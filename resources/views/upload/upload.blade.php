@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="mb-1">Upload Dokumen</h4>
        <div class="text-muted">Unggah dokumen baru ke dalam sistem arsip</div>
    </div>

    <!-- Upload Form Start -->
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Pilih File -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="fw-semibold mb-2">Pilih File</div>
                <input type="file" name="file" class="form-control" required>
                <div class="small text-muted mt-2">
                    Mendukung PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, JPEG, PNG (Max 50MB)
                </div>
            </div>
        </div>

        <!-- Informasi Dokumen -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="fw-semibold mb-3">Informasi Dokumen</div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul dokumen" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="nomor_surat" class="form-control" placeholder="Masukkan nomor surat">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sub Kategori</label>
                        <input type="text" name="sub_category" class="form-control" placeholder="Masukkan sub kategori">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Tags (pisahkan dengan koma)</label>
                        <input type="text" name="tags" class="form-control" placeholder="contoh: laporan, keuangan, triwulan">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Masukkan deskripsi dokumen"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Upload Dokumen</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection