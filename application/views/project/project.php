<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">OKR</h6>
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
          <div class="col-lg-8">
            <h3 class="text-primary"> <button type="button" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
            </button> WORKSPACE <?= $space['name_space'] ?></h3>
           </div>
           <div class="col-lg-4">
            <div class="d-flex">
              <button type="button" class="btn rounded-pill btn-primary" data-toggle="modal" data-target="#editSpaceModal">
                <span class="btn-inner--icon"><i class="ni ni-archive-2"></i></span>
                <span> Edit </span>
              </button>
             
              <button type="button" data-toggle="modal" data-target="#timSpaceModel" class="btn btn-warning rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-circle-08"></i></span>
                  <span class="btn-inner--text">Edit Anggota</span>
              </button>    

              <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Kembali</span>
                </a>
              </div>
           </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editSpaceModal" tabindex="-1" role="dialog" aria-labelledby="editSpaceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSpaceModalLabel">Edit Space</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('workspace/editMySpace/') . $space['id_space'] ?>" method="POST" class="editworkspace-form" >
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label" for="input-email">Project Title</label>
              <input type="text" id="namespace" name="namespace" class="form-control" value="<?= $space['name_space'] ?>" required>
            </div>
          </div>
          <div class="col-lg-12">
          <div class="form-group">
              <label class="form-control-label" for="spacedesc">Deskripsi</label>
                <div id="spacedesc" class="quill-editor"><?= $space['desc_space'] ?></div>
              </div>
              <input type="hidden" id="descfrommodal" name="descfrommodal" class="form-control" value="<?= $space['desc_space'] ?>">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- BATAASSSS -->
<div class="container-fluid">
  <div class="row">   
    <div class="col-lg-12 mb-4">
  
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text-tabnav" role="tablist">
          
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-text-1-tab" data-toggle="tab" href="#tabs-text-1" role="tab" aria-controls="tabs-text-1" aria-selected="true">OKR</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-3-tab" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false">Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tab" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-2" aria-selected="false">Document</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-5-tabnav" href="<?= base_url("notes/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-5" aria-selected="false">Sketch</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-4-tab" href="<?= base_url("workspace/chatspace/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-4" aria-selected="true">Chat</a>
            </li>
           
          </ul>
        </div> 
      </div> 
    </div> 
<div class="container-fluid">
  <div class="row"> 
    <div class="col-xl-12"> 
      <div class="card bg-gradient-primary">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-lg-10">
                  <h3 class="card-title text-white">Lihat Calendar</h3>
              </div>
              <div class="col-auto">
                <a href="<?= base_url("calendar/index/" . $this->uri->segment(3)) ?>" type="button" class="btn btn-secondary mb-3 rounded-pill">
                  <span class="btn-inner--icon"><i class="ni ni-calendar-grid-58"></i></span>
                  <span class="btn-inner--text">Lihat Kalender</span>
                </a>
              </div>
            </div>
          </div>
      </div>
    </div> 
  </div> 
</div> 
<?php if($space['desc_space'] != '') { ?>
<div class="container-fluid">
  <div class="row"> 
    <div class="col-xl-12"> 
      <div class="card pt-2">
          <div class="row m-3">
            <div class="col-sm-2">
              <img src="<?= base_url() ?>assets/img/goals.png" style="width:150px;" class="img-fluid border-radius-lg">
            </div>

              <div class="card-body pt-2">
                  <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Deskripsi</span>
                    <span class="card-title h2 d-block text-darker">
                      <?= $space['desc_space'] ?>
                    </span>
              </div>
            </div>
           </div>
        </div>
    </div>
</div> 
<?php } ?>

