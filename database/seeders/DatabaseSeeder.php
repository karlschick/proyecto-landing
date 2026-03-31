<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            ServiceSeeder::class,
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
            TestimonialSeeder::class,
            GallerySeeder::class,
            StatSeeder::class,

            // E-commerce seeders
            ProductCategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
