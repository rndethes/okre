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
          <?= form_open_multipart('document/tambahDocumentFromOkr/' . $this->uri->segment(3), ['id' => 'myForm']); ?>
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
                                <input type="hidden" name="iddocnew" id="iddocnew">
                                <input type="hidden" name="content" id="content">
                            

                              <hr class="my-4" />
                                    <div class="card bg-gradient-info">
                                        <div class="card-body">
                                            <h3 class="card-title text-white">Cari dokumen yang akan kamu upload</h3>
                                            <blockquote class="blockquote text-white mb-0">
                                                <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-secondary rounded-pill" data-toggle="modal" data-target="#seeMyDocModal">
                                                        Cari Dokumen
                                                    </button>
                                                
                                            </blockquote>
                                        </div>
                                    </div>
                          <div id="previewpdf" style="margin-top: 20px;"></div>
                          <div class="card card-frame">
                                <div class="card-body">
                                   <h3 id="titledoc"></h3>
                                   <h6 id="datedoc"></h6>
                                   <h6 id="createddoc"></h6>
                                    <div id="content-doc" style=" max-height: 300px;overflow-y: auto;overflow-x: hidden;"></div>
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
                                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>">
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

        <!-- Modal -->
            <div class="modal fade" id="seeMyDocModal" tabindex="-1" role="dialog" aria-labelledby="seeMyDocModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seeMyDocModalLabel">Daftar Dokumenmu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                            <div>
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">Nama Dokumen</th>
                                            <th scope="col" class="sort" data-sort="budget">Pemilik</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php foreach($mydocument as $my) { ?>
                                        <tr>
                                            <th><?= $my['name_document_new'] ?></th>
                                            <th><?= $my['nama'] ?></th>
                                            <th>
                                             <button type="button" data-iddoc="<?= $my['id_document_new'] ?>" class="btn btn-success btn-sm rounded-pill btn-signall btn-takedoc">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Ambil Dokumen</span>
                                              </button>    
                                              <a href="<?= base_url("data/previewDocument/") . $this->session->userdata('workspace_sesi') . "/" . $my['id_document_new'] ?>" class="btn btn-primary btn-sm rounded-pill btn-signall" target="_target">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Lihat Dokumen</span>
                                              </a> 
                                            </th>
                                        </tr>    
                                        <?php } ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
            </div>

    <script>
      

        document.querySelectorAll('.btn-takedoc').forEach(function(button) {
            button.addEventListener('click', function() {
                var idDocument = this.getAttribute('data-iddoc'); // Ambil id dokumen

                // Lakukan fetch ke controller untuk mengambil detail dokumen
                fetch('<?= base_url('data/getDocumentById') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_document_new: idDocument }), // Kirim id dokumen dalam format JSON
                })
                .then(response => response.json())
                .then(data => {
                    // Tampilkan konten dokumen di #content-doc
                    document.getElementById('content-doc').innerHTML = data.content;
                    document.getElementById('iddocnew').value = data.iddocnew;
                    document.getElementById('content').value = data.content;
                    document.getElementById('titledoc').innerHTML = data.namadoc;
                    document.getElementById('datedoc').innerHTML = data.createddate;
                    document.getElementById('createddoc').innerHTML = data.usercreated;
            
                    // Tutup modal setelah dokumen diambil
                    $('#seeMyDocModal').modal('hide');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>

  

    