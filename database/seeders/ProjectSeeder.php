<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $categories = [
            ['name' => 'Desarrollo Web', 'description' => 'Proyectos de desarrollo web'],
            ['name' => 'Aplicaciones Móviles', 'description' => 'Apps móviles iOS y Android'],
            ['name' => 'Diseño UX/UI', 'description' => 'Proyectos de diseño de interfaces'],
            ['name' => 'E-commerce', 'description' => 'Tiendas online y plataformas de venta'],
        ];

        foreach ($categories as $categoryData) {
            ProjectCategory::create($categoryData);
        }

        // Crear proyectos
        $projects = [
            [
                'category_id' => 1,
                'title' => 'Portal Corporativo ABC',
                'short_description' => 'Desarrollo de portal web corporativo con panel de administración',
                'description' => 'Desarrollamos un portal web corporativo completo con sistema de gestión de contenidos, integración con redes sociales y panel de administración personalizado. El proyecto incluyó diseño responsive y optimización SEO.',
                'client' => 'ABC Corporation',
                'project_date' => '2024-06-15',
                'url' => 'https://ejemplo.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category_id' => 2,
                'title' => 'App de Delivery FoodNow',
                'short_description' => 'Aplicación móvil para pedidos de comida a domicilio',
                'description' => 'Creamos una aplicación móvil completa para iOS y Android que permite a los usuarios ordenar comida de restaurantes locales. Incluye sistema de pagos, tracking en tiempo real y notificaciones push.',
                'client' => 'FoodNow Inc.',
                'project_date' => '2024-08-22',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category_id' => 4,
                'title' => 'Tienda Online Fashion Store',
                'short_description' => 'E-commerce completo para tienda de moda',
                'description' => 'Desarrollamos una tienda online completa con carrito de compras, sistema de pagos integrado, gestión de inventario y panel de administración. Incluye diseño moderno y responsivo.',
                'client' => 'Fashion Store',
                'project_date' => '2024-09-10',
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'category_id' => 3,
                'title' => 'Rediseño UX de Banking App',
                'short_description' => 'Rediseño completo de interfaz para app bancaria',
                'description' => 'Realizamos un rediseño completo de la experiencia de usuario y la interfaz de una aplicación bancaria, mejorando la usabilidad y haciendo los procesos más intuitivos para los usuarios.',
                'client' => 'Banco Digital',
                'project_date' => '2024-07-18',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
