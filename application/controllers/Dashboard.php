<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in_okr') != TRUE) {
      redirect('auth');
    }
    $this->load->model('Main_model');
    $this->load->model('Project_model');

    $usernamesession = $this->session->userdata('username');
     
    $validatelogin = $this->Main_model->getUserLogin($usernamesession);

    if(empty($validatelogin)){
     redirect('auth/backlogin');
    } 
  }

  public function index()
  {
    $data['users_name']          = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['title']               = 'Dashboard OKR';
    $data['count_space']         = $this->Main_model->countAllMySpace();
    $data['count_okr']           = $this->Main_model->countAllMyProject();
    $data['count_task']          = $this->Main_model->countAllMyTask();
    $data['count_document']      = $this->Main_model->countAllMyDoc();

    $data['my_document']        = $this->Main_model->dataAllMyDoc();

    $data['high']            = $this->Project_model->getKuadHigh();
    $data['medium']          = $this->Project_model->getKuadMed();
    $data['low']             = $this->Project_model->getKuadLow();
    $data['lowest']          = $this->Project_model->getKuadLowest();

    $data['chigh']            = $this->Project_model->countKuadHigh();
    $data['cmed']             = $this->Project_model->countKuadMedium();
    $data['clow']             = $this->Project_model->countKuadLow();
    $data['clowest']          = $this->Project_model->countKuadLowest();


    $scheduleproject              = $this->schedule_project();
        
    $data['mydocument'] = $this->myDocument();

    $data['mytask'] = $this->Main_model->dataMyTask();

    $this->load->helper('url');

    $data['next_schedule']        = !empty($scheduleproject) ? $scheduleproject : false;

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('dashboard/dashboard', $data);
    $this->load->view('template/footer', $data);
  }

  private function myDocument(){
    $iduser = $this->session->userdata('id');

    $documentsign       = $this->Main_model->dataMyDocument($iduser);
    $documentcreated    = $this->Main_model->dataMyDocumentAll($iduser);

    $mydoc = [];
    // Array untuk menyimpan kombinasi unik id_user dan id_document
    $uniqueKeys = [];
    
    // Proses data dari $documentsign
    if (!empty($documentsign)) {
        foreach ($documentsign as $doc) {
            $uniqueKey = $doc['id_user_doc'] . '_' . $doc['id_document_users'];
            if (!in_array($uniqueKey, $uniqueKeys)) {
                $uniqueKeys[] = $uniqueKey;
                $mydoc[] = $doc;
            }
        }
    }  
    // Proses data dari $documentcreated
    if (!empty($documentcreated)) {
        foreach ($documentcreated as $doc) {
            $uniqueKey = $doc['id_user_create'] . '_' . $doc['id_document'];
            if (!in_array($uniqueKey, $uniqueKeys)) {
                $uniqueKeys[] = $uniqueKey;
                $mydoc[] = $doc;
            }
        }
    }

    return $mydoc;
  }

  protected function schedule_project()
  {
    $task = $this->Main_model->getScheduleTask();
    $result  = false;

    foreach ($task as $key => $tk) {
      $dateov     = $tk['overdue_task'];
      $datestart  = $tk['start_task'];

      if($dateov == 'NULL') {
        $date_time = $datestart;
      } else {
        $date_time = $dateov;
      }

      if ($date_time > getCurrentDate()) {
        $result = $task[$key];
        break;
      }
    }
    return $result;
  }

  public function saveToken() {
    $token = $this->input->post('token');
    $user_id = $this->session->userdata('id'); // Ambil user_id dari session

    // Simpan token ke database
    $this->db->where('id', $user_id);
    $this->db->update('users', ['token_users' => $token]);

    echo json_encode(['status' => 'success']);
  }

  public function myProject() {
    // Ambil data proyek dari model
    $projects = $this->Main_model->getAllProjects();

    // Mengirim data sebagai JSON
    echo json_encode($projects);
  }

  public function taskStatus() {
    // Ambil data status task dari model
    $tasks = $this->Main_model->getTaskStatusCounts();

    // Mengirim data sebagai JSON
    echo json_encode($tasks);
  }

  public function myperformance()
  {
    $data['users_name']          = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['title']               = 'Dashboard OKR';
    $data['count_space']         = $this->Main_model->countAllMySpace();
    $data['count_okr']           = $this->Main_model->countAllMyProject();
    $data['count_task']          = $this->Main_model->countAllMyTask();
    $data['count_document']      = $this->Main_model->countAllMyDoc();

    $data['my_document']        = $this->Main_model->dataAllMyDoc();

    $data['high']            = $this->Project_model->getKuadHigh();
    $data['medium']          = $this->Project_model->getKuadMed();
    $data['low']             = $this->Project_model->getKuadLow();
    $data['lowest']          = $this->Project_model->getKuadLowest();

    $data['chigh']            = $this->Project_model->countKuadHigh();
    $data['cmed']             = $this->Project_model->countKuadMedium();
    $data['clow']             = $this->Project_model->countKuadLow();
    $data['clowest']          = $this->Project_model->countKuadLowest();


    $scheduleproject              = $this->schedule_project();
        
    $data['mydocument'] = $this->myDocument();

    $data['mytask'] = $this->Main_model->dataMyTask();

    $this->load->helper('url');

    $data['next_schedule']        = !empty($scheduleproject) ? $scheduleproject : false;

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('dashboard/performence', $data);
    $this->load->view('template/footer', $data);
  }

  function logout()
  {
    $this->session->sess_destroy();
    redirect('auth');
  }


}
