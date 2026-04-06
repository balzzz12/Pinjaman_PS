@extends('layouts.landing')
@section('title', 'Daftar Produk | PS RENT')

@section('content')
<style>
    /* 1. Header & Section Styling */
    .ps-section-header {
        margin-bottom: 40px;
        border-left: 5px solid var(--ps-accent);
        padding-left: 20px;
    }

    .section-title {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
        text-transform: uppercase;
    }

    /* 2. Kategori Konsol - Card Style */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 60px;
    }

    .cat-item {
        background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 25px 15px;
        border-radius: 20px;
        text-align: center;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
    }

    .cat-item:hover {
        background: rgba(0, 162, 255, 0.1);
        border-color: var(--ps-accent);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 162, 255, 0.15);
    }

    .cat-icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(0, 162, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
        color: var(--ps-accent);
        box-shadow: inset 0 0 15px rgba(0, 162, 255, 0.2);
    }

    /* 3. Product Card - Premium Layout */
    .product-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        transition: 0.4s;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .product-card:hover {
        border-color: var(--ps-accent);
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5), 0 0 20px rgba(0, 162, 255, 0.1);
    }

    /* Fixing Image Aspect Ratio */
    .ps-img-container {
        position: relative;
        padding: 25px;
        background: rgba(0, 0, 0, 0.25);
        height: 220px; /* Tinggi tetap agar sejajar */
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 12px;
        border-radius: 18px;
    }

    .ps-img-container img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 15px 25px rgba(0,0,0,0.6));
        transition: 0.5s;
    }

    .product-card:hover .ps-img-container img {
        transform: scale(1.1);
    }

    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
    }

    .badge-ready { background: #00d166; color: #fff; box-shadow: 0 4px 12px rgba(0, 209, 102, 0.3); }
    .badge-booked { background: #ff3e3e; color: #fff; box-shadow: 0 4px 12px rgba(255, 62, 62, 0.3); }

    /* Text Content Styling */
    .card-body-custom {
        padding: 10px 25px 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .category-pill {
        display: inline-block;
        background: rgba(0, 162, 255, 0.1);
        color: var(--ps-accent);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
    }

    .btn-sewa-premium {
        background: linear-gradient(45deg, #00439c, #00a2ff);
        border: none;
        color: white;
        font-weight: 800;
        border-radius: 15px;
        padding: 14px;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 14px;
    }

    .btn-sewa-premium:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 162, 255, 0.4);
        color: white;
    }

    .active-cat {
    background: rgba(0, 162, 255, 0.2) !important;
    border-color: var(--ps-accent) !important;
    box-shadow: 0 0 15px rgba(0,162,255,0.3);
}

.cat-item:active {
    transform: scale(0.95);
}

</style>

<div class="container-fluid px-lg-5">

    {{-- SECTION KATEGORI --}}
    <div class="ps-section-header">
        <h2 class="section-title">Kategori Konsol</h2>
        <p class="text-white-50">Pilih platform gaming generasi terbaru</p>
    </div>

    <div class="cat-grid">

        {{-- SEMUA KATEGORI --}}
        <a href="{{ route('products.index') }}"
           class="cat-item {{ request()->filled('category') ? '' : 'active-cat' }}">
            <div class="cat-icon-wrapper">
                <i class="fas fa-th-large"></i>
            </div>
            <div class="font-weight-bold text-white mb-1">Semua</div>
            <div class="small text-white-50">Lihat semua unit</div>
        </a>

        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}"
               class="cat-item {{ request('category') == $category->id ? 'active-cat' : '' }}">

                <div class="cat-icon-wrapper">
                    @php
                        $name = strtolower($category->name);
                    @endphp

                    @if(str_contains($name, 'stick'))
                        <i class="fas fa-gamepad"></i>
                    @elseif(str_contains($name, 'monitor'))
                        <i class="fas fa-desktop"></i>
                    @else
                        <i class="fab fa-playstation"></i>
                    @endif
                </div>

                <div class="font-weight-bold text-white mb-1">
                    {{ $category->name }}
                </div>

                <div class="small text-white-50">
                    {{ $category->playstations_count ?? 0 }} Unit Tersedia
                </div>
            </a>
        @endforeach

    </div>

    {{-- SECTION KATALOG --}}
    <div class="d-flex justify-content-between align-items-end mb-4 px-2">
        <div class="ps-section-header mb-0">
            <h2 class="section-title">Katalog Tersedia</h2>
            <p class="text-white-50 mb-0">Menampilkan semua unit siap main</p>
        </div>
    </div>

    <div class="row">
        @forelse($playstations as $ps)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-5">
                <div class="product-card">

                    {{-- IMAGE --}}
                    <div class="ps-img-container">
                        @if($ps->stok > 0)
                            <span class="status-badge badge-ready">Ready</span>
                        @else
                            <span class="status-badge badge-booked">Full Booked</span>
                        @endif

                        @if($ps->photo)
                            <img src="{{ asset('uploads/ps/'.$ps->photo) }}" alt="{{ $ps->nama }}">
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <i class="fas fa-box-open fa-3x text-white-50"></i>
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="card-body-custom">
                        <div>
                            <span class="category-pill">
                                {{ $ps->category->name ?? 'PS Console' }}
                            </span>

                            <h4 class="font-weight-bold mb-3">
                                {{ $ps->nama }}
                            </h4>
                        </div>

                        <div class="mt-auto">
                            <div class="mb-4">
                                <span class="text-white-50 small">Mulai dari</span>
                                <div class="price-value">
                                    <span style="color: var(--ps-accent); font-size: 1.1rem;">Rp</span>
                                    {{ number_format($ps->harga, 0, ',', '.') }}
                                    <span class="text-white-50" style="font-size: 0.9rem;">
                                        /jam
                                    </span>
                                </div>
                            </div>

                            @if($ps->stok > 0)
                                <a href="{{ route('sewa.create', $ps->id) }}"
                                   class="btn btn-sewa-premium btn-block">
                                    <i class="fas fa-bolt mr-2"></i> Sewa Sekarang
                                </a>
                            @else
                                <button class="btn btn-secondary btn-block py-3 disabled"
                                        disabled
                                        style="border-radius: 15px; opacity: 0.5;">
                                    <i class="fas fa-clock mr-2"></i> Sedang Disewa
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="main-container py-5" style="border-style: dashed;">
                    <i class="fas fa-search fa-3x mb-3 text-white-50"></i>
                    <h5 class="text-white-50">
                        Maaf, belum ada unit yang tersedia saat ini.
                    </h5>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection