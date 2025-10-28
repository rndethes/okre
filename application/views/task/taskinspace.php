<div id="roomspace"></div>
<div id="taskspace"></div>
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
           <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
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
  
          <ul class="nav nav-pills-edit nav-fill flex-column flex-sm-row" id="tabs-text-tabnav" role="tablist">
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-1-tabnav" href="<?= base_url("project/projectAtWorkspace/") . $this->session->userdata('workspace_sesi') ?>" role="tab" aria-controls="tabs-text-1" aria-selected="true">OKR</a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-3-tabnav" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false">Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tabnav" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-2" aria-selected="false">Document</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-5-tabnav" href="<?= base_url("notes/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-5" aria-selected="false">Sketch</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-4-tab" href="<?= base_url("workspace/chatspace/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-4" aria-selected="true">Chat</a>
            </li>
          </ul>
        </div> 
      </div> 
    </div> 
  
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
        <div class="row mb-2">
            <div class="col-6">
                <div class="card pt-2">
                    <div class="row m-3">
                        <div class="col-sm-4">
                            <img src="<?= base_url() ?>assets/img/jabatanimg.png" style="width:150px;" class="img-fluid border-radius-lg">
                        </div>
                        <div class="card-body pt-2">
                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">okr</span>
                                <a type="button" class="card-title h2 d-block text-darker" data-toggle="modal" data-target="#taskOKRModal">
                                Task From OKR
                                </a>
                          </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="taskOKRModal" tabindex="-1" role="dialog" aria-labelledby="taskOKRModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskOKRModalLabel">Ambil Task Dari OKR</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?= form_open_multipart('task/inputTask', 'class="form-inputtask"'); ?>
                        <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="projectid">Pilih OKR</label>
                                            <select class="form-control" id="projectid" name="projectid">
                                                <option value="">Pilih OKR</option>
                                                <?php foreach($projectspace as $projectspace) { ?>
                                                <option value="<?= $projectspace['id_project'] ?>"><?= $projectspace['nama_project'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <small class="text-danger">*Pilih OKR Terlebih dahulu !</small><br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            
                                            <label for="keyresultselect">Key Result</label>
                                            <select class="form-control" id="keyresultselect" name="keyresultselect">
                                                <option value="">Pilih Key Result</option>
                                                <?php foreach($mykey as $mykey) { ?>
                                                <option value="<?= $mykey['id_kr'] ?>"><?= $mykey['nama_kr'] ?> (<?= $mykey['description_okr'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <button class="btn btn-icon btn-primary rounded-pill" type="button" id="proseskr" disabled>
                                            <span class="btn-inner--text">Proses</span>
                                        </button>
                                        <button class="btn btn-icon btn-info rounded-pill" type="button" id="cekinisiative" disabled>
                                            <span class="btn-inner--text">Cek Inisiative</span>
                                        </button>
                                    </div>
                                    <div class="col-lg-6" id="inisiative-container" style="display: none;">
                                        <div class="form-group">
                                            <label for="inisiativeselect">Inisiative</label>
                                            <select class="form-control" id="inisiativeselect" name="inisiativeselect">
                                                <option value="">Pilih Inisiative</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <button class="btn btn-icon btn-primary rounded-pill" type="button" id="prosesini" style="display: none;">
                                            <span class="btn-inner--text">Proses</span>
                                        </button>
                                        <button class="btn btn-icon btn-danger rounded-pill" type="button" id="hapusini" style="display: none;">
                                            <span class="btn-inner--text">Hapus</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" id="idselected" name="idselected">
                                    <input type="hidden" id="idprojecttask" name="idprojecttask" value="<?= $this->uri->segment(4) ?>">
                                    <input type="hidden" id="namaselected" name="namaselected">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Nama Task</label>
                                                <input class="form-control" type="text" id="namatask" name="namatask">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Tanggal Awal</label>
                                                <input class="form-control" type="datetime-local" id="tanggalawal" name="tanggalawal">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Tanggal Akhir</label>
                                                <input class="form-control" type="datetime-local" id="tanggalakhir" name="tanggalakhir">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">Tipe</label>
                                                        <select class="form-control" id="classificationtask" name="classificationtask">
                                                            <option value="transaction">Transaksi</option>
                                                            <option value="document">Dokumen</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">User</label>
                                            <select class="form-control" id="userselect" name="userselect" required>
                                                <option value="">Pilih User</option>
                                                <?php foreach ($users as $us) : ?>
                                                    <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="desokr" class="form-control-label">Desc</label>
                                                    <div id="desokr"> 
                                                    </div>
                                                    <input type="hidden" id="describeokr" name="describeokr">
                                            </div>
                                        </div>
                                    </div>
                                <?php   
                                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
                                        $myurl = "https://";   
                                    } else { 
                                        $myurl = "http://";  
                                    }                                    
                                    // Append the host(domain name, ip) to the myURL.   
                                    $myurl.= $_SERVER['HTTP_HOST'];   
                                    // Append the requested resource location to the myURL   
                                    $myurl.= $_SERVER['REQUEST_URI'];   
                                    ?>  
                                <input type="hidden" name="myurl" value="<?= $myurl ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
                            <button type="submit" id="simpantask" class="btn btn-success rounded-pill">Simpan</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card pt-2">
                        <div class="row m-3">
                            <div class="col-sm-4">
                                <img src="<?= base_url() ?>assets/img/teamf.png" style="width:150px;" class="img-fluid border-radius-lg">
                                    </div>
                                        <div class="card-body pt-2">
                                        <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Private</span>
                                            <a type="button" data-toggle="modal" data-target="#privateTaskModal" class="card-title h2 d-block text-darker">
                                             Tambah Task
                                            </a>
                                        </div>
                                    </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="privateTaskModal" tabindex="-1" role="dialog" aria-labelledby="privateTaskModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="privateTaskModalLabel">Input Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <div class="modal-body">
                                        <form id="taskForm">
                                            <div class="row">
                                            <input type="hidden" id="idprjpvt" name="idprjpvt" value="<?= $this->uri->segment(4); ?>">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="namataskpvt" class="form-control-label">Nama Task</label>
                                                        <input class="form-control" type="text" id="namataskpvt" name="namataskpvt">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="overduepvt" class="form-control-label">Start</label>
                                                        <input class="form-control" type="datetime-local" id="startpvt" name="startpvt" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="overduepvt" class="form-control-label">Overdue</label>
                                                        <input class="form-control" type="datetime-local" id="overduepvt" name="overduepvt">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">User To</label>
                                                        <select class="form-control" id="userselectpvt" name="userselectpvt">
                                                            <option value="">Pilih User</option>
                                                            <?php foreach ($users as $us) : ?>
                                                                <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">Tipe</label>
                                                        <select class="form-control" id="classificationtask" name="classificationtask">
                                                            <option value="transaction">Transaksi</option>
                                                            <option value="document">Dokumen</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label text-danger">*Jadikan sebagai pertemuan?</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input task" type="checkbox" id="meetingCheckbox" name="jadikanmeeting" value="1">
                                                            <label class="form-check-label task" for="jadikanmeeting">Jadikan Meeting?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="descpvt" class="form-control-label">Desc</label>
                                                        <div id="descpvt"> 
                                                        </div>

                                                        <input type="hidden" id="describeprivate" name="describeprivate">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="myurlpvt" value="<?= $myurl ?>">
                                            </div>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success rounded-pill">Simpan</button>
                                </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                  
        
        </div>
        <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
              <h2 class="mb-0" style="padding-left: 15px;">Task In Space</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <ul class="nav nav-pills nav-fill flex-column flex-sm-row mb-4" id="tabs-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link navtask mb-sm-3 mb-md-0 active" id="tabs-text-1-tab" data-toggle="tab" href="#tabs-text-1" role="tab" aria-controls="tabs-text-1" aria-selected="true" data-status="1" data-prj="<?= $this->uri->segment(4) ?>" data-space="<?= $this->uri->segment(3) ?>"  data-stateacctive="<?= $this->uri->segment(4) ?>">On Going</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtask mb-sm-3 mb-md-0" id="tabs-text-2-tab" data-toggle="tab" href="#tabs-text-2" role="tab" aria-controls="tabs-text-2" aria-selected="false"  data-status="3" data-prj="<?= $this->uri->segment(4) ?>" data-space="<?= $this->uri->segment(3) ?>"  data-stateacctive="<?= $this->uri->segment(4) ?>">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtask mb-sm-3 mb-md-0" id="tabs-text-3-tab" data-toggle="tab" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false"  data-status="4" data-prj="<?= $this->uri->segment(4) ?>" data-space="<?= $this->uri->segment(3) ?>"  data-stateacctive="<?= $this->uri->segment(4) ?>">Reject</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtask mb-sm-3 mb-md-0" id="tabs-text-4-tab" data-toggle="tab" href="#tabs-text-4" role="tab" aria-controls="tabs-text-3" aria-selected="false"  data-status="2" data-prj="<?= $this->uri->segment(4) ?>" data-space="<?= $this->uri->segment(3) ?>"  data-stateacctive="<?= $this->uri->segment(4) ?>">Complete</a>
                </li>
            </ul>

                            <div class="table-responsive">
                                <div>
                                    <table class="table align-items-center" id="tabOnGoing" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col" class="sort" data-sort="tanggalpengajuan">Tanggal Pengajuan</th>
                                                <th scope="col" class="sort" data-sort="duedate">Due Date</th>
                                                <th scope="col" class="sort" data-sort="type">Type</th>
                                                <th scope="col" class="sort" data-sort="purpose">Purpose</th>
                                                <th scope="col" class="sort" data-sort="desc">Desc</th>
                                                <th scope="col" class="sort" data-sort="taskof">Task Of</th>
                                                <th scope="col" class="sort" data-sort="taskto">Task To</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <table class="table align-items-center" id="tabPending" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col" class="sort" data-sort="tanggalpengajuan">Tanggal Pengajuan</th>
                                                <th scope="col" class="sort" data-sort="duedate">Due Date</th>
                                                <th scope="col" class="sort" data-sort="type">Type</th>
                                                <th scope="col" class="sort" data-sort="purpose">Purpose</th>
                                                <th scope="col" class="sort" data-sort="desc">Desc</th>
                                                <th scope="col" class="sort" data-sort="taskof">Task Of</th>
                                                <th scope="col" class="sort" data-sort="taskto">Task To</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <table class="table align-items-center" id="tabReject" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                            <th scope="col"></th>
                                                <th scope="col" class="sort" data-sort="tanggalpengajuan">Tanggal Pengajuan</th>
                                                <th scope="col" class="sort" data-sort="duedate">Due Date</th>
                                                <th scope="col" class="sort" data-sort="type">Type</th>
                                                <th scope="col" class="sort" data-sort="purpose">Purpose</th>
                                                <th scope="col" class="sort" data-sort="desc">Desc</th>
                                                <th scope="col" class="sort" data-sort="taskof">Task Of</th>
                                                <th scope="col" class="sort" data-sort="taskto">Task To</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div>
                                    <table class="table align-items-center" id="tabComplete" style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                            <th scope="col"></th>
                                                <th scope="col" class="sort" data-sort="tanggalpengajuan">Tanggal Pengajuan</th>
                                                <th scope="col" class="sort" data-sort="duedate">Due Date</th>
                                                <th scope="col" class="sort" data-sort="type">Type</th>
                                                <th scope="col" class="sort" data-sort="purpose">Purpose</th>
                                                <th scope="col" class="sort" data-sort="desc">Desc</th>
                                                <th scope="col" class="sort" data-sort="taskof">Task Of</th>
                                                <th scope="col" class="sort" data-sort="taskto">Task To</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
              
           
        
            </div>
          </div>
        </div>
      </div>
     

        <!-- Modal -->
            <div class="modal fade" id="checkOKRModal" tabindex="-1" role="dialog" aria-labelledby="checkOKRModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkOKRModalLabel">Terhubung ke</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id="modalContent">Loading...</div>

                
                </div>
                </div>
            </div>
            </div>

            
            
 

         
 
              

                      