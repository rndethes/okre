<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
       
      </div>
    </div>
  </div>
</div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div id="mainColumn" class="col-lg-10">
                <div class="card">
                <form id="saveDocumentForm" method="POST">
                          <input class="form-control" type="hidden" value="<?= $checkdata['id_document_new'] ?>" id="iddoc">
                          <input class="form-control" type="hidden" value="<?= $checkdata['name_document_new'] ?>" id="namedoc">
                          <input class="form-control" type="hidden" value="<?= $checkdata['tipe_document_new'] ?>" id="tipedoc">
                          <input class="form-control" type="hidden" value="<?= $this->uri->segment(3) ?>" id="idspace">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col-8">
                          <h3 class="mb-0"><?= $checkdata['name_document_new'] ?></h3>
                        </div>
                        
                        <div class="col-4 text-right">
                          <button type="button" class="btn btn-sm btn-success rounded-pill" id="saveButton"> 
                            <span class="btn--inner-icon">
                            <i class="ni ni-check-bold"></i></span>
                            <span class="btn-inner--text">Simpan</span>
                          </button>
                          <button type="button" class="btn btn-sm btn-primary rounded-pill" id="perbesarButton">
                            <span class="btn--inner-icon">
                            <i class="ni ni-map-big"></i></span>
                            <span class="btn-inner--text">Perbesar</span>
                          </button>
                        </div>
                      </div>
                        
                    </div>
                    <div class="card-body">
                   
                    <div id="loading-spinner" style="display: none; text-align: center; margin: 20px;">
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <p>Editor is loading...</p>
                    </div>
                    <textarea name="content" id="editor" style="color:white;border: 1px solid white;background-color: white;"><?= $checkdata['content_doc'] ?></textarea>
                    </div>
                </div>
            </div>
            <div  id="detailColumn" class="col-lg-2">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Detail</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-0"><?= $checkdata['name_document_new'] ?></h4>
                          <small class="mb-0">Pemilik : <?= $checkdata['nama'] ?></small>
                          <small class="mb-0">Dibuat : <?= date('j F Y H:i',strtotime($checkdata['created_date'])) ?></small>
                        </br>
                          
                          </br>
                          <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle rounded-pill" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Opsi Dokumen
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="" id="saveAndSubmitButton">Simpan & Buat Pengajuan</a>
                              <a class="dropdown-item" href="" id="saveTemplateButton">Simpan Template</a>
                            </div>
                          </div>
                        </form>  
                        
                        <a href="<?= base_url('data/viewDocument/') . $this->uri->segment(3) . "/space" ?>" class="btn btn-danger mt-4 rounded-pill text-white">
                          <span class="btn-inner--text">Kembali</span>
                        </a>  
                        
                         
                    </div>
                    
                    
                </div>
                    <div class="card card-frame">
                      <div class="card-header">
                      Aktivitas
                      </div>
                          <div class="card-body" style="max-height: 500px;overflow-y: auto;overflow-x: hidden;">
                           <?php if(empty($checklog)) { ?>
                              <div class="alert alert-info" role="alert">
                                  <strong>Aktifitas Kosong!</strong> Belum ada aktifitas
                              </div>
                           <?php } else { ?>
                            <ul class="list-group">
                              <?php foreach($checklog as $log) { ?>
                                <li class="list-group-item"><small style="font-size: 10px;padding: 1px 1px;"><?= $log['desc_log'] ?> At <?= date('Y-m-d H:i',strtotime($log['created_date_log'])) ?></small></li> 
                              <?php } ?>
                            </ul>
                           <?php } ?>
                            
                        </div>
                    </div>
        </div>
    </div>


    <script src="https://cdn.tiny.cloud/1/i3i11t6e64i6bmnzgiw2v9mn2f0z4igbg20caf6goqn60wuf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    

    <script> 

      document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('loading-spinner').style.display = 'block'; // Tampilkan spinner
      });
          // Memuat template dari server CI3
          function loadTemplates() {
                console.log('Fetching templates...');
                return fetch('<?= base_url('data/get_templates') ?>')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Parsing response JSON
                    })
                    .then(data => {
                        console.log('Templates received:', data); // Debugging
                        return data; // Kembalikan data template
                    })
                    .catch(error => {
                        console.error('Error loading templates:', error);
                        return []; // Jika terjadi error, kembalikan array kosong
                    });
            }

          loadTemplates().then(function(templates) {
            if (templates.length === 0) {
              console.warn('No templates available');
            }
              tinymce.init({
              selector: 'textarea',
              plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'image', 'link', 'lists', 'searchreplace', 'table', 'visualblocks', 'wordcount', 
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Oct 22, 2024:
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'autocorrect', 'typography', 'inlinecss', 'markdown',
                // Add pagebreak plugin
                'pagebreak' , 'template' // Tambahkan plugin pagebreak di sini
              ],
              toolbar: 'template | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen preview | save print ',
              // Gunakan template yang diambil dari server
              templates: templates,
              tinycomments_mode: 'embedded',
              tinycomments_author: 'Author name',
              images_upload_url: '<?= base_url('/data/upload_image') ?>',  // Endpoint di server untuk proses upload
              automatic_uploads: true,
              height: 800,
              deprecation_warnings: false,
              setup: function (editor) {
            
                editor.on('keyup', function () {
                  insertPageBreaks(editor);
                });
              },
              content_css: '<?= base_url('/assets/css/texteditor.css') ?>', // Link ke CSS khusus
            // File Picker Callback (memungkinkan upload file dari komputer lokal)
              file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                  var input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.setAttribute('accept', 'image/*');
                  input.onchange = function () {
                      var file = this.files[0];
                      
                      var reader = new FileReader();
                      reader.onload = function () {
                          var id = 'blobid' + (new Date()).getTime();
                          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                          var base64 = reader.result.split(',')[1];
                          var blobInfo = blobCache.create(id, file, base64);
                          blobCache.add(blobInfo);
                          
                          // Panggil callback dan set URL
                          callback(blobInfo.blobUri(), { title: file.name });
                      };
                      reader.readAsDataURL(file);
                  };
                  input.click();
              }
              },
              init_instance_callback: function(editor) {
                  document.getElementById('loading-spinner').style.display = 'none'; // Sembunyikan spinner
                  console.log('TinyMCE Editor loaded successfully!');
              },
              images_reuse_filename: true,  // Gunakan nama file asli saat upload
            
            });
            function insertPageBreaks(editor) {
                const contentBody = editor.getContentAreaContainer().querySelector('iframe').contentDocument.body;
                const contentHeight = contentBody.scrollHeight;
                const A4Height = 580; // Adjusted height for A4 size in pixels
                
                // Remove all existing page breaks
                removeExistingPageBreaks(editor);

                let currentPageCount = Math.floor(contentHeight / A4Height); // Calculate number of pages

                // Add page breaks after every A4-height
                for (let i = 1; i <= currentPageCount; i++) {
                    insertPageBreakAt(editor, i * A4Height);
                }
              }

              function insertPageBreakAt(editor, position) {
                const doc = editor.getContentAreaContainer().querySelector('iframe').contentDocument;
                const body = doc.body;

                // Create an <hr> element for page break
                const pageBreak = doc.createElement('hr');
                pageBreak.classList.add('page-break');
                pageBreak.style.pageBreakBefore = 'always';

                let accumulatedHeight = 0;
                for (let i = 0; i < body.childNodes.length; i++) {
                  const node = body.childNodes[i];
                  const nodeHeight = node.offsetHeight || 0;
                  accumulatedHeight += nodeHeight;

                  if (accumulatedHeight >= position) {
            
                        node.parentNode.insertBefore(pageBreak, node.nextSibling);
                        break;
                  }
                }
              }
              function removeExistingPageBreaks(editor) {
                const doc = editor.getContentAreaContainer().querySelector('iframe').contentDocument;
                const pageBreaks = doc.querySelectorAll('hr.page-break');
                
                pageBreaks.forEach(pageBreak => {
                  pageBreak.parentNode.removeChild(pageBreak);
                });

              }
        });

        // Mendapatkan elemen editor dan tombol simpan
    document.addEventListener('DOMContentLoaded', function () {

      // Menyimpan status apakah dokumen sudah disimpan
      let isDocumentSaved = false;
       
        document.getElementById('saveButton').addEventListener('click', function () {
            // Ambil konten dari TinyMCE editor
            var content = tinymce.get('editor').getContent();

            // Ambil id dokumen
            var iddoc = document.getElementById('iddoc').value;

            // Kirim data menggunakan AJAX
            var formData = new FormData();
            formData.append('id_document_new', iddoc);
            formData.append('content', content);
            
            // Lakukan post request ke server untuk menyimpan data
            fetch('<?= base_url('data/save_new') ?>', {  // Ganti URL sesuai endpoint untuk menyimpan
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const Toast = Swal.mixin({
                      toast: true,
                      position: "top-end",
                      showConfirmButton: false,
                      timer: 1000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                    });
                    Toast.fire({
                      icon: "success",
                      title: "Dokumen Berhasil Disimpan"
                    });
                    isDocumentSaved = true;
                } else {
                  const Toast = Swal.mixin({
                      toast: true,
                      position: "top-end",
                      showConfirmButton: false,
                      timer: 4000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                    });
                    Toast.fire({
                      icon: "error",
                      title: "Terjadi kesalahan saat menyimpan dokumen."
                    });   
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
      });

        document.getElementById('saveAndSubmitButton').addEventListener('click', function (event) {
            event.preventDefault();

            // Ambil konten dari TinyMCE
            var content = tinymce.get('editor').getContent();
            
            // Ambil id dokumen
            var iddoc = document.getElementById('iddoc').value;

            var tipedoc = document.getElementById('tipedoc').value;

            var namedoc = document.getElementById('namedoc').value;
            var idspace = document.getElementById('idspace').value;

          
            // Kirim data menggunakan AJAX
            var formData = new FormData();
            formData.append('id_document_new', iddoc);
            formData.append('document_name', namedoc);
            formData.append('content', content);
            formData.append('tipedoc', tipedoc);
            formData.append('space', idspace);

            // Kirim request untuk menyimpan dan membuat PDF
            fetch('<?= base_url('data/save_and_submit') ?>', {  // Ganti URL sesuai endpoint untuk menyimpan dan membuat pengajuan
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  Swal.fire({
                      title: "Berhasil Menyimpan Dokumen",
                      text: "Lanjutkan ke halaman pengajuan",
                      icon: "success"
                    });
                    window.location.href = data.redirect_url;

                } else {
                  const Toast = Swal.mixin({
                      toast: true,
                      position: "top-end",
                      showConfirmButton: false,
                      timer: 4000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                    });
                    Toast.fire({
                      icon: "error",
                      title: "Terjadi Masalah Saat Menyimpan Dokumen"
                    });
                }
            })
            .catch(error => {
              const Toast = Swal.mixin({
                      toast: true,
                      position: "top-end",
                      showConfirmButton: false,
                      timer: 4000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                    });
                    Toast.fire({
                      icon: "error",
                      title: 'Error:', error
                    });
            });
        });


          document.getElementById('saveTemplateButton').addEventListener('click', async function () {
            event.preventDefault(); // Mencegah reload halaman

            const { value: temp } = await Swal.fire({
                title: "Berikan Nama Template",
                input: "text",
                inputLabel: "nama template kamu",
                inputPlaceholder: "Berikan Nama Template"
              });
              if (temp) {
                  // Ambil konten dari TinyMCE editor
                var content = tinymce.get('editor').getContent();
                
                // Ambil id dokumen
                var iddoc = document.getElementById('iddoc').value;

                var idspace = document.getElementById('idspace').value;

                // Kirim data menggunakan AJAX
                var formData = new FormData();
                formData.append('id_document_new', iddoc);
                formData.append('content', content);
                formData.append('template_name', temp);
                formData.append('idspace', idspace);
                
                // Lakukan post request ke server untuk menyimpan data
                fetch('<?= base_url('data/save_new_template') ?>', {  // Ganti URL sesuai endpoint untuk menyimpan
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Template berhasil disimpan!');
                    } else {
                      const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                      });
                      Toast.fire({
                        icon: "error",
                        title: "Terjadi Masalah Saat Menyimpan Dokumen"
                      });
                    }
                })
                .catch(error => {
                  const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                      });
                      Toast.fire({
                        icon: "error",
                        title: 'Error:', error
                      });
                })
                
              }
             
          });

          // Event listener untuk menangkap reload halaman
          window.addEventListener('beforeunload', function (event) {
              if (!isDocumentSaved) {
                  // Tampilkan pesan konfirmasi
                  const confirmationMessage = "Dokumen Anda belum disimpan. Apakah Anda yakin ingin meninggalkan halaman?";
                  event.returnValue = confirmationMessage; // Untuk browser modern
                  return confirmationMessage; // Untuk browser lama
              }
          });




      
</script>



        

  
