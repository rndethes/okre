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
          <?php $role_id = $this->session->userdata('role_id');  ?> 
          <?= form_open_multipart('workspace/editSpace/', ['id' => 'workspace-form']); ?>
          <div class="pl-lg-4">
          <input type="hidden" id="id_space" name="id_space" class="form-control" value="<?= $space['id_space'] ?>">
            
          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Space Name</label>
                  <input type="text" id="namaworkspace" name="namaworkspace" class="form-control" value="<?= $space['name_space'] ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Kategori</label>
                  <input type="text" id="kategorispace" name="kategorispace" class="form-control" value="<?= $space['kategory_space'] ?>" readonly>
                </div>
              </div>
            </div>
                 
          <div class="row">
          
          <div class="col-lg-5">
          <div class="form-group">
              <label class="form-control-label" for="input-username">Team</label>
              <select id="user-select" name="userteam" class="form-control add-team">
                  <option value="">- Pilih User -</option>
                  <?php foreach ($users as $us) : ?>
                      <?php if ($us['state'] == '2') { ?>
                          <option value="<?= $us['id']; ?>" data-profile="<?= $us['foto']; ?>" 
                              <?php if (in_array($us['id'], array_column($useratteam, 'id_user'))) echo 'selected'; ?>>
                              <?= $us['username']; ?> (<?= $us['nama']; ?>)
                          </option>
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
              <ul id="user-list">
                  <?php foreach ($useratteam as $user) : ?>
                      <li class="avatar avatar-xs rounded-circle" data-user-id="<?= $user['id_user']; ?>">
                          <img src="<?= base_url('/assets/img/profile/' . $user['foto']); ?>" alt="Profile image of <?= $user['nama']; ?>" class="rounded-circle" data-toggle="tooltip" data-placement="top" title="Name: <?= $user['nama']; ?>">
                          <button class="remove-btn">&times;</button>
                      </li>
                  <?php endforeach; ?>
              </ul>
          </div>
          <div class="alert alert-danger" id="error-alert" style="display: none;">
              User already exists in the list!
          </div>
          <input type="hidden" id="selected-users" name="selected_users" value="<?= $userIdsString ?>">
      </div>

      </div>
            
            <div class="row">
              <div class="col-lg-3">
                <button class="btn btn-icon btn-default rounded-pill" type="submit">
                  <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                  <span class="btn-inner--text">Edit Workspace</span>
                </button>
              </div>
              <div class="col-lg-3">
                <a href="<?= base_url(); ?>project" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Kembali</span>
                </a>
              </div>
            </div>
          </div>

          <?= form_close(); 
          
         
          ?>
        </div>
      </div>
    </div>
  </div>

  

  <script>
   let users = <?php echo json_encode($arrayuser); ?>;

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

document.getElementById('user-list').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-btn')) {
        let userId = event.target.parentElement.getAttribute('data-user-id');
        users = users.filter(user => user.id !== userId);
        updateUserList();
    }
});

function updateUserList() {
    let userList = document.getElementById('user-list');
    userList.innerHTML = '';

    users.forEach(function(user) {
        // Create list item
        let listItem = document.createElement('li');
        listItem.className = 'avatar avatar-xs rounded-circle';
        listItem.setAttribute('data-user-id', user.id);

        // Create image element
        let imgElement = document.createElement('img');
        imgElement.src = user.profileUrl;
        imgElement.alt = `Profile image of ${user.name}`;
        imgElement.className = 'rounded-circle';
        imgElement.setAttribute('data-toggle', 'tooltip');
        imgElement.setAttribute('data-placement', 'top');
        imgElement.setAttribute('title', `Name: ${user.name}`);

        // Create remove button
        let removeEditButton = document.createElement('button');
        removeEditButton.className = 'remove-btn';
        removeEditButton.innerHTML = '&times;';

        removeEditButton.addEventListener('click', function() {
          users.splice(index, 1);
          updateUserList();
        });

        // Append elements to list item
        listItem.appendChild(imgElement);
        listItem.appendChild(removeEditButton);

        // Append list item to user list
        userList.appendChild(listItem);
    });

    // Update hidden input with selected user IDs
    let selectedUsersInput = document.getElementById('selected-users');
    selectedUsersInput.value = users.map(user => user.id).join(',');
}

  </script>
            