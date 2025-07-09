@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Dokumen</h1>
    <div class="mb-3">
        <strong>Judul:</strong> {{ $document->title }}
    </div>
    <div class="mb-3">
        <strong>Kategori:</strong> {{ $document->category->name ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Tag:</strong>
        @foreach($document->tags as $tag)
            <span class="badge bg-info">{{ $tag->name }}</span>
        @endforeach
    </div>
    <div class="mb-3">
        <strong>Penulis:</strong> {{ $document->user->name ?? '-' }}
    </div>
    <div class="mb-3">
        <strong>Tanggal Upload:</strong> {{ $document->created_at->format('d-m-Y') }}
    </div>
    <div class="mb-3">
        <strong>File:</strong> <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">Download / Lihat</a>
    </div>
    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection