@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ Auth::user()->name }}</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon cyan"><i class="bi bi-inbox"></i></div>
        <div class="stat-info">
            <h3>{{ $total }}</h3>
            <p>Total Aspirasi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="bi bi-clock-history"></i></div>
        <div class="stat-info">
            <h3>{{ $baru }}</h3>
            <p>Perlu Review</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon navy"><i class="bi bi-arrow-repeat"></i></div>
        <div class="stat-info">
            <h3>{{ $diproses }}</h3>
            <p>Diproses</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
            <h3>{{ $selesai }}</h3>
            <p>Selesai</p>
        </div>
    </div>
</div>

<!-- Aspirasi Terbaru -->
<div class="recent-section">
    <div class="section-header">
        <h5><i class="bi bi-clock-history me-2"></i>Aspirasi Terbaru</h5>
        <a href="{{ route('admin.aspirasi.index') }}" class="view-all">Lihat Semua →</a>
    </div>

    @forelse($recent as $aspirasi)
    <div class="aspirasi-row">
        <div class="aspirasi-left">
            <span class="tag-kategori">{{ ucfirst($aspirasi->kategori) }}</span>
            <div class="aspirasi-judul">{{ $aspirasi->judul }}</div>
            <div class="aspirasi-meta">
                <i class="bi bi-person"></i> {{ $aspirasi->pelapor->name ?? '-' }}
                &nbsp;·&nbsp;
                <i class="bi bi-calendar3"></i> {{ $aspirasi->created_at->format('d M Y') }}
            </div>
        </div>
        <div class="aspirasi-right">
            <span class="badge-status badge-{{ $aspirasi->status }}">{{ ucfirst($aspirasi->status) }}</span>
            <a href="{{ route('admin.aspirasi.show', $aspirasi->id) }}" class="btn-detail">
                <i class="bi bi-eye"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Belum ada aspirasi yang masuk</p>
    </div>
    @endforelse
</div>

@endsection

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: var(--navy); margin: 0 0 0.2rem; }
    .page-subtitle { color: #6c757d; font-size: 0.9rem; margin: 0; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white; padding: 1.5rem; border-radius: 12px;
        border: 1px solid #e1e8ed; display: flex; align-items: center; gap: 1rem;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.07); }

    .stat-icon {
        width: 52px; height: 52px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: white; flex-shrink: 0;
    }
    .stat-icon.cyan   { background: #00a8cc; }
    .stat-icon.orange { background: #ff9933; }
    .stat-icon.navy   { background: #1e3a5f; }
    .stat-icon.green  { background: #10b981; }

    .stat-info h3 { font-size: 1.9rem; font-weight: 700; color: var(--navy); margin: 0; line-height: 1; }
    .stat-info p  { font-size: 0.82rem; color: #6c757d; margin: 0.3rem 0 0; }

    .recent-section {
        background: white; padding: 1.5rem;
        border-radius: 12px; border: 1px solid #e1e8ed;
    }

    .section-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;
    }
    .section-header h5 { font-size: 1rem; font-weight: 600; color: var(--navy); margin: 0; }
    .view-all { color: var(--cyan); text-decoration: none; font-size: 0.88rem; font-weight: 500; }
    .view-all:hover { color: var(--navy); }

    .aspirasi-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 0; border-bottom: 1px solid #f0f4f8;
    }
    .aspirasi-row:last-child { border-bottom: none; }

    .tag-kategori {
        display: inline-block; font-size: 0.72rem; background: #dbeafe; color: #1e40af;
        padding: 0.2rem 0.6rem; border-radius: 20px; margin-bottom: 0.3rem; font-weight: 500;
    }
    .aspirasi-judul { font-weight: 500; color: var(--navy); margin-bottom: 0.25rem; }
    .aspirasi-meta  { font-size: 0.8rem; color: #6c757d; }
    .aspirasi-meta i { margin-right: 3px; }

    .aspirasi-right { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }

    .badge-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; }
    .badge-baru     { background: #fff4e6; color: #c2410c; }
    .badge-diproses { background: #dbeafe; color: #1e40af; }
    .badge-selesai  { background: #d1fae5; color: #065f46; }
    .badge-ditolak  { background: #fee2e2; color: #991b1b; }

    .btn-detail {
        width: 30px; height: 30px; background: #f0f4f8; color: #6c757d;
        border-radius: 6px; display: flex; align-items: center; justify-content: center;
        text-decoration: none; font-size: 0.85rem; transition: all 0.2s;
    }
    .btn-detail:hover { background: var(--cyan); color: white; }

    .empty-state { text-align: center; padding: 3rem 1rem; color: #6c757d; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.2; display: block; }
    .empty-state p { margin: 0; font-size: 0.9rem; }
</style>
@endpush
