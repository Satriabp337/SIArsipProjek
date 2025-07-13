@extends('layouts.app')

@section('content')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script>
    const categoryChart = new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: @json($documentsPerCategory->pluck('name')),
            datasets: [{
                label: 'Jumlah Dokumen',
                data: @json($documentsPerCategory->pluck('documents_count')),
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            }
        }
    });
</script> -->
<!-- resources/views/laporan/index.blade.php -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/chart-data/category-documents')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const categoryChart = new Chart(document.getElementById('categoryChart'), {
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
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Dokumen'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Kategori'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Dokumen per Kategori'
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                // Optionally, display an error message to the user
                const chartContainer = document.getElementById('categoryChart').parentNode;
                chartContainer.innerHTML = '<p style="color: red;">Failed to load chart data. Please try again later.</p>';
            });
    });
</script>
@endpush
<div class="row mb-4">

    <div class="col">
        <h4>Statistik Dokumen</h4>
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <input type="date" name="start" class="form-control" value="{{ request('start') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end" class="form-control" value="{{ request('end') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
        <h4 class="mt-4">Grafik Dokumen per Kategori</h4>
        <canvas id="categoryChart" height="100"></canvas>

        <h4 class="mt-5">Grafik Dokumen per Departemen</h4>
        <canvas id="departmentChart" height="100"></canvas>

        <h2>Laporan Statistik Arsip</h2>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Dokumen</h5>
                <h3>{{ $totalDocuments }}</h3>
            </div>
        </div>

        <p>Total Unduhan: {{ $totalDownloads }}</p>

        <h4>Dokumen per Kategori</h4>
        <ul>
            @foreach($documentsPerCategory as $cat)
            <li>{{ $cat->name }}: {{ $cat->documents_count }}</li>
            @endforeach
        </ul>

        <h4>Dokumen per Departemen</h4>
        <ul>
            @foreach($documentsPerDepartment as $dept)
            <li>{{ $dept->name }}: {{ $dept->documents_count }}</li>
            @endforeach
        </ul>
        <div class="row mb-4">
            <div class="col-md-6">
                <form>...</form>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('laporan.export.pdf') }}" class="btn btn-danger">
                    Export PDF
                </a>
            </div>
        </div>

    </div>
</div>
@endsection