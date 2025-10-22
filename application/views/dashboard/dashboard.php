<div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(<?= base_url(); ?>/assets/img/theme/office.jpg); background-size: cover; background-position: center top;">
  <span class="mask bg-gradient-default opacity-8">
  </span>
  <!-- Header container -->
  <div class="container-fluid ">
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
      <div class="col-lg-6 col-5 text-right">
      </div>
    </div>
    <div class="row">
      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Space</h5>
                <span class="h2 font-weight-bold mb-0"><?= $count_space; ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                  <i class="ni ni-chart-bar-32"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              <!-- <span class="text-nowrap">Since last month</span> -->
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">OKR</h5>
                <span class="h2 font-weight-bold mb-0"><?= $count_okr; ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                  <i class="ni ni-circle-08"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              <!-- <span class="text-nowrap">Since last month</span> -->
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Task Waiting</h5>
                <span class="h2 font-weight-bold mb-0"><?= $count_task; ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                  <i class="ni ni-single-02"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              <!-- <span class="text-nowrap">Since last month</span> -->
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
          <!-- Card body -->
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Document Waiting</h5>
                <span class="h2 font-weight-bold mb-0"><?= $count_document; ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                  <i class="ni ni-building"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
              <!-- <span class="text-nowrap">Since last month</span> -->
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid d-flex align-items-center">
      <div class="row">
        <div class="col-12">
          <h1 class="display-6 text-white">Halo! <?php echo $this->session->userdata('nama'); ?> <span style='font-size:30px;'>&#128522;</span></h1>
          <p class="text-white mt-0 mb-4">Selamat datang di Dashboard OKR'e</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col">
      <div class="row mt-4">
      
      
        <div class="col-lg-12">
          
              <div class="card">
                <div class="card-header border-0 d-flex">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-tasks"></i>
                  </div>
                  <h2 class="mb-0 mt-2 ml-2">Next Project Schedule</h2>
                </div>
                <div class="row" style="padding: 0px;">
                  <div class="card-body p-3">
                  <div class="col-lg-12">
                    <?php if ($next_schedule) : ?>
                      <div class="alert alert-default alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="fas fa-bell"></i></span>
                        <span class="alert-text"><strong>Next Project yang masih berjalan!</strong> <?= $next_schedule['name_task']; ?>  </span>
                        <a href="<?= base_url(); ?>calendar/viewall" class="btn btn-icon btn-secondary btn-sm"><span class="btn-inner--icon"><i class="ni ni-calendar-grid-58"></i></span><span class="btn-inner--text">Lihat Jadwal</span></a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php else : ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-bell-55"></i></span>
                        <span class="alert-text"><strong>Next Project -</strong>
                          <br>
                          <b>Kosong</b>
                        </span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
                </div>
              </div>  
            </div>  
            <div class="col-lg-6">
              <div class="card card-frame dschard">
                  <div class="card-header border-0">
                    <div class="row align-items-center">
                      <div class="col">
                        <h2 class="mb-0 mt-2 ml-2">Document Waiting</h2>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive dsdocwaiting">
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="name">Nama Dokumen</th>
                                            <th scope="col" class="sort" data-sort="status">Space</th>
                                            <th scope="col" class="sort" data-sort="status">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                      <?php foreach($mydocument as $mydocument) { 
                                      
                                        $CI = &get_instance();
                                        $CI->load->model('Account_model');
                                        $CI->load->model('Space_model');

                                        $idodc = $mydocument['id_document'];

                                        $ceksignature = $CI->Space_model->checkSignatureById($idodc);
                                        $allsign      = $CI->Space_model->checkAllSignatureFile($idodc);
                                        $iduserscek = $this->session->userdata('id');
                                        $checkAllAprove = $CI->Space_model->DataAllAprove($idodc);

                                        if(empty($ceksignature)) {
                                          $nama ="";
                                          
                                        } else {
                                          $usermy_id = $mydocument['id_user_create'];

                                          $usersdoc     = $CI->Account_model->getAccountById($usermy_id);
                                          $logterakhir  = $CI->Space_model->logTerakhir($idodc);
                                          $checkSign    = $CI->Space_model->checkUserSignature($iduserscek,$idodc);
                                    
                                            $nama = $usersdoc['nama'];
                                            $idusesign = $checkSign;
                                          }
                                        ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <span class="name mb-0 text-sm"><?= $mydocument['name_document'] ?></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                              <span class="name mb-0 text-sm"><?= $mydocument['name_space'] ?></span>
                                            </td>
                                            <td>
                                              <?php if($mydocument['status_document'] == '5') { ?>
                                                    <span class="badge badge-pill badge-warning">Revisi</span>
                                              <?php } else { ?>
                                                <?php if(empty($ceksignature)) { ?>
                                                  <span class="badge badge-pill badge-warning">Pembuatan</span>
                                                <?php } else { ?>
                                                  <?php if($mydocument['status_document'] != '4') { ?>
                                                      <?php if($checkAllAprove['conclusion'] == "NotApprove") {  ?>
                                                          <?php if($logterakhir['status_log'] == '1') { ?>
                                                                <span class="badge badge-pill badge-info">Menunggu</span>
                                                          <?php } else if($logterakhir['status_log'] == '2') { ?>
                                                              <span class="badge badge-pill badge-success">Approve By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                                          <?php } else if($logterakhir['status_log'] == '3') { ?>
                                                              <span class="badge badge-pill badge-danger">Reject By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                                          <?php } else if($logterakhir['status_log'] == '4') { ?>
                                                              <span class="badge badge-pill badge-warning">Revisi By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                                          <?php } else { ?>
                                                                <span class="badge badge-pill badge-warning">Created By By <?= $logterakhir['nama_log'] ?> At <?= date("Y-m-d H:i",strtotime($logterakhir['updated_date_doc_signature'])) ?></span>
                                                          <?php } ?>
                                                      <?php } else { ?>
                                                        <span class="badge badge-pill badge-success">All Approve</span>
                                                      <?php } ?>
                                                    <?php } else { ?>
                                                        <span class="badge badge-pill badge-success">Publish At <?= date("Y-m-d H:i",strtotime($my['publish_at'])) ?></span>
                                                    <?php } ?>
                                                <?php } ?>
                                              <?php } ?>
                                            </td>
                                            <td>
                                              <a href="<?= base_url("document/index/") . $mydocument['id_space'] . '/space' ?>" class="btn btn-warning btn-sm rounded-pill">
                                                <span class="btn--inner-icon">
                                                <span class="btn-inner--text">Lihat Data</span>
                                              </a>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        
                </div>
           </div>
           <div class="col-lg-6">
                <div class="card card-frame">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                    <div class="col">
                        <h2 class="mb-0 mt-2 ml-2">Task Waiting</h2>
                    </div>
                        <!-- <div class="col text-right">
                        <a href="#!" class="btn btn-sm btn-primary">Lihat Dokumen Publis</a>
                        </div> -->
                    </div>
                </div>
                    <div class="card-body">
                    <ul class="list-group list-group-flush list my--3">
                          <?php foreach($mytask as $myt) { 
                            if($myt['status_task'] == '1') {
                                $status = '<small class="text-info">On Going</small>';
                            }
                          ?>
                          <li class="list-group-item px-2">                   
                              <div class="row align-items-center">
                                  <div class="col ml--2">
                                      <h4 class="mb-0">
                                          <div><?= $myt['name_task'] ?></div>
                                      </h4>
                                      <span class="text-info">●</span>
                                      <small><?= $status ?></small>
                                  </div>
                                  <div class="col-auto">
                                    <a href="<?= base_url("task/index/") . $myt['task_in_space'] . '/space' ?>" class="btn btn-warning btn-sm rounded-pill">
                                        <span class="btn--inner-icon">
                                        <span class="btn-inner--text">Lihat Data</span>
                                    </a>
                                  </div>
                              </div>
                          </li> 
                        <?php } ?>
                    </ul>
                    </div>
                    
                    
                </div>
           </div>

           <div class="col-lg-8">
            <div class="card">
              <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                      <h3 class="mb-0">Progress OKR</h3>
                    </div>
                  </div>
              </div> 
                <div class="card-body">    
                      <div class="chart">
                          <canvas id="chart-bars" class="chart-canvas"></canvas>
                      </div>
                </div>
              </div>
        </div>
       <div class="col-lg-4">
          <div class="card">        
            <div class="card-header">
              <h5 class="h3 mb-0">Status Task</h5>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="chart-doughnut" class="chart-canvas "></canvas>
                </div>
            </div> 
         </div>
      </div>
    </div>  
  </div>  
</div>
  

     

     
      

      





 