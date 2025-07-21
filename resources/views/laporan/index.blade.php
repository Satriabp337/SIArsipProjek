@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
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

        {{-- Filter & Export Section --}}
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
                                <li>
                                    <a class="dropdown-item" href="{{ route('laporan.export.pdf') }}">
                                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Export PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="printReport()">
                                        <i class="bi bi-printer text-primary me-2"></i>Print Laporan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Statistik Ringkas --}}
        <div class="row mb-4">
            {{-- Total Dokumen --}}
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

            {{-- Total Unduhan --}}
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

            {{-- Total Kategori --}}
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

            {{-- Space for additional metric if needed --}}
            <div class="col-md-3">
                {{-- Reserved for future metrics --}}
            </div>
        </div>

        {{-- Grafik Section --}}
        <div class="row mb-4">
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

            {{-- Additional chart space --}}
            <div class="col-md-4">
                {{-- Reserved for pie chart or other visualization --}}
            </div>
        </div>

        {{-- Detail Tabel --}}
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
                                        <th class="text-center" style="width: 10%">No</th>
                                        <th>Kategori</th>
                                        <th class="text-center" style="width: 20%">Jumlah</th>
                                        <th class="text-center" style="width: 20%">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($documentsPerCategory as $index => $category)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="fw-medium">{{ $category->name }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill">
                                                    {{ number_format($category->documents_count) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $percentage = $totalDocuments > 0
                                                        ? round(($category->documents_count / $totalDocuments) * 100, 1)
                                                        : 0;
                                                @endphp
                                                <span class="text-muted fw-medium">{{ $percentage }}%</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                                Tidak ada data kategori ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional table or content space --}}
            <div class="col-md-6">
                {{-- Reserved for additional tables or content --}}
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none"
            style="background: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-center text-white">
                    <div class="spinner-border text-light mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Print styles */
        @media print {

            .btn,
            .dropdown,
            .card-header {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
                margin-bottom: 1rem !important;
            }

            .container-fluid {
                padding: 0 !important;
            }

            .badge {
                background-color: #6c757d !important;
                color: white !important;
            }
        }

        /* Custom styles */
        .card-body canvas {
            max-height: 400px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.875rem;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Utility functions
            const loadingOverlay = document.getElementById('loadingOverlay');

            function showLoading() {
                loadingOverlay.classList.remove('d-none');
            }

            function hideLoading() {
                loadingOverlay.classList.add('d-none');
            }

            // Category Chart Configuration
            function initCategoryChart() {
                showLoading();

                fetch('/api/chart-data/category-documents')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const ctx = document.getElementById('categoryChart');

                        if (!ctx) {
                            console.error('Canvas element not found');
                            return;
                        }

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels || [],
                                datasets: [{
                                    label: 'Jumlah Dokumen',
                                    data: data.data || [],
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.8)',
                                        'rgba(255, 99, 132, 0.8)',
                                        'rgba(255, 206, 86, 0.8)',
                                        'rgba(75, 192, 192, 0.8)',
                                        'rgba(153, 102, 255, 0.8)',
                                        'rgba(255, 159, 64, 0.8)',
                                        'rgba(201, 203, 207, 0.8)'
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)',
                                        'rgba(201, 203, 207, 1)'
                                    ],
                                    borderWidth: 1,
                                    borderRadius: 4
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
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: 'rgba(255, 255, 255, 0.1)',
                                        borderWidth: 1,
                                        callbacks: {
                                            label: function (context) {
                                                return `Jumlah: ${context.parsed.y} dokumen`;
                                            }

                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1,
                                            callback: function (value) {
                                                return Number.isInteger(value) ? value : '';
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            maxRotation: 45,
                                            minRotation: 0
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeInOutQuart'
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading category chart:', error);

                        // Show error message to user
                        const chartContainer = document.getElementById('categoryChart').parentElement;
                        chartContainer.innerHTML =
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-exclamation-triangle display-4 mb-3"></i>
                                <p>Gagal memuat data grafik</p>
                                <small>Silakan refresh halaman atau hubungi administrator</small>
                            </div>
                            ;
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }

            // Initialize chart
            initCategoryChart();

            // Global functions for buttons
            window.resetFilter = function () {
                const startInput = document.getElementById('start');
                const endInput = document.getElementById('end');

                if (startInput) startInput.value = '';
                if (endInput) endInput.value = '';

                // Remove query parameters and reload
                const url = new URL(window.location);
                url.search = '';
                window.location.href = url.toString();
            };

            window.printReport = function () {
                window.print();
            };

            // Form validation
            const filterForm = document.querySelector('form[method="GET"]');
            if (filterForm) {
                filterForm.addEventListener('submit', function (e) {
                    const startDate = document.getElementById('start').value;
                    const endDate = document.getElementById('end').value;

                    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                        e.preventDefault();
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
                        return false;
                    }
                });
            }
        });
    </script>
@endpush