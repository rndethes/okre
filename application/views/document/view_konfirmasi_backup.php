<style>
    /* Menargetkan sel tabel (td) pertama di setiap baris */
    #myDocumentData td:first-child {
        text-align: center;      /* Pusatkan checkbox secara horizontal */
        vertical-align: middle;  /* Pusatkan checkbox secara vertikal */
    }

    /* Mengubah ukuran checkbox */
    .doc-checkbox {
        transform: scale(1.5); /* Ubah angka 1.5 menjadi lebih besar/kecil sesuai selera */
        cursor: pointer;       /* Mengubah kursor menjadi tangan saat di atas checkbox */
    }
    #checkAll {
      transform: scale(1.5); /* Ubah angka 1.5 menjadi lebih besar/kecil sesuai selera */
        cursor: pointer;       /* Mengubah kursor menjadi tangan saat di atas checkbox */
    }


</style>
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">WORKSPACE</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
              <li class="breadcrumb-item active" aria-current="page">OKR</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">   
    <div class="col-xl-12"> 
      <div class="card">
        <div class="card-header border-2 mb-4">
          <div class="row align-items-center">
            <div class="col">
                <h3>Konfirmasi Dokumen untuk Diarsip</h3>
            </div>
          </div>
        <div class="card-body">              
          <p>Berikut adalah daftar dokumen yang akan digabungkan ke dalam satu file ZIP.</p>
          <h4>Total Ukuran : <?= $total_ukuran_string ?></h4>
          <h5>Banyak File : <?= $jumlah_file ?></h5>
          <table class="table">
                <thead>
                    <tr>
                        <th>Nama Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dokumen_terpilih as $doc): ?>
                        <tr>
                            <td><?= htmlspecialchars($doc['name_document']); ?></td>
                            <td>
                                <a href="<?= $doc['filepath']; ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row">
              <div class="col-lg-3">
                <form action="<?= base_url('document/proses_final_backup/') .$this->uri->segment(3)  ?>" method="POST">
                  <input type="hidden" name="ids_to_zip" value="<?= $ids_untuk_zip ?>">
                      <button type="submit" class="btn btn-success">
                          <i class="fas fa-download"></i> Konfirmasi & Unduh ZIP
                      </button>
                </form>
              </div>
              <div class="col-lg-3">
                <input type="hidden" id="ids_to_zips" name="ids_to_zips" value="<?= $ids_untuk_zip ?>">
                  <button id="btn-archive-selected" class="btn btn-warning">
                      <i class="fas fa-archive"></i> Arsipkan File Terpilih
                  </button>
              </div>
              <div class="col-lg-3">
              <a href="<?= base_url('document/documentAtSpace/') .$this->uri->segment(3)  ?>" class="btn btn-secondary">Batal</a>
              </div>
            </div>
         

            
           
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>
   $('#btn-archive-selected').on('click', function() {
      var idsString = $('#ids_to_zips').val();
        // Hanya ambil checkbox yang tidak di-disable (belum diarsip)
      // Pastikan string tidak kosong sebelum melanjutkan
      if (!idsString) {
            Swal.fire('Tidak Ada File', 'Tidak ada ID file yang ditemukan.', 'warning');
            return;
        }

        var selectedIds = idsString.split(',');

        Swal.fire({
            title: 'Anda Yakin?',
            text: 'Arsipkan ' + selectedIds.length + ' file terpilih ke Google Drive?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, arsipkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jalankan fungsi proses antrian
                processArchiveQueue(selectedIds);
            }
        });
    });

    function processArchiveQueue(ids) {
        let currentFileIndex = 0;
        let totalFiles = ids.length;
        let successCount = 0;
        let failCount = 0;

        // Tampilkan SweetAlert dengan progress bar
        Swal.fire({
            title: 'Mengarsipkan File Document',
            html: `
                <p id="swal-text">Memproses file 1 dari ${totalFiles}...</p>
                <div class="progress">
                    <div id="swal-progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false
        });

        function archiveNext() {
            if (currentFileIndex >= totalFiles) {
                // Proses Selesai
                Swal.fire({
                  title: 'Selesai!',
                  text: `Proses arsip selesai. Berhasil: ${successCount}, Gagal: ${failCount}.`,
                  icon: 'success',
                  confirmButtonText: 'OK' // Mengganti teks tombol
                }).then(() => {
                    // Fungsi ini akan dijalankan setelah admin menekan tombol "OK"
                    location.reload();
                });
                return;
            }

            let fileid = ids[currentFileIndex];
            
            // Kirim AJAX untuk SATU file
            $.ajax({
                url: "<?= base_url('document/archive_by_id'); ?>", // URL ke controller baru
                type: "POST",
                data: { fileid: fileid, iddoc: <?= $this->uri->segment(3) ?> },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        successCount++;
                   
                    } else {
                        failCount++;
                    }
                },
                error: function() {
                    failCount++;
                },
                complete: function() {
                    currentFileIndex++;
                    // Update progress bar dan teks
                    let percentage = Math.round((currentFileIndex / totalFiles) * 100);
                    $('#swal-progress-bar').css('width', percentage + '%');
                    $('#swal-text').text(`Memproses file ${currentFileIndex} dari ${totalFiles}...`);
                    
                    // Lanjutkan ke file berikutnya
                    archiveNext();
                }
            });
        }

        // Mulai proses untuk file pertama
        archiveNext();
    }
</script>




   


