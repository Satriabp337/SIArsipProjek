<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {   
        $defaultRoleId = \App\Models\Role::where('name', 'user')->value('id');

        if (!$defaultRoleId) {
            throw new \Exception('Role "user" tidak ditemukan. Jalankan RoleSeeder terlebih dahulu.');
        }

        $adminRoleId = Role::where('name', 'admin')->value('id');

        if (!$adminRoleId) {
            $adminRoleId = Role::create(['name' => 'admin'])->id;
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('diskop'),
            'role_id' => $adminRoleId,
        ]);
    }
}
