<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecoyAsset extends Model
{
    protected $table = 'decoy_assets';

    protected $fillable = [
        'folder_id',
        'file_name',
        'relative_path',
        'decoy_type',
        'sha256',
        'is_active',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(DecoyFolder::class, 'folder_id');
    }
}
