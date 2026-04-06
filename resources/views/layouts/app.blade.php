<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        {{-- SIDEBAR (ADMIN + PETUGAS) --}}
        @auth
        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        @include('layouts.sidebar')
        @endif
        @endauth

        {{-- CONTENT --}}
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">



                {{-- PAGE CONTENT --}}
                <div class="container-fluid mt-4 px-4">
                    @yield('content')
                </div>

            </div>

            {{-- FOOTER --}}
            @include('layouts.footer')
        </div>

    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</body>

</html>