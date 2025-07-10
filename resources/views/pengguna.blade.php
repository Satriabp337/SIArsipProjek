<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3">
        <div class="mb-4">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:1.5rem;">A</div>
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
    <div class="flex-grow-1">
        <nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
            <form class="d-flex w-50">
                <input class="form-control me-2" type="search" placeholder="Cari dokumen, kategori, atau tag..." aria-label="Search">
            </form>
            <div class="d-flex align-items-center">
                <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
                <img src="https://ui-avat ars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
            </div>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>