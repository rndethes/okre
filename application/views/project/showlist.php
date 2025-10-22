<div class="row">
  <div class="col-lg-6">
  <h4>Tidak Penting , Mendesak</h4>
    <div class="borderlist">
      <ul class="list-group">
      <?php if (empty($showlistonetwo)) { ?>
        <img class="imglist" src="<?= base_url('assets/img/notfoundlist.png') ?>">
      <?php } else { ?>
        <?php foreach($showlistonetwo as $showlistonetwo) { ?>
          <?php 
            $datenow     = date("Y-m-d");
            $dateplustwo = date("Y-m-d",strtotime($showlistonetwo['due_datekey'] . '+2 days'));
            // hitung selisih antara kedua timestamp menggunakan date_diff
            $interval = date_diff(date_create($dateplustwo), date_create($datenow));
            $selisih =  $interval->format('%R%a');
            ?>
          <?php if ($selisih < 2) { ?>     
          <li class="list-group-item listpriority">
          <?php $jumlah_karakter  = strlen($showlistonetwo['description']); ?>
          <?php if($jumlah_karakter > 38) { ?>
          <?= substr($showlistonetwo['description'], 0, 38) . '...' ?>
          <?php } else { ?>
            <?= $showlistonetwo['description'] ?>
          <?php } ?>
            <span class="badge badge-warning">Deadline In <?= date("j F Y",strtotime($showlistonetwo['due_datekey'])) ?></span>
            <a href="<?= base_url(); ?>project/showKey/<?= $showlistonetwo['id_project_priority'] ?>/<?= $showlistonetwo['id_okr_priority']; ?>" class="badge badge-primary"><i class="fas fa-eye"></i></a>
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <a class="dropdown-item listpriorityitem importurgentonelist" href="" data-targetlist="<?= $showlistonetwo['id_priority'] ?>">Penting , Mendesak</a>
                      <a class="dropdown-item listpriorityitem importurgentthreelist" href="" data-targetlist="<?= $showlistonetwo['id_priority'] ?>">Tidak Penting , Tidak Mendesak</a>
                      <a class="dropdown-item listpriorityitem importurgentfourlist" href="" data-targetlist="<?= $showlistonetwo['id_priority'] ?>">Penting , Tidak Mendesak</a>
                    </div>
                </div>
            </li>
          <?php } ?>
        <?php } ?>
      <?php } ?>
      </ul>
    </div>
  </div>
  <div class="col-lg-6">
  <h4>Penting , Mendesak</h4>
    <div class="borderlist">
      <ul class="list-group">
      <?php if (empty($showlistone)) { ?>
        <img class="imglist" src="<?= base_url('assets/img/notfoundlist.png') ?>">
      <?php } else { ?>
        <?php foreach($showlistone as $showlistone) { ?>
          <li class="list-group-item listpriority">
          <?php $jumlah_karakter    =strlen($showlistone['description']); ?>
          <?php if($jumlah_karakter > 38) { ?>
          <?= substr($showlistone['description'], 0, 38) . '...' ?>
          <?php } else { ?>
          <?= $showlistone['description'] ?>
          <?php } ?>
          <span class="badge badge-danger">Deadline In <?= date("j F Y",strtotime($showlistone['due_datekey'])) ?></span>
            <a href="<?= base_url(); ?>project/showKey/<?= $showlistone['id_project_priority'] ?>/<?= $showlistone['id_okr_priority']; ?>" class="badge badge-primary"><i class="fas fa-eye"></i></a>
            <div class="dropdown">
              <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <a class="dropdown-item listpriorityitem importurgenttwolist" href="" data-targetlist="<?= $showlistone['id_priority'] ?>">Tidak Penting , Mendesak</a>
                <a class="dropdown-item listpriorityitem importurgentthreelist" href="" data-targetlist="<?= $showlistone['id_priority'] ?>">Tidak Penting , Tidak Mendesak</a>
                <a class="dropdown-item listpriorityitem importurgentfourlist" href="" data-targetlist="<?= $showlistone['id_priority'] ?>">Penting , Tidak Mendesak</a>
              </div>
            </div>
          </li>
         <?php } ?>
      <?php } ?>
      </ul>
    </div>
  </div>
  <div class="col-lg-6 mt-2">
  <h4>Tidak Penting , Tidak Mendesak</h4>
    <div class="borderlist">
      <ul class="list-group">
      <?php if (empty($showlistonethree)) { ?>
        <img class="imglist" src="<?= base_url('assets/img/notfoundlist.png') ?>">
      <?php } else { ?>
        <?php foreach($showlistonethree as $showlistonethree) { ?>
        <li class="list-group-item listpriority">
        <?php $jumlah_karakter    = strlen($showlistonethree['description']); ?>
        <?php if($jumlah_karakter > 38) { ?>
          <?= substr($showlistonethree['description'], 0, 38) . '...' ?>
        <?php } else { ?>
          <?= $showlistonethree['description'] ?>
        <?php } ?>
          <span class="badge badge-success">Deadline In <?= date("j F Y",strtotime($showlistonethree['due_datekey'])) ?></span>
          <a href="<?= base_url(); ?>project/showKey/<?= $showlistonethree['id_project_priority'] ?>/<?= $showlistonethree['id_okr_priority']; ?>" class="badge badge-primary"><i class="fas fa-eye"></i></a>
            <div class="dropdown">
              <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <a class="dropdown-item listpriorityitem importurgentonelist" href="" data-targetlist="<?= $showlistonethree['id_priority'] ?>"> Penting , Mendesak</a>
                <a class="dropdown-item listpriorityitem importurgenttwolist" href="" data-targetlist="<?= $showlistonethree['id_priority'] ?>">Tidak Penting , Mendesak</a>
                <a class="dropdown-item listpriorityitem importurgentfourlist" href="" data-targetlist="<?= $showlistonethree['id_priority'] ?>">Penting , Tidak Mendesak</a>
              </div>
            </div>
          </li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="col-lg-6 mt-2">
  <h4> Penting , Tidak Mendesak</h4>
    <div class="borderlist">
    <ul class="list-group">
      <?php if (empty($showlistonefour)) { ?>
        <img class="imglist" src="<?= base_url('assets/img/notfoundlist.png') ?>">
      <?php } else { ?>
        <?php foreach($showlistonefour as $showlistonefour) { ?>
          <li class="list-group-item listpriority">
          <?php $jumlah_karakter    = strlen($showlistonefour['description']); ?>
          <?php if($jumlah_karakter > 38) { ?>
            <?= substr($showlistonefour['description'], 0, 38) . '...' ?>
          <?php } else { ?>
            <?= $showlistonefour['description'] ?>
          <?php } ?>
            <span class="badge badge-primary">Deadline In <?= date("j F Y",strtotime($showlistonefour['due_datekey'])) ?></span>
            <a href="<?= base_url(); ?>project/showKey/<?= $showlistonefour['id_project_priority'] ?>/<?= $showlistonefour['id_okr_priority']; ?>" class="badge badge-primary"><i class="fas fa-eye"></i></a>
              <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  <a class="dropdown-item listpriorityitem importurgentonelist" href="" data-targetlist="<?= $showlistonefour['id_priority'] ?>"> Penting , Mendesak</a>
                  <a class="dropdown-item listpriorityitem importurgenttwolist" href="" data-targetlist="<?= $showlistonefour['id_priority'] ?>">Tidak Penting , Mendesak</a>
                  <a class="dropdown-item listpriorityitem importurgentthreelist" href="" data-targetlist="<?= $showlistonefour['id_priority'] ?>">Tidak Penting , Tidak Mendesak</a>
                </div>
              </div>
            </li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>  