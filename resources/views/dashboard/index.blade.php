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
                <div class="card-body p-0">
                    @if($recentDocuments->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 fw-semibold py-3">Dokumen</th>
                                        <th class="border-0 fw-semibold py-3">Tanggal Upload</th>
                                        <th class="border-0 fw-semibold py-3">Diupload oleh</th>
                                        <th class="border-0 fw-semibold py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDocuments as $doc)
                                    <tr>
                                        <td class="align-middle py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="document-icon me-3">
                                                    @php
                                                        $extension = strtolower(pathinfo($doc->filename, PATHINFO_EXTENSION));
                                                        $iconClass = match($extension) {
                                                            'pdf' => 'bi-file-earmark-pdf text-danger',
                                                            'doc', 'docx' => 'bi-file-earmark-word text-primary',
                                                            'xls', 'xlsx' => 'bi-file-earmark-excel text-success',
                                                            'ppt', 'pptx' => 'bi-file-earmark-ppt text-warning',
                                                            default => 'bi-file-earmark-text text-secondary'
                                                        };
                                                    @endphp
                                                    <i class="bi {{ $iconClass }} fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark mb-1">{{ $doc->title }}</div>
                                                    <small class="text-muted">{{ $doc->category->name ?? 'Tidak ada kategori' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle py-3">
                                            <div class="badge-date">{{ $doc->created_at->format('d M Y, H:i') }}</div>
                                        </td>
                                        <td class="align-middle py-3">
                                            <span class="text-muted fw-medium">{{ $doc->uploaded_by ?? 'Admin' }}</span>
                                        </td>
                                        <td class="align-middle text-center py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('documents.file', ['filename' => $doc->filename, 'disposition' => 'inline']) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Lihat dokumen">
                                                    <i class="bi bi-eye me-1"></i> Lihat
                                                </a>
                                                <a href="{{ route('documents.file', ['filename' => $doc->filename, 'disposition' => 'attachment']) }}" 
                                                   class="btn btn-sm btn-outline-success"
                                                   title="Download dokumen">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
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
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.05);
    transition: background-color 0.2s ease;
}

.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.btn:hover {
    transform: translateY(-1px);
}

.document-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(13, 110, 253, 0.1);
}

.badge-date {
    background: linear-gradient(135deg, #0dcaf0, #0aa2c0);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    display: inline-block;
}

/* Fix untuk kolom tabel di mobile */
.table th:first-child,
.table td:first-child {
    min-width: 200px;
    width: 40%;
}

.table th:nth-child(2),
.table td:nth-child(2) {
    min-width: 140px;
    width: 25%;
}

.table th:nth-child(3),
.table td:nth-child(3) {
    min-width: 120px;
    width: 20%;
}

.table th:nth-child(4),
.table td:nth-child(4) {
    min-width: 140px;
    width: 15%;
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
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .document-icon {
        width: 32px;
        height: 32px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    /* Perbaikan khusus untuk mobile */
    .table th:first-child,
    .table td:first-child {
        min-width: 180px;
    }
    
    .table th:nth-child(2),
    .table td:nth-child(2) {
        min-width: 120px;
    }
    
    .table th:nth-child(3),
    .table td:nth-child(3) {
        min-width: 100px;
    }
    
    .table th:nth-child(4),
    .table td:nth-child(4) {
        min-width: 120px;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-center.gap-2 {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Perbaikan untuk layar sangat kecil */
    .table th:first-child,
    .table td:first-child {
        min-width: 160px;
    }
    
    .table th:nth-child(2),
    .table td:nth-child(2) {
        min-width: 110px;
    }
    
    .table th:nth-child(3),
    .table td:nth-child(3) {
        min-width: 90px;
    }
    
    .table th:nth-child(4),
    .table td:nth-child(4) {
        min-width: 100px;
    }
}
</style>
@endsection