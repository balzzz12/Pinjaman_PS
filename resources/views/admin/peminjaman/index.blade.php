@extends('layouts.app')

@section('content')
<style>
    /* Custom Styling untuk Halaman Konten */
    body {
        background-color: #f8f9fc;
        font-family: 'Poppins', sans-serif;
    }

    .card-ps {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-ps .card-header {
        background: linear-gradient(45deg, #050b18 0%, #003791 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .table-ps thead {
        background-color: rgba(0, 55, 145, 0.05);
        color: #003791;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .table-ps th {
        border: none !important;
        padding: 1.2rem !important;
    }

    .table-ps td {
        vertical-align: middle !important;
        border-color: #f1f1f1 !important;
        padding: 1.2rem !important;
        color: #4e4e4e;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
    }

    .btn-action {
        border-radius: 10px;
        transition: all 0.3s;
        margin-right: 5px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Data Peminjaman</h1>
    </div>

    <div class="card card-ps">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-database mr-2"></i> List Transaksi Peminjaman</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-ps mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>User</th>
                            <th>PlayStation</th>
                            <th>Jaminan</th>
                            <th>Tanggal Sewa</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $index => $item)
                        <tr>
                            <td class="font-weight-bold">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-dark px-3 py-2" style="letter-spacing: 1px;">
                                    {{ $item->booking_code ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm mr-2 text-primary">
                                        <i class="fas fa-user-circle fa-lg"></i>
                                    </div>
                                    {{ $item->user->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">
                                    <i class="fas fa-gamepad mr-1"></i>
                                    {{ $item->playstation->nama ?? $item->playstation->name ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @php $dokumen = json_decode($item->dokumen, true); @endphp
                                <small class="text-muted">
                                    <i class="fas fa-id-card mr-1"></i>
                                    {{ $dokumen ? implode(', ', $dokumen) : '-' }}
                                </small>
                            </td>
                            <td>
                                {{ $item->wib->format('d M Y') }}<br>
                                <small>{{ $item->wib->format('H:i') }} WIB</small>
                            </td>
                            <td><span class="badge badge-light text-dark border">{{ $item->durasi ?? '-' }} Hari</span></td>
                            <td>
                                @php
                                $statusClasses = [
                                'menunggu' => 'warning',
                                'disetujui' => 'primary',
                                'dipinjam' => 'info',
                                'menunggu_konfirmasi' => 'dark',
                                'selesai' => 'success',
                                'ditolak' => 'danger'
                                ];
                                $class = $statusClasses[$item->status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-status bg-{{ $class }} text-white">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.peminjaman.show', $item->id) }}" class="btn btn-sm btn-info btn-action" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.peminjaman.edit', $item->id) }}" class="btn btn-sm btn-warning btn-action text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-action" onclick="return confirm('Hapus data?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                                Tidak ada data peminjaman saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
