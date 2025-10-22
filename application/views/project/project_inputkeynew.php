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
        <!-- Animasi Loading (Spinner) -->
        <div id="loadingSpinner" class="text-center" style="display: none;">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
                
        <div class="row ml-3">
          <div class="col-lg-4">
          <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search...">

          </div>
        </div>

        <div class="card-body p-4">
        <?php $id_pjkr = $this->uri->segment(3); ?>
        <?php $user_ses = $this->session->userdata('id'); ?>
          <?php if (empty($all_key)) { ?>
            <div class="alert alert-default" role="alert">
              <strong>Anda belum</strong> Input Key Result!
            </div>
          <?php } else { ?>
                  <!-- List Group -->
                  <div class="list-group list-okr">
                      <?php foreach ($all_key as $ak) : ?>
                        <a href="#" class="list-group-item keyresult-view list-group-item-action" data-toggle="modal" data-target="#inputProgressModal">   
                            <div class="d-flex w-100 justify-content-between">
                              <h3 class="mb-1 title-key"><?= $ak['nama_kr'] ?></h3>
                              <h3 class="mt-0 mb-0 percent-key">
                                  <?php if ($ak['precentage'] >= 0 && $ak['precentage'] < 30) { ?>
                                  <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> <?= $ak['precentage']; ?>%</span>
                                  <?php } else if ($ak['precentage'] >= 30 && $ak['precentage'] < 70) { ?>
                                  <span class="text-warning mr-2"><i class="fa fa-arrow-up"></i> <?= $ak['precentage']; ?>%</span>
                                  <?php } else if ($ak['precentage'] >= 70) { ?>
                                  <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $ak['precentage']; ?>%</span>
                                  <?php } ?>
                              </h3>
                          </div>
                          <div class="d-flex w-100 justify-content-between deadline-key">
                              <input type="hidden" class="duedatekeyvalue" value="<?= $ak['due_datekey']?>">
                              <h5 class="due-key">Tanggal Akhir : <?= date('j F Y H:i', strtotime($ak['due_datekey'])); ?></h5>
                              <small id="countdown-container" class="countdowncontainer"></small>
                          </div>
                          <div class="d-flex w-100 justify-content-between deadline-key">
                              <small class="mb-1"><b>Created By</b> <?= $ak['created_by'] ?></small>
                              <h5 class="due-key"></h5>
                              <?php if (empty($ak['updated_by'])) { ?>
                              <small>Belum di Update</small>
                              <?php } else { ?>
                              <small><b>Update By</b> <?= $ak['updated_by'] ?></small>
                              <?php } ?>
                          </div>

                          <h5 class="mb-1">Score Key Result <span class="badge badge-default"><?= $ak['value_kr'] ?>/ <?= $ak['value_achievment'] ?></span></h5>
                      </a>
                      <li class="list-group-item list-okr">
                          <div class="row">
                              <div class="col-lg-12">
                                  <?php if (empty($ak['description_kr'])) { ?>
                                  <h4 class="text-muted mt-1">Catatan : Belum Ada Catatan</h4>
                                  <?php } else { ?>
                                  <h4 class="text-muted mt-1" id="desc-key">Catatan : <?= $ak['description_kr'] ?></h4>
                                  <?php } ?>
                                  <div class="row">
                                      <div class="col-lg-2" style="margin-right: 10px;">
                                          <a href="" data-target="<?= base_url(); ?>project/deleteKey/<?= $id_pjkr ?>/<?= $ak['id_okr'] ?>/<?= $ak['id_kr']; ?>" class="btn btn-danger tombol-hapus btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Hapus">
                                              <span class="btn--inner-icon"><i class="fas fa-trash"></i></span>
                                              <span class="btn-inner--text"></span>
                                          </a>
                                          <a type="button" href="" class="btn btn-warning btn-sm rounded-pill" data-toggle="modal" data-target="#inputProgressModal" data-idokr="<?= $ak['id_okr'] ?>" data-pj="<?= $id_pjkr ?>">
                                              <span class="btn--inner-icon"><i class="ni ni-settings"></i></span>
                                              <span class="btn-inner--text"></span>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </li>
                     
                      <?php endforeach; ?>
                  </div>
             
          <?php } ?>
          </div>
        </div>

          <div class="cekkrnew modal fade" id="inputProgressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="margin-top: -30px;">
                        <h2><?= $ak['nama_kr'] ?>

                        </h2>
                        <div class="progress-wrapper mb-3">
                          <div class="progress-info">
                       
                            <div class="progress-percentage">
                              <span><?= $ak['precentage'] ?> %</span>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $ak['precentage'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $ak['precentage'] ?>%;"></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="progress-label">
                                <span>Start : <?= $ak['value_achievment'] ?></span>
                              </div>
                            </div>
                            <div class="col-lg-6 text-right">
                              <div class="progress-label">
                                <span>Target : <?= $ak['value_kr'] ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?= form_open_multipart('project/inputValue' , 'class="form-inputkey"'); ?>
                
                          <div class="row">
                      
                            <input type="text" id="id_okr" name="id_okr" value="<?= $ak['id_okr']; ?>">
                            <input type="text" id="value_kr" name="value_kr" value="<?= $ak['value_kr']; ?>">
                            <input type="text" id="id_pjkr" name="id_pjkr" value="<?= $id_pjkr; ?>">
                            <!-- <input type="text" id="cekstatus" name="cekstatus" value="<?= $cekstate; ?>"> -->

                            <input type="text" id="id_kr" name="id_kr" value="<?= $ak['id_kr']; ?>">
                            <input type="text" id="commentkr<?= $ak['id_kr']; ?>" name="commentkr">
                    
                                <div class="col-lg-12 mb-2 d-flex justify-content-center">
                                  <input class="form-control form-nm w-50 inputkey" type="text" id="valuekrinput" name="value_achievment">
                                </div>
                           
                              <div class="col-lg-12 mb-1">
                                <div class="form-group">
                                  <div id="descinkeyresult<?= $ak['id_kr']; ?>" class="quill-editor"><?= $ak['description_kr']; ?></div>
                                </div>
                              </div>
                              <div class="col-lg-12 text-center">
                                <button class="btn btn-lg btn-icon rounded-pill btn-outline-default btn-input" type="submit">
                                <span class="btn-inner--icon"><div class="spinner"></div><i class="fas fa-plus"></i></span>                                
                                 <span class="btn-inner--text">&nbsp;Save Change</span>
                                </button>
                              </div>
                             
                           
                          </div>
                      

                      
                      </div>
                      
                    </div>
                  </div>
                </div>




    















      
      

      
      