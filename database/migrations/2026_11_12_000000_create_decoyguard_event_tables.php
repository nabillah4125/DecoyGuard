<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitored_hosts', function (Blueprint $table) {
            $table->id();
            $table->string('host_identifier', 100)->unique();
            $table->string('host_name', 150);
            $table->string('os_type', 50);
            $table->string('os_version', 100);
            $table->string('agent_version')->nullable();
            $table->string('agent_token_hash', 64)->unique();
            $table->string('status')->default('offline');
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });

        Schema::create('decoy_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('monitored_hosts')->cascadeOnDelete();
            $table->string('folder_name');
            $table->text('folder_path');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('decoy_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('decoy_folders')->cascadeOnDelete();
            $table->string('file_name');
            $table->text('relative_path');
            $table->string('decoy_type');
            $table->string('sha256', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('detection_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_uuid')->unique();
            $table->foreignId('host_id')->constrained('monitored_hosts')->cascadeOnDelete();
            $table->foreignId('folder_id')->constrained('decoy_folders')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('decoy_assets')->cascadeOnDelete();
            $table->string('event_type');
            $table->string('actor_username', 150)->nullable();
            $table->string('process_name')->nullable();
            $table->string('source_ip', 45)->nullable();
            $table->string('severity');
            $table->timestamp('occurred_at')->index();
            $table->json('raw_event')->nullable();
            $table->timestamp('received_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detection_events');
        Schema::dropIfExists('decoy_assets');
        Schema::dropIfExists('decoy_folders');
        Schema::dropIfExists('monitored_hosts');
    }
};
