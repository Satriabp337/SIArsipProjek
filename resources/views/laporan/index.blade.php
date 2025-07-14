@extends('layouts.app')

@section('content')
<div class="container py-4 justify-content-center">
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
    <div class="mb-5 text-center">
        <h5 class="mb-3">Grafik Dokumen per Kategori</h5>
        <canvas id="categoryChart" height="100"></canvas>
    </div>

    <!-- Grafik Dokumen per Departemen -->
    <div class="mb-5 text-center">
        <h5 class="mb-3">Grafik Dokumen per Departemen</h5>
        <div class="d-flex justify-content-center">
            <div style="width: 80%; max-width: 600px;">
                <canvas id="departmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detail Jumlah -->
    <div class="row">
        <div class="col-md-6 text-center">
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
        <div class="col-md-6 text-center">
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

@push('script')
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
            .then(response => response.json())
            .then(data => {
                const departmentChart = new Chart(document.getElementById('departmentChart'), {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Jumlah Dokumen',
                            data: data.data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Jumlah Dokumen per Departemen'
                            }
                        }
                    }
                });
            });
    });
</script>
@endpush