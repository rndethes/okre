<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

  defined('BASEPATH') or exit('No direct script access allowed');


  use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
  use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Style\Alignment;
  use PhpOffice\PhpSpreadsheet\Style\Fill;
  use PhpOffice\PhpSpreadsheet\Style\Border;
  use PhpParser\Node\Stmt\Echo_;

  class Project extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Account_model');
      $this->load->model('Departement_model');
      $this->load->model('Project_model');
      $this->load->model('Space_model');
      $this->load->model('Team_model');
      $this->load->model('Main_model');
      $this->load->library('form_validation');
      $this->load->helper('url', 'form');

      $usernamesession = $this->session->userdata('username');
     
      $validatelogin = $this->Main_model->getUserLogin($usernamesession);
 
      if(empty($validatelogin)){
       redirect('auth/backlogin');
      } 
    }
    public function index()
    {
      $data['title']          = 'Data Workspace';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $iduser = $this->session->userdata('id');

      $delegasi = $this->Project_model->cekDelegasi($iduser);
      
      $data['all_project']         = $this->Project_model->countAllProject();
      $data['all_space']              = $this->Project_model->countAllSpace();
      $data['team_space_total']       = $this->Project_model->countTeamSpace();
      $data['private_space_total']    = $this->Project_model->countPrivateSpace();


       $cekspace = $this->Project_model->cekSpace($iduser);   
       
       $data['cekspace'] = $cekspace;

       $data['notifspace']      = $this->Space_model->checkApprovalSpace($iduser);

       $data['spaceteam']       = $this->Space_model->dataSpaceTeam($iduser);

       $data['spaceprivate']    = $this->Space_model->dataSpacePrivate($iduser);

       $data['datanotif']       = $this->Space_model->checkWhoNotif($iduser);

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/viewspace', $data);
      $this->load->view('template/footer', $data);
    }

    public function projectAtWorkspace($idspace){
      $data['title']          = 'Data Workspace';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      //$data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $data['space']          = $this->Space_model->checkSpaceById($idspace);

      $this->session->set_userdata('workspace_sesi', $idspace);

      $iduser   = $this->session->userdata('id');

      $delegasi = $this->Project_model->cekDelegasi($iduser);
      
      $data['recent_project']      = $this->Project_model->getRecentProject();
      $data['all_project']         = $this->Project_model->countAllProject();
      $data['complete_project']    = $this->Project_model->countCompleteProject();


      $projectDelegasi       = $this->Project_model->getYourProjectDelegate($idspace);
   
      $projects              = $this->Project_model->getYourProject($idspace);

       // Gabungkan data dengan ID project sebagai kunci
       $combinedData = [];

       // Tambahkan data dari projectDelegasi ke array gabungan
       foreach ($projectDelegasi as $delegate) {
           $projectId = $delegate['id_project']; // Sesuaikan dengan nama kolom ID project di tabel delegate_save
           if (!isset($combinedData[$projectId])) {
               $combinedData[$projectId] = $delegate;
           } else {
               // Menggabungkan data jika id_project sudah ada
               $combinedData[$projectId] = array_merge($combinedData[$projectId], $delegate);
           }
       }

       // Tambahkan data dari projects ke array gabungan
       foreach ($projects as $project) {
           $projectId = $project['id_project']; // Sesuaikan dengan nama kolom ID project di tabel projects
           if (!isset($combinedData[$projectId])) {
               $combinedData[$projectId] = $project;
           } else {
               // Menggabungkan data jika project_id sudah ada
               $combinedData[$projectId] = array_merge($combinedData[$projectId], $project);
           }
       }

       $data['projects'] = $combinedData;
        
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/project', $data);
      $this->load->view('template/footer', $data);
    }

    // public function your_project()
    // {
    //   $data['title']          = 'Data Project OKR';
    //   $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    //   $data['project']        = $this->Project_model->getProjectJoinUser();
    //   $data['team']           = $this->Team_model->getALLTeam();
    //   $data['users']          = $this->Account_model->getJoinUsers();
    //   $data['departement']    = $this->Departement_model->getAllDepartement();

    //   $data['your_project']        = $this->Project_model->getYourProject();
    //   $data['recent_project']      = $this->Project_model->getRecentProject();
    //   $data['all_project']         = $this->Project_model->countAllProject();
    //   $data['complete_project']    = $this->Project_model->countCompleteProject();

    


    //   $this->load->view('template/header', $data);
    //   $this->load->view('template/sidebar', $data);
    //   $this->load->view('template/topbar', $data);
    //   $this->load->view('project/your_project', $data);
    //   $this->load->view('template/footer', $data);
    // }

     public function neWorkspace()
    {
      $data['title']          = 'New Work SPace';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getALLUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $data['your_project']        = $this->Project_model->getYourAllProject();
      $data['recent_project']      = $this->Project_model->getRecentProject();
      $data['all_project']         = $this->Project_model->countAllProject();
      $data['complete_project']    = $this->Project_model->countCompleteProject();

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/new_workspace', $data);
      $this->load->view('template/footer', $data);
    }

    public function projectAll($idspace)
    {
      $data['title']          = 'Data Project OKR';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $data['space']          = $this->Space_model->checkSpaceById($idspace);


      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/project_workspace', $data);
      $this->load->view('template/footer', $data);
    }

    public function deleteProjectAll($id,$id_team,$id_space)
    {
      $this->Project_model->hapus_project($id,$id_team);
      $this->session->set_flashdata('flashPj', 'Dihapus');
      redirect('project/projectAll/'.$id_space);
    }

    public function getData()
    {
      $result = $this->Project_model->getDataTable();
      $data   = [];
      $no     = $_POST['start'];

      foreach ($result as $result) {
        $row    = array();
        $row[]  = ++$no;
        $id_tm  = $result->id_team;
        $acc_team = $this->Team_model->getTeamProjectAll($id_tm);
        $role_id = $this->session->userdata('role_id');
        // $row[] = $acc_team;
        $row[]  = $result->id_project;
        $row[]  = '<td scope="row">
                    <div class="media align-items-center">
                      <div class="media-body">
                        <span class="name mb-0 text-sm">' . $result->nama_project . '</span>
                    </div>
                  </div>
                  </td>';
        $row[]  = $result->nama_departement;
        if ($result->priority_project == 3) {
          $row[]  = '<span class="badge badge-pill badge-danger">High</span>';
        } else if ($result->priority_project == 2) {
          $row[]  = '<span class="badge badge-pill badge-warning">Medium</span>';
        } else {
          $row[]  = '<span class="badge badge-pill badge-success">Low</span>';
        }
        foreach ($acc_team as $am) {
          $row2 = '
          <a href="#" class="avatar-groupnew avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="' . $am->nama . '">
                    <img alt="Image placeholder" src="' . base_url('assets/img/profile/') . $am->foto . '">
                    </a>';
        }
       
        $row[]   = $row2;

        $row[]  = date('j F Y', strtotime($result->tanggal_awal_project));
        $row[]  = date('j F Y', strtotime($result->tanggal_akhir_project));

        if ($result->value_project >= 0 && $result->value_project < 30) {
          $row[]  = '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        } else if ($result->value_project >= 30 && $result->value_project < 65) {
          $row[]  =
            '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        } else if ($result->value_project >= 65 && $result->value_project <= 100) {
          $row[]  =
            '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        }

        if ($result->work_status == 1) {
          $row[]  = ' <span class="badge badge-dot mr-4">
                              <i class="bg-success"></i>
                              <span class="status">complete</span>
                            </span>';
        } else if ($result->work_status == 2) {
          $row[]  = '<span class="badge badge-dot mr-4">
                              <i class="bg-danger"></i>
                              <span class="status">pending</span>
                            </span>';
        } else {
          $row[]  = '<span class="badge badge-dot mr-4">
                              <i class="bg-info"></i>
                              <span class="status">on progress</span>
                            </span>';
        }
        if( $role_id == 1) {
        $row[] = '
        <a href="' . base_url('project/showOkr/') . $result->id_project . '" class="btn btn-default btn-sm rounded-pill font-btn"> 
        <span class="btn--inner-icon">
          <i class="ni ni-chart-bar-32"></i></span>
        <span class="btn-inner--text">Masuk OKR</span>
      </a>
        <a href="' . base_url('project/editProjectAll/') . $result->id_project . '" class="btn btn-warning btn-sm rounded-pill">
                            <span class="btn--inner-icon">
                              <i class="ni ni-settings"></i></span>
                            <span class="btn-inner--text"></span>
                          </a>
                          <a data-target="' . base_url('project/deleteProjectAll/') . $result->id_project .'/'.$result->id_team. '" class="btn btn-danger btn-sm tombol-hapus rounded-pill text-white">
                            <span class="btn--inner-icon">
                              <i class="fas fa-trash"></i></span>
                            <span class="btn-inner--text"></span>
                          </a>';

        } else {
          $row[] = '
          <a href="' . base_url('project/showOkr/') . $result->id_project . '" class="btn btn-default btn-sm rounded-pill font-bt"">
          <span class="btn--inner-icon">
            <i class="ni ni-chart-bar-32"></i></span>
          <span class="btn-inner--text">Masuk OKR</span>
        </a>
          <a href="' . base_url('project/editProjectAll/') . $result->id_project . '" class="btn btn-warning btn-sm rounded-pill">
                              <span class="btn--inner-icon">
                                <i class="ni ni-settings"></i></span>
                              <span class="btn-inner--text"></span>
                            </a>';
        }
        $data[] = $row;
      }

      $output   = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->Project_model->count_all_data(),
        "recordsFiltered" => $this->Project_model->count_filtered_data(),
        "data"            => $data,
      );

      // print_r($output);
      // exit();
      $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function getDataInWorkSpace()
    {
      $result = $this->Project_model->getDataTableWorkspace();
      $id_space = $this->input->post('idspace');
      $data   = [];
      $no     = $_POST['start'];

      foreach ($result as $result) {
        $row    = array();
        $row[]  = ++$no;
        $id_tm  = $result->id_team;
        $acc_team = $this->Team_model->getTeamProjectAll($id_tm);
        $role_id = $this->session->userdata('role_id');
        // $row[] = $acc_team;
        $row[]  = $result->id_project;
        $row[]  = '<td scope="row">
                    <div class="media align-items-center">
                      <div class="media-body">
                        <span class="name mb-0 text-sm">' . $result->nama_project . '</span>
                    </div>
                  </div>
                  </td>';
        // $row[]  = $result->nama_departement;
        if ($result->priority_project == 3) {
          $row[]  = '<span class="badge badge-pill badge-danger">High</span>';
        } else if ($result->priority_project == 2) {
          $row[]  = '<span class="badge badge-pill badge-warning">Medium</span>';
        } else {
          $row[]  = '<span class="badge badge-pill badge-success">Low</span>';
        }
        foreach ($acc_team as $am) {
          $row2 = '
          <a href="#" class="avatar-groupnew avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="' . $am->nama . '">
                    <img alt="Image placeholder" src="' . base_url('assets/img/profile/') . $am->foto . '">
                    </a>';
        }
       
        $row[]   = $row2;

        $row[]  = date('j F Y', strtotime($result->tanggal_awal_project));
        $row[]  = date('j F Y', strtotime($result->tanggal_akhir_project));

        if ($result->value_project >= 0 && $result->value_project < 30) {
          $row[]  = '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        } else if ($result->value_project >= 30 && $result->value_project < 65) {
          $row[]  =
            '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        } else if ($result->value_project >= 65 && $result->value_project <= 100) {
          $row[]  =
            '<div class="d-flex align-items-center">
            <span class="completion mr-2">' . $result->value_project . '%</span>
            <div>
              <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: ' . $result->value_project . '%;"></div>
              </div>
            </div>
          </div>';
        }

        if ($result->work_status == 1) {
          $row[]  = ' <span class="badge badge-dot mr-4">
                              <i class="bg-success"></i>
                              <span class="status">complete</span>
                            </span>';
        } else if ($result->work_status == 2) {
          $row[]  = '<span class="badge badge-dot mr-4">
                              <i class="bg-danger"></i>
                              <span class="status">pending</span>
                            </span>';
        } else {
          $row[]  = '<span class="badge badge-dot mr-4">
                              <i class="bg-info"></i>
                              <span class="status">on progress</span>
                            </span>';
        }
        if( $role_id == 1) {
        $row[] = '
        <a href="' . base_url('project/showOkr/') . $result->id_project . '" class="btn btn-default btn-sm rounded-pill font-btn"> 
        <span class="btn--inner-icon">
          <i class="ni ni-chart-bar-32"></i></span>
        <span class="btn-inner--text">Masuk OKR</span>
      </a>
        <a href="' . base_url('project/editProjectAll/') . $result->id_project . '" class="btn btn-warning btn-sm rounded-pill" onclick="saveCurrentUrl('. base_url() .'project/projectAll/'. $id_space .');">
                            <span class="btn--inner-icon">
                              <i class="ni ni-settings"></i></span>
                            <span class="btn-inner--text"></span>
                          </a>
                          <a data-target="' . base_url('project/deleteProjectAll/') . $result->id_project .'/'.$result->id_team. '/' . $id_space .'" class="btn btn-danger btn-sm tombol-hapus rounded-pill text-white" >
                            <span class="btn--inner-icon">
                              <i class="fas fa-trash"></i></span>
                            <span class="btn-inner--text"></span>
                          </a>';

        } else {
          $row[] = '
          <a href="' . base_url('project/showOkr/') . $result->id_project . '" class="btn btn-default btn-sm rounded-pill font-bt"">
          <span class="btn--inner-icon">
            <i class="ni ni-chart-bar-32"></i></span>
          <span class="btn-inner--text">Masuk OKR</span>
        </a>
          <a href="' . base_url('project/editProjectAll/') . $result->id_project . '" class="btn btn-warning btn-sm rounded-pill">
                              <span class="btn--inner-icon">
                                <i class="ni ni-settings"></i></span>
                              <span class="btn-inner--text"></span>
                            </a>';
        }
        $data[] = $row;
      }

      $output   = array(
        "draw"            => $_POST['draw'],
        "recordsTotal"    => $this->Project_model->count_all_data_workspace(),
        "recordsFiltered" => $this->Project_model->count_filtered_data_workspace(),
        "data"            => $data,
      );

      // print_r($output);
      // exit();
      $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function inputProject($idspace)
    {
      $userdata               = $this->session->userdata('username');
      $userid                 = $this->session->userdata('id');
      $nama_project           = $this->input->post('nama_project');
    //  $id_departement         = $this->input->post('id_departement');
      $priority_project       = $this->input->post('priority');
      $tanggal_awal_project   = $this->input->post('tanggal_awal_project');
      $tanggal_akhir_project  = $this->input->post('tanggal_akhir_project');
      $description_project    = $this->input->post('description_project');
      $file                   = $_FILES['file'];
     // $work_status            = $this->input->post('work_status');
      $value_project          = 0;

      $date_created           = date('Y-m-d');

      $bulan = date('Y-m', strtotime($date_created));
      
      $generateIDProject = $this->generateID($bulan);


      if ($file == '') {
        $file_project = "";
      } else {
        $config['upload_path']          = './assets/file';
        $config['allowed_types']        = 'jpg|pdf';
        $config['max_size']             = 5000;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
          $error = array('error' => $this->upload->display_errors());
          $file_project ='';
      } else {
          $file_project = $this->upload->data('file_name');
      }
      }
      $tim = array(
        'nama_team' => $nama_project,
        'created_at'    => $date_created
      );

    if( $priority_project = '' ) {
      $priority_project = 1;
    } else {
      $priority_project = $priority_project;
    }
  
      $id_team = $this->Team_model->input_team($tim, 'team');

      $data = array(
        'id_project'            => $generateIDProject,
        'nama_project'          => $nama_project,
        'id_departement'        => "-",
        'priority_project'      => $priority_project,
        'id_team'               => $id_team,
        'tanggal_awal_project'  => $tanggal_awal_project,
        'tanggal_akhir_project' => $tanggal_akhir_project,
        'description_project'   => $description_project,
        'file'                  => $file_project,
        'work_status'           => '1',
        'value_project'         => $value_project,
        'created_by'            => $userdata,
        'date_created'          => $date_created,
      );

      $kuad = array(
        'id'                    => $generateIDProject,
        'jenis_tabel'     => 'Project',
        'id_priority'      => $priority_project,
        'id_user'           => $userid,
        'created_at'     => $date_created
      );

      $acc_team = array(
        'id_team' => $id_team,
        'id_user'  => $userid,
        'role_user' => '2'
      );

      $this->Team_model->input_teamacc($acc_team, 'access_team');
      $this->Project_model->input_project($data, 'project');

      $saveproject = array(
        'id_space'       => $idspace,
        'id_project'     => $generateIDProject,
        'created_date'   => date("Y-m-d H:i:s")
      );

      $this->Space_model->input_space($saveproject, 'space_okr');


      $this->Project_model->inputKuadran($kuad);
      $this->session->set_flashdata('flashPj', 'Ditambahkan');
      redirect('project/projectAtWorkspace/'.$idspace);
    }

    public function generateID($bulan)
    {


      // $created_date = date('Y-m-d H:i:s',strtotime('+5 hours'));
      $bulan = date('Y-m', strtotime($bulan));
      $ket = array('date_created' => $bulan);

  

      $this->db->select('SUBSTRING(`project`.`id_project`,7, 3) as id', FALSE);
      $this->db->like($ket);
      $this->db->order_by('id_project', 'DESC');
      $this->db->limit(1);

      $query = $this->db->get('project');  //cek dulu apakah ada sudah ada kode di tabel.   

      if ($query->num_rows() <> 0) {
        //cek kode jika telah tersedia    
        $data = $query->row();
        $kode = intval($data->id) + 1;
      } else if ($query->num_rows() == 0) {
        $kode = 1;  //cek jika kode belum terdapat pada table
      }
      // $tanggal = substr($created_date, 8,2);
      $tahun = date('Y', strtotime($bulan));
      $bulan = substr($bulan, 5, 2);
      
      $batas  = str_pad($kode, 3, "0", STR_PAD_LEFT);
    

      // print_r($tanggal);
      // echo "<br>";

      if (empty($bulan)) {
        $id = '';
      } else {
        $id = $tahun . $bulan . $batas;
      }

      // print_r($id);
      // exit();

      return($id);
      //return $id;
    }

    public function editProject($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();
      $id_project = $this->uri->segment(3);
      $userid       = $this->session->userdata('id');

      // Inisialisasi $data['id_okr'] sebagai array kosong
      // Mendapatkan data id_okr
      $data['id_okr'] = $this->Project_model->editOkrByIdPr($id_project);

      // Inisialisasi array untuk menyimpan data id_kr dan id_initiative
      $data['id_kr'] = array();
      $data['id_initiative'] = array();

      // Iterasi untuk setiap id_okr
      foreach ($data['id_okr'] as $ok) {
          // Mendapatkan data id_kr
          $id_kr = $this->Project_model->editKrByIdOkr($ok['id_okr']);
          
          // Menambahkan data id_kr ke dalam array id_kr
          $data['id_kr'] = array_merge($data['id_kr'], $id_kr);

          // Iterasi untuk setiap id_kr
          foreach ($id_kr as $kr) {
              // Mendapatkan data id_initiative
              $id_initiative = $this->Project_model->editInitByIdKr($kr['id_kr']);

              $data['id_initiative'] = array_merge($data['id_initiative'], $id_initiative);
          }
        }
      

      $this->form_validation->set_rules('id_project', 'ID Project', 'required');

      if ($this->form_validation->run() == FALSE) {
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('project/project_edit', $data);
        $this->load->view('template/footer', $data);
      } else {
        $id_project             = $this->input->post('id_project');
        $nama_project           = $this->input->post('nama_project');
        $id_departement         = $this->input->post('id_departement');
        $priority_project       = $this->input->post('priority');
        $id_team                = $this->input->post('id_team');
        $tanggal_awal_project   = $this->input->post('tanggal_awal_project');
        $tanggal_akhir_project  = $this->input->post('tanggal_akhir_project');
        $description_project    = $this->input->post('description_project');
        $file                   = $_FILES['file'];
        $work_status            = $this->input->post('work_status');
        $kuad             = $this->input->post('kuadran');

        if ($file) {
          $config['upload_path']          = './assets/file';
          $config['allowed_types']        = 'jpg|pdf';
          $config['max_size']             = 5000;

          $this->load->library('upload', $config);

          if ($this->upload->do_upload('file', $config)) {
            $new_file = $this->upload->data('file_name');
            $this->db->set('file', $new_file);
          } else {
            echo $this->upload->display_errors();
          }
        }
        
          $this->db->set('nama_project', $nama_project);
          $this->db->set('id_departement', $id_departement);
          $this->db->set('priority_project', $priority_project);
          $this->db->set('id_team', $id_team);
          $this->db->set('tanggal_awal_project', $tanggal_awal_project);
          $this->db->set('tanggal_akhir_project', $tanggal_akhir_project);
          $this->db->set('description_project', $description_project);
          $this->db->set('work_status', $work_status);
          $this->db->where('id_project', $id_project);
          $this->db->update('project');

          $this->db->where('id', $id_project);
          $checkPrj = $this->db->get('kuadran')->num_rows();

        // update ke table kuadran
        if ($checkPrj > 0) {
            $this->db->set('id_priority', $priority_project);
            $this->db->where('id', $id_project);
            $this->db->update('kuadran');
        } else {
          $input = array(
            'id'  => $id_project,
            'jenis_tabel' => 'Project',
            'id_priority'  => $priority_project,
            'id_user'       => $userid
          );

            $this->db->insert('kuadran', $input);
        }        

        foreach( $data['id_okr']  as $ok) {
          $this->db->where('id', $ok['id_okr']);
          $checkOkr = $this->db->get('kuadran')->num_rows();

          // print_r($checkOkr);exit();

          if ($checkOkr > 0) {
            foreach( $kuad as $k) {
              $this->db->set('id_priority', $priority_project);
              $this->db->where('id', $k);
              $this->db->update('kuadran');
            }
          } else {
            $input = array(
              'id'  => $ok['id_okr'],
              'jenis_tabel' => 'Objective',
              'id_priority'  => $priority_project,
              'id_user'       => $userid
            );

              $this->db->insert('kuadran', $input);
          }        
        }

        foreach( $data['id_kr']  as $kr) {
          $this->db->where('id', $kr['id_kr']);
          $checkKr = $this->db->get('kuadran')->num_rows();

          if ($checkKr > 0) {
            foreach( $kuad as $k) {
              $this->db->set('id_priority', $priority_project);
              $this->db->where('id', $k);
              $this->db->update('kuadran');
            }
          } else {
              $input = array(
                'id'  => $kr['id_kr'],
                'jenis_tabel' => 'Key Result',
                'id_priority'  => $priority_project,
                'id_user'       => $userid
              );

              $this->db->insert('kuadran', $input);
          }          
        }

        foreach( $data['id_initiative'] as $init ){
          $this->db->where('id', $init['id_initiative']);
          $checkInitiative = $this->db->get('kuadran')->num_rows();

          if ($checkInitiative > 0) {
            foreach( $kuad as $k) {
              $this->db->set('id_priority', $priority_project);
              $this->db->where('id_kuad', $k);
              $this->db->update('kuadran');
            }
          } else {
              $input = array(
                'id'  => $init['id_initiative'],
                'jenis_tabel' => 'Initiative',
                'id_priority'  => $priority_project,
                'id_user'       => $userid
              );
              $this->db->insert('kuadran', $input);
          }       
        }                                             
        
        $this->session->set_flashdata('flashPj', 'Diedit');
        redirect('project/index');
        }
      }
    
    public function editProjectAll($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();
      $id_project   = $this->uri->segment(3);
      $userid       = $this->session->userdata('id');

      //Mengambil data 
      $data['id_okr'] = $this->Project_model->editOkrByIdPr($id_project);

      // Inisialisasi array untuk menyimpan data id_kr dan id_initiative
      $data['id_kr'] = array();
      $data['id_initiative'] = array();

        // Iterasi untuk setiap id_okr
        foreach ($data['id_okr'] as $ok) {
            // Mendapatkan data id_kr
            $id_kr = $this->Project_model->editKrByIdOkr($ok['id_okr']);
            
            // Menambahkan data id_kr ke dalam array id_kr
            $data['id_kr'] = array_merge($data['id_kr'], $id_kr);

            // Iterasi untuk setiap id_kr
            foreach ($id_kr as $kr) {
                // Mendapatkan data id_initiative
                $id_initiative = $this->Project_model->editInitByIdKr($kr['id_kr']);

                $data['id_initiative'] = array_merge($data['id_initiative'], $id_initiative);
            }
          }

        $this->form_validation->set_rules('id_project', 'ID Project', 'required');

        if ($this->form_validation->run() == FALSE) {
          $this->load->view('template/header', $data);
          $this->load->view('template/sidebar', $data);
          $this->load->view('template/topbar', $data);
          $this->load->view('project/project_editall', $data);
          $this->load->view('template/footer', $data);
        } else {
          $id_project             = $this->input->post('id_project');
          $nama_project           = $this->input->post('nama_project');
          // $id_departement         = $this->input->post('id_departement');
          $priority_project       = $this->input->post('priority_project');
        //  $id_team                = $this->input->post('id_team');
          $tanggal_awal_project   = $this->input->post('tanggal_awal_project');
          $tanggal_akhir_project  = $this->input->post('tanggal_akhir_project');
          $description_project    = $this->input->post('description_project');
          $file                   = $_FILES['file'];
          $work_status            = $this->input->post('work_status');
          $kuad             = $this->input->post('kuadran');


          $id_space            = $this->input->post('id_space');

          if ($file) {
            $config['upload_path']          = './assets/file';
            $config['allowed_types']        = 'jpg|pdf';
            $config['max_size']             = 5000;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file', $config)) {
              $new_file = $this->upload->data('file_name');
              $this->db->set('file', $new_file);
            } else {
              echo $this->upload->display_errors();
            }
          }

          $this->db->set('nama_project', $nama_project);
          $this->db->set('id_departement', NULL);
          $this->db->set('priority_project', $priority_project);
         // $this->db->set('id_team', $id_team);
          $this->db->set('tanggal_awal_project', $tanggal_awal_project);
          $this->db->set('tanggal_akhir_project', $tanggal_akhir_project);
          $this->db->set('description_project', $description_project);
          $this->db->set('work_status', $work_status);
          $this->db->where('id_project', $id_project);
          $this->db->update('project');

          $this->db->where('id', $id_project);
          $checkPrj = $this->db->get('kuadran')->num_rows();

          

        // update ke table kuadran
        if ($checkPrj > 0) {
            $this->db->set('id_priority', $priority_project);
            $this->db->where('id', $id_project);
            $this->db->update('kuadran');
        } else {
          $input = array(
            'id'  => $id_project,
            'jenis_tabel' => 'Project',
            'id_priority'  => $priority_project,
            'id_user'       => $userid
          );

            $this->db->insert('kuadran', $input);
        }         

        //print_r($ok['id_okr']);exit();

        // foreach( $data['id_okr']  as $ok) {
        //   $this->db->where('id', $ok['id_okr']);
        //   $checkOkr = $this->db->get('kuadran')->num_rows();

          

        //   if ($checkOkr > 0) {
        //     foreach($kuad as $k) {
        //       $this->db->set('id_priority', $priority_project);
        //       $this->db->where('id', $k);
        //       $this->db->update('kuadran');
        //     }
        //   } else {
        //     $input = array(
        //       'id'  => $ok['id_okr'],
        //       'jenis_tabel' => 'Objective',
        //       'id_priority'  => $priority_project,
        //       'id_user'       => $userid
        //     );

        //       $this->db->insert('kuadran', $input);
        //   }        
        // }

        // print_r($data['id_kr']);

        foreach( $data['id_kr']  as $kr) {
          $this->db->where('id', $kr['id_kr']);
          $checkKr = $this->db->get('kuadran')->num_rows();

          // if ($checkKr > 0) {
          //   foreach( $kuad as $k) {
          //     $this->db->set('id_priority', $priority_project);
          //     $this->db->where('id', $k);
          //     $this->db->update('kuadran');
          //   }
          // } else {
          //     $input = array(
          //       'id'  => $kr['id_kr'],
          //       'jenis_tabel' => 'Key Result',
          //       'id_priority'  => $priority_project,
          //       'id_user'       => $userid
          //     );

          //     $this->db->insert('kuadran', $input);
          // }          
        }

        foreach( $data['id_initiative'] as $init ){
          $this->db->where('id', $init['id_initiative']);
          $checkInitiative = $this->db->get('kuadran')->num_rows();

          // if ($checkInitiative > 0) {
          //   foreach( $kuad as $k) {
          //     $this->db->set('id_priority', $priority_project);
          //     $this->db->where('id_kuad', $k);
          //     $this->db->update('kuadran');
          //   }
          // } else {
          //     $input = array(
          //       'id'  => $init['id_initiative'],
          //       'jenis_tabel' => 'Initiative',
          //       'id_priority'  => $priority_project,
          //       'id_user'       => $userid
          //     );
          //     $this->db->insert('kuadran', $input);
          // }       
        }                                             
      $this->session->set_flashdata('flashPj', 'Diedit');
      redirect('project/projectAll/' . $id_space);
    }
   }

    public function deleteProject($id,$id_team)
    {
      $this->Project_model->hapus_project($id,$id_team  );
      $this->session->set_flashdata('flashPj', 'Dihapus');
      redirect('project/index');
    }


    public function detailProject($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();
      $data['object']       = $this->Project_model->getAllObject();


      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/project_detail', $data);
      $this->load->view('template/footer', $data);
    }

    public function showOkr($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);


      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $iduser     = $this->session->userdata('id');
      $workspace_sesi     = $this->session->userdata('workspace_sesi');

      $delegasi   = $this->Project_model->cekDelegasi($iduser);

      $data['users']         = $this->Account_model->getAllUserActive();

      $delegasi   = $this->Project_model->cekDelegasi($iduser);
      
      if(!empty($delegasi)) {
        $object     = $this->Project_model->getAllObjectDelegasi($iduser);
        $data['statusproject'] = "Project Partner";
      } else {
        $object     = $this->Project_model->getAllObject();
        $data['statusproject'] = "-";
      }

      $data['chat']  = $this->Project_model->cekChat($id,$workspace_sesi);


      $data['object'] = $object;

      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('template/navbarproject', $data);
      $this->load->view('project/project_okr', $data);
      $this->load->view('template/footer', $data);
    }

    public function inputOkr()
    {
      $userdata       = $this->session->userdata('username');
      $userid         = $this->session->userdata('id');
      $priority_okr   = $this->input->post('priority');
      $nama_okr       = $this->input->post('description_okr');
      $start_datekr   = $this->input->post('start_dateokr');
      $due_date       = $this->input->post('due_date');
      $id_project     = $this->input->post('id_project');
      $id_team        = $this->input->post('id_team');
      $statusproject  = $this->input->post('statusproject');
      $value_okr      = 0;

 
      if(empty($priority_okr)) {
        $priority_okr = "0";
      } else {
        $priority_okr = $this->input->post('priority');
      }

      $data = array(
        'id_project'          => $id_project,
        'id_team'             => $id_team,
        'description_okr'     => $nama_okr,
        'value_okr'           => $value_okr,
        'start_dateokr'       => $start_datekr,
        'due_date'            => $due_date,
        'created_by'          => $userdata
      );

      $id_okr = $this->Project_model->input_okr($data, 'okr');

      $kuad =  array(
        'id'            => $id_okr,
        'jenis_tabel'   => 'Objective',
        'id_priority'   =>  $priority_okr,
        'id_user'       =>  $userid,
      );

      if($statusproject == "Project Partner"){
        $delegatesave = array(
          'id_user_delegate'    => $userid,
          'id_project'          => $id_project,
          'id_okr'              => $id_okr,
          'id_kr'               => "-",
          'id_inisiative'       => "-",
          'keterangan_delegate' => 'objective',
        );

        $this->Project_model->input_delegate($delegatesave, 'delegate_save');
      } 


      
      $this->Project_model->inputKuadran($kuad);

      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);
      
      $sum_value = 0;
      
      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }
      
      $total_precen = 100 * $total_count;
      
      $value_project = round(($sum_value / $total_precen) * 100,2);
      
      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');
      
      $brdprj  = $this->Project_model->checkBrdPrj($id_project);

      if($brdprj != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');

          $deleg_count  = $this->Project_model->countOkr($brdprj['id_project_from']);

          $this->db->set('value_okr', $value_project);
          $this->db->where('id_okr', $brdprj['id_okr']);
          $this->db->update('okr');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $this->db->set('value_project', $value_deleg);
          $this->db->where('id_project', $brdprj['id_project_from']);
          $this->db->update('project');
        }

      $brdokr  = $this->Project_model->checkBrdOkr($id_project);
      if($brdokr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_okr');

          $kr = $this->Project_model->getKeyByIdKr($brdokr['id_kr']);

          $deleg_count  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_project);
          $this->db->where('id_kr', $brdokr['id_kr']);
          $this->db->update('key_result');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $brdkr  = $this->Project_model->checkBrdKr($id_project);
      if($brdkr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_kr');

          $deleg_count  = $this->Project_model->countKr($brdkr['id_kr']);

          $this->db->set('value_percent', $value_project);
          $this->db->where('id_initiative', $brdkr['id_initiative']);
          $this->db->update('initiative');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $kr = $this->Project_model->getKeyByIdKr($brdkr['id_kr']);

          $countkr  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_deleg);
          $this->db->where('id_kr', $brdkr['id_kr']);
          $this->db->update('key_result');

          $total_kr = 100 * $countkr;

          $value_okr = round(($value_project / $total_kr) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $this->session->set_flashdata('flashOkr', 'Ditambahkan');
      redirect('project/showOkr/' . $id_project);
    }



    public function editOkr($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      // $data['project']      = $this->Project_model->getProjectById($id);
      $data['okr']          = $this->Project_model->getOkrById($id);
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();
      $id_okr = $this->uri->segment(3);
      $userid       = $this->session->userdata('id');

      $data['id_kr'] = $this->Project_model->editKrByIdOkr($id_okr);

      $data['id_initiative'] = array();

      foreach ($data['id_kr'] as $kr) {
        // Mendapatkan data id_initiative
        $id_initiative = $this->Project_model->editInitByIdKr($kr['id_kr']);
        $data['id_initiative'] = array_merge($data['id_initiative'], $id_initiative);
      }
      

      $this->form_validation->set_rules('id_project', 'ID Project', 'required');

      if ($this->form_validation->run() == FALSE) {
        $this->load->view('template/header', $data);
        // $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('project/project_editokr', $data);
        $this->load->view('template/footer', $data);
      } else {
        $id_okr                 = $this->input->post('id_okr');
        $id_project             = $this->input->post('id_project');
        $priority_okr       = $this->input->post('priority');
        $description_okr        = $this->input->post('description_okr');
        $due_date               = $this->input->post('due_date');
        $kuad             = $this->input->post('kuadran');

        $this->db->set('description_okr', $description_okr);
        $this->db->set('due_date', $due_date);
        $this->db->where('id_okr', $id_okr);
        $this->db->update('okr');

          $this->db->where('id', $id_okr);
          $checkOkr = $this->db->get('kuadran')->num_rows();

          // print_r($checkOkr);exit();

          if ($checkOkr > 0) {
              $this->db->set('id_priority', $priority_okr);
              $this->db->where('id', $id_okr);
              $this->db->update('kuadran');
          } else {
            $input = array(
              'id'  => $id_okr,
              'jenis_tabel' => 'Objective',
              'id_priority'  => $priority_okr,
              'id_user'       => $userid
            );

              $this->db->insert('kuadran', $input);
          }        
        

        foreach( $data['id_kr']  as $kr) {
          $this->db->where('id', $kr['id_kr']);
          $checkKr = $this->db->get('kuadran')->num_rows();

          if ($checkKr > 0) {
            foreach( $kuad as $k) {
              $this->db->set('id_priority', $priority_okr);
              $this->db->where('id', $k);
              $this->db->update('kuadran');
            }
          } else {
              $input = array(
                'id'  => $kr['id_kr'],
                'jenis_tabel' => 'Key Result',
                'id_priority'  => $priority_okr,
                'id_user'       => $userid
              );

              $this->db->insert('kuadran', $input);
          }          
        }

        foreach( $data['id_initiative'] as $init ){
          $this->db->where('id', $init['id_initiative']);
          $checkInitiative = $this->db->get('kuadran')->num_rows();

          if ($checkInitiative > 0) {
            foreach( $kuad as $k) {
              $this->db->set('id_priority', $priority_okr);
              $this->db->where('id', $k);
              $this->db->update('kuadran');
            }
          } else {
              $input = array(
                'id'  => $init['id_initiative'],
                'jenis_tabel' => 'Initiative',
                'id_priority'  => $priority_okr,
                'id_user'       => $userid
              );
              $this->db->insert('kuadran', $input);
          }       
        }                                             

        // echo json_encode(['success' => true]);
        $this->session->set_flashdata('flashPj', 'Diedit');
        redirect('project/index');
        }
      }
    public function deleteOkr()
    {
      $id_project  = $this->uri->segment(3);
      $id  = $this->uri->segment(4);

      $this->Project_model->hapus_okr($id);

      // print_r($id_project);
      // exit();
      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      $brd  = $this->Project_model->checkBrdPrj($id_project);
      if($brd != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');

          $deleg_count  = $this->Project_model->countOkr($brd['id_project_from']);

          $this->db->set('value_okr', $value_project);
          $this->db->where('id_okr', $brd['id_okr']);
          $this->db->update('okr');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $this->db->set('value_project', $value_deleg);
          $this->db->where('id_project', $brd['id_project_from']);
          $this->db->update('project');
        }

      $this->session->set_flashdata('flashPj', 'Dihapus');
      redirect('project/showOkr/' . $id_project);
    }

    function addRollover($givenDate, $addtime) {
      $datetime = new DateTime($givenDate);
      $datetime->modify($addtime);
      
      if (in_array($datetime->format('l'), array('Sunday','Saturday')) || 
          17 < $datetime->format('G') || 
          (17 === $datetime->format('G') && 30 < $datetime->format('G'))
      ) {
          $endofday = clone $datetime;
          $endofday->setTime(17,30);
          $interval = $endofday->diff($datetime);
      
          $datetime->add(new DateInterval('P1D'));
          if (in_array($datetime->format('l'), array('Saturday', 'Sunday'))) {
              $datetime->modify('next Monday');
          }
          $datetime->setTime(8,30);
          $datetime->add($interval);
      }
      
        return $datetime;
      }

      public function showKuadran() 
      {
        $data['title']          = 'Data  OKR';
        $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['project']        = $this->Project_model->getProjectJoinUser();
        $data['team']           = $this->Team_model->getALLTeam();
        $data['users']          = $this->Account_model->getJoinUsers();
        $data['departement']    = $this->Departement_model->getAllDepartement();

        $data['your_project']        = $this->Project_model->getYourProject();
        $data['recent_project']      = $this->Project_model->getRecentProject();
        $data['all_project']         = $this->Project_model->countAllProject();
        $data['complete_project']    = $this->Project_model->countCompleteProject();

        $data['high']             = $this->Project_model->getKuadHigh();
        $data['medium']             = $this->Project_model->getKuadMed();
        $data['low']             = $this->Project_model->getKuadLow();
        $data['lowest']             = $this->Project_model->getKuadLowest();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('project/kuadran', $data);
        $this->load->view('template/footer', $data);
      }

    public function showKey($id_project, $id)
    {
      $data['title']        = 'Data Key Result | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['key_result']   = $this->Project_model->getKeyById($id_project, $id);
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();
      $data['object']       = $this->Project_model->getAllObject();
     
      $data['users']        = $this->Account_model->getALLUsers();
      $data['timuser']      = $this->Team_model->getTeamAcc();
      $data['project']      = $this->Project_model->getProjectById($id_project);
      $data['user']         = $this->Account_model->getAllUserActive();

      $getidtim   = $this->Team_model->getProjectTim($id_project);

      $iduser     = $this->session->userdata('id');

      $delegasi   = $this->Project_model->cekDelegasi($iduser);
      
      if(!empty($delegasi)) {
        $data['all_key']   = $this->Project_model->getAllKeyResultDelegasi($iduser);
        $data['statusproject'] = "Project Partner";
      } else {
        $data['all_key']      = $this->Project_model->getAllKeyResult();
        $data['statusproject'] = "-";
      }  

      $future = $this->addRollover('2023-06-26 11:41:00', '+63 hours');
      $data['datetime']  =  $future->format('Y-m-d H:i:s');

      $this->load->view('template/header', $data);
     // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/project_inputkeycopy', $data);
      $this->load->view('template/footer', $data);
    }

  

    public function inputKey()
    {
      $userdata          = $this->session->userdata('username');
      $userid            = $this->session->userdata('id');
      // $id_kr             = $this->input->post('id_kr');
      $id_okr            = $this->input->post('id_okr');
      $priority_kr       = $this->input->post('priority');
      $nama_kr           = $this->input->post('nama_kr');
      $value_kr          = $this->input->post('value_kr');
      $precentage        = 0;
      $id_project        = $this->input->post('id_pj');
      $due_datekey       = $this->input->post('due_datekey');
      $start_datekey     = $this->input->post('start_datekey');

   
      $valuekrNm = str_replace('.', '', $value_kr);

      if($priority_kr == '') {
        $priority_kr = '3';
      } else {
        $priority_kr = $priority_kr;
      }

      
      $valuekrNm = round($valuekrNm,0,PHP_ROUND_HALF_DOWN);

      $data = array(
        'id_okr'            => $id_okr,
        'nama_kr'           => $nama_kr,
        'value_kr'          => $valuekrNm,
        'precentage'        => $precentage,
        'start_datekey'     => $start_datekey,
        'due_datekey'       => $due_datekey,
        'created_by'        => $userdata
      );

      $id_kr   =   $this->Project_model->input_key_result($data, 'key_result');

      $kuad =  array(
        'id'          => $id_kr,
        'jenis_tabel'  => 'Key Result',
        'id_priority'  =>  $priority_kr,
        'id_user'       =>  $userid,
      );

      
      $this->Project_model->inputKuadran($kuad);

      $total_kr = $this->Project_model->count_key_result($id_okr);

      $precen     = $this->Project_model->getPrecentage($id_okr);

      $sum_precentage = 0;
      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }



      $total_precentage = 100 * $total_kr;


      $value_okr = round(($sum_precentage / $total_precentage) * 100, 2);

      $this->db->set('value_okr', $value_okr);
      $this->db->set('total_kr', $total_kr);
      $this->db->where('id_okr', $id_okr);
      $this->db->update('okr');

      $this->valueProject($id_project, $id_okr);
    }

    public function inputUpdateKey($id_project, $id_okr)
    {
      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);
      $check_brd  = $this->Project_model->checkBrdPrj($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      if($check_brd != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');
      }

      $this->session->set_flashdata('flashKey', 'Ditambahkan');
      redirect('project/showKey/' . $id_project . '/' . $id_okr);
    }

    public function inputValue()
    {
      $userdata           = $this->session->userdata('username');
      $id_okr             = $this->input->post('id_okr');
      $id_kr              = $this->input->post('id_kr');
      $value_kr           = $this->input->post('value_kr');
      $value_achievment   = $this->input->post('value_achievment');
      $description_kr     = $this->input->post('commentkr');
      $id_project         = $this->input->post('id_pjkr');
      $cekstatus          = $this->input->post('cekstatus');

      //print_r($description_kr);exit();

      $valueachievmentNm = str_replace('.', '', $value_achievment);

      $valueinitiativeNm = round($valueachievmentNm,0,PHP_ROUND_HALF_DOWN);

      $get_kr             = $this->Project_model->getTotalKr($id_okr);

      foreach ($get_kr as $tk) {
        $total_kr = $tk['total_kr'];
      }
      
      if(is_numeric($valueachievmentNm)){
        $precentage         = round(($valueachievmentNm / $value_kr) * 100 , 2);
      }

      if($cekstatus == 1) {
        $this->db->set('description_kr', $description_kr);
        $this->db->set('updated_by', $userdata);
        $this->db->where('id_kr', $id_kr);
        $this->db->update('key_result');
  
        redirect('project/showKey/' . $id_project . '/' . $id_okr);
      } else {
        $this->db->set('description_kr', $description_kr);
        $this->db->set('value_achievment', $valueachievmentNm);
        $this->db->set('precentage', $precentage);
        $this->db->set('updated_by', $userdata);
        $this->db->where('id_kr', $id_kr);
        $this->db->update('key_result');
  
        $this->valueOkr($total_kr, $id_okr, $id_project);
      }
     
    }

    public function valueOkr($total_kr, $id_okr, $id_project)
    {
      $cekokr = $this->Project_model->cekValueOkr($id_okr);

      if(!empty($cekokr['status_from'])) {

        $valuefrom  = $cekokr['value_from'];

        $idini      = $cekokr['idbridge_from'];

        $precen     = $this->Project_model->getPrecentage($id_okr);

        $sum_ach = 0;

        foreach ($precen as $pc) {
          $sum_ach =  $sum_ach + $pc['value_achievment'];
        }

        $precentage = round(($sum_ach / $valuefrom) * 100,2);

        $this->db->set('value_okr', $precentage);
        $this->db->where('id_okr', $id_okr);
        $this->db->update('okr');

        $this->db->set('value_okr', $precentage);
        $this->db->where('id_okr', $id_okr);
        $this->db->update('inisiative');

        $this->valueProject($id_project, $id_okr);  
        
      } else {

      $precen     = $this->Project_model->getPrecentage($id_okr);

      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;


      $value_okr = round(($sum_precentage / $total_precentage) * 100, 2);

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $id_okr);
      $this->db->update('okr');

      $this->valueProject($id_project, $id_okr);

      }

      
    }

    public function valueProject($id_project, $id_okr)
    {
      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      $brdprj  = $this->Project_model->checkBrdPrj($id_project);
      if($brdprj != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');

          $deleg_count  = $this->Project_model->countOkr($brdprj['id_project_from']);

          $this->db->set('value_okr', $value_project);
          $this->db->where('id_okr', $brdprj['id_okr']);
          $this->db->update('okr');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $this->db->set('value_project', $value_deleg);
          $this->db->where('id_project', $brdprj['id_project_from']);
          $this->db->update('project');
        }

        $brdokr  = $this->Project_model->checkBrdOkr($id_project);
      if($brdokr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_okr');

          $kr = $this->Project_model->getKeyByIdKr($brdokr['id_kr']);

          $deleg_count  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_project);
          $this->db->where('id_kr', $brdokr['id_kr']);
          $this->db->update('key_result');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $brdkr  = $this->Project_model->checkBrdKr($id_project);
      if($brdkr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_kr');

          $deleg_count  = $this->Project_model->countKr($brdkr['id_kr']);

          $this->db->set('value_percent', $value_project);
          $this->db->where('id_initiative', $brdkr['id_initiative']);
          $this->db->update('initiative');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $kr = $this->Project_model->getKeyByIdKr($brdkr['id_kr']);

          $countkr  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_deleg);
          $this->db->where('id_kr', $brdkr['id_kr']);
          $this->db->update('key_result');

          $total_kr = 100 * $countkr;

          $value_okr = round(($value_project / $total_kr) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $this->session->set_flashdata('flashKey', 'Ditambahkan');



      redirect('project/showKey/' . $id_project . '/' . $id_okr);
    }

    public function deleteKey()
    {
      $id_project  = $this->uri->segment(3);
      $id_okr      = $this->uri->segment(4);
      $id          = $this->uri->segment(5);

      //UPDATE KEY RESULT

      $this->Project_model->hapus_key_result($id);
      $this->Project_model->hapus_initiative_kr($id);

      $total_kr = $this->Project_model->count_key_result($id_okr);

      $this->db->set('total_kr', $total_kr);
      $this->db->where('id_okr', $id_okr);
      $this->db->update('okr');

      //UPDATE TABEL OKR

      $precen     = $this->Project_model->getPrecentage($id_okr);

      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;

      // $total_precentage = sum($precen);
      if ($sum_precentage == 0 && $total_kr == 0) {
        $value_okr = 0;
      } else {
        $value_okr = round(($sum_precentage / $total_precentage) * 100, 2) ;
      }


      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $id_okr);
      $this->db->update('okr');


      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);
      $check_brd  = $this->Project_model->checkBrdPrj($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      if($check_brd != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');
      }

      $this->session->set_flashdata('flashKey', 'Dihapus');
      redirect('project/showKey/' . $id_project . '/' . $id_okr);
    }

    public function editKey($id_pjkr, $id_okr)
    {
      $id_kr               = $this->input->post('id_kr');
      $id_initiative   = $this->input->post('id_initiative');
      $id_pjkr           = $this->input->post('id_project');
      $priority_kr     = $this->input->post('priority');
      $nama_kr        = $this->input->post('nama_kr');
      $value_kr         = $this->input->post('value_kr');
      $due_datekey = $this->input->post('due_datekey');
      $userid             = $this->session->userdata('id');
      $kuad             = $this->input->post('kuadran');

      $valuekrNm = str_replace('.', '', $value_kr);

      
      $valuekrNm = round($valuekrNm,0,PHP_ROUND_HALF_DOWN);

        $this->db->set('nama_kr', $nama_kr);
        $this->db->set('value_kr', $valuekrNm);
        $this->db->set('due_datekey', $due_datekey);
        $this->db->where('id_kr', $id_kr);
        $this->db->update('key_result');

        $this->db->where('id', $id_kr);
        $checkKr = $this->db->get('kuadran')->num_rows();

        if ($checkKr > 0) {
            $this->db->set('id_priority', $priority_kr);
            $this->db->where('id', $id_kr);
            $this->db->update('kuadran');
        } else {
            $input = array(
              'id'  => $kr['id_kr'],
              'jenis_tabel' => 'Key Result',
              'id_priority'  => $priority_kr,
              'id_user'       => $userid
            );

            $this->db->insert('kuadran', $input);
        }          
      

      foreach( $id_initiative as $init ){
        $this->db->where('id', $init);
        $checkInitiative = $this->db->get('kuadran')->num_rows();

        if ($checkInitiative > 0) {
          foreach( $kuad as $k) {
            $this->db->set('id_priority', $priority_kr);
            $this->db->where('id', $k);
            $this->db->update('kuadran');
          }
        } else {
            $input = array(
              'id'  => $init,
              'jenis_tabel' => 'Initiative',
              'id_priority'  => $priority_kr,
              'id_user'       => $userid
            );
            $this->db->insert('kuadran', $input);
        }       
      }          
      // echo json_encode(['success' => true]);
      $this->session->set_flashdata('flashKey', 'Diedit');
      redirect('project/showKey/' . $id_pjkr . '/' . $id_okr);
      }
    
    public function inputInisiative($id_pjkr, $id_okr)
    {
      $id_project         = $this->uri->segment(3);
      $userdata           = $this->session->userdata('username');
      $userid             = $this->session->userdata('id');
      $id_kr              = $this->input->post('id_kr');
      $id_pjkr            = $this->input->post('id_project');
      $value_initiative   = $this->input->post('value_initiative[]');
      // $start_date         = $this->input->post('start_date[]');
      // $due_date           = $this->input->post('due_date[]');
      $description        = $this->input->post('description[]');
    //  $priority_init      = $this->input->post('priority[]');

  
      $total_initiative_awal = $this->Project_model->count_initiative($id_kr);

      $total = count($value_initiative);

      if($total_initiative_awal == 0) {
        $this->db->set('value_kr', '0');
        $this->db->set('value_achievment', '0');
        $this->db->where('id_kr', $id_kr);
        $this->db->update('key_result');
      }

      for($i=0; $i<$total; $i++){
        if(empty($value_initiative[$i]) || empty($description[$i]) ){
          continue;
        } else {
          $valueformat = str_replace('.', '', $value_initiative[$i]);

          $valueformat = round($valueformat,0,PHP_ROUND_HALF_DOWN);

          //$valueformat = str_replace(',', '', $valueformat);
  
          $data = array(
                'id_kr'                   => $id_kr,
                'description'             => $description[$i],
                'value_initiative'        => $valueformat,
                'value_ach_initiative'    => '0',
                'value_percent'           => '0',
                // 'start_dateinit'          => $start_date[$i],
                // 'due_dateinit'          => $due_date[$i],
                'created_by'              => $userdata
              );
          $id_inisiative = $this->Project_model->input_initiative($data, 'initiative');

          // $kuad = array(
          //   'id'                    => $id_inisiative,
          //   'jenis_tabel'     => 'Inisiative',
          //   'id_priority'      => $priority_init[$i],
          //   'id_user'           => $userid,
          // );

          //$this->Project_model->inputKuadran($kuad);
        }
      }

      $value_ach = $this->Project_model->getPrecentageValueKr($id_kr);

      $value_initiative     = $this->Project_model->getPrecentageInitiative($id_kr);

      foreach ($value_ach as $pc) {
        $value_achievment_key_result =  $pc['value_achievment'];
        $value_key_result            =  $pc['value_kr'];
        $status                      =  $pc['status'];
      }

      $percent_ini = 0;

      foreach ($value_initiative as $vi) {
         $percent_ini =  $percent_ini + $vi['value_percent'];
      }

        if($total == 0) {
          $sumvalue = 0;
          $totvalue = $sumvalue * 100;
        } else {
          $sumvalue = $total + $value_key_result;
          $totvalue = $sumvalue * 100;
        }


      
      if ($value_achievment_key_result == 0 && $value_key_result == 0) {
        $precentage = 0;
      } else {
        $precentage = round(($percent_ini / $totvalue) * 100, 2);
      }


      $this->db->set('value_kr', $sumvalue);
      $this->db->set('precentage', $precentage);
      $this->db->set('status', '1');
      $this->db->where('id_kr', $id_kr);
      $this->db->update('key_result');

      $total_kr = $this->Project_model->count_key_result($id_okr);

      $precen     = $this->Project_model->getPrecentage($id_okr);
      
      $sum_precentage = 0;

      foreach ($precen as $precen) {
        $sum_precentage =  $sum_precentage + $precen['precentage'];
      }

      $total_precentage = 100 * $total_kr;

      if ($sum_precentage == 0 && $total_kr == 0) {
        $value_okr = 0;
      } else {
        $value_okr = round(($sum_precentage / $total_precentage) * 100 , 2);
      }

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $id_okr);
      $this->db->update('okr');

      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      $brdprj  = $this->Project_model->checkBrdPrj($id_project);
      if($brdprj != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');

          $deleg_count  = $this->Project_model->countOkr($brdprj['id_project_from']);

          $this->db->set('value_okr', $value_project);
          $this->db->where('id_okr', $brdprj['id_okr']);
          $this->db->update('okr');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $this->db->set('value_project', $value_deleg);
          $this->db->where('id_project', $brdprj['id_project_from']);
          $this->db->update('project');
        }

        $brdokr  = $this->Project_model->checkBrdOkr($id_project);
      if($brdokr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_okr');

          $kr = $this->Project_model->getKeyByIdKr($brdokr['id_kr']);

          $deleg_count  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_project);
          $this->db->where('id_kr', $brdokr['id_kr']);
          $this->db->update('key_result');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $brdkr  = $this->Project_model->checkBrdKr($id_project);
      if($brdkr != NULL) {
        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_kr');

          $deleg_count  = $this->Project_model->countKr($brdkr['id_kr']);

          $this->db->set('value_percent', $value_project);
          $this->db->where('id_initiative', $brdkr['id_initiative']);
          $this->db->update('initiative');

          $total_deleg = 100 * $deleg_count;

          $value_deleg = round(($value_project / $total_deleg) * 100,2);

          $kr = $this->Project_model->getKeyByIdKr($brdkr['id_kr']);

          $countkr  = $this->Project_model->countKr($kr['id_okr']);

          $this->db->set('precentage', $value_deleg);
          $this->db->where('id_kr', $brdkr['id_kr']);
          $this->db->update('key_result');

          $total_kr = 100 * $countkr;

          $value_okr = round(($value_project / $total_kr) * 100,2);          

          $this->db->set('value_okr', $value_deleg);
          $this->db->where('id_okr', $kr['id_okr']);
          $this->db->update('okr');

          $okr = $this->Project_model->getOkrById($kr['id_okr']);

          $countokr  = $this->Project_model->countOkr($okr['id_project']);

          $total_okr = 100 * $countokr;

          $value_prj = round(($value_deleg / $total_okr) * 100,2);

          $this->db->set('value_project', $value_prj);
          $this->db->where('id_project', $okr['id_project']);
          $this->db->update('project');
        }

      $this->session->set_flashdata('flashKey', 'Ditambahkan');
      redirect('project/showKey/' . $id_pjkr . '/' . $id_okr);
      
    }

    public function getUriSegment(){
      $currentURL = current_url();
      // $id          = $this->uri->segment(5);

      $params   = $_SERVER['QUERY_STRING'];

      $fullURL = $currentURL . '?' . $params; 

      return $fullURL; 
    }

    public function getDetail()
    {
      $sesrole = $this->session->userdata('role_id');
      $sesid =  $this->session->userdata('id');
      $idkr = $this->input->post('idkr');

      $datenow = $this->input->post('datenow');
      $dateover =  $this->input->post('dateover');

      $datenow = str_replace(' ', '', $datenow);
      $dateover = str_replace(' ', '', $dateover);

      //print_r($datenow);

      $data   = $this->Project_model->getInitiativeById($idkr);

      $datakr   = $this->Project_model->getKeyResultById($idkr);

     

      foreach ($datakr as $datakr) {
        $id_okr = $datakr['id_okr']; 
        $duedatekey = $datakr['due_datekey']; 
      }

      $datakr   = $this->Project_model->getOKRNewById($id_okr);

   
      $id_project = $datakr['id_project'];

      $checkteam          = $this->Project_model->checkTeam($id_project);

     

      $textOpening = "";
      $textContent = "";
      $textClosing = '</tbody>
                      </table>
                          </div>
                            </div>
                            ';

      foreach ($data as $data) {
        $row    = array();
        $id_initiative = $data['id_initiative'];
        $id_krnew = $data['id_kr'];

       $checkdelegate      = $this->Project_model->checkDelegateInisiativeRise($id_initiative);

        $checkdelegatetake  = $this->Project_model->checkDelegateInisiativeTake($id_initiative);

        $numdelegate  = $this->Project_model->checkDelegateInisiative($id_initiative);
  
        if($checkdelegate != null) {
          $checkuserrise   = $this->Project_model->getuserRiseIni($id_initiative);
        } 
  
        if($checkdelegatetake != null) {
          $checkusertake   = $this->Project_model->getuserTakeIni($id_initiative);
        }

        $checkuserses       = $this->Project_model->checkUserTakeIni($sesid,$id_initiative);
        $checkusersesrise       = $this->Project_model->checkUserRiseIni($sesid,$id_initiative);


        $btndelegate = '<button type="button" class="btn btn-info btn-sm rounded-pill mt-2" data-toggle="modal" data-target="#modalDelegateInit'.$id_initiative.'">
        <span class="btn--inner-icon">
        <i class="ni ni-circle-08"></i></span>
        <span class="btn-inner--text">Delegate</span>
      </button>';

        


        if(!empty($checkdelegatetake)) {
          foreach($checkusertake as $cs) {
            $datauser = '<div class="d-flex">
            <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit teks" data-toggle="tooltip" data-original-title="'.  $cs['username'] .'" >
            <span class="tooltip-teks">'.  $cs['username'] .'</span>
              <img alt="Image placeholder" src="'. base_url('assets/img/profile/') . $cs['foto'] .'">
            </div>
            <div class="rise"><i class="fas fa-hand-rock text-success"></i></div>
          </div>';
          }
        } else {
          $datauser = "";
        }
        
        if(!empty($checkdelegate)) { 
          foreach($checkuserrise as $cr) {
            $datauserrise = '<div class="d-flex">
              <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit teks" data-toggle="tooltip" data-original-title="'.  $cr['username'] .'" >
              <span class="tooltip-teks">'.  $cr['username'] .'</span>
              <img alt="Image placeholder" src="'. base_url('assets/img/profile/') . $cr['foto'] .'">
              </div>
              <div class="rise"><i class="fas fa-hand-paper text-warning"></i></div>
            </div>';
          }
          } else {
            $datauserrise = "";
          }

          if(empty($checkdelegate) && empty($checkdelegatetake)){
            $showempty = '<span class="badge badge-pill badge-danger">No User</span>';
          } else {
            $showempty = "";
          }

          if ($datenow > $dateover) {
            $taketask = '<button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2 text-white" >
              <span class="btn--inner-icon text-grey">
              <i class="fas fa-hand-rock"></i></span>
            </button>';
          } else {
            if($checkuserses == null) { 
              $taketask = '<button type="button" class="btn btn-success btn-sm rounded-pill mt-2 text-white" id="takeinisiative" data-timini="' . $data['id_initiative'] . '" data-idkr="' . $data['id_kr'] . '" data-user="' .$sesid . '" data-idtim="'. $checkteam['id_team'].'" >
              <span class="btn--inner-icon">
              <i class="fas fa-hand-rock"></i></span>
            </button>';
            } else {
              $taketask = '<button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2 text-white" >
              <span class="btn--inner-icon text-grey">
              <i class="fas fa-hand-rock"></i></span>
            </button>';
            }
          }
                            
        if ($datenow > $dateover) {
          $risehand = '<button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2 text-white">
            <span class="btn--inner-icon text-grey">
            <i class="fas fa-hand-paper"></i></span>
          </button>';
        } else {
          if($checkusersesrise == null) { 
            $risehand = '<button type="button" class="btn btn-warning btn-sm rounded-pill mt-2 text-white" id="riseinisiative" data-timini="' . $data['id_initiative'] . '" data-idkr="' . $data['id_kr'] . '" data-user="' .$sesid . '" data-idtim="'. $checkteam['id_team'].'" >
            <span class="btn--inner-icon">
            <i class="fas fa-hand-paper"></i></span>
          </button>';
          } else {
            $risehand = '<button type="button" class="btn btn-secondary btn-sm rounded-pill mt-2 text-white">
            <span class="btn--inner-icon text-grey">
            <i class="fas fa-hand-paper"></i></span>
          </button>';
          }
        }
       

        if($numdelegate > 2) {
          $buttonshow = '<div id="cek">
          <a href="#" type="button" id="viewdata" class="badge badge-pill badge-info ml-1 mt-2 view_data" data-toggle="modal" data-target="#detailUserModal" data-ini="' . $data['id_initiative'] . '">detail</a>
          </div>';
        } else {
          $buttonshow ="";
        }
       

        $detail = '<tr>
          <td>' . $data['description'] . '</td>  
          <td>' . $data['created_by'] . '</td> 
          <td>
          <div class="d-flex">
            '.$showempty.'
            '.$datauser.'
            '.$datauserrise.'
            '.$buttonshow.'
            </div>           
        </td>

  
          <td><b>' . number_format($data['value_initiative'], 0, ",", ".") . '</b> <i class="fas fa-arrow-circle-right text-success"></i> <b>' . number_format($data['value_ach_initiative'], 0, ",", ".") . '</b></td>
          <td><a type="button" class="btn btn-success btn-sm rounded-pill mt-2 text-white" data-toggle="modal" data-target="#showCmnModal" data-idinisiative="' . $data['id_initiative'] . '">
          <span class="btn-inner--text">Show</span>
           </a>
           </td> 
           <td>
            <a type="button" class="btn btn-default btn-sm rounded-pill mt-2 text-white" data-toggle="modal" data-target="#showInputModal" data-idini="' . $data['id_initiative'] . '" data-idkr="' . $data['id_kr'] . '" data-valini="' . $data['value_initiative'] . '" data-valach="' . $data['value_ach_initiative'] . '" data-desc="' . $data['description'] . '"  data-valuepercent="' . $data['value_percent'] . '" data-duedatekey="' . $duedatekey . '">
              <span class="btn-inner--text">Input</span>
            </a>
            <a type="button" class="btn btn-warning btn-sm rounded-pill mt-2 text-white" data-toggle="modal" data-target="#showEditModal" data-idini="' . $data['id_initiative'] . '" data-idkr="' . $data['id_kr'] . '" data-valini="' . $data['value_initiative'] . '" data-valach="' . $data['value_ach_initiative'] . '" data-desc="' . $data['description'] . '" data-valuepercent="' . $data['value_percent'] . '">
              <span class="btn-inner--text">Edit</span>
            </a>
            <a href="" class="btn btn-danger btn-sm rounded-pill mt-2 text-white tombol-hapus" data-target="' . base_url() .'project/deleteInisiative/' . $id_project .'/'. $id_okr .'/'.$data['id_kr'] .'/'.$data['id_initiative'] .'" >
            <span class="btn-inner--text">Hapus</span>
           </a>
            </td>
            <td>
            '.$taketask.'
            '.$risehand.'
            </td>     
          </tr>';
    

        $textContent = $textContent . " " . $detail;
      }
 


      $textOpening = '
      <div class="table-responsive">
                                          <div>
                                            <table class="table align-items-center">
                                              <thead class="thead-light">
                                                <tr>
                                                  <th scope="col" class="sort" data-sort="name">Inisiatif</th>
                                                  <th scope="col" class="sort" data-sort="name">User Created</th>
                                                  <th scope="col" class="sort" data-sort="name">User</th>
                                                  <th scope="col" class="sort" data-sort="name">Target / Achievment</th>
                                                  <th scope="col" class="sort" data-sort="name">Comment</th>
                                                  <th scope="col" class="sort" data-sort="name">Input Progress</th>
                                                  <th scope="col" class="sort" data-sort="name">Action</th>
                                                </tr>
                                              </thead>
                                              <tbody class="list">';
      $content = $textOpening . " " . $textContent . " " . $textClosing;


      echo json_encode($content);
    }
    public function getComment()
    {
      $idini = $this->input->post('idini');

      $data   = $this->Project_model->getInitiativeByIdIni($idini);


      foreach ($data as $data) {
        $comment = $data['comment'];
      }
      
      echo json_encode($comment);
      // echo $comment;
    }

    public function getCommentShow()
    {
      $idini = $this->input->post('idini');

      $data   = $this->Project_model->getInitiativeByIdIni($idini);


      foreach ($data as $data) {
        $comment = $data['comment'];
      }
      
      echo json_encode($comment);
    }

    public function inputProgressInitiative() {
      $idokr        = $this->input->post('idokr');
      $idpjkr       = $this->input->post('idpjkr');
      $idini        = $this->input->post('idini');
      $idkr         = $this->input->post('idkr');
      $score        = $this->input->post('input-score');
      $comment      = $this->input->post('commentinvoice');
      $scoreawal    = $this->input->post('valfirst');
      $session_user = $this->session->userdata('id');
      $session_nama = $this->session->userdata('nama');


     // print_r($comment);exit();

      $scoreNm = str_replace('.', '', $score);

      $scoreNm = round($scoreNm,0,PHP_ROUND_HALF_DOWN);

      $dateNow = date("Y-m-d H:i:s", strtotime("+7 hours +2 minutes"));

      $comentlog = 'Input ' . $scoreNm . ' by ' . $session_nama;

      $dataadj = array(
        'id_ini'               => $idini,
        'id_user_ini'          => $session_user,
        'keterangan_ini'       => $comentlog,
        'adjust_history_ini'   => $scoreNm,
        'date_created_ini'     => $dateNow,

      );
      $data = $this->Project_model->input_adjust($dataadj, 'history_inisiative');
      

      $perseninitiative = round(($scoreNm / $scoreawal) * 100, 2);

      $this->db->set('comment', $comment);
      $this->db->set('value_ach_initiative', $scoreNm);
      $this->db->set('value_percent', $perseninitiative);
      $this->db->where('id_initiative', $idini);
      $this->db->update('initiative');

      $value_ach     = $this->Project_model->getgetPrecentageKeyResult($idkr);

      $value_ini     = $this->Project_model->getPrecentageInitiative($idkr);

      foreach ($value_ach as $pc) {
        $value_achievment_key_result = $pc['value_achievment'];
        $value_key_result            = $pc['value_kr'];
        $status                      = $pc['status'];
        $precentage_delegate         = $pc['precentage_delegate'];

      }

      $sumvaluekr = $value_key_result * 100;

      $percent_ini = 0;
      foreach ($value_ini as $value_ini) {
        $percent_ini =  $percent_ini + $value_ini['value_percent'];
      }
      if($precentage_delegate > 0 ) {
        $precent_kr = round((($percent_ini + $precentage_delegate) / ($sumvaluekr + 100)) * 100, 2);
      } else {
        $precent_kr = round((($percent_ini) / ($sumvaluekr)) * 100, 2);
      }
     
      $this->db->set('precentage', $precent_kr);
      $this->db->where('id_kr', $idkr);
      $this->db->update('key_result');

      $precen     = $this->Project_model->getPrecentage($idokr);

      $get_kr     = $this->Project_model->getTotalKr($idokr);

      foreach ($get_kr as $tk) {
        $total_kr = $tk['total_kr'];
        $value_delegate_okr = $tk['value_delegate_okr'];
      }
      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;

      if($value_delegate_okr > 0 ) {
        $value_okr = round((($sum_precentage + $value_delegate_okr)/ ($total_precentage + 100 )) * 100, 2);
      } else {
        $value_okr = round((($sum_precentage)/($total_precentage )) * 100, 2);
      }

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $idokr);
      $this->db->update('okr');

      $this->valueProjectIni($idpjkr, $idokr,$idkr,$session_user);
      
    }

    public function valueProjectIni($id_project, $id_okr,$idkr,$iduser)
    {
      $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
      $total_count  = $this->Project_model->countOkr($id_project);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_project);
      $this->db->update('project');

      $cekbridge = $this->Project_model->checkBridgePrj($id_project);

      $resultbridge = $cekbridge['project_from'];
      ///BRIDGE OKR
      if($resultbridge == "bridge_okr") {

        $cekbridgekr = $this->Project_model->checkBrdOkr($id_project);

        $idkrto = $cekbridgekr['id_kr'];
      

        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_okr');

        //CEK KEY RESULT

        $this->updateKRDelegate($idkrto,$value_project,$idkr);
      
      } else if($resultbridge == "bridge_project") {  ///BRIDGE OBJECTIVE
        $cekbridgeprj = $this->Project_model->checkBrdPrj($id_project);

        $idokrto    = $cekbridgeprj['id_okr'];

        $idprjfrom  = $cekbridgeprj['id_project_from'];

        $countbridge = $this->Project_model->countBridgePrj($idprjfrom);
      

        $this->db->set('persentase', $value_project);
        $this->db->where('id_project_to', $id_project);
        $this->db->update('bridge_project');

        //CEK KEY RESULT

        $this->updatePJDelegate($idokrto,$value_project,$id_okr,$countbridge);
      }


      $this->session->set_flashdata('flashKey', 'Ditambahkan');
      $sessionnew = array(
        'dataidkr'              => $idkr,
      );

      $this->session->set_userdata($sessionnew);

    
      redirect('project/showKey/' . $id_project . '/' . $id_okr);


    }

    public function updateKRDelegate($idkrto,$value_project,$idkr){

      $checkjumlah = $this->Project_model->countInisiative($idkr);

      $value_ach     = $this->Project_model->getgetPrecentageKeyResult($idkrto);

      foreach ($value_ach as $pc) {
        $value_achievment_key_result =  $pc['value_achievment'];
        $value_key_result            =  $pc['value_kr'];
        $status                      =  $pc['status'];
        $precentage                  =  $pc['precentage'];
        $idokr                       =  $pc['id_okr'];
      }

      $sumach = $value_achievment_key_result + $checkjumlah;
      $sumkr  = $value_key_result + $checkjumlah;

      $val_precengtage = (($value_project + $precentage) / 200) * 100;

      $this->db->set('value_kr', $sumkr);
      $this->db->set('value_achievment', $sumach);
      $this->db->set('precentage_delegate', $value_project);
      $this->db->set('precentage', $val_precengtage);
      $this->db->where('id_kr', $idkrto);
      $this->db->update('key_result');

      //exit();

      $precen     = $this->Project_model->getPrecentage($idokr);

      $get_kr             = $this->Project_model->getTotalKr($idokr);

      foreach ($get_kr as $tk) {
        $total_kr = $tk['total_kr'];
      }
      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;


      $value_okr = round(($sum_precentage / $total_precentage) * 100, 2);

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $idokr);
      $this->db->update('okr');

      $checkproject     = $this->Project_model->checkOkr($idokr);

      $id_prj = $checkproject['id_project'];

      $value_pj     = $this->Project_model->getPrecentageOkr($id_prj);
      $total_count  = $this->Project_model->countOkr($id_prj);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $id_prj);
      $this->db->update('project');

      return true;
    }

    public function updatePJDelegate($idokrto,$value_project,$id_okr,$countbridge){

      $checkjumlah    = $this->Project_model->countObjective($id_okr);

      $value_ach      = $this->Project_model->getTotalKr($idokrto);

      foreach ($value_ach as $pc) {
        $total_kr                    =  $pc['total_kr'];
        $value_okr                   =  $pc['value_okr'];
        $idprj                       =  $pc['id_project'];
      }

      $sumkr  = $total_kr + $checkjumlah;

      $val_precengtage = (($value_project + $value_okr) / (($countbridge + 1) * 100)) * 100;

      $this->db->set('total_kr', $sumkr);
      $this->db->set('value_delegate_okr', $value_project);
      $this->db->set('value_okr', $val_precengtage);
      $this->db->where('id_okr', $idokrto);
      $this->db->update('okr');


      $value_pj     = $this->Project_model->getPrecentageOkr($idprj);
      $total_count  = $this->Project_model->countOkr($idprj);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $idprj);
      $this->db->update('project');

      return true;

    }
    

    public function editInitiative() {

      $idokr      = $this->input->post('idokr');
      $idpjkr     = $this->input->post('idpjkr');
      $idini      = $this->input->post('idinisiative');
      $idkr       = $this->input->post('idkyer');
      $valueinitiative          = $this->input->post('value_initiative');
      $descriptioninitiative    = $this->input->post('descriptioninitiative');

      $valueinitiativeNm = str_replace('.', '', $valueinitiative);

      $valueinitiativeNm = round($valueinitiativeNm,0,PHP_ROUND_HALF_DOWN);
      //$valueinitiativeNm = str_replace(',', '', $valueinitiativeNm);

      $this->db->set('description', $descriptioninitiative);
      $this->db->set('value_initiative', $valueinitiativeNm);
      // $this->db->set('value_ach_initiative', '0');
      // $this->db->set('value_percent', '0');
      $this->db->where('id_initiative', $idini);
      $this->db->update('initiative');


      $value_ach     = $this->Project_model->getgetPrecentageKeyResult($idkr);


      $value_ini     = $this->Project_model->getPrecentageInitiative($idkr);

      foreach ($value_ach as $pc) {
        $value_achievment_key_result =  $pc['value_achievment'];
        $value_key_result            =  $pc['value_kr'];
        $status                      =  $pc['status'];
      }

      $sumvaluekr = $value_key_result * 100;
     
      $percent_ini = 0;
      foreach ($value_ini as $value_ini) {
        $percent_ini =  $percent_ini + $value_ini['value_percent']; 
      }
     
      $precent_kr = round(($percent_ini / $sumvaluekr) * 100, 2);
      //print_r($precent_kr);exit();

      $this->db->set('precentage', $precent_kr);
      $this->db->where('id_kr', $idkr);
      $this->db->update('key_result');

      $precen     = $this->Project_model->getPrecentage($idokr);

      $get_kr             = $this->Project_model->getTotalKr($idokr);

      foreach ($get_kr as $tk) {
        $total_kr = $tk['total_kr'];
      }
      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;


      $value_okr = round(($sum_precentage / $total_precentage) * 100, 2);

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $idokr);
      $this->db->update('okr');

      $this->valueProject($idpjkr, $idokr);
     
    }

    public function deleteInisiative()
    {
      $id_project         = $this->uri->segment(3);
      $id_okr             = $this->uri->segment(4);
      $id_kr              = $this->uri->segment(5);
      $id_initiative      = $this->uri->segment(6);


      
      $this->Project_model->hapus_initiative($id_initiative);

      $total_kr = $this->Project_model->count_initiative($id_kr);

      $this->db->set('value_kr', $total_kr);
      $this->db->where('id_kr', $id_kr);
      $this->db->update('key_result');

      $precen     = $this->Project_model->getPrecentageInitiative($id_kr);

      $sum_precentage_key = 0;

      foreach ($precen as $pc) {
        $sum_precentage_key =  $sum_precentage_key + $pc['value_percent'];
      }

     


      $total_precentage = 100 * $total_kr;

      // $sum_precentage_key = 100;
      // $total_precentage   = 100;

      // $total_precentage = sum($precen);
      if ($sum_precentage_key == 0 && $total_kr == 0) {
        $value_okr = 0;
      } else {
        $value_okr = round(($sum_precentage_key / $total_precentage) * 100, 2); 
      }

      // print_r($sum_precentage_key);
      // echo "<pre>";
      // print_r($total_precentage);
      // echo "<pre>";
      // print_r($value_okr);
      // exit();

      $this->db->set('precentage', $value_okr);
      $this->db->where('id_kr', $id_kr);
      $this->db->update('key_result');

       //UPDATE TABEL OKR

       $precen     = $this->Project_model->getPrecentage($id_okr);

       $countkey   = $this->Project_model->count_key_result($id_okr);

       $sum_precentage = 0;
 
       foreach ($precen as $precen) {
         $sum_precentage =  $sum_precentage + $precen['precentage'];
       }
 
       // print_r($total_kr);
       // echo "<br>";
 
       $total_precentage = 100 * $countkey;
 
       // $total_precentage = sum($precen);
       if ($sum_precentage == 0 && $countkey == 0) {
         $value_okr = 0;
       } else {
         $value_okr = round(($sum_precentage / $total_precentage) * 100, 2) ;
       }
 

       $this->db->set('value_okr', $value_okr);
       $this->db->where('id_okr', $id_okr);
       $this->db->update('okr');
 
       //UPDATE Project


      //  print_r($value_okr);
      //  exit();
 
       $value_pj     = $this->Project_model->getPrecentageOkr($id_project);
       $total_count  = $this->Project_model->countOkr($id_project);
 
       $sum_value = 0;
 
       foreach ($value_pj as $pj) {
         $sum_value =  $sum_value + $pj['value_okr'];
       }
 
       $total_precen = 100 * $total_count;
 
       $value_project = round(($sum_value / $total_precen) * 100, 2);
 
       $this->db->set('value_project', $value_project);
       $this->db->where('id_project', $id_project);
       $this->db->update('project');
 
       $this->session->set_flashdata('flashKey', 'Dihapus');
       redirect('project/showKey/' . $id_project . '/' . $id_okr);

    }


    public function exportExcelProject($idproject)
    {
      $dataokr = $this->input->post('dataokr');
      $dataprj = $this->input->post('dataprj');
      

      //$idproject  = $this->$this->uri->segment(3);
      $dateF      = date('j F Y');

    $dateName = date('d-m-Y');

    $fileName = 'project_' . $dateName . '.xlsx';
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => '5e72e4'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];

    $project = $this->Main_model->printExcelProject($idproject, $dataprj);
    $object = $this->Main_model->printExcelObj($idproject, $dataokr);
    $ket = 'Laporan Project ' . $dateF;
    
    $row = 8;
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    $sheetDimension = $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    list($startColumn, $startRow, $endColumn, $endRow) = $sheetDimension;

    //Set Default Teks
    $spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Times New Roman')
    ->setSize(12);

    $spreadsheet->getDefaultStyle()
    ->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setWrapText(true);

  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A1', "Laporan Project");

  $spreadsheet->getActiveSheet()
    ->mergeCells("A1:I1");

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(20);

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A2', $ket);

  $spreadsheet->getActiveSheet()
    ->mergeCells("A2:I2");

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getFont()
    ->setSize(12);

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

  // style lebar kolom
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('A')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('B')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('C')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('D')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('E')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('F')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('G')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('H')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('I')
    ->setAutoSize(true);

    $idp = "ID Project";
    $prj_name = "Nama Project";
    $dprt_name = "Nama Departement";
    $tim_name = "Nama Tim";
    $desc = "Decription";

    $ido = "ID Objective";
    $obj_name = "Objective";        
    $progres = "Progress";
    $jml_kr = "Jumlah Key Result";

    $str_date = "Start Date";
    $due_date = "Due Date";

    $columnAlphabet = range('A', 'Z');

    $headerPrj = array();
    $rowPrj = 4;

    if (in_array('`project`.`id_project`', $dataprj)) {
      array_push($headerPrj, $idp);
    }
    if (in_array('`nama_project`', $dataprj)) {
      array_push($headerPrj, $prj_name);
    }
    if (in_array('`departement`.`nama_departement`', $dataprj)) {
      array_push($headerPrj, $dprt_name);
    }
    if (in_array('`team`.`nama_team`', $dataprj)) {
      array_push($headerPrj, $tim_name);
    }
    if (in_array('`description_project`', $dataprj)) {
      array_push($headerPrj, $desc);
    }
    if (in_array('`value_project`', $dataprj)) {
      array_push($headerPrj, $progres);
    }
    if (in_array('`tanggal_awal_project`', $dataprj)) {
      array_push($headerPrj, $str_date);
    }
    if (in_array('`tanggal_akhir_project`', $dataprj)) {
      array_push($headerPrj, $due_date);
    }
    // print_r($headerPrj);exit();

    foreach ($headerPrj as $colIndex => $columnLabel) {
      $colIndex += 1;
      $sheet->setCellValueByColumnAndRow($colIndex, $rowPrj, $columnLabel);
      $sheet->getStyleByColumnAndRow($colIndex, $rowPrj)->applyFromArray($styleJudul);
     }

    $headerOkr = array();
    $rowOkr = 7;


    if (in_array('`id_okr`', $dataokr)) {
      array_push($headerOkr, $ido);
    }
    if (in_array('`description_okr`', $dataokr)) {
      array_push($headerOkr, $obj_name);
    }
    if (in_array('`project`.`nama_project`', $dataokr)) {
      array_push($headerOkr, $prj_name);
    }
    if (in_array('`team`.`nama_team`', $dataokr)) {
      array_push($headerOkr, $tim_name);
    }
    if (in_array('`value_okr`', $dataokr)) {
      array_push($headerOkr, $progres);
    }
    if (in_array('`total_kr`', $dataokr)) {
      array_push($headerOkr, $jml_kr);
    }
    if (in_array('`start_dateokr`', $dataokr)) {
      array_push($headerOkr, $str_date);
    }
    if (in_array('`due_date`', $dataokr)) {
      array_push($headerOkr, $due_date);
    }

    foreach ($headerOkr as $colIndex => $columnLabel) {
     $colIndex += 1;
     $sheet->setCellValueByColumnAndRow($colIndex, $rowOkr, $columnLabel);
     $sheet->getStyleByColumnAndRow($colIndex, $rowOkr)->applyFromArray($styleJudul);
    }
        // $sheet->setCellValue('A4', 'ID Project');
        // $sheet->setCellValue('B4', 'Project Name');
        // $sheet->setCellValue('C4', 'Nama Departement');
        // $sheet->setCellValue('D4', 'Nama Team');
        // $sheet->setCellValue('E4', 'Start Date');
        // $sheet->setCellValue('F4', 'Due Date');
        // $sheet->setCellValue('G4', 'Description');
        // $sheet->setCellValue('H4', 'Status');
        // $sheet->setCellValue('I4', 'Progress');

        // $sheet->setCellValue('A7', 'ID Objective');
        // $sheet->setCellValue('B7', 'Objective Name');
        // $sheet->setCellValue('C7', 'Progress');
        // $sheet->setCellValue('D7', 'Total Key Result');
        // $sheet->setCellValue('E7', 'Start Date');
        // $sheet->setCellValue('F7', 'Due Date');

        $rowConPrj = 5;

        foreach ($project as $rowData) {      
          $colConPrj = 0;    
          foreach ($rowData as $columnLabel) {
            $currentColumn = $columnAlphabet[$colConPrj];
            $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConPrj, $columnLabel);
            $colConPrj++;
          }  
        }

        $rowConOkr = 8;
        

        foreach ($object as $rowData) {      
          $colConOkr = 0;    
          foreach ($rowData as $columnLabel) {
            $currentColumn = $columnAlphabet[$colConOkr];
            $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConOkr, $columnLabel);
            $colConOkr++;
          }  
          $rowConOkr++;
        }

        

      // foreach ($project as $val) {
      //   $sheet->setCellValue('A5', $val['id_project']);
      //   $sheet->setCellValue('B5', $val['nama_project']);
      //   $sheet->setCellValue('C5', $val['nama_departement']);
      //   $sheet->setCellValue('D5', $val['nama_team']);
      //   $sheet->setCellValue('E5', date('j F Y', strtotime($val['tanggal_awal_project'])));
      //   $sheet->setCellValue('F5', date('j F Y', strtotime($val['tanggal_akhir_project'])));
      //   $sheet->setCellValue('G5', $val['description_project']);
      //   if ($val['work_status'] == '1') {
      //     $sheet->setCellValue('H5', 'Complete');
      //   } elseif ($val['work_status'] == '2') {
      //     $sheet->setCellValue('H5', 'Pending');
      //   } else {
      //     $sheet->setCellValue('H5', 'On Progress');
      //   }
      //   $sheet->setCellValue('I5', $val['value_project'].'%');

      //   $sheet->setCellValue('A' . $row, $val['id_okr']);
      //   $sheet->setCellValue('B' . $row, $val['description_okr']);
      //   $sheet->setCellValue('C' . $row, $val['value_okr'].'%');
      //   $sheet->setCellValue('D' . $row, $val['total_kr']);
      //   $sheet->setCellValue('E' . $row, date('j F Y', strtotime($val['start_dateokr'])));
      //   $sheet->setCellValue('F' . $row, date('j F Y', strtotime($val['due_date'])));
       
      //   $row++;
      // }
 
      $writer = new Xlsx($spreadsheet);
      $writer->save($fileName);
      header("Content-Type: application/vnd.ms-excel");
      redirect(base_url() . $fileName);
     
  
    }

    public function exportExcelOkr($id_okr)
    {
      $dataokr = $this->input->post('dataokr');
      $datakr = $this->input->post('datakr');

      // print_r($datakr);exit(); 

      //$idproject  = $this->$this->uri->segment(3);
      $dateF      = date('j F Y');

    $dateName = date('d-m-Y');

    $fileName = 'objective_' . $dateName . '.xlsx';
    $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => '5e72e4'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];

    $object = $this->Main_model->printExcelObj($id_okr, $dataokr);
    $key = $this->Main_model->printExcelKr($id_okr, $datakr);
    $ket = 'Laporan Objective ' . $dateF;

    
    
    $row = 8;
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    $sheetDimension = $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    list($startColumn, $startRow, $endColumn, $endRow) = $sheetDimension;

    //Set Default Teks
    $spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Times New Roman')
    ->setSize(12);

    $spreadsheet->getDefaultStyle()
    ->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setWrapText(true);

  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A1', "Laporan Objective");

  $spreadsheet->getActiveSheet()
    ->mergeCells("A1:H1");

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(20);

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A2', $ket);

  $spreadsheet->getActiveSheet()
    ->mergeCells("A2:H2");

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getFont()
    ->setSize(12);

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

  // style lebar kolom
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('A')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('B')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('C')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('D')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('E')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('F')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('G')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('H')
    ->setAutoSize(true);

    //Data Header Okr
    $ido = "ID Objective";
    $obj_name = "Objective";
    $prj_name = "Nama Project";
    $tim_name = "Nama Tim";
    $progres = "Progress";
    $jml_kr = "Jumlah Key Result";
    

    //Data Header Kr
    $idk = "ID Key Result";
    $obj = "Nama Objective";
    $kr_name = "Nama Key Result";
    $kr_desc = "Decription Key Result";
    $target = "Target Key Result";
    $progres_val = "Progress Value";
    $progres_per = "Persentase Progress";
    $sts_kr = "Status Key Result";

    $str_date = "Start Date";
    $due_date = "Due Date";

    $columnAlphabet = range('A', 'Z');

    $headerOkr = array();
    $rowOkr = 4;


    if (in_array('`id_okr`', $dataokr)) {
      array_push($headerOkr, $ido);
    }
    if (in_array('`project`.`nama_project`', $dataokr)) {
      array_push($headerOkr, $prj_name);
    }
    if (in_array('`team`.`nama_team`', $dataokr)) {
      array_push($headerOkr, $tim_name);
    }
    if (in_array('`description_okr`', $dataokr)) {
      array_push($headerOkr, $obj_name);
    }
    if (in_array('`value_okr`', $dataokr)) {
      array_push($headerOkr, $progres);
    }
    if (in_array('`total_kr`', $dataokr)) {
      array_push($headerOkr, $jml_kr);
    }
    if (in_array('`start_dateokr`', $dataokr)) {
      array_push($headerOkr, $str_date);
    }
    if (in_array('`due_date`', $dataokr)) {
      array_push($headerOkr, $due_date);
    }

    foreach ($headerOkr as $colIndex => $columnLabel) {
     $colIndex += 1;
     $sheet->setCellValueByColumnAndRow($colIndex, $rowOkr, $columnLabel);
     $sheet->getStyleByColumnAndRow($colIndex, $rowOkr)->applyFromArray($styleJudul);
    }

    $headerKr = array();
    $rowKr = 7;

    if (in_array('`id_kr`', $datakr)) {
      array_push($headerKr, $idk);
    }
    if (in_array('`okr`.`description_okr`', $datakr)) {
      array_push($headerKr, $obj);
    }
    if (in_array('`nama_kr`', $datakr)) {
      array_push($headerKr, $kr_name);
    }
    if (in_array('`description_kr`', $datakr)) {
      array_push($headerKr, $kr_desc);
    }
    if (in_array('`value_kr`', $datakr)) {
      array_push($headerKr, $target);
    }
    if (in_array('`value_achievement`', $datakr)) {
      array_push($headerKr, $progres_val);
    }
    if (in_array('`precentage`', $datakr)) {
      array_push($headerKr, $progres_per);
    }
    if (in_array('`status`', $datakr)) {
      array_push($headerKr, $sts_kr);
    }
    if (in_array('`start_datekey`', $datakr)) {
      array_push($headerKr, $str_date);
    }
    if (in_array('`due_datekey`', $datakr)) {
      array_push($headerKr, $due_date);
    }

    foreach ($headerKr as $colIndex => $columnLabel) {
      $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowKr, $columnLabel);
      $sheet->getStyleByColumnAndRow($colIndex + 1, $rowKr)->applyFromArray($styleJudul);
    }

        $rowConOkr = 5;
        

        foreach ($object as $rowData) {      
          $colConOkr = 0;    
          foreach ($rowData as $columnLabel) {
            $currentColumn = $columnAlphabet[$colConOkr];
            $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConOkr, $columnLabel);
            $colConOkr++;
          }  
        }

        $rowConKr = 8;
        

        foreach ($key as $rowData) {    
          $colConKr = 0;
          foreach ($rowData as $columnLabel) {
            $currentColumn = $columnAlphabet[$colConKr];    
            $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConKr, $columnLabel);
            $colConKr++;
          }  
          $rowConKr++;
        }
 
      $writer = new Xlsx($spreadsheet);
      $writer->save($fileName);
      header("Content-Type: application/vnd.ms-excel");
      redirect(base_url() . $fileName);
     
  
    }

    public function exportExcelKr($idkr){

      $datakr = $this->input->post('datakr');
      $datains = $this->input->post('datains');

      $dateF      = date('j F Y');

      $dateName = date('d-m-Y');

      $fileName = 'Inisiative_' . $dateName . '.xlsx';
      $styleJudul = [
      'font' => [
        'color' => [
          'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 11
      ],
      'fill' => [
        'fillType' =>  fill::FILL_SOLID,
        'startColor' => [
          'rgb' => '5e72e4'
        ]
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
      ]

    ];

    $key = $this->Main_model->PrintKeyData($idkr, $datakr);
    $inisiative = $this->Main_model->PrintInsData($idkr, $datains);
    $ket = 'Laporan Key-Result ' . $dateF;
    // print_r($inisiative);exit();
    $row = 8;
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    $sheetDimension = $spreadsheet->getActiveSheet()->calculateWorksheetDimension();
    list($startColumn, $startRow, $endColumn, $endRow) = $sheetDimension;

    //Set Default Teks
    $spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Times New Roman')
    ->setSize(12);

    $spreadsheet->getDefaultStyle()
    ->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setWrapText(true);

  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A1', "Laporan Key Result");

  $spreadsheet->getActiveSheet()
    ->mergeCells("A1:H1");

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(20);

  $spreadsheet->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
  //Style Judul table
  $spreadsheet->getActiveSheet()
    ->setCellValue('A2', $ket);

  $spreadsheet->getActiveSheet()
    ->mergeCells("A2:H2");

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getFont()
    ->setSize(12);

  $spreadsheet->getActiveSheet()
    ->getStyle('A2')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

  // STYLE judul table
  $spreadsheet->getActiveSheet()
  ->setCellValue('A2', $ket);

$spreadsheet->getActiveSheet()
  ->mergeCells("A2:H2");

$spreadsheet->getActiveSheet()
  ->getStyle('A2')
  ->getFont()
  ->setSize(12);

$spreadsheet->getActiveSheet()
  ->getStyle('A2')
  ->getAlignment()
  ->setHorizontal(Alignment::HORIZONTAL_CENTER);

  // style lebar kolom
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('A')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('B')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('C')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('D')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('E')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('F')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('G')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('H')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('I')
    ->setWidth(20);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('J')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('K')
    ->setAutoSize(true);
  $spreadsheet->getActiveSheet()
    ->getColumnDimension('L')
    ->setAutoSize(true);
  
      //Data Header Kr
    $idk = "ID Key Result";
    $obj = "Nama Objective";
    $kr_name = "Nama Key Result";
    $kr_desc = "Decription Key Result";
    $target = "Target Key Result";
    $progres_val = "Progress Value";
    $progres_per = "Persentase Progress";
    $sts_kr = "Status Key Result";
  
    $str_date = "Start Date";
    $due_date = "Due Date";

    //Data Header Ins
    $idins = "ID Initiative"; 
    $nama_kr = "Nama Key Result"; 
    $ins_desc = "Description"; 
    $valins = "value Inisiative"; 
    $startins = "Start Date"; 
    $dueins = "Due Date"; 
    $val_ach = "Value Ach Initiative"; 
    $val_percent = "value Percent"; 
    $comment = "Comment"; 
    $created_by = "created By"; 

    $columnAlphabet = range('A', 'Z');

    $headerKr = array();
    $rowKr = 4;

    if (in_array('`id_kr`', $datakr)) {
      array_push($headerKr, $idk);
    }
    if (in_array('`okr`.`description_okr`', $datakr)) {
      array_push($headerKr, $obj);
    }
    if (in_array('`nama_kr`', $datakr)) {
      array_push($headerKr, $kr_name);
    }
    if (in_array('`description_kr`', $datakr)) {
      array_push($headerKr, $kr_desc);
    }
    if (in_array('`value_kr`', $datakr)) {
      array_push($headerKr, $target);
    }
    if (in_array('`value_achievment`', $datakr)) {
      array_push($headerKr, $progres_val);
    }
    if (in_array('`precentage`', $datakr)) {
      array_push($headerKr, $progres_per);
    }
    if (in_array('`status`', $datakr)) {
      array_push($headerKr, $sts_kr);
    }
    if (in_array('`start_datekey`', $datakr)) {
      array_push($headerKr, $str_date);
    }
    if (in_array('`due_datekey`', $datakr)) {
      array_push($headerKr, $due_date);
    }
  
    foreach ($headerKr as $colIndex => $columnLabel) {
      $colIndex += 1;
      $sheet->setCellValueByColumnAndRow($colIndex, $rowKr, $columnLabel);
      $sheet->getStyleByColumnAndRow($colIndex, $rowKr)->applyFromArray($styleJudul);
     }

    $headerIns = array();
    $rowIns = 7;

    if (in_array('`id_initiative`', $datains)) {
      array_push($headerIns, $idins);
    }
    if (in_array('`key_result`.`nama_kr`', $datains)) {
      array_push($headerIns, $nama_kr);
    }
    if (in_array('`description`', $datains)) {
      array_push($headerIns, $ins_desc);
    }
    if (in_array('`value_initiative`', $datains)) {
      array_push($headerIns, $valins);
    }
    if (in_array('`startins_date`', $datains)) {
      array_push($headerIns, $startins);
    }
    if (in_array('`dueins_date`', $datains)) {
      array_push($headerIns, $dueins);
    }
    if (in_array('`value_ach_initiative`', $datains)) {
      array_push($headerIns, $val_ach);
    }
    if (in_array('`value_percent`', $datains)) {
      array_push($headerIns, $val_percent);
    }
    if (in_array('`comment`', $datains)) {
      array_push($headerIns, $comment);
    }
    if (in_array('`created_by`', $datains)) {
      array_push($headerIns, $created_by);
    }

    foreach ($headerIns as $colIndex => $columnLabel) {
      $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIns, $columnLabel);
      $sheet->getStyleByColumnAndRow($colIndex + 1, $rowIns)->applyFromArray($styleJudul);
    }

    $rowConKr = 5;
      

    foreach ($key as $rowData) {      
      $colConKr = 0;    
      foreach ($rowData as $columnLabel) {
        $currentColumn = $columnAlphabet[$colConKr];
        $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConKr, $columnLabel);
        $colConKr++;
      }  
    }

    $rowConIns = 8;
      

    foreach ($inisiative as $rowData) {    
      $colConIns = 0;
      foreach ($rowData as $columnLabel) {
        $currentColumn = $columnAlphabet[$colConIns];    
        $sheet->setCellValueByColumnAndRow(array_search($currentColumn, $columnAlphabet) + 1, $rowConIns, $columnLabel);
        $colConIns++;
      }  
      $rowConIns++;
    }

      $writer = new Xlsx($spreadsheet);
      $writer->save($fileName);
      header("Content-Type: application/vnd.ms-excel");
      redirect(base_url() . $fileName);

    }

    public function getUser(){
      $users       = $this->Account_model->getALLUsers();

      echo json_encode($users);
    }


    public function saveDelegate()
    {
      $savedelegate = $this->input->post('useritem');
      $idtim        = $this->input->post('idtim');
      $idkr         = $this->input->post('idkr');
      $status       = '2';

      $countdelegate = count($savedelegate);

      $error = array();

      for ($i = 0; $i < $countdelegate; $i++) {

        $checkTeam = $this->Team_model->checkTeamById($idkr,$savedelegate[$i]);

      
          $datacek = array(
            'id_kr_delegate'    => $idkr,
            'id_tim_delegate'   => $idtim,
            'id_user_delegate'  => $savedelegate[$i],
            'status_delegate'   => $status,
          );

          if($checkTeam != null) {
            $error[] = 'Sudah Di Delegasi : ' . $checkTeam['nama'];
          } 
          if (!empty($error)) {
            continue;
          } else if (empty($error)) {
            $data = $this->Project_model->input_delegate($datacek, 'delegate_key_result');     
          }
        } 
      
      echo json_encode($error);
    }

    public function riseHand()
    {
      $idkr   = $this->input->post('idkr');
      $user   = $this->input->post('user');
      $idtim  = $this->input->post('idtim');
      $status = '1';

      $datarise = array(
        'id_kr_delegate'    => $idkr,
        'id_tim_delegate'   => $idtim,
        'id_user_delegate'  => $user,
        'status_delegate'   => $status,
      );
      
      $data = $this->Project_model->input_delegate($datarise, 'delegate_key_result');

      // $data = $this->Project_model->editkr($idkr,$user);
      
      echo json_encode($data);

    }

    public function takeTask()
    {
      $idkr   = $this->input->post('idkr');
      $user   = $this->input->post('user');
      $idtim  = $this->input->post('idtim');
      $status = '2';

      $datarise = array(
        'id_kr_delegate'    => $idkr,
        'id_tim_delegate'   => $idtim,
        'id_user_delegate'  => $user,
        'status_delegate'   => $status,
      );
      
      $data = $this->Project_model->input_delegate($datarise, 'delegate_key_result');

      
      echo json_encode($data);

    }

    public function takeInisiative()
    {
      $idini  = $this->input->post('idini');
      $idkr   = $this->input->post('idkr');
      $user   = $this->input->post('user');
      $idtim  = $this->input->post('idtim');
      $status = '2';

      $datarise = array(
        'id_kr_delegate_inisiative'    => $idkr,
        'id_inisiative_delegate'       => $idini,
        'id_tim_delegate_inisiative'   => $idtim,
        'id_user_delegate_inisiative'  => $user,
        'status_delegate_inisiative'   => $status,
      );
      
      $data = $this->Project_model->input_delegate_inisiative($datarise, 'delegate_inisiative');

      
      echo json_encode($data);

    }

    public function riseHandInisiative()
    {
      $idkr   = $this->input->post('idkr');
      $user   = $this->input->post('user');
      $idtim  = $this->input->post('idtim');
      $idini  = $this->input->post('idini');
      $status = '1';

      $datarise = array(
        'id_kr_delegate_inisiative'    => $idkr,
        'id_inisiative_delegate'       => $idini,
        'id_tim_delegate_inisiative'   => $idtim,
        'id_user_delegate_inisiative'  => $user,
        'status_delegate_inisiative'   => $status,
      );
      
      $data = $this->Project_model->input_delegate_inisiative($datarise, 'delegate_inisiative');

      // $data = $this->Project_model->editkr($idkr,$user);
      
      echo json_encode($data);

    }

    public function AdjustmentInisiative()
    {
      $idini   = $this->input->post('idini');
      $user   = $this->input->post('user');
      $score  = $this->input->post('score');
      $namauser  = $this->input->post('namauser');



      $idokr      = $this->input->post('idokr');
      $idpjkr     = $this->input->post('idpjkr');
      $idkr       = $this->input->post('idkr');

    
      $comment    = $this->input->post('comment');
      $scoreawal  = $this->input->post('valfirst');

      
      $dateNow = date("Y-m-d H:i:s", strtotime("+7 hours +2 minutes"));

      $comentlog = 'Adjustment ' . $score . ' by ' . $namauser;

      $dataadj = array(
        'id_ini'               => $idini,
        'id_user_ini'          => $user,
        'keterangan_ini'       => $comentlog,
        'adjust_history_ini'   => $score,
        'date_created_ini'     => $dateNow,

      );
      
      $data = $this->Project_model->input_adjust($dataadj, 'history_inisiative');



      $perseninitiative = round(($score / $scoreawal) * 100, 2);

      $this->db->set('comment', $comment);
      $this->db->set('value_ach_initiative', $score);
      $this->db->set('value_percent', $perseninitiative);
      $this->db->where('id_initiative', $idini);
      $this->db->update('initiative');

      $value_ach     = $this->Project_model->getgetPrecentageKeyResult($idkr);

      $value_ini     = $this->Project_model->getPrecentageInitiative($idkr);

      foreach ($value_ach as $pc) {
        $value_achievment_key_result =  $pc['value_achievment'];
        $value_key_result            =  $pc['value_kr'];
        $status                      =  $pc['status'];
      }

      $sumvaluekr = $value_key_result * 100;

     
      $percent_ini = 0;
      foreach ($value_ini as $value_ini) {
        $percent_ini =  $percent_ini + $value_ini['value_percent'];
      }
     
      $precent_kr = round(($percent_ini / $sumvaluekr) * 100, 2);
      //print_r($precent_kr);exit();
      $this->db->set('precentage', $precent_kr);
      $this->db->where('id_kr', $idkr);
      $this->db->update('key_result');

      $precen     = $this->Project_model->getPrecentage($idokr);

      $get_kr             = $this->Project_model->getTotalKr($idokr);

      foreach ($get_kr as $tk) {
        $total_kr = $tk['total_kr'];
      }
      $sum_precentage = 0;

      foreach ($precen as $pc) {
        $sum_precentage =  $sum_precentage + $pc['precentage'];
      }

      $total_precentage = 100 * $total_kr;


      $value_okr = round(($sum_precentage / $total_precentage) * 100, 2);

      $this->db->set('value_okr', $value_okr);
      $this->db->where('id_okr', $idokr);
      $this->db->update('okr');


      $value_pj     = $this->Project_model->getPrecentageOkr($idpjkr);
      $total_count  = $this->Project_model->countOkr($idpjkr);

      $sum_value = 0;

      foreach ($value_pj as $pj) {
        $sum_value =  $sum_value + $pj['value_okr'];
      }

      $total_precen = 100 * $total_count;

      $value_project = round(($sum_value / $total_precen) * 100,2);

      $this->db->set('value_project', $value_project);
      $this->db->where('id_project', $idpjkr);
      $this->db->update('project');


      
      $cek     = $this->Project_model->getPrecentageInInitiative($idini);
      
      echo json_encode($cek);

    }

    public function getHistoryInisiative()
    {

      $idini = $this->input->post('idini');

      $data = $this->Project_model->getAllHistory($idini);


      $textOpening = "";
      $textContent = "";
      $textClosing = '</ul>';

      foreach ($data as $data) {
        if ($data == null){
          $detail = '<li class="adjustment-list"></li>';
        } else {
          $detail = '<li class="adjustment-list">' . $data['keterangan_ini'] . ' at ' . date('Y-m-d H:i:s', strtotime($data['date_created_ini'])) . '</li>';
        }
        $textContent = $textContent . " " . $detail;
      
      }
 
      $textOpening = ' <ul class="list-group list-group-flush" id="myList1">';
      $content = $textOpening . " " . $textContent . " " . $textClosing;


      echo json_encode($content);
    }


    public function checkDelegate(){
      $idkr   = $this->input->post('idkr');
      $iduser = $this->input->post('iduser');

      $checkTeam = $this->Team_model->checkTeamById($idkr,$iduser);

      if(!empty($checkTeam)){
        $textContent = '
        <div class="alert alert-default" role="alert">
          <strong>Peringatan</strong> '.$checkTeam['nama'].' Sudah di Delegasikan!
      </div>
       ';
      } else if(empty($checkTeam)) {
        $textContent = '
        <div class="alert alert-success" role="alert">
          <strong>Belum</strong> Ada Yang di Delegasikan!
      </div>
       ';
      } else {
        $textContent = '
        <div class="alert alert-default" role="alert">
          <strong>Peringatan</strong> '.$checkTeam['nama'].' Sudah di Delegasikan!
      </div>
       ';
      }

      $content = $textContent;

      echo json_encode($content);
    }

    public function showUser(){

      $inisiative = $this->input->post("data_id");

      $showdata  = $this->Project_model->checkDelegate($inisiative);

      $output = "";
      $output .= '<div class="d-flex">'; 

     
          foreach($showdata as $cr) {
            $status = $cr['status_delegate_inisiative'];
            if($status == 1){
              $output .= '<div class="d-flex">
              <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit teks" data-toggle="tooltip" data-original-title="'.  $cr['username'] .'" >
              <span class="tooltip-teks">'.  $cr['username'] .'</span>
              <img alt="Image placeholder" src="'. base_url('assets/img/profile/') . $cr['foto'] .'">
              </div>
              <div class="rise"><i class="fas fa-hand-paper text-warning"></i></div>
            </div>';

            } else if ($status == 2) { 
              $output .= '<div class="d-flex">
            <div class="avatar-groupnew avatar avatar-sm rounded-circle rounded-edit teks" data-toggle="tooltip" data-original-title="'.  $cr['username'] .'" >
            <span class="tooltip-teks">'.  $cr['username'] .'</span>
              <img alt="Image placeholder" src="'. base_url('assets/img/profile/') . $cr['foto'] .'">
            </div>
            <div class="rise"><i class="fas fa-hand-rock text-success"></i></div>
          </div>';
            }
             
            }    
            $output .= "</div>"; 

          echo $output;  



    }

    public function sesUnsetPerPage(){
      unset($_SESSION['dataidkr']);

      return false;
    }

    public function copyInisiative(){
      $idkr = $this->input->post('idkrcopy');

      $data   = $this->Project_model->getInitiativeById($idkr);


      echo json_encode($data);
    }


    public function  searchKuadran($id,$type){
      // print_r($type);exit();
        if($type == 'Project') {
          redirect('project/showOkr/' . $id);
        } elseif($type == 'Objective') {
          $checkOkr =  $this->Project_model->checkOkr($id);

          $id_project = $checkOkr['id_project'];

          redirect('project/showKey/' . $id_project .'/' . $id);
        } elseif ($type == 'Key%20Result') {
          $checkKr =  $this->Project_model->checkKr($id);

          $id_okr = $checkKr['id_okr'];

          $checkOkr =  $this->Project_model->checkOkr($id_okr);

          $id_project = $checkOkr['id_project'];  

          redirect('project/showKey/' . $id_project .'/' . $id_okr);
        } else {
          $checkInitiative = $this->Project_model->checkIni($id);

          $id_kr = $checkInitiative['id_kr'];

          $checkKr =  $this->Project_model->checkKr($id_kr);

          $id_okr = $checkKr['id_okr'];

          $checkOkr =  $this->Project_model->checkOkr($id_okr);

          $id_project = $checkOkr['id_project'];

          redirect('project/showKey/' . $id_project .'/' . $id_okr);
        }
    }

    public function delegateOkr($id)
    {
      $userdata      = $this->session->userdata('username');
      $id_user       = $this->input->post('id_user[]');
      $okr           = $this->Project_model->getOkrById($id);
      $project       = $this->Project_model->getProjectById($okr['id_project']);
      $ids           = count($id_user);

      $action       = $this->input->post('action');

      $date_created           = date('Y-m-d');

      $bulan = date('Y-m', strtotime($date_created));

      if($action == "delegasikan") {
        for ($i = 0; $i < $ids; $i++) {
          $checkdelegate = $this->Project_model->checkDelegateOkr($okr['id_okr'], $id_user[$i]);
          if ($checkdelegate == NULL) {
            $generateIDProject = $this->generateID($bulan);
          
            $brdg = array(
              'id_project_from'     => $project['id_project'],
              'id_project_to'       => $generateIDProject,
              'id_okr'              => $okr['id_okr'],
              'id_user'             => $id_user[$i],
              'status'              => 'Delegate',
              'value_achieve'       => '0',
              'persentase'          => '0'
            );
            // print_r($brdg);exit();
            $this->Project_model->inputBridgePrj($brdg);
  
            $tim = array(
              'nama_team'  => $okr['description_okr'],
              'created_at'    => $date_created
            );
        
            $id_team = $this->Team_model->input_team($tim, 'team');
  
            $data = array(
              'id_project'                => $generateIDProject,
              'nama_project'              => $okr['description_okr'],
              'id_departement'            => $project['id_departement'],
              'id_team'                   => $id_team,
              'tanggal_awal_project'      => $okr['start_dateokr'],
              'tanggal_akhir_project'     => $okr['due_date'],
              'work_status'               => '3',
              'value_project'             => $okr['value_okr'],
              'created_by'                => $userdata,
              'date_created'              => $date_created,
              'project_from'              => 'bridge_project',
            );
  
            $this->Project_model->input_project($data, 'project');
  
            $acc_team = array(
              'id_team'   => $id_team,
              'id_user'   => $id_user[$i],
              'role_user' => '2'
            );
  
            $this->Team_model->input_teamacc($acc_team, 'access_team');
          }
        }

      } else {
        for ($i = 0; $i < $ids; $i++) {
          $tim = array(
            'nama_team'  => $okr['description_okr'],
            'created_at'    => $date_created
          );
      
          $id_team = $this->Team_model->input_team($tim, 'team');
          
          $acc_team = array(
            'id_team'   => $id_team,
            'id_user'   => $id_user[$i],
            'role_user' => '2'
          );

          $delegatesave = array(
            'id_user_delegate'    => $id_user[$i],
            'id_project'          => $project['id_project'],
            'id_okr'              => $okr['id_okr'],
            'id_kr'               => "-",
            'id_inisiative'       => "-",
            'keterangan_delegate' => 'objective',
          );

          $this->Project_model->input_delegate($delegatesave, 'delegate_save');

        }
      }

     
      
      redirect('project/showOkr/' . $project['id_project'] );
    }

    public function delegateKr($id)
    {
      $userdata         = $this->session->userdata('username');
      $id_user          = $this->input->post('id_user[]');
      $kr               = $this->Project_model->getKeyByIdKr($id);
      $okr              = $this->Project_model->getOkrById($kr['id_okr']);
      $project          = $this->Project_model->getProjectById($okr['id_project']);
      $ids              = count($id_user);

      $action       = $this->input->post('action');
      

      $date_created     = date('Y-m-d');

      $bulan  = date('Y-m', strtotime($date_created));


      if($action == "delegasikan") {

      for ($i = 0; $i < $ids; $i++) {
        $checkdelegate = $this->Project_model->checkDelegateKr($kr['id_kr'], $id_user[$i]);
        if ($checkdelegate == NULL) {
          $generateIDProject = $this->generateID($bulan);
        
          $brdg = array(
            'id_project_from'       => $project['id_project'],
            'id_project_to'         => $generateIDProject,
            'id_kr'                 => $kr['id_kr'],
            'id_user'               => $id_user[$i],
            'status'                => 'Delegate',
            'value_achieve'         => '0',
            'persentase'            => '0'
          );

          $this->Project_model->inputBridgeOkr($brdg);

          $tim = array(
            'nama_team' => $kr['nama_kr'],
            'created_at'    => $date_created
          );
      
          $id_team = $this->Team_model->input_team($tim, 'team');

          $data = array(
            'id_project'            => $generateIDProject,
            'nama_project'          => $kr['nama_kr'],
            'id_departement'        => $project['id_departement'],
            'id_team'               => $id_team,
            'tanggal_awal_project'  => $kr['start_datekey'],
            'tanggal_akhir_project' => $kr['due_datekey'],
            'work_status'           => '3',
            'value_project'         => $kr['precentage'],
            'created_by'            => $userdata,
            'date_created'          => $date_created,
            'project_from'          => 'bridge_okr',
            'project_owner'         => $userdata,
          );

          $this->Project_model->input_project($data, 'project');


          $checkIni = $this->Project_model->checkInisiative($id);

          if(!empty($checkIni)) {
            foreach($checkIni as $newini) {
              $data = array(
                'id_project'          => $generateIDProject,
                'id_team'             => $id_team,
                'description_okr'     => $newini['description'],
                'value_okr'           => 0,
                'total_kr'            => 0,
                'value_delegate_okr'  => 0,
                'start_dateokr'       => $newini['start_dateinit'],
                'due_date'            => $newini['due_dateinit'],
                'created_by'          => $userdata,
                'status_from'         => 'inisiative',
                'idbridge_from'       => $newini['id_initiative'],
                'value_from'          => $newini['value_initiative']
              );

              $this->Project_model->input_okr($data, 'okr');
            }
          } 

          $acc_team = array(
            'id_team'   => $id_team,
            'id_user'   => $id_user[$i],
            'role_user' => '2'
          );

          $this->Team_model->input_teamacc($acc_team, 'access_team');
        }
      }
    } else {
      for ($i = 0; $i < $ids; $i++) {
        $tim = array(
          'nama_team'     => $kr['nama_kr'],
          'created_at'    => $date_created
        );

        $id_team = $this->Team_model->input_team($tim, 'team');

        $acc_team = array(
          'id_team'   => $id_team,
          'id_user'   => $id_user[$i],
          'role_user' => '2'
        );

        $delegatesave = array(
          'id_user_delegate'    => $id_user[$i],
          'id_project'          => $okr['id_project'],
          'id_okr'              => $kr['id_okr'],
          'id_kr'               => $kr['id_kr'],
          'id_inisiative'       => "-",
          'keterangan_delegate' => 'key_result',
        );

        $this->Project_model->input_delegate($delegatesave, 'delegate_save');
    
    }
  }

      $this->session->set_flashdata('flashKey', 'Ditambahkan');
      
      redirect('project/showKey/' . $project['id_project'] .'/' . $okr['id_okr']);
    }

    public function delegateInit($id)
    {
      $userdata         = $this->session->userdata('username');
      $id_user          = $this->input->post('id_user[]');
      $init             = $this->Project_model->getInitByIdInit($id);
      $kr               = $this->Project_model->getKeyByIdKr($init['id_kr']);
      $okr              = $this->Project_model->getOkrById($kr['id_okr']);
      $project          = $this->Project_model->getProjectById($okr['id_project']);
      $ids              = count($id_user);

      $date_created           = date('Y-m-d');

      $bulan = date('Y-m', strtotime($date_created));

      for ($i = 0; $i < $ids; $i++) {
        $checkdelegate = $this->Project_model->checkDelegateKr($init['id_initiative'], $id_user[$i]);
        if ($checkdelegate == NULL) {
          $generateIDProject = $this->generateID($bulan);
        
          $brdg = array(
            'id_project_from'     => $project['id_project'],
            'id_project_to'       => $generateIDProject,
            'id_initiative'       => $init['id_initiative'],
            'id_user'             => $id_user[$i],
            'status'              => 'Delegate',
            'value_achieve'       => '0',
            'persentase'          => '0'
          );
          // print_r($brdg);exit();
          $this->Project_model->inputBridgeKr($brdg);

          $tim = array(
            'nama_team' => $init['description'],
            'created_at'    => $date_created
          );
      
          $id_team = $this->Team_model->input_team($tim, 'team');

          $data = array(
            'id_project'            => $generateIDProject,
            'nama_project'          => $init['description'],
            'id_departement'        => $project['id_departement'],
            'id_team'               => $id_team,
            'tanggal_awal_project'  => $init['start_dateinit'],
            'tanggal_akhir_project' => $init['due_dateinit'],
            'work_status'           => '3',
            'value_project'         => $init['value_percent'],
            'created_by'            => $userdata,
            'date_created'          => $date_created,
          );

          $this->Project_model->input_project($data, 'project');

          $acc_team = array(
            'id_team' => $id_team,
            'id_user'  => $id_user[$i],
            'role_user' => '2' 
          );

          $this->Team_model->input_teamacc($acc_team, 'access_team');
        }
      }
      
      redirect('project/showKey/' . $project['id_project'] .'/' . $okr['id_okr']);
    }
    
  }
