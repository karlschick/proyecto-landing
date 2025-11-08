<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronica = ProductCategory::where('name', 'Electrónica')->first();
        $ropa = ProductCategory::where('name', 'Ropa y Accesorios')->first();
        $hogar = ProductCategory::where('name', 'Hogar y Jardín')->first();

        $products = [
            // Electrónica
            [
                'category_id' => $electronica?->id,
                'name' => 'Laptop HP 15"',
                'description' => 'Laptop HP con procesador Intel Core i5, 8GB RAM, 256GB SSD. Ideal para trabajo y estudio.',
                'short_description' => 'Laptop potente para trabajo y estudio',
                'price' => 1299000,
                'compare_price' => 1499000,
                'quantity' => 10,
                'track_quantity' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category_id' => $electronica?->id,
                'name' => 'Mouse Inalámbrico Logitech',
                'description' => 'Mouse inalámbrico ergonómico con sensor óptico de alta precisión. Batería de larga duración.',
                'short_description' => 'Mouse inalámbrico ergonómico',
                'price' => 89000,
                'quantity' => 50,
                'track_quantity' => true,
                'is_featured' => false,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category_id' => $electronica?->id,
                'name' => 'Teclado Mecánico RGB',
                'description' => 'Teclado mecánico con retroiluminación RGB, switches azules, ideal para gaming y programación.',
                'short_description' => 'Teclado mecánico gaming',
                'price' => 249000,
                'compare_price' => 299000,
                'quantity' => 25,
                'track_quantity' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],

            // Ropa
            [
                'category_id' => $ropa?->id,
                'name' => 'Camiseta Básica Cotton',
                'description' => 'Camiseta de algodón 100%, disponible en varios colores. Cómoda y versátil.',
                'short_description' => 'Camiseta de algodón básica',
                'price' => 45000,
                'quantity' => 100,
                'track_quantity' => true,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'category_id' => $ropa?->id,
                'name' => 'Jeans Clásicos',
                'description' => 'Jeans de corte clásico, tela denim de alta calidad. Resistentes y cómodos.',
                'short_description' => 'Jeans clásicos premium',
                'price' => 129000,
                'compare_price' => 159000,
                'quantity' => 60,
                'track_quantity' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 5,
            ],

            // Hogar
            [
                'category_id' => $hogar?->id,
                'name' => 'Juego de Toallas 6 piezas',
                'description' => 'Set de 6 toallas de alta absorción, 100% algodón. Incluye toallas de baño y mano.',
                'short_description' => 'Set de toallas premium',
                'price' => 89000,
                'quantity' => 40,
                'track_quantity' => true,
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'category_id' => $hogar?->id,
                'name' => 'Lámpara de Escritorio LED',
                'description' => 'Lámpara LED regulable con brazo flexible. Ahorra energía e iluminación ajustable.',
                'short_description' => 'Lámpara LED ajustable',
                'price' => 79000,
                'quantity' => 30,
                'track_quantity' => true,
                'is_featured' => false,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'category_id' => $hogar?->id,
                'name' => 'Cafetera Prensa Francesa',
                'description' => 'Cafetera tipo prensa francesa, capacidad 1 litro. Vidrio borosilicato resistente al calor.',
                'short_description' => 'Cafetera prensa francesa 1L',
                'price' => 65000,
                'quantity' => 35,
                'track_quantity' => true,
                'is_featured' => true,
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
