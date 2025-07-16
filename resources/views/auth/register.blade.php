@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control">
    </div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input
        type="password"
        class="form-control"
        id="password"
        name="password"
        required
        placeholder="Minimal 8 karakter">
</div>


<div class="mb-3">
    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
    <input
        type="password"
        class="form-control"
        id="password_confirmation"
        name="password_confirmation"
        required
        placeholder="Minimal 8 karakter">
</div>


    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Daftar</button>
    </div>

    <div class="text-center">
        <a href="{{ route('login') }}">Sudah punya akun? Masuk</a>
    </div>
</form>
@endsection
