<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('nomor_keterangan')->nullable();
            $table->date('tanggal_dokumen');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
