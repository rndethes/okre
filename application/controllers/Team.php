<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Team extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Account_model');
    $this->load->model('Team_model');
    $this->load->model('Project_model');
    $this->load->model('Main_model');
    $this->load->model('Departement_model');
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
    
    $data['title']        = 'Data Team OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']        = $this->Account_model->getALLUsers();
    $data['team']         = $this->Team_model->getAllTeamLead();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['countteam']    = $this->Main_model->countAllTeam();
    


    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('team/team', $data);
    $this->load->view('template/footer', $data);
  }
  public function inputTeam()
  {
    $id_user     = $this->session->userdata('id');
    $nama_team   = $this->input->post('nama_team');
    $keterangan  = $this->input->post('keterangan');
    $created_at  = date("Y-m-d H:i:s");


    $data = array(
      'nama_team'  => $nama_team,
      'keterangan' => $keterangan,
      'created_at' => $created_at
    );

    $this->Team_model->input_team($data, 'team');

    $team = $this->Team_model->getTeamLast();
    
    foreach ($team as $team) {
      $id_teamlast = $team['id_team'];
    }


    $dataacc = array(
      'id_team'   => $id_teamlast,
      'id_user'   => $id_user
    );

   $this->Team_model->input_teamacc($dataacc, 'access_team');

    $this->session->set_flashdata('flashTm', 'Ditambahkan');
    redirect('team/index');
  }

  public function detailTeam($id)
  {
    $data['title']        = 'Detail Team';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    //$data['users']        = $this->Team_model->getUserByJabatan();
    //$data['users']        = $this->Team_model->getUserActiveInSpace();
    $data['team']         = $this->Team_model->getTeamById($id);
    $data['project']      = $this->Team_model->getProjectByTeam($id);
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['team_acc']     = $this->Team_model->getTeamAcc();
   // $data['depart']       = $this->Team_model->getDepartByDivisi();

    $sesiworkspace = $this->session->userdata('workspace_sesi');
    
    $data['users']        = $this->Team_model->getUserActiveInSpace($sesiworkspace);

    $data['totalmember']  = count($data['team_acc']);

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('team/team_detail', $data);
    $this->load->view('template/footer');
  }

  public function deleteTeam($id)
  {
    $this->Team_model->delete_team($id);
    $this->session->set_flashdata('flashTm', 'Dihapus');
    redirect('team');
  }

  public function editTeam($id)
  {
    $data['title']        = 'Edit Team | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['team']         = $this->Team_model->getTeamById($id);
    $data['departement']  = $this->Departement_model->getAllDepartement();

    $this->form_validation->set_rules('id_team', 'ID Team', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('team/team_edit', $data);
      $this->load->view('template/footer', $data);
    } else {
      $id_team    = $this->input->post('id_team');
      $nama_team  = $this->input->post('nama_team');
      $keterangan = $this->input->post('keterangan');

      $this->db->set('nama_team', $nama_team);
      $this->db->set('keterangan', $keterangan);
      $this->db->where('id_team', $id_team);
      $this->db->update('team');

      $this->session->set_flashdata('flashTm', 'Ditambahkan');
      redirect('team');
    }
  }

  public function inputUserTeam()
  {
    $select       = $this->input->post('adduser');
    $id_dep     = $this->session->userdata('id_departement');
    // print_r($id_dep);exit();

    $id       = $this->input->post('id');
    $id_team  = $this->input->post('id_team');
    if ($select == 1) {
      $id_dep = $this->input->post('id_depart[]');
      $id_user = $this->Team_model->getUserByDepartement($id_dep);
      
      foreach($id_user as $idu) {
        $check = $this->Team_model->checkAccTeam($id_team, $idu['id']);
        if (empty($check)) {
          $data =  array(
            'id_team' => $id_team,
            'id_user' => $idu['id'],
            'role_user' => '1'
          );
          // print_r($data);exit();
          $this->Team_model->input_teamacc($data, 'access_team');
        }
      }
    } else if ($select == 2) {
      $id_user  = $this->input->post('id_user[]');
      $ids = count($id_user);

      for ($i = 0; $i < $ids; $i++) {
        $check = $this->Team_model->checkAccTeam($id_team, $id_user[$i]);
        if (empty($check)) {  
          $data =  array(
            'id_team' => $id_team,
            'id_user' => $id_user[$i],
            'role_user' => '1'
          );
          // print_r($data);exit();
          $this->Team_model->input_teamacc($data, 'access_team');
        }
      }
    }
    

    $this->session->set_flashdata('flashTm', 'Ditambahkan');
    redirect('team/detailTeam/' . $id);
  }

  public function editRoleUser($id)
  {
      $role       = $this->input->post('editrole');
      $id_team       = $this->input->post('id_team');

      $this->db->set('role_user', $role);
      $this->db->where('id_access_team', $id);
      $this->db->update('access_team');


      $this->session->set_flashdata('flashDept', 'Ditambahkan');
      redirect('team/detailTeam/'. $id_team);
  }

  public function deleteTeamAcc($id)
  {
    $team = $this->Team_model->getTeamAccByID($id);

    foreach ($team as $tm) {
      $id_team    = $tm['id_team'];
    }
    
    $this->Team_model->delete_teamacc($id);
    $this->session->set_flashdata('flashTm', 'Dihapus');
    redirect('team/detailTeam/' . $id_team);
  }

  public function inputTeamBalqi($idpjkr)
  {
        $checkObj = $this->Project_model->checkOKRbyProject($idpjkr);

        foreach($checkObj as $obj){
          $id_team = $obj['id_team'];

          $checkTeam = $this->Team_model->checkAccTeamInObj($id_team);

          foreach($checkTeam as $ct) {
          $data =  array(
            'id_objective'              => $obj['id_okr'],
            'id_user'                   => $ct['id_user'],
            'role_user'                 => 'admin',
            'can_edit_objective'        => 1,
            'can_delete_objective'      => 1
          );

          $this->Team_model->input_teamacc($data, 'access_objective');
        }
      }

      $this->session->set_flashdata('flashOkr', 'Ditambahkan');
      redirect('project/showOkr/' . $idpjkr);
  }

}
