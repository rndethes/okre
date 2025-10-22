<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Document</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('document/index/') . $document['id_space'] . "/space" ?>">Document</a></li>
              <li class="breadcrumb-item active" aria-current="page">Signature</li>
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
              <h3 class="mb-0"> Signature  </h3>
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
                 $checkstatus   = $CI->Space_model->checkSignatureStatus($iddocument,$nouser); 
                //  print_r($document['no_signature']);
                //  echo "<pre>";  print_r($checkstatus);exit();
                 
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
       
          <input type="hidden" id="statusapprovalsign" value="<?= $statuslastsign ?>">
          <div class="alert alert-primary" role="alert">
              <?php 
                if(empty($okrdoc)) {
                  $desc = 'Tidak Terhubung ke OKR';
                  $btn = '';
                } else {
                  $type = $okrdoc['type_doc_in_okr'];
                  $id   = $okrdoc['id_to_doc_in_okr'];                  

                  $datapj = checkProject($id,$type);

                  $nama = $datapj['namaokr'];
                  $idpj = $datapj['idokr'];
                  $idokr = $datapj['idobjective'];

                  $url = base_url('project/showKey/' . $idpj . '/' . $idokr);
                  $desc = 'Dokumen Terhubung ke OKR ' . $type . ' ' . $nama;
                  $btn = ' <a href="'.$url.'" target="_blank" class="btn btn-danger btn-sm closebtndoc text-white" type="button">Cek di OKR</a>';
                }
              ?>
                <span><strong>Note</strong> <?= $desc ?>!</span>
                <?= $btn ?>
            </div>
          <div class="row">
            
            
            <div class="col-lg-8">
                <div class="mb-2">
                    <label for="page-input">Go to Page:</label>
                    <div class="d-flex">
                    <input type="number" style="width:90px" class="form-control form-control-sm" id="page-input" min="1" placeholder="1">
                    <button id="go-to-page" class="btn btn-sm btn-primary ml-3">Go</button>
                    <a id="download" class="btn btn-sm btn-default" href="<?= base_url('assets/document/' . $fildpdf); ?>" download="<?= $fildpdf ?>">Download</a>
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
                            <?php if($document['id_project'] == 0) { ?>
                                <a id="kembalikehalaman" href="<?= base_url("/document/index/") . $this->session->userdata('workspace_sesi') . "/space" ?>" class="btn btn-lg rounded-pill btn-danger"><i class="ni ni-bold-left"></i></a>
                            <?php } else { ?>
                                <a id="kembalikehalaman" href="<?= base_url("/document/index/") . $document['id_project'] ?>" class="btn btn-lg rounded-pill btn-danger"><i class="ni ni-bold-left"></i></a>
                            <?php } ?>
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
                    <input type="hidden" id="urlsign" name="urlsign" value="<?= base_url('assets/img/signature/' . $users_name['signature_photo']); ?>">
                    <input type="hidden" id="current-approver" name="current-approver" value="<?= $users_name['nama'] ?>">
                    <input type="hidden" id="approval-level" value="<?= $document['no_signature'] ?>">
                    <input type="hidden" id="pdf-url" value="<?= base_url('assets/document/' . $namafolder . '/' . $fildpdf); ?>">


                    <?php if($lastdoc == "") { ?>
                    <div class="col-lg-12">
                        <div class="card card-frame">
                        <div class="card-header">
                        <h3 class="mb-0">Audit Tracker  </h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                <?php foreach($checkstatus as $audit) { 
                                    if( $audit['status_signature'] == '2') {
                                        $status = "approve";
                                        $colortext = "text-success";
                                    } else {
                                        $status = "-";
                                        $colortext = "text-warning";
                                    }

                                    if($audit['updated_date'] == '0000-00-00 00:00:00') {
                                        $update = "-";
                                    } else {
                                        $update = "pada tanggal";
                                    }
                                    ?>
                                    <li><span class="text-sm <?= $colortext ?>">Level <?= $audit['no_signature'] ?> Tanda Tangan Oleh :  <?= $audit['nama'] ?> status <?= $status ?></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                        

                          
                        
                        <!-- <div class="card-body insignature"> -->
                        <!-- <div id="signatures">
                            <img src="<?= base_url('assets/img/signature/' . $users_name['signature_photo']); ?>" id="signature1" class="signature" draggable="true" data-x="0" data-y="0" style="width: 100px; height: 50px; text-align: center; line-height: 50px;">
                        </div> -->
                        <!-- </div> -->
                       
                        </div>
                    </div>
                    <?php 
                         $notedoc   = $document['note_from_created'];

                        if($notedoc != NULL) {
                    ?>
                    <div class="col-lg-12">
                        <div class="card card-frame">
                        <div class="card-header">
                            <h3 class="mb-0">Note Dari Pembuat Dokumen  </h3>
                        </div>
                        <div class="card-body">
                            <?= $notedoc ?>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                   
                    <div class="col-lg-12">
                    <button class="btn btn-icon btn-info rounded-pill mb-3" id="ulangiSignature" type="button">
                            <span class="btn-inner--icon"><i class="fas fa-undo"></i></span>
                            <span class="btn-inner--text">Ulangi</span>
                        </button> 
                        <button class="btn btn-icon btn-success rounded-pill mb-3" id="simpanSignature" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                            <span class="btn-inner--text">Setujui</span>
                        </button> 
                        <button class="btn btn-icon btn-danger rounded-pill mb-3" id="rejectSignature" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            <span class="btn-inner--text">Tolak</span>
                        </button> 
                        <button class="btn btn-icon btn-warning rounded-pill mb-3" id="reviceSignature" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-curved-next"></i></span>
                            <span class="btn-inner--text">Revisi</span>
                        </button> 
                        <button class="btn btn-icon btn-info rounded-pill mb-3" id="chatSign" type="button">
                            <span class="btn-inner--icon"><i class="fas fa-comment"></i></span>
                        </button> 
                    </div>
                    <?php } ?>

                    <div id="signatureModalDoc" class="signature-modal">
                        <div class="signature-modal-content">
                           
                            <p>Apakah Anda Ingin Meletakan di posisi ini?</p>
                            <button id="confirmSignature" type="button" class="btn btn-success">Konfirmasi</button>
                            <button id="cancelSignature" type="button" class="btn btn-danger">Batal</button>

                        </div>
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
                          } else if($signlog['status_log'] == '4') {
                            $stat = '<span class="badge badge-warning">Revisi</span>';
                          } else if($signlog['status_log'] == '5') {
                            $stat = '<span class="badge badge-warning">Created By</span>'; 
                          }else {
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
      </div>
      
     
      
    </div>
    <div class="alert alert-default" role="alert">
        <span><strong>Catatan : </strong> <?= $document['note_signature'] ?></span>
    </div>

   

    <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
    
    <input type="hidden" id="urllast" value="<?= base_url('assets/document/' . $namafolder . '/' . $fildpdf); ?>">
    <input type="hidden" id="urllastnewnew" value="<?= base_url('assets/document/'  . $namafolder . '/'); ?>">
    <input type="hidden" id="currenturl" value="<?= base_url("seedocument/documentview/") ?>">
    <script>
        var approvals = <?php echo json_encode($checkstatus); ?>;
        console.log(approvals);
    </script>
   
    <script>
   

        const linkBack = localStorage.getItem('linkbackdoc');

        // Jika nilai ada, tambahkan ke input dengan id "linkback"
        if (linkBack) {
            console.log(linkBack)
            document.getElementById('linkback').value = linkBack;
            document.getElementById('kembalikehalaman').href = linkBack;
        }
    // Mengatur workerSrc
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

      

 


        document.getElementById('chatSign').addEventListener('click', async function() {
                        // Menampilkan SweetAlert dengan input text untuk keterangan
            const { value: textketerangan } = await Swal.fire({
                title: 'Berikan Komentar',
                input: 'textarea',
                inputLabel: 'Berikan Komentar (opsional)',
                inputPlaceholder: 'Ketik komentar di sini...',
                inputAttributes: {
                    'aria-label': 'Masukkan komentar'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
            });

            if (textketerangan !== undefined) { // Jika pengguna menekan Submit
                var iduser = document.getElementById("iduser").value;
                var chatroomid = document.getElementById("chatroomid").value;
                var iddocument = document.getElementById("iddocument").value;
                var idproject = document.getElementById("idproject").value;
                var linkback = document.getElementById("linkback").value;
                var namadok = document.getElementById("namadok").value;
                var spaceid = document.getElementById("spaceid").value;

                const formData = new FormData();

                formData.append('iduser', iduser);
                formData.append('chatroomid', chatroomid);
                formData.append('iddocument', iddocument);
                formData.append('idproject', idproject);
                formData.append('textketerangan', textketerangan || ''); 
                formData.append('namadok', namadok);
                formData.append('spaceid', spaceid);
               
                Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });


                fetch('<?= base_url('workspace/chatFromDocSpace'); ?>', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Menampilkan SweetAlert2
                            Swal.fire({
                                title: 'Success!',
                                text: 'Berhasil Mengirim Pesan!',
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
                                text: 'Gagal Mengirim Pesan.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

        })
        document.getElementById('ulangiSignature').addEventListener('click', async function() {
            var iddocumentsignature = document.getElementById("iddocumentsignature").value;
            var iduser = document.getElementById("iduser").value;
            var idproject = document.getElementById("idproject").value;

                const formData = new FormData();

                formData.append('iddocumentsignaturelast',iddocumentsignature);
                formData.append('iduserlast',iduser);
                formData.append('idproject',idproject);


                fetch('<?= base_url('document/ulangiDocument'); ?>', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Menampilkan SweetAlert2
                            Swal.fire({
                                title: 'Success!',
                                text: 'Berhasil Mengulangi!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                  
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal Mengulangi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            
        })

        document.getElementById('simpanSignature').addEventListener('click', async function() {
            // Menampilkan SweetAlert dengan input text untuk keterangan
            const { value: textketerangan } = await Swal.fire({
                title: 'Alasan Menyetujui',
                input: 'textarea',
                inputLabel: 'Masukkan alasan menyetujui (opsional)',
                inputPlaceholder: 'Ketik alasan menyetujui di sini...',
                inputAttributes: {
                    'aria-label': 'Masukkan alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
            });
            
        if (textketerangan !== undefined) { // Jika pengguna menekan Submit
            var iduser              = document.getElementById("iduser").value;
            var iddocument          = document.getElementById("iddocument").value;
            var statusapprovalsign  = document.getElementById("statusapprovalsign").value;
            var idproject  = document.getElementById("idproject").value;

  

            const currentUrl = `${currentturl}`;
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const currentTime = `${month}${day}${year}${hours}${minutes}`;
            const qrCodeData = `${qrurl}${currentTime}${iddocument}`;
            
            let reffQR;
            if (statusapprovalsign === "last") {
                reffQR = `${currentTime}${iddocument}`;
            } else {
                reffQR = "NULL";
            }
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

            const newFileName = document.getElementById('urllast').value.split('/').pop();
            const urlnew = `${urllastnewnew}${newFileName}`;
            
            const pdfBytes = await fetch(urlnew).then(res => res.arrayBuffer());
            const { PDFDocument, rgb } = PDFLib; 
            const pdfDoc = await PDFDocument.load(pdfBytes);
            const qrCodeImage = await pdfDoc.embedPng(qrCodeImageBytes);

          
            const pages = pdfDoc.getPages();
            const totalPagesBefore = pages.length; // Simpan jumlah halaman awal sebelum tanda tangan
            const lastPageIndex = totalPagesBefore - 1;
            const lastPage = pages[lastPageIndex];

            // **Ambil ukuran halaman pertama (asumsi semua halaman memiliki ukuran yang sama)**
            const { width: docWidth, height: docHeight } = pages[0].getSize();

            // **Cek apakah halaman terakhir adalah halaman tanda tangan sebelumnya**
            let isLastPageSignature = false;
            try {
                const extractedText = await lastPage.getText(); // Ambil teks halaman terakhir
                isLastPageSignature = extractedText.includes("AUDIT TRACKER"); // Deteksi jika ini halaman tanda tangan
            } catch (error) {
                console.error("Error extracting text:", error);
            }

            // **Jika sudah ada halaman tanda tangan sebelumnya, hapus sebelum menambahkan yang baru**
            if (isLastPageSignature) {
                pdfDoc.removePage(lastPageIndex);
            }

            // **Tambahkan halaman baru untuk tanda tangan terbaru**
            const signPage = pdfDoc.addPage([docWidth, docHeight]);

            // **Tambahkan teks "AUDIT TRACKER" di halaman baru**
            const { width: pageWidth, height: pageHeight } = signPage.getSize();
            signPage.drawText("AUDIT TRACKER", { 
                x: pageWidth / 2 - 50, 
                y: pageHeight - 50, 
                size: 20, 
                color: PDFLib.rgb(0, 0, 0) 
            });
         

            if (statusapprovalsign == "last") {
                   // **Dapatkan jumlah halaman terbaru setelah Audit Tracker ditambahkan**
                const updatedTotalPages = pdfDoc.getPageCount();
                const lastUserPageIndex = updatedTotalPages - 2; // Halaman sebelum Audit Tracker
                const activePage = pdfDoc.getPage(lastUserPageIndex);
                const { width: lastPageWidth, height: lastPageHeight } = activePage.getSize();
                const qrSize = 50;

                // Menambahkan QR Code ke pojok kanan bawah PDF di halaman sebelum Audit Tracker
                const qrCodeImage = await pdfDoc.embedPng(qrCodeImageBytes);
                const qrCodeWidth = 50;
                const qrCodeHeight = 50;

                activePage.drawImage(qrCodeImage, {
                    x: lastPageWidth - qrCodeWidth - 10,
                    y: 10,
                    width: qrCodeWidth,
                    height: qrCodeHeight,
                });
            }

            // **Mulai dari posisi di bawah judul**
            let yOffset = pageHeight - 80;

            // **Loop semua tanda tangan dari database**
            for (const approval of approvals) {
                const { no_signature, nama, signature_photo } = approval;

                // Ambil tanggal sekarang
                const dateNow = new Date();

                // Format tanggal ke "8 Maret 2025, 14:30"
                const options = { 
                    day: "numeric", 
                    month: "long", 
                    year: "numeric", 
                    hour: "2-digit", 
                    minute: "2-digit",
                    hour12: false // Gunakan format 24 jam
                };

                // Format tanggal dan waktu
                const formattedDate = dateNow.toLocaleString("id-ID", options);

                // Tambahkan teks tanda tangan
                signPage.drawText(`Level tanda tangan ${no_signature} oleh: ${nama} approve tanggal ${formattedDate}`, { 
                    x: 50, 
                    y: yOffset, 
                    size: 10,  // Ukuran font lebih kecil
                    color: PDFLib.rgb(0, 0, 0) 
                });

                // **Ambil gambar tanda tangan dari server**
                const signatureUrl = `<?= base_url('assets/img/signature/')?>${signature_photo}`;
                const signatureImageBytes = await fetch(signatureUrl).then(res => res.arrayBuffer());
                const signatureImage = await pdfDoc.embedPng(signatureImageBytes);

                // **Posisi tanda tangan di sebelah kanan teks**
                signPage.drawImage(signatureImage, {
                    x: pageWidth - 150, // Geser ke kanan
                    y: yOffset - 10, 
                    width: 80, 
                    height: 45,
                });

                // Geser ke bawah untuk tanda tangan berikutnya
                yOffset -= 50;
            }

            const newPdfBytes = await pdfDoc.save();
        
            const formData = new FormData();
            
            var nosignature         = document.getElementById("nosignature").value;
            var iddocumentsignature = document.getElementById("iddocumentsignature").value;
            var namadokumen         = document.getElementById("namadokumen").value;
            var statussignature     = "Approve";
            var linkback            = document.getElementById("linkback").value;

            formData.append('file', new Blob([newPdfBytes], { type: 'application/pdf' }), 'signed_document.pdf');

            formData.append('iduser',iduser);
            formData.append('iddocument',iddocument);
            formData.append('nosignature',nosignature);
            formData.append('iddocumentsignature',iddocumentsignature);
            formData.append('textketerangan', textketerangan || ''); 
            formData.append('namadokumen',namadokumen);
            formData.append('statussignature',statussignature);
            formData.append('qrcode',reffQR);
            formData.append('aprovaluser',statusapprovalsign);
            formData.append('myurl',linkback);

            if (statusapprovalsign === "last") {
              Swal.fire({
                  title: 'Approval Terakhir',
                  text: 'Apakah Anda ingin mengirim email setelah menyimpan PDF?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonText: 'Kirim dengan Email',
                  cancelButtonText: 'Tanpa Email',
                  showDenyButton: true,  // Menambahkan opsi Cancel
                  denyButtonText: 'Cancel',
              }).then((result) => {
                  if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                      // Jika pengguna memilih untuk mengirim dengan email
                      fetch('<?= base_url('document/save_signed_pdf'); ?>', {
                          method: 'POST',
                          body: formData
                      }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              // Menampilkan SweetAlert2
                              Swal.fire({
                                  title: 'Success!',
                                  text: 'PDF berhasil disimpan dan kamu akan diarahkan ke halaman email!',
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      // Redirect ke halaman pengiriman email
                                      window.location.href = "<?= base_url('document/setEmailPublish/' . $document['id_project'] . '/' . $document['id_document'] . '/fristdoc'); ?>";  // Ganti dengan URL halaman pengiriman email
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
                    } else if (result.isDenied) {
                     // Jika pengguna memilih "Cancel", tidak ada tindakan yang diambil
                     Swal.fire('Perubahan dibatalkan', '', 'info');
                  } else {
                    Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                      // Jika pengguna memilih tanpa email
                      fetch('<?= base_url('document/save_signed_pdf'); ?>', {
                          method: 'POST',
                          body: formData
                      }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              Swal.fire({
                                  title: 'Success!',
                                  text: 'PDF berhasil disimpan!',
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                              }).then((result) => {
                                  if (result.isConfirmed) {
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
                  }
                });
              } else {
                Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Jika bukan approval terakhir, langsung simpan PDF tanpa opsi email
                    fetch('<?= base_url('document/save_signed_pdf'); ?>', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'PDF berhasil disimpan!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
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
                }
            }

          });


          document.getElementById('rejectSignature').addEventListener('click', async function() {
           
            // Menampilkan SweetAlert dengan input text untuk keterangan
            const { value: textketerangan } = await Swal.fire({
                title: 'Alasan Penolakan',
                input: 'textarea',
                inputLabel: 'Masukkan alasan penolakan (opsional)',
                inputPlaceholder: 'Ketik alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Masukkan alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
            });

            if (textketerangan !== undefined) { // Jika pengguna menekan Submit
                var iduser = document.getElementById("iduser").value;
                var iddocument = document.getElementById("iddocument").value;
                var nosignature = document.getElementById("nosignature").value;
                var iddocumentsignature = document.getElementById("iddocumentsignature").value;
                var namadokumen = document.getElementById("namadokumen").value;
                var statussignature = "Reject";
                var linkback = document.getElementById("linkback").value;

                const formData = new FormData();

                formData.append('iduser', iduser);
                formData.append('iddocument', iddocument);
                formData.append('nosignature', nosignature);
                formData.append('iddocumentsignature', iddocumentsignature);
                formData.append('textketerangan', textketerangan || ''); // Mengisi keterangan dengan teks yang diinput atau kosong
                formData.append('namadokumen', namadokumen);
                formData.append('statussignature', statussignature);
                formData.append('myurl', linkback);

                  // Menampilkan loading sebelum memulai fetch
                    Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                fetch('<?= base_url('document/reject_signed_pdf'); ?>', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        Swal.close(); // Menutup loading SweetAlert
                        if (data.success) {
                            // Menampilkan SweetAlert2
                            Swal.fire({
                                title: 'Success!',
                                text: 'PDF berhasil ditolak!',
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
                        Swal.close(); // Menutup loading SweetAlert
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengirim data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }
            // Jika pengguna menekan Cancel, tidak ada tindakan yang diambil
        });

        document.getElementById('reviceSignature').addEventListener('click', async function() {
            // Menampilkan SweetAlert dengan input text untuk keterangan
            const { value: textketerangan } = await Swal.fire({
                title: 'Alasan Revisi',
                input: 'textarea',
                inputLabel: 'Masukkan alasan revisi (opsional)',
                inputPlaceholder: 'Ketik alasan revisi di sini...',
                inputAttributes: {
                    'aria-label': 'Masukkan alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
            });

            if (textketerangan !== undefined) { // Jika pengguna menekan Submit
                var iduser = document.getElementById("iduser").value;
                var iddocument = document.getElementById("iddocument").value;
                var nosignature = document.getElementById("nosignature").value;
                var iddocumentsignature = document.getElementById("iddocumentsignature").value;
                var namadokumen = document.getElementById("namadokumen").value;
                var statussignature = "Revisi";
                var linkback = document.getElementById("linkback").value;

                const formData = new FormData();

                formData.append('iduser', iduser);
                formData.append('iddocument', iddocument);
                formData.append('nosignature', nosignature);
                formData.append('iddocumentsignature', iddocumentsignature);
                formData.append('textketerangan', textketerangan || ''); // Mengisi keterangan dengan teks yang diinput atau kosong
                formData.append('namadokumen', namadokumen);
                formData.append('statussignature', statussignature);
                formData.append('myurl', linkback);

                Swal.fire({
                        title: 'Mengirim Data...',
                        text: 'Tunggu beberapa saat...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });


                fetch('<?= base_url('document/revisi_signed_pdf'); ?>', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Menampilkan SweetAlert2
                            Swal.fire({
                                title: 'Success!',
                                text: 'PDF berhasil direvisi!',
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
            }
            // Jika pengguna menekan Cancel, tidak ada tindakan yang diambil
        });
    </script>
  



  
            