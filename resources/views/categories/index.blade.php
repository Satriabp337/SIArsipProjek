@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Parent</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @if($category->children)
                    @foreach($category->children as $child)
                        <tr>
                            <td>&mdash; {{ $child->name }}</td>
                            <td>{{ $child->description }}</td>
                            <td>{{ $child->parent ? $child->parent->name : '-' }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $child) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $child) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection