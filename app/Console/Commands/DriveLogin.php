<?php

namespace App\Console\Commands;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Console\Command;

class DriveLogin extends Command
{
    protected $signature = 'drive:login';
    protected $description = 'Login Google Drive (sekali) dan simpan token';

    public function handle(): int
    {
        $client = new Client();
        $client->setAuthConfig(base_path(config('ocr.oauth_client')));
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setRedirectUri('http://localhost');

        $this->line('Buka link ini di browser, login dengan akun Gmail arsip:');
        $this->line($client->createAuthUrl());
        $this->line('');
        $this->line('Setelah setuju, browser menuju http://localhost/?code=... (halaman error tidak apa-apa).');
        $kode = $this->ask('Tempel nilai setelah "code=" (sampai sebelum "&scope")');

        $token = $client->fetchAccessTokenWithAuthCode(urldecode(trim($kode)));
        if (isset($token['error'])) {
            $this->error($token['error_description'] ?? $token['error']);
            return self::FAILURE;
        }

        file_put_contents(base_path(config('ocr.oauth_token')), json_encode($token));
        $this->info('Token tersimpan. Drive siap dipakai.');

        return self::SUCCESS;
    }
}