<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'María González',
                'client_position' => 'CEO',
                'client_company' => 'Tech Solutions',
                'testimonial' => 'Excelente trabajo, superaron nuestras expectativas. El equipo fue profesional y entregó el proyecto a tiempo. Definitivamente los recomendaría.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'Carlos Rodríguez',
                'client_position' => 'Director de Marketing',
                'client_company' => 'Fashion Store',
                'testimonial' => 'La tienda online que desarrollaron para nosotros ha incrementado nuestras ventas en un 300%. Altamente recomendados.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'Ana Martínez',
                'client_position' => 'Gerente General',
                'client_company' => 'ABC Corporation',
                'testimonial' => 'Profesionales, creativos y muy responsables. Nuestro nuevo portal web es exactamente lo que necesitábamos.',
                'rating' => 5,
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'client_name' => 'Roberto Silva',
                'client_position' => 'Product Manager',
                'client_company' => 'FoodNow Inc.',
                'testimonial' => 'La app que desarrollaron funciona perfectamente. Los usuarios están muy satisfechos y hemos recibido excelentes comentarios.',
                'rating' => 4,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'client_name' => 'Laura Pérez',
                'client_position' => 'Directora de Innovación',
                'client_company' => 'Banco Digital',
                'testimonial' => 'El rediseño de nuestra app ha mejorado significativamente la experiencia de nuestros usuarios. Trabajo impecable.',
                'rating' => 5,
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
