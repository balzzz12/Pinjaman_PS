@extends('layouts.app')

@section('title','Konfirmasi Pengembalian')

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
        background: #fff;
    }

    .card-ps-header {
        background: linear-gradient(135deg, #050b18 0%, #003791 100%);
        color: white;
        padding: 20px 30px;
        border: none;
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 800;
        color: #5c7fec;
        border-top: none;
        padding: 15px;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 15px;
        color: #4e5159;
    }

    /* Badge Custom */
    .badge-ps {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    /* Image Preview Styling */
    .preview-img {
        transition: transform 0.2s;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .preview-img:hover {
        transform: scale(1.05);
        border-color: #003791;
    }

    /* Action Buttons */
    .btn-ps-success {
        background-color: #1cc88a;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        padding: 8px 15px;
    }

    .btn-ps-dark {
        background-color: #050b18;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        padding: 8px 15px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-ps-success:hover, .btn-ps-dark:hover {
        opacity: 0.9;
        color: white;
        transform: translateY(-2px);
    }

    /* Modal Styling */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 50px;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(5, 11, 24, 0.9);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 85%;
        max-height: 80%;
        border-radius: 15px;
        animation: zoomIn 0.3s;
    }

    @keyframes zoomIn {
        from {transform: scale(0.7); opacity: 0;}
        to {transform: scale(1); opacity: 1;}
    }

    .close-btn {
        position: absolute;
        top: 20px; right: 35px;
        color: #fff; font-size: 40px;
        font-weight: bold; cursor: pointer;
    }
</style>

<div class="container py-5">
    <div class="card card-ps shadow">
        <div class="card-ps-header d-flex justify-content-between align-items-center">
            <h4 class="m-0"><i class="fas fa-check-double me-2"></i> Konfirmasi Pengembalian</h4>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Unit PlayStation</th>
                            <th class="text-center">Bukti Foto</th>
                            <th style="width:250px;">Catatan Balik</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $item)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->user->name }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $item->playstation->nama }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->foto_kembali)
                                <img src="{{ asset('storage/'.$item->foto_kembali) }}"
                                    class="preview-img rounded cursor-pointer"
                                    data-src="{{ asset('storage/'.$item->foto_kembali) }}"
                                    width="80" height="60"
                                    style="object-fit:cover;">
                                @else
                                <small class="text-muted italic">No image</small>
                                @endif
                            </td>
                            <td style="max-width:250px;">
                                <div class="small text-muted" style="line-height: 1.4;">
                                    {{ $item->catatan_kembali ? \Illuminate\Support\Str::limit($item->catatan_kembali, 100) : 'Tidak ada catatan' }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item->kondisi == 'baik')
                                    <span class="badge badge-ps bg-success">Baik</span>
                                @elseif($item->kondisi == 'rusak')
                                    <span class="badge badge-ps bg-danger">Rusak</span>
                                @else
                                    <span class="badge badge-ps bg-secondary">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->status == 'menunggu_konfirmasi')
                                    <span class="badge badge-ps bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge badge-ps bg-info text-white">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-2 align-items-center">
                                    @if($item->status == 'menunggu_konfirmasi')
                                    <form action="{{ route('petugas.peminjaman.selesai', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-ps-success btn-sm w-100 shadow-sm">
                                            <i class="fas fa-check-circle me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                    @endif

                                    @if($item->status == 'selesai')
                                    <a href="{{ route('petugas.peminjaman.cetak', $item->id) }}" class="btn btn-ps-dark btn-sm w-100 shadow-sm">
                                        <i class="fas fa-print me-1"></i> Cetak Struk
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-clipboard-check fa-3x mb-3 d-block opacity-25"></i>
                                Tidak ada pengembalian yang perlu dikonfirmasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="image-modal">
    <span class="close-btn">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const closeBtn = document.querySelector(".close-btn");

        document.querySelectorAll(".preview-img").forEach(img => {
            img.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.getAttribute("data-src");
            }
        });

        closeBtn.onclick = () => modal.style.display = "none";
        modal.onclick = (e) => { if (e.target !== modalImg) modal.style.display = "none"; }
    });
</script>

@endsection
