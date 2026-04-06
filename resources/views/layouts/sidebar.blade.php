<style>
    /* 1. Global Sidebar Styling */
    .bg-ps-gradient {
        background: linear-gradient(180deg, #050b18 0%, #003791 100%) !important;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.3);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* 2. Brand & Logo */
    .sidebar-brand-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 800 !important;
        letter-spacing: 2px;
        background: linear-gradient(45deg, #fff 30%, #a5c9fd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .fa-playstation {
        filter: drop-shadow(0 0 8px rgba(255,255,255,0.4));
        animation: logo-glow 3s ease-in-out infinite;
    }

    /* 3. Navigation Links */
    .sidebar-dark .nav-item .nav-link {
        font-family: 'Poppins', sans-serif;
        margin: 4px 14px;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: rgba(255, 255, 255, 0.6) !important;
    }

    .sidebar-dark .nav-item .nav-link i {
        font-size: 0.95rem;
        margin-right: 0.75rem;
        transition: 0.3s;
    }

    /* Hover State */
    .sidebar-dark .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff !important;
        transform: translateX(5px);
    }

    /* Active State (Glassmorphism) */
    .sidebar-dark .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(8px);
        color: #fff !important;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border-left: 3px solid #0070d1;
    }

    /* 4. Headings */
    .sidebar-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 0.65rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.3) !important;
        margin-top: 1.5rem !important;
        padding-left: 1.8rem !important;
    }

    /* 5. Logout Button Premium */
    .btn-logout-ps {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .btn-logout-ps:hover {
        background: linear-gradient(45deg, #e74a3b, #b91d1d);
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(231, 74, 59, 0.3);
        transform: translateY(-2px);
    }

    /* 6. Animations */
    @keyframes logo-glow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
    }

    /* Custom Scrollbar for Sidebar */
    #accordionSidebar::-webkit-scrollbar {
        width: 4px;
    }
    #accordionSidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }
</style>

@php
    $dashboardRoute = auth()->user()->role->name === 'admin'
        ? 'admin.dashboard'
        : 'petugas.dashboard';
@endphp

<ul class="navbar-nav bg-ps-gradient sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center my-4" href="{{ route($dashboardRoute) }}">
        <div class="sidebar-brand-icon">
            <i class="fab fa-playstation" style="font-size: 2rem;"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PS RENT</div>
    </a>

    <hr class="sidebar-divider my-0" style="opacity: 0.05;">

  {{-- DASHBOARD --}}
<li class="nav-item {{ Route::is($dashboardRoute) ? 'active' : '' }} mt-3">
    <a class="nav-link" href="{{ route($dashboardRoute) }}">
        <i class="fas fa-fw fa-columns"></i>
        <span>Dashboard</span>
    </a>
</li>

    <hr class="sidebar-divider" style="opacity: 0.05;">

    {{-- ================= ADMIN ================= --}}
   @if(auth()->user()->role->name === 'admin')

    <div class="sidebar-heading">Admin Panel</div>

    <li class="nav-item {{ Route::is('categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-th-list"></i>
            <span>Kategori</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('playstation.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.playstation.index') }}">
            <i class="fas fa-fw fa-gamepad"></i>
            <span>Produk</span>
        </a>
    </li>

   <li class="nav-item {{ Route::is('admin.users.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.users.index') }}">
        <i class="fas fa-fw fa-user-shield"></i>
        <span>User Management</span>
    </a>
</li>

    {{-- FIXED ROUTE --}}
    <li class="nav-item {{ Route::is('admin.peminjaman') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Data Peminjaman</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('admin.pengembalian') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengembalian') }}">
            <i class="fas fa-fw fa-archive"></i>
            <span>Data Pengembalian</span>
        </a>
    </li>

    @endif


    {{-- ================= PETUGAS ================= --}}
   @if(auth()->user()->role->name === 'petugas')

    <div class="sidebar-heading">Petugas Panel</div>

    <li class="nav-item {{ Route::is('peminjaman.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.peminjaman.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Konfirmasi Peminjaman</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('pengembalian.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('petugas.pengembalian.index') }}">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Konfirmasi Pengembalian</span>
        </a>
    </li>

    @endif

    <hr class="sidebar-divider d-none d-md-block mt-4" style="opacity: 0.05;">

    {{-- LOGOUT --}}
    <li class="nav-item px-3 mb-4 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-logout-ps btn-block py-2 shadow-sm text-white">
                <i class="fas fa-power-off mr-2"></i>
                LOGOUT
            </button>
        </form>
    </li>

</ul>