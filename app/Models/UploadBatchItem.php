<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadBatchItem extends Model
{
    protected $fillable = [
        'upload_batch_id',
        'original_filename',
        'file_path',
        'status',
        'message',
        'dokumen_id',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(UploadBatch::class, 'upload_batch_id');
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
