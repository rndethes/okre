<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashOkr'); ?>"></div>
    <?php if ($this->session->flashdata('flashOkr')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Objective</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboards</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(); ?>project">Project</a></li>
              <li class="breadcrumb-item active" aria-current="page">Project Progress</li>
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

<input type="hidden" name="idworkspace" value="<?= $this->session->userdata('workspace_sesi') ?>">

            
<?php $idus = $this->session->userdata('id'); ?>

  <div class="row">
        <div class="col-xl-12">
            <div class="card card-frame">
                <div class="card-header">
                    <h2>Masukan Email</h2>
                </div>
                <div class="card-body">
                  <div class="card bg-gradient-default">
                        <div class="card-body">
                            <h3 class="card-title text-white"><?= $mydocument['name_document'] ?></h3>
                            <blockquote class="blockquote text-white mb-0">
                                <p>Dibuat Tanggal : <?= date("j F Y",strtotime($mydocument['created_date'])) ?></p>
                                <footer class="blockquote-footer text-danger"><a class="badge badge-secondary badge-lg" target="_blank" href="<?= base_url('assets/document/' .$namafolder.'/'. $mydocument['file_signature']); ?>">Lihat Dokumen</a></footer>
                            </blockquote>
                        </div>
                  </div>
                <div>
                <form id="formemail">
                <input class="form-control" type="hidden" id="namapengirim" name="namapengirim" value="<?= $users_name['nama'] ?>">
                <input class="form-control" type="hidden" id="iddoc" name="iddoc" value="<?= $mydocument['id_document'] ?>">
                <input class="form-control" type="hidden" id="idprojectemail" name="idprojectemail" value="<?= $this->uri->segment(3) ?>">
                <input class="form-control" type="hidden" id="statuspage" name="statuspage" value="<?= $state ?>">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="subjectemail" class="form-control-label">Subject</label>
                        <input class="form-control" type="text" id="subjectemail">
                      </div>
                    </div>
                   
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="subjectemail" class="form-control-label">File</label>
                        <input class="form-control" type="text" value="<?= $mydocument['file_signature'] ?>" id="fileemail">
                      </div>
                    </div>

                    <div class="col-lg-5">
                      <div class="form-group">
                          <label for="send-user-select" class="form-control-label">Kirim Ke</label>
                          <select id="send-user-select" name="sendemail" class="form-control add-email">
                            <option value="">- Pilih User -</option>
                            <?php foreach ($users as $us) : ?>
                                <?php if ($us['state'] == '2') { ?>
                                    <option value="<?= $us['email']; ?>" data-profile="<?= $us['foto']; ?>"><?= $us['username']; ?> (<?= $us['nama'] ?>)</option>
                                <?php } ?>
                            <?php endforeach; ?>
                          </select>
                      </div>
                      <div id="send-badges"></div>
                   
                    </div>
                    <div class="col-lg-1">
                      <button class="btn btn-icon btn-primary mt-4" type="button" id="addusersend">
                        <span class="btn-inner--icon"><i class="fas fa-plus-square"></i></span>
                      </button>
                    </div>
       
                  <div class="col-lg-5">
                      <div class="form-group">
                          <label for="cc-user-select" class="form-control-label">Tambahkan CC</label>
                          <select id="cc-user-select" name="ccemail" class="form-control add-email">
                            <option value="">- Pilih User -</option>
                            <?php foreach ($users as $us) : ?>
                                <?php if ($us['state'] == '2') { ?>
                                    <option value="<?= $us['email']; ?>" data-profile="<?= $us['foto']; ?>"><?= $us['username']; ?> (<?= $us['nama'] ?>)</option>
                                <?php } ?>
                            <?php endforeach; ?>
                          </select>
                      </div>
                      <div id="cc-badges"></div>
                   
                    </div>
                    <div class="col-lg-1">
                      <button class="btn btn-icon btn-primary mt-4" type="button" id="addusercc">
                        <span class="btn-inner--icon"><i class="fas fa-plus-square"></i></span>
                      </button>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="pesanText">Tambahkan Pesan</label>
                        <textarea class="form-control" id="pesanText" rows="3"></textarea>
                      </div>
                    </div>
                  </div>

                  <button class="btn btn-icon btn-primary rounded-pill" type="submit">
                    <span class="btn-inner--icon"><i class="ni ni-curved-next"></i></span>
                      <span class="btn-inner--text">Kirim Email</span>
                  </button>
                  <!-- <?php if($state == 'alldoc'){ ?>
                  <a href="<?= base_url("document/seedocument/") . $mydocument['id_document'] ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                    <span class="btn-inner--text">Kembali</span>
                  </a>
                  <?php } else { ?>
                    <a href="<?= base_url("document/index/") . $this->uri->segment(3) ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                    <span class="btn-inner--text">Kembali</span>
                  </a>
                  <?php } ?> -->
                  
                 
                </form>
                </div>
                                        
                </div>
            </div>
        </div>
    </div>

   