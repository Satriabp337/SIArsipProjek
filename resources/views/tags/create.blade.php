@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Tag Baru</h1>
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Tag</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('tags.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection