<div class="header bg-dark-primary pb-6">
  <div class="container-fluid">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flashPj'); ?>"></div>
    <?php if ($this->session->flashdata('flashPj')) : ?>
    <?php endif; ?>
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Kuadran</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Project</a></li>
              <li class="breadcrumb-item active" aria-current="page">Kuadran</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
    <div class="row" style="padding: 15px;">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-1">
                    <h1 style="text-align: center;"><i class="fa fa-flag" style="color: #ffea00;"></i></h1>
                </div>
                <div class="card-body" style="overflow-y: scroll; max-height: 250px;">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Jenis Table</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($medium as $data)  : ?>
                                    <tr>
                                        <td><?= $data->id ?></td>
                                        <td><?= $data->jenis_tabel ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->nama_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->description_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->nama_kr ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->description ?></td>
                                        <?php } ?>
                                        <td><?= $data->username ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->value_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->value_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->precentage ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->value_percent ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-1">
                    <h1 style="text-align: center;"><i class="fa fa-flag" style="color: #db2424;"></i></h1>
                </div>
                <div class="card-body" style="overflow-y: scroll; max-height: 250px;">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Jenis Table</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($high as $data)  : ?>
                                    <tr>
                                        <td><?= $data->id ?></td>
                                        <td><?= $data->jenis_tabel ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->nama_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->description_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->nama_kr ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->description ?></td>
                                        <?php } ?>
                                        <td><?= $data->username ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->value_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->value_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->precentage ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->value_percent ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding: 15px;">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-1">
                    <h1 style="text-align: center;"><i class="fa fa-flag" style="color: #d1d1d1;"></i></h1>
                </div>
                <div class="card-body" style="overflow-y: scroll; max-height: 250px;">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Jenis Table</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lowest as $data)  : ?>
                                    <tr>
                                        <td><?= $data->id ?></td>
                                        <td><?= $data->jenis_tabel ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->nama_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->description_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->nama_kr ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->description ?></td>
                                        <?php } ?>
                                        <td><?= $data->username ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->value_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->value_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->precentage ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->value_percent ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-1">
                    <h1 style="text-align: center;"><i class="fa fa-flag" style="color: #29dbff;"></i></h1>
                </div>
                <div class="card-body" style="overflow-y: scroll; max-height: 250px;">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Jenis Table</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($low as $data)  : ?>
                                    <tr>
                                        <td><?= $data->id ?></td>
                                        <td><?= $data->jenis_tabel ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->nama_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->description_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->nama_kr ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->description ?></td>
                                        <?php } ?>
                                        <td><?= $data->username ?></td>
                                        <?php if ($data->jenis_tabel == 'Project') { ?>
                                        <td><?= $data->value_project ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Objective') { ?>
                                        <td><?= $data->value_okr ?></td>
                                        <?php } elseif ($data->jenis_tabel == 'Key Result') { ?>
                                        <td><?= $data->precentage ?></td>
                                        <?php } else { ?>
                                        <td><?= $data->value_percent ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>