@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Dokumen</h1>
    <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul Dokumen</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $document->title) }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $document->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tag (pisahkan dengan koma)</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', $document->tags->pluck('name')->implode(', ')) }}">
            @error('tags')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File Dokumen (biarkan kosong jika tidak ingin mengganti)</label>
            <input type="file" name="file" id="file" class="form-control">
            @error('file')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection