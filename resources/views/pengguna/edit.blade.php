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
    <select name="role_id" class="form-select" required>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
