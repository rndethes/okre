<?php if (!isset($space)) $space = []; ?>
<!-- ======================== HEADER ======================== -->
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Workspace</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Workspace</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $space['name_space'] ?? 'Catatan' ?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ======================== MAIN CONTENT ======================== -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">

      <!-- Workspace Info -->
      <div class="alert alert-secondary" role="alert">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <h3 class="text-primary">
              <button type="button" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
              </button>
              WORKSPACE <?= $space['name_space'] ?? '' ?>
            </h3>
          </div>
          <div class="col-lg-4">
            <div class="d-flex justify-content-end">
              <a href="<?= base_url('project') ?>" class="btn btn-danger rounded-pill text-white">
                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Tabs -->
      <ul class="nav nav-pills nav-fill flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('project/projectAtWorkspace/').$this->session->userdata('workspace_sesi') ?>">OKR</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('task/index/').$this->session->userdata('workspace_sesi').'/space' ?>">Task</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('document/index/').$this->session->userdata('workspace_sesi').'/space' ?>">Document</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= base_url('notes/index/').$this->session->userdata('workspace_sesi').'/space' ?>">Sketch</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('workspace/chatspace/').$this->session->userdata('workspace_sesi').'/space' ?>">Chat</a></li>
      </ul>

      <!-- Flash message -->
      <?php if($this->session->flashdata('flashPj')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
          <?= $this->session->flashdata('flashPj'); ?>
          <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <!-- Upload Section -->
      <div class="card mb-4">
        <div class="card-body text-center">
          <h2 class="mb-4">Upload PDF Baru atau Mulai Canvas Kosong</h2>
          <div class="d-flex justify-content-center gap-3 mb-3">
            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadModal">
              <i class="fas fa-upload me-1"></i> Upload & Edit
            </button>
            <form action="<?= base_url('notes/canvas_blank') ?>" method="post">
              <button type="submit" class="btn btn-secondary rounded-pill">
                <i class="fas fa-pen-nib me-1"></i> Mulai Canvas Kosong
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Upload -->
      <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="fas fa-file-upload me-1"></i> Upload Dokumen PDF</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="uploadForm" action="<?= base_url('notes/upload_action') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Nama Dokumen</label>
                  <input type="text" name="name_notes" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Upload File PDF</label>
                  <input type="file" name="pdf_file" accept="application/pdf" class="form-control" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary rounded-pill">Upload</button>
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- ======================== DAFTAR DOKUMEN ======================== -->
      <div class="card">
        <div class="card-body">
          <h4 class="mb-3"><i class="fas fa-file-alt me-2"></i>Daftar Dokumen</h4>

          <div class="table-responsive">
            <table class="table align-items-center">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Dokumen</th>
                  <th scope="col">Tanggal Dibuat</th>
                  <th scope="col">Jenis</th>
                  <th scope="col">Dibagikan Ke</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="list">
                <?php if(!empty($notes)): foreach($notes as $n): ?>
                <?php 
                  $shared = $n['shared_users'] ?? [];
                  $isOwner = ($n['created_by'] == $this->session->userdata('id'));
                  $userId  = $this->session->userdata('id');
                  $role = 'none';
                  if (!$isOwner) {
                      $role = $n['role'] ?? 'none';
                      $isOwner = ($role === 'owner');
                  } else {
                      $role = 'owner';
                  }
                ?>

                <tr>
                  <th scope="row">
                    <div class="media align-items-center">
                      <div class="avatar rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width:45px; height:45px;">
                        <i class="fas fa-file-pdf text-danger"></i>
                      </div>
                      <div class="media-body">
                        <span class="fw-bold mb-0 text-sm"><?= $n['name_notes'] ?></span><br>
                        <small class="text-muted"><?= $n['file_note'] ?></small>
                      </div>
                    </div>
                  </th>

                  <td><?= date('d M Y H:i', strtotime($n['created_date'])) ?></td>

                  <?php 
                    if($n['type_note'] == "document") {
                      $showBadge = '<span class="badge badge-pill badge-warning">Document</span>';
                    } else {
                      $showBadge = '<span class="badge badge-pill badge-default">Blank Canvas</span>';
                    }
                  ?>

                  <td><?= $showBadge ?></td>

                  <td>
                    <div class="avatar-group d-flex">
                      <?php if(!empty($shared)): ?>
                        <?php foreach($shared as $s): ?>
                          <span class="avatar avatar-sm rounded-circle bg-secondary text-white me-1 d-inline-flex align-items-center justify-content-center"
                                data-bs-toggle="tooltip" title="<?= $s['nama'] ?>">
                            <?= strtoupper(substr($s['nama'], 0, 1)) ?>
                          </span>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <span class="text-muted small">Belum dibagikan</span>
                      <?php endif; ?>
                    </div>
                  </td>

                  <td class="text-center">
                    <?php if(in_array($role, ['owner','editor','viewer'])): ?>
                     <a href="<?= base_url('notes/view_doc/'.$n['reff_note'].'/'.$this->session->userdata('workspace_sesi')) ?>" 
                     class="btn btn-sm btn-info rounded-pill me-1" 
                     title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>

                      </a>
                    <?php endif; ?>

                    <?php if(in_array($role, ['owner','editor'])): ?>
                      <?php if($n['type_note'] == "document") { ?>
                        <a href="<?= base_url('notes/konva/'.$n['reff_note'].'/'.$n['file_note'].'/'.$this->session->userdata('workspace_sesi')) ?>"
                         class="btn btn-sm btn-primary rounded-pill me-1" title="Edit">
                        <i class="fas fa-pen"></i>
                      </a>
                      <?php } else { ?>
                         <a href="<?= base_url('notes/canvas_blank/'.$n['reff_note']) ?>"
                          class="btn btn-sm btn-primary rounded-pill me-1" title="Edit">
                          <i class="fas fa-pen"></i>
                        </a>
                      <?php } ?>
                      
                    <?php endif; ?>

                    <?php if($role == 'owner'): ?>
                      <button class="btn btn-sm btn-success rounded-pill me-1 btnShare"
                              data-id="<?= $n['id_note'] ?>" title="Bagikan">
                        <i class="fas fa-share"></i>
                      </button>
                      <button 
                      class="btn btn-sm btn-danger rounded-pill btnDeleteNote" 
                      data-id="<?= $n['id_note'] ?>" 
                      data-name="<?= htmlspecialchars($n['name_notes'], ENT_QUOTES) ?>"title="Hapus">
                      <i class="fas fa-trash"></i>
                    </button>

                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada dokumen.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ===================== MODAL BAGIKAN (TAMPILAN SAMA DENGAN TOPBAR_CONVA) ===================== -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-white border-bottom">
        <h5 class="modal-title fw-semibold d-flex align-items-center text-dark" id="shareModalLabel">
          <i class="fa-solid fa-share-nodes me-2 text-primary"></i> Bagikan Dokumen
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="noteIdToShare">
        <p class="text-muted mb-3">Atur siapa saja yang dapat mengakses dokumen ini.</p>

        <!-- Pemilik -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Pemilik:</label>
          <input type="text" class="form-control bg-light" id="ownerNameText" readonly value="-">
        </div>

        <!-- Tambahkan anggota -->
        <label class="form-label fw-semibold">Pilih anggota space</label>
        <div class="d-flex flex-wrap gap-2 mb-3">
          <select id="memberSelect" class="form-select flex-grow-1" style="min-width: 220px;">
            <option value="">Pilih pengguna...</option>
          </select>
          <select id="roleSelect" class="form-select" style="width: 130px;">
            <option value="viewer">Viewer</option>
            <option value="editor">Editor</option>
          </select>
          <button id="btnAddUser" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambahkan
          </button>
        </div>

        <!-- Daftar pengguna -->
        <ul class="list-group" id="userList">
          <li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>
        </ul>
      </div>

      <div class="modal-footer bg-light border-top">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary rounded-pill" id="saveShareChanges">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<style>
#shareModal .form-label { margin-bottom: .3rem; }
#shareModal .list-group-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
#shareModal .roleSelect { width: 120px; }
</style>


<!-- ===================== SCRIPT BAGIKAN (IDENTIK TOPBAR_CONVA) ===================== -->
<script>
document.addEventListener('DOMContentLoaded', async function() {
  const baseUrl = window.baseUrl || '<?= base_url() ?>';
  const shareModalEl = document.getElementById('shareModal');
  const shareModal = new bootstrap.Modal(shareModalEl);
  const memberSelect = document.getElementById('memberSelect');
  const addUserBtn = document.getElementById('btnAddUser');
  const roleSelect = document.getElementById('roleSelect');
  const userList = document.getElementById('userList'); 
  const ownerText = document.getElementById('ownerNameText');
  const noteIdInput = document.getElementById('noteIdToShare'); // hidden input untuk noteId

  const toast = new bootstrap.Toast(document.getElementById('liveToast'));
  const showToast = (msg, success = true) => {
    const toastEl = document.getElementById('liveToast');
    const msgEl = document.getElementById('toastMessage');
    msgEl.textContent = msg;
    toastEl.className = `toast align-items-center text-white border-0 bg-${success ? 'success' : 'danger'}`;
    toast.show();
  };

  // === Klik tombol "Bagikan" tiap baris dokumen ===
  document.querySelectorAll('.btnShare').forEach(btn => {
    btn.addEventListener('click', async function() {
      const noteId = this.dataset.id; // ambil id note dari tombol
      noteIdInput.value = noteId; // simpan di hidden input modal

      let ownerId = await loadOwner(noteId);
      await loadMembers(noteId, ownerId);
      await loadSharedUsers(noteId);

      shareModal.show();
    });
  });

  async function loadOwner(noteId){
    const res = await fetch(`${baseUrl}index.php/notes/get_note_owner/${noteId}`);
    const data = await res.json();
    if(data.success){
      ownerText.value = data.owner.nama; // input readonly
      return data.owner.id;
    }
    ownerText.value = '-';
    return null;
  }

  async function loadMembers(noteId, ownerId){
    memberSelect.innerHTML = '<option value="">Memuat...</option>';
    const res = await fetch(`${baseUrl}index.php/notes/get_space_members/${noteId}`);
    const data = await res.json();
    memberSelect.innerHTML = '<option value="">Pilih pengguna...</option>';
    data.forEach(u => {
      if(u.id != ownerId){
        const opt = document.createElement('option');
        opt.value = u.id;
        opt.textContent = `${u.nama} (${u.username})`;
        memberSelect.appendChild(opt);
      }
    });
  }

  async function loadSharedUsers(noteId){
    userList.innerHTML = '';
    const res = await fetch(`${baseUrl}index.php/notes/get_shared_users/${noteId}`);
    const data = await res.json();
    if(!data.success || data.users.length === 0){
      userList.innerHTML = '<li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>';
      return;
    }
    data.users.forEach(u => addSharedUserToList(u.id, u.nama, u.role));
  }

  function addSharedUserToList(userId, userName, role){
    const li = document.createElement('li');
    li.dataset.userId = userId;
    li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
    li.innerHTML = `
      <div>
        <strong>${userName}</strong>
        <span class="badge bg-${role==='editor'?'primary':'secondary'} ms-2 text-uppercase">${role}</span>
      </div>
      <div>
        <select class="form-select form-select-sm d-inline-block w-auto me-2 changeRole">
          <option value="viewer" ${role==='viewer'?'selected':''}>Viewer</option>
          <option value="editor" ${role==='editor'?'selected':''}>Editor</option>
        </select>
        <button class="btn btn-sm btn-outline-danger btnRemoveUser">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    `;
    userList.appendChild(li);
    li.querySelector('.btnRemoveUser').addEventListener('click', ()=>li.remove());
    li.querySelector('.changeRole').addEventListener('change', function(){
      const badge = li.querySelector('.badge');
      const newRole = this.value;
      badge.textContent = newRole;
      badge.className = `badge bg-${newRole==='editor'?'primary':'secondary'} ms-2 text-uppercase`;
    });
  }

  addUserBtn.addEventListener('click', function(){
    const userId = memberSelect.value;
    const userName = memberSelect.options[memberSelect.selectedIndex]?.textContent;
    const role = roleSelect.value;
    if(!userId) return showToast('Pilih pengguna terlebih dahulu!', false);
        if(document.querySelector(`#userList li[data-user-id="${userId}"]`)){
      showToast('Pengguna sudah ditambahkan.', false);
      return;
    }
    addSharedUserToList(userId, userName, role);
  });

  document.getElementById('saveShareChanges').addEventListener('click', async () => {
    const noteId = noteIdInput.value;
    const selectedUsers = [];
    document.querySelectorAll('#userList li').forEach(li => {
      selectedUsers.push({
        id: li.dataset.userId,
        role: li.querySelector('.changeRole').value
      });
    });


    const res = await fetch(`${baseUrl}index.php/notes/share_to_users`, {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({id_note:noteId, users:selectedUsers})
    });
    const result = await res.json();
    if(result.success){
      showToast('✅ Dokumen berhasil dibagikan.');
      shareModal.hide();
    }else{
      showToast('❌ Gagal menyimpan pembagian dokumen.', false);
    }
  });
});
</script>



<!-- ===================== MODAL KONFIRMASI HAPUS  ===================== -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Apakah Anda yakin ingin menghapus dokumen <strong id="docName"></strong>?</p>
        <p class="text-muted small">Tindakan ini akan menghapus juga semua data bagikan yang terkait.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
        <a href="#" id="btnConfirmDelete" class="btn btn-danger rounded-pill">Hapus</a>
      </div>
    </div>
  </div>
</div>

<style>
#sharedUserList .list-group-item { margin-bottom: 5px; }
</style>



<!-- Tooltip Bootstrap -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
  const docNameEl = document.getElementById('docName');
  const confirmBtn = document.getElementById('btnConfirmDelete');

  document.querySelectorAll('.btnDeleteNote').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const name = this.dataset.name;
      // Isi nama dokumen di modal
      docNameEl.textContent = `"${name}"`;
      // Set tautan hapus sesuai ID note
      confirmBtn.href = `<?= base_url('notes/delete/') ?>${id}`;
      // Tampilkan modal konfirmasi
      deleteModal.show();
    });
  });
});
</script>

