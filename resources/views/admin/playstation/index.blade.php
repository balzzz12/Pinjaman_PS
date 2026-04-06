@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Global Page Styling */
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

    /* Card Styling */
    .ps-card {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 55, 145, 0.05);
        margin-bottom: 1.5rem;
    }

    /* Form Design */
    .ps-form-header {
        background: rgba(0, 55, 145, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
        border-radius: 20px 20px 0 0;
        font-weight: 700;
        color: #003791;
    }

    .form-control {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 0.6rem 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #0070d1;
        box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
    }

    /* Table Styling */
    .ps-header-table {
        background: linear-gradient(90deg, #050b18 0%, #003791 100%);
        color: #ffffff;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .ps-header-table th {
        border: none !important;
        padding: 1.2rem !important;
    }

    /* Photo Thumbnail */
    .ps-img-preview {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .ps-img-preview:hover {
        transform: scale(1.5);
        z-index: 10;
        position: relative;
    }

    /* Custom Badges */
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }

    .bg-tersedia {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    .bg-disewa {
        background-color: rgba(231, 74, 59, 0.1);
        color: #e74a3b;
    }

    /* Buttons */
    .btn-ps-primary {
        background: linear-gradient(45deg, #003791, #0070d1);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 10px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px;
        border: none;
    }

    .deskripsi-text {
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container-fluid px-4 py-4">
    <h3 class="page-title mb-4">Data PlayStation</h3>

    {{-- Success Alert --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false,
            iconColor: '#003791'
        });
    </script>
    @endif

    {{-- FORM TAMBAH --}}
    <div class="card ps-card shadow-sm">
        <div class="ps-form-header">
            <i class="fas fa-plus-circle mr-2"></i> Tambah PlayStation Baru
        </div>
        <div class="card-body">
            <form action="{{ route('admin.playstation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-end">
                    <div class="col-xl-2 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">NAMA UNIT</label>
                        <input type="text" name="nama" class="form-control" placeholder="PS5-01" required>
                    </div>
                    <div class="col-xl-2 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">KATEGORI</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">HARGA / JAM</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-light border-0 small">Rp</span></div>
                            <input type="number" name="harga" class="form-control" placeholder="10000" required>
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">STOK</label>
                        <input type="number" name="stok" class="form-control" placeholder="0" required>
                    </div>
                    <div class="col-xl-3 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">FOTO UNIT</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" style="padding: 5px;">
                    </div>
                    <div class="col-xl-3 col-md-4 mb-3">
                        <label class="small font-weight-bold text-muted">VIDEO UNIT</label>
                        <input type="file" name="video" class="form-control">
                    </div>
                    <div class="col-xl-4 col-md-12 mb-3">
                        <label class="small font-weight-bold text-muted">DESKRIPSI UNIT</label>
                        <textarea name="deskripsi" class="form-control" rows="2" placeholder="Contoh: PS5 DualSense, 2 stik, TV 50 inch, ruang AC"></textarea>
                    </div>
                    <div class="col-xl-2 col-md-4 mb-3">
                        <button class="btn btn-ps-primary btn-block py-2">
                            <i class="fas fa-save mr-2"></i> SIMPAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="card ps-card overflow-hidden shadow-sm">
        <div class="ps-form-header border-0 d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list mr-2"></i> Inventaris Unit</span>
            <span class="badge badge-pill badge-primary px-3 py-2" style="font-size: 10px;">TOTAL: {{ count($data) }} UNIT</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="ps-header-table text-center">
                        <tr>
                            <th width="50">NO</th>
                            <th>FOTO</th>
                            <th class="text-left">NAMA UNIT</th>
                            <th>KATEGORI</th>
                            <th>DESKRIPSI</th>
                            <th>HARGA/JAM</th>
                            <th>STOK</th>
                            <th>STATUS</th>
                            <th width="120">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                        @foreach($data as $ps)
                        <tr>
                            <td class="text-muted font-weight-bold">{{ $loop->iteration }}</td>
                            <td>
                                @if($ps->photo)
                                <img src="{{ asset('uploads/ps/'.$ps->photo) }}" class="ps-img-preview">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center m-auto" style="width:60px; height:60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td class="text-left">
                                <span class="font-weight-bold text-dark">{{ $ps->nama }}</span>
                            </td>
                            <td>
                                <span class="badge badge-light border px-2 py-1">
                                    {{ $ps->category->name }}
                                </span>
                            </td>

                            <td class="text-left">
                                <small class="text-muted deskripsi-text" title="{{ $ps->deskripsi }}">
                                    {{ \Illuminate\Support\Str::limit($ps->deskripsi, 40, '...') ?? '-' }}
                                </small>
                            </td>

                            <td class="font-weight-bold text-primary">
                                Rp {{ number_format($ps->harga) }}
                            </td>
                            <td><span class="font-weight-bold">{{ $ps->stok }}</span></td>
                            <td>
                                <span class="badge-status {{ $ps->status == 'tersedia' ? 'bg-tersedia' : 'bg-disewa' }}">
                                    <i class="fas fa-circle mr-1" style="font-size: 7px;"></i>
                                    {{ strtoupper($ps->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.playstation.edit', $ps->id) }}"
                                        class="btn-action shadow-sm mr-2" style="background: #fff3cd; color: #856404;" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.playstation.destroy', $ps->id) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action shadow-sm btn-delete-confirm"
                                            style="background: #f8d7da; color: #721c24;" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // SweetAlert Konfirmasi Hapus
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Unit?',
                text: "Data PlayStation ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#003791',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection