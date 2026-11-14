<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecoyAssetController extends Controller
{
    public function index($folderId)
    {
        $folder = DB::table('decoy_folders')
            ->where('id', $folderId)
            ->first();

        abort_if(!$folder, 404);

        $assets = DB::table('decoy_assets')
            ->where('folder_id', $folderId)
            ->orderByDesc('created_at')
            ->get();

        return view('decoy-assets.index', compact('folder', 'assets'));
    }

    public function create($folderId)
    {
        $folder = DB::table('decoy_folders')
            ->where('id', $folderId)
            ->first();

        abort_if(!$folder, 404);

        return view('decoy-assets.create', compact('folder'));
    }

    public function store(Request $request, $folderId)
    {
        $folder = DB::table('decoy_folders')
            ->where('id', $folderId)
            ->where('status', 'active')
            ->first();

        abort_if(!$folder, 404);

        $validated = $request->validate([
            'file_name' => 'required|string|max:255',
            'relative_path' => 'required|string|max:500',
            'decoy_type' => 'nullable|string|max:50',
            'sha256' => 'nullable|string|size:64',
        ]);

        DB::table('decoy_assets')->insert([
            'folder_id' => $folderId,
            'file_name' => $validated['file_name'],
            'relative_path' => $validated['relative_path'],
            'decoy_type' => $validated['decoy_type'] ?? null,
            'sha256' => $validated['sha256'] ?? null,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('decoy-assets.index', $folderId)
            ->with('success', 'Decoy asset berhasil ditambahkan.');
    }
}
