@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')

<div class="page-header">
    <h1>Data Siswa</h1>
    <button class="btn-primary-custom" onclick="openModal()">
        <i class="bi bi-plus-circle"></i> Tambah Siswa
    </button>
</div>

@if(session('success'))
<div class="alert-success">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="filter-section">
    <form action="{{ route('admin.siswa.index') }}" method="GET">
        <div class="filter-row">

            <div class="filter-item">
                <label>Filter Tingkat</label>
                <select name="tingkat" onchange="this.form.submit()">
                    <option value="">Semua Tingkat</option>
                    <option value="X"   {{ request('tingkat') == 'X'   ? 'selected' : '' }}>Kelas X</option>
                    <option value="XI"  {{ request('tingkat') == 'XI'  ? 'selected' : '' }}>Kelas XI</option>
                    <option value="XII" {{ request('tingkat') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                </select>
            </div>

            <div class="filter-item filter-search">
                <label>Cari Siswa</label>
                <div class="search-input-wrap">
                    <input type="text" name="search"
                           placeholder="Cari nama, NISN, atau kelas..."
                           value="{{ request('search') }}">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </div>

            @if(request()->hasAny(['search', 'tingkat']))
            <div class="filter-item filter-reset">
                <label>&nbsp;</label>
                <a href="{{ route('admin.siswa.index') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>
            @endif

        </div>
    </form>
</div>

<div class="table-section">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Total Pengaduan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                <tr>
                    <td class="td-no">{{ $siswas->firstItem() + $index }}</td>
                    <td>
                        <div class="siswa-name">
                            <div class="siswa-avatar">{{ strtoupper(substr($siswa->name, 0, 1)) }}</div>
                            <span>{{ $siswa->name }}</span>
                        </div>
                    </td>
                    <td class="td-nisn">{{ $siswa->nisn }}</td>
                    <td><span class="tag-kelas">{{ $siswa->kelas }}</span></td>
                    <td>
                        <span class="total-pengaduan {{ $siswa->aspirations_count > 0 ? 'has-data' : '' }}">
                            {{ $siswa->aspirations_count }} pengaduan
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-edit"
                                    onclick="editSiswa({{ $siswa->id }})"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus siswa ini? Semua pengaduannya juga ikut terhapus.')">
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
                        <i class="bi bi-people"></i>
                        <p>{{ request()->hasAny(['search','tingkat']) ? 'Tidak ada siswa yang sesuai filter' : 'Belum ada data siswa' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <div class="pagination-info">
            @if($siswas->total() > 0)
                Menampilkan {{ $siswas->firstItem() }}–{{ $siswas->lastItem() }} dari {{ $siswas->total() }} siswa
            @else
                Tidak ada data
            @endif
        </div>
        <ul class="pagination">
            <li>
                @if($siswas->onFirstPage())
                    <a href="#" class="disabled">«</a>
                @else
                    <a href="{{ $siswas->previousPageUrl() }}">«</a>
                @endif
            </li>
            @foreach($siswas->getUrlRange(1, $siswas->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" class="{{ $page == $siswas->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            </li>
            @endforeach
            <li>
                @if($siswas->hasMorePages())
                    <a href="{{ $siswas->nextPageUrl() }}">»</a>
                @else
                    <a href="#" class="disabled">»</a>
                @endif
            </li>
        </ul>
    </div>
</div>

@endsection

@section('modals')
<!-- Modal Tambah/Edit -->
<div id="siswaModal" class="modal-overlay" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <div class="modal-box-header">
            <h3 id="modalTitle">Tambah Siswa</h3>
            <button class="btn-close-modal" onclick="closeModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="siswaForm" method="POST" action="{{ route('admin.siswa.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="modal-box-body">
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" id="inputName"
                           placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label>NISN <span class="required">*</span></label>
                    <input type="text" name="nisn" id="inputNisn"
                           placeholder="10 digit NISN" maxlength="10" required>
                </div>
                <div class="form-group">
                    <label>Kelas <span class="required">*</span></label>
                    <input type="text" name="kelas" id="inputKelas"
                           placeholder="Contoh: X RPL 1" required>
                </div>
                <div class="form-group">
                    <label id="passwordLabel">Password <span class="required">*</span></label>
                    <div class="input-pass-wrap">
                        <input type="password" name="password" id="inputPassword"
                               placeholder="Minimal 6 karakter">
                        <button type="button" class="btn-toggle-pass" onclick="togglePass()">
                            <i class="bi bi-eye" id="passIcon"></i>
                        </button>
                    </div>
                    <small id="passwordHint" class="hint" style="display:none;">
                        Kosongkan jika tidak ingin mengubah password
                    </small>
                </div>
            </div>

            <div class="modal-box-footer">
                <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-simpan">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-primary-custom { background:var(--cyan); color:white; padding:0.65rem 1.5rem; border-radius:8px; border:none; font-weight:500; font-size:0.9rem; font-family:'Poppins',sans-serif; display:inline-flex; align-items:center; gap:0.5rem; cursor:pointer; transition:background 0.2s; }
    .btn-primary-custom:hover { background:#0088a8; }

    .alert-success { display:flex; align-items:center; gap:0.5rem; padding:0.875rem 1rem; background:#d1fae5; color:#065f46; border-radius:8px; margin-bottom:1.25rem; font-size:0.88rem; font-weight:500; }

    .filter-section { position:relative; z-index:10; background:white; padding:1.25rem 1.5rem; border-radius:10px; border:1px solid #e1e8ed; margin-bottom:1.5rem; }
    .filter-row { display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end; }
    .filter-item { flex:1; min-width:160px; }
    .filter-search { flex:2; }
    .filter-reset { flex:0; min-width:fit-content; }
    .filter-item label { display:block; font-size:0.82rem; font-weight:500; color:var(--text-dark); margin-bottom:0.4rem; }
    .filter-item select { width:100%; padding:0.6rem 0.75rem; border:1px solid #e1e8ed; border-radius:8px; font-size:0.875rem; font-family:'Poppins',sans-serif; }
    .search-input-wrap { display:flex; }
    .search-input-wrap input { flex:1; padding:0.6rem 0.75rem; border:1px solid #e1e8ed; border-radius:8px 0 0 8px; border-right:none; font-size:0.875rem; font-family:'Poppins',sans-serif; }
    .search-input-wrap button { padding:0 1rem; background:var(--cyan); color:white; border:none; border-radius:0 8px 8px 0; cursor:pointer; }
    .btn-reset { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1rem; background:#fee2e2; color:#991b1b; border-radius:8px; text-decoration:none; font-size:0.85rem; font-weight:500; white-space:nowrap; }
    .btn-reset:hover { background:#fecaca; }

    .table-section { position:relative; z-index:10; background:white; border-radius:10px; border:1px solid #e1e8ed; overflow:hidden; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead { background:#f8fafc; }
    th { padding:0.9rem 1.25rem; text-align:left; font-size:0.78rem; font-weight:600; color:var(--navy); text-transform:uppercase; letter-spacing:0.4px; border-bottom:2px solid #e1e8ed; }
    td { padding:1rem 1.25rem; font-size:0.88rem; border-bottom:1px solid #f0f4f8; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover { background:#fafcff; }

    .td-no { color:#94a3b8; font-size:0.82rem; width:50px; }
    .td-nisn { font-family:monospace; color:#6c757d; }

    .siswa-name { display:flex; align-items:center; gap:0.75rem; }
    .siswa-avatar { width:34px; height:34px; border-radius:50%; background:var(--cyan); color:white; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:0.85rem; flex-shrink:0; }

    .tag-kelas { display:inline-block; background:#f0f9ff; color:#0369a1; padding:0.2rem 0.65rem; border-radius:20px; font-size:0.78rem; font-weight:500; }

    .total-pengaduan { font-size:0.82rem; color:#94a3b8; }
    .total-pengaduan.has-data { color:#065f46; font-weight:500; }

    .action-buttons { display:flex; gap:0.4rem; }
    .btn-icon { width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; border:none; cursor:pointer; transition:all 0.2s; font-size:0.9rem; }
    .btn-edit   { background:#fef3c7; color:#92400e; }
    .btn-edit:hover { background:#fde68a; }
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

    .modal-overlay { display:none; position:fixed !important; top:0 !important; left:0 !important; right:0 !important; bottom:0 !important; width:100vw !important; height:100vh !important; background:rgba(0,0,0,0.5); z-index:999999 !important; transform:translateZ(9999px) !important; align-items:center; justify-content:center; }
    .modal-overlay.show { display:flex; }
    .modal-box { position:relative !important; z-index:1000000 !important; transform:translateZ(10000px) !important; background:white; border-radius:12px; width:90%; max-width:460px; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,0.15); }
    .modal-box-header { padding:1.25rem 1.5rem; border-bottom:1px solid #e1e8ed; display:flex; justify-content:space-between; align-items:center; }
    .modal-box-header h3 { margin:0; font-size:1rem; font-weight:600; color:var(--navy); }
    .btn-close-modal { background:none; border:none; cursor:pointer; color:#6c757d; width:30px; height:30px; border-radius:6px; display:flex; align-items:center; justify-content:center; transition:background 0.2s; }
    .btn-close-modal:hover { background:#f3f4f6; }
    .modal-box-body { padding:1.5rem; }
    .modal-box-footer { padding:1.25rem 1.5rem; border-top:1px solid #e1e8ed; display:flex; gap:0.75rem; justify-content:flex-end; }

    .form-group { margin-bottom:1.25rem; }
    .form-group label { display:block; font-size:0.875rem; font-weight:500; color:var(--text-dark); margin-bottom:0.4rem; }
    .required { color:#ef4444; }
    .form-group input { width:100%; padding:0.7rem 0.9rem; border:1px solid #e1e8ed; border-radius:8px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.2s; }
    .form-group input:focus { outline:none; border-color:var(--cyan); }
    .hint { font-size:0.78rem; color:#94a3b8; margin-top:0.3rem; display:block; }

    .input-pass-wrap { position:relative; }
    .input-pass-wrap input { padding-right:2.5rem; }
    .btn-toggle-pass { position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; font-size:1rem; }

    .btn-batal { padding:0.6rem 1.5rem; border-radius:8px; border:1px solid #e1e8ed; background:white; color:var(--text-dark); font-weight:500; font-size:0.9rem; cursor:pointer; font-family:'Poppins',sans-serif; }
    .btn-batal:hover { background:#f3f4f6; }
    .btn-simpan { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.5rem; border-radius:8px; border:none; background:var(--cyan); color:white; font-weight:500; font-size:0.9rem; cursor:pointer; font-family:'Poppins',sans-serif; }
    .btn-simpan:hover { background:#0088a8; }
</style>
@endpush

@push('scripts')
<script>
    function openModal() {
        document.getElementById('siswaModal').classList.add('show');
        document.getElementById('modalTitle').textContent = 'Tambah Siswa';
        document.getElementById('siswaForm').action = '{{ route("admin.siswa.store") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('siswaForm').reset();
        document.getElementById('passwordLabel').innerHTML = 'Password <span class="required">*</span>';
        document.getElementById('inputPassword').required = true;
        document.getElementById('passwordHint').style.display = 'none';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('siswaModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    function closeModalOutside(e) {
        if (e.target === document.getElementById('siswaModal')) closeModal();
    }

    function editSiswa(id) {
        fetch(`/admin/siswa/${id}/edit`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('siswaModal').classList.add('show');
                document.getElementById('modalTitle').textContent = 'Edit Data Siswa';
                document.getElementById('siswaForm').action = `/admin/siswa/${id}`;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('inputName').value  = data.name;
                document.getElementById('inputNisn').value  = data.nisn;
                document.getElementById('inputKelas').value = data.kelas ?? '';
                document.getElementById('inputPassword').value = '';
                document.getElementById('inputPassword').required = false;
                document.getElementById('passwordLabel').innerHTML = 'Password';
                document.getElementById('passwordHint').style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
    }

    function togglePass() {
        const input = document.getElementById('inputPassword');
        const icon  = document.getElementById('passIcon');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endpush
