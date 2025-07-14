<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Arsip Projek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column bg-light vh-100 border-end p-3" style="width: 250px; position: sticky; top: 0;">
            <div class="mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; font-size: 1.5rem;">A</div>
                    <div class="ms-2">
                        <div class="fw-bold">Arsip Digital</div>
                        <small class="text-muted">Kementerian Dalam Negeri</small>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link text-dark">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <!-- Arsip: submenu -->
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#arsipSubmenu" role="button" aria-expanded="false">
                        <span><i class="bi bi-archive me-2"></i> Arsip</span>
                        <i class="bi bi-caret-down-fill small"></i>
                    </a>

                    <div class="collapse ps-3 {{ request()->is('documents*') || request()->is('upload') || request()->is('kategori*') ? 'show' : '' }}" id="arsipSubmenu">
                        <ul class="nav flex-column mt-2">
                            <li><a href="/documents" class="nav-link text-dark ps-4"><i class="bi bi-file-earmark-text me-2"></i> Daftar Dokumen</a></li>
                            <li><a href="/upload" class="nav-link text-dark ps-4"><i class="bi bi-upload me-2"></i> Upload Dokumen</a></li>
                            <li><a href="/kategori" class="nav-link text-dark ps-4"><i class="bi bi-folder me-2"></i> Kategori</a></li>
                        </ul>
                    </div>
                </li>


                <!-- Laporan -->
                <li class="nav-item">
                    <a href="/laporan" class="nav-link text-dark">
                        <i class="bi bi-bar-chart me-2"></i> Laporan
                    </a>
                </li>

                <!-- Pengguna -->
                <li class="nav-item">
                    <a href="/pengguna" class="nav-link text-dark">
                        <i class="bi bi-people me-2"></i> Pengguna
                    </a>
                </li>

                <!-- Pengaturan -->
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark">
                        <i class="bi bi-gear me-2"></i> Pengaturan
                    </a>
                </li>
            </ul>

            <div class="mt-auto pt-3 border-top">
                <small class="text-muted">Logged in as:<br><strong>Dr. Agus Setiawan (admin)</strong></small>
            </div>

        </nav>
        <!-- Main Content -->
        <main class="flex-grow-1">

            @yield('content')
        </main>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script')
</body>

</html>