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
              <h3 class="mb-0">Edit Jabatan</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('departement/editJabatan/' . $jabatan['id_jabatan']); ?>
          <div class="pl-lg-4">

          <div class="pl-lg-2">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="nama_jabatan">Nama Jabatan</label>
                              <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control" placeholder="Nama Jabatan" value="<?= $jabatan['nama_jabatan'] ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Tingkat Jabatan</label>
                              <select class="form-control" id="level_jabatan" name="level_jabatan">
                                <?php if($jabatan['level_jabatan'] == 'TM') { ?>
                                <option value="TM" selected>TM</option>
                                <option value="MM">MM</option>
                                <option value="FM">FM</option>
                                <option value="OF">OF</option>
                                <?php } elseif($jabatan['level_jabatan'] == 'MM') { ?>
                                <option value="TM">TM</option>
                                <option value="MM" selected>MM</option>
                                <option value="FM">FM</option>
                                <option value="OF">OF</option>
                                <?php } elseif($jabatan['level_jabatan'] == 'FM') { ?>
                                <option value="TM">TM</option>
                                <option value="MM">MM</option>
                                <option value="FM" selected>FM</option>
                                <option value="OF">OF</option>
                                <?php } elseif($jabatan['level_jabatan'] == 'OF') { ?>
                                <option value="TM">TM</option>
                                <option value="MM">MM</option>
                                <option value="FM">FM</option>
                                <option value="OF" selected>OF</option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-nomor">Departement</label>
                              <?php $iddept = $jabatan['id_departement']; ?>
                              <select class="form-control" id="id_departement" name="id_departement">
                              <?php foreach ($departement as $departement) : ?>
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