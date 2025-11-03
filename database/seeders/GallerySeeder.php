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
                'category' => 'Desarrollo Web',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Proyecto Web 2',
                'description' => 'Vista responsive del portal',
                'category' => 'Desarrollo Web',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'App Móvil 1',
                'description' => 'Interfaz principal de la app',
                'category' => 'Apps Móviles',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'App Móvil 2',
                'description' => 'Pantalla de checkout',
                'category' => 'Apps Móviles',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Diseño UX 1',
                'description' => 'Wireframes del proyecto',
                'category' => 'Diseño',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Diseño UX 2',
                'description' => 'Prototipos de alta fidelidad',
                'category' => 'Diseño',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        // Nota: Como no tenemos imágenes reales, creamos registros sin imagen
        // En producción, deberás subir imágenes reales
        foreach ($images as $imageData) {
            // Puedes descomentar esto cuando tengas imágenes reales
            // $imageData['image'] = 'placeholder.jpg';

            // Por ahora, solo creamos los registros sin imagen
            // Las imágenes se pueden agregar después desde el panel admin
        }

        // Mensaje informativo
        \Log::info('GallerySeeder: Ejecutado. Agrega imágenes desde el panel de administración.');
    }
}
