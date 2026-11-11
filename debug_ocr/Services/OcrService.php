<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\Process\Process;

class OcrService
{
    /** OCR seluruh halaman PDF. */
    public function extractText(string $pdfPath): string
    {
        $tmp = storage_path('app/ocr/' . uniqid('full_', true));
        if (! is_dir($tmp) && ! mkdir($tmp, 0775, true) && ! is_dir($tmp)) {
            throw new RuntimeException('Gagal membuat folder sementara OCR.');
        }

        $env = config('ocr.tessdata_dir')
            ? ['TESSDATA_PREFIX' => config('ocr.tessdata_dir')]
            : null;

        try {
            $pp = new Process([
                config('ocr.pdftoppm_path'),
                '-jpeg', '-r', (string) config('ocr.dpi'),
                $pdfPath,
                $tmp . DIRECTORY_SEPARATOR . 'page',
            ]);
            $pp->setTimeout(900);
            $pp->run();

            if (! $pp->isSuccessful()) {
                throw new RuntimeException('pdftoppm gagal: ' . trim($pp->getErrorOutput()));
            }

            $pages = glob($tmp . DIRECTORY_SEPARATOR . 'page-*.jpg') ?: [];
            sort($pages);

            if (empty($pages)) {
                throw new RuntimeException('Tidak ada halaman yang bisa dibaca dari PDF.');
            }

            $text = [];
            foreach ($pages as $i => $image) {
                $ts = new Process([
                    config('ocr.tesseract_path'), $image, 'stdout',
                    '-l', config('ocr.lang'), '--psm', '6',
                ], null, $env);
                $ts->setTimeout(300);
                $ts->run();

                if (! $ts->isSuccessful()) {
                    throw new RuntimeException('Tesseract gagal (hal. ' . ($i + 1) . '): ' . trim($ts->getErrorOutput()));
                }

                $text[] = trim($ts->getOutput());
            }

            return trim(implode("\n\n", $text));
        } finally {
            foreach (glob($tmp . DIRECTORY_SEPARATOR . '*') ?: [] as $f) {
                @unlink($f);
            }
            @rmdir($tmp);
        }
    }
}