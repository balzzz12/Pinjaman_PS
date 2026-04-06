@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f2f5;
    }

    .page-title {
        color: #050b18;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        position: relative;
        padding-bottom: 10px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, #003791, #0070d1);
        border-radius: 10px;
    }

    .ps-card {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 55, 145, 0.05);
    }

    .ps-card-header {
        background: linear-gradient(90deg, #050b18 0%, #003791 100%);
        color: #ffffff;
        padding: 1.25rem;
        border-radius: 20px 20px 0 0;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .form-group label {
        font-weight: 700;
        color: #4a5568;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #0070d1;
        box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
    }

    .photo-preview-container {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
    }

    .current-photo {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-ps-update {
        background: linear-gradient(45deg, #003791, #0070d1);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 12px 25px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0, 55, 145, 0.2);
    }

    .btn-ps-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 55, 145, 0.3);
        color: white;
    }

    .btn-ps-back {
        background: #edf2f7;
        color: #4a5568;
        border: none;
        font-weight: 600;
        border-radius: 12px;
        padding: 12px 25px;
        transition: 0.3s;
    }

    .btn-ps-back:hover {
        background: #e2e8f0;
        color: #2d3748;
    }
</style>

<div class="container-fluid px-4 py-4">
    <h3 class="page-title mb-4">Edit PlayStation</h3>

    <div class="card ps-card shadow-sm">
        <div class="ps-card-header">
            <i class="fas fa-edit mr-2"></i> Perbarui Data Unit: {{ $ps->nama }}
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.playstation.update', $ps->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-lg-8">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Nama PlayStation</label>
                                    <input type="text" name="nama" value="{{ $ps->nama }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $ps->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label>Harga / Jam</label>
                                    <input type="number" name="harga" value="{{ $ps->harga }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stok" value="{{ $ps->stok }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="tersedia" {{ $ps->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="disewa" {{ $ps->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mt-3">
                            <label>Ganti Foto</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Ganti Video</label>
                            <input type="file" name="video" class="form-control">
                            <small class="text-muted">Format: mp4, mov</small>
                        </div>


                        <div class="form-group mt-3">
                            <label>Deskripsi Unit</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Contoh: PS4 Slim, 2 stik DualShock, TV 43 inch, ruang AC nyaman">{{ $ps->deskripsi }}</textarea>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-ps-update">
                                <i class="fas fa-sync-alt mr-2"></i> PERBARUI
                            </button>

                            <a href="{{ route('admin.playstation.index') }}" class="btn btn-ps-back ml-2">
                                KEMBALI
                            </a>
                        </div>

                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">

                        <div class="form-group">
                            <label>Foto Saat Ini</label>
                            <div class="photo-preview-container">

                                @if($ps->photo)
                                <img src="{{ asset('uploads/ps/'.$ps->photo) }}" class="current-photo mb-3">
                                @else
                                <p class="text-muted">Tidak ada foto</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label>Video Saat Ini</label>
                            <div class="photo-preview-container">

                                @if($ps->video)

                                <video width="100%" controls style="border-radius:12px;">
                                    <source src="{{ asset('uploads/video/'.$ps->video) }}" type="video/mp4">
                                </video>

                                @else
                                <p class="text-muted">Tidak ada video</p>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection