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
      <!-- Card stats -->

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

            
            <div class="table-responsive">
                <div>
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="tabel">Tabel</th>
                                <th scope="col" class="sort" data-sort="namakolom">Nama Kolom</th>
                                <th scope="col" class="sort" data-sort="tipedata">Tipe Data</th>
                                <th scope="col">Perbolehkan Kosong</th>
                                <th scope="col" class="sort" data-sort="default">Default</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list"> 
                             <!-- Baris Data -->
                            <?php foreach ($datacolumn as $data) : ?>
                            <tr id="row-<?= $data['id'] ?>">
                                <td><?= $tables['table_name'] ?></td>
                                <td><span><?= $data['column_name'] ?></span></td>
                                <?php 
                                    if($data['data_type'] == 'varchar') {
                                        $datatype = 'Karakter';
                                    } else {
                                        $datatype = 'Number';
                                    }
                                ?>
                                <td><span><?= $datatype ?></span></td>
                                <td><span><?= $data['is_nullable'] == 1 ? 'Kosong' : 'Tidak Kosong' ?></span></td>
                                <td><span><?= $data['default_value'] ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-warning rounded-pill" type="button" onclick="editData(<?= $data['id'] ?>)">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Edit</span>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger rounded-pill" type="button" onclick="deleteData(<?= $data['id'] ?>)">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                        <span class="btn-inner--text">Hapus</span>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <!-- Baris Input -->
                            <tr id="input-row">
                                <td><?= $tables['table_name'] ?></td>
                                <td> 
                                    <div class="form-group mt-2">
                                        <input class="form-control" type="text" placeholder="Masukan Nama Kolom" id="namakolom" name="namakolom">
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-group mt-2">
                                        <select class="form-control" id="typedata" name="typedata">
                                            <option value="varchar">Karakter</option>
                                            <option value="int">Number</option>
                                            <option value="date">Date</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mt-2">
                                        <select class="form-control" id="kosong" name="kosong">
                                            <option value="1">Kosong</option>
                                            <option value="0">Tidak Kosong</option>
                                        </select>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-group mt-2">
                                        <input class="form-control" type="text" placeholder="Isi Default" id="defaultval" name="defaultval">
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-default rounded-pill" type="button" id="saveDataColomn">
                                        <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                        <span class="btn-inner--text">Simpan dan Lanjutkan</span>
                                    </button>
                                </td>
                            </tr>            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editNamaKolom">Nama Kolom</label>
                        <input type="text" class="form-control" id="editNamaKolom" name="nama_kolom">
                    </div>
                    <div class="form-group">
                        <label for="editTipeData">Tipe Data</label>
                        <select class="form-control" id="editTipeData" name="tipe_data">
                            <option value="varchar">Karakter</option>
                            <option value="int">Number</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editKosong">Kosong</label>
                        <select class="form-control" id="editKosong" name="kosong">
                            <option value="1">Kosong</option>
                            <option value="0">Tidak Kosong</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editDefaultValue">Default Value</label>
                        <input type="text" class="form-control" id="editDefaultValue" name="default_value">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

            