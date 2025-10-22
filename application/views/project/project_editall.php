<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
              <li class="breadcrumb-item active" aria-current="page">Default</li>
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
              <h3 class="mb-0">Edit Project</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
        <?php $role_id = $this->session->userdata('role_id') ?> 
          <?= form_open_multipart('project/editProjectAll/' . $project['id_project']); ?>
          <?php 
             $CI = &get_instance();
             $CI->load->model('Space_model');
             $spaceokr = $CI->Space_model->checkSpaceOkrById($project['id_project']);

             $idspaceokr = $spaceokr['id_space'];
             $namespaceokr = $spaceokr['name_space'];
          ?>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Project ID</label>
                  <input type="text" id="id_project" name="id_project" class="form-control" value="<?= $project['id_project']; ?>" readonly>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">SPACE</label>
                  <input type="hidden" id="id_space" name="id_space" class="form-control" value="<?= $idspaceokr; ?>">
                  <input type="text" id="nama_space" name="nama_space" class="form-control" value="<?= $namespaceokr; ?>" readonly>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Project Title</label>
                  <input type="text" id="nama_project" name="nama_project" class="form-control" value="<?= $project['nama_project']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="exampleFormControlSelect1">Project Priority</label>
                  <div class="style-toggle row">
                    <input type="radio" id="high" name="priority_project" value="3" class="btn btn-default d-none form-control">
                    <label for="high"><i class="fa fa-flag" style="color: #db2424;"></i></label>

                    <input type="radio" id="medium" name="priority_project" value="2" class="btn btn-default d-none form-control">
                    <label for="medium"><i class="fa fa-flag" style="color: #ffea00;"></i></label>

                    <input type="radio" id="low" name="priority_project" value="1" class="btn btn-default d-none form-control">
                    <label for="low"><i class="fa fa-flag" style="color: #29dbff;"></i></label>

                    <input type="radio" id="lowest" name="priority_project" value="0" class="btn btn-default d-none form-control">
                    <label for="lowest"><i class="fa fa-flag" style="color: #d1d1d1;"></i></label>
                  </div>
                  <!-- <button type="button" class="btn btn-dark-primary mb-4 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Pilih Tugas</span>
                  </button> -->
                  <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Pilih Tugas</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                  <div class="col-4">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3>Objective</h3>
                                      </div>
                                      <div class="card-body">
                                      <?php if (empty($id_okr)) { ?>
                                        <h4>Data tidak ditemukan!</h4>
                                      <?php } else { ?>
                                        <?php foreach($id_okr as $okr) {?>
                                        <div class="my-3">
                                        <label>
                                            <input type="checkbox" name="kuadran[]" value="<?= $okr['id_kuad']; ?>">
                                            <?= $okr['description_okr']; ?>
                                        </label>
                                        </div>
                                      <?php } ?>                                      
                                    <?php } ?>
                                    </div>
                                    </div>
                                  </div>
                                  <div class="col-4">
                                  <div class="card">
                                      <div class="card-header">
                                        <h3>Key Result</h3>
                                      </div>
                                      <div class="card-body">
                                      <?php if (empty($id_kr)) { ?>
                                        <h4>Data tidak ditemukan!</h4>
                                      <?php } else { ?>
                                    <?php foreach($id_kr as $kr) {?>
                                      <div class="my-3">
                                      <label>
                                          <input type="checkbox" name="kuadran[]" value="<?= $kr['id_kuad']; ?>">
                                          <?= $kr['nama_kr']; ?>
                                      </label>
                                      </div>
                                    <?php } ?>
                                    <?php } ?>
                                    </div>
                                    </div>
                                  </div>
                                  <div class="col-4">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3>Initiative</h3>
                                      </div>
                                      <div class="card-body">
                                      <?php if (empty($id_initiative)) { ?>
                                        <h4>Data tidak ditemukan!</h4>
                                      <?php } else { ?>
                                  <?php foreach($id_initiative as $init) {?>
                                    <div class="my-3">
                                      <label>
                                          <input type="checkbox" name="kuadran[]" value="<?= $init['id_kuad']; ?>">
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
              </div>
            </div>
            <div class="row">
              <!-- <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="exampleFormControlSelect1">Team</label>
                  <?php $iddept = $project['id_team']; //ambil dari data yg diedit 
                  ?>
                  <select class="form-control" id="id_team" name="id_team">
                    <?php foreach ($team as $key => $team) : ?>
                      <?php if ($iddept == $team["id_team"]) { ?>
                        <option value="<?php echo $team["id_team"] ?>" selected>
                          <?php echo $team["nama_team"] ?>
                        </option>
                      <?php } else { ?>
                        <option value="<?php echo $team["id_team"] ?>">
                          <?php echo $team["nama_team"]  ?>
                        </option>
                      <?php } ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div> -->
              <?php if($role_id == 1) { ?>
              <div class="col-lg-3">
                <div class="form-group">
                  <label for="example-date-input" class="form-control-label">From</label>
                  <input class="form-control" type="date" value="<?php echo date('Y-m-d', strtotime($project["tanggal_awal_project"])) ?>" id="tanggal_awal_project" name="tanggal_awal_project">
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label for="example-date-input" class="form-control-label">To</label>
                  <input class="form-control" type="date" value="<?php echo date('Y-m-d', strtotime($project["tanggal_akhir_project"])) ?>" id="tanggal_akhir_project" name="tanggal_akhir_project">
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Description</label>
                  <textarea rows="4" class="form-control" id="description_project" name="description_project"><?= $project['description_project'] ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="alert alert-default" role="alert">
                  <strong>Nama File : </strong><?= $project['file']; ?>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file" lang="en">
                    <label class="custom-file-label" for="customFileLang">Select file</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="exampleFormControlSelect1">Work Status</label>
                  <select class="form-control" id="work_status" name="work_status">
                    <option value="1" <?php if ($project['work_status'] == '1') { ?> selected="selected" <?php } ?>>Complete</option>
                    <option value="2" <?php if ($project['work_status'] == '2') { ?> selected="selected" <?php } ?>>Pending</option>
                    <option value="3" <?php if ($project['work_status'] == '3') { ?> selected="selected" <?php } ?>>On Progress</option>
                  </select>
                </div>
              </div> -->
            </div>
            <div class="row mt-4">
              <div class="col-lg-2">
                <button class="btn btn-icon btn-default rounded-pill" id="projectSubmit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Edit</span>
                </button>
              </div>
              <?= form_close(); ?>
              <div class="col-lg-3">
                <button type="button" onclick="goBackToPreviousPage()" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Kembali</span>
                </button>
              </div>
            </div>
          </div>

         
        </div>
      </div>
    </div>
  </div>