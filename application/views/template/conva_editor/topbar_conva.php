<?php
// ===================== TOPBAR_CONVA (UPGRADED) =====================
?>
<div id="main-area">
  <div id="topbar">
    <div class="left">
      <h2>OKRE Sketch</h2>
      <button id="sidebarToggle" class="top-btn" style="display:none;">
        <i class="fa-solid fa-eye"></i>
      </button>
      <div style="color:var(--muted);font-size:13px;">Editor PDF</div>
    </div>
    <div class="actions">
      <a href="<?= base_url() ?>notes/index/<?= $this->uri->segment(4) ?>/space" id="cancelBtn" class="top-btn">
        <i class="fa-solid fa-arrow-left"></i>
        <span class="btn-text">&nbsp;Batalkan</span>
      </a>
      <button id="shareBtn" class="top-btn">
        <i class="fa-solid fa-share-nodes"></i>
        <span class="btn-text">&nbsp;Bagikan</span>
      </button>
      <button id="saveServerTopBtn" class="top-btn">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span class="btn-text">&nbsp;Server</span>
      </button>
      <div class="dropdown">
        <button id="downloadTopBtn" class="top-btn">
          <i class="fa-solid fa-download"></i>
          <span class="btn-text">&nbsp;Download </span> 
          <i class="fa-solid fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="downloadDropdown">
          <button class="small-btn-dropdown" id="savePdfBtn"><i class="fa-solid fa-file-pdf"></i> PDF</button>
          <button class="small-btn-dropdown" id="downloadJpgBtn"><i class="fa-solid fa-image"></i> JPG</button>
        </div>
      </div>
    </div>
  </div>

  <div id="progressBar"><div id="progressFill"></div></div>

  <!-- ===================== MODAL KONFIRMASI ===================== -->
  <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered custom-modal-top">
      <div class="modal-content custom-modal">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          Apakah kamu ingin menutup halaman dan menyimpan perubahan?
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" id="btnTutupHalaman">Tutup Tanpa Menyimpan</button>
          <button type="button" class="btn btn-primary" id="btnSimpanPerubahan">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== MODAL BAGIKAN ===================== -->
  <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="shareModalLabel">
            <i class="fa-solid fa-share-nodes me-2"></i> Bagikan Dokumen
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p>Atur siapa saja yang dapat mengakses dokumen ini.</p>

          <div class="card mb-3">
            <div class="card-body py-2">
              <strong>Pemilik:</strong>
              <span class="text-muted" id="ownerNameText"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="memberSelect" class="form-label">Pilih anggota space</label>
            <select id="memberSelect" class="form-select"></select>
          </div>

          <div class="mb-3">
            <select class="form-select w-auto d-inline-block" id="roleSelect">
              <option value="viewer">Viewer</option>
              <option value="editor">Editor</option>
            </select>
            <button class="btn btn-primary" id="btnAddUser">Tambahkan</button>
          </div>

          <ul class="list-group" id="sharedUserList"></ul>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button class="btn btn-primary" id="saveShareChanges">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== TOAST NOTIFIKASI ===================== -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="liveToast" class="toast align-items-center text-white bg-primary border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">Berhasil disimpan.</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <!-- ===================== SCRIPT LOGIKA ===================== -->
  <script>
  document.addEventListener('DOMContentLoaded', async function() {
    const baseUrl = window.baseUrl || '<?= base_url() ?>';
    const idNote = window.noteId || <?= json_encode($note_id ?? null) ?>;
    const isReadonly = window.isReadonly || false;
    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
    const showToast = (msg, success = true) => {
      const toastEl = document.getElementById('liveToast');
      const msgEl = document.getElementById('toastMessage');
      msgEl.textContent = msg;
      toastEl.className = `toast align-items-center text-white border-0 bg-${success ? 'success' : 'danger'}`;
      toast.show();
    };

    
    // ========== KONFIRMASI SIMPAN ==========
    const cancelBtn = document.getElementById('cancelBtn');
    const btnSimpan = document.getElementById('btnSimpanPerubahan');
    const btnTutup = document.getElementById('btnTutupHalaman');
    const confirmModal = document.getElementById('confirmModal');
    let modalInstance = null;

    if (cancelBtn) {
      cancelBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modalInstance = new bootstrap.Modal(confirmModal);
        modalInstance.show();
        cancelBtn.dataset.href = cancelBtn.getAttribute('href');
      });
    }

    btnSimpan?.addEventListener('click', async function() {
      await saveCanvasToServer();
      const href = cancelBtn?.dataset.href;
      if (href) window.location.href = href;
      modalInstance?.hide();
    });

    btnTutup?.addEventListener('click', function() {
      const href = cancelBtn?.dataset.href;
      if (href) window.location.href = href;
      modalInstance?.hide();
    });

    async function saveCanvasToServer() {
      if (isReadonly) return showToast('Mode baca, tidak bisa menyimpan.', false);
      if (typeof stage === 'undefined') return showToast('Canvas belum siap!', false);

      const jsonData = stage.toJSON();
      const res = await fetch(`${baseUrl}index.php/notes/save_canvas_json/${idNote}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ json: jsonData })
      });
      const result = await res.json();
      if (result.status === 'success') showToast('✅ Coretan berhasil disimpan.');
      else showToast('❌ Gagal menyimpan coretan.', false);
    }

    document.getElementById('saveServerTopBtn')?.addEventListener('click', saveCanvasToServer);

    // ========== MODE READONLY ==========
    if (isReadonly) {
      document.getElementById('saveServerTopBtn').disabled = true;
      document.getElementById('shareBtn').disabled = true;
    }

    // ========== BAGIKAN DOKUMEN ==========
    const shareBtn = document.getElementById('shareBtn');
    const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
    const memberSelect = document.getElementById('memberSelect');
    const addUserBtn = document.getElementById('btnAddUser');
    const roleSelect = document.getElementById('roleSelect');
    const userList = document.getElementById('sharedUserList');
    const ownerText = document.getElementById('ownerNameText');

    shareBtn?.addEventListener('click', async () => {
      await Promise.all([loadOwner(), loadMembers(), loadSharedUsers()]);
      shareModal.show();
    });

    async function loadOwner() {
      const res = await fetch(`${baseUrl}index.php/notes/get_note_owner/${idNote}`);
      const data = await res.json();
      ownerText.textContent = data.success ? data.owner.nama : 'Tidak diketahui';
    }

    async function loadMembers() {
      memberSelect.innerHTML = '<option value="">Memuat...</option>';
      const res = await fetch(`${baseUrl}notes/get_space_members/${idNote}`);
      const data = await res.json();
      memberSelect.innerHTML = '<option value="">Pilih pengguna...</option>';
      data.forEach(u => {
        const opt = document.createElement('option');
        opt.value = u.id;
        opt.textContent = `${u.nama} (${u.username})`;
        memberSelect.appendChild(opt);
      });
    }

    async function loadSharedUsers() {
      userList.innerHTML = '';
      const res = await fetch(`${baseUrl}index.php/notes/get_shared_users/${idNote}`);
      const data = await res.json();

      if (!data.success || data.users.length === 0) {
        userList.innerHTML = '<li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>';
        return;
      }

      data.users.forEach(u => addSharedUserToList(u.id, u.nama, u.role));
    }

    function addSharedUserToList(userId, userName, role) {
      const li = document.createElement('li');
      li.dataset.userId = userId;
      li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
      li.innerHTML = `
        <div>
          <strong>${userName}</strong>
          <span class="badge bg-${role === 'editor' ? 'primary' : 'secondary'} ms-2 text-uppercase">${role}</span>
        </div>
        <div>
          <select class="form-select form-select-sm d-inline-block w-auto me-2 changeRole">
            <option value="viewer" ${role === 'viewer' ? 'selected' : ''}>Viewer</option>
            <option value="editor" ${role === 'editor' ? 'selected' : ''}>Editor</option>
          </select>
          <button class="btn btn-sm btn-outline-danger btnRemoveUser">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      `;
      userList.appendChild(li);
      li.querySelector('.btnRemoveUser').addEventListener('click', () => li.remove());
      li.querySelector('.changeRole').addEventListener('change', function() {
        const badge = li.querySelector('.badge');
        const newRole = this.value;
        badge.textContent = newRole;
        badge.className = `badge bg-${newRole === 'editor' ? 'primary' : 'secondary'} ms-2 text-uppercase`;
      });
    }

    addUserBtn.addEventListener('click', function() {
      const userId = memberSelect.value;
      const userName = memberSelect.options[memberSelect.selectedIndex]?.textContent;
      const role = roleSelect.value;
      if (!userId) return showToast('Pilih pengguna terlebih dahulu!', false);
      if (document.querySelector(`#sharedUserList li[data-user-id="${userId}"]`)) {
        showToast('Pengguna sudah ditambahkan.', false);
        return;
      }
      addSharedUserToList(userId, userName, role);
    });

    // ========== SIMPAN PEMBAGIAN ==========
    document.getElementById('saveShareChanges').addEventListener('click', async () => {
      const selectedUsers = [];
      document.querySelectorAll('#sharedUserList li').forEach(li => {
        selectedUsers.push({ id: li.dataset.userId, role: li.querySelector('.changeRole').value });
      });

      const res = await fetch(`${baseUrl}index.php/notes/share_to_users`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_note: idNote, users: selectedUsers })
      });

      const result = await res.json();
      if (result.success) {
        showToast('✅ Dokumen berhasil dibagikan.');
        shareModal.hide();
      } else {
        showToast('❌ Gagal menyimpan pembagian dokumen.', false);
      }
    });
  });
  </script>
</div>