<div class="container-fluid">
  <div class="row">   
    <div class="col-xl-12"> 
      <div class="card">
        <div class="card-header border-2 mb-4">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">OKR</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <?php $spaceidurl = $this->uri->segment(3) ?>
            </div>
          </div>
        </div>

     
          <div class="row px-4 mb-4">
       
          
          <div class="col-lg-3">
              <div class="card card-stats bg-gradient-blue" style="height: 100px;">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-white mb-0">Total OKR</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $all_project; ?></span>
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
                      <h5 class="card-title text-uppercase text-white mb-0">OKR Complete</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $complete_project; ?></span>
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
                      <h5 class="card-title text-uppercase text-white mb-0">Total individual OKR</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $complete_project; ?></span>
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
                      <h5 class="card-title text-uppercase text-white mb-0">Total Team OKR</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">+<?= $complete_project; ?></span>
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
        <div class="your-project mx-4">
          <div class="row align-items-center mb-4">
            <div class="col-lg-6">
              <h2 class="ml-3"> Your OKR</h2>
            </div>
            <div class="col-lg-6 d-flex justify-content-end ">
            <button type="button" class="btn btn-dark-primary mb-3 rounded-pill" data-toggle="modal" data-target="#tambahModal">
              <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
              <span class="btn-inner--tex t">Create New OKR</span>
            </button>
            <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Input Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                    <?= form_open_multipart('project/inputProject/' . $space['id_space']) ?>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">Project Title</label>
                            <input type="text" id="nama_project" name="nama_project" class="form-control" placeholder="Masukan Nama Project Disini" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">Project Priority</label>
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
            
                      </div>
          
                      <div class="row">
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label for="example-date-input" class="form-control-label">From</label>
                            <input class="form-control" type="date" value="<?= date("Y/m/d") ?>" id="tanggal_awal_project" name="tanggal_awal_project" required>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label for="example-date-input" class="form-control-label">To</label>
                            <input class="form-control" type="date" value="<?= date("Y/m/d") ?>" id="tanggal_akhir_project" name="tanggal_akhir_project" required>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label">Description</label>
                            <textarea rows="4" class="form-control" id="description_project" name="description_project" placeholder="Description Project..."></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">File</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="file" name="file" lang="en" accept=".pdf,.jpg">
                              <label class="custom-file-label" for="customFileLang">Select file</label>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1" required>Work Status</label>
                            <select class="form-control" id="work_status" name="work_status">
                              <option>Select Status</option>
                              <option value="1">Completed</option>
                              <option value="2">Pending</option>
                              <option value="3">On Progress</option>
                            </select>
                          </div>
                        </div> -->
                      </div>
                      <div class="row">
                        <div class="col-lg-3">
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
          </div>
          </div>
        </div>
        </div>
        <!-- <button id="toggleView" class="btn btn-primary">Ubah Tampilan</button> -->
        <div class="container-fluid">
      

        <div class="row align-items-center">
          <?php if(empty($projects)) { ?>
            <div class="col-lg-12 mb-5">
              <div class="alert alert-default" role="alert">
                  <strong>KOSONG!</strong> Belum ada data yang diinput
              </div>
            </div>
          <?php } else { ?>
          <?php foreach ($projects as $yp) : ?>
            <div class="col-lg-6">
                  <div class="card-project">
                      <div class="card card-stats">
                          <!-- Card body -->
                          <div class="card-body">
                              <div class="row ">
                                  <div class="col">
                                      <div>
                                        
                                              <?php if ($yp['priority_project'] == '3') { ?>
                                                  <span class="btnstyle"><i class="fa fa-flag" style="color: #db2424;"></i></span>
                                              <?php } else if ($yp['priority_project'] == '2') { ?>
                                                  <span class="btnstyle"><i class="fa fa-flag" style="color: #fbff00;"></i></span>
                                              <?php } else if ($yp['priority_project'] == '1') { ?>
                                                  <span class="btnstyle"><i class="fa fa-flag" style="color: #29dbff;"></i></span>
                                              <?php } else { ?>
                                                  <span class="btnstyle"><i class="fa fa-flag" style="color: #d1d1d1;"></i></span>
                                              <?php } ?>
                                          </h5>
                                      </div>
                                      <span class="h2 font-weight-bold mb-0"><?= $yp['nama_project']; ?></span>
                                  </div>
                                  <div class="col-auto">
                                      <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                                          <i class="ni ni-bullet-list-67"></i>
                                      </div>
                                  </div>
                              </div>
                              <p class="mt-3 mb-0 text-sm">
                                  <?php if ($yp['value_project'] >= 0 && $yp['value_project'] < 30) { ?>
                                      <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> <?= $yp['value_project'] ?>%</span>
                                  <?php } else if ($yp['value_project'] >= 30 && $yp['value_project'] < 65) { ?>
                                      <span class="text-warning mr-2"><i class="fa fa-arrow-up"></i> <?= $yp['value_project'] ?>%</span>
                                  <?php } else if ($yp['value_project'] >= 65) { ?>
                                      <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $yp['value_project'] ?>%</span>
                                  <?php } ?>
                                  <span class="no-wrap">Progress</span>
                                  <?php
                                  $id_tm = $yp['id_team'];
                                  $CI = &get_instance();
                                  $CI->load->model('Team_model');
                                  $iduser = $this->session->userdata('id');
                                  $acc_team = $CI->Team_model->getTeamProject($id_tm);
                                  $cekmyteam = $CI->Team_model->getMyTeamProject($id_tm,$iduser);
                                  ?>
                                  <div class="avatar-group">
                                      <?php foreach ($acc_team as $am) : ?>
                                          <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $am['nama']; ?>">
                                              <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $am['foto'] ?>">
                                          </a>
                                      <?php endforeach; ?>
                                  </div>
                              </p>
                              <div class="row">
                                  <div class="col-lg-3 mt-2">
                                      <a href="<?= base_url(); ?>project/detailProject/<?= $yp['id_project']; ?>" class="btn btn-info btn-sm font-btn rounded-pill"  onclick="saveCurrentUrl('<?= base_url(); ?>project/projectAtWorkspace/<?= $this->uri->segment(3) ?>');">
                                          <span class="btn--inner-icon">
                                              <i class="fas fa-eye"></i></span>
                                          <span class="btn-inner--text">Lihat</span>
                                      </a>
                                  </div>
                                  <div class="col-lg-4 mt-2">
                                      <a href="<?= base_url(); ?>project/showOkr/<?= $yp['id_project']; ?>" class="btn btn-default btn-sm rounded-pill font-btn" onclick="saveCurrentUrl('<?= base_url(); ?>project/projectAtWorkspace/<?= $this->uri->segment(3)  ?>');">
                                          <span class="btn--inner-icon">
                                              <i class="ni ni-chart-bar-32"></i></span>
                                          <span class="btn-inner--text">Masuk OKR</span>
                                      </a>
                                  </div>
                                  <div class="col-lg-4 mt-2">
                                      <button class="btn btn-warning btn-sm rounded-pill font-btn edit-anggota-btn-okr" data-toggle="modal" data-target="#timOKRModal" data-idtim="<?= $id_tm ?>" data-idpj="<?= $yp['id_project'] ?>" data-roleme="<?= $cekmyteam['role_user'] ?>" data-caneditokr="<?= $cekmyteam['can_edit_okr'] ?>" data-candeleteokr="<?= $cekmyteam['can_delete_okr'] ?>">
                                          <span class="btn--inner-icon">
                                              <i class="ni ni-circle-08"></i></span>
                                          <span class="btn-inner--text">Tim OKR</span>
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col mb-5 text-center">
          <a href="<?= base_url() ?>project/projectAll/<?= $spaceidurl ?>" class="btn btn-sm btn-default rounded-pill" onclick="saveCurrentUrl('<?= base_url(); ?>project/projectAtWorkspace/<?= $this->uri->segment(3)  ?>');">Lihat Semua</a>
        </div>
        </div>  
        <?php }  ?>
    </div>



  </div>
