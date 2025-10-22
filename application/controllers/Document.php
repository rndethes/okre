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

  class Document extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Account_model');
      $this->load->model('Departement_model');
      $this->load->model('Archieve_model');
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
      $data['users']          = $this->Account_model->getJoinUsers();

      if($this->uri->segment(4) == "space") {
        $idspace   = $this->uri->segment(3);

        $data['space']          = $this->Space_model->checkSpaceById($idspace);
        
        $projectDelegasi        = $this->Project_model->getYourProjectDelegate($idspace);
   
        $projects               = $this->Project_model->getYourProjectNoLimit($idspace);
  
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
  
         $data['projectspace'] = $combinedData;


        $iduser = $this->session->userdata('id');
  
        $idprj  = $this->uri->segment(3);
        
  
        $documentsign       = $this->Space_model->dataMyDocumentInSpace($iduser,$idspace);
        $documentcreated    = $this->Space_model->dataMyDocumentAllInSpace($iduser,$idspace);
  
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
        
        $data['mydocument'] = $mydoc;

        $data['documentall'] = $this->Space_model->dataMyDocumentAllSpace($iduser,$idspace);

         
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('document/documentinspace', $data);
        $this->load->view('template/footer', $data);
       

      } else {
        $data['project']        = $this->Project_model->getProjectById($id);
        
        $idspace   =$this->session->userdata('workspace_sesi');

        $iduser = $this->session->userdata('id');
  
        $idprj  = $this->uri->segment(3);
  
        $documentsign       = $this->Space_model->dataMyDocument($iduser,$idprj);
        $documentcreated    = $this->Space_model->dataMyDocumentAll($iduser,$idprj);
  
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
        
        $data['mydocument'] = $mydoc;

        $data['documentall'] = $this->Space_model->dataMyDocumentAllSpace($iduser,$idspace);
  
        $iduser            = $this->session->userdata('id');
        $workspace_sesi    = $this->session->userdata('workspace_sesi');
        $delegasi          = $this->Project_model->cekDelegasi($iduser);
  
        $data['users']     = $this->Account_model->getAllUserActive();
  
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
  
        $this->load->view('template/header', $data);
       // $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/navbarproject', $data);
        $this->load->view('document/document', $data);
        $this->load->view('template/footer', $data);
      }
    }

    public function documentinput($id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $iduser = $this->session->userdata('id');

      $data['spaceteam']       = $this->Space_model->dataSpaceTeam($iduser);

      $wrsesi = $this->session->userdata('workspace_sesi');

      $project = $this->Space_model->getProjectsAccessByWorkspaceId($wrsesi);

      $data['key_result'] = array();
      $data['initiative'] = array();

      foreach($project as $pj){
        $idproject = $pj['id_project'];

        $okr = $this->Project_model->checkOKRbyProject($idproject);

        foreach($okr as $okr){
          $idokr = $okr['id_okr'];
          $namaokr = $okr['description_okr'];
          
          $key_result = $this->Project_model->checkKrbyOKR($idokr);

          foreach($key_result as $kr){
            $idkeyresult = $kr['id_kr'];
            $namakeyresult = $kr['nama_kr'];

            $data['key_result'][] = array(
              'idkeyresult' => $idkeyresult,
              'namakeyresult' => $namakeyresult,
              'namaokr' => $namaokr
            );

            $initiative = $this->Project_model->checkInisiative($idkeyresult);
            foreach($initiative as $ini) {
              $idini = $ini['id_initiative'];
              $namaini = $ini['description'];

              $data['initiative'][] = array(
                'idinitiative' => $idini,
                'namainitiative' => $namaini,
                'namakeyresult' => $namakeyresult
              );
            }
          }
        }
      }

      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentinput', $data);
      $this->load->view('template/footer', $data);
    }

    public function documentinputfromokr($id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $iduser = $this->session->userdata('id');
      $wrsesi = $this->session->userdata('workspace_sesi');

      $data['spaceteam']       = $this->Space_model->dataSpaceTeam($iduser);

      $data['mydocument']       = $this->Space_model->dataAllYourDocument($wrsesi);

    
      $project = $this->Space_model->getProjectsAccessByWorkspaceId($wrsesi);

      $data['key_result'] = array();
      $data['initiative'] = array();

      foreach($project as $pj){
        $idproject = $pj['id_project'];

        $okr = $this->Project_model->checkOKRbyProject($idproject);

        foreach($okr as $okr){
          $idokr = $okr['id_okr'];
          $namaokr = $okr['description_okr'];
          
          $key_result = $this->Project_model->checkKrbyOKR($idokr);

          foreach($key_result as $kr){
            $idkeyresult = $kr['id_kr'];
            $namakeyresult = $kr['nama_kr'];

            $data['key_result'][] = array(
              'idkeyresult' => $idkeyresult,
              'namakeyresult' => $namakeyresult,
              'namaokr' => $namaokr
            );

            $initiative = $this->Project_model->checkInisiative($idkeyresult);
            foreach($initiative as $ini) {
              $idini = $ini['id_initiative'];
              $namaini = $ini['description'];

              $data['initiative'][] = array(
                'idinitiative' => $idini,
                'namainitiative' => $namaini,
                'namakeyresult' => $namakeyresult
              );
            }
          }
        }
      }

      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentinputfromokr', $data);
      $this->load->view('template/footer', $data);
    }


    public function newdocumentinput($id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $iduser = $this->session->userdata('id');

      $data['spaceteam']       = $this->Space_model->dataSpaceTeam($iduser);

      $wrsesi = $this->session->userdata('workspace_sesi');

      $project = $this->Space_model->getProjectsAccessByWorkspaceId($wrsesi);

      $data['key_result'] = array();
      $data['initiative'] = array();

      foreach($project as $pj){
        $idproject = $pj['id_project'];

        $okr = $this->Project_model->checkOKRbyProject($idproject);

        foreach($okr as $okr){
          $idokr = $okr['id_okr'];
          $namaokr = $okr['description_okr'];
          
          $key_result = $this->Project_model->checkKrbyOKR($idokr);

          foreach($key_result as $kr){
            $idkeyresult = $kr['id_kr'];
            $namakeyresult = $kr['nama_kr'];

            $data['key_result'][] = array(
              'idkeyresult' => $idkeyresult,
              'namakeyresult' => $namakeyresult,
              'namaokr' => $namaokr
            );

            $initiative = $this->Project_model->checkInisiative($idkeyresult);
            foreach($initiative as $ini) {
              $idini = $ini['id_initiative'];
              $namaini = $ini['description'];

              $data['initiative'][] = array(
                'idinitiative' => $idini,
                'namainitiative' => $namaini,
                'namakeyresult' => $namakeyresult
              );
            }
          }
        }
      }

      $data['pengajuan_data']   = $this->session->userdata('pengajuan_data');

      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentinputnew', $data);
      $this->load->view('template/footer', $data);
    }



    public function tambahDocument($id) {

      $namedoc             =  $this->input->post('namadocument');
      $filesdoc            = $_FILES['input_document'];
      $namafolder          = checkSpace($id);

      $tipe              = $this->input->post('add_to_initiative');

      $tipeokr           = $this->input->post('tipeokr');
      $myokr             = $this->input->post('myokr');

      $describeokr       = $this->input->post('describeokr');


     if($tipe == 'yes') {
      
     } else {
      if($id == "space") {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
           
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = "0";
        }
      } else {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = $this->input->post('okr'); 
        }
      }

      // exit();

      if ($filesdoc) {
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = '50000';
        $config['upload_path']   = './assets/document/' . $namafolder;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('input_document')) {
          $new_image = $this->upload->data('file_name');
        } else {
          $error_msg = strip_tags($this->upload->display_errors());
          $this->session->set_flashdata('error', 'Upload gagal: ' . $error_msg);
          redirect("document/documentinput/" . $id);
       
          return; // hentikan proses jika gagal upload
        }
      }
       // Prepare data for insertion
                $data = array(
                    'name_document'     => $this->input->post('namadocument'),
                    'id_space'          => $this->input->post('space'),
                    'id_project'        => $pj,
                    'type_document'     => $this->input->post('jenisdocument'),
                    'file_document'     => $new_image,
                    'id_user_create'    => $this->session->userdata('id'),
                    'note_from_created' => $describeokr,
                    'id_project'        => $pj,
                    'status_document'   => '1',
                    'created_date'      => date('Y-m-d H:i:s'),
                );

                // Insert document data into the database
                $insert_id = $this->Main_model->insert_document($data);

               
                if ($insert_id) {
                    $this->session->set_flashdata('message', 'Dokumen berhasil ditambahkan');

                    if($tipeokr != "" || $myokr != "") {
                      if($tipeokr == 'inisiative') {
                        $this->db->set('comment', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_initiative', $myokr);
                        $this->db->update('initiative');
                      } else {
                        $this->db->set('description_kr', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_kr', $myokr);
                        $this->db->update('key_result');
                      }

                      $data = array(
                        'type_doc_in_okr'     => $tipeokr,
                        'id_from_doc_in_okr'  => $insert_id,
                        'id_to_doc_in_okr'    => $myokr,
                        'url_doc_in_okr'      => base_url("document/index/") . $this->session->userdata("workspace_sesi") . "/space",
                      );
              
                      // Insert document data into the database
                      $this->Main_model->input($data,'document_in_okr');
              
                    } 
            
                    if($id == "space") {
                      $idspace   = $this->session->userdata('workspace_sesi');
                      redirect('document/index/' . $idspace . '/' .$id);
                    } else {
                      redirect('document/index/' . $id);
                    }
                  
                } else {
                    $data['error'] = 'Terjadi kesalahan saat menyimpan data dokumen';
                    redirect("document/documentinput/" . $id);
                }
              }
            
    }

    public function tambahDocumentNew($id) {

      $namedoc             =  $this->input->post('namadocument');
      $namafolder          = checkSpace($id);

      $nama_file             =  $this->input->post('nama_doc');

      $tipe             = $this->input->post('add_to_initiative');

      $tipeokr           = $this->input->post('tipeokr');
      $myokr             = $this->input->post('myokr');
 

     if($tipe == 'yes') {
      
     } else {
      if($id == "space") {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
           
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = "0";
        }
      } else {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = $this->input->post('okr'); 
        }
      }
       // Prepare data for insertion
                $data = array(
                    'name_document'     => $this->input->post('namadocument'),
                    'id_space'          => $this->input->post('space'),
                    'id_project'        => $pj,
                    'type_document'     => $this->input->post('jenisdocument'),
                    'file_document'     => $nama_file,
                    'id_user_create'    => $this->session->userdata('id'),
                    'status_document'   => '1',
                    'created_date'      => date('Y-m-d H:i:s'),
                );

                // Insert document data into the database
                $insert_id = $this->Main_model->insert_document($data);

               
                if ($insert_id) {
                    $this->session->set_flashdata('message', 'Dokumen berhasil ditambahkan');

                    if($tipeokr != "" || $myokr != "") {
                      if($tipeokr == 'inisiative') {
                        $this->db->set('comment', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_initiative', $myokr);
                        $this->db->update('initiative');
                      } else {
                        $this->db->set('description_kr', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_kr', $myokr);
                        $this->db->update('key_result');
                      }

                      $data = array(
                        'type_doc_in_okr'     => $tipeokr,
                        'id_from_doc_in_okr'  => $insert_id,
                        'id_to_doc_in_okr'    => $myokr,
                        'url_doc_in_okr'      => base_url("document/index/") . $this->session->userdata("workspace_sesi") . "/space",
                      );
              
                      // Insert document data into the database
                      $this->Main_model->input($data,'document_in_okr');
              
                    } 
            
                    if($id == "space") {
                      $idspace   = $this->session->userdata('workspace_sesi');
                      redirect('document/index/' . $idspace . '/' .$id);
                    } else {
                      redirect('document/index/' . $id);
                    }
                  
                } else {
                    $data['error'] = 'Terjadi kesalahan saat menyimpan data dokumen';
                    redirect("document/documentinput/" . $id);
                }
              }
            
    }

    public function tambahDocumentFromOkr($id) {

      $namedoc             =  $this->input->post('namadocument');
      $namafolder          = checkSpace($id);

      $nama_file          =  $this->input->post('nama_doc');
      $content            =  $this->input->post('content');

      $tipe              = $this->input->post('add_to_initiative');

      $tipeokr           = $this->input->post('tipeokr');
      $myokr             = $this->input->post('myokr');
 

     if($tipe == 'yes') {
      
     } else {
      if($id == "space") {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
           
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = "0";
        }
      } else {
        if($tipeokr != "" || $myokr != "") {
          if($tipeokr == 'key') {
            $kr = $this->Project_model->checkKr($myokr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          } else {
            $ini = $this->Project_model->checkDataIni($myokr);
            $idkr = $ini['id_kr'];

            $kr = $this->Project_model->checkKr($idkr);

            $idokr =  $kr['id_okr'];

            $cekmyokr = $this->Project_model->checkOkr($idokr);

            $pj =  $cekmyokr['id_project'];
          }
        } else {
          $pj = $this->input->post('okr'); 
        }
      }
          $this->load->library('pdf');  // Load library PDF

          $html_content = "";
          $html_content .= $content;  // Tambahkan konten HTML

          $namadocnew = str_replace(' ', '_', $nama_file);

          // Konversi HTML menjadi PDF
          $pdf_output = $this->pdf->create_pdf($html_content, $namadocnew, FALSE);

          $pdf_path = './assets/document/' . $namafolder . '/' . $namadocnew . '.pdf';
          file_put_contents($pdf_path, $pdf_output);

        // Prepare data for insertion
                $data = array(
                    'name_document'     => $this->input->post('namadocument'),
                    'id_space'          => $this->input->post('space'),
                    'id_project'        => $pj,
                    'type_document'     => $this->input->post('jenisdocument'),
                    'file_document'     => $namadocnew . '.pdf',
                    'id_user_create'    => $this->session->userdata('id'),
                    'status_document'   => '1',
                    'created_date'      => date('Y-m-d H:i:s'),
                );

                // Insert document data into the database
                $insert_id = $this->Main_model->insert_document($data);

               
                if ($insert_id) {
                    $this->session->set_flashdata('message', 'Dokumen berhasil ditambahkan');

                    if($tipeokr != "" || $myokr != "") {
                      if($tipeokr == 'inisiative') {
                        $this->db->set('comment', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_initiative', $myokr);
                        $this->db->update('initiative');
                      } else {
                        $this->db->set('description_kr', '<a href="'.base_url("document/seedocument/"). $insert_id.'">'.$namedoc.'</a>');
                        $this->db->where('id_kr', $myokr);
                        $this->db->update('key_result');
                      }

                      $data = array(
                        'type_doc_in_okr'     => $tipeokr,
                        'id_from_doc_in_okr'  => $insert_id,
                        'id_to_doc_in_okr'    => $myokr,
                        'url_doc_in_okr'      => base_url("document/index/") . $this->session->userdata("workspace_sesi") . "/space",
                      );
              
                      // Insert document data into the database
                      $this->Main_model->input($data,'document_in_okr');
              
                    } 
            
                    if($id == "space") {
                      $idspace   = $this->session->userdata('workspace_sesi');
                      redirect('document/index/' . $idspace . '/' .$id);
                    } else {
                      redirect('document/index/' . $id);
                    }
                  
                } else {
                    $data['error'] = 'Terjadi kesalahan saat menyimpan data dokumen';
                    redirect("document/documentinput/" . $id);
                }
              }
            
    }

    public function getSpaceProjects($id_space)
    {
        $id_user = $this->session->userdata('id'); // Asumsikan user ID disimpan di session
        $projects = $this->Space_model->dataSpaceProject($id_user, $id_space);
        echo json_encode($projects);
    }

    public function editdocument($idpj,$id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['users']          = $this->Account_model->getALLUsers();

      $data['space']          = $this->Space_model->checkSpaceById($id);
      $data['useratteam']     = $this->Space_model->checkUserAtTeam($id);

      if($idpj == "space") {
        $data['mydocument']     = $this->Space_model->dataMyDocumentByIdInSpace($id);
      } else {
        $data['mydocument']     = $this->Space_model->dataMyDocumentById($id);
      }

      $data['okrdoc'] = $this->Space_model->checkDocInOKR($id);
     
  
      $idspace = $data['mydocument']['id_space'];

      $iduser = $this->session->userdata('id');

      $data['spaceuser']       = $this->Space_model->dataMySpaceUser($idspace,$iduser);

      $data['namafolder'] = checkSpace($idpj);

   
      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentedit', $data);
      $this->load->view('template/footer', $data);
    }

    public function revisidocument($idpj,$id)
    {
      $data['title']           = 'Data Dokumen';
      $data['users_name']      = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['users']           = $this->Account_model->getALLUsers();
      $data['space']           = $this->Space_model->checkSpaceById($id);
      $data['useratteam']      = $this->Space_model->checkUserAtTeam($id);

      if($idpj == "space") {
        $doc     = $this->Space_model->dataMyDocumentByIdInSpace($id);
        if($doc['id_project'] == '0') {
          $data['mydocument']     =$this->Space_model->dataMyDocumentByIdInSpace($id);
        } else {
          $data['mydocument']     = $this->Space_model->dataMyDocumentById($id);

        }
      } else {
        $data['mydocument']     = $this->Space_model->dataMyDocumentById($id);
      }

      $data['lasdoc']   = $this->Space_model->dataLastDocument($id);

      $idspace = $data['mydocument']['id_space'];

      $iduser  = $this->session->userdata('id');

      $data['spaceuser']   = $this->Space_model->dataMySpaceUser($idspace,$iduser);
      

      $datasignature  = $this->Space_model->dataSignature($id);


      $data['namafolder'] = checkSpace($idpj);


      $datasign = $this->Space_model->dataLastDocument($id);

      $note       = $this->Space_model->checkDataDocumentAll($id);

      if(empty($datasign)) {
        $data['file'] = $data['mydocument']['file_document'];
        $data['note'] = $note['note_signature'];
      } else {
        $datalast  = $this->Space_model->dataLastDocumentByNo($id);
        $data['file'] = $datalast['file_signature'];
        $data['note'] = $note['note_signature'];
      }

      $data['datasignature'] = array_map(function($users) {
        return [
            'id' => $users['id_user_doc'],
            'order' => $users['no_signature'],
            'name' => $users['nama'],
        ];
        }, $datasignature);

      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentrevisi', $data);
      $this->load->view('template/footer', $data);
    }

      public function editDocumentSignature() {
        $id_document  = $this->input->post('id_document');
        $namadokumen  = $this->input->post('namadokumen');
        $typedokumen  = $this->input->post('work_status');
        $space        = $this->input->post('space');
        $project      = $this->input->post('project');
        $idproject    = $this->input->post('idproject');
        $datesign     = $this->input->post('tanggaltandatangan');
        $myurl        = $this->input->post('myurl');
        $statusdoc    = $this->input->post('statusdoc');
        $idspace      = $this->session->userdata('workspace_sesi');
        $describeokr  = $this->input->post('describeokr');
    
        $myid = $this->session->userdata('id');
    
        $usersacc = $this->Account_model->getAccountById($myid);
        $nama = $usersacc['nama'];
    
        // Handle document signatures
        $signatures = $this->input->post('signatures'); // This will be a JSON string

        $signaturesArray = json_decode($signatures, true);

        if (empty($signaturesArray)) {
            $this->session->set_flashdata('error', 'No signatures provided.');
            redirect('document/editdocument/' . $statusdoc .'/'.$id_document);
        } else {
            // Memulai transaction
            $this->db->trans_start();
    
            // Update document details
            $data = [
                  'name_document' => $namadokumen,
                  'type_document' => $typedokumen,
                  'note_from_created' => $describeokr,
                  'status_document' => '2'
              ];

    
           $this->Space_model->updateDocument($id_document, $data);
    
           //Delete existing signatures
           $this->Space_model->deleteDocumentSignatures($id_document);
          
            // Insert new signatures
            foreach ($signaturesArray as $sign) {
                $signatureData = [
                    'no_signature'      => $sign['order'],
                    'id_document_users' => $id_document,
                    'id_user_doc'       => $sign['id'],
                    'status_signature'  => '1',
                    'created_date'      => getCurrentDate(),
                ];
                $this->Space_model->insertDocumentSignature($signatureData);

                $usersdoc = $this->Account_model->getAccountById($sign['id']);
                $namaInDoc = $usersdoc['nama'];
                
                $datats = array(
                  'name_task'           => $namadokumen . ' Untuk Di Tanda Tangani ' . $namaInDoc,
                  'desc_task'           => '<p><a href="'.base_url('document/showDocument/').$id_document.'">'.base_url('document/showDocument/').$id_document.'</a></p>',
                  'type_task'           => 'private',
                  'classification_task' => 'document',
                  'task_in_space'       => $idspace,
                  'task_in'             => $idproject,
                  'id_task_from'        => 0,
                  'create_date_task'    => getCurrentDate(),
                  'user_to_task'        => $sign['id'],
                  'user_from_task'      => $nama,
                  'status_task'         => '1',
                  'start_task'          => $datesign,
                  'overdue_task'        => date("Y-m-d 23:59:59"),
                  'created_by_task'     => $myid,
                  'updated_task'        => getCurrentDate(),
              );
      
              $insert_id = $this->Space_model->insert_task($datats);

              $datatask = array(
                'task_id'                   => $insert_id,
                'document_id_in_task'       => $id_document,
                'user_doc_in_task'          => $sign['id'],
                'created_date_doc_in_task'  => getCurrentDate(),
              );
      
             // Pengecekan sebelum insert
            $is_exists = $this->Main_model->is_record_exists('document_in_task', $datatask);
            if (!$is_exists) {
                $this->Main_model->input($datatask, 'document_in_task');
            }
          }
           // Menyelesaikan transaction
           $this->db->trans_complete();

          if ($this->db->trans_status() === TRUE) {
      
              $log = [
                  'id_doc_signature'              => $id_document,
                  'id_user_log_document'          => $myid,
                  'nama_log'                      => $usersacc['nama'],
                  'keterangan_document_signature' => 'Created By ',
                  'status_log'                    => '5',
                  'updated_date_doc_signature'    => getCurrentDate(), 
              ];
      
              $this->Space_model->insertLogSignature($log);
              $status = "first";

              $type = 'documentbaru';

              $this->saveNotifMultiple($id_document,$type,$namadokumen,$myurl);

              $this->send_email($id_document, $nama, $status);
            
              
              if($statusdoc == 'space') {
                redirect('document/index/' . $this->session->userdata("workspace_sesi") . '/space');
              } else {
                redirect('document/index/' . $idproject);
              }
              
            } else {
                // Jika GAGAL, semua perubahan di database akan dibatalkan.
                $this->session->set_flashdata('error', 'Gagal memperbarui dokumen, terjadi kesalahan pada database.');
                redirect('document/editdocument/' . $statusdoc .'/'.$id_document);
            }
        }
    }

    public function saveDocumentKey($idkr,$idpjkr){
         
       $iddoc = $this->input->post("mydocument");
       $tipeokr = $this->input->post("dockey");
       $docokr = $this->input->post("docokr");

       $data = array(
        'type_doc_in_okr'     => 'key',
        'id_from_doc_in_okr'  => $iddoc,
        'id_to_doc_in_okr'    => $idkr,
        'url_doc_in_okr'      => base_url("document/index/") . $this->session->userdata("workspace_sesi") . "/space",
      );

      // Insert document data into the database
      $this->Main_model->input($data,'document_in_okr');

      $checkDoc = $this->Space_model->checkFile($iddoc);

      $checkSign = $this->Space_model->documentSign($iddoc);

      foreach($checkSign as $cd) {
        $namadokumen = $checkDoc['name_document'];

        $idspace = $this->session->userdata("workspace_sesi");

        $usersdoc = $this->Account_model->getAccountById($cd['id_user_doc']);
        $namaInDoc = $usersdoc['nama'];


        $myid = $this->session->userdata('id');
    
        $usersacc = $this->Account_model->getAccountById($myid);
        $nama = $usersacc['nama'];


        $data = array(
          'name_task'           => $namadokumen . ' Untuk Di Tanda Tangani ' . $namaInDoc,
          'desc_task'           => '<p><a href="'.base_url('document/index/').$idspace.'/space">'.base_url('document/index/').$idspace.'/space</a></p>',
          'type_task'           => 'private',
          'classification_task' => 'document',
          'task_in_space'       => $idspace,
          'task_in'             => $idpjkr,
          'id_task_from'      => 0,
          'create_date_task'  => getCurrentDate(),
          'user_to_task'      => $cd['id_user_doc'],
          'user_from_task'    => $nama,
          'status_task'       => '1',
          'start_task'        => getCurrentDate(),
          'overdue_task'      => date("Y-m-d 23:59:59"),
          'created_by_task'   => $myid,
          'updated_task'      => getCurrentDate(),
        );

        $insert_id = $this->Space_model->insert_task($data);

        $data = array(
          'document_id_in_task'       => $iddoc,
          'task_id'                   => $insert_id,
          'user_doc_in_task'          => $cd['id_user_doc'],
          'created_date_doc_in_task'  => date("Y-m-d H:i:s"),
        );

        // Insert document data into the database
        $this->Main_model->input($data,'document_in_task');
      }

      redirect("project/showKey/" .$idpjkr."/".$docokr);

    }

    public function saveDocumentIni(){
         
      $iddoc    = $this->input->post("mydocumentini");
      $tipeokr  = $this->input->post("doctype");
      $idokr    = $this->input->post("docokr");
      $idpj     = $this->input->post("docpj");
      $idini    = $this->input->post("docini");

      $data = array(
       'type_doc_in_okr'     => 'initiative',
       'id_from_doc_in_okr'  => $iddoc,
       'id_to_doc_in_okr'    => $idini,
       'url_doc_in_okr'      => base_url("document/index/") . $this->session->userdata("workspace_sesi") . "/space",
     );

     // Insert document data into the database
     $this->Main_model->input($data,'document_in_okr');

     $checkDoc = $this->Space_model->checkFile($iddoc);

     $checkSign = $this->Space_model->documentSign($iddoc);

     foreach($checkSign as $cd) {
       $namadokumen = $checkDoc['name_document'];

       $idspace = $this->session->userdata("workspace_sesi");

       $usersdoc = $this->Account_model->getAccountById($cd['id_user_doc']);
       $namaInDoc = $usersdoc['nama'];


       $myid = $this->session->userdata('id');
   
       $usersacc = $this->Account_model->getAccountById($myid);
       $nama = $usersacc['nama'];


       $data = array(
         'name_task'         => $namadokumen . ' Untuk Di Tanda Tangani ' . $namaInDoc,
         'desc_task'         => '<p><a href="'.base_url('document/index/').$idspace.'/space">'.base_url('document/index/').$idspace.'/space</a></p>',
         'type_task'         => 'private',
         'classification_task' => 'document',
         'task_in_space'     => $idspace,
         'task_in'           => $idpj,
         'id_task_from'      => 0,
         'create_date_task'  => date("Y-m-d H:i:s"),
         'user_to_task'      => $cd['id_user_doc'],
         'user_from_task'    => $nama,
         'status_task'       => '1',
         'start_task'        => date("Y-m-d H:i:s"),
         'overdue_task'      => date("Y-m-d 23:59:59"),
         'created_by_task'   => $myid,
         'updated_task'      => date("Y-m-d H:i:s"),
       );

       $insert_id = $this->Space_model->insert_task($data);

       $data = array(
         'document_id_in_task'       => $iddoc,
         'task_id'                   => $insert_id,
         'user_doc_in_task'          => $cd['id_user_doc'],
         'created_date_doc_in_task'  => date("Y-m-d H:i:s"),
       );

       // Insert document data into the database
       $this->Main_model->input($data,'document_in_task');
     }

     redirect("project/showKey/" .$idpj."/".$idokr);

   }

    public function saveNotifMultiple($id,$type,$text,$myurl){
      $myid = $this->session->userdata('id');
      $account = $this->Account_model->getAccountById($myid);
      $namafrom = $account['nama'];
      if($type == 'documentbaru') {
        $title = "Document Baru From " . $namafrom;
      } else if($type == 'documentsimpan') {
        $title = "Document Disetujui Oleh " . $namafrom;
      }  else if($type == 'documentreject') {
        $title = "Document Ditolak Oleh " . $namafrom;
      }  else if($type == 'documentrevisi') {
        $title = "Document Direvisi Oleh " . $namafrom;
      }
     

      $signDocument = $this->Space_model->documentSign($id);

      foreach($signDocument as $sd) {
        $workspace_sesi    = $this->session->userdata('workspace_sesi');
        $data = array(
          'user_id'           => $sd['id_user_doc'],
          'user_from'         => $myid,
          'space_from'        => $workspace_sesi,
          'title_notif'       => $title,
          'message_notif'     => $text,
          'data_notif'        => json_encode(array('url'=>$myurl)),
          'is_read_notif'     => 1,
          'created_at_notif'  => date("Y-m-d H:i:s"),
        );
  
      $this->Main_model->input($data, 'notification');
      
      $accounttokens = $this->Account_model->getAccountById($sd['id_user_doc']);
      $tokens = $accounttokens['token_users'];

      if($tokens == '') {
        $tokens == NULL;
      }
  
      $data = array(
          'user_id_notif_token'     => $sd['id_user_doc'],
          'token_notif_token'       => $tokens,
          'created_at_notif_token'  => date("Y-m-d H:i:s"),
      );
  
      $this->Main_model->input($data, 'notification_tokens');
      }
      
  
      try {
          $accessToken = getAccessToken();
          $response    = sendMessageMultiple($accessToken, $id, $title, $text,$myurl);
          echo 'Message sent successfully: ' . print_r($response, true);
      } catch (Exception $e) {
          echo 'Error: ' . $e->getMessage();
      }
     
    }
  
      public function revisiDocumentSignature() {
        $id_document  = $this->input->post('id_document');
        $namadokumen  = $this->input->post('namadokumen');
        $typedokumen  = $this->input->post('work_status');
        $idproject    = $this->input->post('idproject');
        $myurl        = $this->input->post('myurl');
        $oldfile      = $this->input->post('oldfile');
        $describeokr  = $this->input->post('describeokr');
        $namefile     = $this->input->post('namefile');
        $docurl       = $this->input->post('docurl');

        if($idproject == '0') {
          $idpj = "space";
          $namafolder = checkSpace($idpj);
        } else {
          $checkpj = $this->Space_model->cekProjecteDoc($id_document);
          $idpj   = $checkpj['id_project'];
          $namafolder = checkSpace($idpj);
        }

        $urlindata = base_url("/assets/document/") .$namafolder.'/'. $namefile;

        if($docurl != $urlindata) {
          $filesdoc            = $_FILES['filesign'];
          $old_file_name = $oldfile; // Sesuaikan dengan nama kolom pada database
          // Path lengkap file lama
          $old_file_path = './assets/document/' . $namafolder . '/' . $old_file_name;
          // Hapus file lama jika ada
          if (file_exists($old_file_path)) {
              unlink($old_file_path);
          }

  
          if ($filesdoc) {
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = '50000';
            $config['upload_path']   = './assets/document/' . $namafolder;
  
            $this->load->library('upload', $config);
  
            if ($this->upload->do_upload('filesign')) {
              $new_image = $this->upload->data('file_name');
            } else {
                $error_msg = strip_tags($this->upload->display_errors());
                $this->session->set_flashdata('error', 'Upload gagal: ' . $error_msg);
                redirect("document/revisidocument/space/" . $id_document);
             
                return; // hentikan proses jika gagal upload
            }
          }

          if($new_image) {
            $checkData = $this->Space_model->checkDataDocumentAll($id_document);
  
            $nosign    = $checkData['no_signature'];
            
            $cekuserSign = $this->Space_model->checkNoSign($id_document,$nosign);
  
            $count = count($cekuserSign);
  
            if($count > 1) {
              foreach($cekuserSign as $css) {
                if($css['status_signature'] != '5') {
                  $this->db->set('status_signature', '1');
                  $this->db->set('note_signature', "Revisi");
                  $this->db->set('file_signature', $new_image);
                  $this->db->where('id_doc_signature', $css['id_doc_signature']);
                  $this->db->update('document_signature');
                }
              }
            } else {
              $data = [
                'file_document'     => $new_image,
                'note_from_created' => $describeokr,
                'status_document'   => '6'
            ];
            $this->Space_model->updateDocument($id_document, $data);
            }  
          }

        } else {
          $checkData = $this->Space_model->checkDataDocumentAll($id_document);
  
          $nosign    = $checkData['no_signature'];
            
          $cekuserSign = $this->Space_model->checkNoSign($id_document,$nosign);
  
          $count = count($cekuserSign);

          if($count > 1) {
            foreach($cekuserSign as $css) {
              if($css['status_signature'] != '5') {
                $this->db->set('status_signature', '1');
                $this->db->set('note_signature', "Revisi");
                $this->db->set('file_signature', $namefile);
                $this->db->where('id_doc_signature', $css['id_doc_signature']);
                $this->db->update('document_signature');
              }
            }
          } else {
            $data = [
              'file_document'     => $namefile,
              'note_from_created' => $describeokr,
              'status_document'   => '6'
          ];
          $this->Space_model->updateDocument($id_document, $data);
          }  

        }

        $myid = $this->session->userdata('id');

        $usersacc       = $this->Account_model->getAccountById($myid);

        // Handle document signatures
        $signatures = $this->input->post('signatures'); // This will be a JSON string

        if (!empty($signatures)) {
            $signaturesArray = json_decode($signatures, true);
            // Insert new signatures
            foreach ($signaturesArray as $sg) {
              $checkArray = $this->Space_model->checkDataDocument($sg['order'], $sg['id'],$id_document);
              
              if (empty($checkArray)) {
                  $signatureData = [
                    'no_signature'      => $sg['order'],
                    'id_document_users' => $id_document,
                    'id_user_doc'       => $sg['id'],
                    'status_signature'  => '1',
                    'created_date'      => date("Y-m-d H:i:s"),
                    
                ];
                $this->Space_model->insertDocumentSignature($signatureData);
              }
            }
        }

        $data = [
          'name_document'     => $namadokumen,
          'type_document'     => $typedokumen,
          'note_from_created' => $describeokr,
          'status_document'   => '6'
        ];

        $this->Space_model->updateDocument($id_document, $data);

        $log = [
          'id_doc_signature'              => $id_document,
          'id_user_log_document'          => $myid,
          'nama_log'                      => $usersacc['nama'],
          'keterangan_document_signature' => 'Revisi By ',
          'status_log'                    => '4',
          'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
        ];

        $this->Space_model->insertLogSignature($log);

        if($myurl == 'space') {
          redirect("/document/index/" . $this->session->userdata('workspace_sesi') . "/space");
        } else {
          redirect('document/index/' . $idproject);
        }
       
    }

    public function showDocument($id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

      $data['signaturelog']   = $this->Space_model->dataLogDoc($id);

      $iduser = $this->session->userdata('id');

      $checkall = $this->Space_model->checkAllSignatureFile($id);

      $checkpj = $this->Space_model->cekProjecteDoc($id);

      $data['okrdoc'] = $this->Space_model->checkDocInOKR($id);
    
      if($checkpj['id_project'] == 0) {
        $idpj   = "space";
      } else {
        $idpj   = $checkpj['id_project'];
      }

      $data['namafolder'] = checkSpace($idpj);


      if(empty($checkall)) {
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentFinishSpaceById($id);
        } else {
          $data['document']       = $this->Space_model->dataShowDocumentFinishById($id);
        }

        $checklast              = $this->Space_model->checkLastDocument($id);
  
        $data['lastdoc']        = $checklast['file_signature'];

      } else {
        $cekdoc           = $this->Space_model->checkDoc($id);
        $idproject        = $cekdoc['id_project'];

       

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceById($id,$iduser);

        } else {
          $data['document']       = $this->Space_model->dataShowDocumentById($id,$iduser);
        }

        $checklogview           = $this->Space_model->checkLogById($id,$iduser);

        $data['usersacc']       = $this->Account_model->getAccountById($iduser);
  
        $data['lastdoc']        = '';

      
       
        if(empty($checklogview)) {
          $log = [
            'id_doc_signature'              => $id,
            'id_user_log_document'          => $iduser,
            'nama_log'                      => $data['usersacc']['nama'],
            'keterangan_document_signature' => 'View by ',
            'status_log'                    => '1',
            'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
          ];
    
          $this->Space_model->insertLogSignature($log);
        } 
      }

      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/showdocument', $data);
      $this->load->view('template/footer', $data);
    }
    public function previewDocument($id)
    {
      $data['title']          = 'Data Dokumen';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

      $data['signaturelog']   = $this->Space_model->dataLogDoc($id);

      $iduser = $this->session->userdata('id');

      $checkall = $this->Space_model->checkAllSignatureFile($id);

      $checkpj = $this->Space_model->cekProjecteDoc($id);

      $data['okrdoc'] = $this->Space_model->checkDocInOKR($id);

   

      
      if($checkpj['id_project'] == 0) {
        $idpj   = "space";
      } else {
        $idpj   = $checkpj['id_project'];
      }
    

      $data['namafolder'] = checkSpace($idpj);

      if(empty($checkall)) {
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];
        

        if($idproject == 0) {
          
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
        } else {
         
    

          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
        }

        $checklast              = $this->Space_model->checkLastDocument($id);
  
        $data['lastdoc']        = $checklast['file_signature'];

      } else {

      
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {

          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
        } else {
          
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
        }

       
        $checklogview           = $this->Space_model->checkLogById($id,$iduser);


        $data['usersacc']       = $this->Account_model->getAccountById($iduser);
  
        $data['lastdoc']        = '';
       

        if(empty($checklogview)) {
          $log = [
            'id_doc_signature'              => $id,
            'id_user_log_document'          => $iduser,
            'nama_log'                      => $data['usersacc']['nama'],
            'keterangan_document_signature' => 'View by ',
            'status_log'                    => '1',
            'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
          ];
    
          $this->Space_model->insertLogSignature($log);
        } 
      }

    

      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/previewdocument', $data);
      $this->load->view('template/footer', $data);
    }


  public function save_signed_pdf() {
    ob_start(); 

    $iduser               = $this->input->post("iduser");
    $iddocument           = $this->input->post("iddocument");
    $nosignature          = $this->input->post("nosignature");
    $iddocumentsignature  = $this->input->post("iddocumentsignature");
    $textketerangan       = $this->input->post("textketerangan");
   
   
    $statussignature      = $this->input->post("statussignature");
    $namadokumen          = $this->input->post("namadokumen");
    $qrcode               = $this->input->post("qrcode");
    $aprovaluser          = $this->input->post("aprovaluser");
    $myurl                = $this->input->post("myurl");

    $users      = $this->Account_model->getAccountById($iduser);

    $checkpj    = $this->Space_model->cekProjecteDoc($iddocument);

    $idpj       = $checkpj['id_project'];

    if($idpj == 0) {
      $idpj = 'space';
    } else {
      $idpj = $checkpj['id_project'];
    }

    $namafolder = checkSpace($idpj);

     $datenow = getCurrentDate();


    if($statussignature == "Approve") {
      $config['upload_path']    = './assets/document/' . $namafolder;
      $config['allowed_types']  = 'pdf';
      $config['file_name']      = date("Y-m-d") . ' ' . $namadokumen . '_SIGNED ' . $users['nama'];

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('file')) {
          $data = $this->upload->data();
        
          $new_image = $this->upload->data('file_name');

          $cekLast = $this->Space_model->cekLastSign($iddocument,$nosignature);

          foreach($cekLast as $cl) {
            if($cl['no_signature'] != $nosignature) {
              if($textketerangan == "") {
                $apprveby = "Approve By" . $users['nama'];
              } else {
                $apprveby = $textketerangan;
              }
             

              $this->db->set('status_signature', '2');
              $this->db->set('note_signature', $apprveby);
              $this->db->set('file_signature', $new_image);
              $this->db->set('reff_document', 'NULL');
              $this->db->set('updated_date', $datenow);
              $this->db->where('id_doc_signature', $cl['id_doc_signature']);
              $this->db->update('document_signature');

            } else {

              if($textketerangan == "") {
                $apprveby = "Approve By" . $users['nama'];
              } else {
                $apprveby = $textketerangan;
              }
              $this->db->set('status_signature', '2');
              $this->db->set('note_signature', $apprveby);
              $this->db->set('file_signature', $new_image);
              $this->db->set('reff_document', $qrcode);
              $this->db->set('updated_date', $datenow);
              $this->db->where('id_doc_signature', $cl['id_doc_signature']);
              $this->db->update('document_signature');

            }
          }

          $user   = $this->Account_model->getAccountById($iduser);

          $log = [
            'id_doc_signature'              => $iddocument,
            'id_user_log_document'          => $iduser,
            'nama_log'                      => $user['nama'],
            'keterangan_document_signature' => $textketerangan,
            'status_log'                    => '2',
            'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
          ];

          $cekDocInTask = $this->Space_model->checkAllTaskDocument($iddocument);

          if(!empty($cekDocInTask)) {
            foreach($cekDocInTask as $cdi) {
              $idtask       = $cdi['task_id'];

              $this->db->set('status_task', '2');
              $this->db->where('id_task', $idtask);
              $this->db->update('task');
            }
          }

          if($aprovaluser == "last") {
            $datepublish = date("Y-m-d H:i:s");
            $this->db->set('status_document', '4');
            $this->db->where('id_document', $iddocument);
            $this->db->update('document');

            $doctask = $this->Space_model->checkAllTaskDocument($iddocument);
            if(!empty($doctask)) {
              foreach($doctask as $docatask) {
                $idtask       = $docatask['task_id'];
  
                $this->db->set('status_task', '2');
                $this->db->where('id_task', $idtask);
                $this->db->update('task');
              }
            }

            $docokr = $this->Space_model->checkDocInOKR($iddocument);

            if($docokr) {
  
              $type = $docokr['type_doc_in_okr'];
              $id = $docokr['id_to_doc_in_okr'];
  
              $idspace = $this->session->userdata('workspace_sesi');
  
              if($type == 'key') {
                $kr = $this->Project_model->checkKr($id);
  
                $value =  $kr['value_kr'];
  
                $this->db->set('description_kr', '<p><a target="_blank" href="'.base_url('document/documentAtSpace/').$idspace.'">"'.base_url('document/index/').$idspace.'/space</a></p>');
                $this->db->set('value_achievment', $value);
                $this->db->set('precentage', 100);
                $this->db->where('id_kr', $id);
                $this->db->update('key_result');

                $this->updateOKR($id,$idpj,$type);
                } else {
                $ini = $this->Project_model->checkDataIni($id);
  
  
                $value = $ini['value_initiative'];
                $idkr = $ini['id_kr'];
  
                $this->db->set('comment', '<p><a target="_blank" href="'.base_url('document/documentAtSpace/').$idspace.'">"'.base_url('document/index/').$idspace.'/space</a></p>');
                $this->db->set('value_ach_initiative', $value);
                $this->db->set('value_percent', 100);
                $this->db->where('id_initiative', $id);
                $this->db->update('initiative');
  
                $this->updateOKR($id,$idpj,$type);
              }
            }
       

          }
    
          $this->Space_model->insertLogSignature($log);

          $nama = $users['nama'];

          $status = "Approve";


          $datanamafile = $this->Space_model->arrayLastDocumentSignature($iduser,$iddocumentsignature);
        

          foreach($datanamafile as $datnam) {
             $old_file_name = $datnam['file_sign']; // Sesuaikan dengan nama kolom pada database
 
             // Path lengkap file lama
             $old_file_path = './assets/document/' . $namafolder . '/' . $old_file_name;
     
             // Hapus file lama jika ada
             if (file_exists($old_file_path)) {
                 unlink($old_file_path);
             }
 
          }
 
          if($iduser) {
           $this->db->where('id_document_sign', $iddocumentsignature);
           $this->db->where('user_document_last', $iduser);
           $this->db->delete('document_last');
 
          }
          $type = 'documentsimpan';

          $this->saveNotifMultiple($iddocument,$type,$namadokumen,$myurl);

          $this->send_email($iddocument,$nama,$status);

          $response = ['success' => true, 'file' => base_url('assets/document/' . $namafolder . '/' . $data['file_name'])];

      } else {
          $response = ['success' => false];
      }

      ob_end_clean();
      echo json_encode($response);
      exit();

      }

  }

  public function updateOKR($idkr,$id_project,$type){

    if($type == 'key') {

      $kr     = $this->Project_model->checkDataKrbyOKR($idkr);

      $idkr = $kr['id_okr'];
 
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

    $ini     = $this->Project_model->checkDataIni($idkr);

    $idkr = $ini['id_kr'];

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

  public function reject_signed_pdf() {
    ob_start(); 
    $iduser               = $this->input->post("iduser");
    $iddocument           = $this->input->post("iddocument");
    $nosignature          = $this->input->post("nosignature");
    $iddocumentsignature  = $this->input->post("iddocumentsignature");
    $textketerangan       = $this->input->post("textketerangan");
    $statussignature      = $this->input->post("statussignature");
    $namadokumen          = $this->input->post("namadokumen");
    $myurl                = $this->input->post("myurl");

    $users = $this->Account_model->getAccountById($iduser);

    if($statussignature == "Reject") {
          $this->db->set('status_signature', '3');
          $this->db->set('note_signature', $textketerangan);
          $this->db->where('id_doc_signature', $iddocumentsignature);
          $this->db->update('document_signature');

          $this->db->set('status_document', '3');
          $this->db->where('id_document', $iddocument);
          $this->db->update('document');

          $cekDocInTask = $this->Space_model->checkAllTaskDocument($iddocument);
          if(!empty($cekDocInTask)) {
            foreach($cekDocInTask as $cdi) {
              $idtask       = $cdi['task_id'];

              $this->db->set('status_task', '4');
              $this->db->where('id_task', $idtask);
              $this->db->update('task');
            }
          }


          $user   = $this->Account_model->getAccountById($iduser);
    
          $log = [
            'id_doc_signature'              => $iddocument,
            'id_user_log_document'          => $iduser,
            'nama_log'                      => $users['nama'],
            'keterangan_document_signature' => $textketerangan,
            'status_log'                    => '3',
            'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
          ];
    
          $this->Space_model->insertLogSignature($log);

          $status = "Reject";
          $nama   = $users['nama'];

          $type = 'documentreject';

          $this->saveNotifMultiple($iddocument,$type,$namadokumen,$myurl);

          $this->send_email($iddocument,$nama,$status);
          $response = ['success' => true];

         
         
      } else {
          $response = ['success' => false];
      }
      ob_end_clean();
      echo json_encode($response);      
      exit();
  }

  public function revisi_signed_pdf() {
    ob_start(); 
    $iduser               = $this->input->post("iduser");
    $iddocument           = $this->input->post("iddocument");
    $nosignature          = $this->input->post("nosignature");
    $iddocumentsignature  = $this->input->post("iddocumentsignature");
    $textketerangan       = $this->input->post("textketerangan");
    $statussignature      = $this->input->post("statussignature");
    $namadokumen          = $this->input->post("namadokumen");
    $myurl                = $this->input->post("myurl");


    $users = $this->Account_model->getAccountById($iduser);

    if($statussignature == "Revisi") {

          $this->db->set('status_signature', '5');
          $this->db->set('note_signature', $textketerangan);
          $this->db->where('id_doc_signature', $iddocumentsignature);
          $this->db->update('document_signature');

          $this->db->set('status_document', '5');
          $this->db->where('id_document', $iddocument);
          $this->db->update('document');

          $cekDocInTask = $this->Space_model->checkAllTaskDocument($iddocument);
          if(!empty($cekDocInTask)) {
            foreach($cekDocInTask as $cdi) {
              $idtask       = $cdi['task_id'];

              $this->db->set('status_task', '3');
              $this->db->where('id_task', $idtask);
              $this->db->update('task');
            }
          }

          $user   = $this->Account_model->getAccountById($iduser);
    
          $log = [
            'id_doc_signature'              => $iddocumentsignature,
            'id_user_log_document'          => $iduser,
            'nama_log'                      => $users['nama'],
            'keterangan_document_signature' => $textketerangan,
            'status_log'                    => '5',
            'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
          ];
    
          $this->Space_model->insertLogSignature($log);

          $status = "Revisi";
          $nama   = $users['nama'];
          $type = 'documentrevisi';

          $this->saveNotifMultiple($iddocument,$type,$namadokumen,$myurl);

          $this->send_email($iddocument,$nama,$status);

          $response = ['success' => true];
         
      } else {
          $response = ['success' => false];
      }
      ob_end_clean();
      echo json_encode($response);      
      exit();
  }

   public function showAfterReject( $id,$space ='') {
      $data['title']          = 'Data Document';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

      $data['signaturelog']   = $this->Space_model->dataLogDoc($id);

      $iduser   = $this->session->userdata('id');

      $checkall = $this->Space_model->checkAllSignatureFileFirst($id);

      $checkpj    = $this->Space_model->cekProjecteDoc($id);

      $idpj       = $checkpj['id_project'];

      if($checkpj['id_project'] == 0) {
        $idpj   = "space";
      } else {
        $idpj   = $checkpj['id_project'];
      }
  
      $data['namafolder'] = checkSpace($idpj);
    
      if(empty($checkall)) {
       
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
         
        } else {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id);
        }

        $checklast              = $this->Space_model->checkLastDocument($id);
  
        $data['lastdoc']        = $checklast['file_signature'];
                
      } else {
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id,$iduser);

        } else {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceByIdAfterReject($id,$iduser);
        }
        $checklogview           = $this->Space_model->checkLogById($id,$iduser);
        
        $data['usersacc']       = $this->Account_model->getAccountById($iduser);
  
        $data['lastdoc']        = '';
      }
      $this->load->view('template/header', $data);
      // $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentafterreject', $data);
      $this->load->view('template/footer', $data);
  }

  public function editNewDocumentSign() {
    $id_document  = $this->input->post('id_document');
    $namadokumen  = $this->input->post('namadokumen');
    $typedokumen  = $this->input->post('typedokumen');
    $space        = $this->input->post('space');
    $project      = $this->input->post('project');
    $idproject    = $this->input->post('idproject');
    $filesdoc     = $_FILES['input_document'];

    $idspace        = $this->input->post('idspace');

    $namafolder = checkSpace($idproject);

    $myid = $this->session->userdata('id');

    $usersacc       = $this->Account_model->getAccountById($myid);
    // Handle document signatures
    $signatures = $this->input->post('signatures'); // This will be a JSON string

    if ($filesdoc) {
      $config['allowed_types'] = 'pdf';
      $config['max_size']      = '50000';
      $config['upload_path']   = './assets/document/' . $namafolder;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('input_document')) {
        $new_image = $this->upload->data('file_name');
      } else {
        echo $this->upload->display_errors();
      }
    }
     // Prepare data for insertion
      $data = array(
        'name_document'     => $namadokumen,
        'type_document'     => $typedokumen,
        'id_space'          => $idspace,
        'id_project'        => $idproject,
        'file_document'     => $new_image,
        'id_user_create'    => $this->session->userdata('id'),
        'status_document'   => '2',
        'created_date'      => date('Y-m-d H:i:s'),
      );

      // Insert document data into the database
      $insert_id = $this->Main_model->insert_document($data);

      $iddocument = $insert_id;
      
    if (!empty($signatures)) {
        $signaturesArray = json_decode($signatures, true);

        // Delete existing signatures
        $this->Space_model->deleteDocumentSignatures($iddocument);

        // Insert new signatures
        foreach ($signaturesArray as $signature) {
            $signatureData = [
                'no_signature'      => $signature['order'],
                'id_document_users' => $iddocument,
                'id_user_doc'       => $signature['id'],
                'status_signature'  => '1',
                'created_date'      => date("Y-m-d H:i:s"),
                
            ];
            $this->Space_model->insertDocumentSignature($signatureData);
            }
        }

      $log = [
        'id_doc_signature'              => $iddocument,
        'id_user_log_document'          => $myid,
        'nama_log'                      => $usersacc['nama'],
        'keterangan_document_signature' => 'Recreated By ',
        'status_log'                    => '4',
        'updated_date_doc_signature'    => date("Y-m-d H:i:s"), 
      ];

      $this->Space_model->insertLogSignature($log);

      redirect('document/index/' . $idproject);
  }

  public function publishDocument($idpj,$id,$st) {
    $datepublish = date("Y-m-d H:i:s");

    $this->db->set('status_document', '4');
    $this->db->set('publish_at', $datepublish);
    $this->db->where('id_document', $iddoc);
    $this->db->update('document');

    if($st == 'alldoc') {
      redirect('document/documentAtSpace/' . $id);
    } else {
      redirect('document/index/' . $idpj);
    }

  }

  public function publishDocumentAll($idpj,$idspace,$st,$iddoc) {
    $datepublish = date("Y-m-d H:i:s");

    $this->db->set('status_document', '4');
    $this->db->set('publish_at', $datepublish);
    $this->db->where('id_document', $iddoc);
    $this->db->update('document');


    if($st == 'alldoc') {
      redirect('document/documentAtSpace/' . $idspace);
    } else {
      redirect('document/index/' . $idpj);
    }

  }

  public function setEmailPublish($idpj,$id,$st) {

    $data['title']          = 'Data Dokumen';
    $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']          = $this->Account_model->getALLUsers();

    if($idpj == 0) {
      $data['mydocument']     = $this->Space_model->dataShowDocumentFileInPjById($id);
      $idpj                   = 'space';
      $data['namafolder']     = checkSpace($idpj);
      $data['idpj']           = $idpj;
    } else {
      $data['mydocument']     = $this->Space_model->dataShowDocumentFileById($id);
      $data['namafolder']     = checkSpace($idpj);
      $data['idpj']           = $idpj;
    }
  
    $data['state']            = $st;

    $this->load->view('template/header', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('document/documentemail', $data);
    $this->load->view('template/footer', $data);
  }

  public function send_email_doc() {

    $subject        = $this->input->post('subject');
    $file           = $this->input->post('file');
    $emailsend      = $this->input->post('emailsend');
    $emailcc        = $this->input->post('emailcc');
    $message        = $this->input->post('message');
    $namapengirim   = $this->input->post('namapengirim');
    $iddoc          = $this->input->post('iddoc');


    $checkpj = $this->Space_model->cekProjecteDoc($iddoc);
    $failedEmails = [];


    $idpj   = $checkpj['id_project'];

    if($idpj == 0) {
      $idpj = "space";
    } else {
      $idpj = $idpj;
    }

    $namafolder = checkSpace($idpj);

    $filepath = FCPATH . 'assets/document/' . $namafolder . '/' . $file;
    $datepublish = date("Y-m-d H:i:s");

    $iduser = $this->session->userdata("id");

    $nama  = $this->Account_model->getAccountById($iduser);
    $fullname = $nama['nama'];

    // Memecah nama menjadi array berdasarkan spasi
    $namaArray = explode(' ', trim($fullname));

    // Mengambil kata pertama sebagai nama depan
    $firstname = $namaArray[0];


    $this->db->set('status_document', '4');
    $this->db->set('publish_at', $datepublish);
    $this->db->set('publish_user', $firstname);
    $this->db->where('id_document', $iddoc);
    $this->db->update('document');


    $mail = new PHPMailer(true);

    try {
      //Server settings
    $mail->IsSMTP();
    $mail->SMTPAuth    = true;
    $mail->Host        = 'mail.ethes.tech'; 
    $mail->Username    = 'okrinfo@ethes.tech';
    $mail->Password    = 'OKR@info123';
    $mail->Port        = 587;
    $mail->SMTPDebug    = 0;
    
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );                  //Enable verbose debug output

     // Recipients
     $mail->setFrom('okrinfo@ethes.tech', $namapengirim);

     $mail->Timeout = 30; // 30 detik
            
    // Multiple recipients
        if (!empty($emailsend)) {
            foreach ($emailsend as $index => $email) {
                if ($index === 0) {
                    $mail->addAddress($email); // Email pertama sebagai penerima utama
                } else {
                    $mail->addBCC($email); // Sisanya sebagai BCC
                }
            }
        }

        // Add CC
        if (!empty($emailcc)) {
        foreach ($emailcc as $cc) {
                $mail->addCC($cc);
        }
        }

     // Attachments
     if ($file) {
         $mail->addAttachment($filepath); // Add file
     }

     // Content
     $mail->isHTML(true);                                  // Set email format to HTML
     $mail->Subject = $subject;
     $mail->Body    = $message;

     $mail->send();
      echo json_encode(['status' => 'success', 'message' => 'Email yang tidak berhasil dikirim!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email. Error: ' . $mail->ErrorInfo]);
    }

  }

    public function documentAtSpace($id) {

      $data['title']          = 'Data Document';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
      $data['departement']    = $this->Departement_model->getAllDepartement();

      $iduser = $this->session->userdata('id');

      $this->session->set_userdata('workspace_sesi', $id);

      $delegasi = $this->Project_model->cekDelegasi($iduser);

      $projectDelegasi       = $this->Project_model->getYourProjectDelegateNoAllLimit($id);
   
      $projects      = $this->Project_model->getYourProjectNoLimit($id);

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
      $this->load->view('document/documentatspace', $data);
      $this->load->view('template/footer', $data);

    }

    public function getMyDocuments($iduser, $id_space,$id_project = null) {
      $documentsign = $this->Space_model->dataTableMyDocument($iduser,$id_space,$id_project);
      $documentcreated = $this->Space_model->dataTableMyDocumentAll($iduser, $id_project,$id_space);
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

  public function getDocumentsData() {
    $iduser = $this->session->userdata('id');  // Ambil ID user dari session
    $id_project = $this->input->post('idproject'); // Ambil ID project dari request (AJAX)
    $id_space = $this->input->post('idspace'); // Ambil ID


    $mydocument = $this->Space_model->getDataTableDoc($iduser, $id_project,$id_space);

     // Ambil total data tanpa filter untuk menghitung recordsTotal
     $totalRecords = $this->Space_model->getTotalDocuments($iduser, $id_space, $id_project);


     $data   = [];
     $no     = $_POST['start'];

      // Iterasi dan tambahkan elemen HTML pada nama_dokumen
      foreach ($mydocument as &$doc) {
        $row    = array();
        
        $idpj = $doc['id_project'];

        if($idpj == 0) {
          $idpj = "space";
        } else {
          $idpj = $idpj;
        }

        if($doc['backup_status'] == '1') {
          $state = '
          <span class="btn-inner--icon"><i class="ni ni-book-bookmark text-warning"></i></span>';
        } else {
          $state = "";
        }

        $namafolder = checkSpace($idpj);

        $row[] = '<div class="text-center"><input type="checkbox" class="doc-checkbox" value="' . $doc['id_document'] . '"></div>';

        $idpj = $doc['id_project'];

        $row[] = '
            <div class="media align-items-center">
                <a href="#" class="avatar rounded-circle mr-3 bg-primary">
                  <i class="fas fa-folder-open"></i>
                </a>
                <div class="media-body">
                    <span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_document']) . '</span>'.$state.'
                </div>
            </div>';

            $row[] ='<span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_space']) . '</span>';

           $name = $doc['publish_user'];

           if($name != NULL) {
            $publishname = "from " .$name;
           } else {
            $publishname = "";
           }


           if($doc['backup_status'] == 1 && $doc['backup_status'] == NULL) {
            $statusbackup = '<span class="badge badge-info">Backup Download</span>';
            $filebackup = '-';
           } else if($doc['backup_status'] != NULL) {
            $statusbackup = '<span class="badge badge-info">Backup G Drive</span>';
            $filebackup = '<a target="_blank" href="'.$doc['folder_link'].'" class="badge badge-lg badge-warning"><i class="ni ni-archive-2"></i> Lihat File G Drive</a>';
           } else {
            $statusbackup = '-';
            $filebackup = '-';
           }

          if($doc['publish_at'] == '0000-00-00 00:00:00') {
            $row[] = '<span class="badge badge-success">Complete</span>';
          } else {
            $row[] = '<span class="badge badge-default">Publish</span> <span class="badge badge-info">'.$publishname.'</span> <span class="badge badge-warning">At ' . htmlspecialchars(date("Y-m-d H:i",strtotime($doc['publish_at']))) . '</span>';
          }

          $iddoc = $doc['id_document'];
          $checkFile = $this->Space_model->getSignatureFile($iddoc);

          $filepath = base_url().'assets/document/' .$namafolder.'/'. $checkFile['file_signature'];

        
        
          $row[] = '<a target="_blank" href="'.$filepath.'" class="badge badge-lg badge-default"><i class="ni ni-archive-2"></i> Lihat File</a>';

          $row[] = $statusbackup;

          $row[] = $filebackup;

          if($doc['id_project'] == '0') {
            $row[] = '<a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectAllModal" data-doc="'.$doc['id_document'].'" data-spaceid="'.$doc['id_space'].'">
            <span class="btn--inner-icon">
            <i class="fas fa-users"></i></span>
            <span class="btn-inner--text">Pindahkan Ke OKR</span>
            </a>
            <a href="'. base_url("document/seedocument/") . $iddoc .'" class="btn btn-default btn-sm rounded-pill font-btn"> 
            <span class="btn--inner-icon">
            <i class="ni ni-single-copy-04"></i></span>
            <span class="btn-inner--text">Lihat Dokumen</span>
            </a>';
          } else {
            $row[] ='<a href="'. base_url("document/seedocument/") . $iddoc .'" class="btn btn-default btn-sm rounded-pill font-btn"> 
            <span class="btn--inner-icon">
            <i class="ni ni-single-copy-04"></i></span>
            <span class="btn-inner--text">Lihat Dokumen</span>
            </a>';

          }
          $data[] = $row;
        
    }

   
    $output   = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->Space_model->count_all_datadoc(),
      "recordsFiltered" => $this->Space_model->count_filtered_datadoc($iduser, $id_project,$id_space),
      "data"            => $data,
    );

    $this->output->set_content_type('application/json')->set_output(json_encode($output));
}

