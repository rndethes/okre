<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start Your OKR With OKRE System">
  <meta name="author" content="Creative Tim">
  <title><?= $title; ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/'); ?>img/logo_web.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">


  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/fixedColumns.dataTables.min.css">

  <style>
      @media (max-width: 500px) {
    canvas.pdf-page {
      width: 423px;
      margin-left: -34px;
    }
  }
  </style>
  <!-- Page plugins -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/argon.css?v=1.2.0" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.js"></script>
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>


  
  <style>
       .pdf {
        width: 100%;
        aspect-ratio: 4 / 3;
    }

    .pdf,
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    
      
    </style>

</head>



<body>

  <div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
    </div>
  </div>

  <div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <?php if(empty($file)) { ?>
            <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
            <div class="alert alert-danger" role="alert">
                <h1 class="mb-0 text-white">FILE PDF TIDAK TERFERIFIKASI</h1>
            </div>
            
            </div>
        <?php } else { ?>
            <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
            <div class="alert alert-default" role="alert">
                <h1 class="mb-0 text-white">FILE PDF TERVERIFIKASI SISTEM  <?= $generate ?></h1>
            </div>
            
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
        <div class="d-flex">
        <input type="number" style="width:90px" class="form-control form-control-sm" id="page-input" min="1" placeholder="1">
                    <button id="go-to-page" class="btn btn-sm btn-primary ml-3">Go</button>
                    </div>    
        <div id="pdf-container" style="overflow-y: scroll; height: 1270px;">
                    <!-- Pages will be rendered here -->
                </div>
         
      </div>
        <?php } ?>
       
      </div>
  
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
              &copy; 2022 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Ethes Tech | PT Ethes Teknologi Makmur</a>
            </div>
          </div>
        </div>
      </footer>
      
     

      <script src="<?= base_url('assets/') ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/js-cookie/js.cookie.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
      <script src="<?= base_url('assets/') ?>js/components/vendor/nouislider.min.js"></script>
      <!-- Optional JS -->
      <script src="<?= base_url('assets/') ?>vendor/chart.js/dist/Chart.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/chart.js/dist/Chart.extension.js"></script>
      <!-- Module Script -->
      <!-- Argon JS -->
      <script src="<?= base_url('assets/') ?>js/argon.js?v=1.2.0"></script>
      <script src="<?= base_url('assets/') ?>vendor/select2/dist/js/select2.min.js"></script>
      <script src="<?= base_url('assets/') ?>js/bootstrap-select.js"></script>
      <script src=" <?= base_url('assets/'); ?>js/sweetalert/sweetalert2.all.min.js"></script>

      <input type="hidden" id="urllast" value="<?= base_url('assets/document/' . $namafolder .'/'. $file['file_signature']) ?>">
      <input type="hidden" id="urllastnewnew" value="<?= base_url('assets/document/' . $namafolder .'/'. $file['file_signature']) ?>">
      <input type="hidden" id="currenturl" value="<?= base_url('assets/document/' . $namafolder .'/'. $file['file_signature']) ?>">
    
          <script>
             pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.worker.min.js';

            const url = document.getElementById("urllast").value;
            const urllastnewnew = document.getElementById("urllastnewnew").value;
            const currentturl = document.getElementById("urllastnewnew").value;
                const qrurl = document.getElementById("currenturl").value;

            var pdfjsLib = window['pdfjs-dist/build/pdf'];

            var pdfDoc = null,
                scale = 1.5,
                pdfContainer = document.getElementById('pdf-container'),
                pageElements = []; // Array to keep track of page elements

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
                            
                        // scale = Math.min(viewportWidth / 100, viewportHeight / 1200);
                            
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
            // Handle page navigation
                    document.getElementById('go-to-page').addEventListener('click', function() {
                        var pageNumber = parseInt(document.getElementById('page-input').value, 10);

                        if (pdfDoc && pageNumber > 0 && pageNumber <= pdfDoc.numPages) {
                            var targetPage = pageElements[pageNumber];

                            if (targetPage) {
                                // Scroll to the target page
                                targetPage.scrollIntoView({ behavior: 'smooth' });
                            } else {
                                // If the page is not yet rendered, wait for it to render
                                pdfDoc.getPage(pageNumber).then(function(page) {
                                    // Create canvas element dynamically
                                    var canvas = document.createElement('canvas');
                                    canvas.className = 'pdf-page';
                                    canvas.setAttribute('data-page-number', pageNumber); // Set data-page-number attribute
                                    var ctx = canvas.getContext('2d');
                                    var viewport = page.getViewport({ scale: scale });
                                    canvas.height = viewport.height;
                                    canvas.width = viewport.width;

                                    var renderContext = {
                                        canvasContext: ctx,
                                        viewport: viewport
                                    };

                                    page.render(renderContext).promise.then(function() {
                                        pdfContainer.appendChild(canvas);
                                        pageElements[pageNumber] = canvas;
                                        canvas.scrollIntoView({ behavior: 'smooth' });
                                    });
                                });
                            }
                        }
                    });
          </script>
  
      </body>

      </html>


  

  