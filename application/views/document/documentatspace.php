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
    #checkAllPublish {
      transform: scale(1.5); /* Ubah angka 1.5 menjadi lebih besar/kecil sesuai selera */
        cursor: pointer;       /* Mengubah kursor menjadi tangan saat di atas checkbox */
    }

    div#text-publish {
    max-width: 1100px;
  }

/* 
  div#text-complete {
    max-width: 1100px;
  } */



</style>
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
  <script>
    // Check for flashdata in PHP
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
    </script>
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
                    <h2 class="mb-0" style="padding-left: 15px;">Document Aproval</h2>
                    <?php $role_id = $this->session->userdata('role_id') ?>
                    </div>
                </div>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text-doc" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link mb-sm-3 mb-md-0 active" id="doccomplete" data-toggle="tab" href="#tabs-text-complete" role="tab" aria-controls="tabs-text-complete" aria-selected="true">Document Complete</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link mb-sm-3 mb-md-0" id="docpublish" data-toggle="tab" href="#tabs-text-publish" role="tab" aria-controls="tabs-text-publish" aria-selected="false">Document Publish</a>
                      </li>
                  </ul>

                  <div class="row">
                      <div class="col-lg-3">
                          <input type="hidden" id="spaceindoc" value="<?= $this->uri->segment(3); ?>">
                          <div class="form-group">
                              <label for="filterspace">Filter Project</label>
                              <select class="form-control" id="filterspace" name="filterspace">
                                  <option value="0">Pilih Filter Project</option>
                                  <?php foreach ($projects as $yp) { ?>
                                  <option value="<?= $yp['id_project'] ?>"><?= $yp['nama_project'] ?></option>
                                  <?php }  ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-2 mt-4">
                          <button type="button" id="btnfilterspace" class="btn btn-warning rounded-pill">
                              <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                              <span class="btn-inner--text">Filter</span>
                          </button>
                      </div>
                      <div class="col-lg-6  mt-4">
                        <form id="backupForm" action="<?= base_url('document/documentbackup/') .$this->uri->segment(3); ?>" method="POST">
                            <input type="hidden" name="selected_ids" id="selected_ids_hidden">

                            <button type="submit" class="btn btn-primary rounded-pill mb-3">
                                <i class="fas fa-archive"></i> Lakukan Arsip
                            </button>
                        </form>
                      </div>
                    <div>
                  </div>

                  <div class="tab-content">
                      <div class="tab-pane fade show active" id="tabs-text-complete" role="tabpanel">
                          <div class="table-responsive py-4" id="text-complete">
                              <table class="table table-flush" id="myDocumentData" width="100%">
                                  <thead class="thead-light">
                                      <tr> 
                                          <th class="text-center"><input type="checkbox" id="checkAll"></th>
                                          <th>Nama Dokumen</th>
                                          <th>OKR | Space</th>
                                          <th>Status Dokumen</th>
                                          <th>File</th>
                                          <th>Status Backup</th>
                                          <th>File</th>
                                          <th>Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody></tbody>
                              </table>
                          </div>
                      </div>
                      
                      <div class="tab-pane fade" id="tabs-text-publish" role="tabpanel">
                          <div class="table-responsive py-4" id="text-publish" style="display:none;">
                              <table class="table table-flush" id="myDocumentDataPublish" width="100%">
                                  <thead class="thead-light">
                                      <tr>
                                          <th class="text-center"><input type="checkbox" id="checkAllPublish"></th>
                                          <th>Nama Dokumen</th>
                                          <th>OKR | Space</th>
                                          <th>Status Dokumen</th>
                                          <th>File</th>
                                          <th>Status Backup</th>
                                          <th>File</th>
                                          <th>Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody></tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>



            <div>
        </div>
    </div>
</div>  
 

    <!-- Modal -->
    <div class="modal fade" id="projectAllModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Pindahkan Ke Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?= form_open_multipart('document/moveToProjectFromAll/'); ?>
            <input type="hidden" name="iddocumentpj" id="iddocumentpj" class="form-control" >
            <input type="hidden" name="idspacepj" id="idspacepj" class="form-control" >
            <div class="form-group">
                 <select class="form-control" id="projectdoc" name="projectdoc">
                    <?php foreach ($projects as $pj) : ?>
                       <option value="<?= $pj['id_project']; ?>"><?= $pj['nama_project']; ?></option>
                    <?php endforeach; ?>
                  </select>             
                 </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary rounded-pill">Pindahkan</button>
            </div>
            <?= form_close(); ?>
            </div>
        </div>
        </div>
        

