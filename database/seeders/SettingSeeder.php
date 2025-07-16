<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::create([
            'system_name' => 'SI Arsip Digital',
            'description' => 'Sistem Pengelolaan Arsip Kedinasan Terintegrasi',
        ]);
    }
}
