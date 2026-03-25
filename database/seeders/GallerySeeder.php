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
                'image' => 'gallery/default-1.jpg', // ✅
                'category' => 'Desarrollo Web',
                'type' => 'image',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Proyecto Web 2',
                'description' => 'Vista responsive del portal',
                'image' => 'gallery/default-2.jpg', // ✅
                'category' => 'Desarrollo Web',
                'type' => 'image',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'App Móvil 1',
                'description' => 'Interfaz principal de la app',
                'image' => 'gallery/default-3.jpg', // ✅
                'category' => 'Apps Móviles',
                'type' => 'image',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'App Móvil 2',
                'description' => 'Pantalla de checkout',
                'image' => 'gallery/default-4.jpg', // ✅
                'category' => 'Apps Móviles',
                'type' => 'image',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Diseño UX 1',
                'description' => 'Wireframes del proyecto',
                'image' => 'gallery/default-5.jpg', // ✅
                'category' => 'Diseño',
                'type' => 'image',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Diseño UX 2',
                'description' => 'Prototipos de alta fidelidad',
                'image' => 'gallery/default-6.jpg', // ✅
                'category' => 'Diseño',
                'type' => 'image',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($images as $imageData) {
            GalleryImage::create($imageData);
        }

        $this->command->info('✓ ' . count($images) . ' imágenes de galería creadas correctamente');
    }
}
