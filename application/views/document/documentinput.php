<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Document</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboards</a></li>
              <li class="breadcrumb-item active" aria-current="page">Input Document</li>
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
          <?= form_open_multipart('document/tambahDocument/' . $this->uri->segment(3), ['id' => 'myForm']); ?>
          <div class="pl-lg-4">
          <input class="form-control" type="hidden" name="space" id="selectspace" value="<?= $this->session->userdata('workspace_sesi') ?>">

          <input class="form-control" type="hidden" name="okr" id="okr" value="<?= $this->uri->segment(3) ?>">

            <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="namadocument" class="form-control-label">Nama Dokumen</label>
                                    <input class="form-control" type="text" placeholder="Nama Dokumen" name="namadocument" id="namadocument">
                                </div>
                            </div>
                            
                       
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jenisdocument" class="form-control-label">Jenis Document</label>
                                    <select class="form-control" id="jenisdocument" name="jenisdocument">
                                        <option value="">Pilih Jenis</option>
                                        <option value="1">Surat</option>
                                        <option value="2">Invoice</option>
                                        <option value="3">Proposal</option>
                                        <option value="4">BAA</option>
                                        <option value="5">Dokumen Lainnya</option>
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
                              <div class="col-lg-12">
                                      <div class="custom-file">
                                          <input type="file" class="input_document" name="input_document" id="inputdocument" lang="en" accept=".pdf">
                                          <label class="custom-file-label" for="inputdocument">Select file</label>
                                      </div>
                              </div>
                          </div>
                          <div id="previewpdf" style="margin-top: 20px;"></div>
                          <div class="row">
                            <div class="col-lg-12">
                                  <div class="form-group">
                                      <label for="desokr" class="form-control-label">Tambahkan Catatan Lainnya</label>
                                        <div id="desokr"> 
                                      </div>
                                      <input type="hidden" id="describeokr" name="describeokr">
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-2 mb-2">
                                <button class="btn btn-icon btn-dark-primary rounded-pill" type="button" id="submitBtn">
                                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                <span class="btn-inner--text">Tambah</span>
                                </button>
                            </div>
                            <div class="col-lg-3 mb-2">
                              <?php if($this->uri->segment(3) == "space") { ?>
                                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . '/space' ?>">
                                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                <span class="btn-inner--text">Kembali</span>
                                </a>
                              <?php } else { ?>
                                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url("document/index/") . $this->uri->segment(3) ?>">
                                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                <span class="btn-inner--text">Kembali</span>
                                </a>
                              <?php } ?>
                               
                            </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
        </div>
      </div>
    </div>

  </div>

  

    