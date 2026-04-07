<!-- Modal Logout -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="bi bi-box-arrow-right"></i> Konfirmasi Keluar</h3>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin keluar dari sistem? Anda perlu login kembali untuk mengakses dashboard.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeLogoutModal()">Batal</button>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 999999 !important;
        transform: translateZ(9999px) !important;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        position: relative !important;
        z-index: 1000000 !important;
        transform: translateZ(10000px) !important;
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e1e8ed;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-header h3 i {
        color: #ef4444;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body p {
        margin: 0;
        color: #6c757d;
        line-height: 1.6;
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e1e8ed;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        border: 1px solid #e1e8ed;
        background: white;
        color: var(--text-dark);
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f3f4f6;
    }

    .btn-logout {
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        border: none;
        background: #ef4444;
        color: white;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-logout:hover {
        background: #dc2626;
    }
</style>

<script>
    function openLogoutModal(event) {
        event.preventDefault();
        document.getElementById('logoutModal').classList.add('show');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.remove('show');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('logoutModal');
        if (event.target === modal) {
            closeLogoutModal();
        }
    }
</script>
