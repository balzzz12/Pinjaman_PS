@extends('layouts.landing')
@section('title', 'Pengembalian | PS RENT')

@section('content')
<style>
    :root {
        --ps-accent: #00a2ff;
        --ps-danger: #ff3e3e;
        --ps-success: #00d166;
        --ps-card-bg: rgba(255, 255, 255, 0.03);
    }

    /* Header Styling */
    .ps-section-header {
        margin-bottom: 40px;
        border-left: 5px solid var(--ps-accent);
        padding-left: 20px;
        animation: fadeInLeft 0.6s ease-out;
    }

    .section-title {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
        text-transform: uppercase;
        color: white;
    }

    /* Card Premium Style */
    .ps-form-card {
        background: var(--ps-card-bg);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 40px;
        backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        animation: fadeInUp 0.8s ease-out;
    }

    /* Warning Box */
    .warning-box {
        background: rgba(255, 62, 62, 0.07);
        border: 1px solid rgba(255, 62, 62, 0.2);
        color: #ffb3b3;
        padding: 20px;
        border-radius: 18px;
        margin-bottom: 35px;
    }

    /* Form Controls */
    .form-label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
    }

    .form-control,
    .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff !important;
        border-radius: 14px;
        padding: 14px 18px;
        transition: all 0.3s ease;
    }

    /* Custom File Upload Button */
    .upload-container {
        position: relative;
        width: 100%;
    }

    .upload-btn-wrapper {
        border: 2px dashed rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.03);
        border-radius: 18px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .upload-btn-wrapper:hover {
        border-color: var(--ps-accent);
        background: rgba(0, 162, 255, 0.05);
    }

    .upload-btn-wrapper i {
        font-size: 2rem;
        color: var(--ps-accent);
        margin-bottom: 5px;
    }

    .upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    #file-name-preview {
        display: none;
        margin-top: 10px;
        font-size: 0.85rem;
        color: var(--ps-success);
        font-weight: 600;
    }

    /* Radio Box Custom */
    .radio-container {
        display: flex;
        gap: 20px;
    }

    .radio-box {
        flex: 1;
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 20px;
        cursor: pointer;
        text-align: center;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: rgba(255, 255, 255, 0.6);
    }

    .radio-box input[type="radio"] {
        display: none;
    }

    .radio-box.box-success:has(input:checked) {
        border-color: var(--ps-success);
        background: rgba(0, 209, 102, 0.1);
        color: #fff;
        transform: translateY(-5px);
    }

    .radio-box.box-danger:has(input:checked) {
        border-color: var(--ps-danger);
        background: rgba(255, 62, 62, 0.1);
        color: #fff;
        transform: translateY(-5px);
    }

    /* Submit Button */
    .btn-submit {
        background: linear-gradient(135deg, #0056b3 0%, #00a2ff 100%);
        border: none;
        border-radius: 16px;
        padding: 18px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #fff;
        width: 100%;
        transition: 0.4s;
        box-shadow: 0 10px 20px rgba(0, 162, 255, 0.2);
    }

    .btn-submit:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 30px rgba(0, 162, 255, 0.4);
    }

    .ps-name-tag {
        display: inline-block;
        background: var(--ps-accent);
        color: white;
        padding: 6px 16px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.75rem;
        margin-bottom: 15px;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Perbaikan Textarea agar tulisan terlihat */
    textarea.form-control {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    textarea.form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    /* Styling untuk Image Preview */
    #image-preview-container {
        display: none;
        margin-top: 15px;
        position: relative;
    }

    #image-preview-container img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 12px;
        border: 2px solid var(--ps-accent);
        object-fit: cover;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">

            {{-- HEADER --}}
            <div class="ps-section-header">
                <h2 class="section-title">Proses Pengembalian</h2>
                <p class="text-white-50 mb-0">Selesaikan transaksi penyewaan Anda dengan aman</p>
            </div>

            <div class="ps-form-card">
                <div class="mb-4 text-center text-md-start">
                    <span class="ps-name-tag">UNIT: {{ $sewa->playstation->nama }}</span>
                    <h4 class="text-white fw-bold">Konfirmasi Kondisi Barang</h4>
                </div>

                {{-- PERINGATAN --}}
                <div class="warning-box">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle me-3 mt-1" style="font-size: 1.2rem;"></i>
                        <div class="small">
                            <strong class="d-block mb-1 text-white">PERHATIAN:</strong>
                            <ul class="mb-0 ps-3">
                                <li>Wajib mengembalikan sesuai kondisi awal.</li>
                                <li>Kerusakan fisik/sistem akan dikenakan denda.</li>
                                <li>Pastikan foto bukti pengembalian terlihat jelas.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('sewa.kembali', $sewa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- PILIHAN KONDISI --}}
                    <div class="mb-4">
                        <label class="form-label">Kondisi Saat Ini</label>
                        <div class="radio-container">
                            <label class="radio-box box-success">
                                <input type="radio" name="kondisi" value="baik" required checked>
                                <div class="icon mb-2"><i class="fas fa-check-circle fa-2x text-success"></i></div>
                                <span>Kondisi Baik</span>
                            </label>

                            <label class="radio-box box-danger">
                                <input type="radio" name="kondisi" value="rusak">
                                <div class="icon mb-2"><i class="fas fa-times-circle fa-2x text-danger"></i></div>
                                <span>Ada Kerusakan</span>
                            </label>
                        </div>
                    </div>
                    {{-- UPLOAD FOTO (BUTTON STYLE) --}}
                    <div class="mb-4">
                        <label class="form-label">Bukti Foto Pengembalian</label>
                        <div class="upload-container">
                            <div class="upload-btn-wrapper" id="upload-wrapper">
                                <div id="upload-prompt">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <div class="text-white fw-bold">Upload Foto Unit</div>
                                    <div class="text-white-50 small">Ketuk untuk memilih atau seret gambar ke sini</div>
                                </div>

                                <div id="image-preview-container">
                                    <img id="output-image" src="" alt="Preview">
                                    <div class="text-success small mt-2 fw-bold" id="file-name-display"></div>
                                </div>

                                <input type="file" name="foto_kembali" id="foto_kembali" class="upload-input" accept="image/*" required onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-4">
                        <label class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea
                            name="catatan_kembali"
                            class="form-control"
                            rows="3"
                            placeholder="Contoh: Semua lancar jaya..."></textarea>
                    </div>

                    <hr class="border-white opacity-10 my-4">

                    <button type="submit" class="btn-submit mb-3">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                    </button>

                    <a href="{{ route('sewa.riwayat') }}" class="btn btn-link w-100 text-white-50 text-decoration-none small">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                    </a>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const wrapper = document.getElementById('upload-wrapper');
        const prompt = document.getElementById('upload-prompt');
        const previewContainer = document.getElementById('image-preview-container');
        const output = document.getElementById('output-image');
        const fileNameDisplay = document.getElementById('file-name-display');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                output.src = e.target.result;
                prompt.style.display = 'none'; // Sembunyikan icon awan
                previewContainer.style.display = 'block'; // Tampilkan gambar
                fileNameDisplay.textContent = input.files[0].name;
                wrapper.style.borderColor = 'var(--ps-success)';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            prompt.style.display = 'block';
            previewContainer.style.display = 'none';
            wrapper.style.borderColor = 'rgba(255, 255, 255, 0.2)';
        }
    }
</script>
@endsection