<div class="sidebar">
    <ul class="sidebar-menu">
        <li class="menu-label">Main</li>
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>
        </li>

        <li class="menu-label">Kelola Data</li>
        <li>
            <a href="{{ route('admin.aspirasi.index') }}"
               class="{{ request()->routeIs('admin.aspirasi.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i>Aspirasi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kategori.index') }}"
               class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i>Kategori
            </a>
        </li>
        <li>
            <a href="{{ route('admin.siswa.index') }}"
               class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>Data Siswa
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

<style>
    .sidebar { position:fixed; left:0; top:67px; width:240px; height:calc(100vh - 67px); background:white; padding:1.5rem 0; border-right:1px solid #e1e8ed; overflow-y:auto; }
    .sidebar-menu { list-style:none; padding:0; margin:0; }
    .menu-label { padding:0.5rem 1.5rem; color:#94a3b8; font-size:0.72rem; text-transform:uppercase; font-weight:600; letter-spacing:0.5px; margin-top:0.5rem; }
    .sidebar-menu a { display:flex; align-items:center; padding:0.75rem 1.5rem; color:#6c757d; text-decoration:none; transition:all 0.2s; font-size:0.9rem; }
    .sidebar-menu a i { margin-right:0.75rem; font-size:1.1rem; width:20px; }
    .sidebar-menu a:hover { background:rgba(0,168,204,0.08); color:var(--cyan); }
    .sidebar-menu a.active { background:rgba(0,168,204,0.1); color:var(--cyan); border-left:3px solid var(--cyan); font-weight:500; }
    .sidebar-menu a.logout-btn { color:#ef4444; }
    .sidebar-menu a.logout-btn:hover { background:rgba(239,68,68,0.08); color:#dc2626; }
</style>
