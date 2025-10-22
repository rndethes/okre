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
              <li class="breadcrumb-item active" aria-current="page">Revision</li>
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
              <?php 
              if($mydocument['id_project'] == '0') { 
                $nama = "-";
               } else { 
                $nama = $mydocument['nama_project'];
               } ?>
              <h3 class="mb-0">Revisi dokumen in <?= $mydocument['name_space'] ?> / <?= $nama ?></h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?php $role_id = $this->session->userdata('role_id');  ?> 
          <?= form_open_multipart('document/revisiDocumentSignature/', ['id' => 'document-formrevisi']); ?>
          <div class="alert alert-danger" role="alert">
              <strong>CATATAN</strong>  <p><?= $note ?></p>
          </div>

    
          <input type="hidden" id="idproject" name="idproject" class="form-control" value="<?= $mydocument['id_project'] ?>">

          <input type="hidden" id="myurl" name="myurl" class="form-control" value="<?= $this->uri->segment(3) ?>">
        
          <div class="pl-lg-4">
          <input type="hidden" id="id_document" name="id_document" class="form-control" value="<?= $mydocument['id_document'] ?>">
          <input type="hidden" id="oldfile" name="oldfile" class="form-control" value="<?= $file ?>">
            
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
              <input type="hidden" id="namefile" name="namefile" class="form-control" value="<?= $file ?>">
              <input type="hidden" id="docurl" name="docurl" class="form-control" value="<?= base_url("/assets/document/") .$namafolder.'/'. $file ?>">

              <div class="col-lg-6 mb-3">
                <div class="custom-file">
                    <input type="file" name="filesign" class="custom-file-input" id="filesign" lang="en" value="<?= $file ?>">
                    <label class="custom-file-label" for="filesign">Select file</label>
                </div>
              </div>
            </div>
            </div> 
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <span class="badge badge-lg badge-primary mb-2">File Sebelum Revisi (<?= $file ?>)</span>
                    <embed type="application/pdf" src="<?= base_url("/assets/document/") .$namafolder.'/'. $file ?>" width="850" height="700"></embed>
                </div>
                <div class="col-lg-6 mb-2">
                <span class="badge badge-lg badge-warning mb-2">File Baru</span>
                    <embed id="pdfViewer" type="application/pdf" src="" width="850" height="700"></embed>
                </div>
            </div>
          <div class="row">
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
        <div class="row mt-2 mb-3">
            <div class="col-lg-6">
                <button class="btn btn-icon btn-default rounded-pill" id="btnAdd" type="button">
                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                </button>
            </div>
            <div class="col-lg-6" id="badgeContainer">
                <!-- Badge elements will be added here -->
            </div>
        </div>
            
            <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="desokr" class="form-control-label">Catatan Lainnya</label>
                  <div id="desokr"><?= $mydocument['note_from_created'] ?></div>
                <input type="hidden" id="describeokr" name="describeokr">
              </div>
            </div>
              <div class="col-lg-3 mb-3">
                <button class="btn btn-icon btn-default rounded-pill" id="btnAddRev" type="submit">
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
  
  <script>
  document.addEventListener('DOMContentLoaded', function() {
        
    });
</script>
  <script>
    
    
    document.getElementById('filesign').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var fileURL = URL.createObjectURL(file);
            document.getElementById('pdfViewer').src = fileURL;

            document.getElementById('docurl').value = fileURL;
        }
    });
</script>

  <script>
    let users = <?php echo json_encode($datasignature); ?>;

        // Array untuk menyimpan data
        var userOrderArray = [];

        // Fungsi untuk menambahkan user dari `users` array ke dalam `userOrderArray` dan menampilkan badge
        function initializeUserOrderArray() {
            users.forEach(function(user) {
                var userObject = {
                    id: user.id,       // Sesuaikan dengan struktur data di `datasignature`
                    order: user.order, // Sesuaikan dengan struktur data di `datasignature`
                    name: user.name    // Sesuaikan dengan struktur data di `datasignature`
                };

                userOrderArray.push(userObject);
            });

            displayBadges();
        }

    


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
                badge.className = 'badge badge-default';
                badge.innerHTML = user.name + ' (' + user.order + ') <i class="ni ni-fat-remove" onclick="removeUserFromArray(' + index + ')"></i>';
                badgeContainer.appendChild(badge);
            });
        }

        // Fungsi untuk menghapus user dari array
        function removeUserFromArray(index) {
            userOrderArray.splice(index, 1);
            displayBadges();
        }

        // Event listener untuk tombol "Tambah"
        document.getElementById('btnAdd').addEventListener('click', addUserToArray);

        // Simpan nilai awal dari setiap input
        var initialData = {
            file: '<?= $file ?>',
            selectOrder: document.getElementById('selectOrder').value,
            selectUser: document.getElementById('selectUser').value,
            nameDocument: '<?= $mydocument['name_document'] ?>',
            typeDocument: '<?= $mydocument['type_document'] ?>',
        };

       
 // Cek apakah ada perubahan data
          var valuefile = document.getElementById('filesign').value == "" ? '<?= $file ?>' : document.getElementById('filesign').value
        // Panggil fungsi ini saat halaman dimuat untuk menginisialisasi userOrderArray dari users yang sudah ada
        initializeUserOrderArray();

    </script>



  
            