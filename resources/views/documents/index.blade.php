@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Arsip Dokumen</h2>
            <p class="text-muted mb-0">Kelola dan cari dokumen dengan mudah</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Dokumen
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-lg-5 col-md-12">
                    <label class="form-label fw-semibold text-dark">Kata Kunci</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" 
                               placeholder="Cari berdasarkan judul atau deskripsi..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-4 col-md-8">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-4">
                    <label class="form-label fw-semibold text-dark">Aksi</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary flex-fill" type="submit">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Documents Grid -->
    @if (isset($documents) && $documents->count())
        <!-- Results Info -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                <i class="bi bi-file-earmark-text me-2"></i>
                Menampilkan {{ $documents->firstItem() }} - {{ $documents->lastItem() }} dari {{ $documents->total() }} dokumen
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-sort-down me-1"></i>Urutkan
                    @if(request('sort'))
                        <span class="badge bg-primary ms-1">{{ 
                            request('sort') == 'created_at_desc' ? 'Terbaru' : 
                            (request('sort') == 'created_at_asc' ? 'Terlama' : 
                            (request('sort') == 'title_asc' ? 'A-Z' : 
                            (request('sort') == 'title_desc' ? 'Z-A' : ''))) 
                        }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request('sort') == 'created_at_desc' ? 'active' : '' }}" 
                           href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_desc']) }}">
                            <i class="bi bi-clock me-2"></i>Terbaru
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('sort') == 'created_at_asc' ? 'active' : '' }}" 
                           href="{{ request()->fullUrlWithQuery(['sort' => 'created_at_asc']) }}">
                            <i class="bi bi-clock-history me-2"></i>Terlama
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item {{ request('sort') == 'title_asc' ? 'active' : '' }}" 
                           href="{{ request()->fullUrlWithQuery(['sort' => 'title_asc']) }}">
                            <i class="bi bi-sort-alpha-down me-2"></i>A-Z
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('sort') == 'title_desc' ? 'active' : '' }}" 
                           href="{{ request()->fullUrlWithQuery(['sort' => 'title_desc']) }}">
                            <i class="bi bi-sort-alpha-up me-2"></i>Z-A
                        </a>
                    </li>
                    @if(request('sort'))
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-muted" 
                           href="{{ request()->fullUrlWithQuery(['sort' => null]) }}">
                            <i class="bi bi-x me-2"></i>Reset Urutan
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($documents as $document)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card" style="overflow: visible;">
                        <div class="card-body d-flex flex-column" style="overflow: visible;">
                            <!-- Document Header -->
                            <div class="d-flex align-items-start mb-3">
                                @php
                                    $ext = strtolower($document->file_type);
                                    $iconClass = 'bi-file-earmark-text';
                                    $iconColor = 'text-secondary';
                                    $bgColor = 'bg-light';
                                    
                                    if ($ext === 'pdf') {
                                        $iconClass = 'bi-file-pdf-fill';
                                        $iconColor = 'text-white';
                                        $bgColor = 'bg-danger';
                                    } elseif (in_array($ext, ['doc', 'docx'])) {
                                        $iconClass = 'bi-file-word-fill';
                                        $iconColor = 'text-white';
                                        $bgColor = 'bg-primary';
                                    } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                        $iconClass = 'bi-file-excel-fill';
                                        $iconColor = 'text-white';
                                        $bgColor = 'bg-success';
                                    } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                        $iconClass = 'bi-file-powerpoint-fill';
                                        $iconColor = 'text-white';
                                        $bgColor = 'bg-warning';
                                    } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $iconClass = 'bi-file-image-fill';
                                        $iconColor = 'text-white';
                                        $bgColor = 'bg-info';
                                    }
                                @endphp
                                
                                <div class="file-icon {{ $bgColor }} rounded-3 p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi {{ $iconClass }} {{ $iconColor }} fs-3"></i>
                                </div>
                                
                                <div class="flex-grow-1 min-w-0">
                                    <h5 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $document->title }}">
                                        {{ $document->title }}
                                    </h5>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-{{ $document->access_level == 'Confidential' ? 'danger' : ($document->access_level == 'Internal' ? 'warning' : 'success') }} rounded-pill">
                                            <i class="bi bi-{{ $document->access_level == 'Confidential' ? 'lock-fill' : ($document->access_level == 'Internal' ? 'shield-fill' : 'globe') }} me-1"></i>
                                            {{ $document->access_level }}
                                        </span>
                                        <span class="badge bg-light text-dark rounded-pill">
                                            {{ strtoupper($document->file_type) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Description -->
                            <p class="card-text text-muted mb-3 flex-grow-1" style="line-height: 1.5;">
                                {{ Str::limit($document->description, 120) }}
                            </p>

                            <!-- Document Meta Info -->
                            <div class="document-meta mb-3">
                                @if($document->nomor_surat)
                                    <div class="d-flex align-items-center text-muted small mb-2">
                                        <i class="bi bi-hash text-primary me-2"></i>
                                        <span class="fw-medium">{{ $document->nomor_surat }}</span>
                                    </div>
                                @endif
                                
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="bi bi-folder text-warning me-2"></i>
                                    <span>{{ $document->category ? $document->category->name : 'Tidak Berkategori' }}</span>
                                </div>
                                
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="bi bi-calendar-event text-info me-2"></i>
                                    <span>{{ $document->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-hdd text-secondary me-2"></i>
                                    <span>{{ number_format($document->file_size / 1024 / 1024, 2) }} MB</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card-actions mt-auto pt-3 border-top">
                                @php $ext = strtolower($document->file_type); @endphp
                                
                                <!-- Desktop View -->
                                <div class="d-none d-md-flex">
                                    <div class="btn-group w-100" role="group">
                                        @if(in_array($ext, ['xlsx', 'xls']))
                                            <a href="{{ route('documents.preview.excel', ['filename' => $document->filename]) }}"
                                               class="btn btn-outline-primary btn-sm flex-fill" title="Lihat">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </a>
                                        @else
                                            <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'inline']) }}"
                                               target="_blank" class="btn btn-outline-primary btn-sm flex-fill" title="Lihat">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </a>
                                        @endif

                                        <a href="{{ route('documents.download', $document->id) }}"
                                           class="btn btn-outline-success btn-sm flex-fill" title="Unduh">
                                            <i class="bi bi-download me-1"></i>Unduh
                                        </a>
                                        
                                        <div class="btn-group dropup dropdown-container" role="group">
                                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" 
                                                    data-bs-toggle="dropdown" 
                                                    data-bs-auto-close="true"
                                                    data-bs-offset="0,10"
                                                    data-bs-boundary="viewport"
                                                    aria-expanded="false"
                                                    title="Opsi Lainnya"
                                                    onclick="this.closest('.hover-card').style.zIndex='1070';"
                                                    onblur="setTimeout(() => { if(!this.nextElementSibling.classList.contains('show')) this.closest('.hover-card').style.zIndex=''; }, 100);">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                                <li>
                                                    <a class="dropdown-item py-2" href="{{ route('documents.edit', ['document' => $document->id]) }}">
                                                        <i class="bi bi-pencil me-2 text-primary"></i>Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    @if(in_array(Auth::user()->role, ['admin', 'operator']))
                                                    <form method="POST" action="{{ route('documents.destroy', $document->id) }}" class="d-inline w-100" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger py-2 border-0 bg-transparent w-100 text-start">
                                                            <i class="bi bi-trash me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Mobile View - Fixed Alignment -->
                                <div class="d-md-none">
                                    <div class="mobile-actions-grid">
                                        <!-- First Row: View and Download -->
                                        <div class="mobile-action-row">
                                            @if(in_array($ext, ['xlsx', 'xls']))
                                                <a href="{{ route('documents.preview.excel', ['filename' => $document->filename]) }}"
                                                   class="btn btn-outline-primary btn-sm mobile-action-btn">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                            @else
                                                <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'inline']) }}"
                                                   target="_blank" class="btn btn-outline-primary btn-sm mobile-action-btn">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('documents.download', $document->id) }}"
                                               class="btn btn-outline-success btn-sm mobile-action-btn">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                        
                                        <!-- Second Row: Edit and Delete -->
                                        <div class="mobile-action-row">
                                            <a href="{{ route('documents.edit', ['document' => $document->id]) }}"
                                               class="btn btn-outline-secondary btn-sm mobile-action-btn">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            @if(in_array(Auth::user()->role, ['admin', 'operator']))
                                            <form method="POST" action="{{ route('documents.destroy', $document->id) }}" 
                                                  class="mobile-action-form"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm mobile-action-btn">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <div class="text-muted">
                <small>
                    Halaman {{ $documents->currentPage() }} dari {{ $documents->lastPage() }} 
                    ({{ $documents->total() }} total dokumen)
                </small>
            </div>
            <div>
                {{ $documents->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="empty-state">
                <div class="empty-state-icon mb-4">
                    <i class="bi bi-folder-x display-1 text-muted"></i>
                </div>
                <h4 class="text-muted mb-3">Tidak Ada Dokumen</h4>
                <p class="text-muted mb-4">
                    @if(request('search') || request('category_id'))
                        Tidak ditemukan dokumen yang sesuai dengan kriteria pencarian Anda.
                        <br>Coba ubah kata kunci atau filter yang digunakan.
                    @else
                        Belum ada dokumen yang tersedia di sistem.
                        <br>Mulai dengan menambahkan dokumen pertama Anda.
                    @endif
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Semua Dokumen
                        </a>
                    @endif
                    <a href="{{ route('documents.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Dokumen Pertama
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Custom Styles -->
<style>
.hover-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.08) !important;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    border-color: rgba(0,0,0,0.1) !important;
    z-index: 10;
    position: relative;
}

