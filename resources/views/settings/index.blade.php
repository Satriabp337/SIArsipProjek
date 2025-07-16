@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Pengaturan Umum</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="system_name" class="form-label">Nama Sistem</label>
            <input type="text" class="form-control" id="system_name" name="system_name" value="{{ old('system_name', $setting->system_name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $setting->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo (Opsional)</label><br>
            @if($setting->logo_path)
                <img src="{{ asset('storage/' . $setting->logo_path) }}" height="80" class="mb-2">
            @endif
            <input class="form-control" type="file" id="logo" name="logo">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
