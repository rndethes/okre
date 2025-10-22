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
  <div class="row">
  <div class="col-xl-1 minimized-chat" id="chat-column">
      <div class="card card-frame">
        <div class="card-header">
        <div class="row align-items-center">
          <div class="col">
          <h3 class="mb-0">Chat Room</h3>
          </div>
          <div class="col">
          <ul class="nav nav-pills justify-content-end">
          <li class="nav-item mr-2 mr-md-0">
            <button id="hidechat" type="button" class="btn btn-lg rounded-pill btn-danger">
              <i class="ni ni-bold-left"> </i>
            </button>
          </li>
          
          </ul>
          </div>
          </div>
          
            <input type="hidden" id="myuserid" class="form-control" value="<?= $this->session->userdata('id'); ?>">
            <input type="hidden" id="myprojectid" class="form-control" value="<?= $this->uri->segment(3); ?>">
            <input type="hidden" id="hidden-link" class="form-control hidden-link">
          
        </div>
        <?php if(!empty($chat)) { ?>
          <input type="hidden" id="idroomchat" class="form-control" value="<?= $chat['id_mcr']; ?>">
        <div class="card-body">
         
            <div id="chat-window" class="overflow-auto" style="height: 400px;">
              <!-- Chat Messages -->
              <div class="d-flex justify-content-end mb-2">
                                
            </div>
          </div>
        <div class="card-footer">
            <div id="mention-dropdown" class="list-group" style="display: none;">
               <!-- Daftar mention akan diisi melalui JavaScript -->
            </div>
                        <div class="input-group mb-2">
                       
                          <!-- <input type="text" id="message" class="form-control" placeholder="Type your message..." required> -->

                          <textarea class="form-control" id="message" rows="3"></textarea>

                        </div>
                        <button type="button" id="send-btn" data-userid="<?= $this->session->userdata('id'); ?>" class="btn btn-default">Send</button>
                   
          </div>
        </div>
        <?php } else { ?>
          <div class="card-body">
            <a href="<?= base_url("workspace/tambahChat/") .  $this->session->userdata('workspace_sesi') . "/" . $this->uri->segment(3) . "/" . $project['nama_project'] ?>"  class="btn btn-icon btn-primary">
              <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                <span class="btn-inner--text">Tambah Chat</span>
            </a>
          </div>

        <?php } ?>
    </div>
    </div>
    <div class="col-xl-12" id="main-column">
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
                                        <button class="btn btn-icon btn-primary rounded-pill" type="button" id="proseskr">
                                            <span class="btn-inner--text">Proses</span>
                                        </button>
                                        <button class="btn btn-icon btn-info rounded-pill" type="button" id="cekinisiative">
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
                                    <input type="hidden" id="idprojecttask" name="idprojecttask" value="<?= $this->uri->segment(3) ?>">
                                    <input type="hidden" id="namaselected" name="namaselected">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Nama Task</label>
                                                <input class="form-control" type="text" id="namatask" name="namatask" readonly>
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
                                            <label for="example-text-input" class="form-control-label">User</label>
                                            <select class="form-control" id="userselect" name="userselect">
                                                <option value="">Pilih User</option>
                                                <?php foreach ($users as $us) : ?>
                                                    <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
                                            <input type="hidden" id="idprjpvt" name="idprjpvt" value="<?= $this->uri->segment(3); ?>">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="namataskpvt" class="form-control-label">Nama</label>
                                                        <input class="form-control" type="text" id="namataskpvt" name="namataskpvt" required>
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
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">User To</label>
                                                        <select class="form-control" id="userselectpvt" name="userselectpvt" required>
                                                            <option value="">Pilih User</option>
                                                            <?php foreach ($users as $us) : ?>
                                                                <option value="<?= $us['id']; ?>"><?= $us['nama']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
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
              <h2 class="mb-0" style="padding-left: 15px;">Task</h2>
              <?php $role_id = $this->session->userdata('role_id') ?>
              <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true" data-status="1" data-prj="<?= $this->uri->segment(3) ?>"  data-stateacctive="<?= $this->uri->segment(4) ?>"><i class="fas fa-sync-alt mr-2"></i>On Going</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false" data-status="3" data-prj="<?= $this->uri->segment(3) ?>" data-stateacctive="<?= $this->uri->segment(4) ?>"><i class="fas fa-print mr-2"></i>Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" data-status="4" data-prj="<?= $this->uri->segment(3) ?>" data-stateacctive="<?= $this->uri->segment(4) ?>"><i class="ni ni-bell-55 mr-2"></i>Reject</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" data-status="2" data-prj="<?= $this->uri->segment(3) ?>" data-stateacctive="<?= $this->uri->segment(4) ?>"><i class="fas fa-check-double mr-2"></i>Complete</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <ul class="list-group list-group-flush list my--3"></ul>
                        </div>
                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                            <ul class="list-group list-group-flush list my--3"></ul>
                        </div>
                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <ul class="list-group list-group-flush list my--3"></ul>
                        </div>
                        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                            <ul class="list-group list-group-flush list my--3"></ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>


 
              

                      