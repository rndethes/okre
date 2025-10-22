<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title><?= $title; ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/') ?>img/logo_web.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/argon.css?v=1.2.0" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css" type="text/css">
</head>

<body class="bg-dark-primary-grd">
  <!-- Navbar -->

  <!-- Main content -->
  <div class=" main-content">
    <!-- Header -->
    <div class="header py-7 py-lg-6">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Use this form to register your account OKR'e</h1>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <img src="<?= base_url('assets/') ?>img/regis.svg" class="img-fluid img-login">
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
          xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div> -->
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h4 class="text-muted">Register to Start Your OKR'e</h4>
              </div>
              <div class="btn-wrapper text-center pb-4">
                <img class="logo-form" src="" width="70">
              </div>
              <?= form_open_multipart('register/inputRegister'); ?>
              <div class="pl-lg-2">
              <small class="form-text text-danger"><?= form_error('username'); ?></small>
              <small class="form-text text-danger"><?= form_error('email'); ?></small>
                <div class="row">
                  <input type="hidden" id="id" name="id" class="form-control">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-nomor">Username</label>
                      <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                      <small id="username-error" class="form-text text-danger" style="display:none;">Username tidak boleh menggunakan huruf besar atau spasi.</small>
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
              <div class="text-center">
                <button type="submit"  id="submit-btn" name="inputRegister" class="btn btn-dark-primary my-4">Sign in</button>
              </div>
              <div class="text-center">
                <a href="<?= base_url() ?>auth" class="text-light"><small>Do You Have Account?</small></a>
              </div>

            </div>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- Footer -->

  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/js-cookie/js.cookie.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="<?= base_url('assets/'); ?>js/argon.js?v=1.2.0"></script>
  <script>
    function myFunction() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
<script>
    document.getElementById('username').addEventListener('input', function(event) {
        const username = event.target.value;
        const errorElement = document.getElementById('username-error');
        const submitButton = document.getElementById('submit-btn');

        // Cek apakah ada huruf besar atau spasi dalam input
        if (/[A-Z\s]/.test(username)) {
            // Tampilkan pesan error dan nonaktifkan tombol submit
            errorElement.style.display = 'block';
            submitButton.disabled = true;
        } else {
            // Sembunyikan pesan error dan aktifkan tombol submit jika input valid
            errorElement.style.display = 'none';
            submitButton.disabled = false;
        }
    });
</script>
</body>

</html>