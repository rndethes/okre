<ul class="list-group list-group-flush list">
            <?php foreach($messages as $msg) { 
               $dataNotif = $msg['data_notif'];

               // Decode JSON untuk mendapatkan array PHP
               $decodedData = json_decode($dataNotif, true);
               
               // Mengakses URL dari array yang sudah didecode
               $url = isset($decodedData['url']) ? $decodedData['url'] : null; // Pastikan 'url' ada
               
               // Cek apakah 'type' ada dalam array
               if (isset($decodedData['type'])) {
                   $type = $decodedData['type'];
               
                   if ($type == 'taskmeeting') {
                       $idtask = isset($decodedData['idtask']) ? $decodedData['idtask'] : 0;
                       $typenotif = '<span class="text-primary"> ● Meeting</span>';
                   } else {
                       $idtask = 0;
                       $typenotif = "";
                   }
               } else {
                $type = "";
                   // Jika 'type' tidak ada, berikan nilai default
                   $idtask = 0;
                   $typenotif = "";
               }
                ?>
                

            <li class="list-group-item px-2">
                
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Avatar -->
                <a href="<?= $url ?>" class="avatar rounded-circle">
                    <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') . $msg['foto']?>">
                </a>
                    </div>
                    <div class="col ml--2">
                    <?php  if($type == 'taskmeeting') { ?>
                        <h4 class="mb-0">
                            <span class="notif" data-idnotif="<?= $msg['id_notif'] ?>" data-url="<?= $url ?>"   href="<?= $url ?>"><?= $msg['title_notif'] ?><?= $typenotif ?></span> <?= $msg['data_notif'] == 1 ? '<span class="badge badge-success">Pesan Baru</span>' : '' ?> 
                        </h4>
                    <?php } else { ?>
                      <h4 class="mb-0">
                            <a class="notif-action" data-idnotif="<?= $msg['id_notif'] ?>" data-url="<?= $url ?>"   href="<?= $url ?>"><?= $msg['title_notif'] ?><?= $typenotif ?></a> <?= $msg['data_notif'] == 1 ? '<span class="badge badge-success">Pesan Baru</span>' : '' ?> 
                        </h4>
                    <?php } ?>
                        <span class="text-success">●</span>
                        <small><?= $msg['message_notif'] ?></small>
                    </div>
                    <div class="col-auto">
                    <?php  if($type == 'taskmeeting') { ?>
                      <?php if($msg['is_read_notif'] == '1') { ?>
                      <a href="<?= base_url('workspace/aprovalTaskInMsg/') . $idtask . "/" . $msg['id_notif'] ?>" type="button" class="btn btn-sm btn-success">Terima</a>
                      <a href="<?= base_url('workspace/rejectTaskInMsg/') . $idtask . "/" . $msg['id_notif'] ?>" type="button" class="btn btn-sm btn-danger">Tolak</a>
                      <a href="<?= $url ?>" type="button" class="btn btn-sm btn-warning">Ubah</a>
                      <?php } ?>
                      <a href="<?= base_url('workspace/deleteMessage/') . $msg['id_notif'] ?>" type="button" class="btn btn-sm btn-danger">Hapus</a>
                    <?php } else { ?>
                      <a href="<?= base_url('workspace/deleteMessage/') . $msg['id_notif'] ?>" type="button" class="btn btn-sm btn-danger">Hapus</a>
                    <?php } ?>
                   
                    </div>
                     </div>
                    </li>
                <?php } ?>
              </ul>