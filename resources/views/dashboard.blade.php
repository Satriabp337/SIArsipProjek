<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Dashboard</title>
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
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dokumen</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-folder me-2"></i>Kategori</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-upload me-2"></i>Upload</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-bar-chart me-2"></i>Laporan</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-people me-2"></i>Pengguna</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-archive me-2"></i>Arsip</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
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
                <img src="https://ui-avatars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
            </div>
        </nav>
        <div class="container-fluid py-4">
            <h4 class="fw-bold mb-3">Dashboard</h4>
            <p class="mb-4">Selamat datang di sistem arsip digital Kementerian Dalam Negeri</p>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card card-metric p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="fw-bold">Total Dokumen</div>
                        </div>
                        <div class="fs-3 fw-bold">2,847</div>
                        <div class="text-success small">+12.5% dari bulan lalu</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-metric p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;"><i class="bi bi-people"></i></div>
                            <div class="fw-bold">Pengguna Aktif</div>
                        </div>
                        <div class="fs-3 fw-bold">156</div>
                        <div class="text-success small">+3.2% dari bulan lalu</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-metric p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;"><i class="bi bi-archive"></i></div>
                            <div class="fw-bold">Dokumen Arsip</div>
                        </div>
                        <div class="fs-3 fw-bold">1,234</div>
                        <div class="text-success small">+8.1% dari bulan lalu</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-metric p-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;"><i class="bi bi-download"></i></div>
                            <div class="fw-bold">Unduhan Bulan Ini</div>
                        </div>
                        <div class="fs-3 fw-bold">5,678</div>
                        <div class="text-success small">+15.3% dari bulan lalu</div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card p-3 mb-3">
                        <div class="fw-bold mb-2">Aktivitas Terbaru</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <span class="fw-bold text-primary">Dokumen \"Laporan Keuangan Q1\"</span> telah diupload<br>
                                <small class="text-muted">Siti Maharani • Keuangan • 2 jam yang lalu</small>
                            </li>
                            <li class="list-group-item px-0">
                                <span class="fw-bold text-primary">Dokumen \"SOP Pelayanan\"</span> telah diunduh<br>
                                <small class="text-muted">Ahmad Sutanto • Pelayanan Publik • 4 jam yang lalu</small>
                            </li>
                            <li class="list-group-item px-0">
                                <span class="fw-bold text-primary">Dokumen \"Surat Keputusan 001\"</span> telah diperbarui<br>
                                <small class="text-muted">Budi Santoso • Kepegawaian • 1 hari yang lalu</small>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 mb-3">
                        <div class="fw-bold mb-2">Aksi Cepat</div>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary quick-action"><i class="bi bi-upload icon me-2"></i>Upload Dokumen Baru</a>
                            <a href="#" class="btn btn-outline-success quick-action"><i class="bi bi-calendar-check icon me-2"></i>Jadwalkan Arsip</a>
                            <a href="#" class="btn btn-outline-purple quick-action"><i class="bi bi-people icon me-2"></i>Kelola Pengguna</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

  <div class="flex flex-1 min-h-0 overflow-hidden mt-1">
    <!-- Sidebar -->
    <nav aria-label="Sidebar navigation" class="bg-white w-64 border-r border-slate-300 flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-slate-300">
      <ul class="p-4 space-y-2 text-slate-800 text-sm font-medium select-none">
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md bg-blue-50 text-blue-700 font-semibold" aria-current="page">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-9 10h8a2 2 0 002-2v-5a2 2 0 00-2-2h-8a2 2 0 00-2 2v5a2 2 0 002 2z" />
            </svg>
            Dashboard
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-1a4 4 0 014-4h3m-3 7v1m6-7v1a4 4 0 01-4 4h-3m3-7v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1" />
            </svg>
            Dokumen
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10c0 1.1.9 2 2 2h3v-5h4v5h3a2 2 0 002-2V7m-9 0V4a2 2 0 114 0v3" />
            </svg>
            Kategori
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10v6M8 10v6" />
            </svg>
            Upload
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-1a4 4 0 014-4h3m-3 7v1m6-7v1a4 4 0 01-4 4h-3m3-7v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1" />
            </svg>
            Laporan
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10c0 1.1.9 2 2 2h3v-5h4v5h3a2 2 0 002-2V7m-9 0V4a2 2 0 114 0v3" />
            </svg>
            Pengguna
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-1a4 4 0 014-4h3m-3 7v1m6-7v1a4 4 0 01-4 4h-3m3-7v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1" />
            </svg>
            Arsip
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Pengaturan
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
      <!-- Page Title and Greeting -->
      <section class="mb-6 bg-white rounded-lg shadow p-4 border border-slate-200">
        <h1 class="text-2xl font-bold mb-1 select-none">Dashboard</h1>
        <p class="text-slate-600 select-none">Selamat datang di sistem arsip digital Kementerian Dalam Negeri</p>
      </section>

      <!-- Stats Cards -->
      <section class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <article class="bg-white rounded-lg shadow p-4 border border-slate-200 flex justify-between items-center">
          <div>
            <div class="text-xs text-slate-500 font-semibold select-none">Total Dokumen</div>
            <div class="text-2xl font-extrabold select-none">2,847</div>
            <div class="flex items-center text-green-600 text-xs font-semibold mt-1 select-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              +12.5% dari bulan lalu
            </div>
          </div>
          <div class="bg-blue-100 rounded-md p-2 ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
            </svg>
          </div>
        </article>

        <article class="bg-white rounded-lg shadow p-4 border border-slate-200 flex justify-between items-center">
          <div>
            <div class="text-xs text-slate-500 font-semibold select-none">Pengguna Aktif</div>
            <div class="text-2xl font-extrabold select-none">156</div>
            <div class="flex items-center text-green-600 text-xs font-semibold mt-1 select-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              +3.2% dari bulan lalu
            </div>
          </div>
          <div class="bg-blue-100 rounded-md p-2 ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87m-9-3a4 4 0 014-4M16 14a4 4 0 01-8 0m-6 3v2h5" />
              <circle cx="12" cy="7" r="3" />
            </svg>
          </div>
        </article>

        <article class="bg-white rounded-lg shadow p-4 border border-slate-200 flex justify-between items-center">
          <div>
            <div class="text-xs text-slate-500 font-semibold select-none">Dokumen Arsip</div>
            <div class="text-2xl font-extrabold select-none">1,234</div>
            <div class="flex items-center text-green-600 text-xs font-semibold mt-1 select-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              +8.1% dari bulan lalu
            </div>
          </div>
          <div class="bg-blue-100 rounded-md p-2 ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="16" rx="2" ry="2" />
              <path d="M3 10h18" />
            </svg>
          </div>
        </article>

        <article class="bg-white rounded-lg shadow p-4 border border-slate-200 flex justify-between items-center">
          <div>
            <div class="text-xs text-slate-500 font-semibold select-none">Unduhan Bulan Ini</div>
            <div class="text-2xl font-extrabold select-none">5,678</div>
            <div class="flex items-center text-green-600 text-xs font-semibold mt-1 select-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              +15.3% dari bulan lalu
            </div>
          </div>
          <div class="bg-blue-100 rounded-md p-2 ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v9m0 0l-4-4m4 4l4-4" />
            </svg>
          </div>
        </article>
      </section>

      <!-- Recent Activity & Quick Actions -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Recent Activity -->
        <section aria-label="Aktivitas terbaru" class="bg-white rounded-lg shadow p-6 border border-slate-200">
          <h2 class="text-lg font-semibold mb-4 select-none">Aktivitas Terbaru</h2>
          <ul class="space-y-4 text-sm text-slate-800">
            <li class="flex gap-3">
              <div class="flex-shrink-0 bg-blue-100 text-blue-700 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <div class="font-semibold leading-tight">
                  Dokumen <q class="italic">Laporan Keuangan Q1</q> telah <span class="font-bold">diupload</span>
                </div>
                <div class="text-slate-500 text-xs mt-0.5 select-none">Siti Maharani • Keuangan</div>
                <div class="text-xs text-slate-400 select-none">2 jam yang lalu</div>
              </div>
            </li>

            <li class="flex gap-3">
              <div class="flex-shrink-0 bg-blue-100 text-blue-700 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <div class="font-semibold leading-tight">
                  Dokumen <q class="italic">SOP Pelayanan</q> telah <span class="font-bold">diunduh</span>
                </div>
                <div class="text-slate-500 text-xs mt-0.5 select-none">Ahmad Sutanto • Pelayanan Publik</div>
                <div class="text-xs text-slate-400 select-none">4 jam yang lalu</div>
              </div>
            </li>

            <li class="flex gap-3">
              <div class="flex-shrink-0 bg-blue-100 text-blue-700 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <div class="font-semibold leading-tight">
                  Dokumen <q class="italic">Surat Keputusan 001</q> telah <span class="font-bold">diperbarui</span>
                </div>
                <div class="text-slate-500 text-xs mt-0.5 select-none">Budi Santoso • Kepegawaian</div>
                <div class="text-xs text-slate-400 select-none">1 hari yang lalu</div>
              </div>
            </li>
          </ul>
        </section>

        <!-- Quick Actions -->
        <section aria-label="Aksi cepat" class="bg-white rounded-lg shadow p-6 border border-slate-200">
          <h2 class="text-lg font-semibold mb-4 select-none">Aksi Cepat</h2>
          <div class="space-y-3">
            <button class="w-full flex items-center justify-between px-4 py-3 rounded-md bg-blue-100 text-blue-700 text-sm font-semibold hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400" type="button" aria-label="Upload Dokumen Baru">
              <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
                Upload Dokumen Baru
              </div>
              <span class="text-xl font-light">→</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 rounded-md bg-green-100 text-green-700 text-sm font-semibold hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-400" type="button" aria-label="Jadwalkan Arsip">
              <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                  <line x1="16" y1="2" x2="16" y2="6" />
                  <line x1="8" y1="2" x2="8" y2="6" />
                  <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Jadwalkan Arsip
              </div>
              <span class="text-xl font-light">→</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 rounded-md bg-purple-100 text-purple-700 text-sm font-semibold hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400" type="button" aria-label="Kelola Pengguna">
              <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87m-9-3a4 4 0 014-4M16 14a4 4 0 01-8 0m-6 3v2h5" />
                  <circle cx="12" cy="7" r="3" />
                </svg>
                Kelola Pengguna
              </div>
              <span class="text-xl font-light">→</span>
            </button>
          </div>
        </section>
      </section>
    </main>
  </div>

</body>
</html>

