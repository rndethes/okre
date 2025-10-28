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
            <div class="col-lg-8">
            
              <h3 class="text-primary"> <button type="button" class="btn btn-facebook btn-icon-only">
                  <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
              </button> WORKSPACE <?= $space['name_space'] ?></h3>
                        
            
              
            </div>
            <div class="col-lg-4">
              <div class="d-flex">
              
                <button type="button" data-toggle="modal" data-target="#timSpaceModel" class="btn btn-warning rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-circle-08"></i></span>
                    <span class="btn-inner--text">Edit Anggota</span>
                </button>    

                <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                    <span class="btn-inner--text">Kembali</span>
                  </a>
                </div>
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
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-2-tab" href="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-2" aria-selected="false">Document</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-5-tabnav" href="<?= base_url("notes/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-5" aria-selected="false">Sketch</a>
            </li>
              <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-4-tab active" href="<?= base_url("workspace/chatspace/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-4" aria-selected="true">Chat</a>
              </li>
            
            </ul>
          </div> 
        </div> 
        </div> 
        <div class="container-fluid">
          <div class="row"> 
              <div class="col-lg-12"> 
                  <div class="card">
                      <div class="row p-3">
                      <?php if(!empty($chat)) { ?>
                          <div class="col-lg-12">
                          <div class="alert alert-default alert-dismissible fade show" role="alert">
                                      <span class="alert-icon"><i class="ni ni-air-baloon"></i></span>
                                      <span class="alert-text"><strong>Informasi!</strong> Untuk melakukan mantion ke objective (@obj), ke Dokumen (@doc), ke Key Result (@kr)!</span>
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>

                          
                                  <h4 class="card-title">Daftar Ruanganmu</h4>
                                  <div class="row">
                                      
                                      <div class="col-lg-3 mb-2">
                                          <button class="btn btn-icon btn-warning btn-block" type="button" data-pj="0">
                                              <span class="btn-inner--icon"><i class="ni ni-circle-08"></i></span>
                                              <span class="btn-inner--text titlechat">Ruangan Semua</span>
                                          </button> 
                                      </div>
                                      <?php foreach($projects as $pj) { 
                                        $CI = &get_instance();
                                        $CI->load->model('Team_model');

                                        $idpj = $pj['id_project'];

                                        $total = $CI->Main_model->checkMyMessageInDay($idpj);
                                        
                                        ?>
                                          <div class="col-lg-3 mb-2">
                                          <button class="btn btn-icon btn-secondary btn-block" type="button" id="<?= $pj['id_project'] ?>" data-pj="<?= $pj['id_project'] ?>">
                                              <span class="btn-inner--icon"><i class="ni ni-chat-round"></i></span>
                                              <span class="btn-inner--text titlechat">Ruangan <?= $pj['nama_project'] ?></span>
                                          </button>
                                          </div>
                                      <?php } ?>
                                  </div>
                              </div>
                              <div class="col-lg-12 mt-4">
                                  <input type="hidden" id="myworkspacesesi" class="form-control" value="<?= $this->session->userdata('workspace_sesi'); ?>">
                                  <input type="hidden" id="myuserid" class="form-control" value="<?= $this->session->userdata('id'); ?>">
                                  <input type="hidden" id="myprojectid" class="form-control" value="0">
                                  <input type="hidden" id="hidden-link" class="form-control hidden-link">
                                  <div class="card">
                                      <div class="card-body">
                                          <h2 class="card-title myroom">Ruangan Semua</h2>
                                        
                                          <input type="hidden" id="idroomchat" class="form-control" value="<?= $chat['id_mcr']; ?>">
                                          <div class="card-body">
                                          
                                              <div id="chat-window" class="overflow-auto" style="height: 400px">
                                              <!-- Chat Messages -->
                                              <div class="d-flex justify-content-end mb-2">
                                                                  
                                              </div>
                                          </div>
                                              <div class="card-footer">
                                                  <div id="mention-dropdown" class="list-group" style="display: none;overflow-y:scroll;max-height: 400px;">
                                                  <!-- Daftar mention akan diisi melalui JavaScript -->
                                                  </div>
                                                  <div class="input-group mb-2">     
                                                          <!-- <input type="text" id="message" class="form-control" placeholder="Type your message..." required> -->
                                                          <textarea class="form-control" id="message" rows="3"></textarea> 
                                                          </div>
                                                          <button type="button" id="send-btn" data-userid="<?= $this->session->userdata('id'); ?>" class="btn btn-default rounded-pill">Send</button>
                                                      
                                              </div>
                                          </div>
                              
                                      </div>
                                  </div>
                              </div>
                          
                        <?php } else { ?> 
                          <div class="col-lg-12">
                          <div class="card mb-3 bg-gradient-info">
                      <div class="row">
                        <div class="col-md-6">
                          <img src="<?= base_url('assets/'); ?>img/team.png" class="card-img dashboard"  style="width: 435px;" alt="...">
                        </div>
                        <div class="col-md-6" style="height: 225px; text-align: center;">
                          <div class="card-body">
                            <h1 class="card-title text-white">Tambahkan Ruangan Obrolan</h1>
                            <p class="card-title text-white">Ruangan Obrolan akan dibagi per ruangan OKR atau ruangan bersama, silahkan klik Tambahkan Ruangan untuk memulainya</p>
                            <?php 
                              $namasapace = $space['name_space'];

                              // Ubah string menjadi huruf kecil
                                $slug = strtolower($namasapace);

                                // Hapus semua karakter yang bukan huruf atau angka
                                $namasgenerate = preg_replace('/[^a-z0-9]/', '', $slug);

                            ?>
                            <a href="<?= base_url("workspace/tambahRoom/") . $this->session->userdata("workspace_sesi") . '/' . $namasgenerate ?>" type="button" class="btn btn-secondary">Tambah Ruangan</a>
                          </div>
                        </div>
                      </div>
                    </div>  
                            </div>      
                        <?php } ?>       
                      </div>
                      </div> 
                  </div>
              </div>
              <!-- <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
              <script>
                window.OneSignalDeferred = window.OneSignalDeferred || [];
                OneSignalDeferred.push(function(OneSignal) {
                  OneSignal.init({
                    appId: "7e644fe0-322c-4918-ac8a-50e4548fc488",
                    safari_web_id: "", // Only needed if using custom Safari certificate
                    notifyButton: {
                      enable: true, // Shows the OneSignal bell icon
                    },
                  });
                });
              </script>

     -->
    



      