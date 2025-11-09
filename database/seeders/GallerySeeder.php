<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            [
                'title' => 'Proyecto Web 1',
                'description' => 'Captura de pantalla del proyecto web corporativo',
                'image' => 'default-1.jpg',
                'category' => 'Desarrollo Web',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Proyecto Web 2',
                'description' => 'Vista responsive del portal',
                'image' => 'default-2.jpg',
                'category' => 'Desarrollo Web',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'App Móvil 1',
                'description' => 'Interfaz principal de la app',
                'image' => 'default-3.jpg',
                'category' => 'Apps Móviles',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'App Móvil 2',
                'description' => 'Pantalla de checkout',
                'image' => 'default-4.jpg',
                'category' => 'Apps Móviles',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Diseño UX 1',
                'description' => 'Wireframes del proyecto',
                'image' => 'default-5.jpg',
                'category' => 'Diseño',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Diseño UX 2',
                'description' => 'Prototipos de alta fidelidad',
                'image' => 'default-6.jpg',
                'category' => 'Diseño',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        // Insertar las imágenes en la base de datos
        foreach ($images as $imageData) {
            GalleryImage::create($imageData);
        }

        $this->command->info('✓ ' . count($images) . ' imágenes de galería creadas correctamente');
    }
}
