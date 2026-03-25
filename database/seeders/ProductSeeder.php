<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $electronica = ProductCategory::where('name', 'Electrónica')->first();
        $servicios = ProductCategory::where('name', 'Servicios')->first();
        $instalaciones = ProductCategory::where('name', 'Instalaciones')->first();

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
                'featured_image' => 'products/product1.png', // ← public_html/images/products/product1.png
                'order' => 1,
            ],
            [
                'category_id' => $electronica?->id,
                'name' => 'Mouse Inalámbrico Logitech',
                'description' => 'Mouse ergonómico inalámbrico con batería de larga duración.',
                'short_description' => 'Mouse inalámbrico ergonómico',
                'price' => 89000,
                'quantity' => 50,
                'track_quantity' => true,
                'is_featured' => false,
                'is_active' => true,
                'featured_image' => 'products/product2.png',
                'order' => 2,
            ],

            // Servicios
            [
                'category_id' => $servicios?->id,
                'name' => 'Mantenimiento de Computadores',
                'description' => 'Servicio técnico de mantenimiento preventivo y correctivo de equipos de cómputo.',
                'short_description' => 'Mantenimiento técnico de PC y laptops',
                'price' => 120000,
                'compare_price' => 150000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'featured_image' => 'products/product3.png',
                'order' => 3,
            ],
            [
                'category_id' => $servicios?->id,
                'name' => 'Diseño Web Profesional',
                'description' => 'Creación de sitios web modernos, responsivos y optimizados para SEO.',
                'short_description' => 'Diseño de páginas web profesionales',
                'price' => 950000,
                'compare_price' => 1200000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'featured_image' => 'products/product4.png',
                'order' => 4,
            ],
            [
                'category_id' => $servicios?->id,
                'name' => 'Consultoría Tecnológica',
                'description' => 'Asesoría especializada en transformación digital y automatización.',
                'short_description' => 'Consultoría digital y tecnológica',
                'price' => 350000,
                'compare_price' => null,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => false,
                'is_active' => true,
                'featured_image' => 'products/product5.png',
                'order' => 5,
            ],

            // Instalaciones
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Instalación de Cámaras de Seguridad',
                'description' => 'Instalación profesional de sistemas de videovigilancia IP y analógicos.',
                'short_description' => 'Instalación de cámaras de seguridad',
                'price' => 800000,
                'compare_price' => 950000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'featured_image' => 'products/product6.png',
                'order' => 6,
            ],
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Cableado Estructurado de Red',
                'description' => 'Diseño e instalación de cableado de red para oficinas y hogares.',
                'short_description' => 'Cableado estructurado y redes',
                'price' => 550000,
                'compare_price' => 700000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => false,
                'is_active' => true,
                'featured_image' => 'products/product7.png',
                'order' => 7,
            ],
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Configuración de Servidores',
                'description' => 'Implementación, configuración y mantenimiento de servidores locales o en la nube.',
                'short_description' => 'Configuración profesional de servidores',
                'price' => 1200000,
                'compare_price' => 1500000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'featured_image' => 'products/product8.png',
                'order' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
