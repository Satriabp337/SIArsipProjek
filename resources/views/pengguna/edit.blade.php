@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Edit Pengguna</h4>

    <form method="POST" action="{{ route('pengguna.update', $user->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Peran</label>
            <select name="role" class="form-select" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="operator" {{ $user->role === 'operator' ? 'selected' : '' }}>Operator</option>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
