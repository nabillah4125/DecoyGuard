<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetectionEvent extends Model
{
    protected $table = 'detection_events';

    public const CREATED_AT = 'received_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'event_uuid',
        'host_id',
        'folder_id',
        'asset_id',
        'event_type',
        'actor_username',
        'process_name',
        'source_ip',
        'severity',
        'occurred_at',
        'raw_event',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(MonitoredHost::class, 'host_id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(DecoyFolder::class, 'folder_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(DecoyAsset::class, 'asset_id');
    }
}
