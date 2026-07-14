<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bulog.co.id'],
            [
                'name' => 'Admin Indramayu',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@bulog.co.id'],
            [
                'name' => 'Pengguna Indramayu',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
