<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SI Arsip Projek</title>
    <link rel="icon" type="image/png" href="{{ asset('diskop-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
        :root {
            --primary-color: 2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
            --sidebar-width: 280px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        } */

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: var(--transition);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        #sidebar.collapsed {
            transform: translateX(-100%);
        }

        /* Custom Scrollbar */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Header Section */
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-header .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo-section img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            object-fit: cover;
        }

        .sidebar-header .brand-info h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
        }

        .sidebar-header .brand-info small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
        }

        /* Navigation Styles */
        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: flex;
            align-items: center;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        /* Dropdown Styles */
        .dropdown-toggle::after {
            margin-left: auto;
            transition: var(--transition);
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        .collapse .nav-link {
            padding-left: 3rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .collapse .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.05);
        }

        /* User Info Section */
        .user-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem 1.5rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }

        .user-info strong {
            color: white;
            font-weight: 600;
        }

        /* Main Content */
        #main-content {
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
            background-color: #f5f6fa;
        }

        #main-content.full {
            margin-left: 0;
        }

        /* Header Bar */
        .header-bar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e9ecef;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .toggle-btn {
            background: linear-gradient(135deg, var(--secondary-color), #5dade2);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .toggle-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 1rem;
            }

            .header-bar {
                padding: 0.75rem 1rem;
            }

            .user-greeting {
                display: none;
            }

            .btn-outline-danger {
                padding: 6px 10px;
                font-size: 0.8rem;
            }

            th,
            td {
                font-size: 14px;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {
            .sidebar-header {
                padding: 1rem;
            }

            .sidebar-header .brand-info h5 {
                font-size: 1rem;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 0.6rem 1rem;
            }

            .content-area {
                padding: 0.75rem;
            }
        }

        /* Animation for smooth transitions */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-item {
            animation: slideIn 0.3s ease-out;
        }

        .user-greeting {
            color: #5a5c69;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-outline-danger {
            border-width: 1.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);
        }

        /* Utility Classes */
        .shadow-sm {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        .rounded-lg {
            border-radius: 12px !important;
        }

        /* End of style block */
    </style>
</head>

<body>
    <!-- Main Container -->
    <div class="d-flex position-relative">
        <!-- Sidebar -->
        <nav id="sidebar" class="d-flex flex-column">
            <!-- Header Section -->
            <div class="sidebar-header">
                <div class="logo-section">
                    <img src="{{ asset('images/diskop-logo.png') }}" alt="Logo Diskop">
                    <div class="brand-info">
                        <h5>Arsip Digital</h5>
                        <small>Dinas Koperasi & UKM</small>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="sidebar-nav flex-grow-1">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#arsipSubmenu" role="button"
                            aria-expanded="{{ request()->is('documents*') || request()->is('upload') || request()->is('kategori*') ? 'true' : 'false' }}">
                            <i class="bi bi-archive"></i>
                            Arsip
                        </a>
                        <div class="collapse {{ request()->is('documents*') || request()->is('upload') || request()->is('kategori*') ? 'show' : '' }}"
                            id="arsipSubmenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="/documents"
                                        class="nav-link {{ request()->is('documents*') ? 'active' : '' }}">
                                        <i class="bi bi-file-earmark-text"></i>
                                        Daftar Dokumen
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/upload" class="nav-link {{ request()->is('upload') ? 'active' : '' }}">
                                        <i class="bi bi-upload"></i>
                                        Upload Dokumen
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/kategori"
                                        class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                                        <i class="bi bi-folder"></i>
                                        Kategori
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="/laporan" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart"></i>
                            Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/pengguna" class="nav-link {{ request()->is('pengguna*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i>
                            Pengguna
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/pengaturan/akses" class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Info Section -->
            <div class="user-info">
                <small>
                    Logged in as:<br>
                    <strong>{{ Auth::user()->name }}</strong><br>
                    <span class="badge bg-light text-dark mt-1">
                        {{ ucfirst(Auth::user()->role ?? 'User') }}
                    </span>
                </small>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main id="main-content" class="flex-grow-1">
            <!-- Header Bar -->
            <div class="header-bar d-flex align-items-center justify-content-between">
                <!-- Menu Toggle Button -->
                <button class="toggle-btn" id="sidebarToggle">
                    <i class="bi bi-list me-2"></i>
                    Menu
                </button>

                <!-- User Info & Logout -->
                <div class="d-flex align-items-center">
                    <!-- User Greeting -->
                    <span class="user-greeting me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        Halo, {{ Auth::user()->name }}
                    </span>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            const isMobile = window.innerWidth <= 768;

            // Initialize sidebar state for mobile
            if (isMobile) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('full');
            }

            // Toggle sidebar
            toggleBtn.addEventListener('click', function () {
                if (isMobile) {
                    sidebar.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('full');
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (event) {
                if (isMobile &&
                    !sidebar.contains(event.target) &&
                    !toggleBtn.contains(event.target) &&
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function () {
                const nowMobile = window.innerWidth <= 768;
                if (nowMobile !== isMobile) {
                    location.reload(); // Simple solution for resize handling
                }
            });

            // Smooth scrolling for navigation links
            document.querySelectorAll('.nav-link[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flash Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @stack('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    window.bootstrap = bootstrap;
    </script>
</body>

</html>