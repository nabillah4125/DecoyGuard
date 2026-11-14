<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalHosts = DB::table('monitored_hosts')->count();
        $onlineHosts = DB::table('monitored_hosts')
            ->where('status', 'online')
            ->count();

        $totalFolders = DB::table('decoy_folders')
            ->where('status', 'active')
            ->count();

        $totalAssets = DB::table('decoy_assets')
            ->where('is_active', true)
            ->count();

        $totalEvents = DB::table('detection_events')->count();

        $eventsLast24Hours = DB::table('detection_events')
            ->where('occurred_at', '>=', now()->subDay())
            ->count();

        $newAlerts = DB::table('alerts')
            ->where('status', 'NEW')
            ->count();

        $severityCounts = DB::table('detection_events')
            ->select('severity')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('severity')
            ->pluck('total', 'severity');

        $today = now();
        $activityCounts = DB::table('detection_events')
            ->selectRaw('DATE(occurred_at) as event_date, COUNT(*) as total')
            ->where('occurred_at', '>=', $today->copy()->subDays(6)->startOfDay())
            ->groupByRaw('DATE(occurred_at)')
            ->pluck('total', 'event_date');

        $activity = collect(range(6, 0))->map(function ($daysAgo) use ($today, $activityCounts) {
            $date = $today->copy()->subDays($daysAgo);
            $dateKey = $date->toDateString();

            return [
                'label' => $date->format('D'),
                'date' => $date->format('M j'),
                'total' => (int) $activityCounts->get($dateKey, 0),
            ];
        });

        $recentEvents = DB::table('detection_events')
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
                'detection_events.event_type',
                'detection_events.actor_username',
                'detection_events.process_name',
                'detection_events.source_ip',
                'detection_events.severity',
                'detection_events.occurred_at',
                'monitored_hosts.host_name',
                'decoy_folders.folder_name',
                'decoy_assets.file_name'
            )
            ->orderByDesc('detection_events.occurred_at')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalHosts',
            'onlineHosts',
            'totalFolders',
            'totalAssets',
            'totalEvents',
            'eventsLast24Hours',
            'newAlerts',
            'severityCounts',
            'activity',
            'recentEvents'
        ));
    }
}
