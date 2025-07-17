<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Arsip Projek</title>
    <link rel="icon" type="image/png" href="{{ asset('diskop-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
        body {
            overflow-x: hidden;
        }

        #sidebar {
            transition: all 0.3s;
            width: 250px;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #main-content {
            transition: all 0.3s;
            margin-left: 250px;
        }

        #main-content.full {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                z-index: 1000;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="d-flex">
        <nav id="sidebar" class="bg-light border-end p-3 d-flex flex-column vh-100 position-fixed">
            <div class="mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/diskop-logo.png') }}" alt="Logo Diskop" class="rounded-circle"
                        style="width: 40px; height: 40px; object-fit: cover;">

                    <div class="ms-2">
                        <div class="fw-bold">Arsip Digital</div>
                        <small class="text-muted">Dinas Koperasi & UKM</small>
                    </div>
                </div>
            </div>


            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a href="/dashboard" class="nav-link text-dark"><i
                            class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>

                <li class="nav-item">
                    <a class="nav-link text-dark d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#arsipSubmenu" role="button" aria-expanded="false">
                        <span><i class="bi bi-archive me-2"></i> Arsip</span>
                        <i class="bi bi-caret-down-fill small"></i>
                    </a>
                    <div class="collapse ps-3 {{ request()->is('documents*') || request()->is('upload') || request()->is('kategori*') ? 'show' : '' }}"
                        id="arsipSubmenu">
                        <ul class="nav flex-column mt-2">
                            <li><a href="/documents" class="nav-link text-dark ps-4"><i
                                        class="bi bi-file-earmark-text me-2"></i> Daftar Dokumen</a></li>
                            <li><a href="/upload" class="nav-link text-dark ps-4"><i class="bi bi-upload me-2"></i>
                                    Upload Dokumen</a></li>
                            <li><a href="/kategori" class="nav-link text-dark ps-4"><i class="bi bi-folder me-2"></i>
                                    Kategori</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item"><a href="/laporan" class="nav-link text-dark"><i class="bi bi-bar-chart me-2"></i>
                        Laporan</a></li>
                <li class="nav-item"><a href="/pengguna" class="nav-link text-dark"><i class="bi bi-people me-2"></i>
                        Pengguna</a></li>
                <li class="nav-item"><a href="/pengaturan" class="nav-link text-dark"><i class="bi bi-gear me-2"></i>
                        Pengaturan</a></li>
            </ul>

            <div class="mt-auto pt-3 border-top">
                <small class="text-muted">Logged in as:<br><strong>Dr. Agus Setiawan (admin)</strong></small>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="main-content" class="flex-grow-1">
            <!-- Toggle Button -->
            <button class="btn btn-outline-primary m-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>

            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebarToggle');

            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('full');
            });
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Notifikasi flash untuk success -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        </script>
    @endif


    @stack('script')
</body>

</html>