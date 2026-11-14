<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DecoyFolder extends Model
{
    protected $table = 'decoy_folders';

    protected $fillable = [
        'host_id',
        'folder_name',
        'folder_path',
        'description',
        'status',
        'created_by',
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(MonitoredHost::class, 'host_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(DecoyAsset::class, 'folder_id');
    }
}
