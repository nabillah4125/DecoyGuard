<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecoyFolderController extends Controller
{
    public function index()
    {
        $folders = DB::table('decoy_folders')
            ->leftJoin(
                'monitored_hosts',
                'decoy_folders.host_id',
                '=',
                'monitored_hosts.id'
            )
            ->leftJoinSub(
                DB::table('decoy_assets')
                    ->select('folder_id')
                    ->selectRaw('COUNT(*) as total_assets')
                    ->groupBy('folder_id'),
                'asset_counts',
                'decoy_folders.id',
                '=',
                'asset_counts.folder_id'
            )
            ->select(
                'decoy_folders.*',
                'monitored_hosts.host_name',
                DB::raw('COALESCE(asset_counts.total_assets, 0) as total_assets')
            )
            ->orderByDesc('decoy_folders.created_at')
            ->get();

        return view('decoy-folders.index', compact('folders'));
    }

    public function create()
    {
        $hosts = DB::table('monitored_hosts')
            ->orderBy('host_name')
            ->get();

        return view('decoy-folders.create', compact('hosts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'host_id' => 'required|exists:monitored_hosts,id',
            'folder_name' => 'required|string|max:150',
            'folder_path' => 'required|string|max:500',
            'description' => 'nullable|string',
        ]);

        DB::table('decoy_folders')->insert([
            'host_id' => $validated['host_id'],
            'folder_name' => $validated['folder_name'],
            'folder_path' => $validated['folder_path'],
            'description' => $validated['description'] ?? null,
            'status' => 'active',
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('decoy-folders.index')
            ->with('success', 'Decoy folder berhasil ditambahkan.');
    }
}
