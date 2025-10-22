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
              <img src="<?= base_url() ?>assets/img/divisionimg.png" style="width:176px;"class="img-fluid border-radius-lg">
            </a>
          </div>

          <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">DEPARTEMEN</span>
            <a href="<?= base_url() ?>departement" class="card-title h2 d-block text-darker">
              Pengaturan Departemen
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
              <h3 class="mb-1">Data Division</h3>
            </div>
          </div>
          <div class="row">
            <?php $role = $this->session->userdata('role_id'); ?>
            <?php if($role == '1') { ?>
            <div class="col-lg-3">
              <button type="button" class="btn btn-dark-primary mb-4 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Tambah Divisi</span>
              </button>
            <?php } ?>
            </div>
            <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Input Data Divisi</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                      <?= form_open_multipart('departement/inputDivisi'); ?>
                      <div class="pl-lg-2">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="nama_divisi">Nama Divisi</label>
                              <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" placeholder="Nama Divisi" required>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-6">
                            <button class="btn btn-icon btn-dark-primary" type="submit" name="inputDivisi">
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
            <div class="table-responsive">
            <div>
              <table class="table align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No</th>
                    <th scope="col" class="sort" data-sort="status">Nama Divisi</th>
                    <?php if($role == '1') { ?>
                    <th scope="col" class="sort" data-sort=""></th>
                    <?php } ?>
                  </tr>
                </thead>
                <?php 
                $no = 1;
                foreach($divisi as $dv) :?>
                <tbody class="list">
                    <th>
                        <?= $no++; ?>
                    </th>
                    <td>
                        <?= $dv['nama_divisi']; ?>
                    </td>
                    <?php if($role == '1') { ?>
                        <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="<?= base_url(); ?>departement/editDivisi/<?= $dv['id_divisi']; ?>">Edit</a>
                            <a class="dropdown-item tombol-hapus" data-target="<?= base_url(); ?>departement/deleteDivisi/<?= $dv['id_divisi']; ?>">Delete</a>
                          </div>
                        </div>
                        </td>
                    <?php } ?>
                </tbody>
                <?php endforeach; ?>
              </table>
            </div>

          </div>
        </div>
      </div>
      </div>
    </div>
</div>