@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .card {
        border-radius: 15px;
    }

    .table th {
        font-weight: 600;
        color: #6c757d;
        font-size: 13px;
    }

    .table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .table tbody tr {
        transition: 0.2s;
    }

    .table tbody tr:hover {
        background-color: #f8f9fc;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
    }

    .card-header h6 {
        font-size: 16px;
    }

    .table-responsive {
        padding: 10px 15px;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
        <i class="fas fa-tachometer-alt mr-2 text-primary"></i>
        Dashboard {{ ucfirst($role) }}
    </h1>
    <div class="text-muted small">
        <i class="far fa-calendar-alt mr-1"></i>
        {{ date('l, d F Y') }}
    </div>
</div>

{{-- ================= ADMIN ================= --}}
@if($role == 'admin')

<div class="row">

    {{-- Total PS --}}
    <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase">Total PlayStation</div>
                    <div class="h5 font-weight-bold">{{ $totalPS }}</div>
                </div>
                <i class="fas fa-gamepad fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Total Kategori --}}
    <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase">Total Kategori</div>
                    <div class="h5 font-weight-bold">{{ $totalKategori }}</div>
                </div>
                <i class="fas fa-tags fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Sewa Aktif --}}
    <div class="col mb-4">
        <div class="card border-left-warning shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-warning text-uppercase">Sewa Aktif</div>
                    <div class="h5 font-weight-bold">{{ $sewaAktif }}</div>
                </div>
                <i class="fas fa-clock fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Total User --}}
    <div class="col mb-4">
        <div class="card border-left-info shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase">Total User</div>
                    <div class="h5 font-weight-bold">{{ $totalUser }}</div>
                </div>
                <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Total Sewa --}}
    <div class="col mb-4">
        <div class="card border-left-dark shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-dark text-uppercase">Total Sewa</div>
                    <div class="h5 font-weight-bold">{{ $totalSewa }}</div>
                </div>
                <i class="fas fa-database fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

</div>

<div class="row">

    {{-- Chart --}}
    <div class="col-12">
        <div class="card shadow mb-4 border-0">
            <div class="card-header bg-white">
                <h6 class="font-weight-bold text-primary mb-0">
                    Statistik Penyewaan (7 Hari Terakhir)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chartSewa" style="max-height: 320px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Sewa Terbaru --}}
<div class="card shadow mb-4 border-0">
    <div class="card-header bg-white">
        <h6 class="font-weight-bold text-primary mb-0">Sewa Terbaru</h6>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="thead-light">
                <tr>
                    <th>User</th>
                    <th>PS</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sewaTerbaru as $item)
                <tr>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->playstation->nama }}</td>
                    <td>
                        <span class="badge badge-{{ $item->status == 'selesai' ? 'success' : 'primary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif


{{-- ================= PETUGAS ================= --}}
@if($role == 'petugas')

<div class="row">

    {{-- Menunggu Konfirmasi --}}
    <div class="col-md-3 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-warning text-uppercase">
                        Menunggu Konfirmasi
                    </div>
                    <div class="h5 font-weight-bold">{{ $pendingPeminjaman }}</div>
                </div>
                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Pengembalian --}}
    <div class="col-md-3 mb-4">
        <div class="card border-left-success shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase">
                        Pengembalian
                    </div>
                    <div class="h5 font-weight-bold">{{ $pendingPengembalian }}</div>
                </div>
                <i class="fas fa-undo fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Sewa Aktif --}}
    <div class="col-md-3 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase">
                        Sewa Aktif
                    </div>
                    <div class="h5 font-weight-bold">{{ $sewaAktif }}</div>
                </div>
                <i class="fas fa-gamepad fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

    {{-- Hari Ini --}}
    <div class="col-md-3 mb-4">
        <div class="card border-left-info shadow h-100 py-2 border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase">
                        Transaksi Hari Ini
                    </div>
                    <div class="h5 font-weight-bold">{{ $sewaHariIni->count() }}</div>
                </div>
                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>

</div>

{{-- AKSI CEPAT --}}
<div class="mb-4">
    <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-primary mr-2">
        <i class="fas fa-check"></i> Konfirmasi Peminjaman
    </a>

    <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-success">
        <i class="fas fa-undo"></i> Konfirmasi Pengembalian
    </a>
</div>

{{-- PEMINJAMAN MENUNGGU --}}
<div class="card shadow mb-4 border-0">
    <div class="card-header bg-white">
        <h6 class="font-weight-bold text-primary mb-0">
            <i class="fas fa-clock mr-2"></i> Peminjaman Menunggu
        </h6>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Nama</th>
                    <th>PS</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookingPending as $item)
                <tr>
                    <td>
                        <i class="fas fa-user text-primary mr-1"></i>
                        {{ $item->user->name ?? '-' }}
                    </td>

                    <td>
                        <i class="fas fa-gamepad text-dark mr-1"></i>
                        {{ $item->playstation->nama }}
                    </td>

                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-hourglass-half mr-1"></i> Menunggu
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const canvas = document.getElementById('chartSewa');

    if (canvas) {
        const ctx = canvas.getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78,115,223,0.2)');
        gradient.addColorStop(1, 'rgba(78,115,223,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: gradient,
                    borderColor: '#4e73df',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