/* Active dropdown card gets highest z-index */
.hover-card:has(.dropdown-menu.show) {
    z-index: 1060 !important;
    position: relative;
}

.hover-card .dropdown-container:has(.dropdown-menu.show) {
    z-index: 1061 !important;
    position: relative;
}

.file-icon {
    transition: all 0.3s ease;
}

.hover-card:hover .file-icon {
    transform: scale(1.1);
}

.card-title {
    font-size: 1.1rem;
    line-height: 1.3;
}

.document-meta {
    font-size: 0.875rem;
}

.card-actions {
    background: rgba(0,0,0,0.02);
    margin: 0 -1.25rem -1.25rem;
    padding: 1rem 1.25rem;
    border-radius: 0 0 0.375rem 0.375rem;
    position: relative;
    overflow: visible;
}

/* Dropdown Menu Fixes */
.dropdown-container {
    position: relative;
    z-index: 1;
}

.dropdown-container.show {
    z-index: 1062 !important;
}

.dropup .dropdown-menu {
    top: auto !important;
    bottom: 100% !important;
    margin-top: 0;
    margin-bottom: 0.25rem;
}

.dropdown-menu {
    z-index: 1065 !important;
    min-width: 160px;
    border: 1px solid rgba(0,0,0,0.08) !important;
    border-radius: 0.5rem !important;
    padding: 0.5rem 0;
    margin-top: 0.25rem;
    box-shadow: 0 -0.5rem 1rem rgba(0,0,0,0.15) !important;
    position: absolute !important;
}

