<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat daftar permission
        $permissions = [
            'create document',
            'view document',
            'edit document',
            'delete document',
            'download document',
            'manage users',
            'view report'
        ];

        // Insert semua permission
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Buat role admin & user
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Berikan semua permission ke admin
        $adminRole->syncPermissions($permissions);

        // Berikan sebagian permission ke user
        $userRole->syncPermissions([
            'create document',
            'view document',
            'download document'
        ]);

        // Assign role ke user ID 1 dan 2 (ubah sesuai kebutuhan)
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole('admin');
        }

        $user = User::find(2);
        if ($user) {
            $user->assignRole('user');
        }

        $this->command->info('Seeder selesai: Role dan permission telah dibuat.');
    }
}
