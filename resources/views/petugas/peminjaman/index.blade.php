@extends('layouts.app')

@section('title', 'Konfirmasi Antrean')

@section('content')
<style>
    /* Global Background */
    body {
        background-color: #f8f9fc;
        font-family: 'Poppins', sans-serif;
    }

    /* Card Styling */
    .card-ps {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-ps-header {
        background: linear-gradient(135deg, #050b18 0%, #003791 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #5c7fec;
        border-top: none;
        padding: 15px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        color: #4e5159;
        font-size: 0.9rem;
    }

    /* Badge Customization */
    .badge-status {
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }

    /* Buttons Premium */
    .btn-action {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 6px 15px;
        transition: all 0.3s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-5">
    <div class="card card-ps shadow-sm">
        <div class="card-ps-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-list-ol me-2"></i> Konfirmasi Antrean Peminjaman
            </h4>
        </div>

        <div class="card-body p-4">

            {{-- Alert System --}}
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th class="text-start">Peminjam</th>
                            <th>Kode Booking</th>
                            <th>Unit PS</th>
                            <th>Waktu Request</th>
                            <th>Status</th>
                            <th>Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $index => $item)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">
                                <div class="fw-bold text-dark">{{ $item->user->name ?? '-' }}</div>
                                <small class="text-muted">{{ $item->user->email ?? '' }}</small>
                            </td>

                            <td>
                                <span class="badge bg-light text-primary border px-2 py-2" style="border-radius: 8px; font-family: monospace; font-size: 0.9rem;">
                                    {{ $item->booking_code ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $item->playstation->nama ?? '-' }}</div>
                            </td>
                            
                            <td>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i> {{ $item->created_at->format('d/m/Y') }}<br>
                                    {{ $item->created_at->format('H:i') }} WIB
                                </small>
                            </td>

                            {{-- STATUS BADGES --}}
                            <td>
                                @if($item->status == 'menunggu')
                                    <span class="badge badge-status bg-warning text-dark">MENUNGGU</span>
                                @elseif($item->status == 'disetujui')
                                    <span class="badge badge-status bg-info text-white">DISETUJUI</span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="badge badge-status bg-primary text-white">SEDANG PINJAM</span>
                                @elseif($item->status == 'menunggu_konfirmasi')
                                    <span class="badge badge-status bg-warning text-dark border border-dark">PENDING BALIK</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge badge-status bg-success text-white">SELESAI</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="badge badge-status bg-danger text-white">DITOLAK</span>
                                @endif
                            </td>

                            {{-- ACTION BUTTONS --}}
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                @if($item->status == 'menunggu')
                                    <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Setujui peminjaman ini?')" class="btn btn-success btn-action btn-sm">
                                            <i class="fas fa-check me-1"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('petugas.peminjaman.tolak', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak peminjaman ini?')" class="btn btn-danger btn-action btn-sm">
                                            <i class="fas fa-times me-1"></i> Tolak
                                        </button>
                                    </form>

                                @elseif($item->status == 'disetujui')
                                    <form action="{{ route('petugas.peminjaman.serahkan', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-action btn-sm">
                                            <i class="fas fa-hand-holding-heart me-1"></i> Serahkan Barang
                                        </button>
                                    </form>

                                @elseif($item->status == 'dipinjam')
                                    <form action="{{ route('petugas.peminjaman.selesai', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-action btn-sm text-dark">
                                            <i class="fas fa-undo me-1"></i> Tandai Selesai
                                        </button>
                                    </form>

                                @else
                                    <span class="text-muted small italic">No Action</span>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/white/waiting-room.svg" alt="empty" style="width: 150px;" class="mb-3">
                                <p class="text-muted fw-bold">Belum ada antrean peminjaman masuk.</p>
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