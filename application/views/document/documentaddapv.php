<style>
        canvas {
            border: 1px solid #ccc;
        }
        .badge {
            display: inline-block;
            padding: 10px;
            margin: 5px;
            border: 1px dashed #007bff;
            border-radius: 5px;
            background: rgba(0, 123, 255, 0.2);
            cursor: move;
            position: absolute;
        }
    </style>

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
              <div class="col-lg-12">
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
                            <?php foreach ($spaceuser as $user): ?>
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
               
            </div>
            <div class="row mt-2 mb-7">
                <div class="col-lg-6">
                        <div id="badgeContainer" style="border: 1px solid #ccc; padding: 10px; min-height: 100px;">
                            <!-- Badges will appear here -->
                        </div>
                    <!-- Badge elements will be added here -->
                </div>
                <div class="col-lg-6">
                <div id="pdf-container" style="position: relative; border: 1px solid #ccc; overflow: auto; height: 800px;" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>   
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
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.worker.min.js';

    var pdfDoc = null,
        scale = 1.5,
        pdfContainer = document.getElementById('pdf-container'),
        badges = [
            { name: 'Badge 1', x: null, y: null },
            { name: 'Badge 2', x: null, y: null },
            { name: 'Badge 3', x: null, y: null }
        ];
        pageElements = []; // Array to keep track of page elements

        const url = "<?= base_url("/assets/document/") . $namafolder . "/" . $mydocument['file_document'] ?>";
    

            function renderPage(num) {
                pdfDoc.getPage(num).then(function(page) {
                    var viewport = page.getViewport({ scale: scale });

                    // Create canvas element dynamically
                    var canvas = document.createElement('canvas');
                    canvas.className = 'pdf-page';
                    canvas.setAttribute('data-page-number', num); // Set data-page-number attribute
                    var ctx = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    
                    var renderTask = page.render(renderContext);
                    
                    // Append the canvas to the container
                    pdfContainer.appendChild(canvas);

                    // Save the canvas element for future use
                    pageElements[num] = canvas;

                    
                    // Once rendering is complete, render the next page if available
                    renderTask.promise.then(function() {
                        if (num < pdfDoc.numPages) {
                            renderPage(num + 1);
                        } else {
                            // Close the loading indicator when all pages are rendered
                            Swal.close();
                        }
                    });
                });

            }

            // Adjust scale based on viewport size
            function adjustScale() {
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                    
                // Re-render the pages with the new scale
                if (pdfDoc) {
                    pdfContainer.innerHTML = ''; // Clear current pages
                    for (let i = 1; i <= pdfDoc.numPages; i++) {
                        renderPage(i);
                    }
                }
            }

    // Add event listener for resizing the window
    window.addEventListener('resize', adjustScale);

    // Initial call to adjust scale
    adjustScale();

    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        renderPage(1);
    });
    // // Create badges dynamically
    // function createBadges() {
    //     badges.forEach((badge, index) => {
    //         const badgeElement = document.createElement('div');
    //         badgeElement.className = 'badge badge-default';
    //         badgeElement.textContent = badge.name;
    //         badgeElement.draggable = true;
    //         badgeElement.dataset.index = index;

    //         badgeElement.addEventListener('dragstart', function(event) {
    //             event.dataTransfer.setData('badgeIndex', index);
    //         });

    //         document.getElementById('badgeContainer').appendChild(badgeElement);
    //     });
    // }

    // // Drag-and-Drop Handlers
    // function allowDrop(event) {
    //     event.preventDefault(); // Allow drop
    // }

    // function drop(event) {
    //     event.preventDefault();

    //     // Get badge index from dataTransfer
    //     const badgeIndex = event.dataTransfer.getData('badgeIndex');
    //     const badge = badges[badgeIndex];

    //     // Get the canvas element
    //     const canvas = event.target;

    //     if (!canvas) {
    //         console.error('Canvas element is undefined');
    //         return; // Avoid error if canvas is not found
    //     }

    //        // Calculate drop position relative to the canvas using offsetX and offsetY
    //     const x = event.offsetX;
    //     const y = event.offsetY;

    //     // Ensure the badge position is within bounds (not off the canvas)
    //     const canvasWidth = canvas.width;
    //     const canvasHeight = canvas.height;

    //     const adjustedX = Math.min(Math.max(0, x), canvasWidth); // Prevent badge from going off the left/right edges
    //     const adjustedY = Math.min(Math.max(0, y), canvasHeight)+30; // Prevent badge from going off the top/bottom edges

    //     // Save badge position
    //     badge.x = adjustedX;
    //     badge.y = adjustedY;

    //     // Draw badge on canvas
    //     const ctx = canvas.getContext('2d');
    //     ctx.fillStyle = 'blue';
    //     ctx.font = '12px Arial';
    //     ctx.fillText(badge.name, adjustedX, adjustedY);

    //     console.log(`Badge "${badge.name}" dropped at (${adjustedX}, ${adjustedY}).`);
    // }

    // // Fungsi untuk mendeteksi halaman tempat badge dijatuhkan
    // function getPageNumberFromEvent(event) {
    //     const rect = pdfContainer.getBoundingClientRect();
    //     const x = event.clientX - rect.left;
    //     const y = event.clientY - rect.top;

    //     // Menentukan halaman berdasarkan koordinat
    //     for (let i = 0; i < pageElements.length; i++) {
    //         const canvas = pageElements[i];
    //         if (canvas) {
    //             const canvasRect = canvas.getBoundingClientRect();

    //             if (x >= canvasRect.left && x <= canvasRect.right && y >= canvasRect.top && y <= canvasRect.bottom) {
    //                 return i + 1; // Kembalikan nomor halaman (indeks halaman dimulai dari 1)
    //             }
    //         }
    //     }
    //     return 1; // Kembalikan halaman 1 jika tidak ada kecocokan
    // }

    // createBadges();
    
    // Load a sample PDF (replace with your uploaded PDF)
   
</script>