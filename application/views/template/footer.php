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
      </div>
      </div>
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Siap Untuk Keluar?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Tekan "Logout" jika anda ingin keluar.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary rounded-pill" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-danger rounded-pill" href="<?php echo base_url('dashboard/logout'); ?>">
                <span class="btn--inner-icon">
                  <i class="ni ni-button-power"></i></span>
                <span class="btn-inner--text">Logout</span>
              </a>
            </div>
          </div>
        </div>
      </div>


      <!-- Argon Scripts -->
      <!-- Core -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/jquery/dist/jquery.min.js"></script>
      <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->

      <!-- <script src="<?= base_url('assets/'); ?>jsscroll/mobiscroll.javascript.min.js"></script> -->
     
      <script src="<?= base_url('assets/') ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/js-cookie/js.cookie.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
      <script src="<?= base_url('assets/'); ?>vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
      <!-- <script src="<?= base_url('assets/') ?>js/components/vendor/nouislider.min.js"></script> -->
      <!-- Optional JS -->
      <script src="<?= base_url('assets/') ?>vendor/chart.js/dist/Chart.min.js"></script>
      <script src="<?= base_url('assets/') ?>vendor/chart.js/dist/Chart.extension.js"></script>
      <!-- Module Script -->
      <!-- Argon JS -->
      <script src="<?= base_url('assets/') ?>js/argon.js?v=1.2.0"></script>
      <script src="<?= base_url('assets/') ?>vendor/select2/dist/js/select2.min.js"></script>
      <script src="<?= base_url('assets/') ?>js/bootstrap-select.js"></script>
      <script src=" <?= base_url('assets/'); ?>js/sweetalert/sweetalert2.all.min.js"></script>
      <!-- Data Tables -->
      <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      <script src="<?= base_url('assets/'); ?>js/dataTables.fixedColumns.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
      
      

      
      <script src="<?= base_url('assets/'); ?>js/data_table.js"></script>
      
        <script>
        var baseURL = "<?php echo base_url(); ?>";
      </script>
      <script src="<?= base_url('assets/'); ?>js/script.js"></script>
      <script src="<?= base_url('assets/'); ?>js/doc.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
      <script src="<?= base_url('assets/'); ?>js/kr.js"></script>
      <script src="<?= base_url('assets/'); ?>js/calendar.js"></script>
      <script src="<?= base_url('assets/'); ?>js/notif.js"></script>
      <script src="<?= base_url('assets/'); ?>js/mychart.js"></script>
      <script src="<?= base_url('assets/'); ?>js/main.js"></script>
      <script src="<?= base_url('assets/'); ?>js/myquill.js"></script>
      <script src="<?= base_url('assets/'); ?>js/mydata.js"></script>
      <!-- <script src="<?= base_url('assets/'); ?>js/keyresult.js"></script> -->

      <!-- <script src="<?= base_url('assets/'); ?>dist/pspdfkit.js"></script>

      <script src="https://cdn.docuseal.co/js/form.js"></script>

      
      
      <script>
      PSPDFKit.load({
        container: "#pspdfkit",
          document: ".<?= base_url('assets/document/humanresource/2024_08_23_RAIMBURSTMENT_BANNER_ETHESCOSMO.pdf') ?>."
      })
      .then(function(instance) {
        console.log("PSPDFKit loaded", instance);
      })
      .catch(function(error) {
        console.error(error.message);
      });
    </script> -->
      
      <script>

      // CKEDITOR.replace( 'ckedtor' );
      $(document).on("click", "#viewdata", function(e) {

        var data_id = $(this).data("ini");

        console.log(data_id);
      
                  $.ajax({
                      url: "<?= base_url() ?>project/showUser",
                      method: "POST",
                      data: {
                        data_id: data_id
                      },
                      success: function(data){
                        $("#detail_user").html(data);
                        $("#detailUserModal").modal('show')
                        
                      }
                  });
                });
      </script>
      <script>
          $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Pilih pengguna",
                allowClear: true,
          
            });
        });

        $(document).ready(function() {
          $('.js-example-basic-single').select2({
            placeholder: "Pilih pengguna",
            minimumInputLength: 1,
            allowClear: true,
          });

        
       });
        $(document).ready(function() {
            $('.add-team').select2({
              placeholder: "Pilih pengguna",
              allowClear: true,
                matcher: function(params, data) {
                    // Jika tidak ada input, kembalikan hasil pencarian kosong
                    if ($.trim(params.term).length < 3) {
                        return null;
                    }

                    // Lakukan pencocokan case-insensitive
                    var term = params.term.toLowerCase();
                    var text = data.text.toLowerCase();

                    var username = text.split('(')[0].trim();

                    // Cek apakah input user cocok dengan username
                    if (username.indexOf(term) > -1) {
                        return data;
                    }

                    // Jika tidak ada kecocokan, kembalikan null
                    return null;
                }
            });
        });
        $(document).ready(function() {
          $('#tambahuser').select2({
            placeholder: "Tambah User",
            allowClear: true,
            minimumInputLength: 5,
            ajax: {
                url: baseURL + 'account/searchUsersSpace',  // Ganti dengan URL yang akan mengambil data pengguna
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Hanya kirim permintaan jika input lebih dari 4 karakter
                    if (params.term.length < 5) {
                        return {
                            q: '' // Tidak ada query jika input kurang dari 5 karakter
                        };
                    }
                    return {
                        q: params.term // Mengambil input yang diketik pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.username} (${item.nama})`,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    $(document).ready(function() {
          $('#tambahuserokr').select2({
            placeholder: "Tambah User",
            allowClear: true,
            minimumInputLength: 5,
            ajax: {
                url: baseURL + 'account/searchUsersSpace',  // Ganti dengan URL yang akan mengambil data pengguna
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Hanya kirim permintaan jika input lebih dari 4 karakter
                    if (params.term.length < 5) {
                        return {
                            q: '' // Tidak ada query jika input kurang dari 5 karakter
                        };
                    }
                    return {
                        q: params.term // Mengambil input yang diketik pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.username} (${item.nama})`,
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#okrselect').select2({
            placeholder: "Tambah Key",
            allowClear: true,    
        });

        $('#inisiativeselect').select2({
            placeholder: "Tambah Initiative",
            allowClear: true,    
        });
    });
        
        $(document).ready(function() {
          $('#send-user-select').select2({
            placeholder: "Ketik username/nama/email pengguna",
            allowClear: true,
            minimumInputLength: 5,
            ajax: {
                url: baseURL + 'account/searchUsers',  // Ganti dengan URL yang akan mengambil data pengguna
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Hanya kirim permintaan jika input lebih dari 4 karakter
                    if (params.term.length < 5) {
                        return {
                            q: '' // Tidak ada query jika input kurang dari 5 karakter
                        };
                    }
                    return {
                        q: params.term // Mengambil input yang diketik pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.email,
                                text: `${item.username} (${item.nama})`,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
    $(document).ready(function() {
        $('#cc-user-select').select2({
          placeholder: "Ketik username/nama/email pengguna",
          allowClear: true,
    minimumInputLength: 5,
            ajax: {
                url: baseURL + 'account/searchUsers',  // Ganti dengan URL yang akan mengambil data pengguna
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Hanya kirim permintaan jika input lebih dari 4 karakter
                    if (params.term.length < 5) {
                        return {
                            q: '' // Tidak ada query jika input kurang dari 5 karakter
                        };
                    }
                    return {
                        q: params.term // Mengambil input yang diketik pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.email,
                                text: `${item.username} (${item.nama})`,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
    $(document).ready(function() {
        $('#tambahuserview').select2({
          placeholder: "Tambah User",
            allowClear: true,
            minimumInputLength: 5,
            ajax: {
                url: baseURL + 'account/searchUsersSpace',  // Ganti dengan URL yang akan mengambil data pengguna
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Hanya kirim permintaan jika input lebih dari 4 karakter
                    if (params.term.length < 5) {
                        return {
                            q: '' // Tidak ada query jika input kurang dari 5 karakter
                        };
                    }
                    return {
                        q: params.term // Mengambil input yang diketik pengguna
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.username} (${item.nama})`,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
          
        $(document).on("click", "#detailinit", function(e) {
          
          
          e.preventDefault();
          var idkr = $(this).data('detail');
          var datenow = $(this).data('datenow');
          var dateover = $(this).data('dateover');
          var myteam = $(this).data('myteam');

          var targetDiv = '.show-detail' + idkr;


          $('div[name="showdetail'+idkr+'"]').on('shown.bs.collapse', function(e) {
            e.preventDefault();
            $.ajax({
              url: "<?= base_url() ?>project/getDetail",
              type: "POST",
              dataType: 'json',
              beforeSend: function(){
                  $('.lds-ellipsis').css("visibility", "visible");
              },
              data: {
                idkr: idkr,
                datenow: datenow,
                dateover: dateover,
                myteam: myteam,
              },
              success: function(data) {
                $('.show-detail'+idkr).html(data); //menampilkan data ke dalam modal
              },
              complete: function(){
                  $('.lds-ellipsis').css("visibility", "hidden");                
              },
              error: function(xhr, status, error) {
                console.log('Terjadi kesalahan: ', error);
                $(targetDiv).html('<p>Terjadi kesalahan saat memuat data.</p>');
            }
            });
          });

       

        });
  
      
      </script>
      <script type="text/javascript">



    $(document).on("click", "#initiative", function(e) {
      e.preventDefault();

      var idkr = $(this).data('idkr');
      var maxGroup = 20;
//console.log(idkr);

$('#checkokr'+idkr).on('change', function() {
  console.log("")
            // Cek apakah checkbox dicentang atau tidak
            if ($(this).is(':checked')) {
                $('#valueinitiativefirst'+idkr).attr('disabled', true);
            } else {
                $('#valueinitiativefirst'+idkr).attr('disabled', false);
            }
        });

  e.preventDefault();
    //melakukan proses multiple input 
 
    console.log(idkr);
    $(".add-more"+idkr).click(function(event){

        console.log(idkr);
       
        if($('body').find('.after-add-more'+idkr).length < maxGroup){
            var fieldHTML = '<div class="form-group after-add-more'+idkr+'" style="margin-bottom:-5px;">'+$(".copy-addmore"+idkr).html()+'</div>';
            
            $('body').find('.after-add-more'+idkr+':last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
        var changeformat =  document.querySelectorAll(".form-control.valueinput");

                                  for (let i = 0; i <= changeformat.length; i++) {
                                    changeformat[i].addEventListener("keyup", function(e) {
                                    changeformat[i].value = formatRibuan(this.value);
                                    });
                                  }
    });
    $("body").on("click",".remove-addmore"+idkr,function(){ 
        $(this).parents(".after-add-more"+idkr).remove();
        var changeformat =  document.querySelectorAll(".form-control.valueinput");

      for (let i = 0; i <= changeformat.length; i++) {
        changeformat[i].addEventListener("keyup", function(e) {
        changeformat[i].value = formatRibuan(this.value);
        });
      }
    });


    $(".copyinisiative"+idkr).click(function(){

     var idkrcopy = $('#keyresultselect'+idkr).val();

     var element = document.querySelectorAll(".form-group.after-add-more"+idkr);

    element.forEach(elements => {
      elements.remove();
    });

     $.ajax({
          url: baseURL + "project/copyInisiative",
          type: "POST",
          dataType: "json",
          data: {
            idkrcopy: idkrcopy,
          },
          success: function (data) {
            var todos = JSON.stringify(data);

            obj = JSON.parse(todos);
            const size = Object.keys(obj).length;

            console.log(size)
          
            if(size == 0) {
            
              
              document.getElementById("descriptionfirst"+idkr).value = "";
              document.getElementById("valueinitiativefirst"+idkr).value = "";

              var element = document.querySelectorAll(".form-group.after-add-more"+idkr);

              element.forEach(elements => {
                elements.remove();
              });
            } else {

              for (var i = 0; i < size; i++) {
              if(i == 0) {
                  document.getElementById("descriptionfirst"+idkr).value = obj[0].description;
                  document.getElementById("valueinitiativefirst"+idkr).value = formatRibuan(obj[0].value_initiative);
                } else if (i > 0){
                  var datestart = obj[i].start_dateinit;
                  var datedue = obj[i].due_dateinit;
                  var dateOnlystart = datestart.split(' ')[0];
                  var dateOnlydue = datedue.split(' ')[0];
                 
                  var nama            = '<div class="row"><div class="col-4"><div class="form-group"><label class="form-control-label" for="input-username">Nama</label><input type="text" id="description" name="description[]" value="'+obj[i].description+'" class="form-control"></div></div>';
                  var valueini        = '<div class="col-2"><div class="form-group"><label class="form-control-label" for="input-username">Score</label><input type="text" id="value_initiative" name="value_initiative[]" value="'+formatRibuan(obj[i].value_initiative)+'" class="form-control valueinput"></div></div>';
                  var datestart       = '<div class="col-3"><div class="form-group"><label class="form-control-label" for="input-username">Tanggal Awal <small class="text-danger">(Optional)</small></label><input type="date" value="'+dateOnlystart+'" id="dateawalinitiativefirst" name="dateawal[]" class="form-control valueinput"></div></div>';
                  var dateend         = '<div class="col-3"><div class="form-group"><label class="form-control-label" for="input-username">Tanggal Akhir <small class="text-danger">(Optional)</small></label><input type="date" value="'+dateOnlydue+'" id="dateakhirinitiativefirst" name="dateakhir[]" class="form-control valueinput"></div></div>';
                  var buttonremove    = '<div class="col-lg-3"><div class="form-group mt-4"><label class="form-control-label" for="input-username"></label><button class="btn btn-icon btn-danger rounded-pill remove-addmore'+idkr+'" type="button"><span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span><span class="btn-inner--text">Remove</span></button></div></div></div>';
                  // var prioritySelect  = '<div class="col-lg-2"><div class="form-group"><label class="form-control-label" for="priority">Priority</label><select class="form-control" id="priority" name="priority[]"><option value="" selected>Pilih Prioritas</option><option value="3"' + (obj[i].priority == 3 ? ' selected' : '') + '>High</option><option value="2"' + (obj[i].priority == 2 ? ' selected' : '') + '>Medium</option><option value="1"' + (obj[i].priority == 1 ? ' selected' : '') + '>Low</option><option value="0"' + (obj[i].priority == 0 ? ' selected' : '') + '>Lowest</option></select></div></div>';
                  var fieldHTML       = '<div class="form-group after-add-more'+idkr+'" style="margin-bottom:-5px;">'+nama+valueini+datestart+dateend+buttonremove+'</div>';

                  $('body').find('.after-add-more'+idkr+':last').after(fieldHTML);
                }  
              }
            }
              
            },
          
            });
        });

      });
    </script>
      
      <script>
        $("input[type=range]").on("change input", function() {
          $("[name=values]").val($(this).val()) //assign value..
        })
        $(document).ready(function() {
          $("#myTable").dataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
              url: "<?= base_url('project/getData'); ?>",
              type: "POST",
              // datatype: "json",
            },
            language: {
              paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>',
              },
            },
            columnDefs: [{
              target: [-1],
              orderable: false,
            }, ],
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
              left: 0,
              right: 1,
            },
          });
        });

        $(document).ready(function() {
          $("#tableAcc").dataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
              url: "<?= base_url('account/getDataAcc'); ?>",
              type: "POST",
              // datatype: "json",
            },
            language: {
              paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>',
              },
            },
            columnDefs: [{
              target: [-1],
              orderable: false,
              "width": "80px",
              targets: 6

            }, ],
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
              left: 0,
              right: 1,
            },
          });
        });

        $(document).ready(function() {
          $("#myTableWorkSpace").dataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
              url: "<?= base_url('project/getDataInWorkSpace'); ?>",
              type: "POST",
              data: {
                idspace: "<?= $this->uri->segment(3) == null ? 0 : $this->uri->segment(3)?>",
              },
            },
            language: {
              paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>',
              },
            },
            columnDefs: [{
              target: [-1],
              orderable: false,
            }, ],
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
              left: 0,
              right: 1,
            },
          });
        });
      </script>
      <script>
        $(document).on("change", "#cheak", function(e) {
          var state = $(this).val();
          var id = $(this).data('id');
          if (state == 1) {
            state = 1;
          } else {
            state = 2;
          }
          $.ajax({
            url: "<?= base_url('account/changeStatus'); ?>",
            type: "POST",
            data: {
              state: state,
              id: id
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
              $("#overlay").fadeIn(300);
            },
            success: function(data) {},
            complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
              setTimeout(function() {
                $("#overlay").fadeOut(300);
              }, 500);
            },
          });
        });
      </script>
      <script>
        $(document).ready(function() {
          $("select[name=roleid]").change(function() {
            var role_id = $(this).children("option:selected").val();
            //var roleid = $(this).val();
            var id = $(this).data('id');
            $.ajax({
              type: 'POST',
              url: '<?= base_url('account/changeRole'); ?>',
              data: {
                role_id: role_id,
                id: id
              },
              beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $("#overlay").fadeIn(300);
              },
              success: function(result) {
                $("#display").html(result);
              },
              complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                setTimeout(function() {
                  $("#overlay").fadeOut(300);
                }, 500);
              },
            });
          });
        });
      </script>

      <script>
        $(document).on("click", "#initiative", function(e) {

          var idkr = $(this).data('idkr');

          $('#inisiativeModal').on('show.bs.modal', function(e) {
            //console.log(idkr);

            $.ajax({
              url: "<?= base_url() ?>project/getDetail",
              type: "POST",
              dataType: 'json',
              data: {
                idkr: idkr,
              },
              success: function(data) {
                $('.show-data').html(data); //menampilkan data ke dalam modal
              }
            });
          });

        });
      </script>
   

 





<script>
  $(document).ready(function() {
    $('#initiativecheck').change(function() {
      if ($(this).val() == '1') {
        $('#valueinitiative').hide();
        // $('#rph').show();
        // $("#decm").prop('disabled', true);
        // $("#rph").prop('disabled', false);
      }
    })

  })
</script>
<script>
  //  const quillEditors = [];
  //   document.querySelectorAll('.descinkeyresult').forEach((element) => {
  //       const quill = new Quill(element, {
  //           theme: 'snow',
  //       });
  //       quillEditors.push(quill);  // Simpan instance Quill ke dalam array
  //   });
  // Inisialisasi Quill

  const toolbarOptions = [
    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['link', 'image'],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
    ];

    var quillisnew = document.getElementById("desciniinput");
    var quillnew;
    if(quillisnew) {
      quillnew = new Quill("#desciniinput", {
    modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow",
    });
    }
 
    
  if(quillnew) {
      quillnew.getModule('toolbar').addHandler('image', function() {
      selectLocalImage();
      });

      quillnew.root.addEventListener('paste', function(e) {
        const clipboardData = e.clipboardData || window.clipboardData;
        const items = clipboardData.items;

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            
            if (item.type.indexOf("image") !== -1) {
                const file = item.getAsFile();
                if (file) {
                  console.log(file);
                  e.preventDefault();   
                    saveToServer(file)
                }
            }
        }
    });
  }
  function selectLocalImage() {
      const input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');
      input.click();

      input.onchange = function() {
          const file = input.files[0];

          // Hanya mengupload file gambar
          if (/^image\//.test(file.type)) {
              saveToServer(file);
          } else {
              console.warn('Hanya gambar yang diizinkan.');
          }
      };
  }
  // Fungsi untuk mengupload gambar ke server
  function saveToServer(file) {
      const formDataImg = new FormData();
      formDataImg.append('image', file);

      // Kirim gambar ke server melalui AJAX (gunakan URL endpoint Anda)
      fetch('<?= base_url('project/upload_image'); ?>', {
          method: 'POST',
          body: formDataImg
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Gagal mengupload gambar');
          }
          return response.json();
      })
      .then(result => {
        removePastedImage()
          // Masukkan URL gambar yang dikirimkan dari server ke dalam editor
          const range = quillnew.getSelection();
          quillnew.insertEmbed(range.index, 'image', result.imageUrl);
      })
      .catch(error => {
          console.error('Error:', error);
      });
  }
  // Function to remove the pasted image
  function removePastedImage() {
    const imgs = quillnew.root.querySelectorAll('img'); // Menemukan semua gambar dalam editor
      if (imgs.length > 0) {
          imgs[imgs.length - 1].remove();  // Menghapus gambar terakhir (yang baru saja dipaste)
      }
  }
  
 
    $("#showInputModal").on('show.bs.modal', function(event) {
     var button         = $(event.relatedTarget);
     var valini         = button.data('valini');
     var valach         = button.data('valach');
     var desc           = button.data('desc');
     var idini          = button.data('idini');
     var idkr           = button.data('idkr');
     var duedatekey     = button.data('duedatekey');
   
     var valuepercent   = button.data('valuepercent');

     var dateNow = new Date();
     var newDate = new Date(duedatekey);

     var hasilAngka = formatRibuan(valach);
     var hasilAngkaIni = formatRibuan(valini);
     

    
    

     $(document).ready(function() {
  

     if (dateNow.getTime() > newDate.getTime()) {
      console.log(dateNow.toString() + ' is more recent than ' + newDate.toString());
      document.getElementById("inputscore").readOnly     = true;
      } else {
        document.getElementById("inputscore").readOnly     = false;
      }
  
     document.getElementById("descini").innerHTML     = desc;
     document.getElementById("valach").innerHTML      = hasilAngkaIni;
     document.getElementById("inputscore").value      = hasilAngka;
     document.getElementById("valinistart").innerHTML = hasilAngka;
     document.getElementById("idini").value           = idini;
     document.getElementById("idkr").value            = idkr;
     document.getElementById("valfirst").value        = valini;
     document.getElementById("cekpercen").innerHTML   = valuepercent;
     document.getElementById("percent").value         = valuepercent;

     $.ajax({
        url: "<?= base_url() ?>project/getComment",
        type: "POST",
        dataType: 'json',
        data: {
          idini: idini,
          },
        success: function(data) {
          quillnew.clipboard.dangerouslyPasteHTML(data);
          }
      });

      $.ajax({
        url: "<?= base_url() ?>project/getHistoryInisiative",
        type: "POST",
        dataType: 'json',
        data: {
          idini: idini,
          },
        success: function(data) {
          $('.showhistory').html(data); 
          }
      });

     
   });
   function formatRibuan(angka){
        var number_string =  angka.toString().replace(/[^,\d]/g, ""),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
 

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }
 
        angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
        return angka_hasil;
    }
  });
var inprogress = document.querySelector('.form-inputprogress');
if(inprogress) {
  document.querySelector('.form-inputprogress').onsubmit = function() {
    var quillContent = quillnew.root.innerHTML; 
    document.getElementById('commentinvoice').value = quillContent;

		$(".btn-progress").attr("disabled", "true");
		$(".spinner").show();
		$(".btn-inner--text").hide();
		$(".fa-plus").hide();
  };
}

  $(document).on('show.bs.modal', '.cekkr', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var description = button.data('description'); // Extract description from data-* attributes
      var id = button.data('id'); // Extract ID from data-* attributes

      // console.log(id);

      // Initialize Quill editor for the specific modal
      var quillEditorId = '#descinkeyresult' + id;
      var quill = new Quill(quillEditorId, {
          theme: 'snow'
      });

      // Set Quill content
      quill.root.innerHTML = description;

      // Handle form submission
      $(document).on('submit', '.form-inputkey', function() {
          var quillContent = quill.root.innerHTML;
          $('#commentkr' + id).val(quillContent);
      });
  });


  $(document).on('show.bs.modal', '.cekkrnew', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var description = button.data('description'); // Extract description from data-* attributes
      var id = button.data('id'); // Extract ID from data-* attributes

      
      // Initialize Quill editor for the specific modal
      var quillEditorId = '#descinkeyresult';
      var quill = new Quill(quillEditorId, {
          theme: 'snow'
      });

      // Set Quill content
      quill.root.innerHTML = description;

      // Handle form submission
      $(document).on('submit', '.form-inputkey', function() {
          var quillContent = quill.root.innerHTML;
          $('#commentkr' + id).val(quillContent);
      });
  });
  
  var inkey = document.querySelector('.form-inputkey');
   if(inkey) {
    document.querySelector('.form-inputkey').onsubmit = function() {

      // Lanjutkan dengan logic form submission lainnya
      $(".btn-progress").attr("disabled", "true");
      $(".spinner").show();
      $(".btn-inner--text").hide();
      $(".fa-plus").hide();
      };
   }



</script>
<script>
  $(document).ready(function() {
    $("#showEditModal").on('show.bs.modal', function(event) {
     var button         = $(event.relatedTarget);
     var valini         = button.data('valini');
     
     var desc           = button.data('desc');
     var idini          = button.data('idini');
     var idkr           = button.data('idkr');

     var startdate          = button.data('startdate');
     var duedate           = button.data('duedate');
   
     
      var hasilAngka = formatRibuan(valini);
       console.log(hasilAngka);

  
     document.getElementById("descriptioninitiative").value = desc;
     document.getElementById("valueinitiative").value = hasilAngka;
     document.getElementById("datestarteditini").value = startdate;
     document.getElementById("dateendeditini").value = duedate;
     document.getElementById("idinisiative").value = idini;
     document.getElementById("idkyer").value = idkr;

   });
   function formatRibuan(angka){
        var number_string =  angka.toString().replace(/[^,\d]/g, ""),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
 
 
 
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }
 
        angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
        return angka_hasil;
    }
  });
</script>
<script>

$(document).ready(function() {
    $("#showCmnModal").on('show.bs.modal', function(event) {
     var button = $(event.relatedTarget);
     var idini = button.data('idinisiative');
      
     $.ajax({
      url: "<?= base_url() ?>project/getComment",
      type: "POST",
      dataType: 'json',
      data: {
        idini: idini,
        },
      success: function(data) {
           $('.show-cmt').html(data); //menampilkan data ke dalam modal
        }
    });
   });

   $("#taskIniModal").on('show.bs.modal', function(event) {
      // Ambil data dari tombol yang men-trigger modal
      var button = $(event.relatedTarget); // Tombol yang men-trigger modal
      var idIni = button.data("idini"); // Ambil nilai dari data-idini
      var idOkr = button.data("idokr"); // Ambil nilai dari data-idokr
      var idPj = button.data("idpj"); // Ambil nilai dari data-idpj
      var namaini = button.data("namaini"); // Ambil nilai dari data-idpj

      // Set nilai tersebut ke dalam input di dalam modal
      var modal = $(this);
      modal.find("#taskini").val(idIni); // Set nilai idIni ke input taskini
      modal.find("#taskokr").val(idOkr); // Set nilai idOkr ke input taskokr
      modal.find("#taskpj").val(idPj); // Set nilai idPj ke input taskpj
      modal.find("#namakrtaskini").val(namaini); // Set nilai idIni ke input taskini
    });

    $("#docIniModal").on('show.bs.modal', function(event) {
      console.log("eckkkkkkkk");
      // Ambil data dari tombol yang men-trigger modal
      var button = $(event.relatedTarget); // Tombol yang men-trigger modal
      var idIni = button.data("idini"); // Ambil nilai dari data-idini
      var idOkr = button.data("idokr"); // Ambil nilai dari data-idokr
      var idPj = button.data("idpj"); // Ambil nilai dari data-idpj

      // Set nilai tersebut ke dalam input di dalam modal
      var modal = $(this);
      modal.find("#docini").val(idIni); // Set nilai idIni ke input taskini
      modal.find("#docokr").val(idOkr); // Set nilai idOkr ke input taskokr
      modal.find("#docpj").val(idPj); // Set nilai idPj ke input taskpj
    });
  });

  
  </script>
  <script>
  $('#valuekrinput').on('keyup',function(){
        var angka = $(this).val();
 
        var hasilAngka = formatRibuan(angka);
 
        $(this).val(hasilAngka);
    });

    $('#inputscore').on('keyup',function(){
        var angka = $(this).val();
 
        var hasilAngka = formatRibuan(angka);
 
        $(this).val(hasilAngka);
    });

    $('#valueinitiative').on('keyup',function(){
        var angka = $(this).val();
 
        var hasilAngka = formatRibuan(angka);
 
        $(this).val(hasilAngka);
    });


 
    function formatRibuan(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
 
 
 
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }
 
        angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
        return angka_hasil;
    }

  </script>
  <script>
    $(document).ready(function() { // Ketika halaman selesai di load

    $('#pilih-user').hide();
    $('#pilih-depart').hide();
    $('#adduser').change(function() { // Ketika user memilih filter
      if ($(this).val() == '') { // Jika adduser nya 2
        $('#pilih-user').hide(); // Tampilkan form pilih user
        $('#pilih-depart').hide();
      } else if ($(this).val() == '1') { // Jika adduser nya 2
        $('#pilih-user').hide(); // Tampilkan form pilih user
        $('#pilih-depart').show();
      } else if ($(this).val() == '2') { // Jika adduser nya 2
        $('#pilih-user').show(); // Tampilkan form pilih user
        $('#pilih-depart').hide();
      }
      $('#pilih-user select').val('');
    })
  })
  </script>
  <script>
$(document).ready(function() {
    // Mempertahankan dropdown terbuka
    var activeNav = localStorage.getItem('activeNav');
    if (activeNav) {
        $('#' + activeNav).addClass('show');
        $('[aria-controls="' + activeNav + '"]').attr('aria-expanded', 'true');
    }

    // Menyimpan status dropdown
    $('a[data-toggle="collapse"]').on('click', function() {
        var target = $(this).attr('aria-controls');
        if ($('#' + target).hasClass('show')) {
            localStorage.removeItem('activeNav');
        } else {
            localStorage.setItem('activeNav', target);
        }
    });

    // Menandai link aktif
    var currentUrl = window.location.href;
      $('.nav-link').each(function() {
          if (this.href === currentUrl) {
              $(this).addClass('active');
              $(this).closest('.collapse').addClass('show');
              $(this).closest('.collapse').prev('[data-toggle="collapse"]').attr('aria-expanded', 'true');
          }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var teamSpaceList = document.getElementById('listTeamspace');
        var teamPrivateList = document.getElementById('listPrivatespace');
      if(teamSpaceList) {
        if (teamSpaceList.scrollHeight <= 600) {
            teamSpaceList.classList.add('no-scrollbar');
        }
        if (teamPrivateList.scrollHeight <= 600) {
            teamPrivateList.classList.add('no-scrollbar');
        }
      }
    });
</script>

  <script>

  $(document).ready(function () {
    let mentionDropdown = $('#mention-dropdown');
    let messageInput = $('#message');
    let sendBtn = $('#send-btn');
    let userId = sendBtn.data('userid');
    let mentionType = null;
    let existingMentions = [];

    // Fungsi untuk mengambil data objectives dari server
    function loadMentions(type, query) {
      var myprojectid = $("#myprojectid").val();
      console.log(myprojectid)
        $.ajax({
            url: baseURL + 'workspace/loadMention', // Ganti dengan URL backend Anda
            method: 'POST',
            data: { type: type, query: query, myprojectid: myprojectid },
            success: function(response) {   
             
            // Pastikan response adalah objek JSON
            if (typeof response === 'string') {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    return;
                }
            }
              if (response && response.mentions) {
                    let listItems = '';
                    let tableType = response.table;
                    
                    response.mentions.forEach(function(mention) {
                    let itemName = '';
                    let idproject = '';
                    var link = '';
                    var idokr = '';

                    // Menyesuaikan tampilan berdasarkan tabel
                    if (tableType === 'objective') {
                        itemName  = mention.description_okr;
                        idproject = mention.id_project;
                        idokr     = mention.id_okr;
                    
                        link      = "project/showKey/" + idproject + "/" + idokr
                    } else if (tableType === 'document') {
                        itemName  = mention.name_document;
                        idproject = mention.id_project;
                        idokr     = mention.id_document;

                        link      = "document/index/" + idproject
                    
                    } else {
                        itemName  = mention.nama_kr;
                        idproject = mention.id_project;
                        idokr     = mention.id_document;

                        link      = "project/showKey/" + idproject + "/" + idokr    
                    } 

                    listItems += `<button type="button" class="list-group-item list-group-item-action" data-link="${link}" data-id="${idokr}" data-idpj="${idproject}" data-name="${itemName}"><small>${itemName}</small></button>`;
                });

                    mentionDropdown.html(listItems);
                    mentionDropdown.show();
                }
            }
        });
    }

      // Fungsi untuk memeriksa apakah mention sudah ada
      function isMentionAlreadyUsed(type, name) {
        return existingMentions.some(mention => type === type && name === name);
    }

    // Event handler untuk mengetik di input message
    messageInput.on('keyup', function() {
        let inputVal = messageInput.val();
        let atIndex = inputVal.lastIndexOf('@');
      
        if (atIndex >= 0) {
            let mentionCode = inputVal.substring(atIndex + 1, atIndex + 4).toLowerCase();
            let query = inputVal.substring(atIndex + 4).trim();

          
            if (mentionCode === 'obj') {
                mentionType = 'objective';
            } else if (mentionCode === 'kr') {
                mentionType = 'key_result';
            } else if (mentionCode === 'ini') {
                mentionType = 'initiative';
            } else if (mentionCode === 'doc') {
                mentionType = 'document';
            } else {
                mentionType = null;
            }
            console.log(existingMentions);
          
            if (mentionType) {    
              if (!isMentionAlreadyUsed(mentionType, query)) {
                    loadMentions(mentionType, query);
                } else {
                    mentionDropdown.hide();
                }
            } else {
                mentionDropdown.hide();
            }
        } else {
            mentionDropdown.hide();
        }
    });

    // Event handler untuk memilih mention dari dropdown
    mentionDropdown.on('click', '.list-group-item', function() {
        let mentionName = $(this).data('name');
        let mentionId   = $(this).data('id');
        let link        = $(this).data('link');

        // Update input message dengan mention yang dipilih
        let currentVal = messageInput.val();
        let atIndex = currentVal.lastIndexOf('@');
        let mentionCode = currentVal.substring(atIndex + 1, atIndex + 4).toLowerCase();
        let mentionType = '';
        if (mentionCode === 'obj') {
            mentionType = 'objective';
        } else if (mentionCode === 'kr') {
            mentionType = 'key_result';
        } else if (mentionCode === 'ini') {
            mentionType = 'initiative';
        } else if (mentionCode === 'doc') {
            mentionType = 'document';
        }
        messageInput.val(currentVal.substring(0, atIndex) + '@' + mentionType + '(' + mentionName + ') ');

         // Tambahkan mention ke daftar existingMentions
         existingMentions.push({ type: mentionType, name: mentionName });

         $('#hidden-link').val(link);

        // Sembunyikan dropdown dan kosongkan isinya
        mentionDropdown.hide();
        mentionDropdown.html('');
    });
	// Function to send message
	$("#send-btn").on("click", function () {
		console.log("cekk");
		var message = $("#message").val();
		var userid  = $(this).data("userid");
    var linkinput    = $('#hidden-link').val();
    var idroom    = $('#idroomchat').val();

    console.log("ROOM ID:", idroom);

    // RegEx untuk mendeteksi URL
    let urlPattern = /(https?:\/\/[^\s]+)/g;

    // Ganti URL dalam pesan dengan hyperlink
    let formattedMessage = message
        .replace(urlPattern, '<a class="text-white" style="text-decoration: underline;" href="$1" target="_blank"><i>$1<i></a>')
        .replace(/\n/g, '<br>'); // Mengganti newline dengan <br>

		if (message.trim() !== "") {
			$.ajax({
				url: baseURL + "workspace/chatInSpace", // Ganti dengan URL backend Anda
				method: "POST",
				data: {
					message: formattedMessage,
					user_id: userid, // Ganti dengan ID pengguna yang sedang login
          link: linkinput,
          idroom: idroom,
				},
				success: function (response) {
          console.log("Raw response:", response);

            // Coba parsing JSON jika response adalah string
            try {
                var parsedResponse = typeof response === 'string' ? JSON.parse(response) : response;
                console.log("Parsed response:", parsedResponse);

                if (parsedResponse.status === 'success') {
                  let mentionPattern = /@\w+\(.*?\)/;
                  let messageTime = new Date().toISOString();
                  console.log(messageTime)
                  
                  if (mentionPattern.test(message)) {
                    var formattedMessage = baseURL+'/'+linkinput;
                    $('#chat-window').append(`
                                <div class="d-flex justify-content-end mb-2 mr-5 p-4">
                                    <div class="bg-primary text-white rounded p-2">
                                        <div class="alert alert-secondary" role="alert">
                                            <a href="${formattedMessage}">${message.match(mentionPattern)[0]}</a>
                                        </div>
                                        <span class="textchat"><strong>You</strong><br> ${message.replace(mentionPattern, '')}</span>
                                        <br>
                                        <span class="badge badge-secondary timestamp" data-time="${messageTime}"></span>
                                    </div>
                                </div>
                            `);
                        } else {
                            // Format tanpa mention
                            $('#chat-window').append(`
                                <div class="d-flex justify-content-end mb-2 mr-5 p-4">
                                    <div class="bg-primary text-white rounded p-2">
                                    <span class="textchat"><strong>You</strong><br> ${message}</span>
                                    <br>
                                    <span class="badge badge-secondary timestamp" data-time="${messageTime}"></span>
                                    </div>
                                </div>
                            `);
                        }
                    $("#message").val(""); // Kosongkan input message

                    // Scroll ke bawah otomatis
                    $("#chat-window").scrollTop($("#chat-window")[0].scrollHeight);

                    // Update timestamps setelah chat baru ditambahkan
                  updateTimestamps();
                } else {
                    alert("Failed to send message");
                }
            } catch (e) {
                console.error('Error parsing JSON response:', e);
            }
				},
				error: function () {
					alert("Error in sending message");
				},
			});
		}
   

	});
   // Fungsi untuk menghitung perbedaan waktu
   function formatTimeDifference(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        const diffInMinutes = Math.floor(diffInSeconds / 60);
        const diffInHours = Math.floor(diffInMinutes / 60);
        const diffInDays = Math.floor(diffInHours / 24);

        if (diffInSeconds < 60) {
            return `${diffInSeconds}s`;
        } else if (diffInMinutes < 60) {
            return `${diffInMinutes}m`;
        } else if (diffInHours < 24) {
            return `${diffInHours}h`;
        } else if (diffInDays === 1) {
            return `1d`;
        } else {
            return `${diffInDays}d`;
        }
    }

    // Fungsi untuk memperbarui waktu di elemen chat
    function updateTimestamps() {
        const timestampElements = document.querySelectorAll('.timestamp');
        
        timestampElements.forEach(function (element) {
            const messageTime = new Date(element.getAttribute('data-time'));
            element.innerText = formatTimeDifference(messageTime);
        });
    }

    // Jalankan updateTimestamps setiap 60 detik
    setInterval(updateTimestamps, 60000);

    // Update timestamps ketika halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', updateTimestamps);

	// Function to load messages (optional, load existing messages)
      function loadMessages() {
        var chatWindow = document.getElementById("chat-window");
        if(chatWindow) {
          var isScrolledToBottom = chatWindow.scrollHeight - chatWindow.clientHeight <= chatWindow.scrollTop + 1;

          var your_user_id = $("#myuserid").val();
          var myprojectid = $("#myprojectid").val();
          var workspacesesi = $("#myworkspacesesi").val();
          
          $.ajax({
              url: baseURL + "workspace/loadMessageInSpace", // Ganti dengan URL backend Anda
              method: 'POST',
              data: {
                  myprojectid: myprojectid, workspacesesi: workspacesesi,
              },
              success: function(response, textStatus, jqXHR) {
                  console.log('Status:', textStatus);
                  console.log('Response:', response);
                  
                  if (typeof response === 'string') {
                      try {
                          response = JSON.parse(response);
                      } catch (e) {
                          console.error('Error parsing JSON:', e);
                          return;
                      }
                  }

                  if (response && response.messages) {
                      var newMessageExists = false;

                      $('#chat-window').empty(); // Kosongkan chat-window sebelum menambahkan pesan baru
                      
                      response.messages.forEach(function(message) {
                          var alignment = message.user_id_mc == your_user_id ? 'justify-content-end' : 'justify-content-start';
                          var bgClass = message.user_id_mc == your_user_id ? "#5e72e4" : message.color_mc;
                          var username = message.user_id_mc == your_user_id ? "You": message.username;
                          var timemsg = message.timestamp_mc

                          console.log(message.link_mc)

                          if (message.link_mc == null) {
                              $('#chat-window').append(`
                              <div class="d-flex ${alignment} mb-2 mr-5 position-relative">
                              
                                <div class="rounded p-2 text-white" style="background-color:${bgClass};max-width:300px;">
                                  <span class="textchat"><strong>${username}</strong><br>${message.message_mc}</span>
                                  <br>
                                  <span class="badge badge-secondary timestamp" data-time="${timemsg}"></span>
                                 
                                </div>
                                <!-- Dropdown untuk status -->
                              
                              </div>


                              `);
                          } else {
                              var formattedMessage = baseURL+'/'+message.link_mc;
                              
                              $('#chat-window').append(`
                                  <div class="d-flex ${alignment} mb-2">
                                      <div class="text-white rounded p-2" style="background-color:${bgClass};max-width:300px;">
                                          <div class="alert alert-secondary" role="alert">
                                              <a href="${formattedMessage}">${message.mention_mc}</a>
                                          </div>
                                          <span class="textchat"><strong>${username}</strong><br> ${message.message_mc}</span>
                                          <br>
                                          <span class="badge badge-secondary timestamp" data-time="${timemsg}"></span>
                                 
                                      </div>
                                  </div>
                              `);
                          }
                          
                          newMessageExists = true;
                          updateTimestamps();
                      });

                      if (isScrolledToBottom) {
                          // Scroll otomatis ke bawah hanya jika user berada di posisi paling bawah
                          chatWindow.scrollTop = chatWindow.scrollHeight;
                      } else if (newMessageExists) {
                          // Tampilkan notifikasi jika ada pesan baru dan user sedang scroll ke atas
                          showNewMessageNotification();
                      }
                  }
              }
          });

        }
          
        
      }

     loadMessages(); // Call function to load existing messages on page load

     function checkAndLoadMessages() {
          var roomspace = document.getElementById("roomspace");

          if (roomspace) {
              // Panggil loadMessages() setiap 5 detik
              var interval = setInterval(function() {
                  // Cek apakah roomspace masih ada di halaman
                  if (document.getElementById("roomspace")) {
                      loadMessages();
                  } else {
                      // Jika roomspace sudah tidak ada, hentikan interval
                      clearInterval(interval);
                  }
              }, 3000);
          }
      }

      function showNewMessageNotification() {
          var notification = document.createElement('div');
          notification.className = 'new-message-notification';
          notification.textContent = "";
          notification.style.position = 'absolute';
          notification.style.bottom = '10px';
          notification.style.left = '50%';
          notification.style.transform = 'translateX(-50%)';
          notification.style.color = '#fff';
          notification.style.padding = '5px 10px';
          notification.style.borderRadius = '5px';
          notification.style.cursor = 'pointer';
          notification.style.zIndex = '1000';

          notification.onclick = function() {
              // Scroll ke bawah jika user mengklik notifikasi
              var chatWindow = document.getElementById("chat-window");
              chatWindow.scrollTop = chatWindow.scrollHeight;
              notification.remove();
          };

          document.body.appendChild(notification);

          // Hapus notifikasi setelah beberapa detik jika tidak di-klik
          setTimeout(function() {
              if (notification.parentNode) {
                  notification.remove();
              }
          }, 5000);
      }

      // loadMessages();
      checkAndLoadMessages();

      // Ambil semua tombol yang memiliki atribut 'data-pj'
      const buttons = document.querySelectorAll("button[data-pj]");
      const idRoomChatInput = document.getElementById("idroomchat");
      const myProjectIdInput = document.getElementById("myprojectid");

      // Tambahkan event listener ke setiap tombol
      buttons.forEach((button) => {
        button.addEventListener("click", function () {
          // Ambil nilai dari atribut 'data-pj' pada tombol yang diklik
          const dataPj = this.getAttribute("data-pj");

          // Set value dari input hidden dengan id 'idroomchat'
          myProjectIdInput.value = dataPj;
          const workspaceSesi = document.getElementById("myworkspacesesi");

           // Hapus class btn-warning dari semua tombol dan kembalikan menjadi btn-secondary
           buttons.forEach(btn => {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-secondary');
            });

            // Tambahkan class btn-warning ke tombol yang diklik
            this.classList.remove('btn-secondary');
            this.classList.add('btn-warning');

            // Kirim AJAX request ke server untuk memanggil cekChat
            fetch('<?= base_url('workspace/cek_chat'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        id_project: dataPj, 
                        workspace_sesi: workspaceSesi.value
                    })
                })
                .then(response => response.json())
                .then(data => {

                  
                    // Ubah nilai idroomchat dengan hasil query dari server
                    idRoomChatInput.value = data.id_mcr;


                    loadMessages();

                    console.log("ID Room Chat diubah menjadi: " + data.id_mcr);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                

          // Jika perlu, kamu bisa tambahkan aksi lain seperti mengganti judul ruangan, refresh chat, dll.
          const roomTitle = this.querySelector(".titlechat").textContent;
          document.querySelector(".myroom").textContent = roomTitle;

        });
      });
      
    });
    document.addEventListener("DOMContentLoaded", function () {
      
    });

    $(document).ready(function() {
       // Cek status chat dari localStorage
      if (localStorage.getItem('chatStatus') === 'open') {
          $("#chat-column").removeClass("col-xl-1 minimized-chat").addClass("col-xl-4");
          $("#main-column").removeClass("col-xl-12").addClass("col-xl-8");
          $("#hidechat").html('<i class="ni ni-bold-left"></i>'); // Ikon untuk "hide chat"
      } else {
          $("#chat-column").removeClass("col-xl-4").addClass("col-xl-1 minimized-chat");
          $("#main-column").removeClass("col-xl-8").addClass("col-xl-12");
          $("#hidechat").html('<i class="ni ni-bold-right"></i>'); // Ikon untuk "show chat"
      }

      // Hide/Show Chat dan simpan status di localStorage
      $("#hidechat").click(function() {
          $("#chat-column").toggleClass("col-xl-4 col-xl-1 minimized-chat");
          $("#main-column").toggleClass("col-xl-8 col-xl-12");

          if ($("#chat-column").hasClass("minimized-chat")) {
              $("#hidechat").html('<i class="ni ni-bold-right"></i>'); // Ganti ikon menjadi "show chat"
              localStorage.setItem('chatStatus', 'closed'); // Simpan status "closed" di localStorage
          } else {
              $("#hidechat").html('<i class="ni ni-bold-left"></i>'); // Ganti ikon menjadi "hide chat"
              localStorage.setItem('chatStatus', 'open'); // Simpan status "open" di localStorage
          }
      });

      // Show Chat dari tombol lain dan simpan status di localStorage
      $("#showchat").click(function() {
          $("#chat-column").removeClass("col-xl-1 minimized-chat").addClass("col-xl-4");
          $("#main-column").removeClass("col-xl-12").addClass("col-xl-8");

          $("#hidechat").html('<i class="ni ni-bold-left"></i>'); // Ganti ikon menjadi "hide chat"
          localStorage.setItem('chatStatus', 'open'); // Simpan status "open" di localStorage
      });
    });

    
   </script>

<script>
      $(document).ready(function() {
          let emailsend = [];
          let emailcc = [];
          let usersend = [];
          let usersendinwork = [];
          let userokr = [];
          let templateemail = [];

          function loadTemplatesToDropdown() {
              const savedTemplates = JSON.parse(localStorage.getItem('emailTemplates')) || [];
              const templateDropdown = $('#template');

              templateDropdown.empty(); // Clear previous options

              savedTemplates.forEach((template, index) => {
                  templateDropdown.append(`<option value="${index}">${template.name}</option>`);
              });
          }

          // Call this function when modal opens
          $('#modalAmbilTemplate').on('show.bs.modal', function() {
              loadTemplatesToDropdown();
          });

          // Add template to Send or CC based on user selection
          $('#add-template').click(function() {
              const selectedTemplateIndex = $('#template').val();
              const inputTo = $('#inputto').val();
              const savedTemplates = JSON.parse(localStorage.getItem('emailTemplates')) || [];

              if (selectedTemplateIndex !== null && selectedTemplateIndex !== undefined) {
                  const selectedTemplate = savedTemplates[selectedTemplateIndex];

                  if (inputTo === "send") {
                    emailsend = [];
                    $('#send-badges').empty();

                      selectedTemplate.emails.forEach(email => {
                          if (!emailsend.includes(email)) {
                              emailsend.push(email);
                              $('#send-badges').append(
                                  `<span class="badge badge-primary">${email} <a type="button" class="closeusersend bg-danger" data-email="${email}"><i class="fas fa-window-close"></i></a></span>`
                              );
                          }
                      });
                  } else if (inputTo === "cc") {
                    emailcc = [];
                   $('#cc-badges').empty();

                      selectedTemplate.emails.forEach(email => {
                          if (!emailcc.includes(email)) {
                              emailcc.push(email);
                              $('#cc-badges').append(
                                  `<span class="badge badge-primary">${email} <a type="button" class="closeusercc bg-danger" data-email="${email}"><i class="fas fa-window-close"></i></a></span>`
                              );
                          }
                      });
                  }
              }

              // Close the modal
              $('#modalAmbilTemplate').modal('hide');
          });

          

                  // Function to add user to send array and display badge

          $('#addtemplate').click(function() {
              const selectedEmail = $('#emailtemplate').val();
              if (selectedEmail && !templateemail.includes(selectedEmail)) {
                templateemail.push(selectedEmail);
                  $('#send-badges-template').append(
                    `<span class="badge badge-primary">${selectedEmail} <a type="button" class="closeusertemplate bg-danger" data-email="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );

                  $('#emailtemplate').val("");
              }
          });

          $(document).on('click', '.closeusertemplate', function() {
              const email = $(this).data('email');
              templateemail = templateemail.filter(e => e !== email);
              $(this).parent().remove();
          });

          $('#save-template').click(function() {
            const templateName = $('#nametemplate').val();
            if (templateName && templateemail.length > 0) {
                // Simpan ke localStorage
                let savedTemplates = JSON.parse(localStorage.getItem('emailTemplates')) || [];
                const newTemplate = { name: templateName, emails: templateemail };

                savedTemplates.push(newTemplate);
                localStorage.setItem('emailTemplates', JSON.stringify(savedTemplates));

                Swal.fire({
                  title: "Email Disimpan!",
                  text: "Klik Ok untuk Melanjutkan!",
                  icon: "success"
                });
                $('#nametemplate').val("");
                $('#send-badges-template').html(""); // Clear the badges
                templateemail = []; // Reset the email array

                $('#modalTemplate').modal('hide');
            } else {
              Swal.fire({
                  title: "Email Tidak Bisa Disimpan!",
                  text: "Jangan ada data yang kosong!",
                  icon: "error"
                });
            }
        });

        let inputemail = [];


        $('#addemailuser').click(function() {
              const selectedEmail = $('#emailinput').val();
              if (selectedEmail && !inputemail.includes(selectedEmail)) {
                inputemail.push(selectedEmail);
                  $('#send-badges-email').append(
                    `<span class="badge badge-primary">${selectedEmail} <a type="button" class="closeinputemail bg-danger" data-email="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );

                  $('#emailinput').val("");
              }
          });

          $(document).on('click', '.closeinputemail', function() {
              const email = $(this).data('email');
              inputemail = inputemail.filter(e => e !== email);
              $(this).parent().remove();
          });

          // $('#modalEmail').on('show.bs.modal', function() {
            $('#input-email').click(function() {
                const inputTo = $('#inputemailto').val();
              
                    if (inputTo === "send") {
                     
                      emailsend = emailsend.filter(email => email !== inputemail).concat(inputemail);

                      $('#send-badges').empty(); 
                        emailsend.forEach(email => {
                            $('#send-badges').append(
                                `<span class="badge badge-primary">${email} <a type="button" class="closeusersend bg-danger" data-email="${email}"><i class="fas fa-window-close"></i></a></span>`
                            );
                        });
                                    
                    } else if (inputTo === "cc") {
                    
                      //emailcc = emailcc.concat(inputemail); 

                      emailcc = emailcc.filter(email => email !== inputemail).concat(inputemail);

                      $('#cc-badges').empty();
                        emailcc.forEach(email => {
                            $('#cc-badges').append(
                                `<span class="badge badge-primary">${email} <a type="button" class="closeusercc bg-danger" data-email="${email}"><i class="fas fa-window-close"></i></a></span>`
                            );
                        });
                    }

                     $('#emailinput').val(""); 

                   $('#modalEmail').modal('hide');
              });
            // });


          
    

             // Function to add user to send array and display badge
            $('#addinspaceview').click(function() {
              const selectedEmail = $('#tambahuserview').val();
              const selectedText = $('#tambahuserview option:selected').text();
              if (selectedEmail && !usersendinwork.includes(selectedEmail)) {
                  usersendinwork.push(selectedEmail);
                  $('#send-badges').append(
                    `<span class="badge badge-primary">${selectedText} <a type="button" class="closeuserview bg-danger" data-id="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );
              }
          });

          // Function to add user to send array and display badge
          $('#addusersend').click(function() {
              const selectedEmail = $('#send-user-select').val();
              const selectedText = $('#send-user-select option:selected').text();
              if (selectedEmail && !emailsend.includes(selectedEmail)) {
                  emailsend.push(selectedEmail);
                  $('#send-badges').append(
                    `<span class="badge badge-primary">${selectedEmail} <a type="button" class="closeusersend bg-danger" data-email="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );
              }
          });

      


                // Function to add user to send array and display badge
          $('#addinspace').click(function() {
              const selectedEmail = $('#tambahuser').val();
              const selectedText = $('#tambahuser option:selected').text();
              if (selectedEmail && !usersend.includes(selectedEmail)) {
                  usersend.push(selectedEmail);
                  $('#send-badges').append(
                    `<span class="badge badge-primary">${selectedText} <a type="button" class="closeuser bg-danger" data-id="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );
              }
          });
        

          // Function to add user to cc array and display badge
          $('#addusercc').click(function() {
              const selectedEmail = $('#cc-user-select').val();
              const selectedText = $('#cc-user-select option:selected').text();
              if (selectedEmail && !emailcc.includes(selectedEmail)) {
                  emailcc.push(selectedEmail);
                  $('#cc-badges').append(
                    `<span class="badge badge-primary">${selectedEmail} <a type="button" class="closeusercc bg-danger" data-email="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );
              }
          });

           // Function to remove user from send array when badge close button is clicked
           $(document).on('click', '.closeuserview', function() {
              const email = $(this).data('email');
              usersendinwork = usersendinwork.filter(e => e !== email);
              $(this).parent().remove();
          });


             // Function to remove user from send array when badge close button is clicked
          $(document).on('click', '.closeuser', function() {
              const id = $(this).data('id');
              usersend = usersend.filter(e => e !== id);
              $(this).parent().remove();
          });

          // Function to remove user from send array when badge close button is clicked
          $(document).on('click', '.closeusersend', function() {
              const email = $(this).data('email');
              emailsend = emailsend.filter(e => e !== email);
              $(this).parent().remove();
          });

          // Function to remove user from cc array when badge close button is clicked
          $(document).on('click', '.closeusercc', function() {
              const email = $(this).data('email');
              emailcc = emailcc.filter(e => e !== email);
              $(this).parent().remove();
          });

          $('#addinokr').click(function() {
           
              const selectedEmail = $('#tambahuserokr').val();
              const selectedText = $('#tambahuserokr option:selected').text();
              if (selectedEmail && !userokr.includes(selectedEmail)) {
                  userokr.push(selectedEmail);
                  $('#send-badges-okr').append(
                    `<span class="badge badge-primary">${selectedText} <a type="button" class="closeuseokr bg-danger" data-id="${selectedEmail}"><i class="fas fa-window-close"></i></a></span>`
                  );
              }

              // console.log(userokr)
          });

             // Function to remove user from send array when badge close button is clicked
          $(document).on('click', '.closeuseokr', function() {
              const id = $(this).data('id');
              userokr = userokr.filter(e => e !== id);
              $(this).parent().remove();
          });

          $('#senduserokr').submit(function(e) {
            e.preventDefault(); // Mencegah form submit secara default

              $.ajax({
                  type: 'POST',
                  url: '<?= base_url("project/tambahAnggotaOKR"); ?>',
                  data: {
                      idteam: $('#idaccessteam').val(),
                      tambahstatususer: $('#tambahstatususer').val(),
                      usersend: userokr,
                  },
                  success: function(response) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi sukses
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil!',
                          text: 'User berhasil ditambahkan!',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                            location.reload();
                          }
                      });
                  },
                  error: function(xhr, status, error) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi error
                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: 'Gagal menambahkan. Coba lagi.',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          });


          $('#senduserspaceview').submit(function(e) {
            e.preventDefault(); // Mencegah form submit secara default

              $.ajax({
                  type: 'POST',
                  url: '<?= base_url("workspace/tambahAnggota"); ?>',
                  data: {
                      idspace: $('#idspaceanggota').val(),
                      tambahstatususer: $('#tambahstatususer').val(),
                      usersend: usersendinwork,
                  },
                  success: function(response) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi sukses
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil!',
                          text: 'Berhasil menambah Anggota!',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                            location.reload();
                          }
                      });
                  },
                  error: function(xhr, status, error) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi error
                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: 'Gagal menambah Anggota.',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          });



          $('#senduserspace').submit(function(e) {
            e.preventDefault(); // Mencegah form submit secara default

              $.ajax({
                  type: 'POST',
                  url: '<?= base_url("workspace/tambahAnggota"); ?>',
                  data: {
                      idspace: $('#idspaceanggota').val(),
                       tambahstatususer: $('#tambahstatususer').val(),
                      usersend: usersend,
                  },
                  success: function(response) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi sukses
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil!',
                          text: 'Berhasil menambah Anggota!',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                            location.reload();
                          }
                      });
                  },
                  error: function(xhr, status, error) {
                      // Menutup SweetAlert2 loading dan menampilkan notifikasi error
                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: 'Gagal menambah Anggota.',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          });

          $('#formemail').submit(function(e) {
            e.preventDefault(); // Mencegah form submit secara default

                // Ambil nilai input
              const subject = $('#subjectemail').val().trim();
              const message = $('#pesanText').val().trim();
      
              // Validasi: Cek jika subject/message kosong atau emailsend kosong
              if (!subject || !message) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Form Tidak Lengkap',
                      text: 'Harap isi Subject, Pesan!',
                  });
                  return; // Hentikan proses
              }

            
              // Menampilkan SweetAlert2 loading
              Swal.fire({
                  title: 'Mengirim Email...',
                  text: 'Tunggu beberapa saat...',
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading();
                  }
              });


          //Mengirim data ke server menggunakan AJAX
          $.ajax({
              type: 'POST',
              url: '<?= base_url("document/send_email_doc"); ?>',
              data: {
                  subject: $('#subjectemail').val(),
                  file: $('#fileemail').val(),
                  emailsend: emailsend,
                  emailcc: emailcc,
                  namapengirim: $('#namapengirim').val(),
                  message: $('#pesanText').val(),
                  iddoc: $('#iddoc').val(),
              },
              
              success: function(response) {
                console.log(response); 
                
                  Swal.fire({
                      icon: 'success',
                      title: 'Berhasil!',
                      text: 'Email berhasil dikirim!',
                      confirmButtonText: 'OK'
                  }).then((result) => {
                      if (result.isConfirmed) {
                         var statuspage = $('#statuspage').val();
                          // Redirect ke halaman lain setelah klik OK
                          var idprojectemail = $('#idprojectemail').val();
                          var iddoc = $('#iddoc').val();
                          
                          if(statuspage == 'alldoc') {
                            var linkemail = baseURL + 'document/seedocument/' + iddoc;
                             window.location.href = linkemail;
                          } else {
                            var linkemail = baseURL + 'document/seedocument/' + iddoc;
                            window.location.href = linkemail;
                          }
   
                      }
                  });
                
              },
              error: function(xhr, status, error) {
                  // Menutup SweetAlert2 loading dan menampilkan notifikasi error
                  Swal.fire({
                      icon: 'error',
                      title: 'Gagal!',
                      text: 'Gagal mengirim email. Coba lagi.',
                      confirmButtonText: 'OK'
                  });
              }
          });
      });
      });

      $(document).ready(function() {
          $(".tipe").change(function() {
            var selectedType = $(this).val();
            var parentRow = $(this).closest('.row'); // Find the closest parent row to isolate the form

            // Find the corresponding Score input in the same row
            var scoreInput = parentRow.find('.valueinput');

            if (selectedType === "check") {
              scoreInput.prop("disabled", true); // Disable the Score input
            } else {
              scoreInput.prop("disabled", false); // Enable the Score input
            }
          });
        });    
      
        
    </script>
    <script>
        // Get the input element by its ID
        const namadocumentInput = document.getElementById('namadocument');
        if(namadocumentInput) {
           // Add an event listener for the 'input' event
          namadocumentInput.addEventListener('input', function() {
              // Convert the input value to uppercase
              this.value = this.value.toUpperCase();
          });
        }
       
        document.addEventListener('DOMContentLoaded', function() {
          var checkkeyButton = document.getElementById('checkkey');
          var removeKeyButton = document.getElementById('removekey');
          var formContainer = document.getElementById('formContainer');
          var dokumenokr = document.getElementById('dokumenokr');
          if(checkkeyButton) {
          checkkeyButton.addEventListener('click', function() {
              var selectedOption = dokumenokr.value;

              var existingField = document.querySelector('.dynamic-field');
                  if (existingField) {
                      existingField.remove();
                      var okrInput = document.getElementById('myokr');
                      var tipeokr = document.getElementById('tipeokr');

                      okrInput.value = "";
                      tipeokr.value  = "";
                      
                  }

              if (selectedOption === "1") {
                  // Append Key Result select box
                  var newField = document.createElement('div');
                  newField.classList.add('col-lg-6', 'dynamic-field');
                  newField.innerHTML = `
                      <div class="form-group">
                          <label for="okrselect" class="form-control-label">Key Result</label>
                          <select id="okrselect" name="okrselect" class="form-control add-email okrselect">
                              <option value="">- Pilih User -</option>
                              <?php foreach ($key_result as $key_result) : ?>
                                  <option value="<?= $key_result['idkeyresult']; ?>"><?= $key_result['namakeyresult']; ?> (OBJ : <?= $key_result['namaokr'] ?>)</option>
                              <?php endforeach; ?>
                          </select>
                      </div>`;
                  formContainer.appendChild(newField);
                        // Add event listener to the newly created select box
                      var okrSelect = document.getElementById('okrselect');
                      var okrInput = document.getElementById('myokr');
                      var tipeokr = document.getElementById('tipeokr');

                      // Menggunakan jQuery untuk Select2
                      $('#okrselect').on('change', function() {
                          // Ambil nilai dari Select2
                          var selectedValue = $(this).val();

                          // Set nilai dari input ke nilai yang dipilih dari select
                          okrInput.value = selectedValue;
                          tipeokr.value = "key";
                      });

                    $('.okrselect').select2({
                      placeholder: "Pilih Key",
                      allowClear: true,
                    });

                    
              } else if (selectedOption === "2") {
                  // Append Initiative select box
                  var newField = document.createElement('div');
                  newField.classList.add('col-lg-6', 'dynamic-field');
                  newField.innerHTML = `
                      <div class="form-group">
                          <label for="inisiativeselect" class="form-control-label">Inisiative</label>
                          <select id="inisiativeselect" name="inisiativeselect" class="form-control add-email inisiativeselect">
                              <option value="">- Pilih User -</option>
                              <?php foreach ($initiative as $initiative) : ?>
                                  <option value="<?= $initiative['idinitiative']; ?>"><?= $initiative['namainitiative']; ?> (KEY RESULT : <?= $initiative['namakeyresult'] ?>)</option>
                              <?php endforeach; ?>
                          </select>
                      </div>`;
                  formContainer.appendChild(newField);
                // Add event listener to the newly created select box
                var iniSelect = document.getElementById('inisiativeselect');
                  var okrInput = document.getElementById('myokr');
                  var tipeokr = document.getElementById('tipeokr');


                  $('#inisiativeselect').on('change', function() {
                     // Ambil nilai dari Select2
                     var selectedValue = $(this).val();

                      // Set value dari input ke nilai yang dipilih dari select
                        okrInput.value = selectedValue;
                        tipeokr.value  = "inisiative";
                    });

                    $('.inisiativeselect').select2({
                      placeholder: "Pilih Key",
                      allowClear: true,
                    });

              }
           

          });
        }
        if(removeKeyButton) {
          removeKeyButton.addEventListener('click', function() {
              var dynamicFields = formContainer.getElementsByClassName('dynamic-field');
              if (dynamicFields.length > 0) {
                  dynamicFields[dynamicFields.length - 1].remove();
                  var okrInput = document.getElementById('myokr');
                      var tipeokr = document.getElementById('tipeokr');

                      okrInput.value = "";
                      tipeokr.value  = "";
              }
          });
        }
 
              

      });

      document.addEventListener('DOMContentLoaded', function() {
        var submitBtn = document.getElementById('submitBtn');
        var tipeokrInput = document.getElementById('tipeokr');
        var myForm = document.getElementById('myForm');

        var addBtn = document.getElementById('btnAdd');

        var btnAddRev = document.getElementById('btnAddRev');

        if(btnAddRev) {
            
            // Event listener untuk tombol "Simpan Perubahan"
            document.getElementById('document-formrevisi').addEventListener('submit', function(event) {
           

            var quillContent = quillokr.root.innerHTML;

          document.getElementById("describeokr").value = quillContent;

            var currentData = {
                file: valuefile,
                selectOrder: document.getElementById('selectOrder').value,
                selectUser: document.getElementById('selectUser').value,
                nameDocument : document.getElementById('namadokumen').value,
                typeDocument : document.getElementById('typedokumen').value,
            };

            var isDataChanged = JSON.stringify(initialData) !== JSON.stringify(currentData);

            console.log(currentData);
            console.log(initialData);

            if (!isDataChanged) {
                // Jika tidak ada perubahan, cegah pengiriman form
                event.preventDefault();
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Tidak ada perubahan yang dilakukan. Form tidak dapat dikirim.",
                });
                
                return false;
            } else {
              event.preventDefault(); // Prevent the form from submitting normally
            
              var signaturesInput = document.createElement('input');
              signaturesInput.type = 'hidden';
              signaturesInput.name = 'signatures';
              signaturesInput.value = JSON.stringify(userOrderArray);

              this.appendChild(signaturesInput);
              this.submit(); // Submit the form with the additional input
            }
        });
          }
        
        if(addBtn) {
             // Event listener untuk tombol "Simpan Perubahan"
            document.getElementById('document-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                var signaturesInput = document.createElement('input');
                signaturesInput.type = 'hidden';
                signaturesInput.name = 'signatures';
                signaturesInput.value = JSON.stringify(userOrderArray);

                var quillContent = quillokr.root.innerHTML;

                  document.getElementById("describeokr").value = quillContent;

                this.appendChild(signaturesInput);
                this.submit(); // Submit the form with the additional input
            });
        
        }


        if(submitBtn) {
          submitBtn.addEventListener('click', function(e) {
            var tipeokrValue = tipeokrInput.value.toLowerCase();

            var quillContent = quillokr.root.innerHTML;

            console.log(quillContent);

            document.getElementById("describeokr").value = quillContent;

            if (tipeokrValue === 'key') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda ingin menjadikan dokumen ini sebuah inisiative?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user mengklik "Ya", tambahkan hidden input dan submit form
                        var newInput = document.createElement('input');
                        newInput.type = 'hidden';
                        newInput.name = 'add_to_initiative';
                        newInput.value = 'yes';
                        myForm.appendChild(newInput);

                        myForm.submit();
                    } else {
                        // Jika user mengklik "Tidak", submit form tanpa tambahan input
                        myForm.submit();
                    }
                });
            } else {
                // Jika tidak ada konfirmasi diperlukan, langsung submit form
                myForm.submit();
            }
        });
        }
       
    });


    </script>
   
  
      </body>

      </html>