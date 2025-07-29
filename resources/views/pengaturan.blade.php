@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Pengaturan Sistem
                </div>
                <div class="card-body">

                    <!-- Pengaturan Akses Pengguna -->
                    <section id="pengaturan-akses">
                        <h5 class="mb-4">Pengaturan Akses Pengguna</h5>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="alert alert-info">
                                Sistem saat ini menggunakan kontrol akses statis berdasarkan peran pengguna di tabel <code>users</code>.
                            </div>
                        </div>
                    </section>

                    <hr class="my-5">

                    <!-- Pengaturan Keamanan Data -->
                    <section id="keamanan-data">
                        <h5 class="mb-4">Keamanan Data</h5>

                        <h3 class="font-medium mb-2">Audit Log</h3>

                        @if($latestAudit)
                            <div class="border rounded-lg p-4 mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>
                                        <strong>Aktivitas Terakhir:</strong>
                                        {{ ucfirst($latestAudit->details) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($latestAudit->date)->diffForHumans() }}
                                    </span>
                                </div>
                                <hr class="my-5">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <strong>Diproses oleh:</strong> {{ $latestAudit->user_email }}
                                    </span>
                                    <a href="{{ url('/audit') }}" class="btn btn-primary">Lihat detail</a>
                                </div>
                            </div>
                        @else
                            <div class="border rounded-lg p-4 mb-3 text-muted">
                                Tidak ada aktivitas tercatat dalam audit log.
                            </div>
                        @endif
                    </section>

                    <hr class="my-5">

                    <!-- Pengaturan Penyimpanan -->
                    <section id="penyimpanan">
                        <h5 class="mb-4">Pengaturan Penyimpanan</h5>

                        {{-- 
                            Placeholder for future storage options.
                            Saat ini sistem hanya menggunakan server fisik lokal (on-premise),
                            namun bagian ini disiapkan untuk kemungkinan dukungan cloud storage (S3, Dropbox, dll) ke depannya.
                        --}}
                        <div class="form-group">
                            <label>Penggunaan Penyimpanan</label>
                            <div class="progress">
                                <div class="progress-bar"
                                     role="progressbar"
                                     style="width: {{ $usagePercentage ?? 0 }}%;" {{-- error hanya di css, view bisa ditampilkan secara normal. aman jika dibiarkan saja. --}}
                                     aria-valuenow="{{ $usagePercentage ?? 0 }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    {{ round($usagePercentage, 0) }}%
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                {{ number_format($usedGB, 2) }} GB dari {{ $quotaGB }} GB digunakan
                            </small>
                        </div>

                        <div class="form-group mt-3">
                            <label>Lokasi Penyimpanan</label>
                            <select class="form-control" disabled>
                                <option selected>Penyimpanan Lokal</option>
                            </select>
                        </div>

                        {{-- <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan Penyimpanan</button> --}}
                    </section>

                    <hr class="my-5">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    section {
        padding-bottom: 20px;
    }
</style>
@endsection
