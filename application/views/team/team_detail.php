<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashTm'); ?>"></div>
    <?php if ($this->session->flashdata('flashTm')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Team</h6>
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

<!-- team -->
    <div class="container-fluid mt--6">
      <div class="row">
          <div class="col-lg-12">
              <div class="row" style="padding: 20px;">
                <div class="col-lg-8">
                  <div class="card mb-3 bg-gradient-info">
                    <div class="row no-gutters">
                      <div class="col-md-4">
                        <img src="<?= base_url('assets/'); ?>img/team-spirit.svg" class="card-img dashboard" alt="...">
                      </div>
                      <div class="col-md-7" style="height: 225px">
                        <div class="card-body">
                          <h3 class="card-title text-white">Add member</h3>
                          <p class="card-text text-white">Add your team and member to help you and supporting you in project management OKR</p>
                          <?php
                          $id_tm = $this->uri->segment(3);
                          $CI = &get_instance();
                          $CI->load->model('Team_model');

                          $role = $CI->Team_model->getUserTeamRole($id_tm);
                          // print_r($role);exit();
                          ?>
                           <?php if($role['role_user'] == '3' || $role['role_user'] == '2') { ?>
                          <a href="<?= base_url(); ?>team" type="button" class="btn btn-secondary rounded-pill" data-toggle="modal" data-target="#tambahModal">
                            Add
                          </a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="card mb-3 bg-gradient-info">
                    <div class="row">
                      <div class="col-md-6">
                        <img src="<?= base_url('assets/'); ?>img/team.png" class="card-img dashboard" alt="...">
                      </div>
                      <div class="col-md-6" style="height: 225px; text-align: center;">
                        <div class="card-body">
                          <h2 class="card-title text-white">Member Total</h2>
                          <p class="h1 card-text font-weight-bold text-white"><?= $totalmember ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-lg-3">
              <!-- Modal -->
              <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input User</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('team/inputUserTeam'); ?>
                      <div class="pl-lg-2">
                        <div class="row">
                          <input type="hidden" id="id" name="id" class="form-control" value="<?= $team['id_team']; ?>">
                          <div class="col-lg-12">
                            <select name="adduser" id="adduser" class="form-control">
                              <option value="">Pilih</option>
                              <option value="1">Tambah Berdasarkan Struktur Organisasi</option>
                              <option value="2">Pilih Anggota</option>
                            </select>
                          </div>
                          <div class="col-lg-12 mt-3">
                            <div id="pilih-user" name="pilih-user">
                              <div class="form-group">
                                <input type="hidden" id="id_team" name="id_team" class="form-control" value="<?= $team['id_team']; ?>">
                                <select class="js-example-basic-multiple" name="id_user[]" multiple="multiple" data-live-search="true" multiple>
                                  <?php foreach ($users as $us) : ?>
                                    <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-12 mt-3">
                            <div id="pilih-depart" name="pilih-depart">
                              <div class="form-group">
                                <input type="hidden" id="id_team" name="id_team" class="form-control" value="<?= $team['id_team']; ?>">
                                <select class="js-example-basic-multiple" name="id_depart[]" multiple="multiple" data-live-search="true" multiple>
                                  <?php foreach ($depart as $dp) : ?>
                                    <option value="<?= $dp['id_departement']; ?>"><?= $dp['nama_departement']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-lg-6">
                          <button class="btn btn-icon btn-dark-primary" type="submit" name="inputDepartement">
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
        <?php $role_id = $this->session->userdata('role_id'); ?>
        
        <!-- end team modal -->

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-12">
              <h2 class="mb-0 text-center">Detail Team</h2>
            </div>
            <hr class="my-4">
          </div>
        </div>
        <div class="card-body">
          <h1 class="card-tittle text-center"><?= $team['nama_team'] ?></h1>
        </div>
        <div class="container">

        <div class="table-responsive">
            <div>
              <table class="table align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No</th>
                    <th scope="col" class="sort" data-sort="budget">User</th>
                    <th scope="col" class="sort" data-sort="status">Username</th>
                    <th scope="col" class="sort" data-sort="status">Status</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <?php if (empty($team_acc)) : ?>
                  <tr>
                    <td colspan="5">
                      <div class="alert alert-danger" role="alert">
                        <strong>Tim Ini </strong> Belum Memilih Anggota
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
                <?php
                $no = 1;
                foreach ($team_acc as $tmc) :
                ?>
                  <tbody class="list">
                    <tr>
                      <th scope="row">
                        <?= $no++; ?>
                      </th>
                      <th scope="row">
                        <div class="media align-items-center">
                          <a href="#" class="avatar rounded-circle mr-3">
                            <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $tmc['foto'] ?>">
                          </a>
                          <div class="media-body">
                            <span class="name mb-0 text-sm"><?= $tmc['nama'] ?></span>
                          </div>
                        </div>
                      </th>
                      <td>
                        <?= $tmc['username']; ?>
                      </td>
                       
                        <td>
                        <span class="badge badge-default">  <?= $tmc['role_user']; ?> </span>
                      
                        </td>
                     
                      <?php if($role == '1' || $role == '2') { ?>
                      <td>
                        <div class=" modal fade" id="modalEdit<?= $tmc['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Role User Team</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                                <?= form_open_multipart('team/editRoleUser/'. $tmc['id_access_team']); ?>
                                <input type="hidden" name="id_team" id="id_team" value="<?= $tmc['id_team'] ?>">
                                <div class="pl-lg-2">
                                  <div class="row">
                                    <div class="col-lg-12">
                                    <select name="editrole" id="editrole" class="form-control">
                                      <option value="">Pilih</option>
                                      <option value="1">Staff</option>
                                      <option value="2">Leader</option>
                                      <option value="3">Company</option>
                                    </select>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <button class="btn btn-icon btn-dark-primary" type="submit" name="inputDivisi">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Edit</span>
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
                        <a href="<?= base_url(); ?>team/deleteTeamAcc/<?= $tmc['id_access_team']; ?>" class="btn btn-danger btn-sm rounded-pill">
                          <span class="btn--inner-icon">
                            <i class="fas fa-trash"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                      </td>
                      <?php } ?>
                    </tr>

                  <?php endforeach; ?>
                  </tbody>
              </table>
            </div>

          </div>
          <hr>
    <!-- end table -->
    
        <div class="row ml-3 mb-4">
          <div class="col-lg-3">
            <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url('project/showOkr/') . $project['id_project'] ?>">
              <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
              <span class="btn-inner--text">Back</span>
            </a>
            
            <a href="<?= base_url('team/editTeam/') . $team['id_team'] ?>" class="btn btn-warning rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                <span class="btn--inner-icon">
                    <i class="ni ni-settings"></i></span>
                <span class="btn-inner--text">Edit</span>
             </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
