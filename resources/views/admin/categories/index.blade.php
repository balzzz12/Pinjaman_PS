@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Global Background untuk Page agar matching dengan Sidebar */
    body {
        background-color: #f0f2f5;
    }

    /* Page Title Customization */
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

    /* Card Styling - Glassmorphism Light Version */
    .ps-card {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 55, 145, 0.05);
        transition: transform 0.3s ease;
    }
    .ps-card:hover {
        transform: translateY(-5px);
    }

    /* Header Table ala PlayStation */
    .ps-header-table {
        background: linear-gradient(90deg, #050b18 0%, #003791 100%);
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    .ps-header-table th {
        border: none !important;
        padding: 1.2rem !important;
    }

    /* Button Customization */
    .btn-ps-primary {
        background: linear-gradient(45deg, #003791, #0070d1);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 55, 145, 0.2);
    }
    .btn-ps-primary:hover {
        background: linear-gradient(45deg, #0070d1, #003791);
        color: white;
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 55, 145, 0.3);
    }

    /* Table Decoration */
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 112, 209, 0.02);
    }
    .category-name {
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
    }

    /* Form Styling */
    .form-control {
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #0070d1;
        box-shadow: 0 0 0 4px rgba(0, 112, 209, 0.1);
    }

    /* Action Buttons */
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin: 0 2px;
        transition: 0.3s;
        border: none;
    }
    .btn-edit { background: #fff3cd; color: #856404; }
    .btn-edit:hover { background: #ffeeba; color: #856404; transform: rotate(15deg); }
    .btn-delete-ui { background: #f8d7da; color: #721c24; }
    .btn-delete-ui:hover { background: #f5c6cb; color: #721c24; transform: rotate(-15deg); }

</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <h3 class="page-title">Manajemen Kategori</h3>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                borderRadius: '20px',
                iconColor: '#003791'
            });
        </script>
    @endif

    <div class="row">
        {{-- Form Tambah --}}
        <div class="col-lg-4 mb-4">
            <div class="card ps-card p-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="mr-3" style="width: 40px; height: 40px; background: rgba(0,55,145,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-layer-group" style="color: #003791;"></i>
                        </div>
                        <h5 class="m-0" style="font-weight: 700; color: #050b18;">Tambah Kategori</h5>
                    </div>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small font-weight-bold text-muted">NAMA KATEGORI</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Misal: PlayStation 5"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-ps-primary btn-block mt-4">
                            <i class="fas fa-save mr-2"></i> SIMPAN DATA
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="col-lg-8">
            <div class="card ps-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="ps-header-table text-center">
                                <tr>
                                    <th width="100">NO</th>
                                    <th class="text-left">NAMA KATEGORI</th>
                                    <th width="180">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($categories as $key => $category)
                                    <tr>
                                        <td class="text-muted font-weight-bold">{{ $key + 1 }}</td>
                                        <td class="text-left py-3">
                                            <span class="category-name">{{ $category->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                   class="btn-action btn-edit"
                                                   title="Edit Data">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                      method="POST"
                                                      class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action btn-delete-ui btn-delete-confirm" title="Hapus Data">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/white/search-result-not-found.svg" style="width: 150px; opacity: 0.5;">
                                            <p class="mt-3 text-muted">Belum ada kategori yang ditambahkan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfirmasi Hapus SweetAlert
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#003791',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '20px',
                background: '#ffffff',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection