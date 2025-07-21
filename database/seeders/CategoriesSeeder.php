<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Surat Masuk', 'Surat Keluar', 'Surat Keputusan', 'Surat Tugas'];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}
