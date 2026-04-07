@extends('layouts.siswa')

@section('title', 'Riwayat Pengaduan')

@section('content')

<div class="page-header">
    <div>
        <h1>Riwayat Pengaduan</h1>
        <p class="page-subtitle">Semua pengaduan yang pernah kamu kirim</p>
    </div>
    <a href="{{ route('siswa.aspirasi.create') }}" class="btn-primary-action">
        <i class="bi bi-plus-lg"></i> Buat Pengaduan
    </a>
</div>

<!-- Filter -->
<div class="filter-bar">
    <a href="{{ route('siswa.aspirasi.index') }}"                                   class="filter-btn {{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('siswa.aspirasi.index', ['status' => 'menunggu']) }}"         class="filter-btn {{ request('status') == 'menunggu' ? 'active' : '' }}">Menunggu</a>
    <a href="{{ route('siswa.aspirasi.index', ['status' => 'proses']) }}"           class="filter-btn {{ request('status') == 'proses'   ? 'active' : '' }}">Diproses</a>
    <a href="{{ route('siswa.aspirasi.index', ['status' => 'selesai']) }}"          class="filter-btn {{ request('status') == 'selesai'  ? 'active' : '' }}">Selesai</a>
</div>

<div class="card-section">
    @forelse($aspirasi as $item)
    <div class="aspirasi-card">
        <div class="aspirasi-card-top">
            <div class="aspirasi-info">
                <div class="aspirasi-tags">
                    <span class="tag tag-kategori">{{ $item->category->name ?? '-' }}</span>
                    <span class="tag tag-lokasi">
                        <i class="bi bi-geo-alt"></i>
                        {{ $item->label_lokasi }}
                    </span>
                </div>
                <h6 class="aspirasi-judul">{{ $item->judul }}</h6>
                <p class="aspirasi-desc">{{ Str::limit($item->deskripsi, 110) }}</p>
            </div>
            <span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
        </div>

        <div class="aspirasi-card-bottom">
            <span><i class="bi bi-calendar3"></i> {{ $item->created_at->format('d M Y') }}</span>
            @if($item->feedbacks->count() > 0)
            <button class="feedback-tag" onclick="openFeedback({{ $item->id }})">
                <i class="bi bi-chat-dots"></i> Ada {{ $item->feedbacks->count() }} Feedback
            </button>
            @endif
        </div>
    </div>



    @empty
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Tidak ada pengaduan{{ request('status') ? ' dengan status ini' : '' }}</p>
        @if(!request('status'))
        <a href="{{ route('siswa.aspirasi.create') }}" class="btn-primary-action mt-3">
            Buat Pengaduan Pertama
        </a>
        @endif
    </div>
    @endforelse
</div>

@if($aspirasi->hasPages())
<div class="pagination-wrap">{{ $aspirasi->links() }}</div>
@endif

@endsection

