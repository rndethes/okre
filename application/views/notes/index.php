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

      <!-- Flash message sukses -->
      <?php if($this->session->flashdata('flashPj')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
          <?= $this->session->flashdata('flashPj'); ?>
          <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <!-- Upload & Daftar Dokumen -->
      <div class="card mb-4">
        <div class="card-body">
          <h2 class="text-center mb-4">Upload PDF Baru atau Mulai Canvas Kosong</h2>

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

          <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
          <?php endif; ?>
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
                  <input type="text" name="name_notes" class="form-control" placeholder="Masukkan nama dokumen" required>
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

      <!-- Daftar Dokumen -->
      <div class="card">
        <div class="card-body">
          <h4 class="mb-3"><i class="fas fa-file-alt me-2"></i>Daftar Dokumen</h4>
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
              <thead class="table-primary">
                <tr>
                  <th>No</th>
                  <th>Nama Dokumen</th>
                  <th>File</th>
                  <th>Tanggal Dibuat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($notes)): $no=1; foreach($notes as $n): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $n['name_notes'] ?></td>
                    <td><?= $n['file_note'] ?></td>
                    <td><?= date('d M Y H:i', strtotime($n['created_date'])) ?></td>
                    <td>
                      <a href="<?= base_url('notes/view_pdf/'.$n['file_note']) ?>" target="_blank" class="btn btn-sm btn-info rounded-pill">
                        <i class="fas fa-eye"></i> Lihat
                      </a>
                      <a href="<?= base_url('notes/delete/'.$n['id_note']) ?>" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Yakin hapus dokumen ini?')">
                        <i class="fas fa-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr><td colspan="5" class="text-center">Belum ada dokumen.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Optional: Auto-refresh tabel setelah upload sukses -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const flash = <?= json_encode($this->session->flashdata('flashPj')); ?>;
    if (flash) {
      setTimeout(() => {
        location.reload();
      }, 1000);
    }
  });
  
</script>
