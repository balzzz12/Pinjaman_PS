@extends('layouts.app')

@section('content')
<style>
    .page-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #003791;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .card-ps {
        border: none;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    .card-header-ps {
        background: linear-gradient(135deg, #050b18 0%, #003791 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .form-label-ps {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #334155;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control-ps {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control-ps:focus {
        border-color: #0070d1;
        box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
        background-color: #fff;
    }

    .btn-update-ps {
        background: linear-gradient(45deg, #0070d1, #003791);
        border: none;
        border-radius: 12px;
        padding: 10px 25px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-update-ps:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 112, 209, 0.3);
        color: white;
    }

    .btn-back-ps {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 12px;
        padding: 10px 25px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-back-ps:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .input-group-text-ps {
        background: transparent;
        border-right: none;
        color: #94a3b8;
    }
.form-select.form-control-ps {
    border-radius: 12px;
    padding: 12px 15px;
    border: 2px solid #e2e8f0;
    background-color: #f8fafc;
    height: 48px;
}

.form-select.form-control-ps:focus {
    border-color: #0070d1;
    box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
    background-color: #fff;
}
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-back-ps mr-3 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h3 mb-0 page-heading">Edit Profil User</h1>
            </div>

            <div class="card card-ps overflow-hidden">
                <div class="card-header card-header-ps">
                    <div class="d-flex align-items-center">
                        <div class="bg-white-50 rounded-circle p-2 mr-3" style="background: rgba(255,255,255,0.1)">
                            <i class="fas fa-user-edit text-white fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold">Informasi Akun</h5>
                            <small class="text-white-50">Perbarui data login dan peran pengguna</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label-ps">Nama Lengkap</label>
                                <div class="input-group">
                                    <input type="text" name="name" 
                                           class="form-control form-control-ps @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required
                                           placeholder="Masukkan nama lengkap">
                                </div>
                                @error('name')
                                    <small class="text-danger mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label-ps">Alamat Email</label>
                                <input type="email" name="email" 
                                       class="form-control form-control-ps @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required
                                       placeholder="email@contoh.com">
                                @error('email')
                                    <small class="text-danger mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label-ps">Password Baru <span class="text-muted font-weight-normal">(Opsional)</span></label>
                                <input type="password" name="password" 
                                       class="form-control form-control-ps"
                                       placeholder="••••••••">
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah kata sandi.
                                    </small>
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label-ps">Role Akses</label>
                              <select name="role" class="form-select form-control-ps shadow-none" required>
                                    <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin (Full Access)</option>
                                    <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Petugas (Operator)</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-back-ps mr-2">Batal</a>
                            <button type="submit" class="btn btn-update-ps shadow">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection