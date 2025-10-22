<div id="roomspace"></div>
<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">OKR</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Workspace</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $space['name_space'] ?></li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
  <div class="row">

    <div class="col-xl-12" id="main-column">
      <div class="card">
        <div class="card-header">
        <div class="col-xl-12">
          <div class="row align-items-center">
            <div class="col-8">
              <h2 class="mb-2">Buat Template</h2>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-6">
          <div class="row">
              <div class="form-group">
                <div class="col-sm-2"><label for="example-email-input" class="form-control-label">Picture</label></div>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-4 mb-4">
                      <img id="preview-image" src="#" class="img-thumbnail edit-picture">
                    </div>
                    <div class="col-sm-8">
                    <form id="uploadForm" enctype="multipart/form-data">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto">
                        <label class="custom-file-label" for="foto">Pilih File</label>
                        <label class="form-control-label text-danger pictureLabel" for="input-nomor">*/Max Size Photo 2 MB pastikan gambar png/*</label>
                          <button class="btn btn-icon rounded-pill btn-danger btn-sm" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                              <span class="btn-inner--text">Hapus Gambar</span>
                          </button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
          <input id="idtemplate" class="form-control form-control-sm mb-3" type="hidden">
          <?php 
            
          ?>
          <input id="input-nama-perusahaan" class="form-control form-control-sm mb-3" type="text" placeholder="Nama Perusahaan">
          <input id="input-baris-1" class="form-control form-control-sm mb-3" type="text" placeholder="Baris 1">
          <input id="input-baris-2" class="form-control form-control-sm mb-3" type="text" placeholder="Baris 2">
            <button class="btn btn-icon rounded-pill btn-primary btn-sm" type="button" id="imgEdit">
              <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
              <span class="btn-inner--text">Perkecil Gambar</span>
            </button>
          
          </div>
          <div class="col-lg-12" id="temp-kop">
              <span class="span-kop">
                <img id="preview-kop" src="#">
                <h5 id="kop-title">PT ETHES TEKNOLOGI MAKMUR</h5>
                <small id="kop-lineone"><i>Alamat : Krajan 1 RT 001/RW 007, Kandangan, Temanggung, Jawa Tengah, Indonesia, 56281</i></small><br>
                <small id="kop-linetwo"><i>Email : contact@ethestm.co.id Phone : (0293) 4963641<i></small>
              </span>
          </div>
            <div class="col-lg-12">
            <!-- <form action="<?php echo base_url('your_controller/submit'); ?>" method="post">
                <textarea name="content" id="content"></textarea>
            </form> -->
            <!-- <form action="<?php echo base_url('your_controller/your_method'); ?>" method="post">
                <textarea name="content" id="editor"></textarea>
               
            </form> -->
            </div>
      </div>
      <div class="row mt-3">
            <div class="col-lg-3">
              <button class="btn btn-success rounded-pill savetemplate"><span class="btn-inner--icon"><i class="ni ni-credit-card"></i></span>
                <span class="btn-inner--text">Simpan Template</span>
              </button>
            </div>
        </div>
          <div class="row mt-3">
            <div class="col-lg-3">
              <button onclick="goBackToPreviousPage()" class="btn btn-danger rounded-pill"><span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
              </button>
            </div>
        </div>
    </div>
      </div>
    </div>
    
  </div>

    

  <script>
     // Menangkap elemen input
      const namaPerusahaanInput = document.getElementById('input-nama-perusahaan');
      const baris1Input = document.getElementById('input-baris-1');
      const baris2Input = document.getElementById('input-baris-2');

      // Menangkap elemen yang akan diubah
      const kopTitle = document.getElementById('kop-title');
      const kopLineOne = document.getElementById('kop-lineone');
      const kopLineTwo = document.getElementById('kop-linetwo');

      // Event listener untuk mengubah konten berdasarkan input
      namaPerusahaanInput.addEventListener('input', function() {
        kopTitle.textContent = this.value || 'PT ETHES TEKNOLOGI MAKMUR'; // Default jika kosong
      });

      baris1Input.addEventListener('input', function() {
        kopLineOne.textContent = this.value || 'Alamat : Krajan 1 RT 001/RW 007, Kandangan, Temanggung, Jawa Tengah, Indonesia, 56281'; // Default jika kosong
      });

      baris2Input.addEventListener('input', function() {
        kopLineTwo.textContent = this.value || 'Email : contact@ethestm.co.id Phone : (0293) 4963641'; // Default jika kosong
      });


      document.getElementById('foto').addEventListener('change', function(event) {

        var input = event.target;
        var label = input.nextElementSibling;
        var file = input.files[0];

        // Ganti label dengan nama file yang dipilih
        label.textContent = file.name;

        if (file) {
            var reader = new FileReader();

            // Saat file sudah dibaca
            reader.onload = function(e) {
                // Ubah src dari <img> dengan file yang dipilih
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-kop').src = e.target.result;
            };

            // Membaca file sebagai Data URL
            reader.readAsDataURL(file);
        }

        var formData = new FormData();
        formData.append('foto', this.files[0]); // Ambil file foto

        // Kirim menggunakan AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("data/upload_logo") ?>', true);

        xhr.onload = function() {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            
            if(response.status === 'success') {
              alert('Foto berhasil di-upload!');

              // Simpan URL gambar dan id_template di localStorage
              var imageUrl = '<?= base_url("assets/doctemplate/kop/") ?>' + response.file_name;
              localStorage.setItem('savedImageUrl', imageUrl);
              localStorage.setItem('id_template', response.id_template);  // Simpan id_template

              // Tampilkan gambar dari URL server
              document.getElementById('preview-kop').src = imageUrl;

              // Tampilkan id_template di input
              document.getElementById('idtemplate').value = response.id_template;

            } else {
              alert('Terjadi kesalahan: ' + response.message);
            }
          } else {
            alert('Terjadi kesalahan saat meng-upload foto.');
          }
        };

        xhr.send(formData); 

    }); 
    window.onload = function() {
          // Periksa apakah ada gambar yang tersimpan di localStorage
          var savedImageUrl = localStorage.getItem('savedImageUrl');
          if (savedImageUrl) {
              // Tampilkan gambar dari URL yang tersimpan
              document.getElementById('preview-kop').src = savedImageUrl;
              document.getElementById('preview-image').src = savedImageUrl;
          }

          // Periksa apakah ada id_template yang tersimpan di localStorage
          var savedIdTemplate = localStorage.getItem('id_template');
          if (savedIdTemplate) {
              // Tampilkan id_template di input
              document.getElementById('idtemplate').value = savedIdTemplate;
          }


          // Periksa apakah ada id_template yang tersimpan di localStorage
          var titletemplate = localStorage.getItem('title');
          if (titletemplate) {
              // Tampilkan id_template di input
              document.getElementById('input-nama-perusahaan').value = titletemplate;
          }


          // Periksa apakah ada id_template yang tersimpan di localStorage
          var lineonetemplate = localStorage.getItem('lineone');
            if (lineonetemplate) {
                // Tampilkan id_template di input
                document.getElementById('input-baris-1').value = lineonetemplate;
            }


          // Periksa apakah ada id_template yang tersimpan di localStorage
          var linetwotemplate = localStorage.getItem('linetwo');
            if (linetwotemplate) {
                // Tampilkan id_template di input
                document.getElementById('input-baris-2').value = linetwotemplate;
            }
        

           // Periksa apakah ada id_template yang tersimpan di localStorage
           var tempHtml = localStorage.getItem('templateHtml');
            if (tempHtml) {
                // Tampilkan id_template di input
                document.getElementById('temp-kop').innerHTML = tempHtml;
            }
          
        }


     
          document.getElementById('imgEdit').addEventListener('click', function() {
            var imgElement = document.getElementById('preview-kop'); // Ambil elemen gambar
            var currentWidth = imgElement.clientWidth; // Ambil lebar saat ini

            // Kurangi lebar gambar sebesar 10px jika lebar lebih dari 10px
            if (currentWidth > 40) {
                imgElement.style.width = (currentWidth - 40) + 'px';
            } else {
                alert('Lebar gambar sudah mencapai batas minimum!');
            }
        });

        document.querySelector('.savetemplate').addEventListener('click', function() {
        // Ambil HTML dari elemen yang sudah ada di DOM
          var templateHtml = document.querySelector('.span-kop').outerHTML;

          var idTemplate  = document.getElementById('idtemplate').value;
          var title       = document.getElementById('input-nama-perusahaan').value;
          var lineone     = document.getElementById('input-baris-1').value;
          var linetwo     = document.getElementById('input-baris-2').value;
          
          localStorage.setItem('templateHtml', templateHtml);
          localStorage.setItem('title', title);
          localStorage.setItem('lineone', lineone);
          localStorage.setItem('linetwo', linetwo);

          console.log(templateHtml);

          $.ajax({
                url: '<?= base_url('data/upload_template') ?>', // Ganti dengan URL yang sesuai
                type: 'POST',
                data: {
                    header_template: templateHtml,
                    id_template: idTemplate
                },
                success: function(response) {
                   
                        alert('Template berhasil disimpan!');
               
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan template.');
                }
            });
        });

  </script>
    <!-- <script>
      const {
        ClassicEditor,  
        Essentials, 
            Bold, 
            Italic, 
            Underline, 
            Strikethrough, 
            Link, 
            Image, 
            ImageUpload,
            ImageCaption,
            ImageStyle,
            ImageResize,
            BlockQuote, 
            List, 
            Table, 
            Code, 
            FontColor, 
            FontBackgroundColor, 
            FontSize, 
            FontFamily, 
            Paragraph
    } = CKEDITOR;

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
          plugins: [
            Essentials, 
            Bold, 
            Italic, 
            Underline, 
            Strikethrough, 
            Link, 
            Image, ImageUpload, ImageCaption, ImageStyle, ImageResize,
            BlockQuote, 
            List, 
            Table, 
            Code, 
            FontColor, 
            FontBackgroundColor, 
            FontSize, 
            FontFamily, 
            Paragraph
        ],
        toolbar: [
          'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
            'link', 'imageUpload', '|', 'bulletedList', 'numberedList', '|',
            'blockQuote', 'insertTable', 'fontSize', 'fontFamily', 'fontColor'
        ]
        } )
        .then(editor => {
        console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    </script> -->
   <!-- TinyMCE CDN -->
   <!-- <script src="https://cdn.tiny.cloud/1/i3i11t6e64i6bmnzgiw2v9mn2f0z4igbg20caf6goqn60wuf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
   <script>
      tinymce.init({
        selector: 'textarea',
        plugins: [
          // Core editing features
          'anchor', 'autolink', 'charmap', 'codesample', 'image', 'link', 'lists', 'searchreplace', 'table', 'visualblocks', 'wordcount', 
          // Your account includes a free trial of TinyMCE premium features
          // Try the most popular premium features until Oct 22, 2024:
          'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'autocorrect', 'typography', 'inlinecss', 'markdown',
          // Add pagebreak plugin
          'pagebreak'  // Tambahkan plugin pagebreak di sini
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        images_upload_url: '/upload/upload_image',  // Endpoint di server untuk proses upload
        automatic_uploads: true,
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
                        
                        // Call the callback and populate the Title field with the file name
                        callback(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        },
        images_reuse_filename: true,  // Gunakan nama file asli saat upload
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
      });
    </script> -->
  



             

              

                      