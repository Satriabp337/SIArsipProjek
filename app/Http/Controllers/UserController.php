<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogsAudit;
use App\Models\Role;



class UserController extends Controller
{
    use LogsAudit;
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('pengguna.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pengguna.edit', compact('user', 'roles'));
    }

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->update([
        'name' => $request->name,
        'role_id' => $request->role_id,
    ]);
    $user->refresh();

    $this->logAudit('edit user profile', '-', "Mengubah role " . $user->name . " menjadi " . $user->role->name ?? 'user');

    // Tambahkan route tujuan setelah update
    return redirect()->route('pengguna.index')
                   ->with('success', 'Profil berhasil diubah.');
}

    public function destroy(User $user, Request $request)
    {
        $user->delete();

        $user->update($request->only(['name', 'role']));

        $this->logAudit('delete user profile', '-', "Menghapus akun " . $user->name . " .");
        return redirect()->route('pengguna.index')->with('success', 'User berhasil dihapus.');
    }
}
