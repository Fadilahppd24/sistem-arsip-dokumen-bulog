<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama_dokumen',
        'nomor_keterangan',
        'tanggal_dokumen',
        'deskripsi',
        'file_path',
        'file_size',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_dokumen' => 'date',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * User yang mengunggah dokumen ini (Admin).
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Ukuran file yang mudah dibaca, misal "1.24 MB".
     */
    public function getUkuranFormatAttribute(): string
    {
        $bytes = $this->file_size ?? 0;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' B';
    }

    public function scopeCari($query, ?string $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_dokumen', 'like', "%{$keyword}%")
                ->orWhere('nomor_keterangan', 'like', "%{$keyword}%");
        });
    }
}
