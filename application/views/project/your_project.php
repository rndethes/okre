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
      <div class="row mb-2">
      <div class="col-6">
        <div class="card pt-2">
          <div class="row m-3">
      <div class="col-sm-4">
            <img src="<?= base_url() ?>assets/img/jabatanimg.png" style="width:150px;" class="img-fluid border-radius-lg">
          </div>

          <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">yours</span>
            <a href="<?= base_url() ?>project/your_project" class="card-title h2 d-block text-darker">
              Individual OKR
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
            <a href="<?= base_url() ?>project" class="card-title h2 d-block text-darker">
               Team OKR
            </a>
          </div>
          </div>
        </div>
      </div>

    </div>
    </div>
  </div>
</div>

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
              <span class="btn-inner--text">Create New OKR</span>
            </button>
            <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input OKR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                    <?= form_open_multipart('project/inputProject'); ?>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">OKR Title</label>
                            <input type="text" id="nama_project" name="nama_project" class="form-control" placeholder="Softwere Development" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="id_departement">Departement</label>
                            <select class="form-control" id="id_departement" name="id_departement" required>
                              <option value="">Pilih Departemen</option>
                              <?php foreach ($departement as $dp) : ?>
                                <option value="<?= $dp['id_departement']; ?>"><?= $dp['nama_departement']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">OKR Priority</label>
                            <select class="form-control" id="priority_project" name="priority_project" required>
                              <option>Select Priority</option>
                              <option value="1">Low</option>
                              <option value="2">Medium</option>
                              <option value="3">High</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">Team</label>
                            <select class="form-control" id="id_team" name="id_team" required>
                              <option>Select Team</option>
                              <?php foreach ($team as $tm) : ?>
                                <option value="<?= $tm['id_team']; ?>"><?= $tm['nama_team']; ?></option>
                              <?php endforeach; ?>
                            </select>
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
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1" required>Work Status</label>
                            <select class="form-control" id="work_status" name="work_status">
                              <option>Select Status</option>
                              <option value="1">Completed</option>
                              <option value="2">Pending</option>
                              <option value="3">On Progress</option>
                            </select>
                          </div>
                        </div>
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

        <div class="container-fluid">
        <div class="row align-items-center">
          <?php foreach ($your_project as $yp) : ?>
            <div class="col-lg-6 mb-4">
              <div class="card-project">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                      <div class="row ">
                        <div class="col">
                          <div>
                            <h5 class="card-title text-uppercase text-muted mb-0"><?= $yp['nama_departement'] ?>
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
                        <?php } else if ($yp['value_project'] >= 65 ) { ?>
                          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= $yp['value_project'] ?>%</span>
                        <?php } ?>
                        <span class="no-wrap">Progress</span>
                        <?php
                        $id_tm = $yp['id_team'];
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
                      </p>
                      <div class="row">
                        <div class="col-lg-3">
                          <a href="<?= base_url(); ?>project/detailProject/<?= $yp['id_project']; ?>" class="btn btn-info btn-sm font-btn rounded-pill">
                            <span class="btn--inner-icon">
                              <i class="fas fa-eye"></i></span>
                            <span class="btn-inner--text">Detail</span>
                          </a>
                        </div>
                        <div class="col-lg-4">
                          <a href="<?= base_url(); ?>project/showOkr/<?= $yp['id_project']; ?>" class="btn btn-default btn-sm rounded-pill font-btn">
                            <span class="btn--inner-icon">
                              <i class="ni ni-chart-bar-32"></i></span>
                            <span class="btn-inner--text">Input Progress</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col mb-5 text-center">
          <a href="<?= base_url() ?>/project/projectAll" class="btn btn-sm btn-default rounded-pill">Lihat Semua</a>
        </div>
      </div>
    </div>
  </div>
</div>
