<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::truncate();

        $services = [
            [
                'title' => 'Desarrollo Web',
                'short_description' => 'Creamos sitios web modernos y responsivos',
                'description' => 'Desarrollamos sitios web profesionales, modernos y completamente responsivos. Utilizamos las últimas tecnologías para garantizar el mejor rendimiento y experiencia de usuario.',
                'icon' => '💻',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Diseño Gráfico',
                'short_description' => 'Diseños creativos que destacan tu marca',
                'description' => 'Creamos diseños únicos y profesionales que reflejan la identidad de tu marca. Desde logos hasta material publicitario completo.',
                'icon' => '🎨',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Marketing Digital',
                'short_description' => 'Estrategias para hacer crecer tu negocio',
                'description' => 'Desarrollamos estrategias de marketing digital efectivas para aumentar tu presencia online y generar más ventas.',
                'icon' => '📱',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Consultoría IT',
                'short_description' => 'Asesoramiento tecnológico experto',
                'description' => 'Brindamos consultoría especializada en tecnología para optimizar tus procesos y tomar las mejores decisiones tecnológicas.',
                'icon' => '🔧',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
