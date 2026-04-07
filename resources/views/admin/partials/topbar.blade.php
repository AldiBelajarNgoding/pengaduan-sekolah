<!-- Topbar -->
<div class="topbar">
    <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
        <img src="{{ asset('images/logo-sigap.png') }}" alt="SI-GAP">
        <h4>SI-GAP</h4>
    </a>
    <div class="topbar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
        <span class="user-name">{{ Auth::user()->name ?? 'Admin Sekolah' }}</span>
    </div>
</div>

<style>
    .topbar {
        background: white;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 0;
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
        background: var(--cyan);
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
</style>
