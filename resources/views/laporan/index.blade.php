@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Laporan Statistik Arsip</h2>
                        <!-- <p class="text-muted mb-0">Kelola dan pantau statistik dokumen arsip kedinasan</p> -->
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
            <div class="col-lg-8 col-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bar-chart me-2"></i>Distribusi Dokumen per Kategori
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height: 350px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Detail Tabel --}}
        <div class="table-responsive">
            <table class="table table-hover mb-0 table-bordered text-nowrap align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentsPerCategory as $index => $category)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-medium">{{ $category->name }}</td>
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

        /* Mobile responsive chart styles */
        @media (max-width: 768px) {
            .card-body canvas {
                max-height: 300px !important;
                height: 300px !important;
            }

            .chart-container {
                position: relative;
                height: 300px;
                width: 100%;
            }

            /* Make stats cards stack better on mobile */
            .stats-card {
                margin-bottom: 1rem;
            }

            /* Adjust font sizes for mobile */
            .display-4 {
                font-size: 2rem !important;
            }

            h2.text-primary,
            h2.text-success,
            h2.text-info {
                font-size: 1.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .card-body canvas {
                max-height: 250px !important;
                height: 250px !important;
            }

            .chart-container {
                height: 250px;
            }

            /* Further reduce font sizes on very small screens */
            .display-4 {
                font-size: 1.5rem !important;
            }

            h2.text-primary,
            h2.text-success,
            h2.text-info {
                font-size: 1.25rem !important;
            }

            .card-title {
                font-size: 0.875rem !important;
            }
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
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('d-none');
                }
            }

            function hideLoading() {
                if (loadingOverlay) {
                    loadingOverlay.classList.add('d-none');
                }
            }

            // Function to detect if device is mobile
            function isMobile() {
                return window.innerWidth <= 768;
            }

            // Category Chart Configuration
            // Category Chart Configuration - Updated version
            function initCategoryChart() {
                showLoading();

                // Get current filter parameters from the form
                const startDate = document.getElementById('start')?.value || '';
                const endDate = document.getElementById('end')?.value || '';

                // Build API URL with filter parameters
                let apiUrl = '{{ url("/api/chart-data/category-documents") }}';
                const params = new URLSearchParams();

                if (startDate) params.append('start', startDate);
                if (endDate) params.append('end', endDate);

                if (params.toString()) {
                    apiUrl += '?' + params.toString();
                }

                console.log('Fetching data from:', apiUrl); // Debug log

                fetch(apiUrl)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received data:', data);

                        const ctx = document.getElementById('categoryChart');
                        if (!ctx) {
                            console.error('Canvas element not found');
                            return;
                        }

                        // Check if we have data
                        if (!data.labels || !data.data || data.labels.length === 0) {
                            const chartContainer = ctx.parentElement;
                            chartContainer.innerHTML = `
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-bar-chart display-4 mb-3"></i>
                                <p>Tidak ada data untuk ditampilkan</p>
                                <small>Data akan muncul setelah ada dokumen dalam kategori</small>
                            </div>
                        `;
                            return;
                        }

                        // Create chart container wrapper if not exists
                        if (!ctx.parentElement.classList.contains('chart-container')) {
                            const wrapper = document.createElement('div');
                            wrapper.classList.add('chart-container');
                            ctx.parentElement.insertBefore(wrapper, ctx);
                            wrapper.appendChild(ctx);
                        }

                        // Destroy existing chart if exists
                        if (window.categoryChartInstance) {
                            window.categoryChartInstance.destroy();
                        }

                        // Mobile-specific configuration
                        const mobile = isMobile();

                        // Create new chart
                        window.categoryChartInstance = new Chart(ctx, {
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
                                    borderRadius: mobile ? 2 : 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: !mobile,
                                        position: mobile ? 'bottom' : 'top'
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: 'rgba(255, 255, 255, 0.1)',
                                        borderWidth: 1,
                                        titleFont: {
                                            size: mobile ? 12 : 14
                                        },
                                        bodyFont: {
                                            size: mobile ? 11 : 13
                                        },
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
                                            font: {
                                                size: mobile ? 10 : 12
                                            },
                                            callback: function (value) {
                                                return Number.isInteger(value) ? value : '';
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        },
                                        title: {
                                            display: !mobile,
                                            text: 'Jumlah Dokumen',
                                            font: {
                                                size: mobile ? 11 : 13
                                            }
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            maxRotation: mobile ? 90 : 45,
                                            minRotation: mobile ? 45 : 0,
                                            font: {
                                                size: mobile ? 9 : 11
                                            },
                                            callback: function (value, index) {
                                                const label = this.getLabelForValue(value);
                                                if (mobile && label.length > 10) {
                                                    return label.substring(0, 10) + '...';
                                                }
                                                return label;
                                            }
                                        },
                                        grid: {
                                            display: false
                                        },
                                        title: {
                                            display: !mobile,
                                            text: 'Kategori',
                                            font: {
                                                size: mobile ? 11 : 13
                                            }
                                        }
                                    }
                                },
                                animation: {
                                    duration: mobile ? 500 : 1000,
                                    easing: 'easeInOutQuart'
                                },
                                layout: {
                                    padding: {
                                        left: mobile ? 5 : 10,
                                        right: mobile ? 5 : 10,
                                        top: mobile ? 5 : 10,
                                        bottom: mobile ? 10 : 20
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading category chart:', error);

                        const chartContainer = document.getElementById('categoryChart');
                        if (chartContainer && chartContainer.parentElement) {
                            chartContainer.parentElement.innerHTML = `
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-exclamation-triangle display-4 mb-3"></i>
                                <p>Gagal memuat data grafik</p>
                                <small>Error: ${error.message}</small>
                                <br>
                                <button class="btn btn-sm btn-outline-primary mt-2" onclick="initCategoryChart()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                                </button>
                            </div>
                        `;
                        }
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }

            // Make initCategoryChart globally accessible
            window.initCategoryChart = initCategoryChart;

            // Initialize chart
            initCategoryChart();

            // Reinitialize chart on window resize
            let resizeTimeout;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function () {
                    if (window.categoryChartInstance) {
                        initCategoryChart();
                    }
                }, 250);
            });

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
            // Form validation - Updated version
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

                    showLoading();

                    // Allow form to submit naturally, chart will be refreshed on page load
                });
            }

            // Check if URL has filter parameters, refresh chart if needed
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('start') || urlParams.has('end')) {
                // Chart will be initialized with filter parameters
                console.log('Filter parameters detected, chart will load with filters');
            }
        });
    </script>
@endpush