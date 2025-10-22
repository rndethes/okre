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
                <!-- <div class="btn-group">
                  <button type="button" class="btn btn-primary mb-4 btn-obj rounded-pill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i></span>
                    <span class="btn-inner--text">Export</span>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">PDF</a>
                    <a class="dropdown-item" role="button" data-toggle="modal" data-target="#modalExcel">Excel</a>                    
                  </div>
                </div> -->
                <a href="<?= base_url("project/showOkr/") . $this->uri->segment(3) ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                 <span class="btn-inner--text">Kembali</span>
                </a>
              </div>

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
            <ul class="list-group">
              <?php
              foreach ($all_key as $ak) :
              ?>
                <?php
                $CI = &get_instance();
                $CI->load->model('Main_model');

                $id_kr = $ak['id_kr'];
                $id_okr = $ak['id_okr'];

                $checkinsiative     = $CI->Project_model->count_initiative($id_kr);

                $checkdelegate      = $CI->Project_model->checkDelegateRise($id_kr);

                $checkdelegatetake  = $CI->Project_model->checkDelegateTake($id_kr);

                $checkuserses       = $CI->Project_model->checkUserTake($user_ses,$id_kr);
                
                $suminsiative       = $CI->Project_model->sum_initiative($id_kr);

                $checkteam          = $CI->Project_model->checkTeam($id_pjkr);

                $myteamid = $checkteam['id_team'];

                $checkmyakses = checkMyAksesKey($id_okr);
                $can_edit     = $checkmyakses["can_edit_objective"];
                $can_delete   = $checkmyakses["can_delete_objective"];
                
                
                if($checkdelegate != null) {
                  $user      = $checkdelegate['id_user_delegate'];
                  $checkuser = $CI->Project_model->getuserRise($user);
                } 
               // print_r($checkdelegatetake);
                if($checkdelegatetake != null) {
                  $checkusertake   = $CI->Project_model->getuserTake($id_kr);
                }

                $awal  = strtotime('Y-m-d H:i:s');
                $akhir = strtotime($ak['due_datekey']); // waktu sekarang

                $awal  = new DateTime();
                $akhir = new DateTime($ak['due_datekey']);
                $diff  = $akhir->diff($awal);

                $tahun =  $diff->y . ' year ';
                $bulan = $diff->m . ' month ';
                $day   =  $diff->d . ' day ';
                $jam   =  $diff->h . ' hour ';

                if ($diff->y == 0) {
                  if ($diff->m == 0) {
                    $duetime = $day . $jam;
                  } else if ($diff->d == 0) {
                    $duetime = $jam;
                  } else {
                    $duetime = $bulan . $day . $jam;
                  }
                } else {
                  $duetime = $tahun . $bulan . $day . $jam;
                }

                $datenow = date('Y m d H i s', strtotime("+7 hours +2 minutes"));
                $duedate = date('Y m d H i s', strtotime($ak['due_datekey']));
                ?>
          
                <a href="#" class="list-group-item list-group-item-action <?= $datenow > $duedate && $ak['precentage'] < 100 ? "bg-danger-light" : ""  ?>" data-toggle="modal" data-target="#inputProgressModal<?= $ak['id_kr'] ?>" data-description="<?= htmlspecialchars($ak['description_kr'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= $ak['id_kr']; ?>">
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
                  <?php if($checkinsiative == 0) { ?>
                  <h5 class="mb-1">Score Key Result <span class="badge badge-default"><?= $ak['value_kr'] ?>/ <?= $ak['value_achievment'] ?></span></h5>
                  <?php } else { ?>
                  <h5 class="mb-1">Score Inisiative <span class="badge badge-default"><?= $suminsiative['jumlahinitiative'] ?>/<?= $suminsiative['jumlahachievment'] ?></span></h5>
                  <?php }  ?>
                  <div class="d-flex">
                  <?php 
          
                  if(!empty($checkdelegate)) { ?>
                    <div class="d-flex">
                    <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit" data-toggle="tooltip" data-original-title="<?=  $checkuser['username'] ?>" >
                      <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $checkuser['foto'] ?>">
                    </div>
                    <div class="rise"><i class="fas fa-hand-paper text-warning"></i></div>
                  </div>
                  <?php } ?>


                 <?php if(!empty($checkdelegatetake)) { ?>
                  <?php foreach($checkusertake as $cs) : ?>
                    <div class="d-flex">
                    <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit" data-toggle="tooltip" data-original-title="<?=  $cs['username'] ?>" >
                      <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $cs['foto'] ?>">
                    </div>
                    <div class="rise"><i class="fas fa-hand-rock text-success"></i></div>
                  </div>
                  <?php endforeach; ?>
                  <?php } ?>
                 </div>

                  <?php $role_id  = $this->session->userdata('role_id'); ?>
                 
                  <?php $cekstate = $ak['status']; ?>
                </a>
                <!-- Modal -->
                <div class="cekkr modal fade" id="inputProgressModal<?= $ak['id_kr'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <?php if ($datenow > $duedate) { ?>
                          <?php if ($ak['precentage'] == 100) { ?>
                            <div class="col-4">
                              <span class="badge badge-lg badge-pill badge-success">Complete</span>
                            </div>
                          <?php } else { ?>
                            <div class="row">
                              <?php if ($cekstate == 0) { ?>

                                <div class="col-lg-12 mb-2 d-flex justify-content-center">
                                  <input class="form-control form-control form-nm w-50" type="number" id="example-number-input" name="value_achievment" readonly>
                                </div>
                              <?php } ?>

                              <div class="col-lg-12 mb-1">
                                <div class="form-group">
                                <div class="form-control descinkeyresult" name="description_kr" id="desckr" rows="10"><?= $ak['description_kr']; ?></div>
                                  <!-- <textarea class="form-control" id="exampleFormControlTextarea1" name="description_kr" rows="3" readonly>Isikan Catatan Progress...</textarea> -->
                                </div>
                                <!-- <input class="form-control form-control-" type="text" id="example-number-input" name="description_kr" placeholder="Isikan Catatan Progress..."> -->
                              </div>
                              <div class="col-lg-12 text-center">
                                <button class="btn btn-lg btn-icon rounded-pill btn-outline-default" type="submit" disabled>
                                <span class="btn-inner--icon"><div class="spinner"></div><i class="fas fa-plus"></i></span>                                
                                 <span class="btn-inner--text">&nbsp;Save Change</span>
                                </button>
                              </div>
                            </div>
                          <?php } ?>
                        <?php } else { ?>
                          <div class="row">
                      
                            <input type="hidden" id="id_okr" name="id_okr" class="form-control" value="<?= $ak['id_okr']; ?>">
                            <input type="hidden" id="value_kr" name="value_kr" class="form-control" value="<?= $ak['value_kr']; ?>">
                            <input type="hidden" id="id_pjkr" name="id_pjkr" class="form-control" value="<?= $id_pjkr; ?>">
                            <input type="hidden" id="cekstatus" name="cekstatus" class="form-control" value="<?= $cekstate; ?>">

                            <input type="hidden" id="id_kr" name="id_kr" class="form-control" value="<?= $ak['id_kr']; ?>">
                            <input type="hidden" id="commentkr<?= $ak['id_kr']; ?>" name="commentkr" class="form-control">
                            <?php if ($ak['precentage'] == 100) { ?>
                              <div class="col-12 d-flex justify-content-center">
                                <span class="badge badge-xxl badge-pill badge-success">Complete</span>
                              </div>
                            <?php } else { ?>
                              <?php if ($cekstate == 0) { ?>
                                <?php if($can_edit == 0 && $can_delete == 0) { ?>
                                  <div class="col-lg-12 mb-2 d-flex justify-content-center">
                                  <input class="form-control form-nm w-50 inputkey" type="text" id="valuekrinput" name="value_achievment" readonly>
                                </div>
                                <?php } else { ?>
                                  <div class="col-lg-12 mb-2 d-flex justify-content-center">
                                  <input class="form-control form-nm w-50 inputkey" type="text" id="valuekrinput" name="value_achievment">
                                </div>
                                <?php } ?>
                                
                              <?php } else { ?>
                                <div class="col-lg-12 mb-2 d-flex justify-content-center">
                                  <h5>Input Score di Inisiative</h5>
                                </div>
                              <?php } ?>
                              <div class="col-lg-12 mb-1">
                                <div class="form-group">
                                  <!-- <textarea class="form-control ckeditor" name="description_kr" rows="3" id="ckedtor"><?= $ak['description_kr']; ?></textarea> -->
                                  <!-- <div class="form-control descinkeyresult" name="description_kr" id="desckr" rows="10"><?= $ak['description_kr']; ?></div> -->
                                  <div id="descinkeyresult<?= $ak['id_kr']; ?>" class="quill-editor"><?= $ak['description_kr']; ?></div>
                                </div>
                              </div>
                              <div class="col-lg-12 text-center">
                                <button class="btn btn-lg btn-icon rounded-pill btn-outline-default btn-input" type="submit">
                                <span class="btn-inner--icon"><div class="spinner"></div><i class="fas fa-plus"></i></span>                                
                                 <span class="btn-inner--text">&nbsp;Save Change</span>
                                </button>
                              </div>
                              <script>
                                
                                  var changekey =  document.querySelectorAll(".form-control.form-nm.w-50.inputkey");

                                  for (let i = 0; i < changekey.length; i++) {
                                    changekey[i].addEventListener("keyup", function(e) {
                                    changekey[i].value = formatRibuanKey(this.value);
                                    });
                                  }
                                    function formatRibuanKey(angka){
                                        var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                        split           = number_string.split(','),
                                        sisa            = split[0].length % 3,
                                        angka_hasil     = split[0].substr(0, sisa),
                                        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

                                        // tambahkan titik jika yang di input sudah menjadi angka ribuan
                                        if(ribuan){
                                            separator = sisa ? '.' : '';
                                            angka_hasil += separator + ribuan.join('.');
                                        }
                                
                                        angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
                                        return angka_hasil;
                                    }
                                  </script>
                            <?php } ?>
                          </div>
                        <?php } ?>

                        <?php $role_id = $this->session->userdata('role_id'); ?>
                      </div>
                      
                    </div>
                  </div>
                </div>
               

                <li class="list-group-item <?= $datenow > $duedate && $ak['precentage'] < 100 ? "bg-danger-light" : ""  ?>">
                  <?php if ($role_id != '4') { ?>



                    <div class="row mt-2">

                      <div class="col-lg-12">

                        <?php if (empty($ak['description_kr'])) { ?>
                          <h4 class="text-muted mt-1">Catatan : Belum Ada Catatan</h4>
                        <?php } else { ?>
                          <h4 class="text-muted mt-1" id="desc-key">Catatan : <?= $ak['description_kr'] ?></h4>
                        <?php } ?>
                        <div class="row">
                          <div class="col-lg-2">
                           <?php if($can_delete == '1') { ?>
                              <a href="" data-target="<?= base_url(); ?>project/deleteKey/<?= $id_pjkr ?>/<?= $ak['id_okr'] ?>/<?= $ak['id_kr']; ?>" class="btn btn-danger tombol-hapus btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Hapus">
                                <span class="btn--inner-icon">
                                  <i class="fas fa-trash"></i></span>
                                <span class="btn-inner--text"></span>
                              </a>
                            <?php } ?>
                            <?php if($can_edit == '1') { ?>
                            <a type="button" href="" class="btn btn-warning btn-sm rounded-pill" data-toggle="modal" data-target="#exampleModal<?= $ak['id_kr']; ?>">
                              <span class="btn--inner-icon">
                                <i class="ni ni-settings"></i></span>
                              <span class="btn-inner--text"></span>
                            </a>
                            <?php } ?>
                  
                            <?= form_close(); ?>
                          </div>
                          
                          <div class="col-lg-10 inisiative-line">
                          <?php if($datenow < $duedate) { ?>
                            <a type="button" href="" class="btn btn-success btn-sm rounded-pill mt-2" data-toggle="modal" data-target="#inisiativeModal<?= $ak['id_kr']; ?>" data-idkr="<?= $ak['id_kr']; ?>" id="initiative">
                              <span class="btn--inner-icon">
                                <i class="ni ni-spaceship"></i></span>
                              <span class="btn-inner--text"> Lakukan Inisiative</span>
                            </a>
                            <button type="button" class="btn btn-primary btn-sm rounded-pill mt-2" id="jadikantask"  data-toggle="modal" data-target="#modalTask<?= $ak['id_kr']; ?>">
                              <span class="btn--inner-icon">
                              <i class="ni ni-check-bold"></i></span>
                              <span class="btn-inner--text"> Jadikan Task</span>
                            </button>
                              <div class="modal fade" id="modalTask<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTaskLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalTaskLabel">Input User</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                      <?= form_open_multipart('task/saveTaskOKR/'. $ak['id_kr'] . "/" . $id_pjkr); ?>
                                      <div class="pl-lg-2">
                                      <input type="hidden" name="taskokr" class="form-control" value="<?= $ak['id_okr'] ?>">
                                      <input type="hidden" name="taskkey" class="form-control" value="keyresult">
                                          <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="namakrtask" class="form-control-label">Nama Task</label>
                                                <input class="form-control" type="text" id="namakrtask" name="namakrtask" value="<?= $ak['nama_kr']; ?>">
                                            </div>
                                          </div>
                                          <div class="col-lg-12 mt-3">
                                              <div class="form-group">
                                              <label for="namakrtask" class="form-control-label">Buat Task Untuk</label>
                                              <select class="form-control" id="usertask" name="usertask">
                                                  <?php foreach ($user as $us) : ?>
                                                    <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                  <?php endforeach; ?>
                                                </select>             
                                              </div>
                                          </div>    
                                        </div>
                                      </div>                                        
                                      <div class="modal-footer">
                                        <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="delegasikan">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          <span class="btn-inner--text">Jadikan Task</span>
                                        </button>
                                      </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>

                                <button type="button" class="btn btn-default btn-sm rounded-pill mt-2" id="sambungkandokumen"  data-toggle="modal" data-target="#modalDokumen<?= $ak['id_kr']; ?>">
                                  <span class="btn--inner-icon">
                                  <i class="ni ni-archive-2"></i></span>
                                  <span class="btn-inner--text"> Sambungkan Dokumen</span>
                                </button>
                              <div class="modal fade" id="modalDokumen<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDokumenLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalDokumenLabel">Input User</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                      <?= form_open_multipart('document/saveDocumentKey/'. $ak['id_kr'] . "/" . $id_pjkr); ?>
                                      <div class="pl-lg-2">
                                      <input type="hidden" name="docokr" class="form-control" value="<?= $ak['id_okr'] ?>">
                                      <input type="hidden" name="dockey" class="form-control" value="keyresult">
                                          <div class="col-lg-12 mt-3">
                                              <div class="form-group">
                                                <select class="form-control" id="mydocument" name="mydocument">
                                                <option value="">--Pilih Dokumen--</option>
                                                  <?php foreach ($mydocument as $mydoc) : ?>
                                                    <option value="<?= $mydoc['id_document']; ?>"><?= $mydoc['name_document']; ?></option>
                                                  <?php endforeach; ?>
                                                </select>             
                                              </div>
                                          </div>    
                                        </div>
                                      </div>                                        
                                      <div class="modal-footer">
                                        <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="submitdoc">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          <span class="btn-inner--text">Hubungkan Ke Dokumen</span>
                                        </button>
                                      </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>


                                  <!-- cek -->
                                  <div class="modal fade" id="inisiativeModal<?= $ak['id_kr']; ?>" name="showmodal<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Input Inisiative</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body" style="margin-bottom: -100px;">
                                    <input type="hidden" id="idkrnew" name="idkrnew" class="form-control" value="<?= $ak['id_kr']; ?>">
                                    <div class="row">
                                      <div class="col-lg-3">
                                    <div class="form-group">
                                    <label class="form-control-label" for="input-username">Copy From Key Result</label>
                                      <select class="form-control form-control-sm" id="keyresultselect<?= $ak['id_kr']; ?>">
                                        <?php foreach ($all_key as $allkeys) : ?>
                                          <option value="<?= $allkeys['id_kr']; ?>"><?= $allkeys['nama_kr']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                   </div>
                                      <div class="col-lg-3">
                                      <div class="form-group">
                                      <label for="exampleFormControlSelect1" style="color:white;">Example select</label>
                                          <button class="btn btn-icon btn-sm btn-default copyinisiative<?= $ak['id_kr']; ?>" id="copyinisiative" type="button" data-idkrcopy="<?= $ak['id_kr']; ?>">
                                            <span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i> Copy Initiative</span>
                                        </button>
                                        </div>
                                      </div>
                                  </div>  
                                      <?= form_open_multipart('project/inputInisiative/' . $id_pjkr . '/' . $ak['id_okr'] , 'class="form-inisiative"' , 'id="myforminisiative"') ; ?>
                                      <input type="hidden" id="id_kr" name="id_kr" class="form-control" value="<?= $ak['id_kr']; ?>">
                                      <input type="hidden" id="id_project" name="id_project" class="form-control" value="<?= $id_pjkr; ?>">
                                      <div class="control-group after-add-more<?= $ak['id_kr']; ?>">
                                        <div class="row">
                                          <div class="col-4">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Nama</label>
                                              <input type="text" id="descriptionfirst<?= $ak['id_kr']; ?>" name="description[]" class="form-control">
                                            </div>
                                          </div>
                                          <div class="col-2">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Score</label>
                                              <input type="text" id="valueinitiativefirst<?= $ak['id_kr']; ?>" value="0" name="value_initiative[]" class="form-control valueinput">
                                            </div>
                                          </div>
                                          <div class="col-3">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Tanggal Awal <small class="text-danger">(Optional)</small></label>
                                              <input type="date" id="dateawalinitiativefirst<?= $ak['id_kr']; ?>" name="dateawal[]" class="form-control valueinput">
                                            </div>
                                          </div>
                                          <div class="col-3">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Tanggal Akhir <small class="text-danger">(Optional)</small></label>
                                              <input type="date" id="dateakhirinitiativefirst<?= $ak['id_kr']; ?>" name="dateakhir[]" class="form-control valueinput">
                                            </div>
                                          </div>

                                          <!-- <div class="col-lg-2">
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
                                          </div> -->
                                          <div class="col-lg-3">
                                            <div class="form-group mt-4">
                                              <label class="form-control-label" for="input-username"></label>
                                              <button class="btn btn-icon btn-default rounded-pill add-more<?= $ak['id_kr']; ?>" type="button">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                                <span class="btn-inner--text">Add</span>
                                              </button>
                                            </div>                                      
                                        </div>
                                        </div>
                                      </div>
                                      <script>
                                        var changeformat =  document.querySelectorAll(".form-control.valueinput");

                                        for (let i = 0; i < changeformat.length; i++) {
                                          changeformat[i].addEventListener("keyup", function(e) {
                                          changeformat[i].value = formatRibuanMultiple(this.value);
                                          });
                                        }
                                          function formatRibuanMultiple(angka){
                                              var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                              split           = number_string.split(','),
                                              sisa            = split[0].length % 3,
                                              angka_hasil     = split[0].substr(0, sisa),
                                              ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
                                      
                                              // tambahkan titik jika yang di input sudah menjadi angka ribuan
                                              if(ribuan){
                                                  separator = sisa ? '.' : '';
                                                  angka_hasil += separator + ribuan.join('.');
                                              }
                                      
                                              angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
                                              return angka_hasil;
                                          }
                                        </script>
                                      <div class="row mt-2">
                                        <div class="col-lg-12">
                                          <button class="btn btn-icon btn-default rounded-pill btn-inisiative" type="submit">
                                            <span class="btn-inner--icon"><div class="spinner"></div><i class="ni ni-fat-add"></i></span>
                                            <span class="btn-inner--text">Simpan Inisiative</span>
                                          </button>
                                        </div>
                                      </div>
                                      <?= form_close(); ?>
                                      <div class="copy invisible ">
                                        <div class="control-group copy-addmore<?= $ak['id_kr']; ?>">
                                          <div class="row">
                                            <div class="col-4">
                                              <div class="form-group">
                                                <label class="form-control-label" for="input-username">Nama</label>
                                                <input type="text" id="description" name="description[]" class="form-control">
                                              </div>
                                            </div>
                                            <div class="col-2">
                                              <div class="form-group">
                                                <label class="form-control-label" for="input-username">Score</label>
                                                <input type="text" id="value_initiative" name="value_initiative[]" class="form-control valueinput">
                                              </div>
                                            </div>
                                            <div class="col-3">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Tanggal Awal <small class="text-danger">(Optional)</small></label>
                                              <input type="date" id="dateawalinitiativefirst" name="dateawal[]" class="form-control valueinput">
                                            </div>
                                          </div>
                                          <div class="col-3">
                                            <div class="form-group">
                                              <label class="form-control-label" for="input-username">Tanggal Akhir <small class="text-danger">(Optional)</small></label>
                                              <input type="date" id="dateakhirinitiativefirst" name="dateakhir[]" class="form-control valueinput">
                                            </div>
                                          </div>
                                            <!-- <div class="col-lg-2">
                                            <div class="form-group">
                                              <label class="form-control-label" for="priority">Priority</label>
                                              <select class="form-control form-control" id="priority" name="priority[]">
                                                <option value="" selected>Pilih Prioritas</option>
                                                <option value="3">High</option>
                                                <option value="2">Medium</option>
                                                <option value="1">Low</option>
                                                <option value="0">Lowest</option>
                                              </select>
                                           
                                          </div>
                                          </div> -->
                                            <div class="col-lg-3">
                                              <div class="form-group mt-4">
                                                <label class="form-control-label" for="input-username"></label>
                                                <button class="btn btn-icon btn-danger rounded-pill remove-addmore<?= $ak['id_kr']; ?>" type="button">
                                                  <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                                  <span class="btn-inner--text">Remove</span>
                                                </button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>  
                            <?php } else { ?>
                              <a type="button" class="btn btn-secondary btn-sm rounded-pill mt-2">
                                <span class="btn--inner-icon">
                                  <i class="ni ni-spaceship"></i></span>
                                <span class="btn-inner--text"> Lakukan Inisiative</span>
                              </a>
                            <?php } ?>
                            <a class="btn btn-info btn-sm rounded-pill mt-2" data-toggle="collapse" data-detail="<?= $ak['id_kr']; ?>" data-datenow="<?= $datenow ?>" data-myteam="<?= $myteamid ?>" data-dateover="<?= $duedate ?>" href="#collapseExample<?= $ak['id_kr']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" id="detailinit">
                              <span class="btn--inner-icon">
                                <i class="ni ni-archive-2"></i></span>
                              <span class="btn-inner--text"> See Inisiative</span>
                            </a>
                            <?php if($datenow < $duedate) { ?>
                              <?php if($checkuserses == null) { ?>
                            <button type="button" class="btn btn-success btn-sm rounded-pill mt-2" id="taketask" data-idkr="<?= $ak['id_kr']; ?>" data-user="<?= $this->session->userdata('id') ?>" data-idtim="<?= $checkteam['id_team']; ?>">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-rock"></i></span>
                              <span class="btn-inner--text"> Take Task</span>
                            </button>
                              <?php } ?>
                              <?php } else { ?>
                                <?php if($checkuserses == null) { ?>
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-rock"></i></span>
                              <span class="btn-inner--text"> Take Task</span>
                            </button>
                            <?php } ?>
                              <?php } ?>
                              <?php if($datenow < $duedate) { ?>
                            <?php if($checkdelegate == null) { ?>
                              <button type="button" class="btn btn-warning btn-sm rounded-pill mt-2" id="risehand" data-idkr="<?= $ak['id_kr']; ?>" data-user="<?= $this->session->userdata('id') ?>" data-idtim="<?= $checkteam['id_team']; ?>">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-paper"></i></span>
                              <span class="btn-inner--text"> Raise Hand</span>
                            </button>
                            <?php } ?>
                            <?php } else { ?>
                              <?php if($checkdelegate == null) { ?>
                              <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2">
                              <span class="btn--inner-icon">
                              <i class="fas fa-hand-paper"></i></span>
                              <span class="btn-inner--text"> Raise Hand</span>
                            </button>
                            <?php } ?>
                            <?php } ?>
                            <?php if($datenow < $duedate) { ?>
                            <button type="button" class="btn btn-info btn-sm rounded-pill mt-2" data-toggle="modal" data-target="#modalDelegate<?= $ak['id_kr']; ?>">
                              <span class="btn--inner-icon">
                              <i class="ni ni-circle-08"></i></span>
                              <span class="btn-inner--text">Delegate Key</span>
                            </button>
                            <div class="modal fade" id="modalDelegate<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Input User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                    <?= form_open_multipart('project/delegateKr/'. $ak['id_kr']); ?>
                                    <input type="text" id="idtimdelegate" name="idtimdelegate" value="<?= $checkteam['id_team']; ?>" >
                                    <div class="pl-lg-2">
                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                              <select class="js-example-basic-multiple" name="id_user[]" multiple="multiple" data-live-search="true" multiple>
                                                <?php foreach ($user as $us) : ?>
                                                  <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                <?php endforeach; ?>
                                              </select>             
                                            </div>
                                        </div>    
                                      </div>
                                      <?php 
                                        $CI = &get_instance();
                                        $CI->load->model('Project_model');

                                        $usr = $CI->Project_model->getUserDelegateOkr($ak['id_okr']);
                                        
                                        $patner = $CI->Project_model->cekUser($ak['id_okr']);

                                        ?>
                                        <div class="ml-4">
                                          <p><b>Telah di delegasikan kepada :</b></p>
                                        <?php foreach ($usr as $us) : ?>
                                          <a href="" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $us->nama; ?>">
                                            <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $us->foto; ?>">
                                          </a>
                                        <?php endforeach; ?>
                                        <br>
                                        <?php foreach ($patner as $part) : ?>
                                          <a href="" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $part->nama; ?>">
                                            <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $part->foto; ?>">
                                          </a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>                                        
                                    <div class="modal-footer">
                                      <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="delegasikan">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Tambah</span>
                                      </button>
                                      <!-- <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="tambahpatner">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Tambah Sebagai Patner</span>
                                      </button> -->
                                    </div>
                                    <?= form_close(); ?>
                                  </div>
                                </div>
                              </div>
                            <?php } else { ?>
                              <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2">
                              <span class="btn--inner-icon">
                                <i class="ni ni-circle-08"></i></span>
                              <span class="btn-inner--text"> Delegate</span>
                            </button>
                              <?php } ?>  
                              <!--  <div class="dropdown">
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i></span>
                                <span class="btn-inner--text">Export</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">PDF</a>
                                    <a class="dropdown-item" role="button" data-toggle="modal" data-target="#modalExcelkr">Excel</a> 
                              </div>
                              <div class="modal fade" id="modalExcelkr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <?= form_open('project/exportExcelKr/' . $ak['id_kr']); ?>
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Data<p>Anda bisa memilih data apa saja yang akan di Export ke dalam Excel</p></h5>                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">                       
                            <div class="col-6">
                              <div class="card">
                                <div class="card-header">
                                  Key Result
                                </div>
                                <div class="ml-4">
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`id_kr`">
                                    ID Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`okr`.`description_okr`">
                                    Nama Objective
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`nama_kr`">
                                    Nama Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`description_kr`">
                                    Deskripsi Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`value_kr`">
                                    Target Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`value_achievment`">
                                    Progress Value
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`precentage`">
                                    Persentase Progress
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`status`">
                                    Status Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`start_datekey`">
                                    Start Date
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datakr[]" value="`due_datekey`">
                                    Due Date
                                  </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="card">
                              <div class="card-header">
                                  Initiative
                                </div>
                                <div class="ml-4">
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`id_initiative`">
                                    ID Initiative 
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`key_result`.`nama_kr`">
                                    Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`description`">
                                    Description
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`value_initiative`">
                                    Value Initiative
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`startins_date`">
                                    Startins Date
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`dueins_date`">
                                    Dueins Date
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`value_ach_initiative`">
                                    Value Ach Initiative
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`value_percent`">
                                    Value Percent
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`comment`">
                                    Comment
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="datains[]" value="`initiative`.`created_by`">
                                    Created By
                                  </label>
                                  </div>
                                </div>
                              </div>
                            </div>  
                            </div>                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export</button>
                          </div>
                        </div>
                      </div>
                      <?= form_close(); ?>
                    </div> 
                            </div>        
                          </div>
                        </div> -->
                        </div>
                        </div>
                        <div class="collapse" id="collapseExample<?= $ak['id_kr']; ?>" name="showdetail<?= $ak['id_kr']; ?>" >

                          <div class="card">
                            <div class="card-body cek">
                              <div class="show-detail<?= $ak['id_kr']; ?>"> </div>
                              <div class="text-center">
                                <div class="lds-ellipsis" id="loadinisiative"><div></div><div></div><div></div><div></div></div>
                              </div>
                            </div>
                          </div>
                        </div>
                              <?php $id_initiative = $this->Project_model->editInitByIdKr($ak['id_kr']); ?> 

                        <!-- Modal -->
                        <div class="modal fade initiative" id="exampleModal<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Key Result</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <?= form_open_multipart('project/editKey/' . $id_pjkr . '/' . $ak['id_okr']); ?>
                                <div class="pl-lg-4">
                                  <div class="row">
                                    <input type="hidden" id="id_kr" name="id_kr" class="form-control" value="<?= $ak['id_kr']; ?>">
                                    <input type="hidden" id="id_project" name="id_project" class="form-control" value="<?= $id_pjkr; ?>">
                                    <div class="col-lg-12">
                                      <div class="form-group">
                                        <label class="form-control-label" for="input-username">Key Result Name</label>
                                        <input type="text" id="nama_kr" name="nama_kr" class="form-control" value="<?= $ak['nama_kr']; ?>">
                                      </div>
                                    </div>
                                    <?php if ($role_id == 1) { ?>
                                      <div class="col-lg-12">
                                        <div class="form-group">
                                          <label class="form-control-label" for="input-email">Value Key Result</label>
                                          <input class="form-control valueinput" type="text" id="valuekey" name="value_kr" value="<?= $ak['value_kr']; ?>">
                                        </div>
                                      </div>                                                                                                            
                                      
                                      <div class="col-lg-8">
                                            <div class="form-group">
                                              <label class="form-control-label" for="priority">Inisiative Priority</label>
                                              <select class="form-control form-control" id="priority" name="priority">
                                                <option value="" selected>Pilih Prioritas</option>
                                                <option value="3">High</option>
                                                <option value="2">Medium</option>
                                                <option value="1">Low</option>
                                                <option value="0">Lowest</option>
                                              </select>
                                              <button type="button" class="btn btn-dark-primary my-4 rounded-pill" data-toggle="modal" data-target="#tambahModal<?= $ak['id_kr']; ?>">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                                <span class="btn-inner--text">Pilih Tugas</span>
                                              </button>
                                              <div class=" modal fade" id="tambahModal<?= $ak['id_kr']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Pilih Tugas</h5>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                              <div class="col-12">
                                                                <div class="card">
                                                                  <div class="card-header">
                                                                    <h3>Initiative</h3>
                                                                  </div>
                                                                  <div class="card-body">
                                                                  <?php if (empty($id_initiative)) { ?>
                                                                    <h4>Data tidak ditemukan!</h4>
                                                                  <?php } else { ?>
                                                              <?php foreach($id_initiative as $init) {?>
                                                                <input type="hidden" id="id_initiative" name="id_initiative[]" class="form-control" value="<?= $init['id_initiative']; ?>">
                                                                <div class="my-3">
                                                                  <label>
                                                                      <input type="checkbox" name="kuadran[]" value="<?= $init['id_initiative']; ?>">
                                                                      <?= $init['description']; ?>
                                                                  </label>
                                                                </div>
                                                              <?php } ?>
                                                              <?php } ?>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div> 
                                                        <div class="modal-footer">
                                                        </div>
                                                      </div>
                                                    </div>
                                                
                                            </div>
                                          </div>

                                      <div class="col-lg-12">
                                        <div class="form-group">
                                          <label class="form-control-label" for="input-email">Due Date</label>
                                          <input class="form-control" type="datetime-local" id="due_datekey" name="due_datekey" value="<?= date('Y-m-d\TH:i', strtotime($ak["due_datekey"])); ?>">
                                        </div>
                                      </div>
                                    <?php } else { ?>
                                      <input class="form-control" type="hidden" id="example-number-input" name="value_kr" value="<?= $ak['value_kr']; ?>">
                                      <input class="form-control" type="hidden" id="due_datekey" name="due_datekey" value="<?= date('Y-m-d\TH:i', strtotime($ak["due_datekey"])); ?>">
                                    <?php } ?>
  

                           
                                    <div class=" row">
                                      <div class="col-lg-12">
                                        <button class="btn btn-icon btn-default rounded-pill" type="submit" name="editKey">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          <span class="btn-inner--text">Edit</span>
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
                     <?php } else { ?>
                    <?= form_close(); ?>  
                     <?php } ?> 
                </li>
                
              <?php
              endforeach;
              ?>
            </ul>

         
              
      
          <div class="row mt-3">
            <?php $id_project = $this->uri->segment(3); ?>
            <div class="col-lg-3">
              <a href="<?= base_url(); ?>project/showOkr/<?= $id_project; ?>" id="backbutton" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
              </a>
            </div>
          </div>

          
          <div class="modal fade" id="showCmnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="showCmnModal">Note</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body modal-comment-ini">
                  <!-- <textarea class=""></textarea> -->
                  <div class="show-cmt">
                  </div>
                </div>
                <div class="modal-footer">

                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="showInputModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xxl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="showInputModal">Input Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h2 id="descini"></h2>

                        <div class="text-center">
                          <h1 class="mt-0 mb-0 percent-key">

                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i><span id="cekpercen"></span>%</span>
                           
                          </h1>
                        </div>
                        <div class="text-center mb-3">
                          <div class="badge badge-default">
                            <span>Start : <span id="valinistart"></span></span>
                          </div>
                          <div class="badge badge-default">
                            <span>Target : <span id="valach"></span></span>
                          </div>
                        </div>
                       
                        <?= form_open_multipart('project/inputProgressInitiative', 'class="form-inputprogress"'); ?>
                        <?php $idpjkr = $this->uri->segment(3); ?>
                        <?php $idokr = $this->uri->segment(4); ?>
                        <div class="row">
                        <input type="hidden" id="percent" name="percent">
                          <input type="hidden" id="idini" name="idini">
                          <input type="hidden" id="idkr" name="idkr">
                          <input type="hidden" id="idokr" name="idokr" value="<?= $idokr; ?>">
                          <input type="hidden" id="idpjkr" name="idpjkr" value="<?= $idpjkr; ?>">
                          <input type="hidden" id="valfirst" name="valfirst">


                          <div class="col-lg-12 mb-2 d-flex justify-content-center">
                            <input class="form-control form-control form-nm w-50" type="text" id="inputscore" name="input-score">
                            <?php if($role_id == 1) { ?>
                            <div id="adjustment" data-user="<?= $this->session->userdata('id') ?>" data-namauser="<?= $this->session->userdata('nama') ?>"><i class="fas fa-check-square"></i></div>
                            <?php } ?>
                          </div>
                          <div class="col-lg-9 mb-1">
                            <div class="form-group">
                              <!-- <textarea class="form-control ckeditor" name="cmtini" rows="3" id="ckedtor"></textarea> -->
                              <div class="form-control" name="cmtini" rows="10" id="desciniinput"></div>
                            </div>
                          </div>

                          <input type="hidden" id="commentinvoice" name="commentinvoice">
                       
                          <div class="col-lg-3">
                          <div class="card border-primary mb-3 auto" style="max-width: 18rem;">
                          <div class="card-header">Log Inisiative</div>
                          <div class="card-body text-primary">

                          <span class="showhistory"></span>
        
                            <ul id="showlist" class="list-group list-group-flush"></ul>
  
                          </div>
                        </div>
                          </div>
                          <?php if($can_edit == '0' && $can_delete == '0') { ?>
                            <div class="col-lg-12 text-center">
                            <button class="btn btn-lg btn-icon rounded-pill btn-outline-default btn-progress" type="button" disabled>
                            <span class="btn-inner--icon"><div class="spinner"></div><i class="fas fa-plus"></i></span>                                
                            <span class="btn-inner--text">&nbsp;Save Progress Initiative</span>
                            </button>
                          </div>
                          <?php } else { ?>
                            <div class="col-lg-12 text-center">
                            <button class="btn btn-lg btn-icon rounded-pill btn-outline-default btn-progress" type="submit" id="submitprogress">
                            <span class="btn-inner--icon"><div class="spinner"></div><i class="fas fa-plus"></i></span>                                
                            <span class="btn-inner--text">&nbsp;Save Progress Initiative</span>
                            </button>
                          </div>
                          <?php } ?>
                         
                        </div>


                        <?php $role_id = $this->session->userdata('role_id'); ?>
                      </div>
                      <?= form_close(); ?>
                      <div class="modal-footer">

                      </div>
                    </div>
                  </div>
                </div>
                
                     
          
          <div class="modal fade" id="showEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="showInputModal">Edit Initiative</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <?= form_open_multipart('project/editInitiative/'); ?>
                  <div class="pl-lg-4">
                    <div class="row">
                      <input type="hidden" id="idinisiative" name="idinisiative" class="form-control">
                      <input type="hidden" id="idkyer" name="idkyer" class="form-control">
                      <input type="hidden" id="idokr" name="idokr" class="form-control" value="<?= $idokr; ?>">
                      <input type="hidden" id="idpjkr" name="idpjkr" class="form-control" value="<?= $idpjkr; ?>">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Nama</label>
                          <input type="text" id="descriptioninitiative" name="descriptioninitiative" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Score</label>
                          <input class="form-control" type="text" id="valueinitiative" name="value_initiative">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="datestarteditini">Tanggal Awal</label>
                          <input class="form-control" type="date" id="datestarteditini" name="datestarteditini">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="dateendeditini">Tanggal Akhir</label>
                          <input class="form-control" type="date" id="dateendeditini" name="dateendeditini">
                        </div>
                      </div>
                     
                                                                                                        
                          <div class=" row">
                            <div class="col-lg-12">
                              <button class="btn btn-icon btn-default rounded-pill" type="submit" name="editIni">
                                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                <span class="btn-inner--text">Edit</span>
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

          </div>
                    
          <!-- Modal -->
        <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="detail_user" >
              
              </div>
            </div>
          </div>
        </div>

                      <div class="modal fade" id="taskIniModal" tabindex="-1" role="dialog" aria-labelledby="taskIniModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="taskIniModalLabel">Input Task Inisiative</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                      <?= form_open_multipart('task/saveTaskIni/'); ?>
                                      <div class="pl-lg-2">
                                      <input type="hidden" name="taskokr" id="taskokr" class="form-control" >
                                      <input type="hidden" name="taskini" id="taskini" class="form-control" >
                                      <input type="hidden" name="taskpj"  id="taskpj" class="form-control" >
                                      <input type="hidden" name="tasktype" class="form-control" value="initiative">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="namakrtaskini" class="form-control-label">Nama Task</label>
                                                <input class="form-control" type="text" id="namakrtaskini" name="namakrtaskini">
                                            </div>
                                          </div>
                                          <div class="col-lg-12 mt-3">
                                              <div class="form-group">
                                              <label for="usertaskini" class="form-control-label">Jadikan Task Untuk</label>
                                              <select class="form-control" id="usertaskini" name="usertaskini">
                                                  <?php foreach ($user as $us) : ?>
                                                    <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                  <?php endforeach; ?>
                                                </select>             
                                              </div>
                                          </div>    
                                        </div>
                                      </div>                                        
                                      <div class="modal-footer">
                                        <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="delegasikan">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          <span class="btn-inner--text">Tambah Task</span>
                                        </button>
                                      </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>


                                <div class="modal fade" id="docIniModal" tabindex="-1" role="dialog" aria-labelledby="docIniModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="docIniModalLabel">Input Dokumen Inisiative</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                      <?= form_open_multipart('document/saveDocumentIni/'); ?>
                                      <div class="pl-lg-2">
                                      <input type="hidden" name="docokr" id="docokr" class="form-control" >
                                      <input type="hidden" name="docini" id="docini" class="form-control" >
                                      <input type="hidden" name="docpj"  id="docpj" class="form-control" >
                                      <input type="hidden" name="doctype" class="form-control" value="initiative">
                                          <div class="col-lg-12 mt-3">
                                              <div class="form-group">
                                              <select class="form-control" id="mydocumentini" name="mydocumentini">
                                                <option value="">--Pilih Dokumen--</option>
                                                  <?php foreach ($mydocument as $mydoc) : ?>
                                                    <option value="<?= $mydoc['id_document']; ?>"><?= $mydoc['name_document']; ?></option>
                                                  <?php endforeach; ?>
                                                </select>           
                                              </div>
                                          </div>    
                                        </div>
                                      </div>                                        
                                      <div class="modal-footer">
                                        <button class="btn btn-icon btn-dark-primary" type="submit" name="action" value="ini">
                                          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          <span class="btn-inner--text">Hubungkan Dokumen</span>
                                        </button>
                                      </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>



                          <?php 
                            $CI = &get_instance();
                            $CI->load->model('Project_model');

                            $data = $CI->Project_model->getInitiativeById($ak['id_kr']);
                          ?>
           
                          <?php foreach($data as $dt) : ?>
                            <div class="modal fade" id="modalDelegateInit<?= $dt['id_initiative']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Input User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                    <?= form_open_multipart('project/delegateInit/'. $dt['id_initiative']); ?>
                                    <div class="pl-lg-2">
                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                              <!-- <input type="hidden" id="id_team" name="id_team" class="form-control" value="<?= $team['id_team']; ?>"> -->
                                              <!-- <select class="bootstrap-select" name="id_user[]" multiple="multiple" data-width="100%" data-live-search="true" multiple> -->
                                              <select class="js-example-basic-multiple" name="id_user[]" multiple="multiple" data-live-search="true" multiple>
                                                <?php foreach ($user as $us) : ?>
                                                  <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                <?php endforeach; ?>
                                              </select>             
                                            </div>
                                        </div>    
                                      </div>
                                        <?php 
                                        $CI = &get_instance();
                                        $CI->load->model('Project_model');

                                        $usr = $CI->Project_model->getUserDelegateInit($dt['id_initiative']);
                                        ?>
                                        <div class="ml-4">
                                          <p><b>Telah di delegasikan kepada :</b></p>
                                        <?php foreach ($usr as $us) : ?>
                                          <a href="" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $us->nama; ?>">
                                            <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $us->foto; ?>">
                                          </a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>                                        
                                    <div class="modal-footer">
                                      <button class="btn btn-icon btn-dark-primary" type="submit" name="inputDepartement">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Tambah</span>
                                      </button>
                                    </div>
                                    <?= form_close(); ?>
                                  </div>
                                </div>
                              </div>
                              <?php endforeach; ?>
        </div>
      </div>
      <?php } ?>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script>
             $(document).ready(function () {
         const deadlines = document.querySelectorAll(".duedatekeyvalue");
          // Mengambil semua input deadline dengan menggunakan querySelectorAll
          const countdown = document.querySelectorAll('.countdowncontainer');
          console.log("cek");
          function updateCountdown() {
 
            let html = '';
            // deadlines.forEach((deadline) => {
            for (var j = 0; j < deadlines.length; j++) {
              const endDate = new Date(deadlines[j].value).getTime(); // ambil waktu akhir dari nilai input
              const now = new Date().getTime(); // ambil waktu sekarang
              const timeLeft = endDate - now; // hitung selisih waktu
            if (timeLeft > 0) {
              const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
              const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              html = `<span><b>Deadline</b>: ${days} hari ${hours} jam</span>`; // tampilkan hasil
            } else {
              html = `<span class="badge badge-danger">Deadline Habis !!!</span>`; // tampilkan pesan jika waktu sudah berakhir
            }

          countdown[j].innerHTML = html; // tampilkan hasil pada elemen HTML

         }
        }

        // panggil fungsi updateCountdown setiap 1 detik
        setInterval(() => {
          updateCountdown();
        }, 1000);   
      });
        $(document).ready(function () {
          let sesskr = <?= $this->session->userdata('dataidkr') ?>;
          if(sesskr != '0') {

          let sesskr = <?= $this->session->userdata('dataidkr') ?>;

          var datenow = "<?= $this->session->userdata('datenow') ?>";
          var dateover = "<?= $this->session->userdata('dateover') ?>";
          var myteam = <?= $this->session->userdata('myteam') ?>;
      

          $('div[name="showdetail' + sesskr + '"]').collapse('show');

          $('div[name="showdetail'+sesskr+'"]').on('shown.bs.collapse', function(e) {

              $.ajax({
                      url: "<?= base_url() ?>project/getDetail",
                      type: "POST",
                      dataType: 'json',
                      beforeSend: function(){
                          $('.lds-ellipsis').css("visibility", "visible");
                      },
                      data: {
                        idkr: sesskr,
                        datenow: datenow,
                        dateover: dateover,
                        myteam: myteam,
                      },
                      success: function(data) {
                        $('.show-detail'+sesskr ).html(data); //menampilkan data ke dalam modal
                      },
                      complete: function(){
                          $('.lds-ellipsis').css("visibility", "hidden");                
                      },
                    });
                });
             }
             
        });
          // Event listener for showing modals
        $(document).on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var content = button.data('content'); // Extract content from data-* attributes
            var id = button.data('id'); // Extract ID from data-* attributes

            // Initialize Quill editor for the specific modal
            var quillEditorId = '#descinkeyresult' + id;
            var quill = new Quill(quillEditorId, {
                theme: 'snow'
            });

            // Set Quill content
            quill.root.innerHTML = content;

            // Handle form submission
            $(document).on('submit', '.form-inputkey', function() {
                var quillContent = quill.root.innerHTML;
                $('#quillContent' + id).val(quillContent);
            });
        });


       
          
      
      </script>




    















      
      

      
      