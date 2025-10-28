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
<nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark bg-default">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url("project/projectAtWorkspace/" . $this->session->userdata('workspace_sesi'))  ?>">Project</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarokre" aria-controls="navbarokre" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarokre">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="javascript:void(0)">
                            Project
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarokre" aria-controls="navbarokre" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            
            <ul class="navbar-nav ml-lg-auto">
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url("project/showOkr/") . $this->uri->segment(3) ?>"> <i class="ni ni-atom"></i>
                  <span>OKRE</span></a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="<?= base_url("data/index/") . $this->uri->segment(3) ?>"> <i class="ni ni-bullet-list-67"></i>
                  <span class="nav-link-inner--text">Data</span></a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url("document/index/") . $this->uri->segment(3) ?>"> <i class="ni ni-folder-17"></i>
                  <span class="nav-link-inner--text">Dokumen</span></a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="<?= base_url("task/index/") . $this->uri->segment(3) ?>"> <i class="ni ni-ruler-pencil"></i>
                  <span class="nav-link-inner--text">Task</span></a>
                </li> -->
                <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-5-tabnav" href="<?= base_url("notes/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" role="tab" aria-controls="tabs-text-5" aria-selected="false">Sketch</a>
            </li>
                <li class="nav-item">
                  <a class="nav-link" id="showchat" href="javascript:void(0);"> <i class="ni ni-chat-round"></i>
                  <span class="nav-link-inner--text">Chat</span></a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link" onclick="goBackToPreviousPage()" > <i class="ni ni-bold-left"></i>
                  <span class="nav-link-inner--text">Kembali</span></a>
                </li>
               
               
           </ul>
            
        </div>
    </div>
</nav>