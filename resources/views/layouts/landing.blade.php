<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','PS RENT | Play Has No Limits')</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ps-blue: #00439c;
            --ps-accent: #00a2ff;
            --ps-dark: #02060f;
            --ps-card: rgba(255, 255, 255, 0.05);
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--ps-dark);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 10% 20%, rgba(0, 114, 206, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(0, 162, 255, 0.1) 0%, transparent 40%);
            z-index: -1;
        }

        /* ===== GLOSSY NAVBAR ===== */
        .ps-navbar {
            padding: 20px 60px;
            background: rgba(2, 6, 15, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: 0.4s;
        }

        .ps-navbar.scrolled {
            padding: 12px 60px;
            background: rgba(2, 6, 15, 0.95);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none !important;
        }

        .brand-logo i {
            font-size: 28px;
            background: linear-gradient(45deg, #00a2ff, #00439c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(0, 162, 255, 0.5));
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            font-size: 14px;
            margin: 0 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            text-decoration: none !important;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--ps-accent);
            text-shadow: 0 0 15px rgba(0, 162, 255, 0.6);
        }

        .btn-logout {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            font-size: 13px;
        }

        .btn-logout:hover {
            background: #ff3e3e;
            border-color: #ff3e3e;
            box-shadow: 0 0 20px rgba(255, 62, 62, 0.4);
            transform: translateY(-2px);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            padding: 160px 0 60px;
            text-align: center;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(to bottom, #fff 40%, rgba(255, 255, 255, 0.5));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        /* ===== MAIN CONTAINER SPACING ===== */
        /* Berikan jarak otomatis jika Hero Section tidak ada */
       .content-wrapper {
    padding-top: {{ (Request::is('/') || Request::is('products*')) && !Request::is('sewa*') ? '0px' : '140px' }};
}

        .main-container {
            background: var(--ps-card);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 30px;
            padding: 40px;
            backdrop-filter: blur(10px);
            margin-bottom: 50px;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: float 4s ease-in-out infinite;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--ps-blue);
            border-radius: 10px;
        }

        /* ===== NOTIFICATION ICON ===== */
        .notification-wrapper {
            position: relative;
            margin-right: 20px;
        }

        .notification-icon {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .notification-icon i {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            transition: 0.3s;
        }

        .notification-icon:hover {
            background: rgba(0, 162, 255, 0.15);
            box-shadow: 0 0 10px rgba(0, 162, 255, 0.4);
        }

        .notification-icon:hover i {
            color: #00a2ff;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ff3e3e;
            color: white;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 50px;
            font-weight: 700;
        }

        .notification-badge {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .dropdown-toggle::after {
            display: none !important;
        }
    </style>
</head>

<body>

    <nav class="ps-navbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="/" class="brand-logo">
                <i class="fab fa-playstation"></i>
                <span>PS<span style="font-weight: 300;">RENT</span></span>
            </a>

            <div class="ml-5 d-none d-lg-block">
                <a href="{{ route('products.index') }}" class="nav-link-custom {{ Request::is('products*') ? 'active' : '' }}">Sewa Game</a>
                <a href="{{ route('sewa.riwayat') }}" class="nav-link-custom {{ Request::is('riwayat*') ? 'active' : '' }}">Peminjaman Saya</a>
            </div>
        </div>

       <div class="d-flex align-items-center">

    @auth
        <!-- NOTIFICATION -->
        @if(!Request::is('sewa*'))
        <div class="notification-wrapper dropdown mr-3">

            <button class="notification-icon dropdown-toggle"
                id="notifBtn"
                data-toggle="dropdown">

                <i class="fas fa-bell"></i>

                @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="notification-badge">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-right p-3"
                style="width:300px; max-height:300px; overflow-y:auto;">

                <h6 class="mb-2">Notifikasi</h6>

             @forelse(auth()->user()->notifications()->latest()->take(10)->get() as $notif)
                <div class="mb-2 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                    {{ $notif->data['message'] }}
                    <br>
                    <small class="text-muted">
                        {{ $notif->created_at->diffForHumans() }}
                    </small>
                </div>
                @empty
                <div class="text-muted text-center">Tidak ada notifikasi</div>
                @endforelse

            </div>
        </div>
        @endif

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-logout">
                <i class="fas fa-power-off mr-2"></i> LOGOUT
            </button>
        </form>

    @else
        <!-- LOGIN -->
        <a href="{{ route('login') }}" class="btn btn-outline-light mr-2">
            Login
        </a>

        <!-- REGISTER -->
        <a href="{{ route('register') }}" class="btn btn-primary">
            Daftar
        </a>
    @endauth

</div>
    </nav>

    {{-- LOGIKA: Hero hanya muncul di halaman Katalog Produk --}}
    @if(Request::is('/') || (Request::is('products') && !Request::is('sewa*')))
    <section class="container hero-section">
        <div class="hero-badge floating">Next Generation Rental</div>
        <h1 class="hero-title">Experience More. <br> Pay Less.</h1>
        <p class="text-white-50 mx-auto" style="max-width: 600px; font-size: 18px;">
            Sewa konsol PlayStation terbaru dan mainkan judul game eksklusif favoritmu sekarang juga.
        </p>
    </section>
    @endif

    <main class="container content-wrapper">
        <div class="main-container">
            @yield('content')
        </div>
    </main>

    <script>
        window.onscroll = function() {
            var nav = document.querySelector('.ps-navbar');
            if (window.pageYOffset > 30) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        };

        let notifBtn = document.getElementById('notifBtn');

        if (notifBtn) {
            let notifClicked = false;

            notifBtn.addEventListener('click', function() {
                if (notifClicked) return;

                notifClicked = true;

                fetch("{{ route('notif.read') }}")
                    .then(res => res.json())
                    .then(() => {
                        let badge = document.querySelector('.notification-badge');
                        if (badge) badge.remove();
                    });
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>