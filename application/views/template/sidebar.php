 <!-- Sidenav -->
 <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
   <div class="scrollbar-inner">
     <!-- Brand -->
     <div class="sidenav-header align-items-center mb-2">
       <a class="navbar-brand" href="javascript:void(0)">
         <div class="text-primary"><img src="<?= base_url('assets/'); ?>img/logo.png" class="brand-image"></div>
       </a>
     </div>
     <?php $role_id = $this->session->userdata('role_id'); ?>
     <div class="navbar-inner">
       <!-- Collapse -->
       <div class="collapse navbar-collapse" id="sidenav-collapse-main">
         <!-- Nav items -->
         <?php if ($role_id == '1') { ?>
           <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('dashboard') ?>" href="<?= base_url(); ?>dashboard">
                 <i class="ni ni-tv-2 text-primary"></i>
                 <span class="nav-link-text">Dashboard</span>
               </a>
             </li>
          </ul>
          <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Schedule</span>
            </h6>
            <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('calendar') ?>" href="<?= base_url(); ?>calendar/viewall">
                 <i class="ni ni-calendar-grid-58 text-default"></i>
                 <span class="nav-link-text">Schedule</span>
               </a>
             </li>
          </ul>
            <hr class="my-3">
         <?php

          $userside_id = $this->session->userdata('id');
          $CI = &get_instance();
          $CI->load->model('Space_model');
          $CI->load->model('Main_model');

          $sidespaceteam      = $CI->Space_model->dataSpaceTeam($userside_id);
          $sidespaceprivate    = $CI->Space_model->dataSpacePrivate($userside_id);
          $allspace      = $CI->Space_model->allspaceTeam($userside_id);

          $currentURL = current_url();

          $allspace      = $CI->Space_model->allspaceTeam($userside_id);

        

         ?>
         <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Space</span>
            </h6>
         <ul class="navbar-nav">
             <li class="nav-item">
             <a class="nav-link <?= ($currentURL == base_url('project')) ? 'active' : '' ?>" href="<?= base_url(); ?>project">
                 <i class="ni ni-planet text-danger"></i>
                 <span class="nav-link-text">Create Workspace</span>
               </a>
             </li>
             <li class="nav-item">
              <a class="nav-link" href="#navbar-spaceteam" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spaceteam">
                <i class="fas fa-users text-warning"></i>
                <span class="nav-link-text">Team Space</span>
              </a>
                <div class="collapse" id="navbar-spaceteam" style="">
                  <ul class="nav nav-sm flex-column">
                    <?php if(empty($sidespaceteam)) { ?>
                      <li class="nav-item">
                        <a href="<?= base_url(); ?>project/neWorkspace/team" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Tambahkan Space Team... </span>
                        </a>
                       
                      </li>
                    <?php } else { ?>
                      <?php foreach($sidespaceteam as $sidetm) { 
                        $idpsace = $sidetm['id_space'];
                          $count = $CI->Main_model->getAllNotificationBySpace($idpsace);
                          if($count == 0) {
                            $notif ='';
                          } else {
                            $notif ='<span class="avatar avatar-xs rounded-circle bg-info notifnav">'.$count.'</span>';
                          }
                        ?>
                      <li class="nav-item <?= ($currentURL == base_url('project/projectAtWorkspace/'.$sidetm['id_space'])) ? 'active' : '' ?>">
                        <a href="<?= base_url(); ?>project/projectAtWorkspace/<?= $sidetm['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon"> </span>
                          <span class="sidenav-normal"> <?= $sidetm['name_space'] ?> <?= $notif ?></span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-spaceprivate" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spaceprivate">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">Private Space</span>
              </a>
                <div class="collapse" id="navbar-spaceprivate" style="">
                  <ul class="nav nav-sm flex-column">
                  <?php if(empty($sidespaceprivate)) { ?>
                      <li class="nav-item">
                        <a href="<?= base_url(); ?>project/neWorkspace/private" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Tambahkan Space Private... </span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <?php foreach($sidespaceprivate as $sidepvt) { ?>
                      <li class="nav-item <?= ($currentURL == base_url('project/projectAtWorkspace/'.$sidepvt['id_space'])) ? 'active' : '' ?>">
                      <a href="<?= base_url(); ?>project/projectAtWorkspace/<?= $sidepvt['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> <?= $sidepvt['name_space'] ?> </span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>
            </ul>
            <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Document Space</span>
            </h6>
            <ul class="navbar-nav">
             <!-- <li class="nav-item">
             <a class="nav-link" href="<?= base_url(); ?>document">
                  <i class="fas fa-print text-success"></i>
                 <span class="nav-link-text">Document</span>
               </a>
             </li> -->
             <li class="nav-item">
              <a class="nav-link" href="#navbar-docspaceteam" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-docspaceteam">
              <i class="fas fa-folder-open text-info"></i>
              
                <span class="nav-link-text">Aproval Document</span>
              </a>
                <div class="collapse" id="navbar-docspaceteam" style="">
                  <ul class="nav nav-sm flex-column">
                    <?php if(empty($allspace)) { ?>
                      <li class="nav-item">
                        <a href="" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Masuklah Ke Dalam Space</span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <?php foreach($allspace as $allspace) { ?>
                      <li class="nav-item <?= ($currentURL == base_url('document/documentAtSpace/'.$allspace['id_space'])) ? 'active' : '' ?>">
                         <a href="<?= base_url(); ?>document/documentAtSpace/<?= $allspace['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> <?= $allspace['name_space'] ?> Document</span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>

            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Setting Data</span>
            </h6>
            <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('setting') ?>" href="<?= base_url() ?>setting">
                 <i class="ni ni-settings text-default"></i>
                 <span class="nav-link-text">Setting</span>
               </a>
             </li>
           </ul>
         <?php } else { ?>
           <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('dashboard') ?>" href="<?= base_url(); ?>dashboard">
                 <i class="ni ni-tv-2 text-primary"></i>
                 <span class="nav-link-text">Dashboard</span>
               </a>
             </li>
           </ul>
           <hr class="my-3">
         <?php

          $userside_id = $this->session->userdata('id');
          $CI = &get_instance();
          $CI->load->model('Space_model');

          $sidespaceteam      = $CI->Space_model->dataSpaceTeam($userside_id);
          $sidespaceprivate    = $CI->Space_model->dataSpacePrivate($userside_id);

          $allspace      = $CI->Space_model->allspaceTeam($userside_id);


          $currentURL = current_url();

         ?>
         <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Space</span>
            </h6>
         <ul class="navbar-nav">
             <li class="nav-item">
             <a class="nav-link <?= ($currentURL == base_url('project')) ? 'active' : '' ?>" href="<?= base_url(); ?>project">
                 <i class="ni ni-planet text-danger"></i>
                 <span class="nav-link-text">Create Workspace</span>
               </a>
             </li>
             <li class="nav-item">
              <a class="nav-link" href="#navbar-spaceteam" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spaceteam">
                <i class="fas fa-users text-warning"></i>
                <span class="nav-link-text">Team Space</span>
              </a>
                <div class="collapse" id="navbar-spaceteam" style="">
                  <ul class="nav nav-sm flex-column">
                    <?php if(empty($sidespaceteam)) { ?>
                      <li class="nav-item">
                        <a href="<?= base_url(); ?>project/neWorkspace/team" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Tambahkan Space Team... </span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <?php foreach($sidespaceteam as $sidetm) { ?>
                      <li class="nav-item <?= ($currentURL == base_url('project/projectAtWorkspace/'.$sidetm['id_space'])) ? 'active' : '' ?>">
                      <a href="<?= base_url(); ?>project/projectAtWorkspace/<?= $sidetm['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> <?= $sidetm['name_space'] ?> </span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-spaceprivate" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-spaceprivate">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">Private Space</span>
              </a>
                <div class="collapse" id="navbar-spaceprivate" style="">
                  <ul class="nav nav-sm flex-column">
                  <?php if(empty($sidespaceprivate)) { ?>
                      <li class="nav-item">
                        <a href="<?= base_url(); ?>project/neWorkspace/private" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Tambahkan Space Private... </span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <?php foreach($sidespaceprivate as $sidepvt) { ?>
                      <li class="nav-item <?= ($currentURL == base_url('project/projectAtWorkspace/'.$sidepvt['id_space'])) ? 'active' : '' ?>">
                      <a href="<?= base_url(); ?>project/projectAtWorkspace/<?= $sidepvt['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> <?= $sidepvt['name_space'] ?> </span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>
            </ul>
            <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Document Space</span>
            </h6>
            <ul class="navbar-nav">
             <li class="nav-item">
              <a class="nav-link" href="#navbar-docspaceteam" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-docspaceteam">
              <i class="fas fa-folder-open text-info"></i>
              
                <span class="nav-link-text">Aproval Document</span>
              </a>
                <div class="collapse" id="navbar-docspaceteam" style="">
                  <ul class="nav nav-sm flex-column">
                    <?php if(empty($allspace)) { ?>
                      <li class="nav-item">
                        <a href="<?= base_url(); ?>project/neWorkspace/team" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> Tambahkan Space... </span>
                        </a>
                      </li>
                    <?php } else { ?>
                      <?php foreach($allspace as $allspace) { ?>
                      <li class="nav-item <?= ($currentURL == base_url('document/documentAtSpace/'.$allspace['id_space'])) ? 'active' : '' ?>">
                         <a href="<?= base_url(); ?>document/documentAtSpace/<?= $allspace['id_space'] ?>" class="nav-link">
                          <span class="sidenav-mini-icon">  </span>
                          <span class="sidenav-normal"> <?= $allspace['name_space'] ?> Document</span>
                        </a>
                      </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>  
            </li>

            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
              <span class="docs-normal">Master Data</span>
            </h6>
            <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('setting') ?>" href="<?= base_url() ?>setting">
                 <i class="ni ni-settings text-default"></i>
                 <span class="nav-link-text">Setting</span>
               </a>
             </li>
           </ul>
         <?php } ?>

         <!-- Divider -->
       </div>
     </div>
   </div>
 </nav>