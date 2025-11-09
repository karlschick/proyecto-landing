<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar categorías (no rompe si no existen)
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
                'order' => 2,
            ],

            // Servicios
            [
                'category_id' => $servicios?->id,
                'name' => 'Mantenimiento de Computadores',
                'description' => 'Servicio técnico de mantenimiento preventivo y correctivo de equipos de cómputo. Limpieza, optimización y actualización de software.',
                'short_description' => 'Mantenimiento técnico de PC y laptops',
                'price' => 120000,
                'compare_price' => 150000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'category_id' => $servicios?->id,
                'name' => 'Diseño Web Profesional',
                'description' => 'Creación de sitios web modernos, responsivos y optimizados para SEO, adaptados a la identidad de tu marca.',
                'short_description' => 'Diseño de páginas web profesionales',
                'price' => 950000,
                'compare_price' => 1200000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'category_id' => $servicios?->id,
                'name' => 'Consultoría Tecnológica',
                'description' => 'Asesoría especializada en transformación digital, automatización y estrategias tecnológicas para tu negocio.',
                'short_description' => 'Consultoría digital y tecnológica',
                'price' => 350000,
                'compare_price' => null,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],

            // Instalaciones
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Instalación de Cámaras de Seguridad',
                'description' => 'Instalación profesional de sistemas de videovigilancia IP y analógicos. Configuración y soporte técnico.',
                'short_description' => 'Instalación de cámaras de seguridad',
                'price' => 800000,
                'compare_price' => 950000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 6,
            ],
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Cableado Estructurado de Red',
                'description' => 'Diseño e instalación de cableado de red para oficinas y hogares, cumpliendo estándares internacionales.',
                'short_description' => 'Cableado estructurado y redes',
                'price' => 550000,
                'compare_price' => 700000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => false,
                'is_active' => true,
                'order' => 7,
            ],
            [
                'category_id' => $instalaciones?->id,
                'name' => 'Configuración de Servidores',
                'description' => 'Implementación, configuración y mantenimiento de servidores locales o en la nube (Windows/Linux).',
                'short_description' => 'Configuración profesional de servidores',
                'price' => 1200000,
                'compare_price' => 1500000,
                'quantity' => 1,
                'track_quantity' => false,
                'is_featured' => true,
                'is_active' => true,
                'order' => 8
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
