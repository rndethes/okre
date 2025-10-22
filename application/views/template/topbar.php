<!-- Main content -->
<div class="main-content" id="panel">
  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-dark-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto ">

</ul>
        <ul class="navbar-nav align-items-center  ml-md-auto ml-md-0">
          <li class="nav-item d-xl-none" style="margin-right: -10px;">
            <!-- Sidenav toggler -->
            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main" style="padding:10px;">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </li>
          
          <li class="nav-item dropdown">
            <a class="pr-2 nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="badge-count" class="badge badge-md badge-circle badge-floating badge-danger border-white" style="display: none;">0</span>
              <i class="ni ni-bell-55"></i>
             
             
            </a>
            <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">

              <div class="px-3 py-3">
                <h6 class="text-sm text-muted m-0">Pesanmu <strong id="message-count" class="text-primary">0</strong> pesan.</h6>
              </div>

              <div class="list-group list-group-flush notifspace" id="newmessage">
                
              </div>
              <a id="viewall" href="<?= base_url('workspace/myNotification') ?>" class="dropdown-item-notif text-center text-primary font-weight-bold py-3">View all</a>
              </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" id="topbrimg" src="<?= base_url('assets/img/profile/') . $users_name['foto']; ?>">
                </span>
                <div class="media-body  ml-2  d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?= $users_name['nama']; ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu  dropdown-menu-right ">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="<?= base_url(); ?>project" class="dropdown-item">
                <i class="ni ni-atom"></i>
                <span>Space</span>
              </a>
              <a href="<?= base_url(); ?>setting" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
             
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="modal fade" id="meetingConfirmModal" tabindex="-1" role="dialog" aria-labelledby="meetingConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="meetingConfirmModalLabel">Konfirmasi Meeting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah kamu akan menerima meeting ini?
        <input type="text" id="idnotif" name="idnotif">
      </div>
      <div class="modal-footer">
        <button type="button" id= "terima-btn" class="btn btn-success">Terima</button>
        <button type="button" id="tolak-btn" class="btn btn-danger">Tolak</button>
        <button type="button" id="ubah-btn" class="btn btn-warning">Ubah</button>
      </div>
    </div>
  </div>
</div>