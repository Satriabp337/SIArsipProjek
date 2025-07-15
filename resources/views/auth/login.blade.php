@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input id="password" type="password" name="password" required class="form-control">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Masuk</button>
    </div>

    <div class="text-center">
        <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
    </div>
</form>
@endsection
