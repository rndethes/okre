
  <div id="leftbar">
  <div class="left-top">
    <div id="addPageBtn" class="left-icon" title="Tambah Halaman">
      <i class="fa-solid fa-plus"></i>
    </div>
    <div id="previewPanel" aria-live="polite" aria-label="Preview halaman"></div>

    <div id="deletePageBtn" class="left-icon" title="Hapus Halaman">
      <i class="fa-solid fa-trash"></i>
    </div>
  </div>

  <div class="sidebar-footer">
    <div id="settingsBtn" class="left-icon" title="Pengaturan">
      <i class="fa-solid fa-gear"></i>
    </div>
  </div>
</div>



  <div id="main-area">
    <div id="topbar">
      <div class="left"><h2>
  <img src="http://localhost/projectint/okre/assets/img/logo.png" alt="OKRE Logo" style="width:22px;height:22px;object-fit:contain;vertical-align:middle;margin-right:6px;">
  OKRE Sketch
</h2><div style="color:var(--muted);font-size:13px;margin-left:12px">Canvas Blank</div></div>
      <input type="hidden" id="editable" value="<?= $editable ?>">
      <input type="hidden" id="back_url" value="<?= base_url() ?>notes/index/<?= $this->session->userdata('workspace_sesi') ?>/space">
      <div class="actions" style="display:flex;gap:10px;align-items:center">
        <a href="<?= base_url() ?>notes/index/<?= $this->session->userdata('workspace_sesi') ?>/space" id="cancelBtn" class="top-btn">
          <i class="fa-solid fa-arrow-left"></i> <span class="btn-text">&nbsp;Batalkan</span>
        </a>
        <button id="shareBtn" class="top-btn">
        <i class="fa-solid fa-share-nodes"></i>
        <span class="btn-text">&nbsp;Bagikan</span>
      </button>
        <button id="downloadTopBtn" class="top-btn"><i class="fa-solid fa-download"></i><span class="btn-text">&nbsp;Download</span></button>
        <button id="saveTopBtn" class="top-btn"><i class="fa-solid fa-cloud-arrow-up"></i><span class="btn-text">&nbsp;Simpan</span></button>
      </div>
    </div>

    <div id="container" class="container"></div>
  </div>
</div>

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

<!-- SETTINGS POPUP -->
<div class="popup-sidebar" id="settingsPopup" style="position:fixed; left:96px; bottom:84px; display:none; z-index:1200;">
  <label>Mode tampilan</label>
  <div style="display:flex;gap:8px;margin-bottom:8px;">
    <button class="small-btn" id="themeLightBtn">Light</button>
    <button class="small-btn" id="themeDarkBtn">Dark</button>
  </div>
</div>

<!-- BOTTOM TOOLBAR -->
<div class="bottom-toolbar" id="bottomToolbar">
    <div class="tool-btn" id="quickBrush" title="Brush">
      <i class="fa-solid fa-pen-nib"></i>
    </div>
    <div class="tool-btn" id="touchToggleBtn" title="Mode Coretan Jari">
      <i class="fa-solid fa-hand-point-up"></i>
    </div>
    <div class="tool-btn" id="panToggleBtn" title="Scroll Mode">
      <i class="fa-solid fa-hand"></i>
    </div>
    <div class="tool-btn" id="quickEraser" title="Eraser">
      <i class="fa-solid fa-eraser"></i>
    </div>
   <div class="tool-btn" id="btnDraw" title="Draw / Tools">
    <i class="fa-solid fa-palette"></i>
    <div class="popup" id="popupDraw" style="display:none;">
      <div class="popup-row">
        <label><i class="fa-solid fa-droplet"></i></label>
        <input type="color" id="colorPicker" value="#000000ff">
      </div>

      <div class="popup-row">
        <label><i class="fa-solid fa-ruler-horizontal"></i></label>
        <input type="range" id="sizePicker" min="1" max="60" value="4">
      </div>
    </div>
  </div>

  <!-- ZOOM -->
   
  <div class="tool-btn" id="btnZoom" title="Zoom">
    <i class="fa-solid fa-magnifying-glass-plus"></i>
    <div class="popup" id="popupZoom" style="display:none;">
      <div style="display:flex;gap:8px;align-items:center;">
        <button class="small-btn" id="zoomOutBtn"><i class="fa-solid fa-minus"></i></button>
        <div id="zoomPercent" style="min-width:56px;text-align:center;font-weight:600">100%</div>
        <button class="small-btn" id="zoomInBtn"><i class="fa-solid fa-plus"></i></button>
      </div>
      <div style="height:2px"></div>
      <button class="small-btn" id="fitBtn" title="Fit Width"><i class="fa-solid fa-expand"></i></button>
    </div>
  </div>

  <!-- UNDO -->
  <div class="tool-btn" id="btnUndo" title="Undo">
    <i class="fa-solid fa-rotate-left"></i>
  </div>

  <!-- REDO -->
  <div class="tool-btn" id="btnRedo" title="Redo">
    <i class="fa-solid fa-rotate-right"></i>
  </div>

  <!-- CLEAR ALL -->
  <div class="tool-btn" id="btnClear" title="Hapus semua coretan">
    <i class="fa-solid fa-trash-can"></i>
  </div>

  <!-- Hidden color picker -->
  <input type="hidden" id="colorPicker2" value="#000000ff">
   <input type="text" id="noteid" value="<?= $note_id ?>">
    <input type="text" id="colorPicker2" value="#000000ff">
</div>

 <script>
  document.addEventListener('DOMContentLoaded', async function() {
    const baseUrl = window.baseUrl || '<?= base_url() ?>';
    const idNote = document.getElementById("noteid").value;
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




    btnTutup?.addEventListener('click', function() {
      const href = cancelBtn?.dataset.href;
      if (href) window.location.href = href;
      modalInstance?.hide();
    });

 

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
      const res = await fetch(`${baseUrl}/notes/get_note_owner/${idNote}`);
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

 

  });
  </script>



