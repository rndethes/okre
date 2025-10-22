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
              <h3 class="mb-0">Input Data</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?php $role_id = $this->session->userdata('role_id') ?> 
        <form method="post" action="<?= base_url("data/inputtabel/") . $this->uri->segment(3); ?>">
         <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="tablename" class="form-control-label">Nama Tabel</label>
                    <input class="form-control" type="text" id="tablename" name="tablename">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="tabledesc" class="form-control-label">Deskripsi Tabel</label>
                    <textarea class="form-control" id="tabledesc" name="tabledesc" rows="3"></textarea>
                </div>
            </div>
         </div>
            <button class="btn btn-icon btn-default rounded-pill" type="submit"  >
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Simpan dan Lanjutkan</span>
            </button>
        </form>
        </div>
      </div>
    </div>
  </div>
            