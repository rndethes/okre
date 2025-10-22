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
              <h3 class="mb-0">Edit Task</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
            <?php if($task['type_task'] == "private" || $task['type_task'] == "meeting") { ?>
                <form id="editTaskForm">
                                            <div class="row">
                                            <input type="hidden" id="idtask" name="idtask" value="<?= $task['id_task'] ?>">
                                            <input type="hidden" id="idprjpvt" name="idprjpvt" value="<?= $this->uri->segment(3); ?>">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="namataskpvt" class="form-control-label">Nama</label>
                                                        <input class="form-control" type="text" id="namataskpvt" name="namataskpvt" value="<?= $task['name_task'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="startpvt" class="form-control-label">Start</label>
                                                        <input class="form-control" type="datetime-local" id="startpvt" name="startpvt" value="<?= date('Y-m-d H:i',strtotime($task['start_task'])) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="overduepvt" class="form-control-label">Overdue</label>
                                                        <input class="form-control" type="datetime-local" id="overduepvt" name="overduepvt" value="<?= date('Y-m-d H:i',strtotime($task['overdue_task'])) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">User To</label>
                                                        <select class="form-control" id="userselect" name="userselect">
                                                            <?php $idus = $task['user_to_task']; ?>
                                                                <?php foreach ($users as $key => $us) : ?>
                                                                <?php if ($idus == $us["id"]) { ?>
                                                                    <option value="<?= $us['id']; ?>" selected>
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } else { ?>
                                                                    <option value="<?= $us['id']; ?>">
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userselectpvt" class="form-control-label">Tipe</label>
                                                        <select class="form-control" id="classificationtask" name="classificationtask">
                                                            <?php if($task['classification_task'] == NULL) { ?>
                                                                <option value="NULL" selected>- Belum Dipilih - </option>
                                                            <?php } ?>
                                                                <option value="transaction" <?= $task['classification_task'] == 'transaction' ? 'selected' : '' ?>>Transaksi</option>
                                                                <option value="document" <?= $task['classification_task'] == 'document' ? 'selected' : '' ?>>Dokumen</option>
                                                                <option value="meeting" <?= $task['classification_task'] == 'meeting' ? 'selected' : '' ?>>Meeting</option>
                                                                <option value="other" <?= $task['classification_task'] == 'other' ? 'selected' : '' ?>>Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="descpvt" class="form-control-label">Desc</label>
                                                        <div id="descpvt"> 
                                                            <?= $task['desc_task'] ?>
                                                        </div>
                                                        <input type="hidden" id="describeprivate" name="describeprivate">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($task['task_in'] == "0") { ?>
                                            <input type="hidden" id="linkurlback" name="linkurlback" value="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . '/space' ?>">
                                            <?php } else { ?>
                                                <input type="hidden" id="linkurlback" name="linkurlback" value="<?= base_url("task/index/") . $task['task_in'] ?>">
                                                <?php } ?>
                                            
                                           
                                       
                                    </div>
                                <div class="modal-footer">
                                <?php if($task['task_in'] == "0") { ?>
                                                <a type="button" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . '/space' ?>" class="btn btn-danger rounded-pill" data-dismiss="modal">Kembali</a>
                                            <?php } else { ?>
                                                <a type="button" href="<?= base_url("task/index/") . $task['task_in'] ?>" class="btn btn-danger rounded-pill" data-dismiss="modal">Kembali</a>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary rounded-pill">Edit</button>
                                </div>
                                </div>
                                </form>
                            <?php } else { ?>
                                <?= form_open_multipart('task/editTaskKey', 'class="form-inputtaskokr"' , 'id="editTask"'); ?>

                                    <?php if($this->uri->segment(5) == "space") { ?>
                                        <input type="hidden" name="myurl" value="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . '/space' ?>"></input>
                                    <?php } else { ?>
                                        <input type="hidden" name="myurl" value="<?= base_url("task/index/") . $task['task_in'] ?>" class="btn btn-danger rounded-pill"></input>
                                    <?php } ?>
                                                <div class="row">
                                                    <?php if($task['type_task'] == "keyresult") { ?>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="keyresultselect">Key Result</label>
                                                            <?php $idkr = $task['id_task_from']; ?>
                                                            <select class="form-control" id="keyresultselect" name="keyresultselect">
                                                                <?php foreach ($mykey as $key => $mykey) : ?>
                                                                <?php if ($idkr == $mykey["id_task_from"]) { ?>
                                                                    <option value="<?= $mykey['id_kr'] ?>" selected>
                                                                    <?= $mykey['nama_kr'] ?> (<?= $mykey['description_okr'] ?>)
                                                                    </option>
                                                                <?php } else { ?>
                                                                    <option value="<?= $mykey['id_kr'] ?>">
                                                                    <?= $mykey['nama_kr'] ?> (<?= $mykey['description_okr'] ?>)
                                                                    </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mt-4">
                                                        <button class="btn btn-icon btn-primary" type="button" id="proseskr">
                                                            <span class="btn-inner--text">Proses</span>
                                                        </button>
                                                        <button class="btn btn-icon btn-info" type="button" id="cekinisiative">
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
                                                        <button class="btn btn-icon btn-primary" type="button" id="prosesini" style="display: none;">
                                                            <span class="btn-inner--text">Proses</span>
                                                        </button>
                                                        <button class="btn btn-icon btn-danger" type="button" id="hapusini" style="display: none;">
                                                            <span class="btn-inner--text">Hapus</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                <input type="hidden" id="idtask" name="id_task" value="<?= $task['id_task'] ?>">
                                                    <input type="hidden" id="idselected" name="idselected" value="<?= $task['id_task_from'] ?>">
                                                    <input type="hidden" id="idprojecttask" name="idprojecttask" value="<?= $this->uri->segment(3) ?>">
                                                    <input type="hidden" id="namaselected" name="namaselected" value="keyresult">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Nama Task</label>
                                                                <input class="form-control" type="text" id="namatask" name="namatask" value="<?= $task['name_task'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="tanggalakhir" class="form-control-label">Tanggal Awal</label>
                                                        <input class="form-control" type="datetime-local" id="tanggalawal" name="tanggalawal" value="<?= date('Y-m-d H:i',strtotime($task['start_task'])) ?>">
                                                    </div>
                                                </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Tanggal Akhir</label>
                                                                <input class="form-control" type="datetime-local" id="tanggalakhir" value="<?= date('Y-m-d H:i',strtotime($task['overdue_task'])) ?>" name="tanggalakhir">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="example-text-input" class="form-control-label">User</label>
                                                            <select class="form-control" id="userselect" name="userselect">
                                                            <?php $idus = $task['user_to_task']; ?>
                                                          
                                                                <?php foreach ($users as $key => $us) : ?>
                                                                <?php if ($idus == $us["id"]) { ?>
                                                                    <option value="<?= $us['id']; ?>" selected>
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } else { ?>
                                                                    <option value="<?= $us['id']; ?>">
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                    <?php $typetask = $task['type_task']; ?>
                                                   
                                                    <?php 
                                                     $idini = $task['id_task_from'];
                                                      $CI = &get_instance();
                                                      $CI->load->model('Space_model');

                                                      $ini = $CI->Project_model->checkDataIni($idini);

                                                      $idkr = $ini['id_kr'];

                                                      $arrayini = $CI->Project_model->getInisiativesByKeyResultId($idkr);
                                                    
                                                    ?>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="keyresultselect">Key Result</label>
                                                                <select class="form-control" id="keyresultselect" name="keyresultselect">
                                                                    <?php foreach($mykey as $mykey) { ?>
                                                                        <?php if ($idkr == $mykey["id_kr"]) { ?>
                                                                            <option value="<?= $mykey['id_kr'] ?>" selected><?= $mykey['nama_kr'] ?> (<?= $mykey['description_okr'] ?>)</option>
                                                                        <?php } else { ?>
                                                                            <option value="<?= $mykey['id_kr'] ?>"><?= $mykey['nama_kr'] ?> (<?= $mykey['description_okr'] ?>)</option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="userselectpvt" class="form-control-label">Tipe</label>
                                                                <select class="form-control" id="classificationtask" name="classificationtask">
                                                                    <?php if($task['classification_task'] == NULL) { ?>
                                                                        <option value="NULL" selected>- Belum Dipilih - </option>
                                                                    <?php } ?>
                                                                    <option value="transaction" <?= $task['classification_task'] == 'transaction' ? 'selected' : '' ?>>Transaksi</option>
                                                                    <option value="document" <?= $task['classification_task'] == 'document' ? 'selected' : '' ?>>Dokumen</option>
                                                                    <option value="meeting" <?= $task['classification_task'] == 'meeting' ? 'selected' : '' ?>>Meeting</option>
                                                                    <option value="other" <?= $task['classification_task'] == 'other' ? 'selected' : '' ?>>Other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mt-4">
                                                            <button class="btn btn-icon btn-primary" type="button" id="proseskr">
                                                                <span class="btn-inner--text">Proses</span>
                                                            </button>
                                                            <button class="btn btn-icon btn-info" type="button" id="cekinisiative">
                                                                <span class="btn-inner--text">Cek Inisiative</span>
                                                            </button>
                                                        </div>

                                                        <div class="col-lg-6" id="inisiative-container">
                                                            <div class="form-group">
                                                                <label for="inisiativeselect">Inisiative</label>
                                                                <select class="form-control" id="inisiativeselect" name="inisiativeselect">
                                                                <?php foreach($arrayini as $arrayini) { ?>
                                                                    <?php if ($idini == $arrayini["id_initiative"]) { ?>
                                                                        <option value="<?= $arrayini['id_initiative'] ?>" selected><?= $arrayini['description'] ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?= $arrayini['id_initiative'] ?>"><?= $arrayini['description'] ?></option>
                                                                    <?php }  ?>
                                                                <?php }  ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mt-4">
                                                            <button class="btn btn-icon btn-primary" type="button" id="prosesini" style="display: none;">
                                                                <span class="btn-inner--text">Proses</span>
                                                            </button>
                                                            <button class="btn btn-icon btn-danger" type="button" id="hapusini" style="display: none;">
                                                                <span class="btn-inner--text">Hapus</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                   
                                                   
                                                <div class="row">
                                                    <input type="hidden" id="idtask" name="id_task" value="<?= $task['id_task'] ?>">
                                                    <input type="hidden" id="idselected" name="idselected" value="<?= $task['id_task_from'] ?>">
                                                    <input type="hidden" id="idprojecttask" name="idprojecttask" value="<?= $this->uri->segment(3) ?>">
                                                    <input type="hidden" id="namaselected" name="namaselected" value="initiative">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Nama Task</label>
                                                                <input class="form-control" type="text" id="namatask" name="namatask" value="<?= $task['name_task'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Tanggal Awal</label>
                                                                <input class="form-control" type="datetime-local" id="tanggalawal" value="<?= date('Y-m-d H:i',strtotime($task['start_task'])) ?>" name="tanggalawal">
                                                        </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Tanggal Akhir</label>
                                                                <input class="form-control" type="datetime-local" id="tanggalakhir" value="<?= date('Y-m-d H:i',strtotime($task['overdue_task'])) ?>" name="tanggalakhir">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="example-text-input" class="form-control-label">User</label>
                                                            <select class="form-control" id="userselect" name="userselect">
                                                                <option value="">Pilih User</option>
                                                                <?php $idus = $task['user_to_task']; ?>
                                                                <?php foreach ($users as $key => $us) : ?>
                                                                <?php if ($idus == $us["id"]) { ?>
                                                                    <option value="<?= $us['id']; ?>" selected>
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } else { ?>
                                                                    <option value="<?= $us['id']; ?>">
                                                                    <?= $us['nama']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                               
                                                   
                                                <?php } ?> 
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="desokr" class="form-control-label">Desc</label>
                                                        <div id="desokr"> 
                                                            <?= $task['desc_task'] ?>
                                                        </div>
                                                        <input type="hidden" id="describeokr" name="describeokr" value="<?= $task['desc_task'] ?>">
                                                    </div>
                                                </div>
                                                </div>
                                                
                                              
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <?php if($this->uri->segment(5) == "space") { ?>
                                                <a type="button" href="<?= base_url("task/index/") . $this->session->userdata('workspace_sesi') . '/space' ?>" class="btn btn-danger rounded-pill" data-dismiss="modal">Kembali</a>
                                            <?php } else { ?>
                                                <a type="button" href="<?= base_url("task/index/") . $task['task_in'] ?>" class="btn btn-danger rounded-pill" data-dismiss="modal">Kembali</a>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-primary rounded-pill">Edit</button>
                                        </div>
                                        </div>
                                        </form>

                            <?php } ?>
                        
                        </div>
                  
                    </div>


  

 