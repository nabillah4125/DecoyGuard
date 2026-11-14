<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoredHost;
use App\Models\DecoyFolder;
use App\Models\DecoyAsset;
use App\Models\DetectionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class DetectionEventController extends Controller
{
    public function store(Request $request)
    {
        // 1. Ambil token dari Authorization Bearer
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan.',
            ], 401);
        }

        // 2. Cari host berdasarkan hash token
        $tokenHash = hash('sha256', $token);

        $host = MonitoredHost::where(
            'agent_token_hash',
            $tokenHash
        )->first();

        if (!$host) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid.',
            ], 401);
        }

        // 3. Validasi data event
        $validated = $request->validate([
            'event_uuid' => 'nullable|uuid',
            'event_type' => 'required|in:READ',
            'folder_id' => 'required|integer',
            'asset_id' => 'required|integer',
            'actor_username' => 'nullable|string|max:150',
            'process_name' => 'nullable|string|max:255',
            'occurred_at' => 'required|date',
            'raw_event' => 'nullable|string',
        ]);

        // 4. Pastikan folder milik host yang terautentikasi
        $folder = DecoyFolder::where('id', $validated['folder_id'])
            ->where('host_id', $host->id)
            ->where('status', 'active')
            ->first();

        if (!$folder) {
            return response()->json([
                'success' => false,
                'message' => 'Folder decoy tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        // 5. Pastikan file berada dalam folder tersebut
        $asset = DecoyAsset::where('id', $validated['asset_id'])
            ->where('folder_id', $folder->id)
            ->where('is_active', 1)
            ->first();

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'Asset decoy tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        // 6. Simpan event
        $eventUuid = $validated['event_uuid'] ?? (string) Str::uuid();
        $rawEvent = isset($validated['raw_event'])
            ? json_encode(['message' => $validated['raw_event']], JSON_THROW_ON_ERROR)
            : null;

        $event = DetectionEvent::firstOrCreate(
            ['event_uuid' => $eventUuid],
            [
                'host_id' => $host->id,
                'folder_id' => $folder->id,
                'asset_id' => $asset->id,
                'event_type' => 'READ',
                'actor_username' => $validated['actor_username'] ?? null,
                'process_name' => $validated['process_name'] ?? null,
                'source_ip' => null,
                'severity' => 'HIGH',
                'occurred_at' => $validated['occurred_at'],
                'raw_event' => $rawEvent,
            ]
        );


// 7. Perbarui waktu terakhir host aktif
$host->update([
    'status' => 'online',
    'last_seen_at' => now(),
]);

// 8. Buat Alert otomatis untuk event baru
if ($event->wasRecentlyCreated &&
    in_array($event->severity, ['HIGH', 'CRITICAL'])) {

    DB::table('alerts')->insertOrIgnore([
        'event_id' => $event->id,
        'title' => 'Decoy File Access Detected',
        'message' => 'A decoy file was accessed. User: '
            . ($event->actor_username ?? 'Unknown')
            . '. Process: '
            . ($event->process_name ?? 'Unknown')
            . '. Asset: '
            . $asset->file_name,
        'severity' => $event->severity,
        'status' => 'NEW',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}


        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diterima.',
            'duplicate' => !$event->wasRecentlyCreated,
            'event_id' => $event->id,
        ], 201);
    }
}
