@extends('layouts.admin')

@section('title', 'Detail Aspirasi')

@section('content')

<div class="page-header">
    <div>
        <h1>Detail Aspirasi</h1>
        <p class="page-subtitle">ID #{{ $aspirasi->id }}</p>
    </div>
    <a href="{{ route('admin.aspirasi.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="detail-grid">

    <!-- KIRI -->
    <div class="detail-main">
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-tags">
                    <span class="tag tag-kategori">{{ $aspirasi->category->name ?? '-' }}</span>
                    <span class="tag tag-lokasi">
                        <i class="bi bi-geo-alt"></i>
                        {{ $aspirasi->label_lokasi }}
                    </span>
                </div>
                <span class="badge-status badge-{{ $aspirasi->status }}">{{ ucfirst($aspirasi->status) }}</span>
            </div>

            <h2 class="detail-judul">{{ $aspirasi->judul }}</h2>

            <div class="detail-meta">
                <span><i class="bi bi-person"></i> {{ $aspirasi->pelapor->name ?? '-' }}</span>
                <span><i class="bi bi-mortarboard"></i> Kelas {{ $aspirasi->pelapor->kelas ?? '-' }}</span>
                <span><i class="bi bi-calendar3"></i> {{ $aspirasi->created_at->format('d M Y, H:i') }}</span>
            </div>

            <div class="detail-deskripsi">{{ $aspirasi->deskripsi }}</div>

            @if($aspirasi->photo)
            <div class="detail-photo">
                <p class="photo-label"><i class="bi bi-image"></i> Foto Bukti</p>
                <img src="{{ Storage::url($aspirasi->photo) }}" alt="Foto Bukti"
                     class="photo-img" onclick="openLightbox(this.src)">
            </div>
            @endif
        </div>

        <!-- Riwayat Feedback -->
        <div class="detail-card mt-2">
            <h5 class="section-title"><i class="bi bi-chat-dots"></i> Riwayat Feedback</h5>
            @forelse($aspirasi->feedbacks as $fb)
            <div class="feedback-item">
                <div class="feedback-header">
                    <span class="feedback-admin">
                        <i class="bi bi-shield-check"></i> {{ $fb->admin->name }}
                    </span>
                    <span class="feedback-time">{{ $fb->created_at->format('d M Y, H:i') }}</span>
                </div>
                <p class="feedback-msg">{{ $fb->message }}</p>
            </div>
            @empty
            <div class="empty-feedback">
                <i class="bi bi-chat-square-dots"></i>
                <p>Belum ada feedback</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- KANAN -->
    <div class="detail-sidebar">

        <!-- Form Update -->
        <div class="detail-card">
            <h5 class="section-title"><i class="bi bi-gear"></i> Update Status & Feedback</h5>
            <form action="{{ route('admin.aspirasi.update', $aspirasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="proses"   {{ $aspirasi->status == 'proses'   ? 'selected' : '' }}>Proses</option>
                        <option value="selesai"  {{ $aspirasi->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tulis Feedback <span class="optional">(opsional)</span></label>
                    <textarea name="feedback" rows="4"
                              placeholder="Tulis tanggapan untuk pelapor..."></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Info Pelapor -->
        <div class="detail-card mt-2">
            <h5 class="section-title"><i class="bi bi-person-circle"></i> Info Pelapor</h5>
            <div class="info-row"><span>Nama</span><strong>{{ $aspirasi->pelapor->name ?? '-' }}</strong></div>
            <div class="info-row"><span>NISN</span><strong>{{ $aspirasi->pelapor->nisn ?? '-' }}</strong></div>
            <div class="info-row"><span>Kelas</span><strong>{{ $aspirasi->pelapor->kelas ?? '-' }}</strong></div>
            <div class="info-row"><span>Lokasi</span><strong>{{ $aspirasi->label_lokasi }}</strong></div>
            <div class="info-row"><span>Kategori</span><strong>{{ $aspirasi->category->name ?? '-' }}</strong></div>
        </div>

        <!-- Hapus -->
        <div class="detail-card mt-2">
            <h5 class="section-title danger-title"><i class="bi bi-exclamation-triangle"></i>PERINGATAN !!!</h5>
            <p class="danger-desc">Menghapus aspirasi ini bersifat permanen dan tidak bisa dibatalkan.</p>
            <form action="{{ route('admin.aspirasi.destroy', $aspirasi->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="bi bi-trash"></i> Hapus Aspirasi
                </button>
            </form>
        </div>

    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" onclick="closeLightbox()">
    <img id="lightboxImg" src="" alt="Foto Bukti">
</div>

@endsection

@push('styles')
<style>
    .btn-back { display:inline-flex; align-items:center; gap:0.5rem; padding:0.6rem 1.25rem; border-radius:8px; border:1px solid #e1e8ed; background:white; color:var(--text-dark); text-decoration:none; font-size:0.9rem; transition:all 0.2s; }
    .btn-back:hover { background:#f3f4f6; }

    .detail-grid { display:grid; grid-template-columns:1fr 320px; gap:1.5rem; align-items:start; }
    .detail-card { background:white; border-radius:12px; border:1px solid #e1e8ed; padding:1.5rem; }
    .mt-2 { margin-top:1.5rem; }

    .detail-card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:0.5rem; }
    .detail-tags { display:flex; gap:0.5rem; flex-wrap:wrap; }
    .tag { display:inline-flex; align-items:center; gap:0.35rem; font-size:0.78rem; padding:0.3rem 0.8rem; border-radius:20px; font-weight:500; }
    .tag i { font-size:0.75rem; }
    .tag-kategori { background:#dbeafe; color:#1e40af; }
    .tag-lokasi   { background:#f0fdf4; color:#166534; }

    .badge-status { padding:0.35rem 0.85rem; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .badge-menunggu { background:#fff4e6; color:#c2410c; }
    .badge-proses   { background:#dbeafe; color:#1e40af; }
    .badge-selesai  { background:#d1fae5; color:#065f46; }

    .detail-judul { font-size:1.3rem; font-weight:700; color:var(--navy); margin:0 0 0.75rem; }
    .detail-meta { display:flex; flex-wrap:wrap; gap:1rem; font-size:0.82rem; color:#6c757d; margin-bottom:1.25rem; }
    .detail-meta i { margin-right:4px; }
    .detail-deskripsi { font-size:0.92rem; color:var(--text-dark); line-height:1.75; white-space:pre-line; }

    .detail-photo { margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid #f0f4f8; }
    .photo-label { font-size:0.85rem; font-weight:500; color:#6c757d; margin-bottom:0.75rem; }
    .photo-label i { margin-right:6px; }
    .photo-img { width:100%; max-height:380px; object-fit:cover; border-radius:10px; border:1px solid #e1e8ed; cursor:zoom-in; transition:opacity 0.2s; }
    .photo-img:hover { opacity:0.9; }

    .section-title { font-size:0.95rem; font-weight:600; color:var(--navy); margin:0 0 1.25rem; display:flex; align-items:center; gap:0.5rem; }

    .feedback-item { padding:1rem; background:#f8fafc; border-radius:8px; margin-bottom:0.75rem; }
    .feedback-item:last-child { margin-bottom:0; }
    .feedback-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem; }
    .feedback-admin { font-size:0.82rem; font-weight:600; color:var(--navy); }
    .feedback-admin i { margin-right:4px; color:var(--cyan); }
    .feedback-time { font-size:0.78rem; color:#94a3b8; }
    .feedback-msg { font-size:0.88rem; color:var(--text-dark); margin:0; line-height:1.6; white-space:pre-line; }

    .empty-feedback { text-align:center; padding:2rem; color:#94a3b8; }
    .empty-feedback i { font-size:2rem; display:block; margin-bottom:0.5rem; opacity:0.3; }
    .empty-feedback p { margin:0; font-size:0.85rem; }

    .form-group { margin-bottom:1.25rem; }
    .form-group label { display:block; font-size:0.85rem; font-weight:500; color:var(--text-dark); margin-bottom:0.5rem; }
    .optional { color:#94a3b8; font-weight:400; font-size:0.78rem; }
    .form-group select,
    .form-group textarea { width:100%; padding:0.7rem; border:1px solid #e1e8ed; border-radius:8px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.2s; }
    .form-group select:focus,
    .form-group textarea:focus { outline:none; border-color:var(--cyan); }
    .form-group textarea { resize:vertical; min-height:100px; }

    .btn-submit { width:100%; padding:0.75rem; background:var(--cyan); color:white; border:none; border-radius:8px; font-weight:600; font-size:0.9rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.5rem; transition:background 0.2s; font-family:'Poppins',sans-serif; }
    .btn-submit:hover { background:#0088a8; }

    .info-row { display:flex; justify-content:space-between; align-items:center; padding:0.65rem 0; border-bottom:1px solid #f0f4f8; font-size:0.88rem; }
    .info-row:last-child { border-bottom:none; }
    .info-row span { color:#6c757d; }
    .info-row strong { color:var(--navy); }

    .danger-title { color:#ef4444 !important; }
    .danger-desc { font-size:0.85rem; color:#6c757d; margin-bottom:1rem; line-height:1.5; }
    .btn-danger { width:100%; padding:0.75rem; background:#fee2e2; color:#991b1b; border:1px solid #fecaca; border-radius:8px; font-weight:600; font-size:0.9rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.5rem; transition:all 0.2s; font-family:'Poppins',sans-serif; }
    .btn-danger:hover { background:#ef4444; color:white; border-color:#ef4444; }

    #lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out; }
    #lightbox.show { display:flex; }
    #lightboxImg { max-width:90vw; max-height:90vh; object-fit:contain; border-radius:8px; }

    @media(max-width:900px) { .detail-grid { grid-template-columns:1fr; } }
</style>
@endpush

@push('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('show');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLightbox();
    });
</script>
@endpush
