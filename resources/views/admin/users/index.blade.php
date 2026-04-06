@extends('layouts.app')

@section('content')
<style>
    /* Content Styling agar match dengan Sidebar */
    .page-heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #003791;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .card-ps {
        border: none;
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden;
    }

    .card-ps .card-header {
        background: linear-gradient(135deg, #050b18 0%, #003791 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1.2rem;
    }

    /* Table Styling */
    .table-ps {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-ps thead th {
        background: transparent;
        color: #888;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border: none;
        padding-bottom: 15px;
    }

    .table-ps tbody tr {
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .table-ps tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        background-color: #f8f9ff;
    }

    .table-ps td {
        vertical-align: middle;
        border: none;
        padding: 1.2rem 0.75rem;
    }

    .table-ps td:first-child { border-radius: 10px 0 0 10px; }
    .table-ps td:last-child { border-radius: 0 10px 10px 0; }

    /* Badge Customization */
    .badge-ps {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    /* Button Action styling */
    .btn-action {
        border-radius: 8px;
        padding: 5px 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    
    .btn-edit-ps {
        background: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
        border: 1px solid #f6c23e;
    }
    
    .btn-edit-ps:hover {
        background: #f6c23e;
        color: #fff;
    }

    .btn-delete-ps {
        background: rgba(231, 74, 59, 0.1);
        color: #e74a3b;
        border: 1px solid #e74a3b;
    }

    .btn-delete-ps:hover {
        background: #e74a3b;
        color: #fff;
    }
</style>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 page-heading">User Management</h1>
        </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 10px;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-ps shadow">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span><i class="fas fa-users mr-2"></i> Daftar Pengguna Sistem</span>
        </div>
        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table table-ps">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Pengguna</th>
                            <th>Email Address</th>
                            <th>Role Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center font-weight-bold text-primary">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role_id == 1)
                                    <span class="badge badge-ps" style="background: rgba(231, 74, 59, 0.1); color: #e74a3b;">
                                        <i class="fas fa-user-shield mr-1"></i> Admin
                                    </span>
                                @elseif($user->role_id == 2)
                                    <span class="badge badge-ps" style="background: rgba(78, 115, 223, 0.1); color: #4e73df;">
                                        <i class="fas fa-user-check mr-1"></i> Petugas
                                    </span>
                                @else
                                    <span class="badge badge-ps" style="background: rgba(133, 135, 150, 0.1); color: #858796;">
                                        <i class="fas fa-user mr-1"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-action btn-edit-ps btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                            class="btn btn-action btn-delete-ps btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-user-slash fa-3x mb-3"></i>
                                <p>Belum ada data user yang terdaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection