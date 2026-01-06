<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Valentine Website')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- DataTables + deps (CDN) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <!-- FixedColumns CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <!-- FixedColumns JS -->
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/plugin/utc.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/plugin/timezone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/plugin/relativeTime.js"></script>
    <script>
        dayjs.extend(window.dayjs_plugin_utc);
        dayjs.extend(window.dayjs_plugin_timezone);
        dayjs.extend(window.dayjs_plugin_relativeTime);

        // Set timezone globally
        dayjs.tz.setDefault("America/New_York"); // or your app timezone
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
            <div class="container">
                {{-- <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="/app">
                    <i class="bi bi-heart-fill me-1 text-white" style="font-size: 1.2rem;"></i>
                    <span style="font-weight: 700; color: #fff;">Valen</span><span style="font-weight: 400; color: #ffd6d6;">tine</span>
                </a> --}}
                <a class="navbar-brand d-flex align-items-center" href="/app">
                    <img src="{{ asset('images/logo.png') }}" alt="Valentines By Kids" height="80" class="me-2">
                </a>
                
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            @if(auth()->user()->is_admin)
                                <li class="nav-item d-flex align-items-center">
                                    <a class="nav-link fw-semibold d-flex align-items-center" href="{{ url('/admin/dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item d-flex align-items-center">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-white fw-semibold d-flex align-items-center" style="text-decoration: none;">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link fw-semibold d-flex align-items-center" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item d-flex align-items-center">
                                    <a class="nav-link fw-semibold d-flex align-items-center" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i> Register
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-fill container py-5">
        @yield('content')
    </main>
    <footer class="bg-danger text-white text-center py-4 mt-auto shadow-lg border-top border-light">
        <div class="container">
            <div class="mb-2 d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Valentines By Kids" height="80" class="me-2">
                <span class="fw-bold">Valentines By Kids</span>
            </div>
            <small>&copy; {{ date('Y') }} All rights reserved.</small>            
        </div>
    </footer>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>
</html>