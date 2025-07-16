@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Dashboard Arsip Digital</h4>

    <!-- Metrics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text fs-2 text-primary me-3"></i>
                        <div>
                            <div class="text-muted small">Total Dokumen</div>
                            <h5 class="mb-0">{{ $totalDocuments }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-folder fs-2 text-success me-3"></i>
                        <div>
                            <div class="text-muted small">Kategori</div>
                            <h5 class="mb-0">{{ $totalCategories }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-building fs-2 text-warning me-3"></i>
                        <div>
                            <div class="text-muted small">Departemen</div>
                            <h5 class="mb-0">{{ $totalDepartments }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people fs-2 text-danger me-3"></i>
                        <div>
                            <div class="text-muted small">Pengguna</div>
                            <h5 class="mb-0">{{ $totalUsers }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Uploads -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Dokumen Terbaru</h5>
            @if($recentDocuments->count())
                <ul class="list-group">
                    @foreach($recentDocuments as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $doc->title }}</strong>
                            <div class="text-muted small">{{ $doc->created_at->format('d M Y') }} oleh {{ $doc->uploaded_by ?? 'Admin' }}</div>
                        </div>
                        <a href="{{ route('documents.file', ['filename' => $doc->filename, 'disposition' => 'inline']) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                    </li>   
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Belum ada dokumen diunggah.</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-4">
            <a href="/upload" class="btn btn-primary w-100 shadow-sm">
                <i class="bi bi-upload me-2"></i> Upload Dokumen
            </a>
        </div>
        <div class="col-md-4">
            <a href="/documents" class="btn btn-outline-secondary w-100 shadow-sm">
                <i class="bi bi-collection me-2"></i> Kelola Dokumen
            </a>
        </div>
        <div class="col-md-4">
            <a href="/laporan" class="btn btn-outline-info w-100 shadow-sm">
                <i class="bi bi-bar-chart-line me-2"></i> Lihat Laporan
            </a>
        </div>
    </div>
</div>
@endsection
