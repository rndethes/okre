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
    <div class="col-xl-12"> 
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter</h5>
                <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="filtermyspaceall"> My Space</label>
                        <select class="form-control form-control-sm" id="filtermyspaceall" name="filtermyspaceall">
                            <option value="">Pilih Filter</option>
                            <?php foreach($sidespaceteam as $sidetm) { ?>
                            <option value="<?= $sidetm['id_space'] ?>"><?= $sidetm['name_space'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="filtermyspaceall"> OKR</label>
                        <select class="form-control form-control-sm" id="filtermyspaceall" name="filtermyspaceall">
                            <option value="">Pilih Filter</option>
                            <?php foreach($sidespaceteam as $sidetm) { ?>
                            <option value="<?= $sidetm['id_space'] ?>"><?= $sidetm['name_space'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="filtermyspaceall"> Objective</label>
                        <select class="form-control form-control-sm" id="filtermyspaceall" name="filtermyspaceall">
                            <option value="">Pilih Filter</option>
                            <?php foreach($sidespaceteam as $sidetm) { ?>
                            <option value="<?= $sidetm['id_space'] ?>"><?= $sidetm['name_space'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="filtermyspaceall"> Key Result</label>
                        <select class="form-control form-control-sm" id="filtermyspaceall" name="filtermyspaceall">
                            <option value="">Pilih Filter</option>
                            <?php foreach($sidespaceteam as $sidetm) { ?>
                            <option value="<?= $sidetm['id_space'] ?>"><?= $sidetm['name_space'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                    
                </div>
                
                <button id="filterButton" href="#" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
    
  </div>
      
    
     