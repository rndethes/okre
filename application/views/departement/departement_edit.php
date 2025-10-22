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
              <h3 class="mb-0">Edit Departement</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('departement/editDepartement/' . $departement['id_departement']); ?>
          <div class="pl-lg-4">

            <div class="row">
              <input type="hidden" id="id_departement" name="id_departement" class="form-control" value="<?= $departement['id_departement']; ?>">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="no_departement">No Departement</label>
                  <input type="text" id="no_departement" name="no_departement" class="form-control" value="<?= $departement['no_departement']; ?>">
                  <small class="form-text text-danger"><?= form_error('no_departement'); ?></small>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Nama Departement</label>
                  <input type="text" id="nama_departement" name="nama_departement" class="form-control" value="<?= $departement['nama_departement']; ?>">
                  <small class="form-text text-danger"><?= form_error('nama_departement'); ?></small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Alamat Departement</label>
                  <textarea class="form-control" id="alamat_departement" name="alamat_departement" rows="3"><?= $departement['alamat_departement']; ?></textarea>
                  <small class="form-text text-danger"><?= form_error('alamat_departement'); ?></small>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-lg-2">
                <button class="btn btn-icon btn-dark-primary rounded-pill" type="submit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Edit</span>
                </button>
              </div>
              <div class="col-lg-3">
                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url() ?>departement">
                  <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Back</span>
                </a>
              </div>
            </div>
          </div>




          </form>
        </div>
      </div>
    </div>

  </div>