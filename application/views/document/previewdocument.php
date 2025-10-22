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
               
                   
                    <div class="col-lg-12">
                    <!-- <button class="btn btn-icon btn-info rounded-pill mb-3" id="ulangiSignature" type="button">
                            <span class="btn-inner--icon"><i class="fas fa-undo"></i></span>
                            <span class="btn-inner--text">Ulangi</span>
                        </button>  -->
                   
                    </div>
                   

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
    
    <input type="hidden" id="urllast" value="<?= base_url('assets/document/' . $namafolder . '/' . $fildpdf); ?>">
    <input type="hidden" id="urllastnewnew" value="<?= base_url('assets/document/'  . $namafolder . '/'); ?>">
    <input type="hidden" id="currenturl" value=" <?= base_url("seedocument/documentview/") ?>">
   

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

        // Function to update the PDF
            async function updateAndRenderPDF() {
                try {
                    // Menampilkan loading SweetAlert
                    Swal.fire({
                        title: 'Loading PDF...',
                        text: 'Please wait while the PDF is being processed.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    const newFileName = document.getElementById('urllast').value.split('/').pop(); // Get new file name
                    const urlnew = `${urllastnewnew}${newFileName}`;
                    
                    console.log('Loading new PDF from:', urlnew);

                    // Clear current PDF
                    pdfContainer.innerHTML = '';

                    // Load new PDF
                    const pdf = await pdfjsLib.getDocument(urlnew).promise;
                    pdfDoc = pdf;

                    // Render first page
                    renderPage(1);
                } catch (error) {
                    console.error('Error updating and rendering PDF:', error);
                } 
            }
    

        // Event listener untuk memunculkan modal dengan smooth
            function showModal(modal) {
                modal.classList.add('show');
                const content = modal.querySelector('.signature-modal-content');
                content.classList.add('show');
            }

            function hideModal(modal) {
                const content = modal.querySelector('.signature-modal-content');
                content.classList.remove('show');
                const signature = document.getElementById('signature1');
                modal.style.opacity = 0;
    

                signature.style.width= "100px";
                signature.style.height= "50px";
                setTimeout(() => {
                    modal.classList.remove('show');
                    modal.style.display = 'none';
                }, 300); // Delay sesuai dengan durasi transisi
            }   

        

            // Menyimpan referensi modal dan tombol untuk reuse
                const modal = document.getElementById('signatureModalDoc');
                const confirmButton = document.getElementById('confirmSignature');
                const cancelButton = document.getElementById('cancelSignature');
    
                const pdfPages = document.querySelectorAll('.pdf-page');

                // Untuk menyimpan sementara tanda tangan
                let currentSignature = null;
                let signatureData = [];
                let newPdfBytes; 
                async function addSignaturesToPDF() {
                    try {
                        Swal.fire({
                        title: 'Loading PDF...',
                        text: 'Menyimpan Letak Tanda Tangan.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                        const newFileName = document.getElementById('urllast').value.split('/').pop(); // Dapatkan nama file baru
                        const urlnew = `${urllastnewnew}${newFileName}`;
                        
                        // Ambil file PDF yang sudah diupload
                        const pdfBytes = await fetch(urlnew).then(res => res.arrayBuffer());
                        const { PDFDocument } = PDFLib;
                        const pdfDoc = await PDFDocument.load(pdfBytes);

                        // Tampilkan jumlah halaman sebelum modifikasi
                        console.log(`Jumlah halaman sebelum: ${pdfDoc.getPageCount()}`);

                        const signatureDataUrl = document.getElementById('signature1').src;
                        const signatureImageBytes = await fetch(signatureDataUrl).then(res => res.arrayBuffer());
                        const signatureImage = await pdfDoc.embedPng(signatureImageBytes);

                        // Ambil elemen tanda tangan dari HTML
                        const signature = document.getElementById('signature1');
                        const signatureRect = signature.getBoundingClientRect();

                        const originalWidth = signature.naturalWidth;
                        const originalHeight = signature.naturalHeight;

                        // Skala ukuran tanda tangan
                        const widthScale = signatureRect.width / originalWidth;
                        const heightScale = signatureRect.height / originalHeight;

                        let activePage;
                        const canvasElements = document.querySelectorAll('#pdf-container canvas');

                        let pageHasSignature = false; // Pastikan tanda tangan hanya ditambahkan sekali
                        
                        // Hanya modifikasi halaman aktif yang sesuai
                        canvasElements.forEach((canvas, index) => {
                            if (pageHasSignature) return; // Hentikan jika tanda tangan sudah ditambahkan
                            
                            const canvasRect = canvas.getBoundingClientRect();
                            
                            if (signatureRect.top >= canvasRect.top && signatureRect.bottom <= canvasRect.bottom) {
                                activePage = pdfDoc.getPage(index);

                                // Pastikan halaman tidak dimodifikasi lagi
                                pageHasSignature = true;

                                const pdfPageWidth = activePage.getWidth();
                                const pdfPageHeight = activePage.getHeight();

                                const x = (signatureRect.left - canvasRect.left) / canvasRect.width * pdfPageWidth;
                                const y = ((canvasRect.height - ((signatureRect.top - canvasRect.top) + signatureRect.height)) / canvasRect.height * pdfPageHeight);

                                const resizedWidth = parseFloat(signature.getAttribute('data-width')) || signature.width;
                                const resizedHeight = parseFloat(signature.getAttribute('data-height')) || signature.height;

                                // Tambahkan gambar tanda tangan ke halaman yang aktif
                                activePage.drawImage(signatureImage, {
                                    x: x,
                                    y: y,
                                    width: resizedWidth / canvasRect.width * pdfPageWidth, // Konversi ukuran dari layar ke PDF
                                    height: resizedHeight / canvasRect.height * pdfPageHeight, 
                                });

                                console.log(`Tanda tangan ditambahkan pada halaman ${index + 1}`);
                            }
                        });

                        if (!pageHasSignature) {
                            console.error('Tidak ada halaman yang ditemukan untuk tanda tangan.');
                            return;
                        }

                        // Simpan PDF yang telah dimodifikasi
                        const newPdfBytes = await pdfDoc.save(); 

                        console.log("newPdfBytes has been created:", newPdfBytes);

                        const formData = new FormData();
                        const iddocumentsignature = document.getElementById("iddocumentsignature").value;
                        const iduser = document.getElementById("iduser").value;
                        const namedoc = document.getElementById("namadokumen").value;
                        const idproject = document.getElementById("idproject").value;
                        
                        formData.append('iddocumentsignaturelast', iddocumentsignature);
                        formData.append('iduserlast', iduser);
                        formData.append('filelast', new Blob([newPdfBytes], { type: 'application/pdf' }), 'signed_document.pdf');
                        formData.append('namadokumen', namedoc);
                        formData.append('idproject', idproject);

                        // Kirim data ke server
                        const response = await fetch('<?= base_url('document/pdfSementara'); ?>', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await response.json();

                        if (data.success) {
                            const newFileName = data.newFileName;
                            document.getElementById('urllast').value = '<?= base_url('assets/document/' . $namafolder . '/'); ?>' + newFileName;

                            // Update dan render ulang PDF
                            updateAndRenderPDF();

                            // Reset posisi tanda tangan
                            const signaturesDiv = document.getElementById('signature1');
                            signaturesDiv.style.transform = 'translate(0px, 0px)';
                            signaturesDiv.setAttribute('data-x', 0);
                            signaturesDiv.setAttribute('data-y', 0);
                        } else {
                            console.error('File upload failed:', data.message);
                        }

                        // Tampilkan jumlah halaman setelah modifikasi
                        console.log(`Jumlah halaman setelah: ${pdfDoc.getPageCount()}`);

                    } catch (error) {
                        console.error('Error adding signatures to PDF:', error);
                    }
                }



                // Event listener untuk tombol konfirmasi
                confirmButton.onclick = function() {
                    hideModal(modal);
                    addSignaturesToPDF();
                };

                // Event listener untuk tombol batal
                cancelButton.onclick = function() {
                    hideModal(modal);

        
                    const signaturesDiv = document.getElementById('signature1');
                    console.log(signaturesDiv)

                    // Reset posisi tanda tangan
                    signaturesDiv.style.transform = 'translate(0px, 0px)';
                    signaturesDiv.setAttribute('data-x', 0);
                    signaturesDiv.setAttribute('data-y', 0);
                    
                };

        interact('.signature')
                .draggable({
                    listeners: {
                    start(event) {
                    event.target.classList.add('dragging');
                    // event.target.classList.add('no-touch');
                    },
                    move(event) {
                    
                        var target = event.target;
                        var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    },
                    end(event) {
                        event.target.classList.remove('dragging');
                        event.target.classList.remove('no-touch');
                    
                            // Dapatkan elemen halaman PDF di bawah kursor
                            const pdfPageElement = document.elementFromPoint(event.clientX, event.clientY);
                            if (pdfPageElement) {
                            
                                if (modal) {
                                    modal.style.display = 'block';
                                    modal.style.opacity = '100';
                                    showModal(modal);
                                }
                                event.target.dataset.page = pdfPageElement.getAttribute('data-page-number');
                            }

                        }
                    }
                })
                .resizable({
                    edges: { left: true, right: true, bottom: true, top: true },
                    listeners: {
                    start(event) {
                        // event.target.classList.add('no-touch');
                        event.target.classList.add('resizing');
                    },
                    move(event) {
                        var target = event.target;
                        var x = (parseFloat(target.getAttribute('data-x')) || 0);
                        var y = (parseFloat(target.getAttribute('data-y')) || 0);

                        const width = event.rect.width;
                        const height = event.rect.height;

                        target.style.width = width + 'px';
                        target.style.height = height + 'px';

                        x += event.deltaRect.left;
                        y += event.deltaRect.top;

                        target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);

                        target.setAttribute('data-width', width);
                        target.setAttribute('data-height', height);
                    },
                    end(event) {
                        event.target.classList.remove('resizing');
                        event.target.classList.remove('no-touch');
                    }
                    }
                });

            // Fungsi untuk mencegah scroll selama drag atau resize aktif
            function preventScroll(e) {
                e.preventDefault();
            }

 

    </script>
  



  
            