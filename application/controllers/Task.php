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

  require_once APPPATH . 'third_party/fpdf/fpdf.php';
  require_once APPPATH . 'third_party/fpdi/src/autoload.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;  
  use setasign\Fpdi\Fpdi;

  require 'vendor/autoload.php';

  use Google\Client;


  class Task extends CI_Controller
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

    public function index($id)
    {

      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectById($id);

      $iduser = $this->session->userdata('id');
      $idspace   = $this->session->userdata('workspace_sesi');


      if($this->uri->segment(4) == "space") {
        
        $idspace   = $this->uri->segment(3);
       
        $data['users']  = $this->Team_model->getUserActiveInSpace($idspace);

        $data['space']          = $this->Space_model->checkSpaceById($idspace);

        $data['mykey']          = $this->Project_model->checkOneOKRbySpace($idspace);

        $projectDelegasi       = $this->Project_model->getYourProjectDelegate($idspace);
   
        $projects              = $this->Project_model->getYourProjectNoLimit($idspace);

  
         // Gabungkan data dengan ID project sebagai kunci
         $combinedData = [];
  
         if (!empty($projectDelegasi)) {
          foreach ($projectDelegasi as $delegate) {
              $projectId = $delegate['id_project'];
              if (!isset($combinedData[$projectId])) {
                  $combinedData[$projectId] = $delegate;
              } else {
                  $combinedData[$projectId] = array_merge($combinedData[$projectId], $delegate);
              }
          }
      }
        
        foreach ($projects as $project) {
            $projectId = $project['id_project'];
            if (!isset($combinedData[$projectId])) {
                $combinedData[$projectId] = $project;
            } else {
                // Jika ada data duplikat, Anda bisa memilih untuk mengganti atau menggabungkan data
                $combinedData[$projectId] = array_merge($combinedData[$projectId], $project);
            }
        }
  
         $data['projectspace'] = $combinedData;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('task/taskinspace', $data);
        $this->load->view('template/footer', $data);

        } else {

        $idprj  = $this->uri->segment(3);


        $iduser            = $this->session->userdata('id');
        $workspace_sesi    = $this->session->userdata('workspace_sesi');
        $delegasi          = $this->Project_model->cekDelegasi($iduser);

        // $data['users']     = $this->Account_model->getAllUserActive();

        $delegasi          = $this->Project_model->cekDelegasi($iduser);
        
        if(!empty($delegasi)) {
            $object     = $this->Project_model->getAllObjectDelegasi($iduser);
            $data['statusproject'] = "Project Partner";
        } else {
            $object     = $this->Project_model->getAllObject();
            $data['statusproject'] = "-";
        }

        $data['chat']  = $this->Project_model->cekChat($id,$workspace_sesi);

        $data['object'] = $object;

        $data['mykey'] =  $this->Project_model->checkOneOKRbyProject($idprj);

        $sesiworkspace = $this->session->userdata('workspace_sesi');
        
        $data['users']  = $this->Team_model->getUserActiveInSpace($sesiworkspace);

        // $data['mytask'] =  $this->Space_model->dataMyTask($idprj);

        $this->load->view('template/header', $data);
        // $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/navbarproject', $data);
        $this->load->view('task/task', $data);
        $this->load->view('template/footer', $data);

        }
    }

    public function cekInisiative() {
        $keyResultId = $this->input->get('keyResultId');

        if ($keyResultId) {
            // Ambil data inisiative berdasarkan key result ID
            $inisiatives = $this->Project_model->getInisiativesByKeyResultId($keyResultId);

            // Cek apakah data ditemukan
            if (!empty($inisiatives)) {
                $response = [
                    'status' => 'success',
                    'data' => $inisiatives
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Tidak ada inisiative yang ditemukan untuk Key Result ID tersebut.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Key Result ID tidak valid.'
            ];
        }

        // Mengirimkan response JSON
        echo json_encode($response);
    }

    public function getKey(){
        $project_id = $this->input->post('project_id');  // Ambil ID project dari request

        if ($project_id) {
            // Panggil fungsi di model untuk mendapatkan key result berdasarkan project_id
            $key_results = $this->Project_model->checkKeyByPj($project_id);
            
            if (!empty($key_results)) {
                echo json_encode($key_results);  // Kirim data key result dalam format JSON
            } else {
                echo json_encode([]);  // Jika tidak ada data, kirim array kosong
            }
        } else {
            echo json_encode([]);  // Jika project_id tidak ada, kirim array kosong
        }
    }

    public function getKeyResultDetails() {
            $keyResultId = $this->input->get('keyResultId');
            $namatask    = $this->input->get('namatask');

            if($namatask == 'keyresult') {
                 // Ambil detail Key Result berdasarkan ID
                $keyResult = $this->Project_model->checkDataKrbyOKR($keyResultId);
            } else {
                 // Ambil detail Key Result berdasarkan ID
                 $keyResult = $this->Project_model->checkDataIni($keyResultId);
            }
           
            if ($keyResult) {
                // Response sukses dengan data Key Result
                echo json_encode([
                    'status' => 'success',
                    'data' => $keyResult
                ]);
            } else {
                // Response gagal jika Key Result tidak ditemukan
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Key Result tidak ditemukan'
                ]);
            }
        }
        public function inputTask()
            {
            $userdata           = $this->session->userdata('username');
            $userid             = $this->session->userdata('id');
            $idspace            = $this->session->userdata('workspace_sesi');
            $idselected         = $this->input->post('idselected');
            $namaselected       = $this->input->post('namaselected');
            $namatask           = $this->input->post('namatask');
            $tanggalakhir       = $this->input->post('tanggalakhir');
            $tanggalawal        = $this->input->post('tanggalawal');
            $userselect         = $this->input->post('userselect');
            $idprojecttask      = $this->input->post('idprojecttask');
            $describeokr        = $this->input->post('describeokr');
            $classification     = $this->input->post('classificationtask');

            $myurl  = $this->input->post('myurl');

            if($idprojecttask == 'space') {
                $idprojectnew = '0';

                if($namaselected == 'keyresult') {
                    $kr = $this->Project_model->checkDataKrbyOKR($idselected);

                    $idokr = $kr['id_okr'];

                    $okr = $this->Project_model->checkOkr($idokr);

                    $idprojectnew = $okr['id_project'];
                } else {
                    $ini = $this->Project_model->checkDataIni($idselected);

                    $idkr = $ini['id_kr'];

                    $kr = $this->Project_model->checkDataKrbyOKR($idkr);

                    $idokr = $kr['id_okr'];

                    $okr = $this->Project_model->checkOkr($idokr);

                    $idprojectnew = $okr['id_project'];
                    
                }
            } else {
                $idprojectnew = $idprojecttask;
            }
            
            $userstask      = $this->Account_model->getAccountById($userid);
            $nama           = $userstask['nama'];

            if($namaselected == "keyresult") {
                $keyresult = $this->Project_model->checkDataKrbyOKR($idselected);
                
                $desc      = $keyresult['description_kr'];

                $desc = $describeokr;
             

                $data = array(
                    'name_task'             => $namatask,
                    'desc_task'             => $desc,
                    'type_task'             => $namaselected,
                    'classification_task'   => $classification,
                    'task_in_space'         => $idspace,
                    'task_in'               => $idprojectnew,
                    'id_task_from'          => $idselected,
                    'create_date_task'      => getCurrentDate(),
                    'user_to_task'          => $userselect,
                    'user_from_task'        => $nama,
                    'status_task'           => '1',
                    'start_task'            => $tanggalawal,
                    'overdue_task'          => $tanggalakhir,
                    'created_by_task'       => $userid,
                    'updated_task'          => getCurrentDate(),
                );
                
            } else {
                $ini = $this->Project_model->checkDataIni($idselected);

                $desc      = $ini['comment'];

                $desc = $describeokr;
          
                $data = array(
                    'name_task'             => $namatask,
                    'desc_task'             => $desc,
                    'type_task'             => $namaselected,
                    'classification_task'   => $classification,
                    'task_in_space'         => $idspace,
                    'task_in'               => $idprojectnew,
                    'id_task_from'          => $idselected,
                    'create_date_task'      => getCurrentDate(),
                    'user_to_task'          => $userselect,
                    'user_from_task'        => $nama,
                    'status_task'           => '1',
                    'start_task'            => $tanggalawal,
                    'overdue_task'          => $tanggalakhir,
                    'created_by_task'       => $userid,
                    'updated_task'          => getCurrentDate(),
                );
            }
        
            $idtask = $this->Space_model->input_task($data);

            $data = array(
                'id_tk_inokr'         => $idtask,
                'id_okr_inokr'        => $idselected,
                'type_taskokr'        => $namaselected,
                'created_date_inokr'  => getCurrentDate(),
            );

            $this->Space_model->input_space($data,'task_in_okr');

            $type = 'task';
            $text = '';

            $this->saveNotif($userselect,$type,$namatask,$myurl,$text);

            $this->session->set_flashdata('message', 'Task berhasil ditambahkan');

            if($idprojecttask == 'space') {
                $idspace   = $this->session->userdata('workspace_sesi');
                redirect('task/index/' . $idspace . '/space');
            } else {
                redirect('task/index/' . $idprojecttask);
            }
    }

    public function saveNotif($iduser,$type,$nama_task,$myurl,$text){
        $myid = $this->session->userdata('id');
        $account = $this->Account_model->getAccountById($myid);
        $namafrom = $account['nama'];
        $title = "Task Baru From " . $namafrom;

        if($type == 'taskmeeting') {
            $notiftype = 'taskmeeting';
            $checkIdTask = $this->Space_model->checkIdByName($nama_task);
            $idtask = $checkIdTask['id_task'];
            $message = $text;
        } else {
            $notiftype = 'task';
            $idtask = 0;
            $message = $nama_task;
        }
        $workspace_sesi    = $this->session->userdata('workspace_sesi');

        $data = array(
            'user_id'           => $iduser,
            'user_from'         => $myid,
            'space_from'        => $workspace_sesi,
            'title_notif'       => $title,
            'message_notif'     => $message,
            'data_notif'        => json_encode(array('url'=>$myurl,'type'=>$notiftype,'idtask'=>$idtask)),
            'is_read_notif'     => 1,
            'created_at_notif'  => getCurrentDate(),
        );
    
        $this->Main_model->input($data, 'notification');
        
        $accounttokens = $this->Account_model->getAccountById($iduser);
        $tokens = $accounttokens['token_users'];
        if($tokens == '') {
            $tokens == NULL;
          }
    
        $data = array(
            'user_id_notif_token'     => $iduser,
            'token_notif_token'       => $tokens,
            'created_at_notif_token'  => getCurrentDate(),
        );
    
        $this->Main_model->input($data, 'notification_tokens');
    
        try {
            $accessToken = getAccessToken();
            $response = sendMessage($accessToken, $tokens, $title, $text,$myurl);
            echo 'Message sent successfully: ' . print_r($response, true);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
       
    }

   

     

     
    // function sendPushNotification($token, $title, $message) {

    //     $url = 'https://fcm.googleapis.com/v1/projects/okre-b9df7/messages:send';

    //     $access_token = $this->getAccessToken();

    //     $fields = array(
    //         'message' => array(
    //             'token' => $token,
    //             'notification' => array(
    //                 'title' => $title,
    //                 'body' => $message
    //             ),
    //             'android' => array(
    //                 'priority' => 'HIGH',
    //                 'notification' => array(
    //                     'sound' => 'default'
    //                 )
    //             ),
    //             'apns' => array(
    //                 'payload' => array(
    //                     'aps' => array(
    //                         'content-available' => 1,
    //                         'sound' => 'default'
    //                     )
    //                 )
    //             )
    //         )
    //     );

    //     $headers = array(
    //         'Authorization: Bearer ' . $access_token,
    //         'Content-Type:application/json'
    //     );

    //       // mengirim data payload ke server FCM untuk disebarkan ke perangkat
    
    //       $ch = curl_init();
    //       curl_setopt($ch, CURLOPT_URL, $url);
    //       curl_setopt($ch, CURLOPT_POST, true);
    //       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //       $response = curl_exec($ch);
    //       if ($response === false) {
    //       throw new Exception('Curl error: ' . curl_error($ch));
    //       }
    //      curl_close($ch);

       
    //      return json_decode($response, true);
    // }

    // function getAccessToken() {
    //     $client = new Client();
    //     $serviceAccountPath = FCPATH . "service-notif.json";
    //     $client->setAuthConfig($serviceAccountPath);
    //     $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    //     $client->useApplicationDefaultCredentials();
    //     $token = $client->fetchAccessTokenWithAssertion();
    //     return $token['access_token'];
    //  }

    

    public function saveTask() {
        ob_start(); 
        // Ambil data dari POST request
        $nama_task          = $this->input->post('namataskpvt');
        $overdue_task       = $this->input->post('overduepvt');
        $start_task         = $this->input->post('startpvt');
        $user_id            = $this->input->post('userselectpvt');
        $description        = $this->input->post('describeprivate');
        $idprjpvt           = $this->input->post('idprjpvt');
        $useridfrom         = $this->session->userdata('id');
        $idspace            = $this->session->userdata('workspace_sesi');
        $myurl              = $this->input->post('myurlpvt');
        $jadikanmeeting     = $this->input->post('jadikanmeeting');
        $classification     = $this->input->post('classificationtask');
       
        $userstask      = $this->Account_model->getAccountById($useridfrom);
        $nama           = $userstask['nama'];

        $start = $start_task;
        $due = $overdue_task;


        if($overdue_task == '') {
            $due = "";
        } else {
            $due = date('j F Y H:i', strtotime($overdue_task));
        }


        if($start_task == '') {
            $start = "";
        } else {
            $start = date('j F Y H:i', strtotime($start_task));
        }

        if($overdue_task == '') {
            $overdue_task = NULL;
        } 

        if($idprjpvt == 'space') {
            $idprjpvt = 0;
        } else {
            $idprjpvt = $idprjpvt;
        }

        if($jadikanmeeting == '1') {
            $type_task = 'meeting';
            $type = 'taskmeeting';
            $classification = 'meeting';
            $myurl = base_url("task/editTaskInCalendar/" . $idprjpvt .'/'.$savetask.'/'.$idspace);
        } else {
            $type_task = 'private';
            $type = 'task';
        }

       

        // Buat array data untuk disimpan ke database
        $data = array(
            'name_task'             => $nama_task,
            'desc_task'             => $description,
            'type_task'             => $type_task,
            'classification_task'   => $classification,
            'task_in_space'         => $idspace,
            'task_in'               => $idprjpvt,
            'id_task_from'          => 0,
            'create_date_task'      => getCurrentDate(),
            'user_to_task'          => $user_id,
            'user_from_task'        => $nama,
            'status_task'           => '1',
            'start_task'            => $start_task,
            'overdue_task'          => $overdue_task,
            'created_by_task'       => $useridfrom,
            'updated_task'          => getCurrentDate(),
        );

        $savetask = $this->Space_model->insert_task($data);

        if($jadikanmeeting == '1') {
            $text = $nama_task . ' Pada ' . $start . ' - ' . $due;
        } else {
            $text = "";
        }

        $this->saveNotif($user_id,$type,$nama_task,$myurl,$text);

        if($nama_task == "" || $start_task == "" || $user_id == "") {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan task.');
        } else {
            // Simpan data menggunakan model
            if ($savetask) {
                // Jika berhasil, kirim respon sukses
                $response = array('status' => 'success', 'message' => 'Task berhasil disimpan!');
            } else {
                // Jika gagal, kirim respon error
                $response = array('status' => 'error', 'message' => 'Gagal menyimpan task.');
            }
        }
        ob_end_clean();
        // Kirim respon JSON
        echo json_encode($response);
        
        exit();

    }


    public function loadTasksByStatus() {
        $status     = $this->input->get('statustask');
        $idprj      = $this->input->get('prj');
        $idspace    = $this->input->get('space');

        if($idprj == "space") {
            $tasks = $this->Space_model->dataMyTaskInSpace($status,$idspace);
        } else {
             // Ambil data tugas berdasarkan status
            $tasks = $this->Space_model->dataMyTask($status,$idprj);
        }
        // Kembalikan data dalam format JSON
        echo json_encode($tasks);
    }


    public function loadTasksByStatusTable() {
        $result         = $this->Space_model->getDatatask();
        $data           = [];
        $no             = $_POST['start'];
        $stateacctive   = $this->input->post('stateacctive');
        $status         = $this->input->post('statustask');
        $tableid        = $this->input->post('tableid');

     //   print_r($stateacctive);exit();
  
        foreach ($result as $result) {
          $row    = array();

          if ($result->status_task == 1) {
            $statusLabel = "On Going";
            $statusClass = "text-info";
            $statustabClass = "";
        } else if ($result->status_task == 2) {
            $statusLabel = "Complete";
            $statusClass = "text-success";
            $statustabClass = "text-success";
        } else if ($result->status_task == 3) {
            $statusLabel = "Pending";
            $statusClass = "text-warning";
            $statustabClass = "";
        } else {
            $statusLabel = "Reject";
            $statusClass = "text-danger";
            $statustabClass = "";
        }

        $dateoverdue = $result->overdue_task;

        // Jika $dateoverdue kosong atau null, gunakan "0000-00-00".
        // Jika tidak, format tanggalnya.
        $overdueDate = empty($dateoverdue) ? date('Y-m-d',strtotime($result->create_date_task)) : date("Y-m-d", strtotime($dateoverdue));

        // Dapatkan waktu saat ini
        $currentDate = date("Y-m-d");

        // Bandingkan waktu
        if ($overdueDate < $currentDate) {
            if($result->status_task == 2) {
                $colorovd = "text-success";
            } else {
                $colorovd = "text-danger";
            }
          
        } else {
            if($result->status_task == 2) {
                $colorovd = "text-success";
            } else {
            $colorovd = "";
            }
        }

        if($result->classification_task != NULL) {
            $type = $result->classification_task;
          } else {
            $type = $result->type_task;
          }
          $statusapv = "";

          if($result->type_task == "meeting") {
            $aproval = $result->approval_task_meet;

            if($aproval == '1'){
                $statusapv = '<small class="text-primary">Menunggu</small>';
            } else if($aproval == '2') {
                $statusapv = '<small class="text-danger">Ditolak</small>';
            } else {
                $statusapv = '<small class="text-success">Diterima</small>';
            }
          } 

        

          $status = '<span class="' .$statusClass. '">●</span><small class="'.$statusClass.'">' .$statusLabel. '</small>';
      
          $row[]  = $status;
          $row[]  = '<span class="'.$colorovd.'">' . date('j F Y', strtotime($result->create_date_task)) . '</span>';
          $row[]  =  '<span class="'.$colorovd.'">' . date('j F Y', strtotime($overdueDate)) . '</span>';

          $row[]  = '<span class="'.$colorovd.'">' .$type. '</span>';
          $row[]  = '<span class="'.$colorovd.'">' .$result->name_task. '</span> ' . $statusapv;

          $row[]  = $result->desc_task;

          $row[]  = '<span class="'.$colorovd.'">' .$result->user_from_task. '</span>';

          $id = $result->user_to_task;

          $users = $this->Account_model->getAccountById($id);

          $row[]  = '<span class="'.$colorovd.'">' .$users['nama']. '</span>';

          if($result->status_task == '1') {
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="2" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Pending</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Reject</a>';
          } else if($result->status_task == '2'){
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Pending</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Reject</a>';
          } else if($result->status_task == '3'){
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="2" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Reject</a>';
          } else {
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="2" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-tableid="'.$tableid.'" data-idtask="' . $result->id_task . '">Pending</a>';
          }


          $row[]  = '<div class="dropdown droptask" style="z-index:10000;">
          <button class="btn btn-sm btn-default dropdown-toggle rounded-pill" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ubah Status
          </button>
          <div class="dropdown-menu droptask-menu" aria-labelledby="dropdownMenuButton">
           '.$isitask.'
          </div>
        </div>
        <a href="' . base_url("task/editTask/") . $result->task_in . "/" . $result->id_task . "/" . $stateacctive . '" id="editbtn" class="btn btn-sm btn-warning rounded-pill">Edit</a>
        <button type="button" data-idtaskdelete="' .$result->id_task .'" class="btn btn-sm btn-danger hapustask rounded-pill">Hapus</button>
        ';

        
         
          $data[] = $row;
        }
  
        $output   = array(
          "draw"            => $_POST['draw'],
          "recordsTotal"    => $this->Space_model->count_all_datatask(),
          "recordsFiltered" => $this->Space_model->count_filtered_datatask(),
          "data"            => $data,
        );
  
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function loadTasksByComplateTable() {
        $result = $this->Space_model->getDatatask();
        $data   = [];
        $no     = $_POST['start'];
        $stateacctive  = $this->input->get('stateacctive');
  
        foreach ($result as $result) {
          $row    = array();
          $row[]  = date('j F Y', strtotime($result->create_date_task));
          $row[]  = date('j F Y', strtotime($result->overdue_task));

          if($result->classification_task != "NULL") {
            $type = $result->classification_task;
          } else {
            $type = $result->type_task;
          }

          $row[]  = $type;
          $row[]  = $result->name_task;

          $row[]  = $result->desc_task;

          $row[]  = $result->user_from_task;

          $id = $result->user_to_task;

          $users = $this->Account_model->getAccountById($id);

          $row[]  = $users['nama'];

          if($result->status_task == '1') {
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="2" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-idtask="' . $result->id_task . '">Pending</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-idtask="' . $result->id_task . '">Reject</a>';
          } else if($result->status_task == '2'){
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-idtask="' . $result->id_task . '">Pending</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-idtask="' . $result->id_task . '">Reject</a>';
          } else if($result->status_task == '3'){
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="2" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="4" data-idtask="' . $result->id_task . '">Reject</a>';
          } else {
            $isitask = '<a class="dropdown-item intask" href="#" data-sttask="1" data-idtask="' . $result->id_task . '">On Going</a>
            <a class="dropdown-item intask" href="#" data-sttask="2" data-idtask="' . $result->id_task . '">Complete</a>
            <a class="dropdown-item intask" href="#" data-sttask="3" data-idtask="' . $result->id_task . '">Pending</a>';
          }


          $row[]  = '<div class="dropdown">
          <button class="btn btn-sm btn-default dropdown-toggle rounded-pill" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ubah Status
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
           '.$isitask.'
          </div>
        </div>
        <a href="' . base_url("task/editTask/") . $result->task_in . "/" . $result->id_task . "/" . $stateacctive . '" id="editbtn" class="btn btn-sm btn-warning rounded-pill">Edit</a>';

        
         
          $data[] = $row;
        }
  
        $output   = array(
          "draw"            => $_POST['draw'],
          "recordsTotal"    => $this->Space_model->count_all_datatask(),
          "recordsFiltered" => $this->Space_model->count_filtered_datatask(),
          "data"            => $data,
        );
  
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    public function updateTaskStatus() {
        if (isset($_POST['id_task']) && isset($_POST['status_task'])) {
            $id_task = $this->input->post('id_task');
            $status_task = $this->input->post('status_task');

            $this->db->set('status_task', $status_task);
            $this->db->set('updated_task', getCurrentDate());
            $this->db->where('id_task', $id_task);
            $this->db->update('task');

            $mytask = $this->Space_model->checkMyTaskInOKR($id_task);

            $idokr  = $mytask['id_okr_inokr'];
            $type   = $mytask['type_taskokr'];

            if($type == 'initiative') {
                $ini = $this->Project_model->checkDataIni($idokr);
  
                $value = $ini['value_initiative'];
                $idkr = $ini['id_kr'];
  
                $this->db->set('comment', '<p><a target="_blank" href="'.base_url('document/documentAtSpace/').$idspace.'">"'.base_url('document/index/').$idspace.'/space</a></p>');
                $this->db->set('value_ach_initiative', $value);
                $this->db->set('value_percent', '100');
                $this->db->where('id_initiative', $idokr);
                $this->db->update('initiative');
  
                $this->updateOKR($idkr,$type);
             
              } else {
                $kr = $this->Project_model->checkKr($idokr);
  
                $value =  $kr['value_kr'];
  
                $this->db->set('description_kr', '<p><a target="_blank" href="'.base_url('document/documentAtSpace/').$idspace.'">"'.base_url('document/index/').$idspace.'/space</a></p>');
                $this->db->set('value_achievment', $value);
                $this->db->set('precentage', '100');
                $this->db->where('id_kr', $idokr);
                $this->db->update('key_result');

                $this->updateOKR($idokr,$type);
            }
            
                // Jika berhasil, kembalikan data baru untuk diperbarui di UI
                $color = ""; 
                $statusText = "";

                switch ($status_task) {
                    case 1:
                        $statusText = "On Going";
                        $color = "text-info";
                        break;
                    case 2:
                        $statusText = "Complete";
                        $color = "text-success";
                        break;
                    case 3:
                        $statusText = "Pending";
                        $color = "text-warning";
                        break;
                    case 4:
                        $statusText = "Reject";
                        $color = "text-danger";
                        break;
                }

                echo json_encode([
                    'status' => $statusText,
                    'color' => $color
                ]);
            
        }
    }

    public function updateOKR($idkr,$type){

        if($type != 'initiative') {
          $objective = $this->Project_model->checkOkr($idkr);

          $id_project = $objective['id_project'];
     
          $precen     = $this->Project_model->getPrecentage($idkr);
    
          $get_kr     = $this->Project_model->getTotalKr($idkr);
    
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
          $this->db->where('id_okr', $idkr);
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
    
        } else {
    
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
    
        $kr     = $this->Project_model->checkDataKrbyOKR($idkr);
    
        $idokr  = $kr['id_okr'];

        $objective = $this->Project_model->checkOkr($idokr);

        $id_project = $objective['id_project'];
       
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
    
        }
    
        return true;
      }

    public function editTask($idpj,$idtask)
    {
      $data['title']        = 'Detail Task';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $sesiworkspace = $this->session->userdata('workspace_sesi');
      
      $data['task']  = $this->Space_model->getTaskById($idtask);
      $data['users']  = $this->Team_model->getUserActiveInSpace($sesiworkspace);
      if($idpj == 0) {
        $data['mykey'] =  $this->Project_model->checkOneOKRbySpace($sesiworkspace);
      } else {
        $data['mykey'] =  $this->Project_model->checkOneOKRbyProject($idpj);
      }

      $type =  $data['task']['type_task'];
      
      if($type == "keyresult") {
        $data['typekey'] = "keyresult";
       
      } else if($type == "initiative") {
        $data['typekey'] = "initiative";

        $key =  $this->Project_model->checkByOneOKRbyProject($idpj);
        $ini = $key['id_kr'];

        $data['initiative'] = $this->Project_model->checkDataIni($ini);
        
      } else {
        $data['typekey'] = "private";
      }

      $this->load->view('template/header', $data);
    //   $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('task/edittask', $data);
      $this->load->view('template/footer');
    }

    public function editTaskInCalendar($idpj,$idtask,$idspace)
    {
      $data['title']        = 'Detail Task';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $sesiworkspace = $this->session->userdata('workspace_sesi');
      
      $data['task']  = $this->Space_model->getTaskById($idtask);
      $data['users']  = $this->Team_model->getUserActiveInSpace($sesiworkspace);

      if($idtask == 0) {
        $data['mykey'] =  $this->Project_model->checkOneOKRbySpace($sesiworkspace);
      } else {
        $data['mykey'] =  $this->Project_model->checkOneOKRbyProject($idpj);
      }

      $type =  $data['task']['type_task'];
      
      if($type == "keyresult") {
        $data['typekey'] = "keyresult";
       
      } else if($type == "initiative") {
        $data['typekey'] = "initiative";
        $key =  $this->Project_model->checkByOneOKRbyProject($idpj);
        $ini = $key['id_kr'];

        $data['initiative'] = $this->Project_model->checkDataIni($ini);
        
      } else {
        $data['typekey'] = "private";
      }

      $datalinkback = $this->uri->segment(5);

      if($datalinkback != '') {

      } else {

      }

      $this->load->view('template/header', $data);
    //   $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('task/edittaskcalendar', $data);
      $this->load->view('template/footer');
    }

    public function deleteTask(){
        $idtask = $this->input->post("taskId");

        $result = $this->Space_model->hapus_task($idtask);

        echo json_encode(['success' => true]);
     
    }

    public function editTaskAll()
    {
          $namataskpvt              = $this->input->post('namataskpvt');
          $overduepvt               = $this->input->post('overduepvt');
          $startpvt                 = $this->input->post('startpvt');
          $userselect               = $this->input->post('userselect');
          $describeprivate          = $this->input->post('describeprivate');
          $idtask                   = $this->input->post('idtask');
          $userid                   = $this->session->userdata('id');
          $idspace                  = $this->session->userdata('workspace_sesi');
          $classificationtask       = $this->input->post('classificationtask');
          $idprojecttask       = $this->input->post('idprjpvt');

          if($classificationtask == 'meeting') {
            $classificationtask = 'meeting';
            $type = 'taskmeeting';
            $type_task = 'meeting';
            $myurl = base_url("task/editTaskInCalendar/" . $idprojecttask .'/'.$idtask.'/'.$idspace);
            $text = $namataskpvt . ' Pada ' . $startpvt . ' - ' . $overduepvt;
          } else {
            $type_task = 'private';
            $type = 'task';
            $text = "";
          }

        
          $this->db->set('name_task', $namataskpvt);
          $this->db->set('type_task', $type_task);
          $this->db->set('classification_task', $classificationtask);
          $this->db->set('user_to_task', $userselect);
          $this->db->set('start_task', $startpvt);
          $this->db->set('overdue_task', $overduepvt);
          $this->db->set('desc_task', $describeprivate);
          $this->db->set('updated_task', getCurrentDate());
          $this->db->where('id_task', $idtask);
          $this->db->update('task');

          $data = array(
            'user_id'           => $userselect,
            'user_from'         => $userid,
            'space_from'        => $idspace,
            'title_notif'       => '[Telah di Edit]'. $namataskpvt,
            'message_notif'     => 'Telah di Edit di tanggal ' . $startpvt,
            'data_notif'        => json_encode(array('url'=>'','type'=>'','idtask'=>'')),
            'is_read_notif'     => 1,
            'created_at_notif'  => getCurrentDate(),
        );
    
        $this->Main_model->input($data, 'notification');


        $this->saveNotif($userselect,$type,$namataskpvt,$myurl,$text);
          

        echo json_encode(['success' => true]);
    }

    public function editTaskKey()
    {
        $userdata               = $this->session->userdata('username');
        $userid                 = $this->session->userdata('id');
        $idselected             = $this->input->post('idselected');
        $namaselected           = $this->input->post('namaselected');
        $namatask               = $this->input->post('namatask');
        $tanggalakhir           = $this->input->post('tanggalakhir');
        $tanggalawal            = $this->input->post('tanggalawal');
        $userselect             = $this->input->post('userselect');
        $idprojecttask          = $this->input->post('idprojecttask');
        $idtask                 = $this->input->post('id_task');
        $myurl                  = $this->input->post('myurl');
        $describeokr            = $this->input->post('describeokr');
        $idspace                = $this->session->userdata('workspace_sesi');
        $classificationtask     = $this->input->post('classificationtask');

        

        if($classificationtask == 'meeting') {
          $classificationtask = 'meeting';
          $type = 'taskmeeting';
          $type_task = 'meeting';
          $myurl = base_url("task/editTaskInCalendar/" . $idprojecttask .'/'.$idtask.'/'.$idspace);
          $text = $namatask . ' Pada ' . $tanggalawal . ' - ' . $tanggalakhir;
        } else {
          $type_task = 'private';
          $type = 'task';
          $text = "";
        }

        $userstask      = $this->Account_model->getAccountById($userid);
        $nama           = $userstask['nama'];

        
        $this->db->set('name_task', $namatask);
        $this->db->set('type_task', $type_task);
        $this->db->set('classification_task', $classificationtask);
        $this->db->set('id_task_from', $idselected);
        $this->db->set('user_to_task', $userselect);
        $this->db->set('overdue_task', $tanggalakhir);
        $this->db->set('start_task', $tanggalawal);
        $this->db->set('type_task', $namaselected);
        $this->db->set('desc_task', $describeokr);
        $this->db->set('updated_task', getCurrentDate());
        $this->db->where('id_task', $idtask);
        $this->db->update('task');


          $data = array(
            'user_id'           => $idselected,
            'user_from'         => $userid,
            'space_from'        => $idspace,
            'title_notif'       => '[Telah di Edit]'. $name_task,
            'message_notif'     => 'Telah di Edit di tanggal ' . $tanggalawal,
            'data_notif'        => json_encode(array('url'=>'','type'=>'','idtask'=>'')),
            'is_read_notif'     => 1,
            'created_at_notif'  => getCurrentDate(),
        );
    
        $this->Main_model->input($data, 'notification');

        $this->saveNotif($userselect,$type,$namatask,$myurl,$text);


        $this->session->set_flashdata('message', 'Task berhasil ditambahkan');
        redirect($myurl);
    }

    public function editTaskKeyCalendar()
    {
        $userdata       = $this->session->userdata('username');
        $userid         = $this->session->userdata('id');
        $idselected     = $this->input->post('idselected');
        $namaselected   = $this->input->post('namaselected');
        $namatask       = $this->input->post('namatask');
        $tanggalakhir   = $this->input->post('tanggalakhir');
        $userselect     = $this->input->post('userselect');
        $idspace        = $this->input->post('idspace');
        $idtask         = $this->input->post('id_task');
        
        $userstask      = $this->Account_model->getAccountById($userid);
        $nama           = $userstask['nama'];
          
         
          $this->db->set('id_task_from', $idselected);
          $this->db->set('user_to_task', $userselect);
          $this->db->set('overdue_task', $tanggalakhir);
          $this->db->set('desc_task', $namaselected);
          $this->db->set('updated_task', getCurrentDate());
          $this->db->where('id_task', $idtask);
          $this->db->update('task');

        $this->session->set_flashdata('message', 'Task berhasil ditambahkan');
        if($idspace == '') {
            redirect('calendar/viewall');
        } else {
            redirect('calendar/index/' . $idspace);
        }
        
    }

    public function saveTaskOKR($idkr,$idpjkr)
    {
        $userdata       = $this->session->userdata('username');
        $userid         = $this->session->userdata('id');
        $typetask       = $this->input->post('taskkey');
        $iduserto       = $this->input->post('usertask');
        $idokr          = $this->input->post('taskokr');
        $namakrtask          = $this->input->post('namakrtask');
    
        $userstask      = $this->Account_model->getAccountById($userid);
        $nama           = $userstask['nama'];

            $keyresult = $this->Project_model->checkDataKrbyOKR($idkr);

            $desc                = $keyresult['description_kr'];
            $namekr              = $keyresult['nama_kr'];
            $tanggalakhir        = $keyresult['due_datekey'];

            $data = array(
                'name_task'         => $namakrtask,
                'desc_task'         => $desc,
                'type_task'         => $typetask,
                'task_in'           => $idpjkr,
                'id_task_from'      => $idkr,
                'create_date_task'  => getCurrentDate(),
                'user_to_task'      => $iduserto,
                'user_from_task'    => $nama,
                'status_task'       => '1',
                'overdue_task'      => $tanggalakhir,
                'updated_task'      => getCurrentDate(),
            );

            $idtask = $this->Space_model->input_task($data);

            $data = array(
                'id_tk_inokr'         => $idtask,
                'id_okr_inokr'        => $idkr,
                'type_taskokr'        => $typetask,
                'created_date_inokr'  => getCurrentDate(),
            );

            $this->Space_model->input_space($data, 'task_in_okr');


         $this->session->set_flashdata('message', 'Task berhasil ditambahkan');
        redirect('project/showKey/' . $idpjkr . '/' . $idokr);
    }

    public function saveTaskIni()
    {
      
        $userdata       = $this->session->userdata('username');
        $userid         = $this->session->userdata('id');
        $typetask       = $this->input->post('tasktype');
        $namakrtaskini  = $this->input->post('namakrtaskini');
        $iduserto       = $this->input->post('usertaskini');
        $idokr          = $this->input->post('taskokr');
        $idpjkr         = $this->input->post('taskpj');
        $idini          = $this->input->post('taskini');
        $idspace        = $this->session->userdata('workspace_sesi');
    
        $userstask      = $this->Account_model->getAccountById($userid);
        $nama           = $userstask['nama'];


        $ini = $this->Project_model->checkDataIni($idini);

            $desc                = $ini['comment'];
            $nameini              = $ini['description'];
            $tanggalakhir        = $ini['due_dateinit'];

            if($tanggalakhir == NULL) {
                $tanggalakhir = date("Y-m-d 23:59:00");
            }

            $data = array(
                'name_task'         => $namakrtaskini,
                'desc_task'         => $desc,
                'type_task'         => $typetask,
                'task_in_space'     => $idspace,
                'task_in'           => $idpjkr,
                'id_task_from'      => $idini,
                'create_date_task'  => getCurrentDate(),
                'user_to_task'      => $iduserto,
                'user_from_task'    => $nama,
                'status_task'       => '1',
                'overdue_task'      => $tanggalakhir,
                'updated_task'      => getCurrentDate(),
            );

            $idtask = $this->Space_model->input_task($data);

            $data = array(
                'id_tk_inokr'         => $idtask,
                'id_okr_inokr'        => $idini,
                'type_taskokr'        => $typetask,
                'created_date_inokr'  => getCurrentDate(),
            );

            $this->Space_model->input_space($data, 'task_in_okr');

         $this->session->set_flashdata('message', 'Task berhasil ditambahkan');
        redirect('project/showKey/' . $idpjkr . '/' . $idokr);
    }


    public function moveToTask() {

        $idtask             = $this->input->post("idtaskokr");
        $idspacetask        = $this->input->post("idspacetask");
        $projectdoc         = $this->input->post("projectdoc");
       
        $this->db->set('task_in', $projectdoc);
        $this->db->where('id_task', $idtask);
        $this->db->update('task');
       
       redirect('task/index/'.$idspacetask.'/space');
      }

      public function userSchedule() {
        $userId     = $this->input->post('userId');
        $startDate  = $this->input->post('startDate');
        $endDate    = $this->input->post('endDate');
    
        // Query ke database untuk mengecek apakah user memiliki jadwal di rentang tanggal tersebut
        // Sesuaikan dengan tabel dan struktur database Anda
        $this->db->where('user_to_task', $userId);
        $this->db->where('start_task <=', $endDate);
        $this->db->where('overdue_task >=', $startDate);
        $query = $this->db->get('task');
    
        $hasSchedule = $query->num_rows() > 0;
    
        // Return JSON response
        $response = [
            'hasSchedule' => $hasSchedule,
            'userName' => $this->getUserName($userId)
        ];
    
        echo json_encode($response);
    }

    public function getUserName($userId){
        $userstask      = $this->Account_model->getAccountById($userId);
        $nama           = $userstask['nama'];

        return $nama;
    }

    public function showConnectOKR() {
        $taskFrom = $this->input->post('taskFrom');
        $tipeTask = $this->input->post('tipeTask');
    
        // Ambil data dari database berdasarkan taskFrom dan tipeTask
   
            if ($tipeTask == "keyresult") {
                $data = $this->Project_model->checkKr($taskFrom);

                $id = $data['id_okr'];

                $content = '<h3>Key Result'.$data['nama_kr'].'</h3>
                            <span class="text-success">'.$data['precentage'].' %</span>';

                $okr = $this->Project_model->checkOkr($id);
                
                $idokr = $id;
                $idpj  = $okr['id_project'];

            } else {
                $data = $this->Project_model->checkDataIni($taskFrom);


                $id = $data['id_kr'];

                $content = '<h3>Inisiative '.$data['description'].'</h3>
                            <span class="text-success">Progress <b>'.$data['value_percent'].' %</b></span>';

                $okr = $this->Project_model->checkKr($id);
                
                $idokr = $okr['id_okr'];
                

                $pj = $this->Project_model->checkOkr($idokr);

                $idpj  = $pj['id_project'];
            
            }

            $url = base_url()."project/showKey/".$idpj."/".$idokr;

            $button = '<br><a target="_blank" href="'.$url.'" type="button" class="btn btn-primary mt-3 rounded-pill">Lihat</a>';
    
            // Mengembalikan data dalam bentuk HTML
            echo $content . $button;
       
    }

    public function checkMyTask() {

        $idtask     = $this->input->post("idtask");

        $checkDoc   = $this->Space_model->checkDocInTask($idtask);

        $checkTask     = $this->Space_model->checkInTask($idtask);

        if($checkDoc) {
            $id = $checkDoc['document_id_in_task'];
            $typedoc = $checkDoc['type_doc_in_okr'];

            if($typedoc == '')

            $type = 'document';
        } else {
            $id = 'none';
            $type = 'none';
        }

        if($checkTask) {
            $id = $checkTask['id_tk_inokr'];
            $type = 'okr';


        } else {
            $id = 'none';
            $type = 'none';
        }


        $response = [
            'idintask' => $id,
            'typetask' => $type
        ];
    
        echo json_encode($response);

      }


}

    
