<div id="roomspace"></div>
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
            <input type="hidden" id="myworkspacesesi" class="form-control" value="<?= $this->session->userdata('workspace_sesi'); ?>">
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
          <div class="row align-items-center">
            <div class="col-8">
            <?php  
                if($statusproject == "Project Partner") {
                   $noteproject = '<span class="badge badge-lg badge-pill badge-default">Project Partner</span>';
                } else {
                  $noteproject = '';
                }

              ?>
              <h2 class="mb-2">Project Progress <?= $noteproject; ?></h2>
              
              
               
            </div>
            <div class="col-3">
              <div class="text-muted ">
                <span class="h5">
                  Project Created
                </span>
               
                <span class="badge badge-pill badge-primary"> <?= $project['created_by']; ?></span>

              </div>
            </div>
            <?php $idus = $this->session->userdata('id'); ?>

            <hr class="my-4" />
          </div>
          <?php $id_pjkr = $this->uri->segment(3); ?>
          <div class="card" style="width: 100%;">
          
            <div class="card-body">
              <input type="hidden" name="idworkspace" value="<?= $this->session->userdata('workspace_sesi') ?>">
              <div class="row">
                <div class="col-lg-6">
                  <h3 class="card-title"><?= $project['nama_project']; ?></h3>
                  <p class="card-text">Our Team</p>
                  <?php
                  $id_tm = $project['id_team'];
                  $CI = &get_instance();
                  $CI->load->model('Team_model');
                  
                  $checkmyakses = checkMyAksesOKR($id_tm);
                  $can_edit     = $checkmyakses["can_edit_okr"];
                  $can_delete   = $checkmyakses["can_delete_okr"];

                  $userteam = $CI->Team_model->getUserByTeam($id_tm);

                  $acc_team = $CI->Team_model->getTeamProject($id_tm);
                  ?>
                  <div class="avatar-group">
                    <?php foreach ($acc_team as $am) : ?>
                      <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $am['nama']; ?>">
                        <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $am['foto'] ?>">
                      </a>
                    <?php endforeach; ?>
                  </div>
                  <!-- <button type="button" > -->
                    <a href="<?= base_url('team/detailTeam/') . $project['id_team'] ?>" class="btn btn-sm btn-dark-primary btn-obj rounded-pill mt-3">
                      <span class="btn-inner--icon"><i class="ni ni-book-bookmark"></i></span>
                      <span class="btn-inner--text">Lihat Tim</span>
                    </a>
                  <!-- </button> -->
                </div>

                <div class="col-auto">
                  <button type="button" class="btn btn-dark-primary mb-4 btn-obj rounded-pill" data-toggle="modal" data-target="#tambahModal">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Tambah Objektif</span>
                  </button>
                  <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Input Objek</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                          <?= form_open_multipart('project/inputOkr'); ?>
                          <div class="pl-lg-4">
                            <div class="row">
                              <input type="hidden" id="id_project" name="id_project" class="form-control" value="<?= $project['id_project'] ?>">
                              <input type="hidden" id="id_team" name="id_team" class="form-control" value="<?= $project['id_team'] ?>">
                              <input type="hidden" id="id_okr" name="id_okr" class="form-control">
                              <input type="hidden" id="statusproject" name="statusproject" class="form-control" value="<?= $statusproject ?>">
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label class="form-control-label" for="input-username">Nama Objektif</label>
                                  <input type="text" id="description_okr" name="description_okr" class="form-control" placeholder="Masukan Objektif" required>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="form-group">
                                  <label class="form-control-label" for="exampleFormControlSelect1">Objective Priority</label>
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
                                  <input class="form-control" type="datetime-local" value="<?= date("Y/m/d") ?>" id="start_dateokr" name="start_dateokr" required>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label class="form-control-label" for="input-email">Tanggal Akhir</label>
                                  <input class="form-control" type="datetime-local" value="<?= date("Y/m/d") ?>" id="due_date" name="due_date" required>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                <button class="btn btn-icon btn-default" type="submit">
                                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
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
                <div class="col-auto">
                <button class="btn btn-warning rounded-pill font-btn edit-anggota-btn-okr" data-toggle="modal" data-target="#timOKRModal" data-idtim="<?= $id_tm ?>" data-idpj="<?= $project['id_project'] ?>" data-roleme="<?= $checkmyakses["role_user"] ?>" data-caneditokr="<?= $checkmyakses['can_edit_okr'] ?>" data-candeleteokr="<?= $checkmyakses['can_delete_okr'] ?>">
                                <span class="btn--inner-icon">
                                    <i class="ni ni-circle-08"></i></span>
                                <span class="btn-inner--text">Edit Anggota OKR</span>
                            </button>

                            <div class="modal fade" id="timOKRModal" tabindex="-1" role="dialog" aria-labelledby="timOKRModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="timOKRModalLabel">Role Tim</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                  <div>
                                  <ul class="list-group list-group-flush list my--3">
                                    <?php foreach($userteam as $us) { ?>
                                        <li class="list-group-item px-0">
                                          <div class="row align-items-center">
                                            <div class="col-lg-1">
                                                <!-- Avatar -->
                                                  <a href="#" class="avatar rounded-circle">
                                                      <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $us['foto']; ?>">
                                                  </a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4 class="mb-0">
                                                        <span><?= $us['nama'] ?></span>
                                                    </h4>
                                                </div>
                                                <div class="col-lg-3">
                                                  <?php if($checkmyakses['role_user'] == 'admin') { ?>
                                                    <select class="form-control form-control-sm" id="statususerinokr" name="statususerinokr" data-idteam="<?= $us['id_access_team'] ?>" >
                                                      <option value="viewer" <?php if ($us['role_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                                                      <option value="editor" <?php if ($us['role_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                                                      <option value="admin" <?php if ($us['role_user'] == 'admin') { ?> selected="selected" <?php } ?>>admin</option>
                                                    </select>
                                                  <?php } else if($checkmyakses['role_user'] == 'editor') {?>
                                                    <?php if($us['role_user'] == 'admin') { ?>
                                                      <input class="form-control form-control-sm" type="text" value="<?= $us['role_user'] ?>" disabled>
                                                    <?php } else { ?>
                                                    <select class="form-control form-control-sm" id="statususerinokr" name="statususerinokr" data-idteam="<?= $us['id_access_team'] ?>" >
                                                      <option value="viewer" <?php if ($us['role_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                                                      <option value="editor" <?php if ($us['role_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                                                    </select>
                                                  <?php } ?>
                              
                                                  <?php } else { ?> 
                                                    <select disabled class="form-control form-control-sm" id="statususerinokr" name="statususerinokr" data-idteam="<?= $us['id_access_team'] ?>" >
                                                      <option value="viewer" <?php if ($us['role_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                                                      <option value="editor" <?php if ($us['role_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                                                      <option value="admin" <?php if ($us['role_user'] == 'admin') { ?> selected="selected" <?php } ?>>admin</option>
                                                    </select>
                                                  <?php } ?>
                                          
                                                </div>
                                                <?php if($checkmyakses['role_user'] == 'admin') { ?>
                                                <div class="col-lg-2">
                                                  <button type="button" class="btn btn-sm btn-danger hapususerokr" data-idspaceteam="<?= $us['id_access_team'] ?>">Hapus</button>
                                                </div>
                                                <?php } ?>
                                            </div>
                                          </li>
                                      <?php } ?>
                                      </ul>
                                    </div>
                                    <form id="senduserokr">
                                      <div class="row mt-2">      
                                        <div class="col-lg-9">
                                        <input class="form-control" type="hidden" id="idaccessteam" name="idaccessteam" required>
                                          <div class="form-group">
                                            <label for="tambahuserokr" class="form-control-label">Tambah</label>
                                              <select id="tambahuserokr" name="sendemail" class="form-control add-email">
                                                <option value="">- Pilih User -</option>
                                                  <?php foreach ($users as $us) : ?>
                                                      <?php if ($us['state'] == '2') { ?>
                                                        <option value="<?= $us['id']; ?>" data-profile="<?= $us['foto']; ?>"><?= $us['username']; ?> (<?= $us['nama'] ?>)</option>
                                                      <?php } ?>
                                                  <?php endforeach; ?>
                                              </select>      
                                          </div>
                                          <div id="send-badges-okr"></div>   
                                        </div>
                                        <div class="col-lg-1">
                                            <button class="btn btn-icon btn-primary mt-4" type="button" id="addinokr">
                                              <span class="btn-inner--icon"><i class="fas fa-plus-square"></i></span>
                                            </button>
                                        </div>
                                        <div class="col-lg-6">
                                          <select class="form-control form-control-sm" id="tambahstatususer" name="tambahstatususer">
                                              <option value="viewer">viewer</option>
                                              <option value="editor">editor</option>
                                              <option value="admin">admin</option>
                                          </select>
                                        </div>
                                        </div>  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-success rounded-pill" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary rounded-pill">Tambah Anggota</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>
                            </div>
                </div>
              
                <?php if(empty($teamobj)) { ?>
                <div class="col-auto">
                  <a href="<?= base_url('team/inputTeamBalqi/') . $id_pjkr ?>" type="button" class="btn btn-info rounded-pill">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Buat Team di Objective</span>
                  </a>
                </div>
                <?php } ?>
              
                <div class="col-lg-12">
                  <div class="progress-wrapper">
                    <div class="progress-default">
                      <div class="progress-label">
                        <span>Progress Task</span>
                      </div>
                      <div class="progress-percentage">
                        <h2><?= $project['value_project']; ?>%</h2>
                      </div>
                    </div>
                    <div class="progress" style="height: 20px;">
                      <?php if ($project['value_project'] >= 0 && $project['value_project'] < 30) { ?>
                        <div class=" progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?= $project['value_project']; ?>%"></div>
                      <?php } else if ($project['value_project'] >= 30 && $project['value_project'] < 65) { ?>
                        <div class=" progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?= $project['value_project']; ?>%"></div>
                      <?php } else if ($project['value_project'] >= 65 && $project['value_project'] <= 100) { ?>
                        <div class=" progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?= $project['value_project']; ?>%"></div>
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if($project['description_project'] != '') { ?>
            <div class="card-body">
            <div class="card pt-2">
              <div class="row m-3">
                <div class="col-sm-2">
                  <img src="<?= base_url() ?>assets/img/goals.png" style="width:150px;" class="img-fluid border-radius-lg">
                </div>

                  <div class="card-body pt-2">
                      <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Deskripsi</span>
                        <span class="card-title h2 d-block text-darker">
                        <?= $project['description_project'] ?>
                        </span>
                  </div>
              </div>
           </div>
           <?php } ?>
          <?php if ($project['file'] == NULL) { ?>
            <div class="alert alert-default" role="alert">
              <strong>Tidak Ada</strong> File yang Anda upload!
            </div>
          <?php } else { ?>
            <div id="pdf-responsive" class="custompdf1">
                <div class="custompdf2">
                  <object data="<?= base_url('assets/file/') . $project['file']; ?>" type="application/pdf" width="100%" height="100%">
                    <p><a href="<?= base_url('assets/file/') . $project['file']; ?>" download>click here to
                    download the PDF file.</a></p>
                  </object>
                </div> 
            </div>              
          <?php } ?>
        </div>
          </div>
          
        </div>
        
        <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h2 class="mb-2">Objective</h2>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">

            <div>
              <table class="table align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No</th>
                    <th scope="col" class="sort" data-sort="name">Objective</th>
                    <th scope="col" class="sort" data-sort="budget">Team</th>
                    <th scope="col" class="sort" data-sort="status">Tanggal Akhir</th>
                    <th scope="col" class="sort" data-sort="status">Persentase</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
              <?php if(empty($teamobj)) { ?>
                <tr>
                    <td colspan="18">
                      <div class="alert alert-default" role="alert">
                        <strong>Catatan !!</strong> Harap buat team terlebih dahulu
                      </div>
                    </td>
                  </tr>
                <?php } else { ?>
                <?php if (empty($object)) : ?>
                  <tr>
                    <td colspan="18">
                      <div class="alert alert-default" role="alert">
                        <strong>Belum ada</strong> Objective yang di input
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
                <?php
                $no = 1;
                foreach ($object as $oj) :
                ?>
                  <tbody class="list">
                    <tr>

                      <th><?= $no++; ?></th>
                      <th scope="row">
                        <div class="media align-items-center">
                          <div class="media-body">
                            <span class="name mb-0 text-sm"><?= $oj['description_okr']; ?></span>
                          </div>
                        </div>
                      </th>
                      <td>
                        <div class="avatar-group">
                          <?php
                          $id_okr = $oj['id_okr'];
                          $CI = &get_instance();
                          $CI->load->model('Team_model');

                          $checkAccess = checkMyAksesKey($id_okr);

                          $acc_team = $CI->Team_model->getTeamObj($id_okr);
                          ?>
                          <?php foreach ($acc_team as $am) : ?>
                            <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $am['nama']; ?>">
                              <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $am['foto'] ?>">
                            </a>
                          <?php endforeach; ?>
                        </div>
                      </td>
                      <td>
                        <?= date('j F Y', strtotime($oj['due_date'])); ?>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <span class="completion mr-2"><?= $oj['value_okr']; ?>%</span>
                          <div>
                            <div class="progress">
                              <?php if ($oj['value_okr'] >= 0 && $oj['value_okr'] < 30) { ?>
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?= $oj['value_okr']; ?>%;"></div>
                              <?php } else if ($oj['value_okr'] >= 30 && $oj['value_okr'] < 65) { ?>
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?= $oj['value_okr']; ?>%;"></div>
                              <?php } else if ($oj['value_okr'] >= 65 && $oj['value_okr'] <= 100) { ?>
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?= $oj['value_okr']; ?>%;"></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm rounded-pill edit-anggota-obj" data-toggle="modal" data-target="#timObjModal" data-idokr="<?= $oj['id_okr'];  ?>" data-idpj="<?= $oj['id_project'] ?>" data-roleme="<?= $checkAccess['role_user'] ?>" data-caneditokr="<?= $checkmyakses['can_edit_okr'] ?>" data-candeleteokr="<?= $checkmyakses['can_delete_okr'] ?>">
                          <span class="btn--inner-icon">
                          <i class="fa fa-user"></i></span>
                          <span class="btn-inner--text">Anggota Tim Objective</span>
                        </button>
                      </td>                
                      <!-- <td>
                        <button type="button" class="btn btn-darker btn-sm rounded-pill" data-toggle="modal" data-target="#modalDelegate<?= $oj['id_okr']; ?>">
                          <span class="btn--inner-icon">
                          <i class="fa fa-user"></i></span>
                          <span class="btn-inner--text">Delegate</span>
                        </button>
                      </td>
                      <div class="modal fade" id="modalDelegate<?= $oj['id_okr']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <?= form_open_multipart('project/delegateOkr/'. $oj['id_okr']); ?>
                              <div class="pl-lg-2">
                                  <div class="col-lg-12 mt-3">
                                      <div class="form-group">
                                        <select class="js-example-basic-multiple" name="id_user[]" multiple="multiple" data-live-search="true">
                                          <?php foreach ($users as $us) : ?>
                                            <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                          <?php endforeach; ?>
                                        </select>             
                                      </div>
                                  </div>    
                                </div>
                                  <?php 
                                  $CI = &get_instance();
                                  $CI->load->model('Project_model');

                                  $usr = $CI->Project_model->getUserDelegateOkr($oj['id_okr']);
                                  
                                  $patner = $CI->Project_model->cekUser($oj['id_okr']);

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
                                  <span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
                                  <span class="btn-inner--text">Delegasikan</span>
                                </button>
                                <button class="btn btn-icon btn-warning" type="submit" name="action" value="tambahpatner">
                                  <span class="btn-inner--icon"><i class="fas fa-users"></i></span>
                                  <span class="btn-inner--text">Tambah Sebagai Patner</span>
                                </button>
                              </div>
                              <?= form_close(); ?>
                            </div>
                          </div>
                        </div> -->
                      <td>
                        <a href="<?= base_url(); ?>project/showKey/<?= $oj['id_project'] ?>/<?= $oj['id_okr']; ?>" class="btn btn-default btn-sm rounded-pill">
                          <span class="btn--inner-icon">
                            <i class="fas fa-key"></i></span>
                          <span class="btn-inner--text">Key Result</span>
                        </a>
                        <!-- <a type="button" href="" class="btn btn-default btn-sm rounded-pill" data-toggle="modal" data-target="#okrModal">
                          <span class="btn--inner-icon">
                            <i class="fas fa-key"></i></span>
                          <span class="btn-inner--text">Input</span>
                        </a> -->
                      </td>
                

                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <?php if($can_edit == 1) { ?>
                            <a class="dropdown-item" href="<?= base_url(); ?>project/editOkr/<?= $oj['id_okr']; ?>">Edit</a>
                            <?php } ?>
                            <?php if($can_delete == 1) { ?>
                            <a class="dropdown-item tombol-hapus" href="" data-target="<?= base_url(); ?>project/deleteOkr/<?= $oj['id_project'] ?>/<?= $oj['id_okr']; ?>">Delete</a>
                            <?php } ?>
                          </div>
                        </div>
                      </td>
                     
                    </tr>
                  </tbody>

                  <!-- Modal -->
                  <!-- <div class="modal fade" id="okrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Key Result</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="show-okr">
                            <ul class="list-group">


                              <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                  <h3 class="mb-1 title-key">Cek</h3>
                                  <h3 class="mt-0 mb-0 percent-key">
                                    <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> 20%</span>
                                  </h3>
                                </div>
                                <div class="d-flex w-100 justify-content-between deadline-key">
                                  <h5 class="due-key">Due Date : </h5>
                                </div>
                                <h5 class="mb-1">Value <span class="badge badge-default">cek</span></h5>

                                <h5 class="text-muted">Input Progress</h5>
                                <?= form_open_multipart('project/inputValue'); ?>
                               
                                <div class="row">


                                  <div class="col-lg-1 mb-1">
                                    <input class="form-control form-control-sm form-nm" type="number" id="example-number-input" name="value_achievment">
                                  </div>
                                  <div class="col-lg-6 mb-1">
                                    <input class="form-control form-control-sm" type="text" id="example-number-input" name="description_kr" placeholder="Isikan Catatan Progress...">
                                  </div>
                                  <div class="col-lg-1">
                                    <button class="btn btn-sm btn-icon btn-outline-default" type="submit">
                                      <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                    </button>
                                  </div>
                                </div>


                                <h4 class="text-muted mt-1">Note : Belum Ada Catatan</h4>

                               
                              </li>

                            </ul>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div> -->
                <?php endforeach; ?>
                <?php } ?>
              </table>
              
            </div>
            
          </div>
         
          <div class="row mt-3">
            <div class="col-lg-3">
              <button onclick="goBackToPreviousPage()" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
       
      </div>
    </div>
    
  </div>
  <div class="modal fade" id="modalExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <?= form_open('project/exportExcelProject/' . $project['id_project']); ?>
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
                                  Project
                                </div>
                                <div class="ml-4">
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`project`.`id_project`">
                                    ID Project
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`nama_project`">
                                    Nama Project
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`departement`.`nama_departement`">
                                    Nama Department
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`team`.`nama_team`">
                                    Nama Team
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`description_project`">
                                    Deskripsi
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`value_project`">
                                    Progress
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`tanggal_awal_project`">
                                    Start Date
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataprj[]" value="`tanggal_akhir_project`">
                                    Due Date
                                  </label>
                                  </div>
                                </div>
                              </div>
                            </div>                            
                            <div class="col-6">
                              <div class="card">
                              <div class="card-header">
                                  Objective
                                </div>
                                <div class="ml-4">
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`id_okr`">
                                    ID Objective
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`description_okr`">
                                    Deskripsi Objective
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`project`.`nama_project`">
                                    Nama Project
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`team`.`nama_team`">
                                    Nama Tim
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`value_okr`">
                                    Persentase Progress
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`total_kr`">
                                    Jumlah Key Result
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`start_dateokr`">
                                    Start Date
                                  </label>
                                  </div>
                                  <div class="row">
                                  <label>
                                    <input type="checkbox" name="dataokr[]" value="`due_date`">
                                    Due Date
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

               <!-- Modal -->
                <div class="modal fade" id="timObjModal" tabindex="-1" role="dialog" aria-labelledby="timObjModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="timObjModalLabel">Role Tim Objective</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div>
                      <ul class="list-group list-group-flush list my--3" id="space-team-list"></ul>
                        </div>
                      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success rounded-pill" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                  </div>
                </div>
                </div>


             

              

                      