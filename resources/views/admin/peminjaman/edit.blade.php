@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fc;
        font-family: 'Poppins', sans-serif;
    }

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
    }

    .card-ps-header h2 {
        font-weight: 700;
        margin: 0;
        font-size: 1.6rem;
        display: flex;
        align-items: center;
    }

    .form-label {
        font-weight: 800;
        color: #5c7fec;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .form-control, .form-select {
        border-radius: 15px;
        padding: 12px 20px;
        border: 1.5px solid #e3e6f0;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
    }

    .form-control-readonly {
        background-color: #f8f9fc !important;
        border: 1.5px dashed #d1d3e2 !important;
        color: #b7b9cc !important;
    }

    .input-group .form-control {
        border-radius: 15px 0 0 15px;
        border-right: none;
    }

    .input-group-text {
        border-radius: 0 15px 15px 0;
        background-color: #f8f9fc;
        border: 1.5px solid #e3e6f0;
    }

    .btn-update {
        background-color: #0056b3;
        border: none;
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 700;
        color: white;
    }

    .btn-back {
        background-color: #eaecf4;
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 700;
        color: #4e5159;
        margin-right: 15px;
        text-decoration: none;
    }

    .btn-back:hover { background-color: #dddfeb; }
    .btn-update:hover { background-color: #004494; }

    .small-info {
        font-size: 0.75rem;
        color: #a3a6b5;
        margin-top: 5px;
        font-style: italic;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card card-ps">

                <div class="card-ps-header">
                    <h2>
                        <i class="fas fa-edit mr-3"></i>
                        Edit Peminjaman
                    </h2>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('admin.peminjaman.update', $sewa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- USER -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">User / Pelanggan</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $sewa->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PLAYSTATION -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Unit PlayStation</label>
                                <select name="playstation_id" class="form-select" required>
                                    @foreach($playstations as $ps)
                                        <option value="{{ $ps->id }}"
                                            {{ old('playstation_id', $sewa->playstation_id) == $ps->id ? 'selected' : '' }}>
                                            {{ $ps->nama ?? $ps->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- DURASI -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Durasi (Jam)</label>
                                <div class="input-group">
                                    <input type="number"
                                           name="durasi"
                                           min="1"
                                           value="{{ old('durasi', $sewa->durasi) }}"
                                           class="form-control"
                                           required>
                                    <span class="input-group-text">Jam</span>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Status Saat Ini</label>
                                <input type="text"
                                       class="form-control form-control-readonly"
                                       value="{{ ucfirst(str_replace('_',' ', $sewa->status)) }}"
                                       readonly>
                                <div class="small-info">
                                    *Status hanya bisa diubah melalui menu konfirmasi
                                </div>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection