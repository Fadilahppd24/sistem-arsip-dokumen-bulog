<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Jenis aktivitas
            // Contoh: Upload Dokumen, Edit Dokumen, Hapus Dokumen
            $table->string('aktivitas');

            // Modul yang diakses
            // Contoh: Dokumen, Pengguna
            $table->string('modul')->nullable();

            // ID data yang diproses
            $table->unsignedBigInteger('referensi_id')->nullable();

            // Keterangan tambahan
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};