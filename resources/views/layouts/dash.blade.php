<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Nakamart</title>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background-color: #fdfdfd;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            background: #f8f9fa;
            padding-top: 60px;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            padding-top: 80px;
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-link {
            color: #2c3e50;
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #0d6efd;
            background-color: #e7f1ff;
            border-radius: 8px;
        }

        .nav-link i {
            margin-right: 6px;
        }

        li.nav-item {
            list-style: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Naka-Mart</a>
            <li class="nav-item mb-2">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-decoration-none">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </div>
    </nav>

    <div class="sidebar border-end">
        <ul class="nav flex-column px-3">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            @if (auth()->user()->hasRole('admin'))
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('produk*') ? 'active' : '' }}" href="{{ url('produk') }}">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="{{ url('kategori') }}">
                        <i class="bi bi-tags"></i> Kategori
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ url('details') }}">
                        <i class="bi bi-bar-chart-line"></i>Produk Details
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')

</body>

</html>
