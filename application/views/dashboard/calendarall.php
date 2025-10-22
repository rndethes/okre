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
              <li class="breadcrumb-item active" aria-current="page">Schedule</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
<?php
    $userside_id = $this->session->userdata('id');
    $CI = &get_instance();
    $CI->load->model('Space_model');

    $sidespaceteam      = $CI->Space_model->allspaceTeam($userside_id);
    $teamspace          = $CI->Space_model->dataMySpaceUserSide(0,$userside_id);

    $idWorkspaces = [];
    // Loop melalui setiap elemen dalam $sidespaceteam
    foreach ($sidespaceteam as $spaceTeam) {
            // Tambahkan nilai id_workspace ke array baru
        $idWorkspaces[] = $spaceTeam['id_workspace'];
    }

    $idwork = implode(',', $idWorkspaces);
?>

<div class="container-fluid mt--6">
  <div class="row">   
    <div class="col-xl-3"> 
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter</h5>
                <p class="card-text">Silahkan pilih filter berdasarkan user / space, pilihlah satu filter saja untuk melihat jadwal tim kamu di setiap space</p>
                <div class="form-group">
                    <label for="filteruserall">Cari User</label>
                    <select class="form-control form-control-sm" id="filteruserall" name="filteruserall">
                        <option value="">Pilih Filter</option>
                        <?php foreach($usersspace as $us) { ?>
                        <option value="<?= $us['id_user'] ?>"><?= $us['username'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filtermyspaceall">All My Space</label>
                    <select class="form-control form-control-sm" id="filtermyspaceall" name="filtermyspaceall">
                        <option value="">Pilih Filter</option>
                        <?php foreach($sidespaceteam as $sidetm) { ?>
                        <option value="<?= $sidetm['id_space'] ?>"><?= $sidetm['name_space'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" id="iduserincalendar" value="<?= $this->session->userdata("id") ?>">
                <input type="hidden" id="idspace">
                <input type="hidden" id="checkinspace" value="<?= $idwork ?>">
                <ul class="list-group mb-4" id="listall" style="display:none;">
                <li class="list-group-item">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="usercalendar" id="usercalendar-allview" value="all">
                        <label class="form-check-label" for="usercalendar_all">All</label>
                    </div>
                </li>
                </ul>
                <ul id="list-container" class="list-group mb-3">
                    <!-- Hasil perulangan list akan ditampilkan di sini -->
                </ul>
                <button id="filterButton" href="#" class="btn btn-primary rounded-pill">Filter</button>
                <button id="resetFilter" href="#" class="btn btn-warning rounded-pill">Reset</button>
            </div>
        </div>
    </div>
    <div class="col-xl-9"> 
    <div class="card">
        <div class="card-header border-2 mb-4">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">Calendar In Your Space</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <?php $spaceidurl = $this->uri->segment(3) ?>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-xl-12 align-items-center"> 
                <div class="card">
                    <div id='calendarall'></div>
                </div>
            </div>
        </div>
     </div> 
    </div>
  </div>
      
    
      <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalCalendar" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content bg-gradient-primary">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Jadwal Kamu</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-1 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4"></h4>
                        <h5 class="text-white"></h5>
                        <div id="description-container" class="text-white">
                            <p>[Description]</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <!-- <button type="button" id="viewnotif" class="btn btn-white">View</button> -->
                    <button type="button" id="editjadwal" class="btn btn-white" data-idpace="<?= $this->uri->segment(3) == '' ? 'all' : $this->uri->segment(3) ?>">Edit</button>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>