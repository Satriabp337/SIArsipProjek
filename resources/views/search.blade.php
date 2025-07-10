<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Dokumen - Sistem Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Pencarian Dokumen</h2>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('documents.search') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Kata Kunci</label>
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Cari judul dokumen..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="date" class="form-label">Tanggal Upload</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Hasil Pencarian</h5>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary active">
                                    <i class="bi bi-grid"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>

                        @if($documents->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-search display-1 text-muted"></i>
                                <p class="mt-3 text-muted">Tidak ada dokumen yang ditemukan</p>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($documents as $document)
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    @if($document->mime_type == 'application/pdf')
                                                        <i class="bi bi-file-pdf text-danger fs-2 me-2"></i>
                                                    @elseif($document->mime_type == 'application/msword' || $document->mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                                                        <i class="bi bi-file-word text-primary fs-2 me-2"></i>
                                                    @else
                                                        <i class="bi bi-file-text fs-2 me-2"></i>
                                                    @endif
                                                    <h5 class="card-title mb-0">{{ $document->title }}</h5>
                                                </div>
                                                <p class="card-text">{{ $document->description }}</p>
                                                <div class="mb-3">
                                                    <span class="badge bg-secondary">{{ $document->category->name }}</span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small mb-2">
                                                    <i class="bi bi-person me-2"></i>
                                                    <span>{{ $document->user->name }}</span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small mb-2">
                                                    <i class="bi bi-calendar me-2"></i>
                                                    <span>{{ $document->created_at->format('d F Y') }}</span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small mb-3">
                                                    <span>{{ strtoupper($document->file_type) }} • {{ number_format($document->file_size / 1024 / 1024, 2) }} MB</span>
                                                    <span class="badge {{ $document->is_public ? 'bg-primary' : 'bg-danger' }} ms-2">
                                                        {{ $document->is_public ? 'public' : 'confidential' }}
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-muted small">{{ $document->download_count }} unduhan</div>
                                                    <div>
                                                        <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-outline-secondary me-1">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-secondary me-1">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $documents->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>