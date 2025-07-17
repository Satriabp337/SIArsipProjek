@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Laporan Statistik Arsip</h2>
                    <p class="text-muted mb-0">Kelola dan pantau statistik dokumen arsip kedinasan</p>
                </div>
                <div>
                    <span class="badge bg-info fs-6">{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Export Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="start" class="form-label fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i>Tanggal Mulai
                    </label>
                    <input type="date" name="start" id="start" class="form-control" value="{{ request('start') }}">
                </div>
                <div class="col-md-3">
                    <label for="end" class="form-label fw-semibold">
                        <i class="bi bi-calendar-check me-1"></i>Tanggal Selesai
                    </label>
                    <input type="date" name="end" id="end" class="form-control" value="{{ request('end') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </button>
                </div>
                <div class="col-md-2">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('laporan.export.pdf') }}">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Export PDF
                            </a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="printReport()">
                                <i class="bi bi-printer text-primary me-2"></i>Print Laporan
                            </a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-text display-4 text-primary"></i>
                    </div>
                    <h6 class="card-title text-muted">Total Dokumen</h6>
                    <h2 class="mb-0 text-primary">{{ number_format($totalDocuments) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-download display-4 text-success"></i>
                    </div>
                    <h6 class="card-title text-muted">Total Unduhan</h6>
                    <h2 class="mb-0 text-success">{{ number_format($totalDownloads) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-folder display-4 text-info"></i>
                    </div>
                    <h6 class="card-title text-muted">Total Kategori</h6>
                    <h2 class="mb-0 text-info">{{ $documentsPerCategory->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-building display-4 text-warning"></i>
                    </div>
                    <h6 class="card-title text-muted">Total Departemen</h6>
                    <h2 class="mb-0 text-warning">{{ $documentsPerDepartment->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="row mb-4">
        <!-- Grafik Kategori -->
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Distribusi Dokumen per Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Departemen -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2"></i>Dokumen per Departemen
                    </h5>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div style="width: 100%; max-width: 300px;">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Tabel -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>Detail Dokumen per Kategori
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsPerCategory as $index => $cat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $cat->documents_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">{{ $totalDocuments > 0 ? round(($cat->documents_count / $totalDocuments) * 100, 1) : 0 }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-building me-2"></i>Detail Dokumen per Departemen
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Departemen</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsPerDepartment as $index => $dept)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dept->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $dept->documents_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">{{ $totalDocuments > 0 ? round(($dept->documents_count / $totalDocuments) * 100, 1) : 0 }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background: rgba(0,0,0,0.5); z-index: 9999;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-center text-white">
                <div class="spinner-border text-light mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Memuat data...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show loading
    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }

    // Hide loading
    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }

    // Chart Kategori
    showLoading();
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
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Jumlah: ' + context.parsed.y + ' dokumen';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading category chart:', error);
        })
        .finally(() => {
            hideLoading();
        });

    // Chart Departemen
    fetch('/api/chart-data/department-documents')
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('departmentChart'), {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: data.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(199, 199, 199, 0.8)',
                            'rgba(83, 102, 255, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(199, 199, 199, 1)',
                            'rgba(83, 102, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 10,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed + ' dokumen';
                                    
                                    // Calculate percentage
                                    let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = Math.round((context.parsed / sum) * 100);
                                    label += ' (' + percentage + '%)';
                                    
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading department chart:', error);
        });
});

// Reset Filter Function
function resetFilter() {
    document.getElementById('start').value = '';
    document.getElementById('end').value = '';
    window.location.href = window.location.pathname;
}

// Print Report Function
function printReport() {
    window.print();
}

// Add print styles
const printStyles = `
    @media print {
        .btn, .dropdown, .card-header {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
    }
`;

// Add print styles to head
const styleSheet = document.createElement('style');
styleSheet.textContent = printStyles;
document.head.appendChild(styleSheet);
</script>
@endpush