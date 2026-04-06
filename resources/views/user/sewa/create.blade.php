@extends('layouts.landing')
@section('title','Sewa PS - ' . $ps->nama)

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #0061ff;
        --secondary: #6c757d;
        --success: #28a745;
        --dark: #1a202c;
        --border: #e2e8f0;
    }

    body {
        background-color: #f7fafc;
    }

    .sewa-wrapper {
        max-width: 1150px;
        margin: 100px auto 60px auto;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sewa-card {
        background: #fff;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border);
        height: 100%;
    }

    .sewa-image {
        width: 100%;
        height: 380px;
        border-radius: 20px;
        object-fit: cover;
        margin-bottom: 24px;
        transition: transform 0.3s ease;
    }

    .sewa-image:hover {
        transform: scale(1.02);
    }

    .media-preview {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 24px;
    }

    .sewa-video {
        width: 100%;
        height: 380px;
        border-radius: 20px;
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    /* MEDIA SWITCH FOTO VIDEO */
    .media-box {
        position: relative;
    }

    .media-switch {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
    }

    .media-box {
        position: relative;
    }

    .sewa-image,
    .sewa-video {
        width: 100%;
        height: 380px;
        object-fit: cover;
        border-radius: 20px;
        margin-bottom: 24px;
    }

    .media-btn {
        border: none;
        padding: 8px 14px;
        font-weight: 700;
        border-radius: 10px;
        background: #f1f5f9;
        cursor: pointer;
    }

    .media-btn.active {
        background: #3b82f6;
        color: white;
    }


    .sewa-image,
    .sewa-video {
        width: 100%;
        height: 380px;
        object-fit: cover;
        border-radius: 20px;
    }

    @media(max-width:768px) {
        .media-preview {
            grid-template-columns: 1fr;
        }
    }

    .price-box {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        margin-bottom: 25px;
    }

    .total-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
    }

    .total-price {
        font-size: 2.2rem;
        font-weight: 800;
        display: block;
        margin: 5px 0;
    }

    /* Form Styling */
    .section-box {
        background: #f8fafc;
        border-radius: 18px;
        padding: 24px;
        margin-top: 20px;
        border: 1px solid var(--border);
    }

    .section-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 20px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-grid .full {
        grid-column: span 2;
    }

    label {
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 2px solid var(--border);
        font-weight: 600;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 97, 255, 0.1);
    }

    /* Document Selector */
    .doc-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .doc-item {
        background: #fff;
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: 0.2s;
    }

    .doc-item:has(input:checked) {
        border-color: var(--primary);
        background: #eff6ff;
        color: var(--primary);
    }

    /* Buttons */
    .action-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-btn {
        padding: 16px;
        border-radius: 14px;
        font-weight: 800;
        border: none;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
    }

    .btn-pinjam {
        background: var(--success);
        color: white;
    }

    .btn-booking {
        background: var(--primary);
        color: white;
    }



    .action-btn:hover:not(:disabled) {
        transform: translateY(-3px);
        filter: brightness(1.1);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .action-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .doc-warning {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
        padding: 15px;
        border-radius: 12px;
        color: #92400e;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-grid .full {
            grid-column: span 1;
        }

        .btn-pinjam {
            background: var(--success);
            color: white;
            font-size: 1rem;
        }

        .btn-kembali {
            background: #f1f5f9;
            color: #334155;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container sewa-wrapper">
    <div class="row">
        {{-- SISI KIRI: INFO PRODUK --}}
        <div class="col-lg-7 mb-4">
            <div class="sewa-card">

                <div class="media-box">

                    <div class="media-switch d-flex justify-content-end">
                        <button type="button" class="media-btn active" data-target="foto">📷 FOTO</button>

                        @if($ps->video)
                        <button type="button" class="media-btn" data-target="video">▶ VIDEO</button>
                        @endif
                    </div>

                    @if($ps->photo)
                    <img id="media-foto"
                        src="{{ asset('uploads/ps/'.$ps->photo) }}"
                        class="sewa-image"
                        alt="{{ $ps->nama }}">
                    @endif

                    @if($ps->video)
                    <video id="media-video" class="sewa-video" controls hidden>
                        <source src="{{ asset('uploads/video/'.$ps->video) }}" type="video/mp4">
                    </video>
                    @endif

                </div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="fw-bold mb-1" style="color:var(--dark)">{{ $ps->nama }}</h2>
                        <span class="badge rounded-pill px-3 py-2 bg-light text-primary border border-primary">{{ $ps->category->name }}</span>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Status Unit</small>
                        <span class="fw-bold {{ $ps->stok > 0 ? 'text-success' : 'text-danger' }}">
                            ● {{ $ps->stok > 0 ? 'Tersedia' : 'Kosong' }} ({{ $ps->stok }} Unit)
                        </span>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Deskripsi Unit</h5>
                <p class="text-muted">
                    {!! $ps->deskripsi ?? 'Tidak ada deskripsi untuk unit ini.' !!}
                </p>
            </div>
        </div>

        {{-- SISI KANAN: FORM SEWA --}}
        <div class="col-lg-5 mb-4">
            <form action="{{ route('sewa.store') }}" method="POST" id="mainForm">
                @csrf
                <input type="hidden" name="playstation_id" value="{{ $ps->id }}">
                <input type="hidden" id="price_per_hour" value="{{ $ps->harga }}">

                <div class="sewa-card">
                    {{-- BOX HARGA --}}
                    <div class="price-box">
                        <span class="total-label">Estimasi Total Biaya</span>
                        <span class="total-price" id="grand-total">Rp {{ number_format($ps->harga,0,',','.') }}</span>
                        <div style="opacity: 0.9; font-size: 0.85rem;">
                            Rate: Rp {{ number_format($ps->harga,0,',','.') }} / jam
                        </div>
                    </div>

                    {{-- DURASI --}}
                    <div class="mb-4">
                        <label>DURASI PINJAM (HARI)</label>

                        <input type="number"
                            name="durasi"
                            id="durasi_input"
                            class="form-control form-control-lg text-primary"
                            min="1"
                            max="30"
                            value="1"
                            required>

                        <span class="input-group-text bg-white fw-bold">Hari</span>

                        <small class="text-muted mt-2 d-block text-end">
                            Maksimal peminjaman 7 Hari
                        </small>

                        <div class="alert alert-info mt-3" style="border-radius:12px; font-size:0.85rem;">
                            💡 Pembayaran dilakukan saat pengembalian unit
                        </div>
                    </div>

                    {{-- DATA DIRI --}}
                    <div class="section-box">
                        <div class="section-title">👤 Data Diri Penyewa</div>

                        <div class="form-grid">

                            <div class="full">
                                <label>Nama Lengkap *</label>
                                <input type="text" name="nama" class="form-control" placeholder="Sesuai KTP" required>
                            </div>

                            <div>
                                <label>Nomor KTP *</label>
                                <input
                                    type="text"
                                    name="no_ktp"
                                    class="form-control"
                                    placeholder="320xxxxxxxxxxxxx"
                                    pattern="[0-9]{16}"
                                    maxlength="16"
                                    required>
                            </div>

                            <div>
                                <label>WhatsApp *</label>
                                <input
                                    type="text"
                                    name="hp"
                                    class="form-control"
                                    placeholder="08xxxxxxxxxx"
                                    pattern="08[0-9]{8,12}"
                                    required>
                            </div>

                            <div class="full">
                                <label>Email Aktif *</label>
                                <input type="email" name="email"
                                    value="{{ auth()->user()->email }}"
                                    class="form-control" required>

                                <div class="full">
                                    <label>Alamat Domisili *</label>
                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap saat ini" required></textarea>
                                </div>

                            </div>
                        </div>

                        {{-- JAMINAN --}}
                        <div class="section-box">
                            <div class="section-title">📄 Dokumen Jaminan</div>
                            <div class="doc-grid">
                                <label class="doc-item"><input type="checkbox" name="dokumen[]" value="KTP"> KTP</label>
                                <label class="doc-item"><input type="checkbox" name="dokumen[]" value="SIM"> SIM</label>
                                <label class="doc-item"><input type="checkbox" name="dokumen[]" value="NPWP"> NPWP</label>
                                <label class="doc-item"><input type="checkbox" name="dokumen[]" value="KK"> KK</label>
                            </div>
                            <div class="doc-warning mt-3">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Wajib menyerahkan minimal 1 dokumen <b>ASLI</b> saat pengambilan unit.
                            </div>
                        </div>

                        {{-- PERSETUJUAN --}}
                        <div class="mt-4 px-2">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="setuju" name="setuju" required>
                                <label class="form-check-label fw-bold" for="setuju" style="font-size: 0.8rem">
                                    Saya setuju dengan Syarat & Ketentuan berlaku.
                                </label>
                            </div>

                            {{-- BUTTONS --}}
                            <div class="action-group">
                              <button type="submit" name="aksi" value="pinjam" class="action-btn btn-pinjam">
    🚀 SEWA SEKARANG
</button>

<a href="{{ url()->previous() }}" class="action-btn btn-kembali">
    ← BATALKAN PESANAN
</a>

                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const pricePerHour = parseFloat(document.getElementById('price_per_hour').value);
        const durasiInput = document.getElementById('durasi_input');
        const grandTotal = document.getElementById('grand-total');

        function hitungTotal() {
            let hari = parseInt(durasiInput.value) || 1;

            if (hari > 7) hari = 7;
            if (hari < 1) hari = 1;

            durasiInput.value = hari;

            let total = hari * 24 * pricePerHour;

            grandTotal.innerText = 'Rp ' + Math.floor(total).toLocaleString('id-ID');
        }

        // 🔥 pakai ini (BUKAN input)
        durasiInput.addEventListener('change', hitungTotal);
        durasiInput.addEventListener('blur', hitungTotal);

        // biar langsung ke-load
        hitungTotal();

        const form = document.getElementById('mainForm');

        /* =========================
           SWITCH FOTO VIDEO FIX
        ========================= */

        const fotoBtn = document.querySelector('[data-target="foto"]');
        const videoBtn = document.querySelector('[data-target="video"]');

        const foto = document.getElementById("media-foto");
        const video = document.getElementById("media-video");

        if (fotoBtn) {
            fotoBtn.addEventListener("click", function() {

                this.classList.add("active");
                if (videoBtn) videoBtn.classList.remove("active");

                foto.hidden = false;

                if (video) {
                    video.hidden = true;
                    video.pause();
                }

            });
        }

        if (videoBtn) {
            videoBtn.addEventListener("click", function() {

                this.classList.add("active");
                fotoBtn.classList.remove("active");

                if (video) {
                    video.hidden = false;
                }

                foto.hidden = true;

            });
        }

        function confirmAction(buttonValue, message, confirmBtnColor) {
            const btn = document.querySelector(`button[value='${buttonValue}']`);
            if (!btn) return;

            btn.addEventListener("click", function(e) {
                e.preventDefault();
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pesanan',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: confirmBtnColor,
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Cek Kembali',
                    borderRadius: '15px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "aksi";
                        input.value = buttonValue;
                        form.appendChild(input);
                        form.submit();
                    }
                });
            });
        }

        confirmAction("pinjam", "Apakah data sudah benar? Anda akan melakukan penyewaan langsung.", "#28a745");

    });
</script>
{{-- NOTIFIKASI SUCCESS --}}
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'OK',
            borderRadius: '15px'
        });

    });
</script>
@endif

{{-- NOTIFIKASI ERROR --}}
@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {

        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: '{{ session("error") }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
            borderRadius: '15px'
        });

    });
</script>
@endif