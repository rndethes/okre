<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Pesanku</h6>
          
        </div>

      </div>

    </div>
  </div>
</div>
<?php
    $userside_id = $this->session->userdata('id');
    $CI = &get_instance();
    $CI->load->model('Space_model');
    $CI->load->model('Main_model');


    $sidespaceteam      = $CI->Space_model->allspaceTeam($userside_id);
    $teamspace          = $CI->Space_model->dataMySpaceUserSide(0,$userside_id);

    $idWorkspaces = [];
    // Loop melalui setiap elemen dalam $sidespaceteam
    foreach ($sidespaceteam as $spaceTeam) {
            // Tambahkan nilai id_workspace ke array baru
        $idWorkspaces[] = $spaceTeam['id_workspace'];
    }

    $idwork = implode(',', $idWorkspaces);
?>

<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Pesanku </h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
    
        <div class="card-body">
        <?php if(!empty($messages)) { ?>
            <a href="<?= base_url('workspace/deleteAll/') . $this->session->userdata("id"); ?>" class="btn btn-danger rounded-pill mb-2">Hapus Semua</a>
        <?php } ?>
        <br>
        <br>
        <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
        <?php
        $isFirst = true;
        foreach($sidespaceteam as $sidetm) { 
          $countmsg   = $CI->Main_model->getAllNotificationBySpace($sidetm['id_space']);
          ?>
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 <?= $isFirst ? 'active' : '' ?>" data-idspace="<?= $sidetm['id_space'] ?>" id="notif-tab-<?= $sidetm['id_space'] ?>" data-toggle="tab" href="#notif" role="tab" aria-controls="notif" aria-selected="<?= $isFirst ? 'true' : 'false' ?>"><?= $sidetm['name_space'] ?> ( <?= $countmsg ?> )</a>
          </li>
          <?php $isFirst = false; } ?>
        </ul>
        <br>
        <!-- Container for Notification List -->
          <div class="tab-content mt-4" id="notifContent">
              <div id="notifTabContent">
                  <!-- Content of the selected tab will be loaded here via AJAX -->
              </div>
          </div>
       

        </div>
      </div>
    </div>
  </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ketika salah satu tab di klik
        const tabs = document.querySelectorAll('a[data-toggle="tab"]');
        const notifTabContent = document.getElementById('notifTabContent');
        const STORAGE_KEY = 'selectedTabIdSpace'; // Kunci untuk localStorage

        // Fungsi untuk memuat notifikasi
        function loadNotifications(idSpace) {
            const url = "<?= base_url('workspace/getNotificationsBySpace/') ?>" + idSpace;
            
            // Tampilkan loading text sebelum fetch
            notifTabContent.innerHTML = '<p>Loading...</p>';

            // Lakukan request dengan fetch()
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text(); // Mengambil respon sebagai teks HTML
                })
                .then(html => {
                    // Update konten div notifTabContent dengan HTML yang diterima
                    notifTabContent.innerHTML = html;
                })
                .catch(error => {
                    notifTabContent.innerHTML = '<p>Error loading notifications. Please try again.</p>';
                    console.error('Fetch error:', error);
                });
        }

            // Fungsi untuk menandai tab yang aktif
          function setActiveTab(tab) {
              tabs.forEach(tab => tab.classList.remove('active')); // Hapus kelas 'active' dari semua tab
              tab.classList.add('active'); // Tambahkan kelas 'active' ke tab yang diklik
              tab.setAttribute('aria-selected', 'true'); // Tetapkan atribut aria
          }
          
          const savedIdSpace = localStorage.getItem(STORAGE_KEY);
            let initialTab;

            if (savedIdSpace) {
                initialTab = document.querySelector(`a[data-idspace="${savedIdSpace}"]`);
            } else {
                initialTab = document.querySelector('a[data-toggle="tab"].active');
            }

            if (initialTab) {
                const idSpace = initialTab.getAttribute('data-idspace');
                setActiveTab(initialTab); // Tandai tab sebagai aktif
                loadNotifications(idSpace); // Panggil fungsi loadNotifications dengan id_space yang disimpan
            }

        // Event listener untuk klik tab lainnya
        tabs.forEach(tab => {
          tab.addEventListener('click', function (e) {
              e.preventDefault();
              const idSpace = this.getAttribute('data-idspace'); // Ambil id_space dari atribut data-idspace
              loadNotifications(idSpace); // Panggil fungsi loadNotifications

              // Tandai tab yang aktif dan simpan id_space di localStorage
              setActiveTab(this);
              localStorage.setItem(STORAGE_KEY, idSpace); // Simpan id_space ke localStorage
          });
      });
    });

</script>

  

  
            