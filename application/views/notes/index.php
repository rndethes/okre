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
                      $this->db->select('role');
                      $this->db->where('id_notes', $n['id_note']);
                      $this->db->where('id_users', $userId);
                      $this->db->where('state_note_share', 'active');
                      $share = $this->db->get('notes_share')->row_array();
                      if ($share) $role = $share['role'];
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
                      <a href="<?= base_url('notes/view_pdf/'.$n['file_note'].'/'.$this->session->userdata('workspace_sesi')) ?>" 
                      target="_blank" 
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
                      <a href="<?= base_url('notes/delete/'.$n['id_note']) ?>"
                         onclick="return confirm('Yakin hapus dokumen ini?')"
                         class="btn btn-sm btn-danger rounded-pill" title="Hapus">
                        <i class="fas fa-trash"></i>
                      </a>
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

<!-- ===================== MODAL BAGIKAN ===================== -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="shareModalLabel">
          <i class="fas fa-share-alt me-2"></i> Bagikan Dokumen ke Anggota Space
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="noteIdToShare">

        <p>Pilih anggota yang ingin diberi akses ke dokumen ini.</p>

        <div class="input-group mb-3">
          <select id="userSelect" class="form-select">
            <option value="">-- Pilih pengguna --</option>
            <?php foreach ($space_members as $member): ?>
              <?php if ($member['id'] != $this->session->userdata('id')): ?>
                <option value="<?= $member['id'] ?>"><?= $member['nama'] ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>

          <select id="roleSelect" class="form-select" style="max-width:140px;">
            <option value="viewer">Viewer</option>
            <option value="editor">Editor</option>
          </select>

          <button class="btn btn-primary" id="btnAddShare">Tambahkan</button>
        </div>

        <ul class="list-group" id="sharedUserList">
          <li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>
        </ul>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-success" id="btnSaveShare">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<style>
#sharedUserList .list-group-item { margin-bottom: 5px; }
</style>

<!-- ===================== SCRIPT BAGIKAN ===================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
  let noteId = null;
  let sharedUsers = [];

  document.querySelectorAll('.btnShare').forEach(btn => {
    btn.addEventListener('click', function() {
      noteId = this.dataset.id;
      document.getElementById('noteIdToShare').value = noteId;
      document.getElementById('sharedUserList').innerHTML = `
        <li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>`;
      sharedUsers = [];
      shareModal.show();
    });
  });

  document.getElementById('btnAddShare').addEventListener('click', function() {
    const userSelect = document.getElementById('userSelect');
    const roleSelect = document.getElementById('roleSelect');
    const userId = userSelect.value;
    const userName = userSelect.options[userSelect.selectedIndex].text;
    const role = roleSelect.value;

    if (!userId) return alert('Pilih pengguna terlebih dahulu.');

    if (!sharedUsers.find(u => u.id == userId)) {
      sharedUsers.push({ id: userId, name: userName, role });
      const list = document.getElementById('sharedUserList');
      if (list.children[0].classList.contains('text-muted')) list.innerHTML = '';

      const li = document.createElement('li');
      li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
      li.innerHTML = `
        <div><strong>${userName}</strong>
          <span class="badge bg-${role === 'editor' ? 'primary' : 'secondary'} ms-2 text-uppercase">${role}</span>
        </div>
        <button class="btn btn-sm btn-outline-danger btnRemoveUser"><i class="fas fa-times"></i></button>
      `;
      li.querySelector('.btnRemoveUser').addEventListener('click', () => {
        li.remove();
        sharedUsers = sharedUsers.filter(u => u.id != userId);
        if (sharedUsers.length === 0) {
          list.innerHTML = `<li class="list-group-item text-muted small text-center">Belum ada pengguna ditambahkan.</li>`;
        }
      });
      list.appendChild(li);
    } else {
      alert('Pengguna ini sudah ditambahkan.');
    }
  });

  document.getElementById('btnSaveShare').addEventListener('click', function() {
    if (sharedUsers.length === 0) return alert('Belum ada pengguna untuk dibagikan.');

    fetch('<?= base_url("notes/share_to_users") ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        id_note: noteId,
        users: sharedUsers
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Dokumen berhasil dibagikan.');
        shareModal.hide();
        location.reload();
      } else {
        alert('Gagal menyimpan data: ' + data.message);
      }
    })
    .catch(err => console.error('Error:', err));
  });
});
</script>

<!-- Tooltip Bootstrap -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });
});
</script>
