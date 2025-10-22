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
    
 
    <div class="col-xl-8 order-xl-1">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Change Password </h3>
            </div>

          </div>
        </div>
        <div class="card-body">
          <?= form_open_multipart('setting/changepassword') ?>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <input type="hidden" id="input-username" name="id" class="form-control" value="<?= $users['id']; ?>">
                <input type="hidden" id="input-username" name="username" class="form-control" value="<?= $users['username']; ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="new_password1">New Password</label>
                  <input type="password" id="new_password1" name="new_password1" class="form-control">
                  <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
       
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="new_password2">Repeat Password</label>
                  <input type="password" id="new_password2" name="new_password2" class="form-control">
                  <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
       
            </div>
          </div>
     
      
        

          <div class="row">
            <div class="col-lg-4">
              <button class="btn btn-icon btn-dark-primary rounded-pill" type="submit" name="edit">
                <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                <span class="btn-inner--text">Change Password</span>
              </button>
            </div>
            <div class="col-lg-5">
              <a href="<?= base_url(); ?>setting"  class="btn btn-icon btn-danger rounded-pill">
                <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Back</span>
              </a>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>