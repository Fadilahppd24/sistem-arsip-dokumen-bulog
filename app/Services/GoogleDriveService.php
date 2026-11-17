<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use RuntimeException;

class GoogleDriveService
{
    protected Drive $drive;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(base_path(config('ocr.oauth_client')));
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessType('offline');

        $tokenPath = base_path(config('ocr.oauth_token'));
        if (! is_file($tokenPath)) {
            throw new RuntimeException('Token Drive belum dibuat. Jalankan: php artisan drive:login');
        }

        $client->setAccessToken(json_decode(file_get_contents($tokenPath), true));

        if ($client->isAccessTokenExpired()) {
            $refresh = $client->getRefreshToken();
            if (! $refresh) {
                throw new RuntimeException('Refresh token hilang. Jalankan ulang: php artisan drive:login');
            }
            $new = $client->fetchAccessTokenWithRefreshToken($refresh);
            if (isset($new['error'])) {
                throw new RuntimeException('Gagal refresh token Drive: ' . ($new['error_description'] ?? $new['error']));
            }
            $new['refresh_token'] = $new['refresh_token'] ?? $refresh;
            file_put_contents($tokenPath, json_encode($new));
        }

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
            'data'       => file_get_contents($localPath),
            'mimeType'   => 'application/pdf',
            'uploadType' => 'multipart',
            'fields'     => 'id,webViewLink',
        ]);

        return ['id' => $file->id, 'url' => $file->webViewLink];
    }
}