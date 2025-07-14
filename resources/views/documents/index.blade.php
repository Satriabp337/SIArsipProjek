@extends('layouts.app')
@section('content')
<!-- Main Content -->
<div class="container py-4">
    @include('layouts.navbar')
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="department_id" class="form-select">
                <option value="">Semua Departemen</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i> Filter</button>
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
    <p class="text-muted">Menampilkan 3 dari 3 dokumen</p>

    <div class="row g-4">
        @if (isset($documents) && $documents->count())
        @foreach ($documents as $document)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @php
                        $ext = strtolower($document->file_type);
                        $iconClass = 'bi-file-earmark-text';
                        $iconColor = 'text-secondary';
                        if ($ext === 'pdf') {
                        $iconClass = 'bi-file-pdf';
                        $iconColor = 'text-danger';
                        } elseif (in_array($ext, ['doc', 'docx'])) {
                        $iconClass = 'bi-file-word';
                        $iconColor = 'text-primary';
                        } elseif (in_array($ext, ['xls', 'xlsx'])) {
                        $iconClass = 'bi-file-excel';
                        $iconColor = 'text-success';
                        } elseif (in_array($ext, ['ppt', 'pptx'])) {
                        $iconClass = 'bi-file-powerpoint';
                        $iconColor = 'text-warning';
                        }
                        @endphp
                        <i class="bi {{ $iconClass }} {{ $iconColor }} fs-2 me-2"></i>
                        <h5 class="card-title mb-0">{{ $document->title }}</h5>
                    </div>
                    <p class="card-text">{{ $document->description }}</p>
                    <div class="mb-3">
                        <span class="badge bg-secondary">{{ $document->category ? $document->category->name : 'Uncategorized' }}</span>
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-2">
                        <i class="bi bi-building me-2"></i>
                        <span>{{ $document->department ? $document->department->name : 'No Department' }}</span>
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-2">
                        <i class="bi bi-calendar me-2"></i>
                        <span>{{ $document->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center text-muted small mb-3">
                        <span>{{ strtoupper($document->file_type) }} • {{ number_format($document->file_size / 1024 / 1024, 2) }} MB</span>
                        <span class="badge bg-{{ $document->access_level == 'Confidential' ? 'danger' : ($document->access_level == 'Internal' ? 'warning' : 'primary') }} ms-2">{{ strtolower($document->access_level) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">Versi 1 • 0 unduhan</div>
                        <div>
                            <a href="{{ route('documents.file', ['filename' => $document->filename, 'disposition' => 'inline']) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('documents.download', $document->id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Download"><i class="bi bi-download"></i></a>
                            <a href="{{ route('documents.edit', ['document' => $document->id]) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="mt-4">
            {{ $documents->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

        @else
        <p>Tidak ada dokumen tersedia.</p>
        @endif
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $documents->appends(request()->all())->links() }}
    </div>
    <div class="mt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection