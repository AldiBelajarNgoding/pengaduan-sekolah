@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')

<div class="page-header">
    <h1>Kelola Kategori</h1>
    <button class="btn-primary-custom" onclick="openModal()">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </button>
</div>

@if(session('success'))
<div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert-error"><i class="bi bi-exclamation-triangle"></i> {{ session('error') }}</div>
@endif

<div class="table-section">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Aspirasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $kategori)
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td class="kat-name">{{ $kategori->name }}</td>
                    <td>
                        <span class="total {{ $kategori->aspirations_count > 0 ? 'has-data' : '' }}">
                            {{ $kategori->aspirations_count }} aspirasi
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-edit"
                                    onclick="editKategori({{ $kategori->id }}, '{{ $kategori->name }}')"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Hapus"
                                        {{ $kategori->aspirations_count > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-td">
                        <i class="bi bi-tag"></i>
                        <p>Belum ada kategori</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<!-- Modal -->
<div id="kategoriModal" class="modal-overlay" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <div class="modal-box-header">
            <h3 id="modalTitle">Tambah Kategori</h3>
            <button class="btn-close-modal" onclick="closeModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="kategoriForm" method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-box-body">
                <div class="form-group">
                    <label>Nama Kategori <span class="required">*</span></label>
                    <input type="text" name="name" id="inputName"
                           placeholder="Contoh: Fasilitas" required>
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
    .alert-error   { display:flex; align-items:center; gap:0.5rem; padding:0.875rem 1rem; background:#fee2e2; color:#991b1b; border-radius:8px; margin-bottom:1.25rem; font-size:0.88rem; font-weight:500; }

    .table-section { position:relative; z-index:10; background:white; border-radius:10px; border:1px solid #e1e8ed; overflow:hidden; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead { background:#f8fafc; }
    th { padding:0.9rem 1.25rem; text-align:left; font-size:0.78rem; font-weight:600; color:var(--navy); text-transform:uppercase; letter-spacing:0.4px; border-bottom:2px solid #e1e8ed; }
    td { padding:1rem 1.25rem; font-size:0.88rem; border-bottom:1px solid #f0f4f8; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover { background:#fafcff; }

    .td-no { color:#94a3b8; font-size:0.82rem; width:50px; }
    .kat-name { font-weight:500; color:var(--navy); }

    .total { font-size:0.82rem; color:#94a3b8; }
    .total.has-data { color:#065f46; font-weight:500; }

    .action-buttons { display:flex; gap:0.4rem; }
    .btn-icon { width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; border:none; cursor:pointer; transition:all 0.2s; font-size:0.9rem; }
    .btn-edit   { background:#fef3c7; color:#92400e; }
    .btn-edit:hover { background:#fde68a; }
    .btn-delete { background:#fee2e2; color:#991b1b; }
    .btn-delete:hover:not(:disabled) { background:#fecaca; }
    .btn-delete:disabled { opacity:0.35; cursor:not-allowed; }

    .empty-td { text-align:center; padding:3rem 1rem; color:#6c757d; }
    .empty-td i { font-size:2.5rem; opacity:0.2; display:block; margin-bottom:0.75rem; }
    .empty-td p { margin:0; font-size:0.9rem; }

    .modal-overlay { display:none; position:fixed !important; top:0 !important; left:0 !important; right:0 !important; bottom:0 !important; width:100vw !important; height:100vh !important; background:rgba(0,0,0,0.5); z-index:999999 !important; transform:translateZ(9999px) !important; align-items:center; justify-content:center; }
    .modal-overlay.show { display:flex; }
    .modal-box { position:relative !important; z-index:1000000 !important; transform:translateZ(10000px) !important; background:white; border-radius:12px; width:90%; max-width:420px; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,0.15); }
    .modal-box-header { padding:1.25rem 1.5rem; border-bottom:1px solid #e1e8ed; display:flex; justify-content:space-between; align-items:center; }
    .modal-box-header h3 { margin:0; font-size:1rem; font-weight:600; color:var(--navy); }
    .btn-close-modal { background:none; border:none; cursor:pointer; color:#6c757d; width:30px; height:30px; border-radius:6px; display:flex; align-items:center; justify-content:center; transition:background 0.2s; }
    .btn-close-modal:hover { background:#f3f4f6; }
    .modal-box-body { padding:1.5rem; }
    .modal-box-footer { padding:1.25rem 1.5rem; border-top:1px solid #e1e8ed; display:flex; gap:0.75rem; justify-content:flex-end; }

    .form-group { margin-bottom:0; }
    .form-group label { display:block; font-size:0.875rem; font-weight:500; color:var(--text-dark); margin-bottom:0.4rem; }
    .required { color:#ef4444; }
    .form-group input { width:100%; padding:0.7rem 0.9rem; border:1px solid #e1e8ed; border-radius:8px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.2s; }
    .form-group input:focus { outline:none; border-color:var(--cyan); }

    .btn-batal { padding:0.6rem 1.5rem; border-radius:8px; border:1px solid #e1e8ed; background:white; color:var(--text-dark); font-weight:500; font-size:0.9rem; cursor:pointer; font-family:'Poppins',sans-serif; }
    .btn-batal:hover { background:#f3f4f6; }
    .btn-simpan { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.5rem; border-radius:8px; border:none; background:var(--cyan); color:white; font-weight:500; font-size:0.9rem; cursor:pointer; font-family:'Poppins',sans-serif; }
    .btn-simpan:hover { background:#0088a8; }
</style>
@endpush

@push('scripts')
<script>
    function openModal() {
        document.getElementById('kategoriModal').classList.add('show');
        document.getElementById('modalTitle').textContent = 'Tambah Kategori';
        document.getElementById('kategoriForm').action = '{{ route("admin.kategori.store") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('inputName').value = '';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('kategoriModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    function closeModalOutside(e) {
        if (e.target === document.getElementById('kategoriModal')) closeModal();
    }

    function editKategori(id, name) {
        document.getElementById('kategoriModal').classList.add('show');
        document.getElementById('modalTitle').textContent = 'Edit Kategori';
        document.getElementById('kategoriForm').action = `/admin/kategori/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('inputName').value = name;
        document.body.style.overflow = 'hidden';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endpush
