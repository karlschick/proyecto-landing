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
                'name'              => 'Administrador',
                'password'          => Hash::make('9906Kael'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Editor
        User::updateOrCreate(
            ['email' => 'editor@tudominio.com'],
            [
                'name'              => 'Editor',
                'password'          => Hash::make('editor2026'),
                'role'              => 'editor',
                'email_verified_at' => now(),
            ]
        );

        // Investigador
        User::updateOrCreate(
            ['email' => 'researcher@tudominio.com'],
            [
                'name'              => 'Investigador',
                'password'          => Hash::make('researcher2026'),
                'role'              => 'researcher',
                'email_verified_at' => now(),
            ]
        );

        // Columnista
        User::updateOrCreate(
            ['email' => 'columnist@tudominio.com'],
            [
                'name'              => 'Columnista',
                'password'          => Hash::make('columnist2026'),
                'role'              => 'columnist',
                'email_verified_at' => now(),
            ]
        );

        // Vendedor
        User::updateOrCreate(
            ['email' => 'seller@tudominio.com'],
            [
                'name'              => 'Vendedor',
                'password'          => Hash::make('seller2026'),
                'role'              => 'seller',
                'email_verified_at' => now(),
            ]
        );

        // Cliente / Comprador
        User::updateOrCreate(
            ['email' => 'customer@tudominio.com'],
            [
                'name'              => 'Cliente',
                'password'          => Hash::make('customer2026'),
                'role'              => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Usuario registrado
        User::updateOrCreate(
            ['email' => 'user@tudominio.com'],
            [
                'name'              => 'Usuario',
                'password'          => Hash::make('user2026'),
                'role'              => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
