@extends('layouts.app')
@section('content')
<div class="flex-grow-1">
    @include('layouts.navbar')  
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-3">Dashboard</h4>
        <p class="mb-4">Selamat datang di sistem arsip digital Kementerian Dalam Negeri</p>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-metric p-3">
                    <div class="d-flex align-items-center mb-2">

                        <div class="fw-bold">Total Dokumen</div>
                    </div>
                    <div class="fs-3 fw-bold">2,847</div>
                    <div class="text-success small">+12.5% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-metric p-3">
                    <div class="d-flex align-items-center mb-2">

                        <div class="fw-bold">Pengguna Aktif</div>
                    </div>
                    <div class="fs-3 fw-bold">156</div>
                    <div class="text-success small">+3.2% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-metric p-3">
                    <div class="d-flex align-items-center mb-2">

                        <div class="fw-bold">Dokumen Arsip</div>
                    </div>
                    <div class="fs-3 fw-bold">1,234</div>
                    <div class="text-success small">+8.1% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-metric p-3">
                    <div class="d-flex align-items-center mb-2">

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
@endsection