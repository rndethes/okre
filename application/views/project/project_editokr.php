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
              <h3 class="mb-0">Edit Account</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('project/editOkr/' . $okr['id_okr']); ?>
          <div class="pl-lg-4">
            <input type="hidden" id="id_okr" name="id_okr" class="form-control" value="<?= $okr['id_okr']; ?>">
            <input type="hidden" id="id_project" name="id_project" class="form-control" value="<?= $okr['id_project']; ?>">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Nama Objective</label>
                  <input type="text" id="description_okr" name="description_okr" class="form-control" value="<?= $okr['description_okr']; ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Tanggal Akhir</label>
                  <input class="form-control" type="date" value="<?php echo date('Y-m-d', strtotime($okr["due_date"])) ?>" id="due_date" name="due_date">
                </div>
              </div>
              <div class="col-lg-10">
                 <div class="form-group">
                  <label class="form-control-label" for="exampleFormControlSelect1">Objective Priority</label>
                  <div class="style-toggle row">
                    <input type="radio" id="high" name="priority" value="3" class="btn btn-default d-none form-control">
                    <label for="high"><i class="fa fa-flag" style="color: #db2424;"></i></label>

                    <input type="radio" id="medium" name="priority" value="2" class="btn btn-default d-none form-control">
                    <label for="medium"><i class="fa fa-flag" style="color: #ffea00;"></i></label>

                    <input type="radio" id="low" name="priority" value="1" class="btn btn-default d-none form-control">
                    <label for="low"><i class="fa fa-flag" style="color: #29dbff;"></i></label>

                    <input type="radio" id="lowest" name="priority" value="0" class="btn btn-default d-none form-control">
                    <label for="lowest"><i class="fa fa-flag" style="color: #d1d1d1;"></i></label>
                  </div>
                  <button type="button" class="btn btn-dark-primary mb-2 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                    <span class="btn-inner--text">Pilih Tugas</span>
                  </button>
                  <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Pilih Tugas</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                            <div class="modal-body">
                                <div class="row">                            
                                  <div class="col-6">
                                  <div class="card">
                                      <div class="card-header">
                                        <h3>Key Result</h3>
                                      </div>
                                      <div class="card-body">
                                      <?php if (empty($id_kr)) { ?>
                                        <h4>Data tidak ditemukan!</h4>
                                      <?php } else { ?>
                                    <?php foreach($id_kr as $kr) {?>
                                      <div class="my-3">
                                      <label>
                                          <input type="checkbox" name="kuadran[]" value="<?= $kr['id_kr']; ?>">
                                          <?= $kr['nama_kr']; ?>
                                      </label>
                                      </div>
                                    <?php } ?>
                                    <?php } ?>
                                    </div>
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3>Initiative</h3>
                                      </div>
                                      <div class="card-body">
                                      <?php if (empty($id_initiative)) { ?>
                                        <h4>Data tidak ditemukan!</h4>
                                      <?php } else { ?>
                                  <?php foreach($id_initiative as $init) {?>
                                    <div class="my-3">
                                      <label>
                                          <input type="checkbox" name="kuadran[]" value="<?= $init['id_initiative']; ?>">
                                          <?= $init['description']; ?>
                                      </label>
                                    </div>
                                  <?php } ?>
                                  <?php } ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div> 
                            <div class="modal-footer">
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
              </div>    
            </div>
            <div class="row">
              <div class="col-lg-2">
                <button class="btn btn-icon btn-default rounded-pill" type="submit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Edit</span>
                </button>
              </div>
              <div class="col-lg-3">
                <a href="<?= base_url(); ?>project/showOkr/<?= $okr['id_project']; ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Kembali</span>
                </a>
              </div>
            </div>
          </div>

          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>