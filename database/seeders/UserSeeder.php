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
            ['email' => 'minkuimy@gmail.com'],
            [
                'name' => 'Dean',
                'password' => Hash::make('indramayu'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staffbulog@gmail.com'],
            [
                'name' => 'Staff',
                'password' => Hash::make('indramayu'),
                'role' => 'user',
            ]
        );
    }
}
