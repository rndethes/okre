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
                          <h3 class="card-title text-white">Add Your Team</h3>
                          <p class="card-text text-white">Add and Make your team to help you and supporting you in project management OKR</p>
                          <?php $role = $this->session->userdata('role_id'); ?>
                           <?php if($role == '1' || $role == '2') { ?>
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
                          <h2 class="card-title text-white">Team</h2>
                          <p class="h1 card-text font-weight-bold text-white"><?= $countteam ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

  <!-- end team -->


  <!-- team modal -->
          <div class="row">
            <div class="col-lg-3">
              <!-- Modal -->
              <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input Team</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('team/inputTeam'); ?>
                      <div class="pl-lg-2">
                        <div class="row">
                          <input type="hidden" id="id_team" name="id_team" class="form-control">
                          <!-- <div class="col-lg-6">
                            <div class="form-group">
                              <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                <option value="AL">Alabama</option>
                                ...
                                <option value="WY">Wyoming</option>
                              </select>
                            </div>
                          </div> -->
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Nama Team</label>
                              <input type="text" id="nama_team" name="nama_team" class="form-control" placeholder="Nama Team" required maxlength="32">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Keterangan</label>
                              <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan.."></textarea>
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

<!-- Page content -->
    <div class="container">
      <div class="row">
              <!-- table -->
        <div class="col-lg-12">
          <div class="card">
              <div class="row align-items-center mt-4">
                <div class="col">
                  <h2 class="mb-0 text-center">Data Team</h2>
                </div>
              </div>
            <div class="card-body">
              <div class="table-responsive">
                <div>
                  <table class="table align-items-center">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="sort" data-sort="name">No</th>
                        <th scope="col" class="sort" data-sort="budget">Nama</th>
                        <th scope="col" class="sort" data-sort="status">Keterangan</th>
                        <th scope="col" class="sort" data-sort="status">Member Team</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                  <?php
                  $no = 1;
                  foreach ($team as $tm) :
                  ?>
                    <tbody class="list">
                      <tr>
                        <th scope="row">
                          <?= $no++; ?>
                        </th>
                        <td>
                          <?= $tm['nama_team']; ?>
                        </td>
                        <td>
                          <?= $tm['keterangan']; ?>
                        </td>
                        <td>
                          <div class="avatar-group">
                            <?php
                              $id_tm = $tm['id_team'];
                              $CI = &get_instance();
                              $CI->load->model('Team_model');

                              $acc_team = $CI->Team_model->getTeamProject($id_tm);                              ?>
                              <?php foreach ($acc_team as $am) : ?>
                                  <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="<?= $am['nama']; ?>">
                                    <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $am['foto'] ?>">
                                  </a>
                              <?php endforeach; ?>
                          </div>     
                        </td>
                        <?php if ($role_id == '3') { ?>
                      <td>
                        <a href="<?= base_url(); ?>team/detailTeam/<?= $tm['id_team']; ?>" class="btn btn-info btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Detail">
                          <span class="btn--inner-icon">
                            <i class="fas fa-solid fa-eye"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                      </td>
                    <?php } else { ?>
                      <td>
                        <a href="<?= base_url(); ?>team/detailTeam/<?= $tm['id_team']; ?>" class="btn btn-info btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Detail">
                          <span class="btn--inner-icon">
                            <i class="fas fa-solid fa-eye"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                        <a href="<?= base_url(); ?>team/editTeam/<?= $tm['id_team']; ?>" class="btn btn-warning btn-sm rounded-pill" data-toggle="tooltip" data-placement="top" title="Edit">
                          <span class="btn--inner-icon">
                            <i class="ni ni-settings"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                        <a href="<?= base_url(); ?>team/deleteTeam/<?= $tm['id_team']; ?>" class="btn btn-danger btn-sm rounded-pill tombol-hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <span class="btn--inner-icon">
                            <i class="fas fa-trash"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                      </td>
                    <?php } ?>
                  </tr>

                </tbody>
              <?php endforeach; ?>

            </table>
          </div>

        </div>
      </div>
    </div>
      </div>
    <!-- end table -->
    </div>
  </div>
