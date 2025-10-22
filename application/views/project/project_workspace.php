<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
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
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-1">All Project di Workspace <?= $space['name_space'] ?></h1>
                <h6 class="heading-small text-muted mb-4">Data Semua Project</h6>
            </div>
          </div>
          <div class="row topCard">

            <div class="col-lg-3">
              <button type="button" class="btn btn-default mb-4 rounded-pill" data-toggle="modal" data-target="#tambahModal">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Create New Project</span>
              </button>
              <!-- Modal -->
              <!-- Modal -->
              <div class=" modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <small class="text-danger pl-4">*Semua Kolom Wajib Diisi</small>
                    <?= form_open_multipart('project/inputProject/' . $space['id_space']); ?>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">Project Title</label>
                            <input type="text" id="nama_project" name="nama_project" class="form-control" placeholder="Softwere Development" required>
                          </div>
                        </div>
   
                      </div>
                      <div class="row">
                
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">Project Priority</label>
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
                          </div>
                        </div>
     
                      </div>
                      <div class="row">
   
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label for="example-date-input" class="form-control-label">From</label>
                            <input class="form-control" type="date" value="<?= date("Y/m/d") ?>" id="tanggal_awal_project" name="tanggal_awal_project" required>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label for="example-date-input" class="form-control-label">To</label>
                            <input class="form-control" type="date" value="<?= date("Y/m/d") ?>" id="tanggal_akhir_project" name="tanggal_akhir_project" required>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label">Description</label>
                            <textarea rows="4" class="form-control" id="description_project" name="description_project" placeholder="Description Project..."></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlSelect1">File</label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="file" name="file" lang="en" accept=".pdf,.jpg">
                              <label class="custom-file-label" for="customFileLang">Select file</label>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col-lg-3">
                          <button class="btn btn-icon btn-default" type="submit">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah</span>
                          </button>
                        </div>
                      </div>
                    </div>

                    <?= form_close(); ?>
                  </div>
                  <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card table">
          <div class="table-responsive">
            <div>
              <table id="myTableWorkSpace" class="table align-items-center">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">No</th>
                    <th scope="col" class="sort" data-sort="name">ID Project</th>
                    <th scope="col" class="sort" data-sort="name">Project</th>
                    <!-- <th scope="col" class="sort" data-sort="name">Departement</th> -->
                    <th scope="col" class="sort" data-sort="name">Priority</th>
                    <th scope="col" class="sort" data-sort="name">Team</th>
                    <th scope="col" class="sort" data-sort="budget">Start</th>
                    <th scope="col" class="sort" data-sort="status">Deadline</th>
                    <th scope="col" class="sort" data-sort="completion">Progress</th>
                  
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                </tbody>
              </table>
            </div>

          </div>

        </div>
        <div class="row mt-3" style="padding: 20px;">
          <div class="col-lg-3">
          <button onclick="goBackToPreviousPage()" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
              </button>
          </div>
        </div>

      </div>
    </div>


    