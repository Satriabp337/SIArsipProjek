<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
        }

        .sidebar {
            min-width: 220px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            min-height: 100vh;
        }

        .sidebar .nav-link.active {
            background: #f1f5f9;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: #222;
        }

        .sidebar .nav-link:hover {
            background: #f1f5f9;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card-metric {
            min-width: 180px;
        }

        .quick-action {
            border-radius: 12px;
        }

        .quick-action .icon {
            font-size: 1.5rem;
        }

        .dropzone {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 40px 0;
            text-align: center;
            color: #6c757d;
            background: #f8f9fa;
        }

        .dropzone .bi {
            font-size: 2.5rem;
            color: #adb5bd;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
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
                <li><a href="/documents" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dokumen</a></li>
                <li><a href="kategori" class="nav-link"><i class="bi bi-folder me-2"></i>Kategori</a></li>
                <li><a href="/upload" class="nav-link"><i class="bi bi-upload me-2"></i>Upload</a></li>
                <li><a href="/laporan" class="nav-link"><i class="bi bi-bar-chart me-2"></i>Laporan</a></li>
                <li><a href="/pengguna" class="nav-link"><i class="bi bi-people me-2"></i>Pengguna</a></li>
                <li><a href="/arsip" class="nav-link"><i class="bi bi-archive me-2"></i>Arsip</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="col-md-10 ms-sm-auto px-4 py-4">
            <nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
                <form class="d-flex w-50">
                    <input class="form-control me-2" type="search" placeholder="Cari dokumen, kategori, atau tag..."
                        aria-label="Search">
                </form>
                <div class="d-flex align-items-center">
                    <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
                    <img src="https://ui-avatars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
                </div>
            </nav>

            <div class="container-fluid py-4">
                <div>
                    <h4 class="mb-1">Upload Dokumen</h4>
                    <div class="text-muted">Unggah dokumen baru ke dalam sistem arsip</div>
                </div>
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
                            Mendukung PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Max 50MB)
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
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih kategori</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Sub Kategori</label>
                                <input type="text" name="sub_category" class="form-control" placeholder="Masukkan sub kategori">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Departemen <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-select" required>
                                    <option value="">Pilih departemen</option>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Tingkat Akses <span class="text-danger">*</span></label>
                                <select name="access_level" class="form-select" required>
                                    <option value="Internal" selected>Internal</option>
                                    <option value="Public">Publik</option>
                                    <option value="Confidential">Rahasia</option>
                                </select>
                            </div>
                            <div class="col-md-6">
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


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>