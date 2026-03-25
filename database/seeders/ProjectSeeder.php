<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProjectCategory::all()->keyBy('name');

        $projects = [
            [
                'category' => 'Desarrollo Web',
                'title' => 'Portal Corporativo ABC',
                'short_description' => 'Desarrollo de portal web corporativo con panel de administración',
                'description' => 'Desarrollamos un portal web corporativo completo con sistema de gestión de contenidos, integración con redes sociales y panel de administración personalizado.',
                'client' => 'ABC Corporation',
                'project_date' => '2024-06-15',
                'url' => 'https://ejemplo.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
                'image' => 'projects/default-project-1.png',
            ],
            [
                'category' => 'Aplicaciones Móviles',
                'title' => 'App de Delivery FoodNow',
                'short_description' => 'Aplicación móvil para pedidos de comida a domicilio',
                'description' => 'Creamos una aplicación móvil completa para iOS y Android que permite a los usuarios ordenar comida de restaurantes locales.',
                'client' => 'FoodNow Inc.',
                'project_date' => '2024-08-22',
                'url' => null,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
                'image' => 'projects/default-project-2.png',
            ],
            [
                'category' => 'E-commerce',
                'title' => 'Tienda Online Fashion Store',
                'short_description' => 'E-commerce completo para tienda de moda',
                'description' => 'Desarrollamos una tienda online completa con carrito de compras, sistema de pagos integrado, gestión de inventario y panel de administración.',
                'client' => 'Fashion Store',
                'project_date' => '2024-09-10',
                'url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
                'image' => 'projects/default-project-3.png',
            ],
            [
                'category' => 'Diseño UX/UI',
                'title' => 'Rediseño UX de Banking App',
                'short_description' => 'Rediseño completo de interfaz para app bancaria',
                'description' => 'Realizamos un rediseño completo de la experiencia de usuario y la interfaz de una aplicación bancaria.',
                'client' => 'Banco Digital',
                'project_date' => '2024-07-18',
                'url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
                'image' => 'projects/default-project-4.png',
            ],
        ];

        foreach ($projects as $projectData) {
            $category = $categories[$projectData['category']] ?? null;
            if ($category) {
                Project::create([
                    'category_id'       => $category->id,
                    'title'             => $projectData['title'],
                    'slug'              => Str::slug($projectData['title']),
                    'short_description' => $projectData['short_description'],
                    'description'       => $projectData['description'],
                    'client'            => $projectData['client'],
                    'project_date'      => $projectData['project_date'],
                    'url'               => $projectData['url'],
                    'is_featured'       => $projectData['is_featured'],
                    'is_active'         => $projectData['is_active'],
                    'order'             => $projectData['order'],
                    'featured_image'    => $projectData['image'],
                ]);
            }
        }
    }
}
