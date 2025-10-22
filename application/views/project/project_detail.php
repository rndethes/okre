<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Objective</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboards</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>project">Project</a></li>
              <li class="breadcrumb-item active" aria-current="page">Project Detail</li>
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
 
    <div class="col-xl-8">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h2 class="mb-2">Project Detail</h2>
              
            </div>
            <hr class="my-4" />
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <h1 class="card-title"><?= $project['nama_project']; ?></h1>
                  <?php $idteam = $project['id_team']; ?>
                  <?php foreach ($team as $key => $tm) : ?>
                    <?php if ($idteam == $tm['id_team']) { ?>
                      <h3 class="card-title"><?= $tm['nama_team']; ?></h3>
                    <?php } else { ?>
                    <?php } ?>
                  <?php endforeach; ?>
                  <p class="card-text">Our Team Member</p>
                  <?php
                  $id_tm = $project['id_team'];
                  $CI = &get_instance();
                  $CI->load->model('Team_model');

                  $acc_team = $CI->Team_model->getTeamProject($id_tm);
                  ?>
                  <div class="avatar-group">
                    <?php foreach ($acc_team as $am) : ?>
                      <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $am['nama']; ?>">
                        <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $am['foto'] ?>">
                      </a>
                    <?php endforeach; ?>
                  </div>
                </div>

              </div>
            </div>
          </div>
         
        </div>
        <div class="card-body">
          <h2 class="mb-0">Project Description</h2>
          <p><?= $project['description_project'] ?></p>
          <?php if ($project['file'] == NULL) { ?>
            <div class="alert alert-default" role="alert">
              <strong>Tidak Ada</strong> File yang Anda upload!
            </div>
          <?php } else { ?>
            <p> <iframe class="file-detail" src="<?= base_url('assets/file/') . $project['file']; ?>" frameborder="0"></iframe> </p>
          <?php } ?>
          <div class="row mt-3">
            <div class="col-lg-3">
              <button onclick="goBackToPreviousPage()" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Back</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
