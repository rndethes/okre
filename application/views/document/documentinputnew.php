<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
              <li class="breadcrumb-item active" aria-current="page">Default</li>
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
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Tambah Dokumen</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>
          <?= form_open_multipart('document/tambahDocumentNew/' . $this->uri->segment(3), ['id' => 'myForm']); ?>
          <div class="pl-lg-4">
          <input class="form-control" type="hidden" name="space" id="selectspace" value="<?= $this->session->userdata('workspace_sesi') ?>">

          <input class="form-control" type="hidden" name="okr" id="okr" value="<?= $this->uri->segment(3) ?>">

          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="namadocument" class="form-control-label">Nama Dokumen</label>
                                    <input class="form-control" type="text" placeholder="Nama Dokumen" name="namadocument" id="namadocument"  value="<?= isset($pengajuan_data['name_document']) ? $pengajuan_data['name_document'] : '' ?>">
                                </div>
                            </div>

                            <input type="hidden" id="url_document" name="url_document" value="<?= isset($pengajuan_data['url_doc']) ? $pengajuan_data['url_doc'] : '' ?>">
                            <input type="hidden" id="nama_doc" name="nama_doc" value="<?= isset($pengajuan_data['name_file']) ? $pengajuan_data['name_file'] : '' ?>">
                            
                       
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jenisdocument" class="form-control-label">Jenis Document</label>
                                    <select class="form-control" id="jenisdocument" name="jenisdocument">
                                        <option value="">Pilih Jenis</option>
                                        <option value="1" <?= isset($pengajuan_data['type_document']) && $pengajuan_data['type_document'] == '1' ? 'selected' : '' ?>>Surat</option>
                                        <option value="2" <?= isset($pengajuan_data['type_document']) && $pengajuan_data['type_document'] == '2' ? 'selected' : '' ?>>Invoice</option>
                                        <option value="3" <?= isset($pengajuan_data['type_document']) && $pengajuan_data['type_document'] == '3' ? 'selected' : '' ?>>Proposal</option>
                                        <option value="4" <?= isset($pengajuan_data['type_document']) && $pengajuan_data['type_document'] == '4' ? 'selected' : '' ?>>BAA</option>
                                        <option value="5" <?= isset($pengajuan_data['type_document']) && $pengajuan_data['type_document'] == '5' ? 'selected' : '' ?>>Dokumen Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                              <hr class="my-4" />
                                <div class="row">
                                  <div class="col-lg-3">
                                    <h5>Hubungkan Dokumen dengan OKR</h5>
                                    <div class="form-group">
                                        <select class="form-control" id="dokumenokr" name="dokumenokr">
                                            <option value="">Hubungkan Dokumen</option>
                                            <option value="1">Key Result</option>
                                            <option value="2">Inisiative</option>
                                        </select>
                                      </div>
                                  </div>
                                  <div class="col-lg-1">
                                      <button class="btn btn-icon btn-primary mt-4" type="button" id="checkkey" name="checkkey">
                                        <span class="btn-inner--icon"><i class="fas fa-plus-square"></i></span>
                                      </button>
                                  </div>
                                  <div class="col-lg-1">
                                      <button class="btn btn-icon btn-danger mt-4" type="button" id="removekey" name="removekey">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                      </button>
                                  </div>
                                </div>
                                <div class="row" id="formContainer">
                                </div>
                                <input type="hidden" name="tipeokr" id="tipeokr">
                                <input type="hidden" name="myokr" id="myokr">

                              <hr class="my-4" />
                            <div class="row">
                        
                          </div>
                          <div id="previewpdf" style="margin-top: 20px;"></div>
                            <div class="row">
                            <div class="col-lg-2 mb-2">
                                <button class="btn btn-icon btn-dark-primary rounded-pill" type="button" id="submitBtn">
                                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                <span class="btn-inner--text">Tambah</span>
                                </button>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= isset($pengajuan_data['urlback']) ? $pengajuan_data['urlback'] : '' ?>">
                                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                <span class="btn-inner--text">Kembali</span>
                                </a>
                            </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
        </div>
      </div>
    </div>

  </div>

    <script>
        var urldoc = document.getElementById("url_document").value;


        // Tampilkan preview PDF
        document.getElementById('previewpdf').innerHTML = '<iframe src="' + urldoc + '" width="100%" height="600px"></iframe>';
    </script>

  

    