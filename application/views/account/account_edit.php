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
              <h3 class="mb-0">Edit Account</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('account/editAccount/' . $users['id']); ?>
          <div class="pl-lg-2">
            <div class="row">
              <div class="col-lg-6">
                <a href="#" class="rounded-circle mr-3">
                  <img alt="Image placeholder picture-edit" src="<?= base_url('assets/img/profile/') . $users['foto']; ?>" style="width: 149px;">
                </a>
              </div>
              <div class="col-lg-6 mt-5">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto" name="foto" value="<?= $users['foto'];  ?>">
                  <label class="custom-file-label" for="foto">Choose file</label>
                </div>
              </div>
            </div>
            <div class="row">
              <input type="hidden" id="id" name="id" value="<?= $users['id']; ?>" class="form-control">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Username</label>
                  <input type="text" id="username" name="username" class="form-control" value="<?= $users['username']; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Nama</label>
                  <input type="text" id="nama" name="nama" class="form-control" value="<?= $users['nama']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Email</label>
                  <input type="email" id="email" name="email" class="form-control" value="<?= $users['email']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">No Hp</label>
                  <input type="text" id="no_hp" name="no_hp" class="form-control" value="<?= $users['no_hp']; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Jabatan</label>
                  <?php $idjab = $users['id_jabatan']; //ambil dari data yg diedit 
                  ?>
                  <select class="form-control" id="id_jabatan" name="id_jabatan" style="width:100%;">
                    <?php foreach ($jabatan as $key => $jabatan) : ?>
                      <?php if ($idjab == $jabatan["id_departement"]) { ?>
                        <option value="<?php echo $jabatan["id_jabatan"] ?>" selected>
                          <?php echo $jabatan["nama_jabatan"] ?>
                        </option>
                      <?php } else { ?>
                        <option value="<?php echo $jabatan["id_jabatan"] ?>">
                          <?php echo $jabatan["nama_jabatan"]  ?>
                        </option>
                      <?php } ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <label class="form-control-label" for="input-nomor">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $users['alamat'] ?></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Departemen</label>
                  <?php $iddept = $users['id_departement']; //ambil dari data yg diedit 
                  ?>
                  <select class="form-control" id="id_departement" name="id_departement" style="width:100%;">
                    <?php foreach ($departement as $key => $departement) : ?>
                      <?php if ($iddept == $departement["id_departement"]) { ?>
                        <option value="<?php echo $departement["id_departement"] ?>" selected>
                          <?php echo $departement["nama_departement"] ?>
                        </option>
                        <?php } else { ?>
                          <option value="<?php echo $departement["id_departement"] ?>">
                            <?php echo $departement["nama_departement"]  ?>
                          </option>
                          <?php } ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-nomor">Departemen</label>
                        <?php $idkan = $users['id_kantor']; //ambil dari data yg diedit 
                        ?>
                        <select class="form-control" id="id_kantor" name="id_kantor" style="width:100%;">
                          <?php foreach ($kantor as $key => $kantor) : ?>
                            <?php if ($idkan == $kantor["id_kantor"]) { ?>
                              <option value="<?php echo $kantor["id_kantor"] ?>" selected>
                                <?php echo $kantor["nama_kantor"] ?>
                              </option>
                            <?php } else { ?>
                              <option value="<?php echo $kantor["id_kantor"] ?>">
                                <?php echo $kantor["nama_kantor"]  ?>
                              </option>
                            <?php } ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Role ID</label>
                  <select class="form-control" id="role_id" name="role_id">
                    <option value="1" <?php if ($users['role_id'] == '1') { ?> selected="selected" <?php } ?>>Company</option>
                    <option value="2" <?php if ($users['role_id'] == '2') { ?> selected="selected" <?php } ?>>Leader</option>
                    <option value="3" <?php if ($users['role_id'] == '3') { ?> selected="selected" <?php } ?>>Staff</option>
                  </select>
                </div>
              </div>
              <!-- <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-nomor">Password</label>
                  <input type="password" id="password" name="password" class="form-control" value="<?= $users['password']; ?>">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="myFunction()">
                    <label class=" custom-control-label" for="customCheck1">Show Password</label>
                  </div>
                </div>
              </div> -->
          </div>
          <br>
          <div class="row">
            <div class="col-lg-2">
              <button class="btn btn-icon btn-dark-primary rounded-pill" type="submit" name="editAccount">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Edit</span>
              </button>
            </div>
          </form>
             <div class="col-lg-3">
                  <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#changePass<?= $users['id']; ?>">
                    <span class="btn-inner--icon"><i class="ni ni-lock-circle-open"></i></span>
                    <span class="btn-inner--text">Change Password</span>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="changePass<?= $users['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <?= form_open_multipart('account/changePassword'); ?>
                          <div class="col-lg-12">
                            <input type="hidden" name="id" value="<?= $users['id']; ?>">

                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Password</label>
                              <label class="form-control-label text-danger changePassword" for="input-nomor" onclick="showDisabled()">*/Klik jika ingin mengganti Password/*</label>
                              <input type="password" id="passwordEdit" name="password" class="form-control" readonly>
                            </div>
                          </div>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                          <?= form_close(); ?>
                        </div>
                        <div class="modal-footer">

                        </div>

                      </div>
                    </div>
                  </div>
                </div>
            <div class="col-lg-3">
              <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url() ?>account">
                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Back</span>
              </a>
            </div>
          </div>
        </div>      
      </div>
    </div>
  </div>