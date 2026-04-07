@extends('layouts.siswa')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1>Halo, {{ Auth::user()->name }} </h1>
        <p class="page-subtitle">Kelas {{ Auth::user()->kelas ?? '-' }} &nbsp;·&nbsp; NISN: {{ Auth::user()->nisn }}</p>
    </div>
    <a href="{{ route('siswa.aspirasi.create') }}" class="btn-primary-action">
        <i class="bi bi-plus-lg"></i> Buat Pengaduan
    </a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon cyan"><i class="bi bi-send"></i></div>
        <div class="stat-info">
            <h3>{{ $totalAspirasi }}</h3>
            <p>Total Pengaduan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="bi bi-clock-history"></i></div>
        <div class="stat-info">
            <h3>{{ $menunggu }}</h3>
            <p>Menunggu Review</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon navy"><i class="bi bi-arrow-repeat"></i></div>
        <div class="stat-info">
            <h3>{{ $diproses }}</h3>
            <p>Sedang Diproses</p>
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

<!-- Pengaduan Terbaru -->
<div class="card-section">
    <div class="section-header">
        <h5><i class="bi bi-clock-history me-2"></i>Pengaduan Terbaru</h5>
        <a href="{{ route('siswa.aspirasi.index') }}" class="link-all">Lihat Semua →</a>
    </div>

    @forelse($aspirasi->take(5) as $item)
    <div class="aspirasi-row">
        <div class="aspirasi-info">
            <span class="tag-kategori">{{ ucfirst($item->kategori) }}</span>
            <div class="aspirasi-judul">{{ $item->judul }}</div>
            <div class="aspirasi-meta"><i class="bi bi-calendar3"></i> {{ $item->created_at->format('d M Y') }}</div>
        </div>
        <span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Belum ada pengaduan</p>
        <a href="{{ route('siswa.aspirasi.create') }}" class="btn-primary-action mt-3">Buat Pengaduan Pertama</a>
    </div>
    @endforelse
</div>

@endsection

@push('styles')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; }
    .page-header h1 { font-size:1.6rem; font-weight:700; color:var(--navy); margin:0 0 0.2rem; }
    .page-subtitle { color:#6c757d; font-size:0.88rem; margin:0; }

    .btn-primary-action {
        display:inline-flex; align-items:center; gap:0.5rem;
        background:var(--orange); color:white; padding:0.65rem 1.25rem;
        border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:background 0.2s;
    }
    .btn-primary-action:hover { background:#e68a00; color:white; }

    .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.25rem; margin-bottom:2rem; }
    .stat-card { background:white; padding:1.25rem; border-radius:12px; border:1px solid #e1e8ed; display:flex; align-items:center; gap:1rem; }
    .stat-icon { width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:white; flex-shrink:0; }
    .stat-icon.cyan   { background:#00a8cc; }
    .stat-icon.orange { background:#ff9933; }
    .stat-icon.navy   { background:#1e3a5f; }
    .stat-icon.green  { background:#10b981; }
    .stat-info h3 { font-size:1.7rem; font-weight:700; color:var(--navy); margin:0; line-height:1; }
    .stat-info p  { font-size:0.82rem; color:#6c757d; margin:0.25rem 0 0; }

    .card-section { background:white; border-radius:12px; border:1px solid #e1e8ed; padding:1.5rem; }
    .section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; }
    .section-header h5 { font-size:1rem; font-weight:600; color:var(--navy); margin:0; }
    .link-all { color:var(--cyan); text-decoration:none; font-size:0.88rem; font-weight:500; }
    .link-all:hover { color:var(--navy); }

    .aspirasi-row { display:flex; justify-content:space-between; align-items:center; padding:1rem 0; border-bottom:1px solid #f0f4f8; }
    .aspirasi-row:last-child { border-bottom:none; }
    .tag-kategori { display:inline-block; font-size:0.72rem; background:#fff4e6; color:var(--orange); padding:0.2rem 0.6rem; border-radius:20px; margin-bottom:0.3rem; font-weight:500; }
    .aspirasi-judul { font-weight:500; color:var(--navy); margin-bottom:0.2rem; }
    .aspirasi-meta { font-size:0.8rem; color:#6c757d; }
    .aspirasi-meta i { margin-right:4px; }

    .badge-status { padding:0.35rem 0.85rem; border-radius:20px; font-size:0.78rem; font-weight:600; white-space:nowrap; }
    .badge-baru     { background:#fff4e6; color:#c2410c; }
    .badge-diproses { background:#dbeafe; color:#1e40af; }
    .badge-selesai  { background:#d1fae5; color:#065f46; }
    .badge-ditolak  { background:#fee2e2; color:#991b1b; }

    .empty-state { text-align:center; padding:3rem 1rem; color:#6c757d; }
    .empty-state i { font-size:3rem; opacity:0.2; display:block; margin-bottom:0.75rem; }
    .empty-state p { margin:0; font-size:0.9rem; }
    .mt-3 { margin-top:1rem; }
</style>
@endpush
