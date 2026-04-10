@extends('layouts.app')

@section('content')

<style>
    /* 🎨 PLAYSTATION THEME VARIABLES */
    :root {
        --ps-navy: #050b18;
        --ps-blue-primary: #003791;
        --ps-blue-light: #0070d1;
        --ps-grad: linear-gradient(90deg, #050b18 0%, #003791 100%);
        --ps-grad-action: linear-gradient(45deg, #003791, #0070d1);
    }

    body {
        background-color: #f0f2f5;
    }

    /* 🔵 PAGE TITLE */
    .page-title {
        color: var(--ps-navy);
        font-weight: 800;
        position: relative;
        padding-bottom: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .page-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background: var(--ps-grad-action);
        border-radius: 10px;
    }

    /* 🗂️ CARD & LAYOUT */
    .ps-card {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 55, 145, 0.05);
        overflow: hidden;
    }

    .ps-card-header {
        background: rgba(0, 55, 145, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
        font-weight: 700;
        color: var(--ps-blue-primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* 🔍 FILTER BOX */
    .filter-wrapper {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        border: 1px solid #eef2f7;
    }

    .form-control-custom {
        border-radius: 10px !important;
        border: 1.5px solid #e2e8f0;
        padding: 0.6rem 1rem;
        transition: all 0.3s;
    }

    .form-control-custom:focus {
        border-color: var(--ps-blue-light);
        box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
    }

    /* 📊 TABLE STYLING */
    .ps-header-table {
        background: var(--ps-grad);
        color: #ffffff;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .ps-header-table th {
        border: none !important;
        padding: 1.2rem !important;
    }

    .table td {
        vertical-align: middle !important;
        padding: 15px;
        color: #4a5568;
        border-top: 1px solid #f0f2f5;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 112, 209, 0.02);
    }

    /* 🏷️ BADGE STYLES */
    .badge-ps {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .bg-admin { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; }
    .bg-petugas { background-color: rgba(54, 185, 204, 0.1); color: #36b9cc; }
    .bg-user { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    
    .badge-activity {
        background: var(--ps-blue-primary);
        color: white;
        font-size: 10px;
        padding: 4px 10px;
    }

    /* 🔵 BUTTONS & PAGINATION */
    .btn-ps-primary {
        background: var(--ps-grad-action);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-ps-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 55, 145, 0.2);
        color: white;
    }

    .pagination .page-link {
        border: none;
        margin: 0 3px;
        border-radius: 8px !important;
        color: var(--ps-blue-primary);
        font-weight: 600;
    }

    .page-item.active .page-link {
        background: var(--ps-grad-action);
        color: white;
    }
</style>

<div class="container-fluid px-4 py-4">
    <h3 class="page-title mb-4">Log Aktivitas Sistem</h3>

    <div class="card ps-card">
        <div class="ps-card-header">
            <span><i class="fas fa-history mr-2"></i> Riwayat Aktivitas</span>
            <span class="badge badge-pill badge-primary px-3 py-2" style="font-size: 10px;">
                TOTAL: {{ $logs->total() }} LOGS
            </span>
        </div>
        
        <div class="card-body p-4">
            
            {{-- 🔍 SEARCH & FILTER --}}
            <form method="GET" action="" class="filter-wrapper">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-muted text-uppercase">Cari Data</label>
                        <input type="text" name="search" class="form-control form-control-custom"
                            placeholder="Cari aktivitas atau nama user..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="small font-weight-bold text-muted text-uppercase">Filter Role</label>
                        <select name="role" class="form-control form-control-custom">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                            <option value="petugas" {{ request('role')=='petugas'?'selected':'' }}>Petugas</option>
                            <option value="peminjam" {{ request('role')=='peminjam'?'selected':'' }}>User</option>
                        </select>
                    </div>

                    <div class="col-md-5 d-flex">
                        <button type="submit" class="btn btn-ps-primary px-4 mr-2">
                            <i class="fas fa-filter mr-1"></i> FILTER
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-light px-4 border" style="border-radius:10px; font-weight:600;">
                            RESET
                        </a>
                    </div>
                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="ps-header-table text-center">
                        <tr>
                            <th width="50">NO</th>
                            <th class="text-left">USER</th>
                            <th>ROLE</th>
                            <th>AKTIVITAS</th>
                            <th class="text-left">DESKRIPSI</th>
                            <th class="text-right">WAKTU</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($logs as $log)
                        <tr>
                            <td class="text-muted font-weight-bold">{{ ($logs->currentPage()-1) * $logs->perPage() + $loop->iteration }}</td>
                            <td class="text-left">
                                <div class="font-weight-bold text-dark">{{ $log->user->name ?? 'System' }}</div>
                                <small class="text-muted">{{ $log->user->email ?? '' }}</small>
                            </td>
                            <td>
                                @php $role = $log->user->role->name ?? null; @endphp
                                @if($role == 'admin')
                                    <span class="badge-ps bg-admin">Admin</span>
                                @elseif($role == 'petugas')
                                    <span class="badge-ps bg-petugas">Petugas</span>
                                @elseif($role == 'peminjam')
                                    <span class="badge-ps bg-user">User</span>
                                @else
                                    <span class="badge badge-light text-muted border">None</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-pill badge-activity">{{ strtoupper($log->aktivitas) }}</span>
                            </td>
                            <td class="text-left">
                                <span class="small">{{ $log->deskripsi }}</span>
                            </td>
                            <td class="text-right">
                                <div class="small font-weight-bold text-dark">{{ optional($log->created_at)->format('d M Y') }}</div>
                                <small class="text-muted">{{ optional($log->created_at)->format('H:i') }} WIB</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/data-report.svg" style="width: 150px;" class="mb-3 opacity-50">
                                <p class="text-muted font-italic">Data log aktivitas tidak ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="small text-muted font-weight-bold">
                    Showing {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection