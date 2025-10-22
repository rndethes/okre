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
              <h1 class="text-white">Welcome! to OKR'e</h1>
              <p class="text-lead text-white">Use this form to login your account OKR'e</p>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <img src="<?= base_url('assets/') ?>img/pjnew.png" class="img-fluid img-login">
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
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h4 class="text-muted">Login to OKR'e Dashboard</h4>
              </div>
              <div class="btn-wrapper text-center pb-4">
                <img class="logo-form" src="" width="70">
              </div>
              <form role="form" method="POST" action="<?= base_url('auth/login'); ?>">
                <?php
                if ($this->session->flashdata('msg') != null) {
                  echo
                  '<div id="info" class="alert alert-warning alert-dismissible fade show" role="alert">' . $this->session->flashdata('msg') . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                }
                ?>
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input name="username" class="form-control" placeholder="Username" type="text" value="<?= $this->session->flashdata('username'); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input name="password" id="password" class="form-control" placeholder="Password" type="password">

                  </div>
                  <div class="custom-control custom-checkbox mt-1">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="myFunction()">
                    <label class=" custom-control-label" for="customCheck1">Show Password</label>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4 rounded-pill">Login</button>
                </div>
                <div class="text-center">
                  <a href="<?= base_url() ?>register" class="text-light"><small>Create new account</small></a>
                </div>

                <!-- <div class="card-header bg-transparent pb-1">
                </div> -->

              </form>
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
</body>

</html>