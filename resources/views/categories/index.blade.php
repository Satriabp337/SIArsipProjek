@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kategori Dokumen</h2>
</div>

<div class="row g-4">
    @foreach ($categories as $category)
    <div class="col-md-4">
        <a href="{{ route('kategori.show', $category->id) }}" class="text-decoration-none text-dark">
            <div class="card folder-item p-3 rounded d-flex align-items-center">
                <i class="bi bi-folder fs-1 text-primary me-3"></i>
                <div>
                    <h5 class="mb-0">{{ $category->name }}</h5>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection
