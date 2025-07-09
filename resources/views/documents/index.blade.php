@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Dokumen</h1>
    <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3">Upload Dokumen</a>
    <form method="GET" action="{{ route('documents.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tag</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{ $document->title }}</td>
                    <td>{{ $document->category->name ?? '-' }}</td>
                    <td>
                        @foreach($document->tags as $tag)
                            <span class="badge bg-info">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $document->user->name ?? '-' }}</td>
                    <td>{{ $document->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                        <a href="{{ route('documents.show', $document) }}" class="btn btn-info btn-sm">Lihat</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection