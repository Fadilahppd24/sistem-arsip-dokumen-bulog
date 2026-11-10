<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            $table->longText('isi_ocr')->nullable();
            $table->string('status_ocr')->nullable();
            $table->text('ocr_error')->nullable();
            $table->string('drive_file_id')->nullable();
            $table->string('drive_url', 500)->nullable();
            $table->text('drive_error')->nullable();
            $table->string('file_hash', 64)->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            $table->dropColumn([
                'isi_ocr', 'status_ocr', 'ocr_error',
                'drive_file_id', 'drive_url', 'drive_error', 'file_hash',
            ]);
        });
    }
};