</div>

<?php $CI = &get_instance();
      $CI->load->model('Space_model');
      $idspace = $this->uri->segment(3);
      $id = $this->session->userdata('id');
      $myidspace = $CI->Space_model->cekSpaceTeamId($id,$idspace);

     $statususerokr = $myidspace['status_user'];
?>

<!-- Modal -->
<div class="modal fade" id="timSpaceModel" tabindex="-1" role="dialog" aria-labelledby="timSpaceModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timSpaceModelLabel">Role Tim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div>
      <ul class="list-group list-group-flush list my--3">
        <?php foreach($spaceteam as $spteam) { ?>
            <li class="list-group-item px-0">
              <div class="row align-items-center">
                <div class="col-lg-1">
                    <!-- Avatar -->
                      <a href="#" class="avatar rounded-circle">
                          <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $spteam['foto']; ?>">
                      </a>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="mb-0">
                            <span><?= $spteam['nama'] ?></span>
                        </h4>
                    </div>
                    <div class="col-lg-3">
                      <?php if($statususerokr == 'admin') { ?>
                        <select class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="<?= $spteam['id'] ?>" >
                          <option value="viewer" <?php if ($spteam['status_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                          <option value="editor" <?php if ($spteam['status_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                          <option value="admin" <?php if ($spteam['status_user'] == 'admin') { ?> selected="selected" <?php } ?>>admin</option>
                        </select>
                      <?php } else if($statususerokr == 'editor') {?>
                        <?php if($spteam['status_user'] == 'admin'){ ?>
                          <select disabled class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="<?= $spteam['id'] ?>" >
                          <option value="admin" <?php if ($spteam['status_user'] == 'admin') { ?> selected="selected" <?php } ?>>admin</option>
                        </select>
                        <?php } else { ?>
                        <select class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="<?= $spteam['id'] ?>" >
                          <option value="viewer" <?php if ($spteam['status_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                          <option value="editor" <?php if ($spteam['status_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                        </select>
                       <?php } ?>
  
                      <?php } else { ?> 
                        <select disabled class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="<?= $spteam['id'] ?>" >
                          <option value="viewer" <?php if ($spteam['status_user'] == 'viewer') { ?> selected="selected" <?php } ?>>viewer</option>
                          <option value="editor" <?php if ($spteam['status_user'] == 'editor') { ?> selected="selected" <?php } ?>>editor</option>
                          <option value="admin" <?php if ($spteam['status_user'] == 'admin') { ?> selected="selected" <?php } ?>>admin</option>
                        </select>
                      <?php } ?>
               
                    </div>
                    <?php if($statususerokr == 'admin') { ?>
                    <div class="col-lg-2">
                      <button type="button" class="btn btn-sm btn-danger hapususer" data-idspaceteam="<?= $spteam['id'] ?>">Hapus</button>
                    </div>
                    <?php } ?>
                </div>
              </li>
          <?php } ?>
          </ul>
        </div>
        <form id="senduserspace">
            <div class="row mt-2">      
              <div class="col-lg-9">
              <input class="form-control" type="hidden" value="<?= $this->uri->segment(3) ?>" id="idspaceanggota" name="idspaceanggota" required>
                <div class="form-group">
                  <label for="tambahuser" class="form-control-label">Tambah</label>
                    <select id="tambahuser" name="sendemail" class="form-control add-email">
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
                  <button class="btn btn-icon btn-primary mt-4" type="button" id="addinspace">
                    <span class="btn-inner--icon"><i class="fas fa-plus-square"></i></span>
                  </button>
              </div>
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="tambahstatususer" name="tambahstatususer">
                    <option value="viewer">viewer</option>
                    <option value="editor">editor</option>
                    <option value="admin">admin</option>
                </select>
              </div>  
              </div>  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary rounded-pill">Tambah Anggota</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="timOKRModal" tabindex="-1" role="dialog" aria-labelledby="timOKRModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timOKRModalLabel">Role Tim OKR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div>
      <ul class="list-group list-group-flush list my--3" id="space-team-list"></ul>
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