<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SI-GAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #1e3a5f;
            --cyan: #00a8cc;
            --orange: #ff9933;
            --light-bg: #f5f7fa;
            --text-dark: #2c3e50;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-bg);
            color: var(--text-dark);
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--navy);
            text-decoration: none;
        }

        .topbar-brand img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }

        .topbar-brand h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-name {
            color: var(--text-dark);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 67px;
            width: 240px;
            height: calc(100vh - 67px);
            background: white;
            padding: 1.5rem 0;
            border-right: 1px solid #e1e8ed;
            overflow-y: auto;
        }

        .sidebar-menu { list-style: none; padding: 0; }

        .menu-label {
            padding: 0.5rem 1.5rem;
            color: #94a3b8;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .sidebar-menu a i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 153, 51, 0.08);
            color: var(--orange);
        }

        .sidebar-menu a.active {
            background: rgba(255, 153, 51, 0.1);
            color: var(--orange);
            border-left: 3px solid var(--orange);
            font-weight: 500;
        }

        .sidebar-menu a.logout-btn { color: #ef4444; }
        .sidebar-menu a.logout-btn:hover {
            background: rgba(239, 68, 68, 0.08);
            color: #dc2626;
        }

        /* MAIN CONTENT */
        .main-content {
            position: relative;
            z-index: 1;
            margin-left: 240px;
            margin-top: 67px;
            padding: 2rem;
            min-height: calc(100vh - 67px);
        }

        /* ALERTS */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Topbar -->
    <div class="topbar">
        <a href="{{ route('siswa.dashboard') }}" class="topbar-brand">
            <img src="{{ asset('images/logo-sigap.png') }}" alt="SI-GAP">
            <h4>SI-GAP</h4>
        </a>
        <div class="topbar-user">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}</div>
            <span class="user-name">{{ Auth::user()->name }}</span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="menu-label">Menu</li>
            <li>
                <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.aspirasi.index') }}" class="{{ request()->routeIs('siswa.aspirasi.index') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>Riwayat Pengaduan
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.aspirasi.create') }}" class="{{ request()->routeIs('siswa.aspirasi.create', 'siswa.aspirasi.store') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>Buat Pengaduan
                </a>
            </li>
            <li class="menu-label">Akun</li>
            <li>
                <a href="#" class="logout-btn" onclick="openLogoutModal(event)">
                    <i class="bi bi-box-arrow-right"></i>Keluar
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="bi bi-x-circle"></i> {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <i class="bi bi-x-circle"></i>
            <ul style="margin:0; padding-left:1.5rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </div>

    @yield('modals')

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-box-header">
                <h3><i class="bi bi-box-arrow-right" style="color:#ef4444"></i> Konfirmasi Keluar</h3>
            </div>
            <div class="modal-box-body">
                <p>Apakah kamu yakin ingin keluar dari sistem?</p>
            </div>
            <div class="modal-box-footer">
                <button class="btn-batal" onclick="closeLogoutModal()">Batal</button>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-keluar">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            display: none;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 999999 !important;
            transform: translateZ(9999px) !important;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box { position: relative !important; z-index: 1000000 !important; transform: translateZ(10000px) !important; background: white; border-radius: 12px; width: 90%; max-width: 400px; overflow: hidden; }
        .modal-box-header { padding: 1.5rem; border-bottom: 1px solid #e1e8ed; }
        .modal-box-header h3 { margin: 0; font-size: 1.1rem; font-weight: 600; color: var(--navy); display: flex; align-items: center; gap: 0.75rem; }
        .modal-box-body { padding: 1.5rem; }
        .modal-box-body p { margin: 0; color: #6c757d; }
        .modal-box-footer { padding: 1.5rem; border-top: 1px solid #e1e8ed; display: flex; gap: 1rem; justify-content: flex-end; }
        .btn-batal { padding: 0.6rem 1.5rem; border-radius: 8px; border: 1px solid #e1e8ed; background: white; color: var(--text-dark); font-weight: 500; cursor: pointer; }
        .btn-batal:hover { background: #f3f4f6; }
        .btn-keluar { padding: 0.6rem 1.5rem; border-radius: 8px; border: none; background: #ef4444; color: white; font-weight: 500; cursor: pointer; }
        .btn-keluar:hover { background: #dc2626; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openLogoutModal(e) { e.preventDefault(); document.getElementById('logoutModal').classList.add('show'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.remove('show'); }
        window.onclick = function(e) {
            const m = document.getElementById('logoutModal');
            if (e.target === m) closeLogoutModal();
        }
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(a => {
                a.style.transition = 'opacity 0.5s';
                a.style.opacity = '0';
                setTimeout(() => a.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
