<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
              <li class="breadcrumb-item active" aria-current="page">Default</li>
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
              <h3 class="mb-0">Input Workspace  </h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?php $role_id = $this->session->userdata('role_id');
          $cekurl = $this->uri->segment(3);
    
          ?> 
          <?= form_open_multipart('workspace/tambahWorkSpace/', ['id' => 'workspace-form','class' => 'workspaceclass-form']); ?>
          <div class="pl-lg-4">
            
          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Space Name</label>
                  <input type="text" id="namaworkspace" name="namaworkspace" class="form-control">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Kategori</label>
                  <input type="text" id="kategorispace" name="kategorispace" class="form-control" value="<?= $cekurl ?>" readonly>
                </div>
              </div>
            </div>
                 
          <div class="row">
            <?php if($cekurl == 'team') { ?>
              <div class="col-lg-5">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Team</label>
                  <select id="user-select" name="userteam" class="form-control add-team">
                  <option value="">- Pilih User -</option>
                  <?php foreach ($users as $us) : ?>
                    <?php if ($us['state'] == '2') { ?>
                      <option value="<?= $us['id']; ?>" data-profile="<?= $us['foto']; ?>"><?= $us['username']; ?> (<?= $us['nama'] ?>)</option>
                    <?php } ?>
                  <?php endforeach; ?>
                </select>
                </div>
              </div>
         
              <div class="col-lg-1">
                <br>
              <button type="button" id="tambah-user" class="btn btn-facebook btn-icon-only">
                <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
               </button>
              </div>
              <div class="col-lg-6">
               <div class="user-list">
                  <h4>Selected Users:</h4>
                  <ul id="user-list"></ul>
                </div>
                <div class="alert alert-danger" id="error-alert" style="display: none;">
                  User already exists in the list!
                </div>

              </div>
              <?php } ?>
              <div class="col-lg-12 mb-1">
                  <div class="form-group">
                  <label class="form-control-label" for="spacedesc">Deskripsi</label>
                    <div id="spacedesc" class="quill-editor"></div>
                  </div>
                  <input type="hidden" id="descfromquill" name="descfromquill" class="form-control">
              </div>
            </div>
            <input type="hidden" id="selected-users" name="selected_users">
            <div class="row">
              <div class="col-lg-3">
                <button class="btn btn-icon btn-default rounded-pill" type="submit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Tambah Workspace</span>
                </button>
              </div>
              <div class="col-lg-3">
                <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Kembali</span>
                </a>
              </div>
            </div>
          </div>

          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    let users = [];

    document.getElementById('tambah-user').addEventListener('click', function() {
      let select = document.getElementById('user-select');
      let selectedOption = select.options[select.selectedIndex];
      let userId = selectedOption.value;
      let userName = selectedOption.text;
      let userProfile = selectedOption.getAttribute('data-profile');
      let profileUrl = baseURL + `/assets/img/profile/${userProfile}`;

      // Check if the user already exists in the array
      let userExists = users.some(function(user) {
        return user.id === userId;
      });

      if (userExists) {
        document.getElementById('error-alert').style.display = 'block';
      } else {
        document.getElementById('error-alert').style.display = 'none';
        users.push({ id: userId, name: userName, profileUrl: profileUrl });
        updateUserList();
        $('[data-toggle="tooltip"]').tooltip(); // Initialize tooltips
        
      }
    });

    function updateUserList() {
      let userList = document.getElementById('user-list');
      userList.innerHTML = '';

      users.forEach(function(user, index) {
        let listItem = document.createElement('li');
        listItem.className = 'avatar avatar-xs rounded-circle';

        let imgElement = document.createElement('img');
        imgElement.src = user.profileUrl;
        imgElement.alt = `Profile image of ${user.name}`;
        imgElement.className = 'rounded-circle';
        imgElement.setAttribute('data-toggle', 'tooltip');
        imgElement.setAttribute('data-placement', 'top');
        imgElement.setAttribute('title', `Name: ${user.name}`);

        let removeTeamButton = document.createElement('button');
        removeTeamButton.className = 'remove-btn';
        removeTeamButton.innerHTML = '&times;';
        removeTeamButton.addEventListener('click', function() {
          users.splice(index, 1);
          updateUserList();
        });

        listItem.appendChild(imgElement);
        listItem.appendChild(removeTeamButton);
        userList.appendChild(listItem);
      });

      let selectedUsersInput = document.getElementById('selected-users');
      selectedUsersInput.value = users.map(user => user.id).join(',');
    }
  </script>
            