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

  class Calendar extends CI_Controller
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
    public function index($idspace)
    {
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
        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarcalendar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/calendar', $data);
        $this->load->view('template/footer', $data);
    }

    public function getTasks() {
        $idspace = $this->input->get('idspace');
        $selectedUsers = $this->input->get('users');

        try {
            if($selectedUsers == 'all') {
                $userIds = 'all';
                $tasks = $this->Space_model->get_all_tasks($userIds, $idspace);
            } else {
                $userIds = explode(',', $selectedUsers);
                $tasks = $this->Space_model->get_all_tasks($userIds, $idspace);
            }
            

            $events = [];
            foreach ($tasks as $task) {

                if($task->type_task == 'meeting'){
                    $namatask = '[MEET] ' . $task->name_task;
                } else {
                    $namatask = '[SUBS] ' . $task->name_task;
                }

                $events[] = array(
                    'id'            => $task->id_task,
                    'title'         => $namatask,
                    'description'   => $task->desc_task,
                    'start'         => $task->start_task,
                    'end'           => $task->overdue_task,
                    'taskin'        => $task->task_in,
                );
            }


            header('Content-Type: application/json');
            echo json_encode(['events' => $events]);
        } catch (Exception $e) {
            log_message('error', 'Error fetching tasks: ' . $e->getMessage());
            show_error('Error fetching tasks: ' . $e->getMessage(), 500);
        }
    }

    public function viewall()
    {
        $data['title']          = 'Data Workspace';
        $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['team']           = $this->Team_model->getALLTeam();
        $data['users']          = $this->Account_model->getJoinUsers();

        $iduser                 = $this->session->userdata('id');

        $delegasi               = $this->Project_model->cekDelegasi($iduser);

        $cekspace               = $this->Space_model->allspaceTeam($iduser);

        $myspace = [];

        foreach($cekspace as $space) {
            $idspace = $space['id_workspace'];

            $myspace[] =  $idspace;
        }

        $data['usersspace']     = $this->Main_model->getMyTeamInSpace($myspace);

       // print_r($data['usersspace']);exit();
        
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/calendarall', $data);
        $this->load->view('template/footer', $data);
    }

    public function getDataSpaceActive(){
        $id_space = $this->input->post('id_space');

        if($id_space) {
            $dataSpaceActive = $this->Space_model->dataMySpaceUserSide($id_space);
            echo json_encode($dataSpaceActive);
        } else {
            echo json_encode([]);
        }
    }

    public function getTasksAll() {
        $idspace = $this->input->get('idspaceall');
        $selectedUsers = $this->input->get('users');
        $cekin = $this->input->get('cekin');

        // Fungsi untuk menghasilkan warna acak
        function randomColor() {
            $colors = ['#FF5733', '#33FF57', '#3357FF', '#F0FF33', '#FF33A8', '#33FFF7'];
            return $colors[array_rand($colors)];
        }

        try {
            if($idspace == '') {
                $myid = $this->session->userdata("id");
                $tasks = $this->Space_model->get_all_tasks_notwithspace($myid);

                $events = [];
                foreach ($tasks as $task) {
                    if ($task->created_by_task == $myid || $task->user_to_task == $myid) {
                        $color = '#5e72e4'; // Warna khusus untuk user yang sedang login
                    } else {
                        $color = randomColor(); // Warna acak untuk user lain
                    }

                    $idtask = $task->user_to_task;

                    $user   = $this->Account_model->getAccountById($idtask);

                    $nama   = $user['nama'];

                    if($task->type_task == 'meeting'){
                        $namatask = '[MEET] ' . $task->name_task;
                    } else {
                        $namatask = '[SUBS] ' . $task->name_task;
                    }

                    
                    

                    $events[] = array(
                        'id'                => $task->id_task,
                        'title'             => $namatask,
                        'description'       => 'Task dari ' . $task->user_from_task . ' <i class="fas fa-arrow-circle-right text-success"></i> ' . $nama . '<br>' . $task->desc_task,
                        'start'             => $task->start_task,
                        // 'end'               => $task->overdue_task,
                        'taskin'            => $task->task_in,
                        'backgroundColor'   => $color, // Warna background
                        'borderColor'       => $color, // Warna border
                    );
                }
            } else {
                if($selectedUsers == 'all') {
                    $userIds = 'all';
                    $tasks = $this->Space_model->get_all_tasks($userIds, $idspace);
                } else {
                    $userIds = explode(',', $selectedUsers);
                    $tasks = $this->Space_model->get_all_tasks($userIds, $idspace);
                }

                $myid = $this->session->userdata("id");


                $events = [];
                foreach ($tasks as $task) {
                      // Tentukan warna berdasarkan dua kondisi
                    if ($task->created_by_task == $myid || $task->user_to_task == $myid) {
                        $color = '#5e72e4'; // Warna khusus untuk user yang sedang login
                    } else {
                        $color = randomColor(); // Warna acak untuk user lain
                    }

                    if($task->type_task == 'meeting'){
                        $namatask = '[MEET] ' . $task->name_task;
                    } else {
                        $namatask = '[SUBS] ' . $task->name_task;
                    }

                    $events[] = array(
                        'id'                => $task->id_task,
                        'title'             => $namatask,
                        'description'       => $task->desc_task,
                        'start'             => $task->start_task,
                        //'end'               => $task->overdue_task,
                        'taskin'            => $task->task_in,
                        'backgroundColor'   => $color, // Warna background
                        'borderColor'       => $color, // Warna border
                    );
                }
            }

            header('Content-Type: application/json');
            echo json_encode(['events' => $events]);
        } catch (Exception $e) {
            log_message('error', 'Error fetching tasks: ' . $e->getMessage());
            show_error('Error fetching tasks: ' . $e->getMessage(), 500);
        }
    }

    public function getTasksFromUser() {
        $idspace        = $this->input->get('idspaceall');
        $selectedUsers  = $this->input->get('users');
        $cekin          = $this->input->get('cekin');

        // Fungsi untuk menghasilkan warna acak
        function randomColor() {
            $colors = ['#FF5733', '#33FF57', '#3357FF', '#F0FF33', '#FF33A8', '#33FFF7'];
            return $colors[array_rand($colors)];
        }

        try {
                  
                $tasks = $this->Space_model->get_user_tasks($selectedUsers);
                

                $myid = $this->session->userdata("id");


                $events = [];
                foreach ($tasks as $task) {
                      // Tentukan warna berdasarkan dua kondisi
                    if ($task->created_by_task == $myid || $task->user_to_task == $myid) {
                        $color = '#5e72e4'; // Warna khusus untuk user yang sedang login
                    } else {
                        $color = randomColor(); // Warna acak untuk user lain
                    }

                    if($task->type_task == 'meeting'){
                        $namatask = '[MEET] ' . $task->name_task;
                    } else {
                        $namatask = '[SUBS] ' . $task->name_task;
                    }

                    $events[] = array(
                        'id'                => $task->id_task,
                        'title'             => $namatask,
                        'description'       => $task->desc_task,
                        'start'             => $task->start_task,
                        //'end'               => $task->overdue_task,
                        'taskin'            => $task->task_in,
                        'backgroundColor'   => $color, // Warna background
                        'borderColor'       => $color, // Warna border
                    );
                }
            

            header('Content-Type: application/json');
            echo json_encode(['events' => $events]);
        } catch (Exception $e) {
            log_message('error', 'Error fetching tasks: ' . $e->getMessage());
            show_error('Error fetching tasks: ' . $e->getMessage(), 500);
        }
    }
}