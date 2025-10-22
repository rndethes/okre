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
              <h3 class="mb-0">Edit Divisi</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('departement/editDivisi/' . $divisi['id_divisi']); ?>
          <div class="pl-lg-4">

            <div class="row">
              <input type="hidden" id="id_divisi" name="id_divisi" class="form-control" value="<?= $divisi['id_divisi']; ?>">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Nama Divisi</label>
                  <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" value="<?= $divisi['nama_divisi']; ?>">
                  <small class="form-text text-danger"><?= form_error('nama_divisi'); ?></small>
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
                <a class="btn btn-icon btn-danger rounded-pill" type="button" href="<?= base_url() ?>departement/division">
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