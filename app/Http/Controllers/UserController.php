<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogsAudit;

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
        // You can pass the role options directly here if needed
        $roles = ['admin', 'operator', 'user'];
        return view('pengguna.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        $user->refresh();

        $this->logAudit('edit user profile', '-', "Mengubah role {$user->name} menjadi {$user->role}");

        return redirect()->route('pengguna.index')
                         ->with('success', 'Profil berhasil diubah.');
    }

    public function destroy(User $user, Request $request)
    {
        $this->logAudit('delete user profile', '-', "Menghapus akun {$user->name}.");
        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'User berhasil dihapus.');
    }
}
