@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 fw-bold text-dark">Dashboard Arsip Digital</h3>
                    <p class="text-muted mb-0">Selamat datang di sistem manajemen arsip kedinasan</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Upload Dokumen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-file-earmark-text fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small fw-medium">Total Dokumen</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ number_format($totalDocuments) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-folder fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small fw-medium">Total Kategori</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ number_format($totalCategories) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-building fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small fw-medium">Total Departemen</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ number_format($totalDepartments) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-people fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small fw-medium">Total Pengguna</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ number_format($totalUsers) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Documents -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Dokumen Terbaru
                        </h5>
                        <a href="/documents" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentDocuments->count())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 fw-medium">Dokumen</th>
                                        <th class="border-0 fw-medium">Tanggal Upload</th>
                                        <th class="border-0 fw-medium">Diupload oleh</th>
                                        <th class="border-0 fw-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDocuments as $doc)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                    <i class="bi bi-file-earmark-text text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $doc->title }}</div>
                                                    <small class="text-muted">{{ $doc->category->name ?? 'Tidak ada kategori' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <small class="text-muted">{{ $doc->created_at->format('d M Y, H:i') }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <small class="text-muted">{{ $doc->uploaded_by ?? 'Admin' }}</small>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('documents.file', ['filename' => $doc->filename, 'disposition' => 'inline']) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-x display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">Belum ada dokumen</h5>
                            <p class="text-muted">Mulai upload dokumen pertama Anda</p>
                            <a href="/upload" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i> Upload Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Statistics -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-lightning me-2 text-primary"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/upload" class="btn btn-primary btn-lg">
                            <i class="bi bi-upload me-2"></i> Upload Dokumen
                        </a>
                        <a href="/documents" class="btn btn-outline-secondary">
                            <i class="bi bi-collection me-2"></i> Kelola Dokumen
                        </a>
                        <a href="/categories" class="btn btn-outline-success">
                            <i class="bi bi-folder me-2"></i> Kelola Kategori
                        </a>
                        <a href="/laporan" class="btn btn-outline-info">
                            <i class="bi bi-bar-chart-line me-2"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Storage Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-hdd me-2 text-primary"></i>
                        Informasi Penyimpanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Ruang Terpakai</span>
                            <span class="small fw-medium">2.3 GB / 10 GB</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 23%"></div>
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="text-primary fw-bold">{{ number_format($totalDocuments) }}</div>
                                <small class="text-muted">Total File</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-success fw-bold">7.7 GB</div>
                            <small class="text-muted">Tersisa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.btn {
    transition: all 0.3s ease;
}

.progress-bar {
    transition: width 0.6s ease;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.gap-2 {
        justify-content: center;
    }
}
</style>
@endsection