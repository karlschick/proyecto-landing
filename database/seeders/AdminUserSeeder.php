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
            ['email' => 'maurogomez@studioft5.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('maurofit2000'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );
    }
}
