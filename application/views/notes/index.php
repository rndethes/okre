<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Upload & Catatan PDF</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: #f5f6fa;
      font-family: 'Arial', sans-serif;
      padding: 20px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      background: #fff;
      padding: 20px;
    }
    h2 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
    }
    th {
      background: #007bff;
      color: #fff;
    }
  </style>
</head>
<body>

<div class="container">

  <!-- Bagian Upload -->
  <div class="card mb-4">
    <h2>Upload PDF Baru atau Mulai Canvas Kosong</h2>

    <div class="d-flex justify-content-center gap-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
        Upload & Edit
      </button>
      <form action="<?= base_url('index.php/notes/canvas_blank') ?>" method="post">
        <button type="submit" class="btn btn-secondary">Mulai Canvas Kosong</button>
      </form>
    </div>

    <?php if(isset($error)): ?>
      <div class="alert alert-danger mt-3 text-center"><?= $error ?></div>
    <?php endif; ?>
  </div>

  <!-- Modal Upload -->
  <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Upload Dokumen PDF</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <form action="<?= base_url('index.php/notes/upload_action') ?>" method="post" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-primary">Upload</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Daftar Dokumen -->
  <div class="card mt-4">
    <h4 class="mb-3">Daftar Dokumen</h4>
    <table class="table table-bordered table-striped">
      <thead>
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
            <a href="<?= base_url('index.php/notes/view_pdf/'.$n['file_note']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>  
            <a href="<?= base_url('index.php/notes/delete/'.$n['id_note']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus dokumen ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="5" class="text-center">Belum ada dokumen.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
