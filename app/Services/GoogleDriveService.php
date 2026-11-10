<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    protected Drive $drive;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(base_path(config('ocr.drive_credentials')));
        $client->addScope(Drive::DRIVE);

        $this->drive = new Drive($client);
    }

    /** @return array{id:string, url:?string} */
    public function upload(string $localPath, string $name): array
    {
        $meta = new DriveFile([
            'name'    => $name,
            'parents' => [config('ocr.drive_folder_id')],
        ]);

        $file = $this->drive->files->create($meta, [
            'data'              => file_get_contents($localPath),
            'mimeType'          => 'application/pdf',
            'uploadType'        => 'multipart',
            'fields'            => 'id,webViewLink',
            'supportsAllDrives' => true,
        ]);

        return ['id' => $file->id, 'url' => $file->webViewLink];
    }
}