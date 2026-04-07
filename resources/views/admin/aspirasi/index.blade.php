@extends('layouts.admin')

@section('title', 'Kelola Aspirasi')

@section('content')

<div class="page-header">
    <h1>Kelola Aspirasi</h1>
</div>

@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="filter-section">
    <form action="{{ route('admin.aspirasi.index') }}" method="GET">
        <div class="filter-row">

            <div class="filter-item">
                <label>Status</label>
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="proses"   {{ request('status') == 'proses'   ? 'selected' : '' }}>Proses</option>
                    <option value="selesai"  {{ request('status') == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="filter-item">
                <label>Kategori</label>
                <select name="category_id" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ request('category_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <label>Bulan</label>
                <select name="bulan" onchange="this.form.submit()">
                    <option value="">Semua Bulan</option>
                    <option value="1"  {{ request('bulan') == '1'  ? 'selected' : '' }}>Januari</option>
                    <option value="2"  {{ request('bulan') == '2'  ? 'selected' : '' }}>Februari</option>
                    <option value="3"  {{ request('bulan') == '3'  ? 'selected' : '' }}>Maret</option>
                    <option value="4"  {{ request('bulan') == '4'  ? 'selected' : '' }}>April</option>
                    <option value="5"  {{ request('bulan') == '5'  ? 'selected' : '' }}>Mei</option>
                    <option value="6"  {{ request('bulan') == '6'  ? 'selected' : '' }}>Juni</option>
                    <option value="7"  {{ request('bulan') == '7'  ? 'selected' : '' }}>Juli</option>
                    <option value="8"  {{ request('bulan') == '8'  ? 'selected' : '' }}>Agustus</option>
                    <option value="9"  {{ request('bulan') == '9'  ? 'selected' : '' }}>September</option>
                    <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                </select>
            </div>

        </div>

        <div class="filter-row mt-1">
            <div class="filter-item filter-search">
                <label>Cari Judul, Nama Siswa, atau NISN</label>
                <div class="search-input-wrap">
                    <input type="text" name="search"
                           placeholder="Ketik judul, nama siswa, atau NISN..."
                           value="{{ request('search') }}">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </div>

            @if(request()->hasAny(['status', 'category_id', 'bulan', 'search']))
            <div class="filter-item filter-reset">
                <label>&nbsp;</label>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset Filter
                </a>
            </div>
            @endif
        </div>
    </form>
</div>

@if(request()->hasAny(['status', 'category_id', 'bulan', 'search']))
@php
    $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $namaKat   = $kategoris->firstWhere('id', request('category_id'))?->name;
@endphp
<div class="filter-active">
    <i class="bi bi-funnel-fill"></i>
    Filter aktif:
    @if(request('status'))      <span class="chip">Status: {{ ucfirst(request('status')) }}</span> @endif
    @if(request('category_id')) <span class="chip">Kategori: {{ $namaKat }}</span> @endif
    @if(request('bulan'))       <span class="chip">Bulan: {{ $namaBulan[(int)request('bulan')] }}</span> @endif
    @if(request('search'))      <span class="chip">Cari: "{{ request('search') }}"</span> @endif
</div>
@endif

<div class="table-section">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aspirasi</th>
                    <th>Pelapor</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasis as $index => $aspirasi)
                <tr>
                    <td class="td-no">{{ $aspirasis->firstItem() + $index }}</td>
                    <td>
                        <div class="asp-title">{{ $aspirasi->judul }}</div>
                        <div class="asp-tags">
                            <span class="tag tag-kategori">{{ $aspirasi->category->name ?? '-' }}</span>
                            <span class="tag tag-lokasi">
                                <i class="bi bi-geo-alt"></i>
                                {{ $aspirasi->label_lokasi }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.aspirasi.index', ['search' => $aspirasi->pelapor->nisn]) }}"
                           class="link-siswa">
                            {{ $aspirasi->pelapor->name ?? '-' }}
                        </a>
                        <div class="asp-sub">
                            {{ $aspirasi->pelapor->kelas ?? '-' }}
                            &nbsp;·&nbsp;
                            NISN: {{ $aspirasi->pelapor->nisn ?? '-' }}
                        </div>
                    </td>
                    <td class="td-date">
                        {{ $aspirasi->created_at->format('d M Y') }}
                        <div class="td-time">{{ $aspirasi->created_at->format('H:i') }}</div>
                    </td>
                    <td>
                        <span class="badge-status badge-{{ $aspirasi->status }}">
                            {{ ucfirst($aspirasi->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.aspirasi.show', $aspirasi->id) }}"
                               class="btn-icon btn-view" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.aspirasi.destroy', $aspirasi->id) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus aspirasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-td">
                        <i class="bi bi-inbox"></i>
                        <p>{{ request()->hasAny(['status','category_id','bulan','search']) ? 'Tidak ada aspirasi yang sesuai filter' : 'Belum ada aspirasi masuk' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <div class="pagination-info">
            @if($aspirasis->total() > 0)
                Menampilkan {{ $aspirasis->firstItem() }}–{{ $aspirasis->lastItem() }}
                dari {{ $aspirasis->total() }} aspirasi
            @else
                Tidak ada data
            @endif
        </div>
        <ul class="pagination">
            <li>
                @if($aspirasis->onFirstPage())
                    <a href="#" class="disabled">«</a>
                @else
                    <a href="{{ $aspirasis->previousPageUrl() }}">«</a>
                @endif
            </li>
            @foreach($aspirasis->getUrlRange(1, $aspirasis->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" class="{{ $page == $aspirasis->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            </li>
            @endforeach
            <li>
                @if($aspirasis->hasMorePages())
                    <a href="{{ $aspirasis->nextPageUrl() }}">»</a>
                @else
                    <a href="#" class="disabled">»</a>
                @endif
            </li>
        </ul>
    </div>
</div>

@endsection

@push('styles')
<style>
    .alert-success { display:flex; align-items:center; gap:0.5rem; padding:0.875rem 1rem; background:#d1fae5; color:#065f46; border-radius:8px; margin-bottom:1.25rem; font-size:0.88rem; font-weight:500; }

    .filter-section { background:white; padding:1.5rem; border-radius:10px; border:1px solid #e1e8ed; margin-bottom:1rem; }
    .filter-row { display:flex; gap:1rem; flex-wrap:wrap; }
    .filter-row.mt-1 { margin-top:1rem; }
    .filter-item { flex:1; min-width:130px; }
    .filter-search { flex:3; min-width:260px; }
    .filter-reset { flex:0; min-width:fit-content; }
    .filter-item label { display:block; font-size:0.82rem; font-weight:500; color:var(--text-dark); margin-bottom:0.4rem; }
    .filter-item select { width:100%; padding:0.6rem 0.75rem; border:1px solid #e1e8ed; border-radius:8px; font-size:0.875rem; font-family:'Poppins',sans-serif; }
    .search-input-wrap { display:flex; }
    .search-input-wrap input { flex:1; padding:0.6rem 0.75rem; border:1px solid #e1e8ed; border-radius:8px 0 0 8px; border-right:none; font-size:0.875rem; font-family:'Poppins',sans-serif; }
    .search-input-wrap button { padding:0 1rem; background:var(--cyan); color:white; border:none; border-radius:0 8px 8px 0; cursor:pointer; }
    .btn-reset { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1rem; background:#fee2e2; color:#991b1b; border-radius:8px; text-decoration:none; font-size:0.85rem; font-weight:500; white-space:nowrap; transition:background 0.2s; }
    .btn-reset:hover { background:#fecaca; }

    .filter-active { display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap; padding:0.75rem 1rem; background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; margin-bottom:1rem; font-size:0.82rem; color:#0369a1; }
    .chip { background:#0369a1; color:white; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.75rem; font-weight:500; }

    .table-section { background:white; border-radius:10px; border:1px solid #e1e8ed; overflow:hidden; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead { background:#f8fafc; }
    th { padding:0.9rem 1.25rem; text-align:left; font-size:0.78rem; font-weight:600; color:var(--navy); text-transform:uppercase; letter-spacing:0.4px; border-bottom:2px solid #e1e8ed; }
    td { padding:1rem 1.25rem; font-size:0.88rem; border-bottom:1px solid #f0f4f8; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover { background:#fafcff; }

    .td-no { color:#94a3b8; font-size:0.82rem; width:50px; }
    .td-date { color:#6c757d; font-size:0.82rem; white-space:nowrap; }
    .td-time { font-size:0.75rem; color:#94a3b8; margin-top:2px; }
    .asp-title { font-weight:500; color:var(--navy); margin-bottom:0.35rem; }
    .asp-sub { font-size:0.78rem; color:#6c757d; margin-top:2px; }
    .asp-tags { display:flex; gap:0.4rem; flex-wrap:wrap; margin-top:0.35rem; }

    .link-siswa { color:var(--navy); text-decoration:none; font-weight:500; font-size:0.88rem; }
    .link-siswa:hover { color:var(--cyan); text-decoration:underline; }

    .tag { display:inline-flex; align-items:center; gap:0.3rem; font-size:0.72rem; padding:0.2rem 0.6rem; border-radius:20px; font-weight:500; }
    .tag-kategori { background:#dbeafe; color:#1e40af; }
    .tag-lokasi   { background:#f0fdf4; color:#166534; }
    .tag-lokasi i { font-size:0.7rem; }

    .badge-status { padding:0.3rem 0.8rem; border-radius:20px; font-size:0.75rem; font-weight:600; white-space:nowrap; }
    .badge-menunggu { background:#fff4e6; color:#c2410c; }
    .badge-proses   { background:#dbeafe; color:#1e40af; }
    .badge-selesai  { background:#d1fae5; color:#065f46; }

    .action-buttons { display:flex; gap:0.4rem; }
    .btn-icon { width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; border:none; cursor:pointer; transition:all 0.2s; text-decoration:none; font-size:0.9rem; }
    .btn-view   { background:#dbeafe; color:#1e40af; }
    .btn-view:hover { background:#bfdbfe; }
    .btn-delete { background:#fee2e2; color:#991b1b; }
    .btn-delete:hover { background:#fecaca; }

    .empty-td { text-align:center; padding:3rem 1rem; color:#6c757d; }
    .empty-td i { font-size:2.5rem; opacity:0.2; display:block; margin-bottom:0.75rem; }
    .empty-td p { margin:0; font-size:0.9rem; }

    .pagination-wrapper { padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; border-top:1px solid #e1e8ed; }
    .pagination-info { font-size:0.82rem; color:#6c757d; }
    .pagination { display:flex; gap:0.4rem; list-style:none; margin:0; padding:0; }
    .pagination a { padding:0.45rem 0.75rem; border:1px solid #e1e8ed; border-radius:6px; color:var(--text-dark); text-decoration:none; font-size:0.82rem; transition:all 0.2s; }
    .pagination a:hover  { background:var(--cyan); color:white; border-color:var(--cyan); }
    .pagination a.active { background:var(--cyan); color:white; border-color:var(--cyan); }
    .pagination a.disabled { opacity:0.4; pointer-events:none; }
</style>
@endpush
