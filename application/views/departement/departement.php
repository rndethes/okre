<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashDept'); ?>"></div>
    <?php if ($this->session->flashdata('flashDept')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Departement</h6>
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
      <div class="row mb-2">
      <div class="col-4">
        <div class="card">
          <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <img src="<?= base_url() ?>assets/img/departementimg.png" style="width:150px;" class="img-fluid border-radius-lg">
          </div>

          <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">DIVISI</span>
            <a href="<?= base_url() ?>departement/division" class="card-title h2 d-block text-darker">
              Pengaturan Divisi
            </a>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <a href="javascript:;" class="d-block">
              <img src="<?= base_url() ?>assets/img/divisionimg.png" style="width:176px;" class="img-fluid border-radius-lg">
            </a>
          </div>

          <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">DEPARTEMEN</span>
            <a href="<?= base_url() ?>departement" class="card-title h2 d-block text-darker">
              Pengaturan Departement
            </a>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <a href="javascript:;" class="d-block">
              <img src="<?= base_url() ?>assets/img/jabatanimg.png" style="width:205px;" class="img-fluid border-radius-lg">
            </a>
          </div>
          <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">JABATAN</span>
            <a href="<?= base_url() ?>departement/jabatan" class="card-title h2 d-block text-darker">
              Pengaturan Jabatan
            </a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center mb-4">
            <div class="col">
              <h3 class="mb-1">Data Departement</h3>
            </div>
          </div>
          <div class="row">
            <?php $role = $this->session->userdata('role_id'); ?>
            <?php if($role == '1') { ?>
            <div class="col-lg-3">
              <button type="button" class="btn btn-dark-primary mb-4 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Tambah Departement</span>
              </button>
            <?php } ?>
              <!-- Modal -->
              <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input Data Account</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('departement/inputDepartement'); ?>
                      <div class="pl-lg-2">
                        <div class="row">
                          <input type="hidden" id="id_departement" name="id_departement" class="form-control" placeholder="ID Departement">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">No Departement</label>
                              <input type="text" id="no_departement" name="no_departement" class="form-control" placeholder="No Departement" required maxlength="32" required>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Nama Departement</label>
                              <input type="text" id="nama_departement" name="nama_departement" class="form-control" placeholder="Nama Departement" required>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Divisi</label>
                              <select class="form-control" id="divisi" name="divisi">
                                <option value="">Pilih Divisi</option>
                                <?php foreach($divisi as $dv) : ?>
                                <option value="<?= $dv['id_divisi']; ?>"><?= $dv['nama_divisi']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Alamat Departement</label>
                              <textarea class="form-control" id="alamat_departement" name="alamat_departement" rows="3" placeholder="Alamat Departement.."></textarea>
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
          <div class="table-responsive">
            <div>
              <table class="table align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No</th>
                    <th scope="col" class="sort" data-sort="budget">No Departement</th>
                    <th scope="col" class="sort" data-sort="status">Nama Departement</th>
                    <th scope="col" class="sort" data-sort="status">Alamat Departement</th>
                     <?php if($role == '1') { ?>
                    <th scope="col"></th>
                     <?php } ?>
                  </tr>
                </thead>
                <?php
                $no = 1;
                foreach ($departement as $dt) : ?>
                  <tbody class="list">
                    <tr>
                      <th scope="row">
                        <?= $no++; ?>
                      </th>
                      <td>
                        <?= $dt['no_departement']; ?>
                      </td>
                      <td>
                        <?= $dt['nama_departement']; ?>
                      </td>
                      <td>
                        <?= $dt['alamat_departement']; ?>
                      </td>
                      <?php if($role == '1') { ?>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="<?= base_url(); ?>departement/editDepartement/<?= $dt['id_departement']; ?>">Edit</a>
                            <a class="dropdown-item tombol-hapus" data-target="<?= base_url(); ?>departement/deleteDepartement/<?= $dt['id_departement']; ?>">Delete</a>
                          </div>
                        </div>
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
    </div>