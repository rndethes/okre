<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

  defined('BASEPATH') or exit('No direct script access allowed');
  require_once(APPPATH . 'third_party/fpdf/fpdf.php');
  require_once(APPPATH . 'third_party/fpdi/src/autoload.php');


  use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
  use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Style\Alignment;
  use PhpOffice\PhpSpreadsheet\Style\Fill;
  use PhpOffice\PhpSpreadsheet\Style\Border;
  use PhpParser\Node\Stmt\Echo_;

 

  class Workspace extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Account_model');
      $this->load->model('Space_model');
      $this->load->model('Departement_model');
      $this->load->model('Project_model');
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
        $data['title']          = 'Tambah Workspace';
        $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['project']        = $this->Project_model->getProjectJoinUser();
        $data['team']           = $this->Team_model->getALLTeam();
        $data['users']           = $this->Account_model->getALLUsers();
        $data['departement']    = $this->Departement_model->getAllDepartement();

        $data['your_project']        = $this->Project_model->getYourProject();
        $data['recent_project']      = $this->Project_model->getRecentProject();
        $data['all_project']         = $this->Project_model->countAllProject();
        $data['complete_project']    = $this->Project_model->countCompleteProject();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('project/new_workspace', $data);
        $this->load->view('template/footer', $data);
    }

    public function tambahWorkSpace()
    {
         // Validasi input
         $this->form_validation->set_rules('namaworkspace', 'Space Name', 'required');
         $this->form_validation->set_rules('kategorispace', 'Kategori', 'required');

         if ($this->form_validation->run() == FALSE) {
             // Jika validasi gagal, kembali ke form dengan error
             redirect("workspace");
         } else {
             // Ambil data dari form
             $space_name        = $this->input->post('namaworkspace');
             $category          = $this->input->post('kategorispace');
             $desc              = $this->input->post('descfromquill');
             $selected_users    = $this->input->post('selected_users'); // ID pengguna yang dipilih
            
             // Pisahkan ID pengguna yang dipilih menjadi array
             $user_ids = explode(',', $selected_users);

             // Tambahkan ID pengguna yang membuat workspace ke array user_ids
             $creator_id = $this->session->userdata('id');
             if (!in_array($creator_id, $user_ids)) {
                 $user_ids[] = $creator_id; // Menambahkan pengguna yang membuat workspace
             }

             // Generate nama folder dengan huruf kecil dan tanpa spasi
            $folder_space = strtolower(str_replace(' ', '', $space_name));

            // Path folder tujuan
            $folder_path = FCPATH . 'assets/document/' . $folder_space;

            // Cek apakah folder sudah ada, jika tidak, buat folder baru
            if (!is_dir($folder_path)) {
                mkdir($folder_path, 0755, true); // Buat folder dengan izin 0755
            }

             // Data workspace
             $data = array(
                 'name_space'       => $space_name,
                 'kategory_space'   => $category,
                 'create_by'        => $creator_id,
                 'folder_space'     => $folder_space,
                 'desc_space'       => $desc,   
                 'date_created'     => date('Y-m-d H:i:s')
             );

            // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
            $workspace_id = $this->Project_model->insert_workspace($data);

            if($category == "team") { 
                // Tambahkan pengguna ke workspace
                if ($workspace_id) {
                    $this->Project_model->add_user_to_workspace($workspace_id, $user_ids, $creator_id);
                }
            } else {
                if ($workspace_id) {
                    $this->Project_model->add_user_workspace($workspace_id, $creator_id);
                }
            }
             
            // Redirect atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'Workspace berhasil ditambahkan!');
            redirect('project');
         }
     
    }

    public function getWorkspaceData($id_space) {
        // Get workspace data
        $workspaceData = $this->Space_model->getWorkspaceById($id_space);
    
        // Get projects in workspace
        $projectsData = $this->Space_model->getProjectsByWorkspaceId($id_space);
    
        // Combine workspace data and projects data
        $responseData = array(
            'workspace' => $workspaceData,
            'projects' => $projectsData
        );
    
        // Return data as JSON
        echo json_encode($responseData);
    }

    public function editWorkspace($id)
    {
      $data['title']          = 'Edit Space';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['users']           = $this->Account_model->getALLUsers();
      $data['space']                = $this->Space_model->checkSpaceById($id);
      $data['useratteam']           = $this->Space_model->checkUserAtTeam($id);

      $userIds = array_column($data['useratteam'], 'id_user');
      $userIdsString = implode(',', $userIds);
  
      // Tambahkan string ID ke data yang akan dikirim ke view
      $data['userIdsString'] = $userIdsString;

      //print_r($data['userIdsString']);exit();
      $arrayuser         = $this->Space_model->checkUserAtTeam($id);


      $data['arrayuser'] = array_map(function($user) {
        return [
            'id' => $user['id_user'],
            'name' => $user['nama'],
            'profileUrl' => base_url('/assets/img/profile/' . $user['foto'])
        ];
        }, $arrayuser);
   
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('project/edit_workspace', $data);
      $this->load->view('template/footer', $data);
    }


    public function editSpace()
    {
         // Validasi input
         $this->form_validation->set_rules('namaworkspace', 'Space Name', 'required');
         $this->form_validation->set_rules('kategorispace', 'Kategori', 'required');

         if ($this->form_validation->run() == FALSE) {
             // Jika validasi gagal, kembali ke form dengan error
             redirect("workspace");
         } else {
             // Ambil data dari form
             $id_space          = $this->input->post('id_space');
             $space_name        = $this->input->post('namaworkspace');
             $category          = $this->input->post('kategorispace');
             $selected_users    = $this->input->post('selected_users'); // ID pengguna yang dipilih
            
             // Pisahkan ID pengguna yang dipilih menjadi array
             $user_ids = explode(',', $selected_users);

             // Tambahkan ID pengguna yang membuat workspace ke array user_ids
             $creator_id = $this->session->userdata('id');
             if (!in_array($creator_id, $user_ids)) {
                 $user_ids[] = $creator_id; // Menambahkan pengguna yang membuat workspace
             }

             if (count($user_ids) > 1) {
                $category = 'team'; // Ubah kategori menjadi "team" jika lebih dari 1 pengguna
             } else {
                $category = 'private'; 
             }

             $this->db->set('name_space', $space_name);
             $this->db->set('kategory_space', $category);
             $this->db->where('id_space', $id_space);
             $this->db->update('space');

             $this->Space_model->hapus_space($id_space);

              // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
            $workspace_id = $id_space;

            if($category == "team") { 
                // Tambahkan pengguna ke workspace
                if ($workspace_id) {
                    $this->Project_model->add_user_to_workspace($workspace_id, $user_ids, $creator_id);
                }
                } else {
                    if ($workspace_id) {
                        $this->Project_model->add_user_workspace($workspace_id, $creator_id);
                    }
                }

            // Redirect atau tampilkan pesan sukses
            $this->session->set_flashdata('success', 'Workspace berhasil diedit!');
            redirect('project');
         }
     
    }

    public function appInvitation() {
        $workspace_id = $this->input->post('workspace_id');
        $invitation_id = $this->input->post('invitation_id');
        $action = $this->input->post('action'); // 'accept' atau 'reject'
    
        if ($action == 'accept') {

            $this->db->set('approval_user', '2');
            $this->db->where('id_user', $invitation_id);
            $this->db->where('id_workspace', $workspace_id);
            $this->db->update('space_team');
            
        } elseif ($action == 'reject') {
            $this->db->set('approval_user', '1');
            $this->db->where('id_user', $invitation_id);
            $this->db->where('id_workspace', $workspace_id);
            $this->db->update('space_team');
            
        }
    
        // Redirect atau kembalikan response sesuai kebutuhan
        $this->session->set_flashdata('success', 'Workspace berhasil ditambahkan!');
    redirect('project');
    }

    public function toggle_favorite() {
        $workspace_id = $this->input->post('workspace_id');
        $user_id = $this->session->userdata('id'); // Asumsi user ID disimpan di session

        $is_favorite = $this->Space_model->toggle_favorite($workspace_id, $user_id);

        echo json_encode(['is_favorite' => $is_favorite]);
    }

    public function deleteSpace($id) {
        // Memeriksa apakah ada OKR terkait dengan space ini
        $spaceokr = $this->Space_model->checkSpaceOkr($id);
    
        foreach ($spaceokr as $sp) {
            $idproject = $sp['id_project'];
            // Memeriksa apakah ada OKR terkait dengan project ini
            $okr = $this->Project_model->checkOKRbyProject($idproject);
            foreach ($okr as $okr_item) {
                $idokr = $okr_item['id_okr'];
                // Memeriksa apakah ada Key Result terkait dengan OKR ini
                $keyresult = $this->Project_model->checkKrbyOKR($idokr);
                foreach ($keyresult as $kr_item) {
                    $idkr = $kr_item['id_kr'];
                    // Menghapus inisiatif yang terkait dengan Key Result
                    $this->Project_model->hapus_initiative_kr($idkr);
                    // Menghapus Key Result
                    $this->Project_model->hapus_key_result($idkr);
                }
                // Menghapus OKR
                $this->Project_model->hapus_okrall($idokr);
            }
            // Menghapus Project
            $this->Project_model->hapus_project($idproject);
        }
    
        // Menghapus Space dan Workspace
        $this->Space_model->hapus_space($id);
        $this->Space_model->hapus_workspace($id);
    
        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Workspace berhasil dihapus!');
        redirect('project');
    }

    public function chatInSpace(){
        $message    = $this->input->post('message');
        $user_id    = $this->input->post('user_id');
        $link       = $this->input->post('link');
        $idroom     = $this->input->post('idroom');

            // Cek apakah user sudah memiliki warna yang tersimpan di chatroom
            $this->db->select('color_mc');
            $this->db->from('message_chat');
            $this->db->where('user_id_mc', $user_id);
            $this->db->where('chatroom_id_mc', $idroom);
            $this->db->limit(1);
            $query = $this->db->get();
            $result = $query->row();

            if ($result) {
                $color = $result->color_mc;
            } else {
                // Jika belum, pilih warna secara acak
                $colors = ['#5603ad','#f3a4b5','#f5365c','#fb6340','#2dce89','#11cdef','#8965e0','#ffd600'];
                $color = $colors[array_rand($colors)];
            }
        
            $mention = null;
            if (preg_match('/@(\w+)\((.*?)\)/', $message, $matches)) {
                $mentionType = $matches[1];
                $mentionName = $matches[2];
                $mention = $mentionType . ':' . $mentionName; // Atur sesuai kebutuhan
            }

            if($link == ""){
                $link = NULL;
            }
        
            // Validasi dan sanitasi input
            if (!empty($message) && !empty($user_id)) {
                // Data workspace
                $data = array(
                    'user_id_mc'       => $user_id,
                    'chatroom_id_mc'   => $idroom,
                    'message_mc'       => $message,
                    'link_mc'          => $link,
                    'color_mc'         => $color, // Simpan warna di sini
                    'mention_mc'       => $mention,
                );

                
                $this->saveNotifMessage($idroom,$user_id,$message);
                // Simpan data ke database
                $this->Space_model->insert_message($data);
        
                // Kirim respon ke frontend
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
    }

    public function saveNotifMessage($idroom,$user_id,$message){
        $myid = $this->session->userdata('id');
        $chatroom = $this->Main_model->checkMyRoomChat($idroom);
        $namecr = $chatroom['name_mcr'];

        if($chatroom['id_project_rc'] == '0'){
            $idspace = $chatroom['id_space_rc'];

            $spaceteam = $this->Team_model->cekTeamSpace($idspace);

            $myurl = base_url('workspace/chatspace/' . $idspace . '/space');

            foreach($spaceteam as $result) {
                $accounttokens = $this->Account_model->getAccountById($result['id_user']);
                $name = $accounttokens['nama'];
                $workspace_sesi    = $this->session->userdata('workspace_sesi');

                $data = array(
                    'user_id'           => $result['id_user'],
                    'user_from'         => $myid,
                    'space_from'         => $workspace_sesi,
                    'title_notif'       => 'Pesan Baru dari '.$name.' di Ruangan bersama',
                    'message_notif'     => $message,
                    'data_notif'        => json_encode(array('url'=>$myurl,'type'=>'','idtask'=>'')),
                    'is_read_notif'     => 1,
                    'created_at_notif'  => date("Y-m-d H:i:s"),
                );
            
                $this->Main_model->input($data, 'notification');
                
                
                $tokens = $accounttokens['token_users'];
                if($tokens == '') {
                    $tokens == NULL;
                  }
            
                $data = array(
                    'user_id_notif_token'     => $result['id_user'],
                    'token_notif_token'       => $tokens,
                    'created_at_notif_token'  => date("Y-m-d H:i:s"),
                );
            
                $this->Main_model->input($data, 'notification_tokens');
            }

        } else {
            $idproject = $chatroom['id_project_rc'];
            $idspace = $chatroom['id_space_rc'];

            $pj = $this->Project_model->checkPjById($idproject);

            $idteam = $pj['id_team'];

            $team = $this->Team_model->checkAccTeamInObj($idteam);

            $myurl = base_url('workspace/chatspace/' . $idspace . '/space');

            foreach($team as $result) {
                $accounttokens = $this->Account_model->getAccountById($result['id_user']);
                $name = $accounttokens['nama'];
                $workspace_sesi    = $this->session->userdata('workspace_sesi');
                $data = array(
                    'user_id'           => $result['id_user'],
                    'user_from'         => $myid,
                    'space_from'        => $workspace_sesi,
                    'title_notif'       => 'Pesan Baru dari '.$name.' Ruangan ' . $namecr,
                    'message_notif'     => $message,
                    'data_notif'        => json_encode(array('url'=>$myurl,'type'=>'','idtask'=>'')),
                    'is_read_notif'     => 1,
                    'created_at_notif'  => date("Y-m-d H:i:s"),
                );
            
                $this->Main_model->input($data, 'notification');
                
                
                $tokens = $accounttokens['token_users'];

                if($tokens == NULL) {
                    $tokens == NULL;
                }
            
                $data = array(
                    'user_id_notif_token'     => $result['id_user'],
                    'token_notif_token'       => $tokens,
                    'created_at_notif_token'  => date("Y-m-d H:i:s"),
                );
            
                $this->Main_model->input($data, 'notification_tokens');
            }



        }

        return true;
       
    }

    public function chatFromDocSpace(){
        $message    = $this->input->post('textketerangan');
        $user_id    = $this->input->post('iduser');
        $link       = "document/index/" . $this->input->post('idproject');
        $idroom     = $this->input->post('chatroomid');
        $namadok    = $this->input->post('namadok');
        $idproject  = $this->input->post('idproject');
        $spaceid    = $this->input->post('spaceid');

        if($idroom == 0) {
                     // Data workspace
                     $data = array(
                        'id_space_rc'       => $spaceid,
                        'id_project_rc'     => $idproject,
                        'name_mcr'          => $namadok,
                        'created_at_mcr'    => date("Y-m-d H:i:s"),
                        'created_by_mcr	'   => $this->session->userdata("id"),
                    );
       
                // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
             $this->Space_model->insert_roommessage($data);
        }

        $generatemessage = '@document('.$namadok.') '. $message;
    
            // Cek apakah user sudah memiliki warna yang tersimpan di chatroom
            $this->db->select('color_mc');
            $this->db->from('message_chat');
            $this->db->where('user_id_mc', $user_id);
            $this->db->where('chatroom_id_mc', $idroom);
            $this->db->limit(1);
            $query = $this->db->get();
            $result = $query->row();

            if ($result) {
                $color = $result->color_mc;
            } else {
                // Jika belum, pilih warna secara acak
                $colors = ['#5603ad','#f3a4b5','#f5365c','#fb6340','#2dce89','#11cdef','#8965e0','#ffd600'];
                $color = $colors[array_rand($colors)];
            }
        
            $mention = null;
            if (preg_match('/@(\w+)\((.*?)\)/', $generatemessage, $matches)) {
                $mentionType = $matches[1];
                $mentionName = $matches[2];
                $mention = $mentionType . ':' . $mentionName; // Atur sesuai kebutuhan
            }
        
            // Validasi dan sanitasi input
            if (!empty($generatemessage) && !empty($user_id)) {
                // Data workspace
                $data = array(
                    'user_id_mc'       => $user_id,
                    'chatroom_id_mc'   => $idroom,
                    'message_mc'       => $generatemessage,
                    'link_mc'          => $link,
                    'color_mc'         => $color, // Simpan warna di sini
                    'mention_mc'       => $mention,
                );
        
                // Simpan data ke database
                $this->Space_model->insert_message($data);
        
                // Kirim respon ke frontend
                $response = ['success' => true];
            } else {
                $response = ['success' => false];
            }

            echo json_encode($response);      
    }

    public function loadMessageInSpace(){
        $idproject = $this->input->post("myprojectid");
        $idspace   = $this->input->post("workspacesesi");

        if($idproject == 0){
            $messages = $this->Space_model->dataMessagebySpace($idspace);
        } else {
            $messages = $this->Space_model->dataMessageInSpace($idproject);
        }

        // Kirim respon ke frontend
        echo json_encode(['messages' => $messages]);
    }

    public function loadMention(){
        $type = $this->input->post('type');
        $query = $this->input->post('query');
        $myprojectid = $this->input->post('myprojectid');

 
        
        switch ($type) {
            case 'objective':
                $table = 'okr';
                break;
            case 'key_result':
                $table = 'key_result';
                break;
            case 'document':
                $table = 'document';
                break;    
            default:
                $table = '';
                break;
        }
        if ($table) {
            if($table == 'document') {
                $mentions = $this->Space_model->dataDoc($table,$myprojectid);
                $response = array(
                    'table' => $type,
                    'mentions' => $mentions
                ); 
            } else {

                if($myprojectid == 0){
                    $mentions = $this->Space_model->dataObj($table,$myprojectid);
                    $response = array(
                        'table' => $type,
                        'mentions' => $mentions
                    );
                } else {
                    $mentions = $this->Space_model->dataObj($table,$myprojectid);
                    $response = array(
                        'table' => $type,
                        'mentions' => $mentions
                    );
                }
                
            }
         echo json_encode($response);
        } 
    }

    public function tambahChat($idspace,$idprject,$nama){

                   // Data workspace
                $data = array(
                    'id_space_rc'       => $idspace,
                    'id_project_rc'     => $idprject,
                    'name_mcr'          => $nama,
                    'created_at_mcr'    => date("Y-m-d H:i:s"),
                    'created_by_mcr	'   => $this->session->userdata("id"),
                );
   
            // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
            $this->Space_model->insert_roommessage($data);

        redirect("project/showOkr/" . $idprject);
    
    }

    public function tambahAnggota()
    {
        $idspace = $this->input->post("idspace");
        $usersend = $this->input->post("usersend");
        $statususer = $this->input->post("tambahstatususer");

       // print_r($statususer);exit();


        if($statususer == 'viewer') {
            $can_edit = false;
            $can_delete = false;
        } else if($statususer == 'editor') {
            $can_edit = true;
            $can_delete = false;
        } else {
            $can_edit = true;
            $can_delete = true;
        }

        foreach ($usersend as $iduser) {
            $data = array(
                'id_workspace'  => $idspace,
                'id_user'       => $iduser,
                'status_user'   => $statususer,
                'approval_user' => 1,
                'can_edit'      => $can_edit,
                'can_delete'    => $can_delete,
            );
        
            $this->db->insert('space_team', $data);
        }

        $response = array('status' => "success");
  
         echo json_encode($response);

    }

    public function selectAnggota()
    {
        $idteam     = $this->input->post("idteam");
        $statususer = $this->input->post("statususer");

        if($statususer == 'viewer') {
            $can_edit = false;
            $can_delete = false;
        } else if($statususer == 'editor') {
            $can_edit = true;
            $can_delete = false;
        } else {
            $can_edit = true;
            $can_delete = true;
        }

        $this->db->set('status_user', $statususer);
        $this->db->set('can_edit', $can_edit);
        $this->db->set('can_delete', $can_delete);
        $this->db->where('id', $idteam);
        $this->db->update('space_team');

        echo json_encode(['success' => true]);

    }

    public function selectAnggotaObj()
    {
        $idteam     = $this->input->post("idteam");
        $statususer = $this->input->post("statususerobj");


        if($statususer == 'viewer') {
            $can_edit = 0;
            $can_delete = 0;
        } else if($statususer == 'editor') {
            $can_edit = 1;
            $can_delete = 0;
        } else {
            $can_edit = 1;
            $can_delete = 1;
        }

        $this->db->set('role_user', $statususer);
        $this->db->set('can_edit_objective', $can_edit);
        $this->db->set('can_delete_objective', $can_delete);
        $this->db->where('id_access_objective', $idteam);
        $this->db->update('access_objective');

        echo json_encode(['success' => true]);
    }


    public function getTeamMembers($idspace) {
        $spaceteam = $this->Space_model->checkUserAtTeam($idspace);
    
        echo json_encode($spaceteam);
    }

    public function getTeamMembersObj($idokr) {
        $spaceteam = $this->Space_model->checkUserAtTeamObj($idokr);
    
        echo json_encode($spaceteam);
    }

    public function hapusAnggota() {
        // Memeriksa apakah ada OKR terkait dengan space ini
        // Menghapus Space dan Workspace
        $id = $this->input->post("idspaceteam");
      
        $this->Space_model->hapus_space_team($id);
    
        // Set flash message dan redirect
        echo json_encode(['success' => true]);
    }

    public function getMessages() {
        // Asumsikan Anda memiliki model `Message_model` yang mengambil data pesan
        $messages = $this->Main_model->getUnreadMessages(); // Mengambil pesan yang belum dibaca


        // Kembalikan data dalam format JSON
        echo json_encode(array('result' => $messages));
    }

    public function markAsRead() {
        $id_notif = $this->input->post('id_notif');
    
        if ($id_notif) {
            // Update database untuk menandai notifikasi sebagai dibaca
            $this->db->where('id_notif', $id_notif);
            $this->db->update('notification', array('is_read_notif' => 0));
    
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No ID provided'));
        }
    }


    public function markAsReadMeeting() {
        $id_notif = $this->input->post('id_notif');

        $idtask     = $this->input->post('idtask');

        $myid       = $this->session->userdata('id');
    
        if ($id_notif) {
            // Update database untuk menandai notifikasi sebagai dibaca
            $this->db->where('id_notif', $id_notif);
            $this->db->update('notification', array('is_read_notif' => 0));

            $this->db->where('id_task', $idtask);
            $this->db->update('task', array('approval_task_meet' => 0));

            $myNotif = $this->Main_model->checkMyNotification($id_notif);

            $notif      = $myNotif['message_notif'];
            $userid     = $myNotif['user_from'];
            $datanotif  = $myNotif['data_notif'];

            $dataArray = json_decode($datanotif, true);

            $url = base_url("calendar/viewall/");
            $type = 'task';
            $idtask = $dataArray['idtask'];
            
            $workspace_sesi    = $this->session->userdata('workspace_sesi');

            $data = array(
                'user_id'           => $userid,
                'user_from'         => $myid,
                'space_from'        => $workspace_sesi,
                'title_notif'       => 'Meeting Kamu di Ubah',
                'message_notif'     => 'Permintaan Ubah ' . $notif,
                'data_notif'        => json_encode(array('url'=>$url,'type'=>$type,'idtask'=>$idtask)),
                'is_read_notif'     => 1,
                'created_at_notif'  => date("Y-m-d H:i:s"),
              );
        
            $this->Main_model->input($data, 'notification');
            
            $accounttokens = $this->Account_model->getAccountById($userid);
            $tokens = $accounttokens['token_users'];
      
            if($tokens == '') {
              $tokens == NULL;
            }
        
            $data = array(
                'user_id_notif_token'     => $userid,
                'token_notif_token'       => $tokens,
                'created_at_notif_token'  => date("Y-m-d H:i:s"),
            );
        
            $this->Main_model->input($data, 'notification_tokens');
    
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No ID provided'));
        }
    }

    public function aprovalTask() {
        $id_notif   = $this->input->post('id_notif');

        $idtask     = $this->input->post('idtask');

        $myid       = $this->session->userdata('id');
    
        if ($id_notif) {
            // Update database untuk menandai notifikasi sebagai dibaca
            $this->db->where('id_notif', $id_notif);
            $this->db->update('notification', array('is_read_notif' => 0));

            $this->db->where('id_task', $idtask);
            $this->db->update('task', array('approval_task_meet' => 0));

            $myNotif = $this->Main_model->checkMyNotification($id_notif);

            $notif      = $myNotif['message_notif'];
            $userid     = $myNotif['user_from'];
            $datanotif  = $myNotif['data_notif'];

            $dataArray = json_decode($datanotif, true);

            $url = base_url("calendar/viewall/");
            $type = 'task';
            $idtask = $dataArray['idtask'];

            $workspace_sesi    = $this->session->userdata('workspace_sesi');

            $data = array(
                'user_id'           => $userid,
                'user_from'         => $myid,
                'space_from'         => $workspace_sesi,
                'title_notif'       => 'Meeting Kamu di Approve',
                'message_notif'     => 'Approve ' . $notif,
                'data_notif'        => json_encode(array('url'=>$url,'type'=>$type,'idtask'=>$idtask)),
                'is_read_notif'     => 1,
                'created_at_notif'  => date("Y-m-d H:i:s"),
              );
        
            $this->Main_model->input($data, 'notification');
            
            $accounttokens = $this->Account_model->getAccountById($userid);
            $tokens = $accounttokens['token_users'];
      
            if($tokens == '') {
              $tokens == NULL;
            }
        
            $data = array(
                'user_id_notif_token'     => $userid,
                'token_notif_token'       => $tokens,
                'created_at_notif_token'  => date("Y-m-d H:i:s"),
            );
        
            $this->Main_model->input($data, 'notification_tokens');
    
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No ID provided'));
        }
    }

    public function aprovalTaskInMsg($id,$idnotif) {
        $this->db->where('id_notif', $idnotif);
        $this->db->update('notification', array('is_read_notif' => 0));

        $this->db->where('id_task', $id);
        $this->db->update('task', array('approval_task_meet' => 0));


        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Pesan dihapus dihapus!');
        redirect('workspace/myNotification/');
    
       
    }

    public function rejectTask() {
        $id_notif = $this->input->post('id_notif');

        $idtask = $this->input->post('idtask');

        $myid       = $this->session->userdata('id');
    
        if ($id_notif) {
            // Update database untuk menandai notifikasi sebagai dibaca
            $this->db->where('id_notif', $id_notif);
            $this->db->update('notification', array('is_read_notif' => 0));
            
            $this->db->set('status_task',4);
            $this->db->set('approval_task_meet',2);
            $this->db->where('id_task', $idtask);
            $this->db->update('task');
            

            $myNotif = $this->Main_model->checkMyNotification($id_notif);

            $notif      = $myNotif['message_notif'];
            $userid     = $myNotif['user_from'];
            $datanotif  = $myNotif['data_notif'];

            $dataArray = json_decode($datanotif, true);

            $url = base_url("calendar/viewall/");
            $type = 'task';
            $idtask = $dataArray['idtask'];

            $workspace_sesi    = $this->session->userdata('workspace_sesi');

            $data = array(
                'user_id'           => $userid,
                'user_from'         => $myid,
                'space_from'        => $workspace_sesi,
                'title_notif'       => 'Meeting Kamu di Reject',
                'message_notif'     => 'Reject ' . $notif,
                'data_notif'        => json_encode(array('url'=>$url,'type'=>$type,'idtask'=>$idtask)),
                'is_read_notif'     => 1,
                'created_at_notif'  => date("Y-m-d H:i:s"),
              );
        
            $this->Main_model->input($data, 'notification');
            
            $accounttokens = $this->Account_model->getAccountById($userid);
            $tokens = $accounttokens['token_users'];
      
            if($tokens == '') {
              $tokens == NULL;
            }
        
            $data = array(
                'user_id_notif_token'     => $userid,
                'token_notif_token'       => $tokens,
                'created_at_notif_token'  => date("Y-m-d H:i:s"),
            );
        
            $this->Main_model->input($data, 'notification_tokens');
    
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No ID provided'));
        }
    }

    public function getNotificationsBySpace($id_space)
            {
                // Ambil data notifikasi berdasarkan id_space
                $data['messages']           = $this->Main_model->getAllMessagesBySpace($id_space);
               

                // Load view untuk menampilkan notifikasi
                $this->load->view('dashboard/notification_list', $data);
            }

    public function rejectTaskInMsg($id,$idnotif) {
        $this->db->where('id_notif', $idnotif);
        $this->db->update('notification', array('is_read_notif' => 0));

        $this->db->where('id_task', $id);
        $this->db->update('task', array('approval_task_meet' => 2));


        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Pesan dihapus dihapus!');
        redirect('workspace/myNotification/');
    
       
    }

    public function myNotification()
    {
      $data['title']          = 'Notifikasiku';
      $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['users']           = $this->Account_model->getALLUsers();

      $id = $this->session->userdata('id');

      $data['messages']           = $this->Main_model->getAllMessages();
      
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('dashboard/message', $data);
      $this->load->view('template/footer', $data);
    }

    public function get_messages_all($page = 1){
        $id = $this->session->userdata('id'); // Mengambil user ID dari session
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit; // Hitung offset berdasarkan halaman

        // Query untuk mengambil pesan dengan pagination
        $this->db->select('notification.*,users.nama,users.foto');
        $this->db->from('notification');
        $this->db->join('users', 'users.id = notification.user_from');
        $this->db->where('notification.user_id', $id);
        $this->db->order_by('notification.created_at_notif', 'DESC');
        $this->db->limit($limit, $offset); // Menambahkan LIMIT dan OFFSET
        $messages = $this->db->get()->result_array(); // Mengambil data

        // Menghitung total pesan untuk pagination
        $this->db->where('notification.user_id', $id);
        $total_messages = $this->db->count_all_results('notification');

        // Menghitung total halaman
        $total_pages = ceil($total_messages / $limit);

        // Response data dalam format JSON
        $response = array(
            'messages' => $messages,
            'total_pages' => $total_pages,
            'current_page' => $page,
        );

        echo json_encode($response);
    }


    public function deleteAll($id) {
        // Memeriksa apakah ada OKR terkait dengan space ini
        $this->Space_model->delete_message($id);

        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Pesan dihapus dihapus!');
        redirect('workspace/myNotification/');
    }


    public function deleteMessage($id) {
        // Memeriksa apakah ada OKR terkait dengan space ini
        $this->Space_model->delete_message_one($id);

        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Pesan dihapus dihapus!');
        redirect('workspace/myNotification/');
    }
    
    public function check_overdue_tasks() {
        $current_date = date('Y-m-d H:i:s');
        $overdue_tasks = $this->Main_model->get_overdue_tasks($current_date);
    
        echo json_encode($overdue_tasks);
    }

    public function chatSpace($id){
       $data['title']          = 'OKRE Chat';
       $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
       $data['users']          = $this->Account_model->getJoinUsers();
       $data['space']          = $this->Space_model->checkSpaceById($id);
    //    print_r($id);exit();
    //    $projectDelegasi       = $this->Project_model->getYourProjectDelegateNoAllLimit($id);
   
    //    $projects              = $this->Project_model->getYourProjectNoLimit($id);
 
    //     // Gabungkan data dengan ID project sebagai kunci
    //     $combinedData = [];
 
    //     // Tambahkan data dari projectDelegasi ke array gabungan
    //     foreach ($projectDelegasi as $delegate) {
    //         $projectId = $delegate['id_project']; // Sesuaikan dengan nama kolom ID project di tabel delegate_save
    //         if (!isset($combinedData[$projectId])) {
    //             $combinedData[$projectId] = $delegate;
    //         } else {
    //             // Menggabungkan data jika id_project sudah ada
    //             $combinedData[$projectId] = array_merge($combinedData[$projectId], $delegate);
    //         }
    //     }
 
    //     // Tambahkan data dari projects ke array gabungan
    //     foreach ($projects as $project) {
    //         $projectId = $project['id_project']; // Sesuaikan dengan nama kolom ID project di tabel projects
    //         if (!isset($combinedData[$projectId])) {
    //             $combinedData[$projectId] = $project;
    //         } else {
    //             // Menggabungkan data jika project_id sudah ada
    //             $combinedData[$projectId] = array_merge($combinedData[$projectId], $project);
    //         }
    //     }
 
    //     $data['projects'] = $combinedData;

        $projectDelegasi       = $this->Project_model->getYourProjectDelegate($id);
    
        $projects              = $this->Project_model->getYourProject($id);

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

        $data['chat']  = $this->Project_model->cekChat('0',$id);

       $this->load->view('template/header', $data);
       $this->load->view('template/sidebar', $data);
       $this->load->view('template/topbar', $data);
       $this->load->view('invitation/chatspace', $data);
       $this->load->view('template/footer', $data);
    }

    public function cek_chat() {
        // Ambil data dari POST request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        // Ambil nilai id_project dan workspace_sesi dari request
        $id_project = $data['id_project'];
        $workspace_sesi = $data['workspace_sesi'];
    
        // Jalankan query untuk cek chat
        $chat = $this->Project_model->cekChat($id_project, $workspace_sesi);

        if(empty($chat)) {
            $pj = $this->Project_model->checkPjById($id_project);

            $namapj = $pj['nama_project'];

            $data = array(
                'id_space_rc'       => $workspace_sesi,
                'id_project_rc'     => $id_project,
                'name_mcr'          => $namapj,
                'created_at_mcr'    => date("Y-m-d H:i:s"),
                'created_by_mcr	'   => $this->session->userdata("id"),
            );

        // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
        $this->Space_model->insert_roommessage($data);
        }
    
        // Kembalikan hasil dalam format JSON
        echo json_encode(['id_mcr' => $chat['id_mcr']]);
    }

    public function tambahRoom($idspace,$nama){
            // Data workspace
            $data = array(
                'id_space_rc'       => $idspace,
                'id_project_rc'     => 0,
                'name_mcr'          => $nama,
                'created_at_mcr'    => date("Y-m-d H:i:s"),
                'created_by_mcr	'   => $this->session->userdata("id"),
            );

        // Simpan data ke database dan ambil ID workspace yang baru ditambahkan
        $this->Space_model->insert_roommessage($data);

        redirect("workspace/chatspace/" . $idspace . "/space");

        }

    public function editMySpace($id)
    {
           // Ambil data dari form
           $namespace   = $this->input->post('namespace');
           $desc        = $this->input->post('descfrommodal');
         
           $this->db->set('name_space', $namespace);
           $this->db->set('desc_space', $desc);
           $this->db->where('id_space', $id);
           $this->db->update('space');

          // Redirect atau tampilkan pesan sukses
          $this->session->set_flashdata('success', 'Workspace berhasil diedit!');
          redirect('project/projectAtWorkspace/' .$id);
       
    }


}