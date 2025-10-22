<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Document</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('document/index/') .  $this->session->userdata('workspace_sesi') . "/space" ?>">Document</a></li>
              <li class="breadcrumb-item active" aria-current="page">Input</li>
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
              <h3 class="mb-0">Input Penandatangan  </h3>
            </div>
            <style>
              span.badge.badge-default.sign-user {
                  font-size: 15px;
              }
            </style>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?php $role_id = $this->session->userdata('role_id');  ?> 
          <?= form_open_multipart('document/editDocumentSignature/', ['id' => 'document-form']); ?>
    
          <input type="hidden" id="idproject" name="idproject" class="form-control" value="<?= $mydocument['id_project'] ?>">

          <input type="hidden" id="statusdoc" name="statusdoc" class="form-control" value="<?= $this->uri->segment(3) ?>">
        
          <div class="pl-lg-4">
          <input type="hidden" id="id_document" name="id_document" class="form-control" value="<?= $mydocument['id_document'] ?>">
            <div class="alert alert-primary" role="alert">
              <?php 
                if(empty($okrdoc)) {
                  $desc = 'Tidak Terhubung ke OKR';
                } else {
                  $type = $okrdoc['type_doc_in_okr'];
                  $id   = $okrdoc['id_to_doc_in_okr'];                  

                  $datapj = checkProject($id,$type);

                  $nama = $datapj['namaokr'];

                  $desc = 'Dokumen Terhubung ke OKR ' . $type . ' ' . $nama;
                }
              ?>
                <strong>Note</strong> <?= $desc ?>!
            </div>
          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Dokumen</label>
                  <input type="text" id="namadokumen" name="namadokumen" class="form-control" value="<?= $mydocument['name_document'] ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Type Document</label>
                  <select class="form-control" id="work_status" name="work_status">
                    <option value="1" <?php if ($mydocument['type_document'] == '1') { ?> selected="selected" <?php } ?>>Surat</option>
                    <option value="2" <?php if ($mydocument['type_document'] == '2') { ?> selected="selected" <?php } ?>>Invoice</option>
                    <option value="3" <?php if ($mydocument['type_document'] == '3') { ?> selected="selected" <?php } ?>>Proposal</option>
                    <option value="4" <?php if ($mydocument['type_document'] == '4') { ?> selected="selected" <?php } ?>>BAA</option>
                    <option value="5" <?php if ($mydocument['type_document'] == '5') { ?> selected="selected" <?php } ?>>Dokumen Lainnya</option>
                  </select>
                </div>
              </div>
             
            </div> 
          <div class="row">
            <div class="col-lg-6">
                <embed type="application/pdf" src="<?= base_url("/assets/document/") . $namafolder . "/" . $mydocument['file_document'] ?>" width="600" height="400"></embed>
            </div>
           
            <div class="col-lg-6">
              <div class="form-group">
                <label for="desokr" class="form-control-label">Catatan Lainnya</label>
                  <div id="desokr"><?= $mydocument['note_from_created'] ?></div>
                <input type="hidden" id="describeokr" name="describeokr">
              </div>
              <div class="form-group">
                  <label for="tanggaltandatangan" class="form-control-label">Jadwalkan Tanda Tangan <small class="text-danger">*Silahkan Disesuaikan Seperlunya</small></label>
                  <input class="form-control" type="datetime-local" value="<?= date("Y-m-d H:i",strtotime(getCurrentDate())); ?>" id="tanggaltandatangan" name="tanggaltandatangan">
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="selectOrder">Masukan Urutan Tanda Tangan</label>
                    <select class="form-control" id="selectOrder" name="selectOrder">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="selectUser">Masukan User</label>
                    <select class="form-control" id="selectUser" name="selectUser">
                        <option value="">Pilih User</option>
                        <?php foreach ($spaceuser as $user) : ?>
                            <option value="<?= $user['idusers']; ?>"><?= $user['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2 mb-7">
            <div class="col-lg-6">
                <button class="btn btn-icon btn-default rounded-pill" id="btnAdd" type="button">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>

                </button>
            </div>
            <div class="col-lg-6" id="badgeContainer">
                <!-- Badge elements will be added here -->
            </div>
        </div>
            
            <?php if($this->uri->segment(3) == "space") { ?>
              <input type="hidden" name="myurl" id="myurl" value="<?= base_url(); ?>document/index/<?= $this->session->userdata("workspace_sesi") . "/space" ?>">
            <?php } else { ?>
              <input type="hidden" name="myurl" id="myurl" value="<?= base_url(); ?>document/index/<?= $mydocument['id_project'] ?>">
            <?php } ?>
            <div class="row">
              <div class="col-lg-3 mb-3">
                <button class="btn btn-icon btn-default rounded-pill" id="btnAdd" type="submit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Simpan Perubahan</span>
                </button>
              </div>
              <div class="col-lg-3 mb-3">
              <?php if($this->uri->segment(3) == "space") { ?>
                  <a href="<?= base_url(); ?>document/index/<?= $this->session->userdata("workspace_sesi") . "/space" ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                    <span class="btn-inner--text">Kembali</span>
                  </a>
                <?php } else { ?>
                  <a href="<?= base_url(); ?>document/index/<?= $mydocument['id_project'] ?>" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                    <span class="btn-inner--text">Kembali</span>
                  </a>
                <?php } ?>
               
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    // Array untuk menyimpan data
    var userOrderArray = [];

    // Fungsi untuk menambahkan user ke dalam array dan menampilkan badge
    function addUserToArray() {
        var selectOrder = document.getElementById('selectOrder');
        var selectUser = document.getElementById('selectUser');

        var order = selectOrder.value;
        var userId = selectUser.value;
        var userName = selectUser.options[selectUser.selectedIndex].text;

        // Periksa apakah nama atau urutan sudah ada dalam array
        var isNameExist = userOrderArray.some(function(user) {
            return user.name === userName;
        });

        var isOrderExist = userOrderArray.some(function(user) {
            return user.order === order;
        });

        if (isNameExist) {
            alert('Nama sudah ada dalam daftar');
            return;
        }

        if (isOrderExist) {
            alert('Urutan sudah ada dalam daftar');
            return;
        }

        if (userId && order) {
            var userObject = {
                id: userId,
                order: order,
                name: userName
            };

            userOrderArray.push(userObject);
            displayBadges();
        } else {
            alert('Please select both Order and User');
        }
    }

    // Fungsi untuk menampilkan badge
    function displayBadges() {
        var badgeContainer = document.getElementById('badgeContainer');
        badgeContainer.innerHTML = '';

        userOrderArray.forEach(function(user, index) {
            var badge = document.createElement('span');
            badge.className = 'badge badge-default sign-user';
            badge.innerHTML = user.name + ' (' + user.order + ') <i class="ni ni-fat-remove" onclick="removeUserFromArray(' + index + ')"></i>';
            badgeContainer.appendChild(badge);
        });
    }

    // Fungsi untuk menghapus user dari array
    function removeUserFromArray(index) {
        userOrderArray.splice(index, 1);
        displayBadges();
    }

    console.log(userOrderArray)

    // Event listener untuk tombol "Tambah"
    document.getElementById('btnAdd').addEventListener('click', addUserToArray);

</script>





  
            