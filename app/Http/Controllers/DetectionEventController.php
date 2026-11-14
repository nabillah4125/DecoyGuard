<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetectionEventController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('detection_events')
            ->leftJoin(
                'monitored_hosts',
                'detection_events.host_id',
                '=',
                'monitored_hosts.id'
            )
            ->leftJoin(
                'decoy_folders',
                'detection_events.folder_id',
                '=',
                'decoy_folders.id'
            )
            ->leftJoin(
                'decoy_assets',
                'detection_events.asset_id',
                '=',
                'decoy_assets.id'
            )
            ->select(
                'detection_events.id',
                'detection_events.event_uuid',
                'detection_events.event_type',
                'detection_events.actor_username',
                'detection_events.process_name',
                'detection_events.source_ip',
                'detection_events.severity',
                'detection_events.occurred_at',
                'detection_events.received_at',
                'monitored_hosts.host_name',
                'decoy_folders.folder_name',
                'decoy_assets.file_name'
            );

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('monitored_hosts.host_name', 'like', "%{$search}%")
                    ->orWhere('decoy_folders.folder_name', 'like', "%{$search}%")
                    ->orWhere('decoy_assets.file_name', 'like', "%{$search}%")
                    ->orWhere('detection_events.actor_username', 'like', "%{$search}%")
                    ->orWhere('detection_events.process_name', 'like', "%{$search}%");
            });
        }

        // Filter event type
        if ($request->filled('event_type')) {
            $query->where(
                'detection_events.event_type',
                $request->event_type
            );
        }

        // Filter severity
        if ($request->filled('severity')) {
            $query->where(
                'detection_events.severity',
                $request->severity
            );
        }

        // Filter tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate(
                'detection_events.occurred_at',
                '>=',
                $request->date_from
            );
        }

        // Filter tanggal akhir
        if ($request->filled('date_to')) {
            $query->whereDate(
                'detection_events.occurred_at',
                '<=',
                $request->date_to
            );
        }

        $events = $query
            ->orderByDesc('detection_events.occurred_at')
            ->paginate(15)
            ->withQueryString();

        return view('detection-events.index', compact('events'));
    }
    public function show($id)
{
    $event = DB::table('detection_events')
        ->leftJoin(
            'monitored_hosts',
            'detection_events.host_id',
            '=',
            'monitored_hosts.id'
        )
        ->leftJoin(
            'decoy_folders',
            'detection_events.folder_id',
            '=',
            'decoy_folders.id'
        )
        ->leftJoin(
            'decoy_assets',
            'detection_events.asset_id',
            '=',
            'decoy_assets.id'
        )
        ->select(
            'detection_events.*',
            'monitored_hosts.host_name',
            'decoy_folders.folder_name',
            'decoy_assets.file_name'
        )
        ->where('detection_events.id', $id)
        ->first();

    abort_if(!$event, 404);

    return view('detection-events.show', compact('event'));
}
}
