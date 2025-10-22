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
      <div class="card ">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0"> Data Dokumen  </h3>
            </div>
            <?php 
                 $iddocument   = $document['id_document'];
                 $idspace   = $document['id_space'];

                 $idusers           = $this->session->userdata("id");

                 $CI = &get_instance();
                 $CI->load->model('Space_model');
                 $CI->load->model('Account_model');


                 $filesignature     = $CI->Space_model->checkSignatureFile($iddocument);
                 $allsign           = $CI->Space_model->checkAllSignatureFile($iddocument);

                 
                if($document['id_project'] != 0) {
                    $chatroom           = $CI->Space_model->checkIdChatRoom($document['id_project']);
                
                    if($chatroom) {
                       $idchatroom   = $chatroom["id_mcr"];
                    } else {
                       $idchatroom = "0";
                    }
                } else {
                    $idchatroom = "0";
                }
                
                 $usersdoc     = $CI->Account_model->getAccountById($idusers);

                if($lastdoc != "") {
                    $fildpdf = $lastdoc;
                } else {
                 if(empty($filesignature)) {
                    $fildpdf = $document['file_document'];
                 } else {
                    $fildpdf = $filesignature['file_signature'];
                 }

                }
                
                $nouser = $document['no_signature'];
                
                $checkLastNo   = $CI->Space_model->checkLastNoSignature($iddocument);


                if($nouser == $checkLastNo["no_signature"]) {
                  $statuslastsign ="last";
                } else {
                  $statuslastsign ="first";
                }   
                 $checkAllSign   = $CI->Space_model->checkSignature($iddocument);
            ?>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body padding-edit">
          <input type="hidden" id="linkback" value="<?= base_url("document/documentAtSpace/") ?>">
        <div class="row">
        <div class="col-lg-8">
                <div class="mb-2">
                    <label for="page-input">Go to Page:</label>
                    <div class="d-flex">
                    <input type="number" style="width:90px" class="form-control form-control-sm" id="page-input" min="1" placeholder="1">
                    <button id="go-to-page" class="btn btn-sm btn-primary ml-3">Go</button>
                    <a id="download" class="btn btn-sm btn-default" href="<?=  base_url('assets/document/' . $namafolder . '/' . $fildpdf); ?>" download>Download</a>
                    <span class="badge badge-lg badge-info"><?= $usersdoc['nama'] ?> Tanda Tangan No : <b><?= $document['no_signature']  ?></b></span>
                    </div> 
                </div>    
                <div id="pdf-container" style="overflow-y: scroll; height: 1270px;">
                    <!-- Pages will be rendered here -->
                </div>
            </div>
        <div class="col-lg-4">
                <div class="row">
                <div class="col-lg-12">
                        <div class="card card-frame">
                            <div class="card-header">
                           
                            <div class="row align-items-center">
                            <div class="col-8">
                            <h3 class="mb-0">Detail Dokumen</h3>
                            </div>
                            <div class="col-4 text-right">
                            
                            </div>
                            </div>
                            </div>
                        <div class="card-body">
                            <h3><?= $document['name_document'] ?></h3>
                                <div class="text-sm"><b>Dibuat Oleh : </b><?= $document['nama'] ?></div>
                                <div class="text-sm"><b>Dibuat Tanggal : </b><?= date("j F Y H:i") ?></div>
                                <input type="hidden" id="iduser" name="iduser" value="<?= $document['id_user_doc'] ?>">
                                <input type="hidden" id="iddocument" name="iddocument" value="<?= $document['id_document'] ?>">
                                <input type="hidden" id="nosignature" name="nosignature" value="<?= $document['no_signature'] ?>">
                                <input type="hidden" id="iddocumentsignature" name="iddocumentsignature" value="<?= $document['id_doc_signature'] ?>">
                                <input type="hidden" id="namadokumen" name="namadokumen" value="<?= $document['name_document'] ?>">
                                <input type="hidden" id="idproject" name="idproject" value="<?= $document['id_project'] ?>">
                                <input type="hidden" id="chatroomid" name="chatroomid" value="<?= $idchatroom ?>">
                                <input type="hidden" id="namadok" name="namadok" value="<?= $document['nama'] ?>">
                                <input type="hidden" id="spaceid" name="spaceid" value="<?= $idspace ?>">
                                
                                <?php foreach($checkAllSign as $cas) { 
                                    if($cas['status_signature'] == '1') {
                                        $state = '<span class="badge badge-info mr-1"><i class="fas fa-clock"></i></span>';
                                    } else if($cas['status_signature'] == '2') {
                                        $state = '<span class="badge badge-success mr-1"><i class="fas fa-check"></i></span>';
                                    } else {
                                        $state = '<span class="badge badge-danger mr-1"><i class="fas fa-times"></i></span>';
                                    }
                                    ?>
                                    <small><?= $cas['nama'] ?> No : <?= $cas['no_signature'] ?></small><?= $state ?>
                                <?php } ?>
                        </div>
                        </div>
                    </div>
                  
             
                   
                    <div class="col-lg-12 mb-3">
                    <button id="publish" data-idspace="<?= $document['id_space'] ?>" data-iddocument="<?= $document['id_document'] ?>" data-status="afterpublish" data-status="afterpublish"  data-prj="<?= $document['id_project'] ?>" class="btn btn-info rounded-pill text-white">
                                            <span class="btn--inner-icon">
                                            <i class="ni ni-email-83"></i></span>
                                            <span class="btn-inner--text">Publish</span>
                                        </button>
                        <a href="<?= base_url("document/documentAtSpace/") . $document['id_space'] ?>" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                            <span class="btn-inner--text">Kembali</span>
                        </a>
                    </div>
                 
                    <div class="col-lg-12">
                        <div class="card card-frame">
                            <div class="card-header">
                            <h3 class="mb-0">Status</h3>
                            </div>
                        <div class="card-body statuslogcard">
                        <?php foreach($signaturelog as $signlog) { ?>
                        <?php 
                          if($signlog['status_log'] == '1') {
                            $stat = '<span class="badge badge-info">Viewed</span>';
                          } else if($signlog['status_log'] == '2') {
                            $stat = '<span class="badge badge-success">Approved</span>';
                          } else {
                            $stat = '<span class="badge badge-danger">Reject</span>';
                          }
                          
                          ?>
                        <div class="list-group list-group-flush">
                        <h4 class="mt-3 mb-1"><?= $stat ?> By : <?= $signlog['nama_log'] ?></h4>
                        <p class="text-sm mb-0">At <?= date("d F Y H:i",strtotime($signlog['updated_date_doc_signature'])) ?></p> 
                        </div>
                        <?php } ?>

                        </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-default" role="alert">
                    <span><strong>Catatan : </strong> <?= $document['note_signature'] ?></span>
                </div>
                <input type="hidden" id="urllast" value="<?= base_url('assets/document/' . $namafolder . '/' . $fildpdf); ?>">
                <input type="hidden" id="urllastnewnew" value="<?= base_url('assets/document/'  . $namafolder . '/'); ?>">
                <input type="hidden" id="currenturl" value=" <?= base_url("seedocument/documentview/") ?>">
                            
                          
                              
                                      
                        </div>
                        </div>
                    </div>
                    

                    </div>
                  </div>
                </div>
              

    <script>
  // Mengatur workerSrc
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.worker.min.js';

  const url = document.getElementById("urllast").value;
  const urllastnewnew = document.getElementById("urllastnewnew").value;
  const currentturl = document.getElementById("urllastnewnew").value;

  

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
  



  
            