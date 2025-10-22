<div id="roomspace"></div>
<script>
    // Check for flashdata in PHP
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
    </script>
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Workspace</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Workspace</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('document/index/') .$this->uri->segment(3) . "/space" ?>">Document</a></li>
              <li class="breadcrumb-item active" aria-current="page">Buat Dokumen</li>
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
      <!-- <div class="card card-frame">
        <div class="card-body"> -->
        <div class="alert alert-secondary" role="alert">
        <div class="row align-items-center">
          <div class="col-lg-10">
            <h3 class="text-primary">  <button type="button" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
            </button> WORKSPACE <?= $space['name_space'] ?></h3>
           </div>
           <div class="col-auto">
           <a href="<?= base_url("document/index/") . $this->uri->segment(3) . "/space" ?>" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
              <span class="btn-inner--text">Kembali</span>
            </a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- BATAASSSS -->
<div class="container-fluid">
  <div class="row">   
    <div class="col-lg-12 mb-4">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text-tabnav" role="tablist">
          <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-1-tabnav" href="<?= base_url("project/projectAtWorkspace/") . $this->session->userdata('workspace_sesi') ?>" role="tab" aria-controls="tabs-text-1" aria-selected="true">OKR</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-3-tab" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false">Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-text-2-tab" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-2" aria-selected="false">Document</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-4-tab" href="<?= base_url("workspace/chatspace/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-4" aria-selected="true">Chat</a>
            </li>
          </ul>
        </div> 
      </div> 
    </div> 
      <div class="col-xl-12">
      <div class="card pt-2">
                    <div class="row m-3">
                      <div class="col-sm-2">
                        <img src="<?= base_url() ?>assets/img/imgreviewdoc.png" style="width:150px;" class="img-fluid border-radius-lg">
                      </div>

                        <div class="card-body pt-2">
                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Daftar Dokumen di Space <?= $space['name_space'] ?></span>
                              <span class="card-title h4 d-block text-darker">
                                Klik Disini Untuk Melihat Daftar Dokumen yang sudah dibuat
                              </span>
                            
                                <a href="<?= base_url("data/viewDocument/") . $this->uri->segment(3) . "/space" ?>" class="btn btn-default rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                    <span class="btn-inner--text">Lihat Daftar Dokumenmu</span>
                                </a>
                            
                        </div>
                  </div>
                </div>
        <div class="card">
          <div class="card-header">
          <div class="row">
                <div class="col-xl-12" id="main-column">
                <div class="card">
                    <div class="card-header">
                    <div class="col-xl-12">
                    <div class="row align-items-center">
                        <div class="col-8">
                        <h2 class="mb-2">Buat Document</h2>
                        </div>
                        <hr class="my-4" />
                    </div>
                    </div>

                <form action="<?= base_url("data/savedecsdoc/") . $this->session->userdata('workspace_sesi') ?>" method="POST">
                    <div class="row">
                        
                    
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="docname" class="form-control-label">Nama Dokumen</label>
                            <input class="form-control" type="text" placeholder="Input Nama Dokumen Disini" id="docname" name="docname" required>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="doctype" class="form-control-label">Tipe Dokumen</label>
                                <select class="form-control" id="doctype" name="doctype" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="1">Surat</option>
                                    <option value="2">Invoice</option>
                                    <option value="3">Proposal</option>
                                    <option value="4">BAA</option>
                                    <option value="5">Dokumen Lainnya</option>
                                </select>
                        </div>
                        </div>
                        <div class="col-lg-3">
                        <button class="btn btn-primary rounded-pill"><span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i></span>
                            <span class="btn-inner--text">Simpan dan Lanjutkan</span>
                        </button>
                        </div>
                       
                    </div>
                </from>
                <?php 
                    $CI = &get_instance();
                    $CI->load->model('Space_model');
                    $idspace = $this->session->userdata('workspace_sesi');
                    $id = $this->session->userdata('id');
                    $myidspace = $CI->Space_model->cekSpaceTeamId($id,$idspace);
                  ?>
              
              
                    
                  </br>
                </div>
              </div>
            </div>
          </div>
        </div>            
      </div>

    
 




        
    

 
              

                      