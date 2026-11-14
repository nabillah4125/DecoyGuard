<?php

namespace Tests\Feature\Api;

use App\Models\DecoyAsset;
use App\Models\DecoyFolder;
use App\Models\MonitoredHost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DetectionEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_agent_can_submit_an_event(): void
    {
        $token = 'test-agent-token';
        $host = MonitoredHost::create([
            'host_identifier' => 'test-host',
            'host_name' => 'Test Host',
            'os_type' => 'Windows',
            'os_version' => '11',
            'agent_token_hash' => hash('sha256', $token),
        ]);
        $folder = DecoyFolder::create([
            'host_id' => $host->id,
            'folder_name' => 'Finance',
            'folder_path' => 'C:\\Decoy\\Finance',
            'status' => 'active',
        ]);
        $asset = DecoyAsset::create([
            'folder_id' => $folder->id,
            'file_name' => 'Payroll.txt',
            'relative_path' => 'Payroll.txt',
            'decoy_type' => 'file',
            'is_active' => true,
        ]);
        $eventUuid = (string) Str::uuid();

        $response = $this->withToken($token)->postJson('/api/events', [
            'event_uuid' => $eventUuid,
            'event_type' => 'READ',
            'folder_id' => $folder->id,
            'asset_id' => $asset->id,
            'actor_username' => 'test-user',
            'process_name' => 'notepad.exe',
            'occurred_at' => '2026-11-12T12:00:00+00:00',
            'raw_event' => 'test event',
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'duplicate' => false,
            ]);

        $this->assertDatabaseHas('detection_events', [
            'event_uuid' => $eventUuid,
            'host_id' => $host->id,
            'folder_id' => $folder->id,
            'asset_id' => $asset->id,
            'event_type' => 'READ',
            'raw_event' => json_encode(['message' => 'test event']),
        ]);
    }
}
