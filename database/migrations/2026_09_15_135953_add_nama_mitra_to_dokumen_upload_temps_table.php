<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dokumen_upload_temps')) {
            return;
        }

        if (Schema::hasColumn('dokumen_upload_temps', 'nama_mitra')) {
            return;
        }

        Schema::table('dokumen_upload_temps', function (Blueprint $table) {
            $table->string('nama_mitra')->nullable()->after('tanggal_dokumen');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('dokumen_upload_temps')
            && Schema::hasColumn('dokumen_upload_temps', 'nama_mitra')) {
            Schema::table('dokumen_upload_temps', function (Blueprint $table) {
                $table->dropColumn('nama_mitra');
            });
        }
    }
};