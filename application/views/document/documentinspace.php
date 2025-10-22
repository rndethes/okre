<div id="roomspace"></div>
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
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Workspace</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Workspace</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $space['name_space'] ?></li>
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
      <!-- <div class="card card-frame">
        <div class="card-body"> -->
        <div class="alert alert-secondary" role="alert">
        <div class="row align-items-center">
          <div class="col-lg-10">
            <h3 class="text-primary">  <button type="button" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
            </button> WORKSPACE <?= $space['name_space'] ?></h3>
           </div>
           <div class="col-auto">
           <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
              <span class="btn-inner--text">Kembali</span>
            </a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- BATAASSSS -->
<div class="container-fluid">
  <div class="row">   
    <div class="col-lg-12 mb-4">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text-tabnav" role="tablist">
          <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-1-tabnav" href="<?= base_url("project/projectAtWorkspace/") . $this->session->userdata('workspace_sesi') ?>" role="tab" aria-controls="tabs-text-1" aria-selected="true">OKR</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-3-tab" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false">Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tab" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-2" aria-selected="false">Document</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-4-tab" href="<?= base_url("workspace/chatspace/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-4" aria-selected="true">Chat</a>
            </li>
          </ul>
        </div> 
      </div> 
    </div> 
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-6">
                <div class="card bg-gradient-primary">
                  <div class="card-body">
                    <h3 class="card-title text-white">Buat Dokumen</h3>
                    <blockquote class="blockquote text-white mb-0">
                        <p>Buat Dokumen klik Disini.</p>
                        <a href="<?= base_url("data/createDocument/") . $this->uri->segment(3) . "/space" ?>" type="button" class="btn btn-secondary rounded-pill">
                          Buat Dokumen
                        </a>
                    </blockquote>
                  </div>
                </div>
              </div>
            <div class="col-lg-6">
              <div class="card bg-gradient-default">
                <div class="card-body">
                  <h3 class="card-title text-white">Buat Dokumen Pengajuan</h3>
                  <blockquote class="blockquote text-white mb-0">
                      <p>Unggah Dokumen Disini.</p>
                      <button type="button" class="btn btn-secondary rounded-pill" data-toggle="modal" data-target="#unggahModal">
                        Unggah Dokumen
                      </button>
                      <!-- <a href="<?= base_url("document/documentinput/") . $this->uri->segment(4) ?>" type="button" class="btn btn-secondary rounded-pill">
                        Unggah Document
                      </a>                 -->
                  </blockquote>
                </div>
              </div>
            </div>
          </div>
          </div>
          <?php 
            $CI = &get_instance();
            $CI->load->model('Space_model');
            $idspace = $this->session->userdata('workspace_sesi');
            $id = $this->session->userdata('id');
            $myidspace = $CI->Space_model->cekSpaceTeamId($id,$idspace);
          ?>
        <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
              
              <?php $role_id = $this->session->userdata('role_id') ?>

              <ul class="nav nav-pills nav-fill flex-column flex-sm-row mb-4" id="tabs-text-doc">
                  <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active" id="yourdoc-tab" data-toggle="tab" href="#yourdoc" role="tab" aria-controls="yourdoc" aria-selected="true">Dokumen Pengajuan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="spacedoc-tab" data-toggle="tab" href="#spacedoc" role="tab" aria-controls="spacedoc" aria-selected="false">Documen Space</a>
                  </li>
              </ul>
             
              <div class="data-yourdoc">
              <h2 class="mb-0" style="padding-left: 15px;">Dokumen Pengajuan</h2>
              <br>
             
                <div class="table-responsive" id="table-you">
                  <div>
                      <table class="table align-items-center">
                          <thead class="thead-light">
                              <tr>
                                  <th scope="col" class="sort" data-sort="name">Nama Document</th>
                                  <th scope="col" class="sort" data-sort="budget">Type Document</th>
                                  <th scope="col" class="sort" data-sort="status">Space</th>
                                  <th scope="col">Pemilik</th>
                                  <th scope="col">OKR</th>
                                  <th scope="col" class="sort" data-sort="completion">Status</th>
                                  <th scope="col"></th>
                              </tr>
                          </thead>
                          <?php if(empty($mydocument)) { ?>
                          
                            <div class="alert alert-primary" role="alert">
                                <strong>Maaf !</strong> Tidak Ada Data!
                            </div>
                          
                          <?php }  else { ?>
                          <tbody class="list">
                          
                          <?php foreach($mydocument as $my) { ?>
                          <?php
                          $CI = &get_instance();
                          $CI->load->model('Account_model');
                          $CI->load->model('Space_model');

                            $idodc = $my['id_document'];

                            $cekdokumeninOKR = $CI->Space_model->checkDocInOKR($idodc);

                            if(empty($cekdokumeninOKR)) {
                              $okr = "<span class='badge badge-pill badge-secondary'>None</span>";
                            } else {

                              $type = $cekdokumeninOKR['type_doc_in_okr'];
                              $id   = $cekdokumeninOKR['id_to_doc_in_okr'];

                              $datapj = checkProject($id,$type);

                              $idpj = $datapj['idokr'];
                              $nama = $datapj['namaokr'];
                              $progress = $datapj['progressokr'];

                              if($type == 'inisiative'){
                                $id = checkKeyResult($id);
                              } else {
                                $id = $datapj['idobjective'];
                              }

                              $okr = "<a href='' type='button' data-namaokr='".$nama."' data-descokr='Dokumen Masuk ke ".$type."' data-progressokr='".$progress."' data-url='".base_url('project/showKey/').$idpj.'/'.$id."' class='badge badge-pill badge-primary checkmyokr'>Dokumen Tersambung OKR</a>";
                            }

                            

                            $ceksignature = $CI->Space_model->checkSignatureById($idodc);
                            $allsign      = $CI->Space_model->checkAllSignatureFile($idodc);
                            $iduserscek = $this->session->userdata('id');
                            $checkAllAprove = $CI->Space_model->DataAllAprove($idodc);


                            
                            if(empty($ceksignature)) {
                              $nama ="";
                            
                            } else {
                              $usermy_id = $my['id_user_create'];

                              $usersdoc     = $CI->Account_model->getAccountById($usermy_id);
                              $logterakhir  = $CI->Space_model->logTerakhir($idodc);
                              $checkSign    = $CI->Space_model->checkUserSignature($iduserscek,$idodc);
                        
                            
                              
                                $nama = $usersdoc['nama'];
                                $idusesign = $checkSign;
                              }

                              $ifisign    = $CI->Space_model->checkIfISign($iduserscek,$idodc);
                              $ifuserscek = $CI->Space_model->checkIfISignature($iduserscek,$idodc);

                              $ifusersApprove = $CI->Space_model->checkIfISignatureApprove($iduserscek,$idodc);
                              

                              if(!empty($ifisign)) {

                                $mynomorsign = $ifisign['no_signature'];


                                if($mynomorsign == '1') {
                                  $ifuserrevisi = $CI->Space_model->checkWhoCreateRevisi($idodc,$mynomorsign);
                                  $idrevisi = $ifuserrevisi['id_user_create'];
                                } else {
                                  $ifuserrevisi = $CI->Space_model->checkIfRevisi($idodc,$mynomorsign,$iduserscek);
                                  if(empty($ifuserrevisi)) {
                                    $idrevisi = 0;
                                  } else {
                                    $idrevisi = $ifuserrevisi['id_user_doc'];
                                  } 
                                }                              
                              }
                            ?>
                              <tr>
                                  <th scope="row">
                                      <div class="media align-items-center">
                                          <div class="media-body">
                                              <span class="name mb-0 text-sm"><?= $my['name_document'] ?></span>
                                          </div>
                                      </div>
                                  </th>
                                  <?php if($my['type_document'] == '1' ) { ?>
                                    <td>
                                    Surat
                                  </td>
                                  <?php } else if($my['type_document'] == '2') { ?> 
                                    <td>
                                    Invoice
                                  </td>
                                  <?php } else if($my['type_document'] == '3') { ?>
                                    <td>
                                    Proposal
                                  </td>
                                  <?php } else if($my['type_document'] == '4') { ?>
                                    <td>
                                    BAA
                                  </td>
                                  <?php } else { ?>
                                    <td>
                                    Dokumen Lainnya
                                  </td>
                                  <?php } ?>
                                  <td>
                                      <span class="badge badge-dot mr-4">
                                        <i class="bg-warning"></i>
                                        <span class="status"><?= $my['name_space'] ?></span>
                                      </span>
                                  </td>
                                  <td>
                                    <?php 
                                    $usersdoc     = $CI->Account_model->getAccountById($my['id_user_create']);
                                    ?>
                                    <?= $usersdoc['nama'] ?>
                                  </td>
                                  <td>
                                    <?= $okr ?>
                                  </td>
                                  <td>
                                  <?php if($my['status_document'] == '5') { ?>
                                    <span class="badge badge-pill badge-warning">Revisi</span>
                                  <?php } else { ?>
                                    <?php if(empty($ceksignature)) { ?>
                                      <span class="badge badge-pill badge-warning">Pembuatan</span>
                                      <?php } else { ?>
                                      <?php if($my['status_document'] != '4') { ?>
                                      <?php if($checkAllAprove['conclusion'] == "NotApprove") {  ?>
                                      <?php if($logterakhir['status_log'] == '1') { ?>
                                        <span class="badge badge-pill badge-info">Menunggu</span>
                                      <?php } else if($logterakhir['status_log'] == '2') { ?>
                                      <span class="badge badge-pill badge-success">Approve By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else if($logterakhir['status_log'] == '3') { ?>
                                      <span class="badge badge-pill badge-danger">Reject By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else if($logterakhir['status_log'] == '4') { ?>
                                      <span class="badge badge-pill badge-warning">Revisi By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else { ?>
                                        <span class="badge badge-pill badge-warning">Created By By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } ?>
                                      <?php } else { ?>
                                        <span class="badge badge-pill badge-success">All Approve</span>
                                        <?php } ?>
                                        <?php } else { ?>
                                          <span class="badge badge-pill badge-success">Publish At <?= date("Y-m-d H:i",strtotime($my['publish_at'])) ?></span>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                    </td>
                                    <?php if($my['status_document'] == '1' ) { ?>
                                      <td>
                                        <?php if($my['id_project'] == '0') { ?>
                                          
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        
                                        <?php } ?>
                                        <a href="<?= base_url("document/editdocument/") . $this->uri->segment(4) . "/" . $my['id_document'] ?>" class="btn btn-warning btn-sm rounded-pill">
                                          <span class="btn--inner-icon">
                                          <i class="fas fa-users"></i></span>
                                          <span class="btn-inner--text">Tambah Penandatangan</span>
                                        </a>
                                        <a data-link="<?= base_url("document/deleteDocument/") . $my['id_document'] ?>" class="btn btn-danger btn-sm tombol-hapus-dokumen rounded-pill text-white">
                                              <span class="btn--inner-icon"><i class="fas fa-trash"></i></span>
                                              <span class="btn-inner--text">Hapus</span>
                                          </a>
                                    </td>
                                    <?php } else if($my['status_document'] == '5') { ?>
                                      
                                      <?php if($iduserscek == $idrevisi) { ?>
                                      <td>
                                            <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                        <a href="<?= base_url("document/revisidocument/") . $this->uri->segment(4) . "/" . $my['id_document'] ?>" class="btn btn-warning btn-sm rounded-pill">
                                          <span class="btn--inner-icon">
                                          <i class="fas fa-sync-alt"></i></span>
                                          <span class="btn-inner--text">Revisi</span>
                                        </a>
                                        
                                      </td>
                                      <?php } else { ?>
                                        <td>
                                            <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                        <a href="" class="btn btn-secondary btn-sm rounded-pill">
                                          <span class="btn--inner-icon">
                                          <i class="fas fa-sync-alt"></i></span>
                                          <span class="btn-inner--text">Menunggu Revisi</span>
                                        </a>
                                        <a href="<?= base_url("document/previewDocument/") . $my['id_document'] ?>" class="btn btn-info btn-sm rounded-pill" type="button" data-doc="<?= $my['id_document'] ?>">
                                                      <span class="btn--inner-icon">
                                                      <i class="ni ni-archive-2"></i></span>
                                                      <span class="btn-inner--text">Lihat</span>
                                                  </a>
                                        
                                      </td>
                                      <?php } ?>                        
                                    <?php } else { ?>
                                      <?php if($checkAllAprove['conclusion'] == "NotApprove") {  ?>
                                      <?php if($my['status_document'] == '2') { ?> 
                                        <?php if(!empty($allsign)) { ?>
                                          <?php if(!empty($ifuserscek)) { ?>   
                                          <td>
                                              <?php if($my['id_project'] == '0') { ?>
                                                  <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                                      <span class="btn--inner-icon">
                                                      <i class="fas fa-users"></i></span>
                                                      <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                                  </a>
                                                  
                                             <?php } ?>
                                          <?php if(empty($ifusersApprove)) { ?>
                                            <a href="<?= base_url("document/showDocument/") . $my['id_document'] ?>" data-linkback="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" class="btn btn-default btn-sm rounded-pill btn-signall">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-signature"></i></span>
                                              <span class="btn-inner--text"> Tanda Tangani</span>
                                            </a>
                                          </td>
                                          <?php } ?>
                                          <?php } else { ?>
                                            <td>
                                            <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                          <a href="<?= base_url("document/showAfterReject/") . $my['id_document'] . "/" . $this->uri->segment(4) ?>" class="btn btn-info btn-sm rounded-pill">
                                              <span class="btn--inner-icon">
                                              <i class="ni ni-single-copy-04"></i></span>
                                              <span class="btn-inner--text">Lihat Dokumen</span>
                                            </a>
                                            <a href="" class="btn btn-secondary btn-sm rounded-pill">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-signature"></i></span>
                                              <span class="btn-inner--text"> Menunggu di Tanda Tangani </span>
                                            </a>
                                          </td>
                                          <?php } ?>
                                        <?php } else { ?>
                                          <td>
                                        <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                              <a href="<?= base_url("document/showDocument/") . $my['id_document'] ?>" class="btn btn-info btn-sm rounded-pill">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Lihat Dokumen</span>
                                              </a>
                                          </td>                        
                                        <?php } ?>
                                        <?php } else if ($my['status_document'] == '6') { ?>
                                          <?php if(!empty($allsign)) { ?>
                                            <?php if(!empty($ifuserscek)) { ?>
                                          <td>
                                        <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                            <a href="<?= base_url("document/showDocument/") . $my['id_document'] ?>"  data-linkback="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" class="btn btn-default btn-sm rounded-pill btn-signall">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-signature"></i></span>
                                              <span class="btn-inner--text"> Tanda Tangani </span>
                                            </a>
                                          </td>
                                          <?php } else { ?>
                                            <td>
                                              <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                            <a href="" class="btn btn-secondary btn-sm rounded-pill">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-signature"></i></span>
                                              <span class="btn-inner--text"> Menunggu di Tanda Tangani </span>
                                            </a>
                                          </td>
                                          <?php } ?>
                                        <?php } else { ?>
                                          <td>
                                              <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                              <a href="<?= base_url("document/showDocument/") . $my['id_document'] ?>" class="btn btn-info btn-sm rounded-pill">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Lihat Dokumen</span>
                                              </a>
                                          </td>                        
                                        <?php } ?>
                                      <?php } else { ?>
                                        <td>
                                            <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                        
                                        <a href="<?= base_url("document/showAfterReject/") . $this->uri->segment(4) . "/" . $my['id_document'] ?>" class="btn btn-info btn-sm rounded-pill">
                                            <span class="btn--inner-icon">
                                            <i class="ni ni-single-copy-04"></i></span>
                                            <span class="btn-inner--text">Lihat Dokumen</span>
                                          </a>
                                          <a data-link="<?= base_url("document/deleteDocument/") . $my['id_document'] ?>" class="btn btn-danger btn-sm tombol-hapus-dokumen rounded-pill text-white">
                                              <span class="btn--inner-icon"><i class="fas fa-trash"></i></span>
                                              <span class="btn-inner--text">Hapus</span>
                                          </a>
                                      </td>
                                      <?php } ?>
                                      <?php } else { ?>
                                        <?php if($my['id_user_create'] == $iduserscek) { ?>
                                          <td>
                                                <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                            <button id="publish" data-status="fristdoc" data-iddocument="<?= $idodc ?>"  data-prj="<?= $my['id_project'] ?>" class="btn btn-info btn-sm rounded-pill">
                                                <span class="btn--inner-icon">
                                                <i class="ni ni-email-83"></i></span>
                                                <span class="btn-inner--text">Publish</span>
                                            </button>
                                        </td>      
                                        <?php } else { ?>
                                          <td>
                                                <?php if($my['id_project'] == '0') { ?>
                                        <a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectModal" data-doc="<?= $my['id_document'] ?>">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-users"></i></span>
                                              <span class="btn-inner--text">Pindahkan Ke OKR</span>
                                          </a>
                                        <?php } ?>
                                            <button data-status="fristdoc" data-iddocument="<?= $idodc ?>"  data-prj="<?= $my['id_project'] ?>" class="btn btn-secondary btn-sm rounded-pill">
                                                <span class="btn--inner-icon">
                                                <i class="ni ni-email-83"></i></span>
                                                <span class="btn-inner--text">Publish</span>
                                            </button>
                                        </td>  
                                        <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                              </tr>  
                          </tbody>
                          <?php } ?>
                      </table>
                  </div>
                </div>
              </div>
              <div class="data-spacedoc d-none">
              <h2 class="mb-0" style="padding-left: 15px;">Dokumen Space</h2>
              <br>
              <div class="table-responsive" id="table-space">
              <div>
                      <table class="table align-items-center">
                          <thead class="thead-light">
                              <tr>
                                  <th scope="col" class="sort" data-sort="name">Nama Document</th>
                                  <th scope="col" class="sort" data-sort="budget">Type Document</th>
                                  <th scope="col" class="sort" data-sort="status">Space</th>
                                  <th scope="col">Pemilik</th>
                                  <th scope="col">OKR</th>
                                  <th scope="col" class="sort" data-sort="completion">Status</th>
                                  <th scope="col"></th>
                                 
                              </tr>
                          </thead>
                          <?php if(empty($documentall)) { ?>
                          
                            <div class="alert alert-primary" role="alert">
                                <strong>Maaf !</strong> Tidak Ada Data!
                            </div>
                          
                          <?php }  else { ?>
                          <tbody class="list">
                          
                          <?php foreach($documentall as $dcall) { ?>
                          <?php
                          $CI = &get_instance();
                          $CI->load->model('Account_model');
                          $CI->load->model('Space_model');

                            $idodc = $dcall['id_document'];

                            $cekdokumeninOKR = $CI->Space_model->checkDocInOKR($idodc);

                            if(empty($cekdokumeninOKR)) {
                              $okr = "<span class='badge badge-pill badge-secondary'>None</span>";
                            } else {

                              $type = $cekdokumeninOKR['type_doc_in_okr'];
                              $id   = $cekdokumeninOKR['id_to_doc_in_okr'];

                              $datapj = checkProject($id,$type);

                              $idpj = $datapj['idokr'];
                              $nama = $datapj['namaokr'];
                              $progress = $datapj['progressokr'];

                              if($type == 'inisiative'){
                                $id = checkKeyResult($id);
                              } else {
                                $id = $datapj['idobjective'];
                              }

                              $okr = "<a href='' type='button' data-namaokr='".$nama."' data-descokr='Dokumen Masuk ke ".$type."' data-progressokr='".$progress."' data-url='".base_url('project/showKey/').$idpj.'/'.$id."' class='badge badge-pill badge-primary checkmyokr'>Dokumen Tersambung OKR</a>";
                            }


                            $ceksignature = $CI->Space_model->checkSignatureById($idodc);
                            $allsign      = $CI->Space_model->checkAllSignatureFile($idodc);
                            $iduserscek = $this->session->userdata('id');
                            $checkAllAprove = $CI->Space_model->DataAllAprove($idodc);


                            
                            if(empty($ceksignature)) {
                              $nama ="";
                            
                            } else {
                              $usermy_id = $dcall['id_user_create'];

                              $usersdoc     = $CI->Account_model->getAccountById($usermy_id);
                              $logterakhir  = $CI->Space_model->logTerakhir($idodc);
                              $checkSign    = $CI->Space_model->checkUserSignature($iduserscek,$idodc);
                        
                            
                              
                                $nama = $usersdoc['nama'];
                                $idusesign = $checkSign;
                              }

                              $ifisign    = $CI->Space_model->checkIfISign($iduserscek,$idodc);
                              $ifuserscek = $CI->Space_model->checkIfISignature($iduserscek,$idodc);

                              $ifusersApprove = $CI->Space_model->checkIfISignatureApprove($iduserscek,$idodc);
                              

                              if(!empty($ifisign)) {

                                $mynomorsign = $ifisign['no_signature'];


                                if($mynomorsign == '1') {
                                  $ifuserrevisi = $CI->Space_model->checkWhoCreateRevisi($idodc,$mynomorsign);
                                  $idrevisi = $ifuserrevisi['id_user_create'];
                                } else {
                                  $ifuserrevisi = $CI->Space_model->checkIfRevisi($idodc,$mynomorsign,$iduserscek);
                                  if(empty($ifuserrevisi)) {
                                    $idrevisi = 0;
                                  } else {
                                    $idrevisi = $ifuserrevisi['id_user_doc'];
                                  } 
                                }                              
                              }
                            ?>
                              <tr>
                                  <th scope="row">
                                      <div class="media align-items-center">
                                          <div class="media-body">
                                              <span class="name mb-0 text-sm"><?= $dcall['name_document'] ?></span>
                                          </div>
                                      </div>
                                  </th>
                                  <?php if($dcall['type_document'] == '1' ) { ?>
                                    <td>
                                    Surat
                                  </td>
                                  <?php } else if($dcall['type_document'] == '2') { ?> 
                                    <td>
                                    Invoice
                                  </td>
                                  <?php } else if($dcall['type_document'] == '3') { ?>
                                    <td>
                                    Proposal
                                  </td>
                                  <?php } else if($dcall['type_document'] == '4') { ?>
                                    <td>
                                    BAA
                                  </td>
                                  <?php } else { ?>
                                    <td>
                                    Dokumen Lainnya
                                  </td>
                                  <?php } ?>
                                  <td>
                                      <span class="badge badge-dot mr-4">
                                        <i class="bg-warning"></i>
                                        <span class="status"><?= $dcall['name_space'] ?></span>
                                      </span>
                                  </td>
                                  <td>
                                    <?php 
                                    $usersdoc     = $CI->Account_model->getAccountById($dcall['id_user_create']);
                                    ?>
                                    <?= $usersdoc['nama'] ?>
                                  </td>
                                  <td>
                                    <?= $okr ?>
                                  </td>
                                  <td>
                                  <?php if($dcall['status_document'] == '5') { ?>
                                    <span class="badge badge-pill badge-warning">Revisi</span>
                                  <?php } else { ?>
                                    <?php if(empty($ceksignature)) { ?>
                                      <span class="badge badge-pill badge-warning">Pembuatan</span>
                                      <?php } else { ?>
                                      <?php if($dcall['status_document'] != '4') { ?>
                                      <?php if($checkAllAprove['conclusion'] == "NotApprove") {  ?>
                                      <?php if($logterakhir['status_log'] == '1') { ?>
                                        <span class="badge badge-pill badge-info">Menunggu</span>
                                      <?php } else if($logterakhir['status_log'] == '2') { ?>
                                      <span class="badge badge-pill badge-success">Approve By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else if($logterakhir['status_log'] == '3') { ?>
                                      <span class="badge badge-pill badge-danger">Reject By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else if($logterakhir['status_log'] == '4') { ?>
                                      <span class="badge badge-pill badge-warning">Revisi By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } else { ?>
                                        <span class="badge badge-pill badge-warning">Created By By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                      <?php } ?>
                                      <?php } else { ?>
                                        <span class="badge badge-pill badge-success">All Approve</span>
                                        <?php } ?>
                                        <?php } else { ?>
                                          <span class="badge badge-pill badge-success">Publish At <?= date("Y-m-d H:i",strtotime($dcall['publish_at'])) ?></span>
                                      <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                    </td>
                                    <?php if($myidspace['status_user'] == 'admin') { ?>
                                      
                                        <td>
                                          <?php if($dcall['status_document'] == '5') { ?>
                                          <a href="<?= base_url("document/revisidocument/") . $this->uri->segment(4) . "/" . $dcall['id_document'] ?>" class="btn btn-warning btn-sm rounded-pill">
                                              <span class="btn--inner-icon">
                                              <i class="fas fa-sync-alt"></i></span>
                                              <span class="btn-inner--text">Revisi</span>
                                            </a>
                                        <?php } ?>
                                          <a href="<?= base_url("document/previewDocument/") . $dcall['id_document'] ?>" data-linkback="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" class="btn btn-primary btn-sm rounded-pill btn-signall">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Lihat Dokumen</span>
                                              </a>
                                        <td>
                                  
                                    <?php } else { ?>
                                      <td>
                                        <a href="<?= base_url("document/previewDocument/") . $dcall['id_document'] ?>" data-linkback="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" class="btn btn-primary btn-sm rounded-pill btn-signall">
                                                  <span class="btn--inner-icon">
                                                  <i class="ni ni-archive-2"></i></span>
                                                  <span class="btn-inner--text">Lihat Dokumen</span>
                                              </a>
                                          </td>
                                    <?php } ?>
                                <?php } ?>
                              </tr>  
                          </tbody>
                          <?php } ?>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
        <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Pindahkan Ke Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?= form_open_multipart('document/moveToProject/'); ?>
            <input type="hidden" name="iddocumentpj" id="iddocumentpj" class="form-control" >
            <input type="hidden" name="idspacepj" id="idspacepj" value="<?= $this->session->userdata('workspace_sesi') ?>" class="form-control" >
            <div class="form-group">
                 <select class="form-control" id="projectdoc" name="projectdoc">
                    <?php foreach ($projectspace as $pj) : ?>
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


      <!-- Modal -->
      <div class="modal fade" id="unggahModal" tabindex="-1" role="dialog" aria-labelledby="unggahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="unggahModalLabel">Unggah Menggunakan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  <a href="<?= base_url("document/documentinput/") . $this->uri->segment(4) ?>" class="btn btn-icon btn-primary btn-block" type="button">
                      <span class="btn-inner--icon"><i class="ni ni-tv-2"></i></span>
                      <span class="btn-inner--text">Ambil dari File Komputer</span>
                  </a>
                </div>
                <div class="col-lg-6">
                  <a href="<?= base_url("document/documentinputfromokr/") . $this->uri->segment(4) ?>" class="btn btn-icon btn-default btn-block" type="button">
                      <span class="btn-inner--icon"><i class="ni ni-chart-bar-32"></i></span>
                      <span class="btn-inner--text">Ambil dari File OKRE</span>
                  </a>
                </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>

 




        
    

 
              

                      