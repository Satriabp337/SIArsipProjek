@extends('layouts.auth')

@section('content')
    <div class="container py-5">
        <h3>Verifikasi Email</h3>
        <p>Silakan verifikasi email Anda dengan mengklik tautan di email yang telah kami kirimkan.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
        </form>
    </div>
@endsection
