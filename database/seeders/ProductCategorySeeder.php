<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónica',
                'description' => 'Productos electrónicos y tecnología',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Ropa y Accesorios',
                'description' => 'Moda, ropa y accesorios',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Hogar y Jardín',
                'description' => 'Artículos para el hogar y jardín',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Deportes',
                'description' => 'Artículos deportivos y fitness',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Libros',
                'description' => 'Libros y revistas',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
