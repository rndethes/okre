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
            <div id="pdf-container" style="overflow-y: scroll; height: 600px; width: 100%; border: 1px solid black;">
                <!-- Halaman PDF akan ditampilkan di sini -->
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
                        <div class="card card-frame">
                        <div class="card-header">
                        <h3 class="mb-0">Tanda Tanganmu  </h3>
                        </div>
                        <div class="card-body insignature">
                        <div id="signatures">
                            <img src="<?= base_url('assets/img/signature/' . $users_name['signature_photo']); ?>" id="mysignature" class="mysignature">
                        </div>
                        <button id="save-btn">Simpan Tanda Tangan</button>
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

  

 
    </script>

        <script>

        let pdfDoc = null,
        pageNum = 1;
        let currentPageNumber = 1; //
            // Load PDF
            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                renderAllPages(pdfDoc.numPages);
            });

            function renderAllPages(totalPages) {
                for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                    renderPage(pageNum);
                }
            }


            function renderPage(pageNum) {
                pdfDoc.getPage(pageNum).then(function(page) {
                    let viewport = page.getViewport({ scale: 1 });
                    
                    // Buat elemen canvas untuk setiap halaman
                    let canvas = document.createElement('canvas');
                    canvas.className = 'pdf-page';
                    let ctx = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Tambahkan canvas ke dalam kontainer
                    document.getElementById('pdf-container').appendChild(canvas);

                    // Render halaman di canvas tersebut
                    let renderCtx = {
                        canvasContext: ctx,
                        viewport: viewport
                    };

                    page.render(renderCtx).promise.then(function() {
                        // Setelah halaman dirender, tambahkan tanda tangan jika ada di halaman ini
                        addSignaturesToPage(pageNum);
                    });

                });
            }

            
            const signatures = []; // Array untuk menyimpan data tanda tangan

            // Inisialisasi Interact.js untuk drag dan resize
            interact('#mysignature')
                .draggable({
                    onmove: dragMoveListener,
                    onend: function(event) {
                        let pageNum = getCurrentPageNumber(); // Fungsi untuk mendapatkan halaman saat ini
                        saveSignature(pageNum);
                    }
                })
                .resizable({
                    edges: { left: true, right: true, bottom: true, top: true }
                })
                .on('resizemove', function(event) {
                    let target = event.target;
                    target.style.width = event.rect.width + 'px';
                    target.style.height = event.rect.height + 'px';
                    target.setAttribute('data-x', (parseFloat(target.getAttribute('data-x')) || 0) + event.deltaRect.left);
                    target.setAttribute('data-y', (parseFloat(target.getAttribute('data-y')) || 0) + event.deltaRect.top);
                })
                .on('resizeend', function(event) {
                    let pageNum = getCurrentPageNumber(); // Fungsi untuk mendapatkan halaman saat ini
                    saveSignature(pageNum);
                });


                function getCurrentPageNumber() {
                    let container = document.getElementById('pdf-container');
                    let containerTop = container.scrollTop;
                    let containerHeight = container.clientHeight;
                    
                    // Ambil semua elemen canvas (halaman PDF) yang ada
                    let pages = document.querySelectorAll('#pdf-container .pdf-page');
                    
                    for (let i = 0; i < pages.length; i++) {
                        let page = pages[i];
                        let pageTop = page.offsetTop;
                        let pageBottom = pageTop + page.clientHeight;

                        // Cek apakah halaman ini terlihat dalam area scroll
                        if (pageBottom > containerTop && pageTop < (containerTop + containerHeight)) {
                            currentPageNumber = i + 1; // Halaman dihitung mulai dari 1
                            break;
                        }
                    }

                    return currentPageNumber;
                }

                document.getElementById('pdf-container').addEventListener('scroll', function() {
                    let pageNum = getCurrentPageNumber();
                    console.log("Halaman aktif:", pageNum);
                });

                function updateSignaturesPosition() {
                    let container = document.getElementById('pdf-container');
                    let containerTop = container.scrollTop;
                    let containerHeight = container.clientHeight;

                    // Iterasi semua halaman
                    document.querySelectorAll('#pdf-container .pdf-page').forEach(page => {
                        let pageTop = page.offsetTop;
                        let pageBottom = pageTop + page.clientHeight;
                        let pageNum = Array.from(document.querySelectorAll('#pdf-container .pdf-page')).indexOf(page) + 1;

                        if (pageBottom > containerTop && pageTop < (containerTop + containerHeight)) {
                            // Tambahkan tanda tangan yang sesuai dengan halaman ini
                            addSignaturesToPage(pageNum);
                        }
                    });
                }

                // Event listener untuk scroll
                document.getElementById('pdf-container').addEventListener('scroll', updateSignaturesPosition);

                // Panggil fungsi ini saat halaman pertama kali dirender
                updateSignaturesPosition();



                function dragMoveListener(event) {
                    let target = event.target,
                        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                    // Apply translation to signature
                    target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                    target.setAttribute('data-x', x);
                    target.setAttribute('data-y', y);
                }

                function saveSignature(pageNum) {
                    let signature = document.getElementById('mysignature');
                    let x = parseFloat(signature.style.left);
                    let y = parseFloat(signature.style.top);
                    let width = signature.style.width;
                    let height = signature.style.height;

                    signatures.push({
                        pageNum: pageNum,
                        x: x,
                        y: y,
                        width: width,
                        height: height
                    });
                }
            function addSignaturesToPage(pageNum) {
                signatures.forEach(function(signature) {
                    if (signature.pageNum === pageNum) {
                        let signatureImg = document.createElement('img');
                        signatureImg.src = '<?= base_url('assets/img/signature/' . $users_name['signature_photo']); ?>'; // Gambar tanda tangan
                        signatureImg.style.position = 'absolute';
                        signatureImg.style.left = signature.x + 'px';
                        signatureImg.style.top = signature.y + 'px';
                        signatureImg.style.width = signature.width;
                        signatureImg.style.height = signature.height;
                        signatureImg.className = 'signature';
                        signatureImg.setAttribute('data-page', pageNum);

                        document.getElementById('pdf-container').appendChild(signatureImg);
                    }
                });
            }
        

        </script>
  



  
            