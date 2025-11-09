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
            ['email' => 'admin@landing.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Editor (si lo necesitas)
        User::updateOrCreate(
            ['email' => 'editor@landing.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );
    }
}
