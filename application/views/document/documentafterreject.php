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
                 $iddocument         = $this->uri->segment(3);

                 if( $iddocument == 'space') {
                  $iddocument         = $this->uri->segment(4);
                 }

                 $CI = &get_instance();
                 $CI->load->model('Space_model');

                 $filesignature   = $CI->Space_model->checkSignatureFile($iddocument);
                 $allsign   = $CI->Space_model->checkAllSignatureFile($iddocument);

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

                $checkstatus   = $CI->Space_model->checkSignatureStatus($iddocument,$nouser); 

               // print_r($iddocument);exit();

              

            ?>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body padding-edit">
        <?php if($document['id_project'] == 0) { ?>
            <input type="hidden" id="linkback" name="linkback" value="<?= base_url("document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>">
         <?php } else { ?>
            <input type="hidden" id="linkback" name="linkback" value="<?= base_url("document/index/") . $document['id_project'] ?>">
         <?php } ?>
        <div class="row">
        <div class="col-lg-8">
                <div class="mb-2">
                  <button id="prev-page" class="btn btn-sm btn-primary">Previous</button>
                  <button id="next-page" class="btn btn-sm btn-primary">Next</button>
                  <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                  <a id="download" class="btn btn-sm btn-primary" href="<?= base_url('assets/document/'.$namafolder.'/'. $fildpdf); ?>" download="<?= $fildpdf ?>">Download</a>
                  </div>
                  <canvas id="pdf-canvas" class="canvaspdf"></canvas> 
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

                               
                        </div>
                        </div>
                    </div>
                    <?php if($lastdoc == "") { ?>
                                      <div class="col-lg-12">
                                        <div class="card card-frame">
                                          <div class="card-header">
                                            <h3 class="mb-0"><span class="badge badge-lg badge-pill badge-default"><i class="fas fa-signature"></i></span> Audit Tracker  </h3>
                                          </div>
                                            <div class="card-body">
                                                
                                            <?php foreach($checkstatus as $audit) { 
                                                if( $audit['status_signature'] == '2') {
                                                    $status = "approve";
                                                    $colortext = "text-success";
                                                    $statesign = '<span class="badge badge-success mr-1"><i class="fas fa-check"></i></span>';
                                                } else  if( $audit['status_signature'] == '1') { 
                                                    $status = "-";
                                                    $colortext = "";
                                                    $statesign = '<span class="badge badge-info mr-1"><i class="fas fa-clock"></i></span>';
                                                } else {
                                                    $status = "reject";
                                                    $colortext = "text-danger";
                                                    $statesign = '<span class="badge badge-danger mr-1"><i class="fas fa-times"></i></span>';
                                                }
                                                if($audit['updated_date'] == '0000-00-00 00:00:00') {
                                                    $updateddate = "-";
                                                } else {
                                                    $updateddate = "pada tanggal " . date("j F Y H:i",strtotime($audit['updated_date']));
                                                }
                                                ?>
                                                <?= $statesign ?><span class="text-sm <?= $colortext ?>">Level <?= $audit['no_signature'] ?> Tanda Tangan Oleh :  <?= $audit['nama'] ?> status <?= $updateddate ?></span>
                                                <br>
                                          <?php } ?>
                                        </div>
                                      </div>
                                  </div>
                              <?php } ?>
                  
             
                   
                    <div class="col-lg-12 mb-3">
                      <?php $space = $this->uri->segment(3); ?>
                      <?php if($space == 'space') { ?>
                        <a href="<?= base_url("document/index/") . $document['id_space'] . '/' . $space ?>" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                            <span class="btn-inner--text">Kembali</span>
                        </a>
                      <?php } else { ?>
                        <a href="<?= base_url("document/documentAtSpace/") . $document['id_space'] ?>" class="btn btn-danger rounded-pill text-white"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                            <span class="btn-inner--text">Kembali</span>
                        </a>
                      <?php } ?>
                        
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
                
               
                   
                           
            </div>
            </div>
            <?php 
                $alldoc   = $CI->Space_model->checkDocument($document['id_document']);
            ?>
            <?php foreach($alldoc as $all) { ?>

              <div class="alert alert-danger" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Catatan Dari <?= $all['nama'] ?> : </strong> <?= $all['note_signature'] ?></span>
            </div>
            <?php } ?>

            
           
        </div>
        

         

        </div>
      </div>
    </div>
   

    <script>
  // Mengatur workerSrc
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.worker.min.js';

  const url = '<?= base_url('assets/document/'.$namafolder.'/'. $fildpdf); ?>';
  var pdfjsLib = window['pdfjs-dist/build/pdf'];

  var pdfDoc = null,
          pageNum = 1,
          pageRendering = false,
          pageNumPending = null,
          scale = 1.5,
          canvas = document.getElementById('pdf-canvas'),
          ctx = canvas.getContext('2d');

      function renderPage(num) {
          pageRendering = true;
          pdfDoc.getPage(num).then(function(page) {
              var viewport = page.getViewport({ scale: scale });
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              var renderContext = {
                  canvasContext: ctx,
                  viewport: viewport
              };
              var renderTask = page.render(renderContext);
              renderTask.promise.then(function() {
                  pageRendering = false;
                  if (pageNumPending !== null) {
                      renderPage(pageNumPending);
                      pageNumPending = null;
                  }
              });
          });

          document.getElementById('page-num').textContent = num;
      }

      function queueRenderPage(num) {
          if (pageRendering) {
              pageNumPending = num;
          } else {
              renderPage(num);
          }
      }

      function onPrevPage() {
          if (pageNum <= 1) {
              return;
          }
          pageNum--;
          queueRenderPage(pageNum);
      }

      function onNextPage() {
          if (pageNum >= pdfDoc.numPages) {
              return;
          }
          pageNum++;
          queueRenderPage(pageNum);
      }

      document.getElementById('prev-page').addEventListener('click', onPrevPage);
      document.getElementById('next-page').addEventListener('click', onNextPage);

      pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
          pdfDoc = pdfDoc_;
          document.getElementById('page-count').textContent = pdfDoc.numPages;
          renderPage(pageNum);
      });

      interact('.signature')
        .draggable({
          listeners: {
            start(event) {
              event.target.classList.add('dragging');
            },
            move: function(event) {
              var target = event.target;
              var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
              var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

              target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

              target.setAttribute('data-x', x);
              target.setAttribute('data-y', y);
            },
            end(event) {
              event.target.classList.remove('dragging');
            }
          }
        })
        .resizable({
          edges: { left: true, right: true, bottom: true, top: true },
          listeners: {
            start(event) {
              event.target.classList.add('resizing');
            },
            move: function(event) {
              var target = event.target;
              var x = (parseFloat(target.getAttribute('data-x')) || 0);
              var y = (parseFloat(target.getAttribute('data-y')) || 0);

              target.style.width = event.rect.width + 'px';
              target.style.height = event.rect.height + 'px';

              x += event.deltaRect.left;
              y += event.deltaRect.top;

              target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

              target.setAttribute('data-x', x);
              target.setAttribute('data-y', y);
            },
            end(event) {
              event.target.classList.remove('resizing');
            }
          }
        });

        document.getElementById('simpanSignature').addEventListener('click', async function() {
            var iduser              = document.getElementById("iduser").value;
            var iddocument          = document.getElementById("iddocument").value;

            const currentUrl = window.location.href;
            // Ambil waktu saat ini
            const now = new Date();

            // Ambil bagian-bagian tanggal dan waktu
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');  // getMonth() dimulai dari 0, jadi tambahkan 1
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            // Gabungkan bagian-bagian tersebut menjadi format YmdHi
            const currentTime = `${year}${month}${day}${hours}${minutes}`;

            const qrCodeData = `${currentUrl} ${currentTime} ${iddocument}`;

            const reffQR     = `${currentTime} ${iddocument}`

            // Buat div dan QR Code
            const qrCodeDiv = document.createElement('div');
            const qrCode = new QRCode(qrCodeDiv, {
                text: qrCodeData,
                width: 50,
                height: 50
            });

             // Tunggu sampai QR Code dibuat
           await new Promise(resolve => setTimeout(resolve, 500));

          // Ambil QR Code dari canvas dan konversi ke PNG
              const qrCanvas = qrCodeDiv.querySelector('canvas');
              const qrCodeImageUrl = qrCanvas.toDataURL('image/png');
              const qrCodeImageBytes = await fetch(qrCodeImageUrl).then(res => res.arrayBuffer());


            const pdfBytes = await fetch(url).then(res => res.arrayBuffer());
            const { PDFDocument } = PDFLib;
            const pdfDoc = await PDFDocument.load(pdfBytes);

            const signatureDataUrl = document.getElementById('signature1').src;
            const signatureImageBytes = await fetch(signatureDataUrl).then(res => res.arrayBuffer());
            const signatureImage = await pdfDoc.embedPng(signatureImageBytes);

            const page = pdfDoc.getPages()[pageNum - 1];
            const { width: imgWidth, height: imgHeight } = await signatureImage.scale(1);

            // Get signature position and size
            const signature = document.getElementById('signature1');
            const rect = signature.getBoundingClientRect();
            const canvasRect = document.getElementById('pdf-canvas').getBoundingClientRect();
            const pdfPageWidth = page.getWidth();
            const pdfPageHeight = page.getHeight();

            const x = (rect.left - canvasRect.left) / canvasRect.width * pdfPageWidth;
            const y = (canvasRect.height - (rect.top - canvasRect.top) - rect.height) / canvasRect.height * pdfPageHeight;

            page.drawImage(signatureImage, {
                x: x,
                y: y,
                width: signature.width,
                height: signature.height,
            });

             // Menambahkan QR Code ke pojok kanan bawah PDF
              const qrCodeImage = await pdfDoc.embedPng(qrCodeImageBytes);
              const qrCodeWidth = 50;  // Lebar QR Code
              const qrCodeHeight = 50;  // Tinggi QR Code
              page.drawImage(qrCodeImage, {
                  x: pdfPageWidth - qrCodeWidth - 10,
                  y: 10,
                  width: qrCodeWidth,
                  height: qrCodeHeight,
              });

            const newPdfBytes = await pdfDoc.save();

            const formData = new FormData();


            var nosignature         = document.getElementById("nosignature").value;
            var iddocumentsignature = document.getElementById("iddocumentsignature").value;
            var textketerangan      = document.getElementById("textketerangan").value;
            var namadokumen         = document.getElementById("namadokumen").value;
            var statussignature     = "Approve";
            var linkback            = document.getElementById("linkback").value;

            formData.append('file', new Blob([newPdfBytes], { type: 'application/pdf' }), 'signed_document.pdf');

            formData.append('iduser',iduser);
            formData.append('iddocument',iddocument);
            formData.append('nosignature',nosignature);
            formData.append('iddocumentsignature',iddocumentsignature);
            formData.append('textketerangan',textketerangan);
            formData.append('namadokumen',namadokumen);
            formData.append('statussignature',statussignature);
            formData.append('qrcode',reffQR);


            fetch('<?= base_url('document/save_signed_pdf'); ?>', {
            method: 'POST',
            body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                 // Menampilkan SweetAlert2
                  Swal.fire({
                      title: 'Success!',
                      text: 'PDF berhasil disimpan!',
                      icon: 'success',
                      confirmButtonText: 'OK'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Redirect setelah SweetAlert2 ditutup
                          window.location.href = linkback;
                      }
                  });
                } else {
                  Swal.fire({
                    title: 'Error!',
                    text: 'Gagal menyimpan PDF.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

    });


    
    </script>
  



  
            