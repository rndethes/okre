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
  <div class="row">
  <div class="col-xl-1 minimized-chat" id="chat-column">
      <div class="card card-frame">
        <div class="card-header">
        <div class="row align-items-center">
          <div class="col">
          <h3 class="mb-0">Chat Room</h3>
          </div>
          <div class="col">
          <ul class="nav nav-pills justify-content-end">
          <li class="nav-item mr-2 mr-md-0">
            <button id="hidechat" type="button" class="btn btn-lg rounded-pill btn-danger">
              <i class="ni ni-bold-left"> </i>
            </button>
          </li>
          
          </ul>
          </div>
          </div>
          
            <input type="hidden" id="myuserid" class="form-control" value="<?= $this->session->userdata('id'); ?>">
            <input type="hidden" id="myprojectid" class="form-control" value="<?= $this->uri->segment(3); ?>">
            <input type="hidden" id="hidden-link" class="form-control hidden-link">
          
        </div>
        <?php if(!empty($chat)) { ?>
          <input type="hidden" id="idroomchat" class="form-control" value="<?= $chat['id_mcr']; ?>">
        <div class="card-body">
         
            <div id="chat-window" class="overflow-auto" style="height: 400px;">
              <!-- Chat Messages -->
              <div class="d-flex justify-content-end mb-2">
                                
            </div>
          </div>
        <div class="card-footer">
            <div id="mention-dropdown" class="list-group" style="display: none;">
               <!-- Daftar mention akan diisi melalui JavaScript -->
            </div>
                        <div class="input-group mb-2">
                       
                          <!-- <input type="text" id="message" class="form-control" placeholder="Type your message..." required> -->

                          <textarea class="form-control" id="message" rows="3"></textarea>

                        </div>
                        <button type="button" id="send-btn" data-userid="<?= $this->session->userdata('id'); ?>" class="btn btn-default">Send</button>
                   
          </div>
        </div>
        <?php } else { ?>
          <div class="card-body">
            <a href="<?= base_url("workspace/tambahChat/") .  $this->session->userdata('workspace_sesi') . "/" . $this->uri->segment(3) . "/" . $project['nama_project'] ?>"  class="btn btn-icon btn-primary">
              <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                <span class="btn-inner--text">Tambah Chat</span>
            </a>
          </div>

        <?php } ?>
    </div>
    </div>
    <div class="col-xl-12" id="main-column">
      <div class="card">
        <div class="card-header">
        <div class="card bg-gradient-default">
          <div class="card-body">
            <h3 class="card-title text-white">Upload Document</h3>
            <blockquote class="blockquote text-white mb-0">
                <p>Upload Document Disini.</p>
                <a href="<?= base_url("document/documentinput/") . $this->uri->segment(3) ?>" type="button" class="btn btn-secondary rounded-pill">
                  Upload Document
                </a>                
            </blockquote>
          </div>
        </div>
        </div>
      
        <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">Document</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <div class="table-responsive">
                <div>
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Nama Document</th>
                                <th scope="col" class="sort" data-sort="budget">Type Document</th>
                                <th scope="col" class="sort" data-sort="status">Space | Project</th>
                                <th scope="col">Pemilik</th>
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


                          $ceksignature   = $CI->Space_model->checkSignatureById($idodc);
                          $allsign        = $CI->Space_model->checkAllSignatureFile($idodc);
                          $iduserscek     = $this->session->userdata('id');
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
                                      <span class="status"><?= $my['name_space'] . ' | ' . $my['nama_project'] ?></span>
                                    </span>
                                </td>
                                <td>
                                  <?php 
                                  $usersdoc     = $CI->Account_model->getAccountById($my['id_user_create']);
                                  ?>
                                  <?= $usersdoc['nama'] ?>
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
                                      <a href="<?= base_url("document/editdocument/") . $this->uri->segment(3) . "/" . $my['id_document'] ?>" class="btn btn-warning btn-sm rounded-pill">
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
                                      <a href="<?= base_url("document/revisidocument/") . $this->uri->segment(3) . "/" . $my['id_document'] ?>" class="btn btn-warning btn-sm rounded-pill">
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
                                      <a href="<?= base_url("document/showAfterReject/") . $my['id_document'] ?>" class="btn btn-info btn-sm rounded-pill">
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
          </div>
        </div>
      </div>
    </div>
    
  </div>
 
              

                      