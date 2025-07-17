<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('pengguna.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('pengguna.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user,operator',
        ]);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        \App\Models\audit::create([
            'user_id' => auth()->id(), // ID pengguna yang melakukan edit
            'user_name' => auth()->user()->name, // Username pengguna
            'user_email' => auth()->user()->email, // Email pengguna
            'action' => 'Profile Edit', // Tindakan yang dilakukan
            'details' => 'Edit user dengan ID: ' . $user->id . ' dengan nama: ' . $user->name, // Detail tindakan
            ]);

        return redirect()->route('pengguna.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('pengguna.index')->with('success', 'User berhasil dihapus.');
    }
}