.dropdown-menu.show {
    z-index: 1065 !important;
    display: block !important;
}

.dropdown-menu .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0;
    transition: all 0.2s ease;
}

.dropdown-menu .dropdown-item:hover {
    background-color: rgba(0,0,0,0.06);
    color: inherit;
}

.dropdown-menu .dropdown-item.text-danger:hover {
    background-color: rgba(220,53,69,0.1);
    color: #dc3545;
}

.dropdown-divider {
    margin: 0.25rem 0;
    opacity: 0.2;
}

.empty-state-icon {
    opacity: 0.5;
}

.btn-group .dropdown-toggle-split {
    border-left: none;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

/* Mobile Action Buttons - Fixed Alignment */
.mobile-actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.mobile-action-row {
    display: flex;
    gap: 0.75rem;
    align-items: stretch;
}

.mobile-action-btn {
    flex: 1;
    font-size: 0.875rem;
    padding: 0.625rem 0.75rem;
    min-height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    white-space: nowrap;
}

.mobile-action-form {
    flex: 1;
    display: flex;
}

.mobile-action-form .mobile-action-btn {
    width: 100%;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-actions {
        background: rgba(0,0,0,0.02);
        margin: 0 -1.25rem -1.25rem;
        padding: 1rem 1.25rem;
        border-radius: 0 0 0.375rem 0.375rem;
        overflow: visible;
    }
    
    .card {
        overflow: visible !important;
    }
    
    .card-body {
        overflow: visible !important;
    }
    
    /* Ensure dropdown works on mobile */
    .dropup .dropdown-menu {
        position: absolute !important;
        will-change: transform;
        bottom: 100% !important;
        top: auto !important;
        left: auto !important;
        right: 0 !important;
        transform: none !important;
        margin-bottom: 0.5rem;
        box-shadow: 0 -0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    
    .dropdown-menu {
        position: absolute !important;
        will-change: transform;
        top: auto !important;
        bottom: 100% !important;
        left: auto !important;
        right: 0 !important;
        transform: none !important;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
    .mobile-action-btn {
        font-size: 0.8rem;
        padding: 0.5rem 0.5rem;
        min-height: 36px;
    }
    
    .mobile-action-row {
        gap: 0.5rem;
    }
    
    .mobile-actions-grid {
        gap: 0.5rem;
    }
}
</style>
@endsection