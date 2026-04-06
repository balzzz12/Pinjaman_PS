@extends('layouts.app')

@section('title','Pengembalian (Admin)')

@section('content')
<style>
    /* Global Styling */
    body {
        background-color: #f8f9fc;
        font-family: 'Poppins', sans-serif;
    }

    /* Card Styling */
    .card-ps {
        border: none;
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-ps-header {
        background: linear-gradient(135deg, #050b18 0%, #003791 100%);
        color: white;
        padding: 20px 30px;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
        color: #4e5159;
    }

    .table thead th {
        background-color: #f8f9fc;
        border-top: none;
        border-bottom: 2px solid #e3e6f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 800;
        color: #5c7fec;
        padding: 15px;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 15px;
        border-bottom: 1px solid #f1f3f9;
    }

    /* Image Hover Effect */
    .img-zoom {
        transition: transform 0.3s ease;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .img-zoom:hover {
        transform: scale(2.5);
        position: relative;
        z-index: 10;
    }

    /* Custom Badges */
    .badge-ps {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .bg-ps-success { background-color: #d1e7dd; color: #0f5132; }
    .bg-ps-danger { background-color: #f8d7da; color: #842029; }
    .bg-ps-warning { background-color: #fff3cd; color: #664d03; }
    .bg-ps-primary { background-color: #cfe2ff; color: #084298; }

    /* Empty State */
    .empty-state {
        padding: 40px;
        text-align: center;
        color: #a3a6b5;
    }
</style>

<div class="container mt-5">
    <div class="card card-ps">
        <div class="card-ps-header">
            <h4 class="m-0 font-weight-bold">
                <i class="fas fa-archive mr-2"></i> Data Pengembalian
            </h4>
            <span class="badge badge-light px-3 py-2" style="border-radius: 10px; color: #003791;">
                Total: {{ $peminjaman->count() }} Data
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Unit PS</th>
                            <th class="text-center">Bukti Foto</th>
                            <th>Catatan</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $item->user->name }}</td>
                            <td>
                                <span class="text-dark">{{ $item->playstation->nama }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->foto_kembali)
                                <img src="{{ asset('storage/'.$item->foto_kembali) }}" 
                                     width="60" height="40" 
                                     style="object-fit: cover;"
                                     class="rounded img-zoom shadow-sm">
                                @else
                                <small class="text-muted italic">Tidak ada foto</small>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $item->catatan_kembali ?? '—' }}
                                </small>
                            </td>
                            <td class="text-center">
                                @if($item->kondisi == 'baik')
                                    <span class="badge badge-ps bg-ps-success">
                                        <i class="fas fa-check-circle mr-1"></i> Baik
                                    </span>
                                @elseif($item->kondisi == 'rusak')
                                    <span class="badge badge-ps bg-ps-danger">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Rusak
                                    </span>
                                @else
                                    <span class="badge badge-ps bg-light text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $status = $item->status;
                                    $class = 'bg-ps-secondary';
                                    if($status == 'menunggu_konfirmasi') $class = 'bg-ps-warning';
                                    elseif($status == 'selesai') $class = 'bg-ps-success';
                                    elseif($status == 'dipinjam') $class = 'bg-ps-primary';
                                @endphp
                                <span class="badge badge-ps {{ $class }}">
                                    {{ ucfirst(str_replace('_',' ',$status)) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                Belum ada data pengembalian.
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