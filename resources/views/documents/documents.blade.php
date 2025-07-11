<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .sidebar { min-width: 220px; background: #fff; border-right: 1px solid #e5e7eb; min-height: 100vh; }
        .sidebar .nav-link.active { background: #f1f5f9; font-weight: 600; }
        .sidebar .nav-link { color: #222; }
        .sidebar .nav-link:hover { background: #f1f5f9; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .card-metric { min-width: 180px; }
        .quick-action { border-radius: 12px; }
        .quick-action .icon { font-size: 1.5rem; }
    </style>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar d-flex flex-column p-3">
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px;height:40px;font-size:1.5rem;">A</div>
                    <div class="ms-2">
                        <div class="fw-bold">Arsip Digital</div>
                        <small class="text-muted">Kementerian Dalam Negeri</small>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <!-- <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li> -->
            <li><a href="/dashboard" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dashboard</a></li>
            <li><a href="/document" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dokumen</a></li>
            <li><a href="/kategori" class="nav-link"><i class="bi bi-folder me-2"></i>Kategori</a></li>
            <li><a href="/upload" class="nav-link"><i class="bi bi-upload me-2"></i>Upload</a></li>
            <li><a href="/laporan" class="nav-link"><i class="bi bi-bar-chart me-2"></i>Laporan</a></li>
            <li><a href="/pengguna" class="nav-link"><i class="bi bi-people me-2"></i>Pengguna</a></li>
            <li><a href="/arsip" class="nav-link"><i class="bi bi-archive me-2"></i>Arsip</a></li>
            <li><a href="/pengaturan" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
            </ul>
        </nav>
        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
                <form class="d-flex w-50">
                    <input class="form-control me-2" type="search" placeholder="Cari dokumen, kategori, atau tag..."
                        aria-label="Search">
                </form>
                <div class="d-flex align-items-center">
                    <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
                    <img src="https://ui-avat ars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
                </div>
            </nav>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dokumen</h2>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            Tanggal Upload
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Terbaru</a></li>
                            <li><a class="dropdown-item" href="#">Terlama</a></li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary"><i class="bi bi-grid"></i></button>
                        <button type="button" class="btn btn-outline-secondary"><i class="bi bi-list"></i></button>
                    </div>
                    <button class="btn btn-primary">Tampilkan Filter</button>
                </div>
            </div>

            <p class="text-muted">Menampilkan 3 dari 3 dokumen</p>

            <div class="row g-4">
                @if (isset($documents) && $documents->count())
                    @foreach ($documents as $document)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    @php
                                        $ext = strtolower($document->file_type);
                                        $iconClass = 'bi-file-earmark-text';
                                        $iconColor = 'text-secondary';
                                        if ($ext === 'pdf') {
                                            $iconClass = 'bi-file-pdf';
                                            $iconColor = 'text-danger';
                                        } elseif (in_array($ext, ['doc', 'docx'])) {
                                            $iconClass = 'bi-file-word';
                                            $iconColor = 'text-primary';
                                        } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                            $iconClass = 'bi-file-excel';
                                            $iconColor = 'text-success';
                                        } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                            $iconClass = 'bi-file-powerpoint';
                                            $iconColor = 'text-warning';
                                        }
                                    @endphp
                                    <i class="bi {{ $iconClass }} {{ $iconColor }} fs-2 me-2"></i>
                                    <h5 class="card-title mb-0">{{ $document->title }}</h5>
                                </div>
                                <p class="card-text">{{ $document->description }}</p>
                                <div class="mb-3">
                                    <span class="badge bg-secondary">{{ $document->category ? $document->category->name : 'Uncategorized' }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="bi bi-building me-2"></i>
                                    <span>{{ $document->department ? $document->department->name : 'No Department' }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="bi bi-calendar me-2"></i>
                                    <span>{{ $document->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-3">
                                    <span>{{ strtoupper($document->file_type) }} • {{ number_format($document->file_size / 1024 / 1024, 2) }} MB</span>
                                    <span class="badge bg-{{ $document->access_level == 'Confidential' ? 'danger' : ($document->access_level == 'Internal' ? 'warning' : 'primary') }} ms-2">{{ strtolower($document->access_level) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">Versi 1 • 0 unduhan</div>
                                    <div>
                                        <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'inline']) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'attachment']) }}" class="btn btn-sm btn-outline-secondary me-1" title="Download"><i class="bi bi-download"></i></a>
                                        <a href="{{ route('documents.edit', ['document' => $document->id]) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p>Tidak ada dokumen tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>