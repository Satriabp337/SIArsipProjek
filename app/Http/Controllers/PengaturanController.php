<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Audit;
class PengaturanController extends Controller
{
    
    public function pengaturan()
    {
        $latestAudit = Audit::orderBy('date', 'desc')->first();
        return view('pengaturan', compact('latestAudit'));
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $latestAudit = Audit::orderBy('date', 'desc')->first();
        return view('pengaturan', compact('roles', 'permissions', 'latestAudit'));
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
