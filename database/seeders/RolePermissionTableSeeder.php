<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// database/seeders/RolePermissionTableSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = Permission::all();

        // admin => semua permission
        $admin = Role::where('name', 'admin')->first();
        $admin->permissions()->sync($permissions->pluck('id')->toArray());

        // operator => view, edit, upload
        $operator = Role::where('name', 'operator')->first();
        $operatorPermissions = $permissions->whereIn('name', ['view', 'edit', 'upload']);
        $operator->permissions()->sync($operatorPermissions->pluck('id')->toArray());

        // user => view only
        $user = Role::where('name', 'user')->first();
        $userPermissions = $permissions->where('name', 'view');
        $user->permissions()->sync($userPermissions->pluck('id')->toArray());
    }
}

