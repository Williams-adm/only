<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            BrandSeeder::class

            /*
            ProductSeeder::class,
            OptionSeeder::class, */
        ]);
    }
}
