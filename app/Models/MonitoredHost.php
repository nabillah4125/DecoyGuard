<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoredHost extends Model
{
    protected $table = 'monitored_hosts';

    protected $fillable = [
        'host_identifier',
        'host_name',
        'os_type',
        'os_version',
        'agent_version',
        'agent_token_hash',
        'status',
        'last_seen_at',
    ];

    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
        ];
    }

    public function decoyFolders(): HasMany
    {
        return $this->hasMany(DecoyFolder::class, 'host_id');
    }

    public function detectionEvents(): HasMany
    {
        return $this->hasMany(DetectionEvent::class, 'host_id');
    }
}
