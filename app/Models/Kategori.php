<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'icon',
        'warna',
    ];

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}
