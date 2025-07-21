<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class PengaturanController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('pengaturan', compact('roles', 'permissions'));
    }

    public function update(Request $request)
    {
        foreach ($request->permissions as $roleId => $permissionIds) {
            $role = Role::findOrFail($roleId);
            $role->permissions()->sync($permissionIds);
        }

        return redirect()->route('pengaturan.akses')->with('success', 'Hak akses berhasil diperbarui.');
    }
}
