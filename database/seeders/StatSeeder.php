<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'label'    => 'Proyectos Completados',
                'value'    => '150+',
                'target'   => 150,
                'suffix'   => '+',
                'duration' => 20,
                'step'     => 5,
                'order'    => 1,
                'is_active'=> true,
            ],
            [
                'label'    => 'Satisfacción del Cliente',
                'value'    => '95%',
                'target'   => 95,
                'suffix'   => '%',
                'duration' => 30,
                'step'     => 5,
                'order'    => 2,
                'is_active'=> true,
            ],
            [
                'label'    => 'Años de Experiencia',
                'value'    => '20+',
                'target'   => 20,
                'suffix'   => '+',
                'duration' => 200,
                'step'     => 1,
                'order'    => 3,
                'is_active'=> true,
            ],
            [
                'label'    => 'Clientes Satisfechos',
                'value'    => '2000+',
                'target'   => 2000,
                'suffix'   => '+',
                'duration' => 10,
                'step'     => 50,
                'order'    => 4,
                'is_active'=> true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(
                ['label' => $stat['label']],
                $stat
            );
        }
    }
}
