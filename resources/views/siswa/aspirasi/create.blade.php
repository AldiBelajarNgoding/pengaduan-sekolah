@extends('layouts.siswa')

@section('title', 'Buat Pengaduan')

@section('content')

<div class="page-header">
    <div>
        <h1>Buat Pengaduan</h1>
        <p class="page-subtitle">Sampaikan aspirasimu dengan jelas dan detail</p>
    </div>
    <a href="{{ route('siswa.dashboard') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form action="{{ route('siswa.aspirasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <!-- Kategori -->
            <div class="form-group">
                <label for="category_id">Kategori <span class="required">*</span></label>
                <div class="select-wrap">
                    <select name="category_id" id="category_id" required
                            class="{{ $errors->has('category_id') ? 'is-error' : '' }}">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('category_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->name }}
                        </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down select-arrow"></i>
                </div>
                @error('category_id')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <!-- Lokasi -->
            <div class="form-group">
                <label for="lokasi">Lokasi <span class="required">*</span></label>
                <div class="select-wrap">
                    <select name="lokasi" id="lokasi" required class="{{ $errors->has('lokasi') ? 'is-error' : '' }}">
                        <option value="">-- Pilih Lokasi --</option>
                        <option value="ruang_kelas"  {{ old('lokasi') == 'ruang_kelas'  ? 'selected' : '' }}>Ruang Kelas</option>
                        <option value="toilet"       {{ old('lokasi') == 'toilet'       ? 'selected' : '' }}>Toilet</option>
                        <option value="kantin"       {{ old('lokasi') == 'kantin'       ? 'selected' : '' }}>Kantin</option>
                        <option value="perpustakaan" {{ old('lokasi') == 'perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                        <option value="laboratorium" {{ old('lokasi') == 'laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                        <option value="lapangan"     {{ old('lokasi') == 'lapangan'     ? 'selected' : '' }}>Lapangan</option>
                        <option value="mushola"      {{ old('lokasi') == 'mushola'      ? 'selected' : '' }}>Mushola</option>
                        <option value="parkiran"     {{ old('lokasi') == 'parkiran'     ? 'selected' : '' }}>Parkiran</option>
                        <option value="koridor"      {{ old('lokasi') == 'koridor'      ? 'selected' : '' }}>Koridor / Lorong</option>
                        <option value="lainnya"      {{ old('lokasi') == 'lainnya'      ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <i class="bi bi-chevron-down select-arrow"></i>
                </div>
                @error('lokasi')<span class="error-msg">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Judul -->
        <div class="form-group">
            <label for="judul">Judul Pengaduan <span class="required">*</span></label>
            <input type="text" name="judul" id="judul"
                   placeholder="Contoh: Toilet lantai 2 rusak dan tidak ada air"
                   value="{{ old('judul') }}" required
                   class="{{ $errors->has('judul') ? 'is-error' : '' }}">
            @error('judul')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi <span class="required">*</span></label>
            <textarea name="deskripsi" id="deskripsi" rows="5"
                      placeholder="Jelaskan masalah secara detail: kondisi, sudah berapa lama, dampaknya..."
                      required class="{{ $errors->has('deskripsi') ? 'is-error' : '' }}">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <!-- Foto -->
        <div class="form-group">
            <label>Foto Bukti <span class="optional">(opsional, maks. 2MB)</span></label>
            <div class="upload-area" id="uploadArea" onclick="document.getElementById('photo').click()">
                <div class="upload-placeholder" id="uploadPlaceholder">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <p>Klik untuk upload foto</p>
                    <span>JPG, JPEG, PNG, WEBP</span>
                </div>
                <div class="upload-preview" id="uploadPreview" style="display:none;">
                    <img id="previewImg" src="" alt="Preview">
                    <button type="button" class="btn-remove-photo" onclick="removePhoto(event)">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>
            <input type="file" name="photo" id="photo" accept="image/*" style="display:none;">
            @error('photo')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('siswa.dashboard') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-send"></i> Kirim Pengaduan
            </button>
        </div>
    </form>
</div>

@endsection

@push('styles')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
    .page-header h1 { font-size:1.6rem; font-weight:700; color:var(--navy); margin:0 0 0.2rem; }
    .page-subtitle { color:#6c757d; font-size:0.88rem; margin:0; }

    .btn-back {
        display:inline-flex; align-items:center; gap:0.5rem; padding:0.6rem 1.25rem;
        border-radius:8px; border:1px solid #e1e8ed; background:white;
        color:var(--text-dark); text-decoration:none; font-size:0.9rem; transition:background 0.2s;
    }
    .btn-back:hover { background:#f3f4f6; }

    .form-card { background:white; border-radius:12px; border:1px solid #e1e8ed; padding:2rem; max-width:700px; }

    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }

    .form-group { margin-bottom:1.5rem; }
    .form-group label { display:block; font-size:0.9rem; font-weight:500; color:var(--text-dark); margin-bottom:0.5rem; }
    .required { color:#ef4444; }
    .optional { color:#94a3b8; font-weight:400; font-size:0.8rem; }

    .form-group input,
    .form-group textarea {
        width:100%; padding:0.75rem 1rem; border:2px solid #e1e8ed;
        border-radius:8px; font-size:0.9rem; font-family:'Poppins',sans-serif; transition:border-color 0.2s;
    }
    .form-group input:focus,
    .form-group textarea:focus { outline:none; border-color:var(--orange); }
    .form-group textarea { resize:vertical; }
    .is-error { border-color:#ef4444 !important; }
    .error-msg { font-size:0.8rem; color:#ef4444; margin-top:0.35rem; display:block; }

    /* Custom Select */
    .select-wrap { position:relative; }
    .select-wrap select {
        width:100%; padding:0.75rem 2.5rem 0.75rem 1rem;
        border:2px solid #e1e8ed; border-radius:8px;
        font-size:0.9rem; font-family:'Poppins',sans-serif;
        appearance:none; -webkit-appearance:none;
        background:white; cursor:pointer; transition:border-color 0.2s;
    }
    .select-wrap select:focus { outline:none; border-color:var(--orange); }
    .select-arrow {
        position:absolute; right:0.9rem; top:50%; transform:translateY(-50%);
        color:#94a3b8; font-size:0.85rem; pointer-events:none;
    }

    /* Upload */
    .upload-area {
        border:2px dashed #e1e8ed; border-radius:10px; cursor:pointer;
        transition:border-color 0.2s; overflow:hidden; min-height:130px;
        display:flex; align-items:center; justify-content:center;
    }
    .upload-area:hover { border-color:var(--orange); }
    .upload-placeholder { text-align:center; padding:2rem; color:#94a3b8; }
    .upload-placeholder i { font-size:2rem; display:block; margin-bottom:0.5rem; color:#cbd5e1; }
    .upload-placeholder p { margin:0 0 0.2rem; font-size:0.88rem; color:#6c757d; font-weight:500; }
    .upload-placeholder span { font-size:0.75rem; }
    .upload-preview { position:relative; width:100%; }
    .upload-preview img { width:100%; max-height:240px; object-fit:cover; display:block; }
    .btn-remove-photo {
        position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.5);
        border:none; border-radius:50%; color:white; width:28px; height:28px;
        display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:1rem;
    }
    .btn-remove-photo:hover { background:rgba(239,68,68,0.85); }

    .form-actions { display:flex; gap:1rem; justify-content:flex-end; padding-top:1rem; border-top:1px solid #f0f4f8; }
    .btn-cancel {
        padding:0.7rem 1.5rem; border-radius:8px; border:1px solid #e1e8ed;
        background:white; color:var(--text-dark); text-decoration:none; font-size:0.9rem; font-weight:500;
    }
    .btn-cancel:hover { background:#f3f4f6; }
    .btn-submit {
        display:inline-flex; align-items:center; gap:0.5rem; padding:0.7rem 1.5rem;
        border-radius:8px; border:none; background:var(--orange); color:white;
        font-size:0.9rem; font-weight:600; cursor:pointer; transition:background 0.2s; font-family:'Poppins',sans-serif;
    }
    .btn-submit:hover { background:#e68a00; }

    @media(max-width:600px) { .form-row { grid-template-columns:1fr; } }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2MB.');
            this.value = '';
            return;
        }

        const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            alert('Format foto harus JPG, JPEG, PNG, atau WEBP.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('uploadPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    function removePhoto(e) {
        e.stopPropagation();
        document.getElementById('photo').value = '';
        document.getElementById('previewImg').src = '';
        document.getElementById('uploadPlaceholder').style.display = 'block';
        document.getElementById('uploadPreview').style.display = 'none';
    }
</script>
@endpush
