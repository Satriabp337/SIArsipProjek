<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            CategoriesSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}


