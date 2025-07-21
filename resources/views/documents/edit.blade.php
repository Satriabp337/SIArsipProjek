@extends('layouts.app') {{-- Pastikan layout.app kamu sudah ada --}}

@section('content')
    <div class="container py-4">
        <h2>Edit Dokumen</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('documents.update', $document->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Dokumen</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $document->title) }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Sub Kategori</label>
                    <input type="text" name="sub_category" class="form-control" value="{{ old('sub_category', $document->sub_category) }}">
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $document->department_id == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tingkat Akses</label>
                    <select name="access_level" class="form-select" required>
                        <option value="Public" {{ $document->access_level == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Internal" {{ $document->access_level == 'Internal' ? 'selected' : '' }}>Internal</option>
                        <option value="Confidential" {{ $document->access_level == 'Confidential' ? 'selected' : '' }}>Confidential</option>
                    </select>
                </div>
            </div> -->

            <div class="mb-3">
                <label class="form-label">Tags (pisahkan dengan koma)</label>
                <input type="text" name="tags" class="form-control" value="{{ old('tags', $document->tags) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">File Saat Ini:</label>
                <div>
                    <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'inline']) }}" target="_blank">
                        {{ $document->original_filename }}
                    </a>
                </div>
            </div>

            {{-- Optional: Tambahkan upload file baru jika ingin ganti --}}
            {{-- <div class="mb-3">
                <label class="form-label">Ganti File (Opsional)</label>
                <input type="file" name="file" class="form-control">
            </div> --}}

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