public function getDocumentsDataAfterPublish() {
  $iduser = $this->session->userdata('id');  // Ambil ID user dari session
  $id_project = $this->input->post('idproject'); // Ambil ID project dari request (AJAX)
  $id_space = $this->input->post('idspace'); // Ambil ID


  $mydocument = $this->Space_model->getDataTableDocPublish($iduser, $id_project,$id_space);

   // Ambil total data tanpa filter untuk menghitung recordsTotal
   $data   = [];
   $no     = $_POST['start'];

    // Iterasi dan tambahkan elemen HTML pada nama_dokumen
    foreach ($mydocument as &$doc) {
      $row    = array();
      
      $idpj = $doc['id_project'];

      if($idpj == 0) {
        $idpj = "space";
      } else {
        $idpj = $idpj;
      }

      $namafolder = checkSpace($idpj);

      $row[] = '<div class="text-center"><input type="checkbox" class="doc-checkbox" value="' . $doc['id_document'] . '"></div>';

      $idpj = $doc['id_project'];

      $row[] = '
          <div class="media align-items-center">
              <a href="#" class="avatar rounded-circle mr-3 bg-primary">
                <i class="fas fa-folder-open"></i>
              </a>
              <div class="media-body">
                  <span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_document']) . '</span>
              </div>
          </div>';

          $row[] ='<span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_space']) . '</span>';

         $name = $doc['publish_user'];

         if($name != NULL) {
          $publishname = "from " .$name;
         } else {
          $publishname = "";
         }


         if($doc['backup_status'] != 1 && $doc['backup_status'] == NULL) {
          $statusbackup = '<span class="badge badge-info">Backup Download</span>';
          $filebackup = '-';
         } else if($doc['backup_status'] != NULL) {
          $statusbackup = '<span class="badge badge-info">Backup G Drive</span>';
          $filebackup = '<a target="_blank" href="'.$doc['folder_link'].'" class="badge badge-lg badge-warning"><i class="ni ni-archive-2"></i> Lihat File G Drive</a>';
         } else {
          $statusbackup = '-';
          $filebackup = '-';
         }

        if($doc['publish_at'] == '0000-00-00 00:00:00') {
          $row[] = '<span class="badge badge-success">Complete</span>';
        } else {
          $row[] = '<span class="badge badge-default">Publish</span> <span class="badge badge-info">'.$publishname.'</span> <span class="badge badge-warning">At ' . htmlspecialchars(date("Y-m-d H:i",strtotime($doc['publish_at']))) . '</span>';
        }

        $iddoc = $doc['id_document'];
        $checkFile = $this->Space_model->getSignatureFile($iddoc);

        $filepath = base_url().'assets/document/' .$namafolder.'/'. $checkFile['file_signature'];
      
        $row[] ='<a target="_blank" href="'.$filepath.'" class="badge badge-lg badge-default"><i class="ni ni-archive-2"></i> Lihat File</a>';

        $row[] = $statusbackup;

        $row[] = $filebackup;
        if($doc['id_project'] == '0') {
          $row[] = '<a href="" class="btn btn-success btn-sm rounded-pill" type="button" data-toggle="modal" data-target="#projectAllModal" data-doc="'.$doc['id_document'].'" data-spaceid="'.$doc['id_space'].'">
          <span class="btn--inner-icon">
          <i class="fas fa-users"></i></span>
          <span class="btn-inner--text">Pindahkan Ke OKR</span>
          </a>
          <a href="'. base_url("document/seedocument/") . $iddoc .'" class="btn btn-default btn-sm rounded-pill font-btn"> 
          <span class="btn--inner-icon">
          <i class="ni ni-single-copy-04"></i></span>
          <span class="btn-inner--text">Lihat Dokumen</span>
          </a>';
        } else {
          $row[] ='<a href="" class="btn btn-secondary btn-sm rounded-pill">
          <span class="btn--inner-icon">
          <i class="fas fa-users"></i></span>
          <span class="btn-inner--text">Pindahkan Ke OKR</span>
          </a>
          <a href="'. base_url("document/seedocument/") . $iddoc .'" class="btn btn-default btn-sm rounded-pill font-btn"> 
          <span class="btn--inner-icon">
          <i class="ni ni-single-copy-04"></i></span>
          <span class="btn-inner--text">Lihat Dokumen</span>
          </a>';

        }
        $data[] = $row;
      
  }

 
  $output   = array(
    "draw"            => $_POST['draw'],
    "recordsTotal"    => $this->Space_model->count_all_datadocpublish(),
    "recordsFiltered" => $this->Space_model->count_filtered_datadocpublish($iduser, $id_project,$id_space),
    "data"            => $data,
  );

  $this->output->set_content_type('application/json')->set_output(json_encode($output));
}

  public function seedocument($id) {
      $data['title']          = 'Data Document';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

      $data['signaturelog']   = $this->Space_model->dataLogDoc($id);

      $iduser   = $this->session->userdata('id');

      $checkall = $this->Space_model->checkAllSignatureFileFirst($id);

      $checkpj    = $this->Space_model->cekProjecteDoc($id);

      $idpj       = $checkpj['id_project'];

      if($checkpj['id_project'] == 0) {
        $idpj   = "space";
      } else {
        $idpj   = $checkpj['id_project'];
      }
    
      $data['namafolder'] = checkSpace($idpj);
    
      if(empty($checkall)) {
       
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentFinishSpaceById($id);
        } else {
          $data['document']       = $this->Space_model->dataShowDocumentFinishById($id);
        }

        $checklast              = $this->Space_model->checkLastDocument($id);
  
        $data['lastdoc']        = $checklast['file_signature'];
      } else {
        $cekdoc                 = $this->Space_model->checkDoc($id);
        $idproject = $cekdoc['id_project'];

        if($idproject == 0) {
          $data['document']       = $this->Space_model->dataShowDocumentSpaceById($id,$iduser);
        } else {
          $data['document']       = $this->Space_model->dataShowDocumentById($id,$iduser);
        }
        $checklogview           = $this->Space_model->checkLogById($id,$iduser);


        $data['usersacc']       = $this->Account_model->getAccountById($iduser);
  
        $data['lastdoc']        = '';
       

      }

      $this->load->view('template/header', $data);
       $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/seedocumentpublish', $data);
      $this->load->view('template/footer', $data);
  }

  public function send_email($id_document,$nama,$status) {
    ob_start(); // Mulai output buffering

    $signatures = $this->Space_model->checkSignature($id_document);
    
    if($status == "Approve") {
      $status = '<span style="background-color: #2dce89" class="btninemail">Approve</span>';
      $notestatus= 'Dokumen Telah di Aprove ' . $nama;
    } else if($status == "Reject") {
      $status = '<span style="background-color: #f5365c" class="btninemail">Reject</span>';
      $notestatus= 'Dokumen Telah di Reject ' . $nama;
    } else if($status == "Revisi") {
      $status = '<span style="background-color: #fb6340" class="btninemail">Revisi</span>';
      $notestatus= 'Dokumen Harus di Revisi dari' . $nama;
    } else {
      $status = '';
      $notestatus= 'Ada Pengajuan Tanda Tangan Baru di OKRE';
    }

    $doc = $this->Space_model->checkFile($id_document);

    $link = base_url("document/index/") . $doc["id_project"];

    $subject = 'Notifikasi Pengajuan Dokumen Baru di OKRE yaitu ' . $doc['name_document'];

    $mail = new PHPMailer(true);
    try {
      //Server settings
    $mail->IsSMTP();
    $mail->SMTPAuth    = true;
    $mail->Host        = 'mail.ethes.tech'; 
    $mail->Username    = 'infookre@ethes.tech';
    $mail->Password    = 'InfoOKR@2024';
    $mail->Port        = 587;
    $mail->SMTPDebug   = SMTP::DEBUG_SERVER;  //Enable verbose debug output
    
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );                  //Enable verbose debug output

     // Recipients
     $mail->setFrom('infookre@ethes.tech', $nama);
            
     // Multiple recipients
     if (!empty($signatures)) {
         foreach ($signatures as $email) {
             $mail->addAddress($email['email']);
         }
     }

     // Content
     $mail->isHTML(true);                                  // Set email format to HTML
     $mail->Subject = $subject;

     $message = '
     <!DOCTYPE html>
     <html lang="en">
         <head>
             <meta charset="UTF-8" />
             <meta name="viewport" content="width=device-width, initial-scale=1.0" />
             <title>Notifikasi Email</title>
             <style>
                 .card {
                     background-color: #ffffff;
                     border-radius: 10px;
                     box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                     margin: 20px;
                     padding: 20px;
                     max-width: 600px;
                     font-family: Arial, sans-serif;
                     color: #333333;
                     border: 1px solid #dddddd;
                 }
                 .card h2 {
                     font-size: 24px;
                     margin-bottom: 10px;
                     color: #007bff;
                 }
                 .card p {
                     font-size: 16px;
                     line-height: 1.5;
                 }
                 .card a {
                     color: #007bff;
                     text-decoration: none;
                 }
                 .card a:hover {
                     text-decoration: underline;
                 }
                 .btn {
                     display: inline-block;
                     padding: 10px 20px;
                     margin-top: 20px;
                     background-color: #bfbfbf;
                     color: #ffffff;
                     text-align: center;
                     border-radius: 5px;
                     text-decoration: none;
                     font-size: 16px;
                     font-weight: bold;
                 }
                 .btn:hover {
                     background-color: #0056b3;
                     text-decoration: none;
                 }
                 .btninemail {
                  padding-right: 0.875em;
                  padding-left: 0.875em;
                  border-radius: 10rem;
                  }
             </style>
         </head>
         <body>
             <div class="card">
                 <h2>OKRE Notifikasi '.$status.'</h2>
                 <p>Halo,</p>
                 <p>'.$notestatus.', silahkan klik link dibawah ini.</p>
                 <a href="' . $link . '" class="btn" target="_blank">Klik Di Sini</a>
             </div>
         </body>
     </html>';


      // Assign message to the body
      $mail->Body = $message;

      // Send email
      $mail->send();
      ob_end_clean(); // Hapus semua output buffering
      return true; // Mengembalikan status success
    } catch (Exception $e) {
      ob_end_clean(); // Hapus semua output buffering
      return false; // Mengembalikan status gagal
    }

  }

  public function setEmailAfterAproval($id) {

    $data['title']          = 'Data Dokumen';
    $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']          = $this->Account_model->getALLUsers();

    $data['mydocument']     = $this->Space_model->dataShowDocumentFileById($id);

    $checkpj    = $this->Space_model->cekProjecteDoc($id);

    $idpj       = $checkpj['id_project'];

    $data['namafolder'] = checkSpace($idpj);


    $data['state']          = "cek";

    $this->load->view('template/header', $data);
    // $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('document/documentemailafteraproval', $data);
    $this->load->view('template/footer', $data);
  }

  public function deleteDocument($id) {

    $sign = $this->Space_model->documentSign($id);

    $checkpj = $this->Space_model->cekProjecteDoc($id);

    $idpj   = $checkpj['id_project'];

    if($checkpj['id_project'] == 0) {
      $idpj   = "space";
    } else {
      $idpj   = $checkpj['id_project'];
    }

    $namafolder = checkSpace($idpj);

    foreach($sign as $sg) {
      $file_signature = $sg['file_signature'];
      $this->deleteFile($namafolder, $file_signature);
    }
    $doc = $this->Space_model->documentFile($id);

    foreach($doc as $dc) {
      $file_document = $dc['file_document'];
      $this->deleteFile($namafolder, $file_document);
    }

    $this->Space_model->hapus_document($id,'document_signatur_log');
    $this->Space_model->hapus_document($id,'document_signature');
    $this->Space_model->hapus_document($id,'document');

    if($checkpj['id_project'] == 0) {
      redirect('document/index/' . $this->session->userdata('workspace_sesi') . '/space');
    } else {
      redirect('document/index/' . $idpj);
    }
  }

  public function deleteFile($namafolder, $filename) {
    if (!empty($filename)) {
      $old_file_path = './assets/document/' . $namafolder . '/' . $filename;

      // Hapus file jika ada
      if (file_exists($old_file_path)) {
          unlink($old_file_path);
      }
  } else {
      // Log atau handle kasus di mana filename kosong
      log_message('error', 'Filename is empty, cannot delete file.');
  }
}

  public function pdfSementara() {
    $namedoc              = $this->input->post('namedoc');
    $iddocumentsignature  = $this->input->post('iddocumentsignaturelast');
    $iduserlast           = $this->input->post('iduserlast');
    $namadokumen          = $this->input->post("namadokumen");
    $idproject            = $this->input->post("idproject");


    if($idproject == '0') {
      $idproject = 'space';
    } else {
      $idproject = $idproject;
    }
    $namafolder           = checkSpace($idproject);
  
    $config['upload_path']    = './assets/document/' . $namafolder;
    $config['allowed_types'] = 'pdf';
    $config['max_size']       = '20480'; // 20MB
    $config['file_name']      = "temporary" . $iddocumentsignature;

    $filesdoc            = $_FILES['filelast'];

   

    $this->load->library('upload', $config);
    // Memeriksa apakah file di-upload
    if (!$this->upload->do_upload('filelast')) {
        $error = array('error' => $this->upload->display_errors());
        echo json_encode(array('success' => false, 'message' => $error));
    } else {
        $new_image = $this->upload->data('file_name');
        // Simpan data ke database
       
        $this->Space_model->saveDocumentSignature($iduserlast,$iddocumentsignature, $new_image);

        $datanamafile = $this->Space_model->checkLastDocumentSignature($iduserlast,$iddocumentsignature);

        $namafileterakhir = $datanamafile['file_sign'];

        echo json_encode(array('success' => true, 'newFileName' => $namafileterakhir));
    }
  }

  public function ulangiDocument() {
  

        // Simpan data ke database
        $iddocumentsignature = $this->input->post('iddocumentsignaturelast');
        $iduserlast = $this->input->post('iduserlast');
        $namadokumen = $this->input->post('namadokumen');
        $idproject          = $this->input->post("idproject");

        $namafolder = checkSpace($idproject);

        $datanamafile = $this->Space_model->arrayLastDocumentSignature($iduserlast,$iddocumentsignature);
        

         foreach($datanamafile as $datnam) {
            $old_file_name = $datnam['file_sign']; // Sesuaikan dengan nama kolom pada database

            // Path lengkap file lama
            $old_file_path = './assets/document/' . $namafolder . '/' . $old_file_name;
    
            // Hapus file lama jika ada
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }

         }

         if($iduserlast) {
          $this->db->where('id_document_sign', $iddocumentsignature);
          $this->db->where('user_document_last', $iduserlast);
          $this->db->delete('document_last');

         }
       
      
        echo json_encode(array('success' => true));
    }


    public function moveToProject() {

      $iddocumentpj         = $this->input->post("iddocumentpj");
      $idspacepj            = $this->input->post("idspacepj");
      $projectdoc           = $this->input->post("projectdoc");
     
      $this->db->set('id_project', $projectdoc);
      $this->db->where('id_document', $iddocumentpj);
      $this->db->update('document');
     
     redirect('document/index/'.$idspacepj.'/space');
    }

    public function moveToProjectFromAll() {

      $iddocumentpj         = $this->input->post("iddocumentpj");
      $idspacepj            = $this->input->post("idspacepj");
      $projectdoc           = $this->input->post("projectdoc");
     
      $this->db->set('id_project', $projectdoc);
      $this->db->where('id_document', $iddocumentpj);
      $this->db->update('document');
     
     redirect('document/documentAtSpace/'.$idspacepj);
    }

    // Di dalam Document.php
    public function documentbackup($id) {

      $data['title']          = 'Data Document';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']        = $this->Project_model->getProjectJoinUser();
      $data['team']           = $this->Team_model->getALLTeam();
      $data['users']          = $this->Account_model->getJoinUsers();
        // Ambil string ID dari form sebelumnya
        $ids_string = $this->input->post('selected_ids');
        if (empty($ids_string)) {
            // Jika tidak ada ID, kembalikan ke halaman sebelumnya dengan pesan error
            $this->session->set_flashdata('error', 'Tidak ada dokumen yang dipilih.');
            redirect('halaman/sebelumnya'); // Ganti dengan URL halaman daftar dokumen Anda
        }

        // Ubah string menjadi array
        $ids_array = explode(',', $ids_string);

        // Ambil detail dokumen dari database berdasarkan ID
        $dokumen_dari_db = $this->Space_model->get_documents_by_ids($ids_array);
        $data_untuk_view = [];

        $jumlah_file_valid = 0;
        $total_ukuran_bytes = 0;
    
        foreach ($dokumen_dari_db as $doc) {
            $idpj = ($doc['id_project'] == 0) ? "space" : $doc['id_project'];
            $namafolder = checkSpace($idpj); // Asumsi checkSpace() adalah helper

            $iddoc = $doc['id_document'];
            $checkFile = $this->Space_model->getSignatureFile($iddoc);

            if (!empty($checkFile) && isset($checkFile['file_signature'])) {
              // Bangun path FISIK (bukan URL) untuk kalkulasi ukuran
              $physicalPath = FCPATH . 'assets/document/' . $namafolder . '/' . $checkFile['file_signature'];
              
              // 2. Cek jika file benar-benar ada di server
              if (file_exists($physicalPath)) {
                  // Tambahkan ukuran file (dalam bytes) ke total
                  $total_ukuran_bytes += filesize($physicalPath);
                  // Tambahkan hitungan file yang valid
                  $jumlah_file_valid++;
              }
          }
    
            // Bangun path lengkap di sini
            $doc['filepath'] = base_url('assets/document/' . $namafolder . '/' . $checkFile['file_signature']);
            
            $data_untuk_view[] = $doc; // Masukkan ke array baru yang akan dikirim ke view
        }

        $total_ukuran_mb = number_format($total_ukuran_bytes / 1048576, 2);
        $total_ukuran_kb = number_format($total_ukuran_bytes / 1024, 2);
    
        $data['dokumen_terpilih'] = $data_untuk_view;
        $data['ids_untuk_zip'] = implode(',', $ids_array);
        $data['jumlah_file'] = $jumlah_file_valid;
        $data['total_ukuran_string'] = $total_ukuran_mb . ' MB (' . $total_ukuran_kb . ' KB)'; // <-- UBAH INI
        // ... muat data lain yang dibutuhkan untuk header/footer ...

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('document/view_konfirmasi_backup', $data);
        $this->load->view('template/footer', $data);
    }

    // Di dalam Document.php
  public function proses_final_backup($id) {
      $ids_string = $this->input->post('ids_to_zip');
      if (empty($ids_string)) {
          redirect('document/documentAtSpace/' . $id);
      }

      $cekspace = $this->Space_model->checkSpaceById($id);

      $namespace = $cekspace['name_space'];
      
      $ids_array = explode(',', $ids_string);
      $files_to_zip = $this->Space_model->get_documents_by_ids($ids_array);

      if (!empty($files_to_zip)) {
          $zip = new ZipArchive();
          $zipFileName = 'arsip_dokumen_' . $namespace . '_' . date('Y-m-d_His') . '.zip';
          $zipFilePath = FCPATH . 'temp/' . $zipFileName;

          if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
              
              // =======================================================
              // SOLUSI DIMULAI DI SINI
              // =======================================================
              $fileAddedCount = 0; // 1. Buat counter manual

              foreach ($files_to_zip as $doc) {
                  // ... (logika untuk mendapatkan $physicalFilePath) ...
                  $idpj = ($doc['id_project'] == 0) ? "space" : $doc['id_project'];
                  $namafolder = checkSpace($idpj);
                  $checkFile = $this->Space_model->getSignatureFile($doc['id_document']);
                  
                  if (!empty($checkFile) && isset($checkFile['file_signature'])) {
                      $physicalFilePath = FCPATH . 'assets/document/' . $namafolder . '/' . $checkFile['file_signature'];

                      if (file_exists($physicalFilePath)) {
                          $fileNameInZip = $doc['name_document'] . '.pdf';
                          if ($zip->addFile($physicalFilePath, $fileNameInZip)) {
                              $fileAddedCount++; // 2. Tambah counter jika 'addFile' berhasil
                          }
                      }
                  }
              }

              $zip->close();

              // 3. Gunakan counter manual kita, bukan $zip->numFiles
              if ($fileAddedCount > 0) {
                  // Lanjutkan proses hanya jika ZIP tidak kosong
                  $this->Space_model->tandai_sudah_diarsip($ids_array);

                  $this->load->helper('download');
                  force_download($zipFilePath, NULL);
                  unlink($zipFilePath);
                  exit();
              } else {
                  // Handle jika tidak ada file valid yang ditemukan
                  unlink($zipFilePath);
                  $this->session->set_flashdata('error', 'Tidak ada file valid yang ditemukan untuk diarsip.');
                  redirect('document/documentAtSpace/' . $id);
              }
          }
      } else {
          $this->session->set_flashdata('error', 'Tidak ada dokumen yang dipilih untuk diarsip.');
          redirect('document/documentAtSpace/' . $id);
      }
  }

  public function archive_by_id() {
		
      $file_id = $this->input->post('fileid');
      $id = $this->input->post('iddoc');

      if (empty($file_id)) {
        $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Tidak ada foto yang dipilih.']));
        return;
      }

      $cekspace = $this->Space_model->checkSpaceById($id);

      $namespace = $cekspace['name_space']; 
      // 1. Ambil semua data gambar dari database untuk tanggal tersebut yang BELUM diarsip
      $file = $this->Space_model->getSignatureFile($file_id);

      $id_document = $file['id_document_users'];

      $doc = $this->Archieve_model->get_documents_by_ids($id_document);

      $idpj = ($doc['id_project'] == 0) ? "space" : $doc['id_project'];

      $namafolder = checkSpace($idpj); // Asumsi checkSpace() adalah helper

      // print_r($idpj);exit();

      // $this->db->get_where('document_signature', ['id' => $file_id])->row_array();
    
      if (empty($file)) {
        $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'info', 'message' => 'Tidak ada foto yang perlu diarsipkan untuk tanggal ini.']));
        return;
      }
    
      $success_count = 0;
      $fail_count = 0;
    
        // Tentukan path file di server lokal
        $local_path = FCPATH . 'assets/document/' . $namafolder . '/' . $file['file_signature'];
       
        $source_file_to_upload = $local_path;
  
        // 3. Upload file ke Google Drive
        $gdrive_id = $this->Archieve_model->upload_to_gdrive($source_file_to_upload, $file['file_signature'],$namafolder);
    
        if ($gdrive_id) {
          // 4. Jika berhasil, update database
          $this->Archieve_model->save_other_id($file['id_document_users'], $gdrive_id,$file['file_signature']);
          
          // 5. Hapus file sumber
          //unlink($source_file_to_upload);
          $success_count++;
        } else {
          // Jika upload gagal, hapus file temporary jika ada
          if (!empty($temp_file_path)) {
            unlink($temp_file_path);
          }
          $fail_count++;
        }
      // }
    
      $this->output->set_content_type('application/json')->set_output(json_encode([
        'status' => 'success',
        'message' => "Proses arsip selesai. Berhasil: $success_count, Gagal: $fail_count."
      ]));
    }



   

  }

  




