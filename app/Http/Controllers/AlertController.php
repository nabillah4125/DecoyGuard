<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('alerts')
            ->join('detection_events', 'alerts.event_id', '=', 'detection_events.id')
            ->leftJoin('monitored_hosts', 'detection_events.host_id', '=', 'monitored_hosts.id')
            ->leftJoin('decoy_assets', 'detection_events.asset_id', '=', 'decoy_assets.id')
            ->select(
                'alerts.id',
                'alerts.event_id',
                'alerts.title',
                'alerts.message',
                'alerts.severity',
                'alerts.status',
                'alerts.created_at',
                'detection_events.event_type',
                'detection_events.actor_username',
                'detection_events.occurred_at',
                'monitored_hosts.host_name',
                'decoy_assets.file_name'
            );

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('alerts.title', 'like', "%{$search}%")
                    ->orWhere('alerts.message', 'like', "%{$search}%")
                    ->orWhere('monitored_hosts.host_name', 'like', "%{$search}%")
                    ->orWhere('decoy_assets.file_name', 'like', "%{$search}%")
                    ->orWhere('detection_events.actor_username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('severity')) {
            $query->where('alerts.severity', $request->severity);
        }

        if ($request->filled('status')) {
            $query->where('alerts.status', $request->status);
        }

        $alerts = $query
            ->orderByDesc('alerts.created_at')
            ->paginate(15)
            ->withQueryString();

        return view('alerts.index', compact('alerts'));
    }

    public function show($id)
    {
        $alert = DB::table('alerts')
            ->join('detection_events', 'alerts.event_id', '=', 'detection_events.id')
            ->leftJoin('monitored_hosts', 'detection_events.host_id', '=', 'monitored_hosts.id')
            ->leftJoin('decoy_folders', 'detection_events.folder_id', '=', 'decoy_folders.id')
            ->leftJoin('decoy_assets', 'detection_events.asset_id', '=', 'decoy_assets.id')
            ->select(
                'alerts.*',
                'detection_events.event_uuid',
                'detection_events.event_type',
                'detection_events.actor_username',
                'detection_events.process_name',
                'detection_events.source_ip',
                'detection_events.occurred_at',
                'detection_events.raw_event',
                'monitored_hosts.host_name',
                'decoy_folders.folder_name',
                'decoy_assets.file_name'
            )
            ->where('alerts.id', $id)
            ->first();

        abort_if(!$alert, 404);

        return view('alerts.show', compact('alert'));
    }

public function acknowledge($id)
{
    $alert = DB::table('alerts')->where('id', $id)->first();

    abort_if(!$alert, 404);

    if ($alert->status !== 'NEW') {
        return redirect()->route('alerts.show', $id)
            ->with('error', 'Only new alerts can be acknowledged.');
    }

    DB::table('alerts')->where('id', $id)->update([
        'status' => 'ACKNOWLEDGED',
        'acknowledged_by' => auth()->id(),
        'acknowledged_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('alerts.show', $id)
        ->with('success', 'Alert successfully acknowledged.');
}

public function resolve($id)
{
    $alert = DB::table('alerts')->where('id', $id)->first();

    abort_if(!$alert, 404);

    if ($alert->status === 'RESOLVED') {
        return redirect()->route('alerts.show', $id)
            ->with('error', 'This alert has already been resolved.');
    }

    DB::table('alerts')->where('id', $id)->update([
        'status' => 'RESOLVED',
        'resolved_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('alerts.show', $id)
        ->with('success', 'Alert successfully resolved.');
}

}
