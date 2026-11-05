<?php

namespace App\Jobs;

use App\Models\UploadBatchItem;
use App\Services\ProsesOcrDokumenService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProsesOcrDokumenJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 600;
    public int $tries = 1;

    public function __construct(
        public int $uploadBatchItemId
    ) {
    }

    public function handle(ProsesOcrDokumenService $service): void
    {
        // Klaim item secara atomik agar tidak diproses dua kali.
        $claimed = UploadBatchItem::query()
            ->whereKey($this->uploadBatchItemId)
            ->where('status', 'pending')
            ->update(['status' => 'processing']);

        if ($claimed !== 1) {
            return;
        }

        $item = UploadBatchItem::with('batch')
            ->findOrFail($this->uploadBatchItemId);

        $hasil = $service->proses(
            $item->file_path,
            $item->original_filename,
            (int) $item->batch->user_id
        );

        $this->selesaikanItem(
            $hasil['status'],
            $hasil['message'],
            $hasil['dokumen_id'] ?? null
        );
    }

    private function selesaikanItem(
        string $status,
        string $message,
        ?int $dokumenId = null
    ): void {
        DB::transaction(function () use ($status, $message, $dokumenId) {

            // Kunci item sebelum mengubah status dan menghitung progres.
            $item = UploadBatchItem::query()
                ->whereKey($this->uploadBatchItemId)
                ->lockForUpdate()
                ->first();

            if (!$item) {
                return;
            }

            // Item yang sudah selesai tidak boleh dihitung ulang.
            if (in_array($item->status, [
                'berhasil',
                'duplikat',
                'gagal',
            ], true)) {
                return;
            }

            $batch = $item->batch()
                ->lockForUpdate()
                ->first();

            if (!$batch) {
                return;
            }

            if (!in_array($status, [
                'berhasil',
                'duplikat',
                'gagal',
            ], true)) {
                $status = 'gagal';
                $message = 'Status hasil OCR tidak dikenal.';
            }

            $item->update([
                'status' => $status,
                'message' => $message,
                'dokumen_id' => $dokumenId,
            ]);

            $batch->increment('processed_files');

            if ($status === 'berhasil') {
                $batch->increment('success_files');
            } elseif ($status === 'duplikat') {
                $batch->increment('duplicate_files');
            } else {
                $batch->increment('failed_files');
            }

            $batch->refresh();

            $batch->update([
                'status' => $batch->processed_files >= $batch->total_files
                    ? 'completed'
                    : 'processing',
            ]);
        });
    }

    public function failed(?\Throwable $exception): void
    {
        try {
            $this->selesaikanItem(
                'gagal',
                'Terjadi kesalahan saat memproses OCR.'
            );
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui status Queue OCR', [
                'upload_batch_item_id' => $this->uploadBatchItemId,
                'error' => $e->getMessage(),
            ]);
        }

        Log::error('Queue OCR gagal', [
            'upload_batch_item_id' => $this->uploadBatchItemId,
            'error' => $exception?->getMessage(),
        ]);
    }
}
