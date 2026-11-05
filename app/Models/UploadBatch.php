<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadBatch extends Model
{
    protected $fillable = [
        'user_id',
        'total_files',
        'processed_files',
        'success_files',
        'duplicate_files',
        'failed_files',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(UploadBatchItem::class);
    }

    public function getProgressPercentAttribute(): int
    {
        if ($this->total_files === 0) {
            return 0;
        }

        return (int) round(
            ($this->processed_files / $this->total_files) * 100
        );
    }
}