@section('modals')
    @foreach($aspirasi as $item)
    <!-- Modal Feedback -->
    <div id="modal-{{ $item->id }}" class="modal-overlay" onclick="closeFeedback({{ $item->id }})">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-box-header">
                <div>
                    <h3>Feedback Admin</h3>
                    <p class="modal-subtitle">{{ $item->judul }}</p>
                </div>
                <button class="btn-close-modal" onclick="closeFeedback({{ $item->id }})">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-box-body">
                @foreach($item->feedbacks as $fb)
                <div class="fb-item">
                    <div class="fb-header">
                        <span class="fb-admin">
                            <i class="bi bi-shield-check"></i> {{ $fb->admin->name }}
                        </span>
                        <span class="fb-time">{{ $fb->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <p class="fb-msg">{{ $fb->message }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
@endsection
@push('styles')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .page-header h1 { font-size:1.6rem; font-weight:700; color:var(--navy); margin:0 0 0.2rem; }
    .page-subtitle { color:#6c757d; font-size:0.88rem; margin:0; }

    .btn-primary-action { display:inline-flex; align-items:center; gap:0.5rem; background:var(--orange); color:white; padding:0.65rem 1.25rem; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:background 0.2s; }
    .btn-primary-action:hover { background:#e68a00; color:white; }

    .filter-bar { display:flex; gap:0.5rem; margin-bottom:1.5rem; flex-wrap:wrap; }
    .filter-btn { padding:0.45rem 1rem; border-radius:20px; border:1px solid #e1e8ed; background:white; color:#6c757d; text-decoration:none; font-size:0.85rem; font-weight:500; transition:all 0.2s; }
    .filter-btn:hover { border-color:var(--orange); color:var(--orange); }
    .filter-btn.active { background:var(--orange); color:white; border-color:var(--orange); }

    .card-section { position:relative; z-index:10; background:white; border-radius:12px; border:1px solid #e1e8ed; padding:1.5rem; }

    .aspirasi-card { padding:1.25rem 0; border-bottom:1px solid #f0f4f8; }
    .aspirasi-card:last-child { border-bottom:none; }
    .aspirasi-card-top { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:0.75rem; }

    .aspirasi-tags { display:flex; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.4rem; }
    .tag { display:inline-flex; align-items:center; gap:0.3rem; font-size:0.72rem; padding:0.2rem 0.6rem; border-radius:20px; font-weight:500; }
    .tag i { font-size:0.7rem; }
    .tag-kategori { background:#fff4e6; color:#c2410c; }
    .tag-lokasi   { background:#f0fdf4; color:#166534; }

    .aspirasi-judul { font-size:0.95rem; font-weight:600; color:var(--navy); margin:0 0 0.35rem; }
    .aspirasi-desc { font-size:0.85rem; color:#6c757d; margin:0; line-height:1.5; }

    .aspirasi-card-bottom { display:flex; align-items:center; gap:1.5rem; font-size:0.8rem; color:#94a3b8; }
    .aspirasi-card-bottom i { margin-right:4px; }

    .feedback-tag { background:none; border:none; cursor:pointer; padding:0; color:var(--cyan); font-weight:500; font-size:0.8rem; font-family:'Poppins',sans-serif; display:inline-flex; align-items:center; gap:4px; transition:color 0.2s; }
    .feedback-tag:hover { color:var(--navy); }

    .badge-status { padding:0.35rem 0.85rem; border-radius:20px; font-size:0.78rem; font-weight:600; white-space:nowrap; flex-shrink:0; }
    .badge-menunggu { background:#fff4e6; color:#c2410c; }
    .badge-proses   { background:#dbeafe; color:#1e40af; }
    .badge-selesai  { background:#d1fae5; color:#065f46; }

    .empty-state { text-align:center; padding:3rem 1rem; color:#6c757d; }
    .empty-state i { font-size:3rem; opacity:0.2; display:block; margin-bottom:0.75rem; }
    .empty-state p { margin:0; font-size:0.9rem; }
    .mt-3 { margin-top:1rem; }

    .pagination-wrap { margin-top:1.5rem; display:flex; justify-content:center; }

    .modal-overlay { display:none; position:fixed !important; top:0 !important; left:0 !important; right:0 !important; bottom:0 !important; width:100vw !important; height:100vh !important; background:rgba(0,0,0,0.5); z-index:999999 !important; transform:translateZ(9999px) !important; align-items:center; justify-content:center; }
    .modal-overlay.show { display:flex; }
    .modal-box { position:relative !important; z-index:1000000 !important; transform:translateZ(10000px) !important; background:white; border-radius:14px; width:90%; max-width:480px; max-height:80vh; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 16px 40px rgba(0,0,0,0.15); }
    .modal-box-header { padding:1.25rem 1.5rem; border-bottom:1px solid #f0f4f8; display:flex; justify-content:space-between; align-items:flex-start; flex-shrink:0; }
    .modal-box-header h3 { margin:0 0 0.2rem; font-size:1rem; font-weight:600; color:var(--navy); }
    .modal-subtitle { margin:0; font-size:0.82rem; color:#6c757d; }
    .btn-close-modal { background:none; border:none; cursor:pointer; color:#6c757d; width:30px; height:30px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:0.9rem; flex-shrink:0; transition:background 0.2s; }
    .btn-close-modal:hover { background:#f3f4f6; }
    .modal-box-body { padding:1.25rem 1.5rem; overflow-y:auto; }

    .fb-item { padding:1rem; background:#f8fafc; border-radius:10px; margin-bottom:0.75rem; }
    .fb-item:last-child { margin-bottom:0; }
    .fb-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem; }
    .fb-admin { font-size:0.82rem; font-weight:600; color:var(--navy); }
    .fb-admin i { margin-right:4px; color:var(--cyan); }
    .fb-time { font-size:0.75rem; color:#94a3b8; }
    .fb-msg { margin:0; font-size:0.88rem; color:var(--text-dark); line-height:1.6; white-space:pre-line; }
</style>
@endpush

@push('scripts')
<script>
    function openFeedback(id) {
        document.getElementById('modal-' + id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeFeedback(id) {
        document.getElementById('modal-' + id).classList.remove('show');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.show').forEach(m => {
                m.classList.remove('show');
            });
            document.body.style.overflow = '';
        }
    });
</script>
@endpush
