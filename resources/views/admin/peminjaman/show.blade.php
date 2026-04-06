@extends('layouts.app')

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
        padding: 25px 35px;
        border: none;
    }

    .card-ps-header h3 {
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
        letter-spacing: 1px;
    }

    /* Section Headings */
    .section-title {
        font-weight: 800;
        color: #003791;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border-left: 4px solid #0070d1;
        padding-left: 15px;
        margin: 30px 0 20px 0;
    }

    /* Form & Data Styling */
    .form-group label {
        font-weight: 600;
        color: #5c7fec;
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .form-control-plaintext {
        background-color: #f8f9fc !important;
        border: 1.5px solid #e3e6f0 !important;
        border-radius: 15px !important;
        padding: 12px 20px !important;
        color: #4e5159 !important;
        font-weight: 500;
        min-height: 48px;
    }

    /* Badge for Status */
    .badge-ps {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .status-pending { background: #ffeeba; color: #856404; }
    .status-active { background: #d4edda; color: #155724; }

    /* Action Buttons */
    .btn-back {
        background-color: #eaecf4;
        border: none;
        border-radius: 15px;
        padding: 12px 30px;
        font-weight: 700;
        color: #4e5159;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-back:hover {
        background-color: #d1d3e2;
        color: #2e2f37;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-ps">
                <div class="card-ps-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-circle mr-3" style="font-size: 1.8rem;"></i>
                        <h3>Detail Data Penyewa</h3>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="section-title">Data Diri Penyewa</div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <div class="form-control-plaintext shadow-sm">
                                    {{ $peminjaman->user->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label>Nomor KTP</label>
                                <div class="form-control-plaintext shadow-sm">
                                    {{ $peminjaman->user->no_ktp ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label>WhatsApp / No. HP</label>
                                <div class="form-control-plaintext shadow-sm">
                                    {{ $peminjaman->user->hp ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label>Email Address</label>
                                <div class="form-control-plaintext shadow-sm">
                                    {{ $peminjaman->user->email ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <div class="form-control-plaintext shadow-sm" style="min-height: 100px;">
                                    {{ $peminjaman->user->alamat ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-title">Rincian Peminjaman</div>

                    <div class="row bg-light p-4 rounded-lg mx-1 shadow-sm border">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Kode Booking</small>
                            <span class="text-primary font-weight-bold">{{ $peminjaman->booking_code }}</span>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Unit PlayStation</small>
                            <span class="font-weight-bold">{{ $peminjaman->playstation->nama ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Durasi Sewa</small>
                            <span class="font-weight-bold">{{ $peminjaman->durasi }} Jam</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Status Pesanan</small>
                            <span class="badge badge-ps {{ $peminjaman->status == 'dipinjam' ? 'status-active' : 'status-pending' }}">
                                {{ $peminjaman->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <small class="text-muted">ID Peminjaman: #{{ $peminjaman->id }}</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection