<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
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
  <?php if(!empty($notifspace)) { ?>
    <div class="row">   
      <div class="col-xl-12"> 
        <div class="card">
            <div class="card-body">
              <h3 class="card-title text-dark">Invitation</h3>
              <div class="list-group list-group-flush">
              <?php foreach($datanotif as $index => $ntf) { ?>
              <a href="#!" class="list-group-item list-group-item-action" type="button" data-toggle="modal" data-target="#modal-notification-<?= $index ?>">      
                  <div class="row align-items-center">
                      <div class="col-auto">
                          <!-- Avatar -->
                          <img alt="Image placeholder" src="<?= base_url('/assets/img/profile/' . $ntf['foto']); ?>" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                          <div class="d-flex justify-content-between align-items-center">
                              <div>
                                  <h4 class="mb-0 text-sm">Undangan Bergabung Workspace dari <b class="text-primary"><?= $ntf['nama'] ?></b></h4>
                              </div>
                              <div class="text-right text-muted">
                                  <span><i class="fas fa-envelope"></i></span>
                              </div>
                          </div>
                          <p class="text-sm mb-0">Kamu diundang kedalam workspace <?= $ntf['name_space'] ?> klik dan pilih setujui/tidak</p>
                      </div>
                  </div>
              </a>

              <!-- Modal -->
              <div class="modal fade" id="modal-notification-<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="modal-notification-<?= $index ?>-label" aria-hidden="true">
                  <div class="modal-dialog modal-secondary modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-secondary">
                          <div class="modal-header">
                              <h6 class="modal-title" id="modal-title-notification-<?= $index ?>">Your attention is required</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <div class="modal-body">
                          <form method="post" action="<?= base_url() . '/workspace/appInvitation/' . $ntf['id_workspace'] ?>">
                              <div class="py-3 text-center">
                                  <i class="ni ni-bell-55 ni-3x"></i>
                                  <h4 class="heading mt-4">Invitation Workspace!</h4>
                                  <p>Terima Undangan Masuk Ke Workspace <?= $ntf['name_space'] ?> dari <?= $ntf['nama'] ?>?</p>
                                  <input type="hidden" name="workspace_id" value="<?= $ntf['id_workspace'] ?>">
                                  <input type="hidden" name="invitation_id" value="<?= $ntf['id_user'] ?>">
                                  <input type="hidden" name="response" id="response-<?= $index ?>" value="">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" name="action" value="accept" class="btn btn-success">Terima</button>
                              <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                          </div>
                          </form>
                      </div>
                  </div>
              </div>
          <?php } ?>
  

            <!-- </div> -->
          </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">   
      <div class="col-xl-12"> 
        <div class="card bg-gradient-default">
          <div class="card-body">
            <h3 class="card-title text-white">Create Space</h3>
            <blockquote class="blockquote text-white mb-0">
                <p>Buatlah Ruangan Untuk Project Anda dengan cara klik buat ruangan.</p>
                <button type="button" class="btn btn-secondary rounded-pill" data-toggle="modal" data-target="#exampleModal">
                  Tambah Space
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Buatlah Space</h5>
                        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="row mb-2">
                      <div class="col-6">
                        <div class="card pt-2">
                          <div class="row m-3">
                          <div class="col-sm-4">
                            <img src="<?= base_url() ?>assets/img/jabatanimg.png" style="width:150px;" class="img-fluid border-radius-lg">
                          </div>
                          <div class="card-body pt-2">
                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">yours</span>
                            <a href="<?= base_url() ?>project/neWorkspace/private" class="card-title h2 d-block text-darker">
                              Tambah Workspace Pribadi
                            </a>
                          </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="card pt-2">
                          <div class="row m-3">
                            <div class="col-sm-4">
                                  <img src="<?= base_url() ?>assets/img/teamf.png" style="width:150px;" class="img-fluid border-radius-lg">
                                </div>

                                <div class="card-body pt-2">
                                  <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">team</span>
                                  <a href="<?= base_url() ?>project/neWorkspace/team" class="card-title h2 d-block text-darker">
                                  Tambah Workspace Team
                                  </a>
                                </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </div>



<!-- BATAASSSS -->


<div class="container-fluid">
  <div class="row">   
    <div class="col-xl-12"> 
      <div class="card">
        <div class="card-header border-2 mb-4">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">OKR</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
            </div>
          </div>
        </div>

        <?php if($cekspace == 0) { ?>
        <?php } else { ?>
          <div class="row px-4 mb-4">
          
          <div class="col-lg-3">
              <div class="card card-stats bg-gradient-blue" style="height: 100px;">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Total Space</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $all_space; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="ni ni-folder-17"></i>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
              <div class="card card-stats bg-gradient-success" style="height: 100px;">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Team Space</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $team_space_total; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="ni ni-ui-04"></i>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
              <div class="card card-stats bg-gradient-blue" style="height: 100px;">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Private Space</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $private_space_total; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="ni ni-single-02"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <div class="col-lg-3">
              <div class="card card-stats bg-gradient-success" style="height: 100px;">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Total OKR</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $all_project; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                        <i class="ni ni-world-2"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
        <div class="col-xl-12"> 
       
        </div>
        
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
            <div class="card card-frame">
            <div class="card-header border-2">
                <div class="row align-items-center">
                    <div class="col">
                    <h2 class="mb-0" style="padding-left: 15px;">Work Space</h2>
                    </div>
                </div>
                </div>
                <div class="card-body">
                  
                <?php 
                $myid = $this->session->userdata("id");



                if(!empty($spaceteam)) { ?>
                <h3 class="mb-0" style="padding-left: 15px;"><a href="#!" class="avatar avatar-xs rounded-circle bg-primary"><i class="fas fa-users"></i></a>Team Space</h3>
                <hr>
                <div class="listTeamspace" id="listTeamspace">
                <ul class="list-group list-group-flush list my--3">
                    <?php foreach($spaceteam as $st) { 
                        
                         $CI = &get_instance();
                         $CI->load->model('Space_model');
                         $totalteammem = $CI->Space_model->countSpaceTeam($st['id_space']);
                         $is_favorite = $st['is_favorite'];
                         $canedit = $st['can_edit'];
                         $candelete = $st['can_delete'];
                        ?>
                    <li class="list-group-item px-0">       
                        <div class="row align-items-center">
                            <div class="col-auto">
                            </div>
                            <div class="col ml--2">
                            <h4 class="mb-0">
                         
                                <a href="#!" data-idspace="<?= $st['id_space'] ?>" class="favorite-workspace <?= $is_favorite ? 'text-warning' : '' ?>"><?= $st['name_space'] ?> <i class="fas fa-star <?= $is_favorite ? 'text-warning' : '' ?>"></i></a>
                          
                            </h4>
                                <span class="text-success">●</span>
                                <small><?= $totalteammem ?> Member Active</small>
                            </div>
                            <div class="col-auto">
                                <?php if($candelete == '1') { ?>
                                  <button data-deletespace="<?= base_url("workspace/deleteSpace/") . $st['id_space'] ?>" class="btn btn-sm btn-danger rounded-pill delete-space"><i class="fas fa-trash"></i></button>
                                <?php } ?>
                                <?php if($canedit == '1') { ?>
                                  <a href="<?= base_url("workspace/editWorkspace/") . $st['id_space'] ?>" class="btn btn-sm rounded-pill btn-warning">Edit</a>
                                <?php } ?>
                                  <button type="button" data-toggle="modal" data-target="#timviewSpaceModel" class="btn btn-sm rounded-pill btn-warning text-white edit-anggota-btn" data-canedit="<?= $canedit ?>" data-stateus="<?=  $st['status_user'] ?>" data-candelete="<?= $candelete ?>" data-idspace="<?= $st['id_space'] ?>">Edit Anggota</button>
                                  <a href="<?= base_url("project/projectAtWorkspace/") . $st['id_space'] ?>" class="btn btn-sm rounded-pill btn-info">Lihat Workspace</a>
                                  <button type="button" data-workspaceid="<?= $st['id_space'] ?>" class="btn btn-sm btn-primary rounded-pill view-workspace">View</button>
                      
                              
                            </div>
                        </div>
                    </li>    
                    <?php } ?>
                </ul>
                </div>
                <?php } ?>
                
                <?php if(!empty($spaceprivate)) { ?>
                <hr>
                <h3 class="mb-0" style="padding-left: 15px;"><a href="#!" class="avatar avatar-xs rounded-circle bg-success"><i class="fas fa-user"></i></a>Private Space</h3>
                <hr>
                <div class="listPrivatespace" id="listPrivatespace">
                <ul class="list-group list-group-flush list my--3">
                    <?php foreach($spaceprivate as $stp) { 
                      $is_favorite = $stp['is_favorite'];?>
                    <li class="list-group-item px-0">       
                        <div class="row align-items-center">
                            <div class="col-auto">
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-0">
                                <a href="#!" data-idspace="<?= $stp['id_space'] ?>" class="favorite-workspace <?= $is_favorite ? 'text-warning' : '' ?>"><?= $stp['name_space'] ?> <i class="fas fa-star <?= $is_favorite ? 'text-warning' : '' ?>"></i></a>
                                </h4>
                                <span class="text-success">●</span>
                                <small>Active</small>
                            </div>
                            <div class="col-auto">
                            <button data-deletespace="<?= base_url("workspace/deleteSpace/") . $stp['id_space'] ?>" class="btn btn-sm btn-danger delete-space"><i class="fas fa-trash"></i></button>
                                <a href="<?= base_url("workspace/editWorkspace/") . $stp['id_space'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= base_url("project/projectAtWorkspace/") . $stp['id_space'] ?>" class="btn btn-sm btn-info">See Workspace</a>
                                <button type="button" data-workspaceid="<?= $stp['id_space'] ?>" class="btn btn-sm btn-primary view-workspace">View</button>
                            </div>
                        </div>
                    </li>    
                    <?php } ?>
                </ul>
                </div>
                <?php } ?>
                </div>
             </div>
            </div>
            <div class="col-lg-5">
            <div class="card">
            <div class="card-header border-2">
                <div class="row align-items-center">
                    <div class="col">
                    <h2 class="mb-0" style="padding-left: 15px;">Project</h2>
                    </div>
                </div>
                </div>
                <div class="card-body">
                
                <div class="alert alert-primary" role="alert">
                <h3 id="workspaceName" class="mb-0 text-white" style="padding-left: 15px;">Nama Workspace</h3>
                </div>
                
                <hr>
                <ul id="workspaceDetails" class="list-group list-group-flush list my--3">
                         
                </ul>

                
             </div>
            </div>

            </div>
          </div>
          <!-- <div class="col mb-5 text-center">
          <a href="<?= base_url() ?>/project/projectAll" class="btn btn-sm btn-default rounded-pill">Lihat Semua</a>
        </div> -->
        </div>  
        <?php } ?>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="timviewSpaceModel" tabindex="-1" role="dialog" aria-labelledby="timviewSpaceModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timviewSpaceModelLabel">Role Tim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div>
      <ul class="list-group list-group-flush list my--3" id="space-team-list"></ul>
        </div>
        <form id="senduserspaceview">
            <div class="row mt-2">      
              <div class="col-lg-9">
              <input class="form-control" type="hidden" id="idspaceanggota" name="idspaceanggota">
                <div class="form-group">
                  <label for="tambahuserview" class="form-control-label">Tambah Anggota</label>
                    <select id="tambahuserview" name="sendemail" class="form-control add-email">
                      <option value="">- Pilih User -</option>
                        <?php foreach ($users as $us) : ?>
                            <?php if ($us['state'] == '2') { ?>
                              <option value="<?= $us['id']; ?>" data-profile="<?= $us['foto']; ?>"><?= $us['username']; ?> (<?= $us['nama'] ?>)</option>
                            <?php } ?>
                        <?php endforeach; ?>
                    </select>      
                </div>
                <div id="send-badges"></div>   
              </div>
              <div class="col-lg-1">
                  <button class="btn btn-icon btn-primary mt-4" type="button" id="addinspaceview">
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