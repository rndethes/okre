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
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Input Data</h3>
            </div>
            <hr class="my-4" />
          </div>
        </div>
        <div class="card-body">
          <?php $role_id = $this->session->userdata('role_id') ?> 
         <div class="row">
            <div class="col-lg-6">
                <h1><?= $tables['table_name'] ?></h1>
            </div>
            <div class="col-lg-12">
                <p><?= $tables['description'] ?></p>
            </div>
         </div>
           <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#exampleModal">
                Edit Data
            </button>
            <a href="<?= base_url("data/viewinput/") . $this->uri->segment(3) . "/" . $tables['id']; ?>" type="button" class="btn btn-success rounded-pill">
                Lanjutkan Input Data
            </a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Tabel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post" action="<?= base_url("data/edittable/") . $this->uri->segment(3) . "/" . $tables['id']; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tablename" class="form-control-label">Nama Tabel</label>
                                <input class="form-control" type="text" id="tablename" name="tablename" value="<?= $tables['table_name'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tabledesc" class="form-control-label">Deskripsi Tabel</label>
                                <textarea class="form-control" id="tabledesc" name="tabledesc" rows="3"><?= $tables['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
            <hr>
            <input class="form-control" type="hidden" id="table_id" name="table_id" value="<?= $tables['id'] ?>">
            <input class="form-control" type="hidden" id="table_name_input" name="table_name_input" value="<?= $tables['table_name'] ?>">
            <input class="form-control" type="hidden" id="idpj" name="idpj" value="<?= $this->uri->segment(3) ?>">

            <button class="btn btn-icon btn-primary rounded-pill" type="button" id="addRow">
                <span class="btn-inner--icon"><i class="ni ni-plus"></i></span>
                <span class="btn-inner--text">Tambah Baris</span>
            </button> 

            <button class="btn btn-icon btn-success rounded-pill" type="submit" id="saveData">
                <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                <span class="btn-inner--text">Save Data</span>
            </button>
            
            </br>
            </br>

            <div class="table-responsive">
                <div>
                    <table class="table align-items-center">
                        <form id="dataForm">
                            <thead class="thead-light">
                                <tr>
                                    <?php foreach($datacolumn as $datacol) { ?>
                                        <th scope="col" class="sort" data-sort="<?= $datacol['column_name'] ?>"><?= $datacol['column_name'] ?></th>
                                    <?php } ?>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="tableBody"> 
                                <tr id="input-row">
                                <?php foreach($datacolumn  as $datacol) { ?>
                                    <?php if($datacol['data_type'] == 'number') {
                                        $newclass = 'math-input';
                                        $typform = 'text';
                                    } else if($datacol['data_type'] == 'date') {
                                        $newclass = ''; 
                                        $typform = 'date';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                    } else {
                                        $newclass = ''; 
                                        $typform = 'text';     
                                    }
                                    ?>
                                    <td class="datavalue">
                                        <div class="form-group from-edit-value">
                                            <input class="form-control <?= $newclass ?>" 
                                                type="<?= $typform ?>" 
                                                data-type="<?= $datacol['data_type'] ?>"
                                                placeholder="Masukan <?= $datacol['column_name'] ?>" 
                                                name="<?= $datacol['column_id'] ?>">
                                        </div>
                                    </td>
                                <?php } ?>
                                    <td class="datavalue">
                                       <button class="btn btn-sm btn-icon btn-danger rounded-pill removeRow" type="button">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                            <span class="btn-inner--text">Hapus</span>
                                        </button>
                                       
                                    </td>
                                </tr>  
                            </tbody>
                        </form>
                    </table>
                    
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
        mathInputOperation();
    });
        // Fungsi untuk menambah baris baru di tabel
        document.getElementById('addRow').addEventListener('click', function() {
            // Ambil elemen body tabel
            var tableBody = document.getElementById('tableBody');

            // Ambil elemen baris input sebagai template
            var inputRow = document.getElementById('input-row').cloneNode(true);

            // Reset nilai input di baris yang baru
            var inputs = inputRow.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = ''; // Mengosongkan value input
            });

            // Tambahkan event listener untuk tombol Hapus baris baru
            var removeButton = inputRow.querySelector('.removeRow');
            removeButton.addEventListener('click', function() {
                this.closest('tr').remove(); // Hapus baris jika tombol Hapus diklik
            });

            // Tambahkan baris baru ke tabel
            tableBody.appendChild(inputRow);

            mathInputOperation();
        });

        // Fungsi untuk menyimpan data ke Local Storage setiap kali input berubah
        function saveDataToLocalStorage() {
            var tableBody = document.getElementById('tableBody');
            var rows = tableBody.querySelectorAll('tr');
            var rowData = [];

            // Loop setiap baris dan simpan data input ke dalam array
            rows.forEach(function(row) {
                var inputs = row.querySelectorAll('input');
                var rowValues = {};
                inputs.forEach(function(input) {
                    rowValues[input.name] = input.value; // Simpan nilai input berdasarkan name attribute
                });
                rowData.push(rowValues); // Tambahkan data baris ke array
            });

            // Simpan array ke Local Storage
            localStorage.setItem('tableData', JSON.stringify(rowData));
        }

        function loadDataFromLocalStorage() {
            var savedData = localStorage.getItem('tableData');
            if (savedData) {
                var rowData = JSON.parse(savedData);  // Ambil data dari Local Storage dan parsing
                var tableBody = document.getElementById('tableBody');  // Element tbody dari tabel

                // Kosongkan tabel sebelum menambahkan data yang tersimpan
                tableBody.innerHTML = '';

                // Loop untuk setiap data di Local Storage
                rowData.forEach(function(rowValues) {
                    var newRow = document.createElement('tr');  // Buat elemen <tr> baru untuk setiap baris
                    newRow.setAttribute('id', 'input-row');  // Set id untuk row baru

                    // Isi setiap kolom sesuai dengan data yang disimpan di Local Storage
                    <?php foreach($datacolumn as $datacol) { ?>
                    var newCell = document.createElement('td');
                    newCell.classList.add('datavalue');  // Tambahkan class ke <td>

                    var formGroup = document.createElement('div');
                    formGroup.classList.add('form-group', 'from-edit-value');  // Tambahkan class ke div form-group

                    if($datacol['data_type'] == 'number') {
                                        $newclass = 'math-input';
                                        $typform = 'text';
                                    } else if($datacol['data_type'] == 'date') {
                                        $newclass = ''; 
                                        $typform = 'date';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                    } else {
                                        $newclass = ''; 
                                        $typform = 'text';     
                                    }

                    var input = document.createElement('input');
                    input.className = 'form-control <?= $datacol['data_type'] == 'number' ? 'math-input' : '' ?>';
                    input.setAttribute('type', 'text');
                    input.setAttribute('data-type', '<?= $datacol['data_type'] ?>');
                    input.setAttribute('placeholder', 'Masukan <?= $datacol['column_name'] ?>');
                    input.setAttribute('name', '<?= $datacol['column_id'] ?>');
                    input.value = rowValues['<?= $datacol['column_id'] ?>'] || '';  // Ambil nilai yang sesuai dari Local Storage

                    // Masukkan input ke dalam form-group, kemudian ke dalam cell
                    formGroup.appendChild(input);
                    newCell.appendChild(formGroup);
                    newRow.appendChild(newCell);
                    <?php } ?>

                    // Tambahkan tombol hapus di kolom terakhir
                    var removeCell = document.createElement('td');
                    removeCell.classList.add('datavalue');  // Tambahkan class ke <td>

                    var removeButton = document.createElement('button');
                    removeButton.classList.add('btn', 'btn-sm', 'btn-icon', 'btn-danger', 'rounded-pill', 'removeRow');
                    removeButton.setAttribute('type', 'button');
                    removeButton.innerHTML = '<span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span><span class="btn-inner--text">Hapus</span>';

                    // Event listener untuk hapus baris
                    removeButton.addEventListener('click', function() {
                        var rowCount = document.querySelectorAll('#tableBody tr').length;
                        if (rowCount > 1) {
                            this.closest('tr').remove();  // Hapus baris
                            saveDataToLocalStorage();  // Update Local Storage setelah baris dihapus
                        } else {
                            alert('Baris terakhir tidak dapat dihapus.');
                        }
                    });

                    removeCell.appendChild(removeButton);
                    newRow.appendChild(removeCell);

                    // Masukkan baris baru ke dalam tbody
                    tableBody.appendChild(newRow);
                });

                // Reapply the event listener for any remaining rows
                document.querySelectorAll('.removeRow').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var rowCount = document.querySelectorAll('#tableBody tr').length;
                        if (rowCount > 1) {
                            this.closest('tr').remove(); // Hapus baris jika tombol Hapus diklik
                            saveDataToLocalStorage();  // Update localStorage setelah baris dihapus
                        } else {
                            alert('Baris terakhir tidak dapat dihapus.');
                        }
                    });
                });
            }
            mathInputOperation();
        }



        // Panggil fungsi ini setiap kali ada perubahan pada input
        document.getElementById('tableBody').addEventListener('input', saveDataToLocalStorage);

        // Panggil fungsi ini saat halaman dimuat untuk mengambil data dari Local Storage
        window.onload = loadDataFromLocalStorage;

        // Tambahkan event listener untuk tombol tambah baris agar datanya juga tersimpan
        document.getElementById('addRow').addEventListener('click', function() {
            saveDataToLocalStorage(); // Simpan data ke Local Storage saat menambah baris baru
            mathInputOperation();
        });


        // Fungsi untuk mengecek dan mengeksekusi ekspresi matematika
        function evaluateMathExpression(input) {
            try {
                // Eksekusi ekspresi matematika dengan eval
                let result = eval(input);
                // Pastikan hasilnya berupa angka
                if (!isNaN(result)) {
                    return result;
                } else {
                    return input;  // Jika hasil bukan angka, kembalikan input aslinya
                }
            } catch (e) {
                return input;  // Jika terjadi error dalam evaluasi, kembalikan input aslinya
            }
        }

        function mathInputOperation() {
            // Event listener untuk input dengan tipe data number
            document.querySelectorAll('.math-input').forEach(function(inputElement) {
                inputElement.addEventListener('keydown', function(e) {
                    // Cek jika user menekan tombol Enter
                    if (e.key === 'Enter') {
                        // Cek apakah data-type adalah 'number'
                        if (inputElement.getAttribute('data-type') === 'number') {
                            // Ambil nilai dari input
                            let inputValue = inputElement.value.trim();
                            
                            // Evaluasi ekspresi matematika
                            let evaluatedResult = evaluateMathExpression(inputValue);
                            
                            // Ganti nilai input dengan hasil evaluasi
                            inputElement.value = evaluatedResult;
                        }
                    }
                });
            });
        }

        // Event listener untuk tombol Save Data
        document.getElementById('saveData').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah pengiriman form jika diperlukan
           
            saveDataToDatabase(); // Simpan data ke database
        });

        function saveDataToDatabase() {
        var tableBody = document.getElementById('tableBody');
        var rows = tableBody.querySelectorAll('tr');
        var rowData = [];

        // Loop setiap baris dan simpan data input ke dalam array
        rows.forEach(function(row, index) {
            var inputs = row.querySelectorAll('input');
            inputs.forEach(function(input) {
                rowData.push({
                    row_number: index + 1, // Menyimpan nomor baris
                    table_id: 1,           // Ganti dengan ID tabel yang sesuai
                    column_id: input.name, // ID kolom
                    column_value: input.value // Nilai kolom
                });
            });
        });

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: "<?= base_url('/data/saveData') ?>", // Ganti dengan URL controller
            type: 'POST',
            data: { data: rowData }, // Mengirim data
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    alert(result.message);
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    }

  
  </script>

            