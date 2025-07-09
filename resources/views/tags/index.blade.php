@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Tag</h1>
    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Tambah Tag</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Jumlah Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->documents_count }}</td>
                    <td>
                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection