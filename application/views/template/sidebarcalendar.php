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
     <?php
        $userside_id = $this->session->userdata('id');
        $idspace     = $this->uri->segment(3);
        
        $CI = &get_instance();
        $CI->load->model('Space_model');

        $spaceactive      = $CI->Space_model->dataSpaceActive($idspace);
        $teamspace        = $CI->Space_model->dataMySpaceUserSide($idspace);

        $currentURL = current_url();

        ?>
     <div class="navbar-inner">
       <!-- Collapse -->
       <div class="collapse navbar-collapse" id="sidenav-collapse-main">
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
              <span class="docs-normal">Space</span>
            </h6>
            <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link <?= menu_active('dashboard') ?>" href="<?= base_url(); ?>project/projectAtWorkspace/<?= $idspace ?>">
                <i class="fas fa-users text-warning"></i>
                <span class="nav-link-text"><?= $spaceactive['name_space'] ?></span>
               </a>
             </li>
            </ul>
              <!-- <a href="#" class="badge badge-pill badge-default"> <i class="fas fa-users text-secondary"></i> 1</a> -->
            <hr class="my-3">
            <h6 class="navbar-heading p-0 text-muted">
                <span class="docs-normal">Filter</span>
            </h6>
            <input type="hidden" id="idspace" value="<?= $idspace ?>">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="usercalendar" id="usercalendar-all" value="all">
                        <label class="form-check-label" for="usercalendar_all">All</label>
                    </div>
                </li>
                <?php foreach($teamspace as $tmsp) { ?>
                    <?php if($tmsp['id'] == $userside_id) { ?>
                        <li class="list-group-item">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="usercalendar[]" id="usercalendar_<?= $tmsp['id'] ?>" value="<?= $tmsp['id'] ?>" checked>
                                <label class="form-check-label" for="usercalendar_<?= $tmsp['id'] ?>"><?= $tmsp['username'] ?></label>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="list-group-item">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="usercalendar[]" id="usercalendar_<?= $tmsp['id'] ?>" value="<?= $tmsp['id'] ?>">
                                <label class="form-check-label" for="usercalendar_<?= $tmsp['id'] ?>"><?= $tmsp['username'] ?></label>
                            </div>
                        </li>
                    <?php } ?>
                  
                <?php } ?>
            </ul>
       </div>
     </div>
   </div>
 </nav>



 



