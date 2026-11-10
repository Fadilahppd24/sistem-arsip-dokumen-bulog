<?php

namespace App\Jobs;

use App\Models\Dokumen;
use App\Services\GoogleDriveService;
use App\Services\OcrService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ArsipkanDokumenJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 1800;
    public int $tries = 1;

    public function __construct(public int $dokumenId)
    {
    }

    public function handle(OcrService $ocr): void
    {
        $dokumen = Dokumen::find($this->dokumenId);
        if (! $dokumen || ! Storage::disk('public')->exists($dokumen->file_path)) {
            return;
        }

        $path = Storage::disk('public')->path($dokumen->file_path);

        try {
            $teks = $ocr->extractText($path);
            $dokumen->update([
                'isi_ocr'    => $teks,
                'status_ocr' => 'selesai',
                'ocr_error'  => null,
            ]);
        } catch (Throwable $e) {
            Log::warning('OCR lengkap gagal: ' . $e->getMessage());
            $dokumen->update([
                'status_ocr' => 'parsial',
                'ocr_error'  => mb_substr($e->getMessage(), 0, 1000),
            ]);
        }

        if (config('ocr.drive_folder_id')) {
            try {
                $hasil = app(GoogleDriveService::class)->upload(
                    $path,
                    $dokumen->id . '_' . basename($dokumen->file_path)
                );
                $dokumen->update([
                    'drive_file_id' => $hasil['id'],
                    'drive_url'     => $hasil['url'],
                    'drive_error'   => null,
                ]);
            } catch (Throwable $e) {
                Log::warning('Upload Drive gagal: ' . $e->getMessage());
                $dokumen->update(['drive_error' => mb_substr($e->getMessage(), 0, 1000)]);
            }
        }
    }
}