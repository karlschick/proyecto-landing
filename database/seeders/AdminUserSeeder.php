<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'skuboxit@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('9906Kael'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Editor (si lo necesitas)
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('user2026'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );
    }
}
