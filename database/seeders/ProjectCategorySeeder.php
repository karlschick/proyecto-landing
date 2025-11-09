<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar proyectos primero para evitar FK
        Project::query()->delete();
        ProjectCategory::query()->delete();

        $categories = [
            ['name' => 'Desarrollo Web', 'description' => 'Proyectos de desarrollo web', 'is_active' => true, 'order' => 1],
            ['name' => 'Aplicaciones Móviles', 'description' => 'Apps móviles iOS y Android', 'is_active' => true, 'order' => 2],
            ['name' => 'Diseño UX/UI', 'description' => 'Proyectos de diseño de interfaces', 'is_active' => true, 'order' => 3],
            ['name' => 'E-commerce', 'description' => 'Tiendas online y plataformas de venta', 'is_active' => true, 'order' => 4],
        ];

        foreach ($categories as $category) {
            ProjectCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
                'order' => $category['order'],
            ]);
        }
    }
}
