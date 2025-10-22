<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

defined('BASEPATH') or exit('No direct script access allowed');

class Invitation extends CI_Controller
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
        $data['title']          = 'Data Project OKR';
        $data['users_name']     = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
        $data['project']        = $this->Project_model->getProjectJoinUser();
        $data['team']           = $this->Team_model->getALLTeam();
        $data['users']           = $this->Account_model->getALLUsers();
        $data['departement']    = $this->Departement_model->getAllDepartement();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('invitation/invitation', $data);
        $this->load->view('template/footer', $data);
    }
}