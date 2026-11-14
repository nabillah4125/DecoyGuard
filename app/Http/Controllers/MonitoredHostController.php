<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MonitoredHostController extends Controller
{
    public function index()
    {
        $hosts = DB::table('monitored_hosts')
            ->orderByDesc('created_at')
            ->get();

        return view('monitored-hosts.index', compact('hosts'));
    }

    public function create()
    {
        return view('monitored-hosts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'host_identifier' => 'required|string|max:100|unique:monitored_hosts,host_identifier',
            'host_name' => 'required|string|max:150',
            'os_type' => 'required|string|max:50',
            'os_version' => 'required|string|max:100',
        ]);

        // Token hanya ditampilkan saat pendaftaran.
        $agentToken = Str::random(64);

        DB::table('monitored_hosts')->insert([
            'host_identifier' => $validated['host_identifier'],
            'host_name' => $validated['host_name'],
            'os_type' => $validated['os_type'],
            'os_version' => $validated['os_version'],
            'agent_version' => null,
            'agent_token_hash' => hash('sha256', $agentToken),
            'status' => 'offline',
            'last_seen_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('monitored-hosts.index')
            ->with('success', 'Host berhasil didaftarkan.')
            ->with('agent_token', $agentToken);
    }
    public function regenerateToken($id)
{
    $host = DB::table('monitored_hosts')
        ->where('id', $id)
        ->first();

    if (!$host) {
        abort(404, 'Host tidak ditemukan.');
    }

    $agentToken = Str::random(64);

    DB::table('monitored_hosts')
        ->where('id', $id)
        ->update([
            'agent_token_hash' => hash('sha256', $agentToken),
            'status' => 'offline',
            'last_seen_at' => null,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('monitored-hosts.index')
        ->with('success', 'Agent Token berhasil diterbitkan ulang.')
        ->with('agent_token', $agentToken);
}
}
