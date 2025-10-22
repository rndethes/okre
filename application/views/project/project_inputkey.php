<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashKey'); ?>"></div>
    <?php if ($this->session->flashdata('flashKey')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Key Result</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboards</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>project">Project</a></li>
              <li class="breadcrumb-item active" aria-current="page">Key Result</li>
              
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
           
              <h2 class="mb-0">Objective</h2>             
              <?php 
              if($key_result['value_from'] != null){
              if($key_result['value_from'] >= 0 ) {
                $val = 'Besar Value yang Harus Dicapai ' . 'Rp' . number_format($key_result['value_from'],0,',','.');
              } else {
                $val ='';
              }
            } else {
              $val = '';
            }
              ?>
              <h1><?= $key_result['description_okr']; ?></h1>
              <h4 class="text-warning"><?= $val ?></h4>
            </div>
            <div class="col-lg-12">
              <div class="progress-wrapper">
                <div class="progress-info">
                  <div class="progress-label">
                    <span>Progress Task</span>
                  </div>
                  <div class="progress-percentage">
                    <h2><?= $key_result['value_okr']; ?>%</h2>
                  </div>
                </div>
                <div class="progress" style="height: 20px;">
                  <?php if ($key_result['value_okr'] >= 0 && $key_result['value_okr'] < 30) { ?>
                    <div class=" progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $key_result['value_okr']; ?>%"></div>
                  <?php } else if ($key_result['value_okr'] >= 30 && $key_result['value_okr'] < 65) { ?>
                    <div class=" progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $key_result['value_okr']; ?>%"></div>
                  <?php } else if ($key_result['value_okr'] >= 65 && $key_result['value_okr'] <= 100) { ?>
                    <div class=" progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $key_result['value_okr']; ?>%"></div>
                  <?php } ?>
            
                </div>
              </div>
            </div>
            <div class="col-lg-6 mt-5">
              <button type="button" class="btn btn-dark-primary mb-4 btn-key rounded-pill" data-toggle="modal" data-target="#tambahModalKey">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Tambah Key Result</span>
              </button>
              <div class="modal fade" id="tambahModalKey" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input Key</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('project/inputKey', 'class="form-key"'); ?>
                      <?php $id_pj = $this->uri->segment(3); ?>
                      <div class="pl-lg-4">
                        <div class="row">
                          <input type="hidden" id="id_okr" name="id_okr" class="form-control" value="<?= $key_result['id_okr']; ?>">
                          <input type="hidden" id="id_pj" name="id_pj" class="form-control" value="<?= $id_pj; ?>">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-username">Nama Key Result</label>
                              <input type="text" id="nama_kr" name="nama_kr" class="form-control" placeholder="Nama Produk Selesai dalam 1 hari" required>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-email">Score Key Result</label>
                              <input class="form-control" type="text" id="valuekrinput" name="value_kr" placeholder="Value Key Result" required>
                            </div>
                          </div>
                          <div class="col-lg-8">
                                <div class="form-group">
                                  <label class="form-control-label" for="exampleFormControlSelect1">Key Result Priority</label>
                                  <div class="style-toggle row">
                                      <input type="radio" id="high" name="priority" value="3" class="btn btn-default d-none form-control">
                                      <label for="high"><i class="fa fa-flag" style="color: #db2424;"></i></label>

                                      <input type="radio" id="medium" name="priority" value="2" class="btn btn-default d-none form-control">
                                      <label for="medium"><i class="fa fa-flag" style="color: #ffea00;"></i></label>

                                      <input type="radio" id="low" name="priority" value="1" class="btn btn-default d-none form-control">
                                      <label for="low"><i class="fa fa-flag" style="color: #29dbff;"></i></label>

                                      <input type="radio" id="lowest" name="priority" value="0" class="btn btn-default d-none form-control">
                                      <label for="lowest"><i class="fa fa-flag" style="color: #d1d1d1;"></i></label>
                                  </div>
                                </div>
                              </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-email">Tanggal Awal</label>
                              <input class="form-control" type="datetime-local" value="<?= date("Y/m/d") ?>" id="start_datekey" name="start_datekey" required>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-email">Tanggal Akhir</label>
                              <input class="form-control" type="datetime-local" value="<?= date("Y/m/d") ?>" id="due_datekey" name="due_datekey" required>
                            </div>
                          </div>
                          <div class="row">

                        
                            <div class="col-lg-12">
                              <button class="btn btn-icon btn-default btn-key-result" type="submit">
                                <span class="btn-inner--icon"><div class="spinner"></div><i class="ni ni-fat-add"></i></span>
                                <span class="btn-inner--text">Tambah</span>
                              </button>
                            </div>
                          </div>
                        </div>
                        <?= form_close(); ?>
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-5">

                <a href="<?= base_url("project/showOkr/") . $this->uri->segment(3) ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                 <span class="btn-inner--text">Kembali</span>
                </a>
              </div>

          </div>

        </div>
        <?php $id_pjkr = $this->uri->segment(3); ?>
        <?php $user_ses = $this->session->userdata('id'); ?>

      <div class="card-body p-4">
          <ul class="list-group list-group-flush list my--3">
          <?php foreach ($all_key as $ak) : ?>
              <li class="list-group-item">
                <div class="card p-3">
                  <div class="row align-items-center">
                      <div class="col-auto">
                      </div>
                      <div class="col ml--2">
                          <h4 class="mb-0">
                              <a href="#!" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><?= $ak['nama_kr'] ?> <span class=" badge badge-success"><i class="ni ni-bold-down"></i></span></a>
                          </h4>
                          
                          <span class="text-success">●</span>
                          <small>Online</small>
                      </div>
                      <div class="col-auto">
                            <a href="" data-target="<?= base_url(); ?>project/deleteKey/" class="btn btn-danger tombol-hapus btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Hapus">
                                <span class="btn--inner-icon">
                                  <i class="fas fa-trash"></i></span>
                                <span class="btn-inner--text"></span>
                              </a>
                              <a type="button" href="" class="btn btn-warning btn-sm rounded-pill" data-toggle="modal" data-target="#exampleModa">
                              <span class="btn--inner-icon">
                                <i class="ni ni-settings"></i></span>
                              <span class="btn-inner--text"></span>
                            </a>
                            <a type="button" href="" class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#inisiativeModal" id="initiative">
                              <span class="btn--inner-icon">
                                <i class="ni ni-spaceship"></i></span>
                              <span class="btn-inner--text"> Lakukan Inisiative</span>
                            </a>
                              <button type="button" class="btn btn-success btn-sm rounded-pill" id="taketask">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-rock"></i></span>
                              <span class="btn-inner--text"> Take Task</span>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm rounded-pill" id="risehand">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-paper"></i></span>
                              <span class="btn-inner--text"> Raise Hand</span>
                            </button>
                      </div>
                  </div>
                  <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                      <div>
                          <table class="table align-items-center">
                              <thead class="thead-light">
                                  <tr>
                                      <th scope="col" class="sort" data-sort="name">Inisiative</th>
                                      <th scope="col" class="sort" data-sort="budget">Score</th>
                                      <th scope="col" class="sort" data-sort="status">Prioritas</th>
                                      <th scope="col" class="sort" data-sort="completion">Status</th>
                                      <th scope="col"></th>
                                  </tr>
                              </thead>
                              <tbody class="list">
                              </tbody>
                          </table>
                      </div>

                    </div>
                  </div>
                  </div>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>

    <div class="modal fade" id="inisiativeModal" tabindex="-1" role="dialog" aria-labelledby="inisiativeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="inisiativeModalLabel">Inisiative</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form id="initiativeForm">
            <div id="initiativeContainer">
                <div class="row initiative-group">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="namainisiative" class="form-control-label">Nama Inisiative</label>
                            <input class="form-control" type="text" id="namainisiative" name="namainisiative[]">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="scoreinisiative" class="form-control-label">Score</label>
                            <input class="form-control" type="text" id="scoreinisiative" name="scoreinisiative[]">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-control-label" for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority[]">
                                <option value="" selected>Pilih Prioritas</option>
                                <option value="3">High</option>
                                <option value="2">Medium</option>
                                <option value="1">Low</option>
                                <option value="0">Lowest</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mt-4">
                            <button class="btn btn-icon btn-danger rounded-pill remove" type="button">
                                <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                <span class="btn-inner--text">Remove</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-icon btn-default rounded-pill add-more" type="button">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Add</span>
                </button>
            </div>
        </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
      

    <script>
       $.fn.modal.Constructor.prototype._enforceFocus = function() {
                var $modalElement = this.$element;
                $(document).on('focusin.modal',function(e) {
                    if ($modalElement.length > 0 && $modalElement[0] !== e.target
                        && !$modalElement.has(e.target).length
                        && $(e.target).parentsUntil('*[role="dialog"]').length === 0) {
                        $modalElement.focus();
                    }
                });
            };
     </script>

      
      