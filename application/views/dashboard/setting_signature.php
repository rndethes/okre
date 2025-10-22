<div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(<?= base_url(); ?>/assets/img/theme/office.jpg); background-size: cover; background-position: center top;">
  <!-- Mask -->
  <span class="mask bg-gradient-default opacity-8"></span>
  <!-- Header container -->
  <div class="container-fluid d-flex align-items-center">
    <div class="row">
      <div class="col-lg-7 col-md-10">
        <h1 class="display-2 text-white"> <?= $users['nama']; ?></h1>
        <p class="text-white mt-0 mb-5">This is your profile page, You can edit your profile </p>
      </div>
    </div>
  </div>
  
</div>
<div class="container-fluid mt--6">
  <div class="row">
  <div class="col-xl-12 order-xl-1 ">
    <div class="card bg-default card-frame">
      <div class="card-body">
        <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-text-1-tab" href="<?= base_url("setting") ?>" >Setting Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-text-2-tab" href="<?= base_url("setting/signatureview") ?>">Setting Tanda Tangan</a>
          </li>
      </ul>
      </div>
    </div>
    
</div>
 
    <div class="col-xl-12 order-xl-1">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Edit Signature </h3>
            </div>

          </div>
        </div>
        <div class="card-body">
        <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('message'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
          <?= form_open_multipart('setting/editsignature') ?>
          <h6 class="heading-small text-muted mb-4">Upload Tanda Tanganmu</h6>
          <div class="pl-lg-4">
         
          </div>
          <div class="pl-lg-4">
            <div class="row">
              <div class="form-group">
                <div class="col-sm-2"><label for="example-email-input" class="form-control-label">Picture</label></div>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-4 mb-4">
                      <img id="preview-image" src="<?= base_url('assets/img/signature/') . $users['signature_photo']; ?>" class="img-thumbnail edit-picture">
                    </div>
                    <div class="col-sm-8">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="signature_photo" name="signature_photo">
                        <label class="custom-file-label" for="signature_photo">Pilih File</label>
                        <label class="form-control-label text-danger pictureLabel" for="input-nomor"></label>
                      </div>
                      <input type="hidden" value="<?= $users['signature_photo']; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <button class="btn btn-icon btn-dark-primary rounded-pill" type="submit" name="edit">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Edit Signature</span>
              </button>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
  <script>
        document.getElementById('signature_photo').addEventListener('change', function(event) {
        var input = event.target;
        var label = input.nextElementSibling;
        var file = input.files[0];

        // Ganti label dengan nama file yang dipilih
        label.textContent = file.name;

        if (file) {
            var reader = new FileReader();

            // Saat file sudah dibaca
            reader.onload = function(e) {
                // Ubah src dari <img> dengan file yang dipilih
                document.getElementById('preview-image').src = e.target.result;
            };

            // Membaca file sebagai Data URL
            reader.readAsDataURL(file);
        }
    }); 
  </script>