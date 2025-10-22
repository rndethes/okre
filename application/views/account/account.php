<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashAcc'); ?>"></div>
    <?php if ($this->session->flashdata('flashAcc')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Account</h6>
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
        <div class="card-header border-0">
          <div class="row align-items-center mb-4">
            <div class="col">
              <h3 class="mb-0">Data Account</h3>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-3">
              <button type="button" class="btn btn-dark-primary mb-4 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Tambah Account</span>
              </button>
              <!-- Modal -->
              <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input Data Account</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('account/inputAccount'); ?>
                      <div class="pl-lg-2">
                        <div class="row">
                          <input type="hidden" id="id" name="id" class="form-control">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Username</label>
                              <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Nama</label>
                              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Email</label>
                              <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">No Hp</label>
                              <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No Hp" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Jabatan</label>
                              <select class="form-control" id="jabatan" name="jabatan">
                                <option value="">Pilih Jabatan</option>
                                <?php foreach($jabatan as $jb) : ?>
                                <option value="<?= $jb['id_jabatan']; ?>"><?= $jb['nama_jabatan']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <label class="form-control-label" for="input-nomor">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat.."></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Departemen</label>
                              <select class="form-control" id="id_departement" name="id_departement">
                                <option value="">Pilih Departemen</option>
                                <?php foreach ($departement as $dt) : ?>
                                  <option value="<?= $dt['id_departement']; ?>"><?= $dt['nama_departement']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                          <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Kantor</label>
                              <select class="form-control" id="id_kantor" name="id_kantor">
                                <option value="">Pilih Kantor</option>
                                <?php foreach ($kantor as $kt) : ?>
                                  <option value="<?= $kt['id_kantor']; ?>"><?= $kt['nama_kantor']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Role ID</label>
                              <select class="form-control" id="role_id" name="role_id">
                                <option value="">Pilih Role</option>
                                <option value="1">Company</option>
                                <option value="2">Leader</option>
                                <option value="3">Staff</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Password</label>
                              <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="myFunction()">
                                <label class=" custom-control-label" for="customCheck1">Show Password</label>
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
        </div>

    <div class="col-xl-12">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center mb-4">
          </div>
        <div class="table-responsive">
          <div>
            <table class="table align-items-center" id="tableAcc">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="sort" data-sort="name">No</th>
                  <th scope="col" class="sort" data-sort="name">Nama</th>
                  <th scope="col" class="sort" data-sort="status">Username</th>
                  <th scope="col" class="sort" data-sort="completion">No Hp</th>
                
                  <th scope="col" class="sort" data-sort="completion">Departement</th>
                  <th scope="col" class="sort" data-sort="completion">Role</th>
                  <th scope="col" class="sort" data-sort="completion">Activated</th>
                  <th scope="col"></th>
                </tr>
              </thead>

              <tbody class="list">
              </tbody>

            </table>
          </div>
        </div>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div> 
  </div>