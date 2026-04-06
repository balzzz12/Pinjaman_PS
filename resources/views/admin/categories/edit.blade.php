@extends('layouts.app')

@section('content')
<style>
    /* Styling agar senada dengan login & index */
    .ps-card-edit {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 500px;
        margin: auto;
    }
    .ps-header-edit {
        background: linear-gradient(45deg, #003791, #0070d1);
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        font-weight: 700;
    }
    .btn-ps-update {
        background-color: #003791;
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 25px;
        transition: 0.3s;
    }
    .btn-ps-update:hover {
        background-color: #002d75;
        color: white;
        transform: translateY(-2px);
    }
    .btn-ps-back {
        background-color: #f4f7f9;
        color: #666;
        border: none;
        font-weight: 600;
        padding: 10px 25px;
    }
    .btn-ps-back:hover {
        background-color: #e2e8f0;
        color: #333;
    }
    .form-label {
        color: #003791;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid py-5">
    <div class="card ps-card-edit">
        <div class="ps-header-edit text-center">
            <i class="fas fa-edit mb-2 fa-2x"></i>
            <h4 class="mb-0">Edit Kategori</h4>
        </div>

        <div class="card-body p-4">
            {{-- Pesan Error --}}
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-left: 5px solid #e74a3b;">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Nama Kategori</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control form-control-lg @error('name') is-invalid @enderror" 
                        placeholder="Ubah nama kategori..."
                        value="{{ old('name', $category->name) }}" 
                        required
                        autofocus
                    >
                    <small class="text-muted">Pastikan nama kategori belum digunakan sebelumnya.</small>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-ps-back shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-ps-update shadow">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection