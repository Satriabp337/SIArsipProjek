@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>Daftar Pengguna</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Verifikasi</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-secondary">{{ $user->role->name ?? 'user' }}</span></td>
                <td>
                    @if($user->email_verified_at)
                        <span class="badge bg-success">Terverifikasi</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Tidak ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
