<div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(<?= base_url(); ?>/assets/img/theme/office.jpg); background-size: cover; background-position: center top;">
  <!-- Mask -->
  <span class="mask bg-gradient-default opacity-8"></span>
  <!-- Header container -->
  <div class="container-fluid d-flex align-items-center">
    <div class="row">
      <div class="col-lg-7 col-md-10">
        <h1 class="display-2 text-white"> <?= $users['nama']; ?></h1>
        <p class="text-white mt-0 mb-5">This is your profile page, You can edit your profile </p>
      </div>
    </div>
  </div>
  
</div>
<div class="container-fluid mt--6">
  <div class="row">
  <div class="col-xl-12 order-xl-1 ">
    <div class="card bg-default card-frame">
      <div class="card-body">
        <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-text-1-tab" href="<?= base_url("setting") ?>" >Setting Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tab" href="<?= base_url("setting/signatureview") ?>">Setting Tanda Tangan</a>
          </li>
      </ul>
      </div>
    </div>
    
</div>
    <div class="col-xl-4 order-xl-2">
      <div class="card card-profile">
        <img src="<?= base_url() ?>/assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
        <div class="row justify-content-center">
          <div class="col-lg-3 order-lg-2">
            <div class="card-profile-image">
              <a href="#">
                <img src="<?= base_url() ?>/assets/img/profile/<?= $users['foto'] ?>" class="rounded-circle">
              </a>
            </div>
          </div>
        </div>
        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
          <div class="d-flex justify-content-between">

          </div>
        </div>
        <div class="card-body pt-0">
          <div class="row">
            <div class="col">
             
            </div>
          </div>
          <div class="text-center">
            <h5 class="h3 mt-4">
              <?= $users['nama']; ?><span class="font-weight-light"></span>
            </h5>
            <div class="h5 font-weight-300">
              <i class="ni location_pin mr-2"></i><?= $users['alamat']; ?>
            </div>
            <div>
            </div>
          </div>
          <div class="text-center mt-3">
          <a href="<?= base_url(); ?>/setting/changepassword" type="button" class="btn btn-dark-primary mb-4 rounded-pill" >
              <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
              <span class="btn-inner--text">Change Your Password</span>
            </a>
              </div>
        </div>
      </div>
    </div>
 
    <div class="col-xl-8 order-xl-1">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Edit profile </h3>
            </div>

          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('setting/edit') ?>
          <h6 class="heading-small text-muted mb-4">User information</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" id="input-username" name="id" class="form-control" value="<?= $users['id']; ?>">
                <input type="hidden" id="input-username" name="usernamelama" class="form-control" value="<?= $users['username']; ?>">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Username</label>
                  <input type="text" id="input-username" name="username" class="form-control" value="<?= $users['username']; ?>">
                </div>
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Nama</label>
                  <input type="text" id="input-username" name="nama" class="form-control" value="<?= $users['nama']; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Email address</label>
                  <input type="email" id="input-email" name="email" class="form-control" value="<?= $users['email']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-first-name">No Hp</label>
                  <input type="text" id="input-first-name" name="no_hp" class="form-control" value="<?= $users['no_hp']; ?>">
                </div>
              </div>         
            </div>
          </div>
          <hr class="my-4" />
          <!-- Address -->
          <h6 class="heading-small text-muted mb-4">Contact information</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="input-address">Address</label>
                  <textarea rows="4" class="form-control" name="alamat"><?= $users['alamat']; ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <hr class="my-4" />
          <div class="pl-lg-4">
            <div class="row">
              <div class="form-group">
                <div class="col-sm-2"><label for="example-email-input" class="form-control-label">Picture</label></div>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-4 mb-4">
                      <img id="preview-image" src="<?= base_url('assets/img/profile/') . $users['foto']; ?>" class="img-thumbnail edit-picture">
                    </div>
                    <div class="col-sm-8">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto">
                        <label class="custom-file-label" for="foto">Pilih File</label>
                        <label class="form-control-label text-danger pictureLabel" for="input-nomor">*/Max Size Photo 2 MB/*</label>
                      </div>
                      <input type="hidden" value="<?= $users['foto']; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <button class="btn btn-icon btn-dark-primary rounded-pill" type="submit" name="edit">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Edit</span>
              </button>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
  <script>
        document.getElementById('foto').addEventListener('change', function(event) {
        var input = event.target;
        var label = input.nextElementSibling;
        var file = input.files[0];

        // Ganti label dengan nama file yang dipilih
        label.textContent = file.name;

        if (file) {
            var reader = new FileReader();

            // Saat file sudah dibaca
            reader.onload = function(e) {
                // Ubah src dari <img> dengan file yang dipilih
                document.getElementById('preview-image').src = e.target.result;
            };

            // Membaca file sebagai Data URL
            reader.readAsDataURL(file);
        }
    }); 
  </script>