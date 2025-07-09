@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard Statistik Dokumen</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Dokumen</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalDocuments }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Kategori</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalCategories }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Tag</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalTags }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</html></html>