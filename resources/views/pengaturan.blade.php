@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Menu Pengaturan
                </div>
                <div class="list-group list-group-flush">
                    <a href="#pengaturan-akses" class="list-group-item list-group-item-action active">Pengaturan Akses</a>
                    <a href="#keamanan-data" class="list-group-item list-group-item-action">Keamanan Data</a>
                    <a href="#notifikasi" class="list-group-item list-group-item-action">Notifikasi</a>
                    <a href="#penyimpanan" class="list-group-item list-group-item-action">Penyimpanan</a>
                    <a href="#versi-dokumen" class="list-group-item list-group-item-action">Versi Dokumen</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Pengaturan Sistem
                </div>
                <div class="card-body">
                    <!-- Pengaturan Akses Pengguna -->
                    <section id="pengaturan-akses">
    <h5 class="mb-4">Pengaturan Akses Pengguna</h5>

    {{-- Tampilkan notifikasi sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pengaturan.akses.update') }}" method="POST">
        @csrf

        {{-- Kontrol Akses Dokumen --}}
        <div class="form-group">
            <label>Kontrol Akses Dokumen</label>
            <select class="form-control" name="akses_dokumen">
                <option value="publik">Publik - Semua pengguna dapat melihat</option>
                <option value="internal">Internal - Hanya anggota organisasi</option>
                <option value="privat">Privat - Hanya pengguna tertentu</option>
            </select>
            <small class="form-text text-muted">Tentukan siapa yang dapat melihat dokumen dalam sistem</small>
        </div>

        {{-- Tabel Hak Akses --}}
        <div class="form-group">
            <label>Manajemen Peran Pengguna</label>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Peran</th>
                        @foreach ($permissions as $permission)
                            <th>{{ ucfirst($permission->label) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ ucfirst($role->name) }}</td>
                            @foreach ($permissions as $permission)
                                <td>
                                    @if($role->name === 'admin')
                                        {{-- Admin selalu memiliki semua hak akses (tapi tidak bisa diubah) --}}
                                        <input type="checkbox" checked disabled>
                                        <input type="hidden" name="permissions[{{ $role->id }}][]" value="{{ $permission->id }}">
                                    @else
                                        <input type="checkbox"
                                               name="permissions[{{ $role->id }}][]"
                                               value="{{ $permission->id }}"
                                               {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan Akses</button>
    </form>
</section>


                    <hr class="my-5">

                    <!-- Pengaturan Keamanan Data -->
                    <section id="keamanan-data">
    <h5 class="mb-4">Keamanan Data</h5>
    <form>
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

        <a href="{{ url('/audit') }}" class="btn btn-primary">Lihat Log Lengkap</a>
    </form>
</section>

                    <hr class="my-5">

                    <!-- Pengaturan Notifikasi -->
                    <section id="notifikasi">
                        <h5 class="mb-4">Pengaturan Notifikasi</h5>
                        <form>
                            <div class="form-group">
                                <label>Frekuensi Notifikasi</label>
                                <select class="form-control">
                                    <option>Segera</option>
                                    <option>Harian</option>
                                    <option>Mingguan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Notifikasi</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifEmail" checked>
                                    <label class="custom-control-label" for="notifEmail">Email</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifWeb" checked>
                                    <label class="custom-control-label" for="notifWeb">Web Browser</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifMobile">
                                    <label class="custom-control-label" for="notifMobile">Mobile Push</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Event yang Akan Dikirimkan Notifikasi</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifEdit" checked>
                                    <label class="custom-control-label" for="notifEdit">Dokumen Diedit</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifNew" checked>
                                    <label class="custom-control-label" for="notifNew">Dokumen Baru</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifDelete" checked>
                                    <label class="custom-control-label" for="notifDelete">Dokumen Dihapus</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="notifComment">
                                    <label class="custom-control-label" for="notifComment">Komentar Baru</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan Notifikasi</button>
                        </form>
                    </section>

                    <hr class="my-5">

                    <!-- Pengaturan Penyimpanan -->
                    <section id="penyimpanan">
                        <h5 class="mb-4">Pengaturan Penyimpanan</h5>
                        <form>
                            <div class="form-group">
                                <label>Penggunaan Penyimpanan</label>
                                <div class="progress mb-2">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                </div>
                                <small class="form-text text-muted">65% dari 10 GB digunakan</small>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Penyimpanan</label>
                                <select class="form-control">
                                    <option>Penyimpanan Lokal</option>
                                    <option>Amazon S3</option>
                                    <option>Google Cloud Storage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="autoBackup" checked>
                                    <label class="custom-control-label" for="autoBackup">Backup Otomatis</label>
                                </div>
                                <small class="form-text text-muted">Backup harian akan dilakukan setiap pukul 02:00 WIB</small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#cleanupModal">
                                    Bersihkan File Sementara
                                </button>
                                <small class="form-text text-muted">File sementara akan dibersihkan secara otomatis setelah 30 hari</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan Penyimpanan</button>
                        </form>
                    </section>

                    <hr class="my-5">

                    <!-- Pengaturan Versi Dokumen -->
                    <section id="versi-dokumen">
                        <h5 class="mb-4">Pengaturan Versi Dokumen</h5>
                        <form>
                            <div class="form-group">
                                <label>Kebijakan Versi Dokumen</label>
                                <select class="form-control">
                                    <option>Simpan semua versi</option>
                                    <option>Simpan versi utama saja</option>
                                    <option selected>Simpan versi dalam 90 hari terakhir</option>
                                </select>
                                <small class="form-text text-muted">Versi dokumen lama akan membantu dalam pemulihan data</small>
                            </div>
                            <div class="form-group">
                                <label>Frekuensi Penyimpanan Versi</label>
                                <select class="form-control">
                                    <option>Setiap perubahan</option>
                                    <option selected>Setiap 5 perubahan</option>
                                    <option>Setiap 10 perubahan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="autoVersion" checked>
                                    <label class="custom-control-label" for="autoVersion">Versi Otomatis</label>
                                </div>
                                <small class="form-text text-muted">Sistem akan membuat versi baru secara otomatis</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan Versi</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cleanupModal" tabindex="-1" role="dialog" aria-labelledby="cleanupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cleanupModalLabel">Bersihkan File Sementara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda yakin ingin membersihkan semua file sementara? File yang sudah dihapus tidak dapat dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Ya, Bersihkan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .image-checkbox {
        position: relative;
    }
    .image-checkbox input[type="radio"] {
        opacity: 0;
        position: absolute;
    }
    .image-checkbox label {
        cursor: pointer;
        display: block;
    }
    .image-checkbox input[type="radio"]:checked + label {
        border: 2px solid #007bff;
        border-radius: 5px;
    }
    .image-checkbox label span {
        display: block;
        text-align: center;
        margin-top: 5px;
        font-weight: bold;
    }
    section {
        padding-bottom: 20px;
    }
    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endsection
