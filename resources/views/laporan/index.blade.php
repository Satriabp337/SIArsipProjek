@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Statistik Arsip Dokumen</h4>

    <!-- Filter Tanggal -->
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label for="start" class="form-label">Tanggal Mulai</label>
            <input type="date" name="start" id="start" class="form-control" value="{{ request('start') }}">
        </div>
        <div class="col-md-3">
            <label for="end" class="form-label">Tanggal Selesai</label>
            <input type="date" name="end" id="end" class="form-control" value="{{ request('end') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('laporan.export.pdf') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </form>

    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Dokumen</h5>
                    <h3 class="mb-0">{{ $totalDocuments }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Unduhan</h5>
                    <h3 class="mb-0">{{ $totalDownloads }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Dokumen per Kategori -->
    <div class="mb-5">
        <h5 class="mb-3">Grafik Dokumen per Kategori</h5>
        <canvas id="categoryChart" height="100"></canvas>
    </div>

    <!-- Grafik Dokumen per Departemen -->
    <div class="mb-5">
        <h5 class="mb-3">Grafik Dokumen per Departemen</h5>
        <canvas id="departmentChart" height="100"></canvas>
    </div>

    <!-- Detail Jumlah -->
    <div class="row">
        <div class="col-md-6">
            <h6>Dokumen per Kategori</h6>
            <ul class="list-group">
                @foreach($documentsPerCategory as $cat)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $cat->name }}
                    <span class="badge bg-primary rounded-pill">{{ $cat->documents_count }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h6>Dokumen per Departemen</h6>
            <ul class="list-group">
                @foreach($documentsPerDepartment as $dept)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $dept->name }}
                    <span class="badge bg-secondary rounded-pill">{{ $dept->documents_count }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Kategori
        fetch('/api/chart-data/category-documents')
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('categoryChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Jumlah Dokumen',
                            data: data.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Dokumen per Kategori'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {}
                        }
                    }
                });
            });

        // Chart Departemen
        fetch('/api/chart-data/department-documents')
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('departmentChart'), {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Jumlah Dokumen',
                            data: data.data,
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                                '#e74a3b', '#858796', '#5a5c69', '#2e59d9'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Dokumen per Departemen'
                            }
                        }
                    }
                });
            });
    });
</script>
@endpush