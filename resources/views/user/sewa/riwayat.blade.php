@extends('layouts.landing')
@section('title', 'Riwayat Sewa | PS RENT')

@section('content')
<style>
    /* 1. Header Styling - Menyamakan dengan Katalog */
    .ps-section-header {
        margin-bottom: 40px;
        border-left: 5px solid var(--ps-accent);
        padding-left: 20px;
    }

    .section-title {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
        text-transform: uppercase;
        color: white;
    }

    /* 2. Card Premium Style */
    .ps-card-dark {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .card-header-custom {
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 20px 25px;
    }

    /* 3. Table Styling */
    .table {
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }

    .ps-header-table {
        background: linear-gradient(90deg, #00439c 0%, #00a2ff 100%);
        color: #fff;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
    }

    .ps-header-table th {
        border: none !important;
        padding: 1.5rem !important;
        font-weight: 800;
    }

    .table td {
        border-color: rgba(255, 255, 255, 0.05);
        padding: 1.2rem !important;
        vertical-align: middle !important;
    }

    .table-hover tbody tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    /* 4. Status Badges */
    .badge-status {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.65rem;
        text-transform: uppercase;
        display: inline-block;
    }

    .bg-menunggu {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .bg-dipinjam {
        background: rgba(0, 209, 102, 0.15);
        color: #00d166;
        border: 1px solid rgba(0, 209, 102, 0.3);
    }

    .bg-selesai {
        background: rgba(0, 162, 255, 0.15);
        color: #00a2ff;
        border: 1px solid rgba(0, 162, 255, 0.3);
    }

    .bg-ditolak {
        background: rgba(255, 62, 62, 0.15);
        color: #ff3e3e;
        border: 1px solid rgba(255, 62, 62, 0.3);
    }

    /* 5. Action Buttons */
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: none;
        transition: 0.3s;
        margin: 0 4px;
    }

    .btn-action:hover {
        transform: translateY(-3px);
        filter: brightness(1.2);
    }

    /* Row Expired Highlight */
    .row-expired {
        background: rgba(255, 62, 62, 0.05) !important;
    }

    .text-ps-accent {
        color: var(--ps-accent);
    }
</style>

<div class="container-fluid px-lg-5 py-4">

    {{-- HEADER --}}
    <div class="ps-section-header">
        <h2 class="section-title">Riwayat Sewa</h2>
        <p class="text-white-50">Pantau durasi bermain dan status transaksi Anda</p>
    </div>

    <div class="card ps-card-dark shadow-lg">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-white">
                <i class="fas fa-history mr-2 text-ps-accent"></i> Transaksi Terakhir
            </span>
            <span class="badge badge-primary px-3 py-2" style="background: var(--ps-accent); border-radius: 8px;">
                TOTAL: {{ count($sewas) }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead class="ps-header-table text-center">
                        <tr>
                            <th width="70">NO</th>
                            <th class="text-left">PLAYSTATION</th>
                            <th>DURASI (HARI)</th>
                            <th>TOTAL HARGA</th>
                            <th>SISA WAKTU</th>
                            <th>STATUS</th>
                            <th>TANGGAL</th>
                            <th width="150">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($sewas as $item)
                        @php
                        $start = $item->waktu_mulai ?? null;
                        $end = null;

                        if ($start) {
                        $end = \Carbon\Carbon::parse($start)
                        ->timezone('Asia/Jakarta')
                        ->addDays($item->durasi);
                        }
                        @endphp
                        <tr class="{{ $end && now()->gt($end) ? 'row-expired' : '' }}">
                            <td class="text-white-50 font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="text-left">
                                <div class="font-weight-bold text-white">{{ $item->playstation->nama }}</div>
                                <small class="text-white-50">{{ $item->playstation->category->name ?? 'Console' }}</small>
                            </td>
                            <td><span class="text-white">{{ $item->durasi }} Hari</span></td>
                            <td>
                                <span class="font-weight-bold text-ps-accent">
                                    Rp {{ number_format(($item->durasi * 24) * $item->playstation->harga,0,',','.') }}
                                    {{-- DENDA --}}
                                    @if($item->status == 'selesai' && $item->denda > 0)
                                    <div class="text-danger small mt-1">
                                        Denda: Rp {{ number_format($item->denda,0,',','.') }}
                                    </div>
                                    @endif
                            </td>
                            <td>
                                @if($item->status == 'dipinjam' && $item->waktu_mulai && $end)

                                <span class="countdown text-success font-weight-bold"
                                    data-end="{{ $end->toIso8601String() }}">
                                    <i class="fas fa-clock mr-1"></i>
                                    loading...
                                </span>

                                @else
                                <span class="text-white-50">-</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($item->status, ['menunggu','booking']))
                                <span class="badge-status bg-menunggu">{{ strtoupper($item->status) }}</span>

                                @elseif($item->status == 'disetujui')
                                <span class="badge-status bg-menunggu">DISETUJUI</span>

                                @elseif($item->status == 'dipinjam')
                                <span class="badge-status bg-dipinjam">DIPINJAM</span>

                                @elseif($item->status == 'menunggu_konfirmasi')
                                <span class="badge-status bg-menunggu">MENUNGGU KONFIRMASI</span>

                                @elseif($item->status == 'selesai')
                                <span class="badge-status bg-selesai">SELESAI</span>
                                @elseif($item->status == 'ditolak')
                                <span class="badge-status bg-ditolak">DITOLAK</span>
                                @endif
                            </td>
                            <td class="text-white-50 small">
                                {{ $item->wib->format('d M Y') }}<br>
                                {{ $item->wib->format('H:i') }} WIB
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if($item->status == 'menunggu')
                                    <form action="{{ route('sewa.cancel',$item->id) }}" method="POST" class="form-cancel">
                                        @csrf @method('DELETE')
                                        <button class="btn-action" style="background: rgba(255, 62, 62, 0.2); color: #ff3e3e;" title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($item->status == 'dipinjam' && $item->waktu_mulai)
                                    <a href="{{ route('sewa.form.kembali',$item->id) }}"
                                        class="btn-action"
                                        style="background: rgba(0, 209, 102, 0.2); color: #00d166;"
                                        title="Kembalikan">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    @endif

                                    @if(in_array($item->status, ['booking','disetujui','dipinjam']))
                                    <button class="btn-action btn-kode" style="background: rgba(0, 162, 255, 0.2); color: #00a2ff;"
                                        data-kode="{{ $item->booking_code }}" title="Lihat Kode">
                                        <i class="fas fa-qrcode"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center">
                                <div class="py-4">
                                    <i class="fas fa-gamepad fa-4x mb-3 text-white-50" style="opacity: 0.2;"></i>
                                    <h5 class="text-white-50">Belum ada riwayat transaksi</h5>
                                    <a href="{{ route('products.index') }}" class="btn btn-sewa-premium mt-3 px-4">
                                        Mulai Sewa Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script SweetAlert Tetap Sama --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
    // ... script yang sama dari kode lama kamu ...
    document.querySelectorAll(".form-cancel").forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Batalkan sewa?',
                icon: 'warning',
                background: '#1a1d21',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ff3e3e',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    document.querySelectorAll(".btn-kode").forEach(btn => {
        btn.addEventListener("click", function() {
            let kode = this.getAttribute("data-kode");

            Swal.fire({
                title: 'Kode Booking',
                html: `
                <div id="kodeArea" style="padding:20px;">
                    <h2 style="letter-spacing:4px; color:#00a2ff; font-weight:800;">
                        ${kode}
                    </h2>
                    <p class="text-white-50">Tunjukkan kode ini ke petugas di lokasi</p>
                </div>
            `,
                background: '#1a1d21',
                color: '#fff',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Download',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#00a2ff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const element = document.getElementById("kodeArea");

                    html2canvas(element).then(canvas => {
                        const link = document.createElement("a");
                        link.download = "kode-booking-" + kode + ".png";
                        link.href = canvas.toDataURL();
                        link.click();
                    });
                }
            });
        });
    });

    setInterval(() => {
        document.querySelectorAll('.countdown').forEach(el => {
            let end = new Date(el.dataset.end).getTime();
            let now = Date.now();
            let diff = Math.floor((end - now) / 1000);

            if (diff <= 0) {
                el.innerHTML = "Waktu Habis";
                el.classList.remove("text-success");
                el.classList.add("text-danger");
                return;
            }

            let h = Math.floor(diff / 3600);
            let m = Math.floor((diff % 3600) / 60);
            let s = diff % 60;

            el.innerHTML = `<i class="fas fa-clock mr-1"></i> ${h} jam ${m} menit ${s} detik`;
        });
    }, 1000);
</script>
@endsection
