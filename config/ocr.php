<?php

return [
    'pdftoppm_path' => env('PDFTOPPM_PATH', 'pdftoppm'),
    'tesseract_path' => 'C:/Program Files/Tesseract-OCR/tesseract.exe',
    'tessdata_dir'   => env('TESSDATA_DIR'),
    'lang'           => env('OCR_LANG', 'ind'),
    'dpi'            => env('OCR_DPI', 200),

    'drive_folder_id'   => env('GOOGLE_DRIVE_FOLDER_ID'),
    'drive_credentials' => env('GOOGLE_APPLICATION_CREDENTIALS', 'storage/app/google/arsip-bulog.json'),
];