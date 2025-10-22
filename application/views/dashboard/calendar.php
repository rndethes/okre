<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">OKR</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Workspace</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $space['name_space'] ?></li>
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
        <div class="alert alert-secondary" role="alert">
        <div class="row align-items-center">
          <div class="col-lg-10">
            <h3 class="text-primary"> <button type="button" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
            </button> WORKSPACE <?= $space['name_space'] ?></h3>
           </div>
           <div class="col-auto">
           <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
              <span class="btn-inner--text">Kembali</span>
            </a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">   
    <div class="col-xl-12"> 
      <div class="card">
        <div class="card-header border-2 mb-4">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">Calendar In Your Space</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <?php $spaceidurl = $this->uri->segment(3) ?>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-xl-12 align-items-center"> 
                <div class="card p-5">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>        
    </div>
      <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalCalendar" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content bg-gradient-primary">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Jadwal Kamu</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-1 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4"></h4>
                        <h5 class="text-white"></h5>
                        <div id="description-container" class="text-white">
                            <p>[Description]</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="editjadwal" class="btn btn-white" data-idpace="<?= $this->uri->segment(3); ?>">Edit</button>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>