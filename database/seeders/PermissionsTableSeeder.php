<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// database/seeders/PermissionsTableSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'view', 'label' => 'Melihat'],
            ['name' => 'edit', 'label' => 'Mengedit'],
            ['name' => 'upload', 'label' => 'Mengunggah'],
            ['name' => 'delete', 'label' => 'Menghapus'],
            ['name' => 'share', 'label' => 'Membagikan'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}

