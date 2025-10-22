<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('Departement_model');
    $this->load->model('Account_model');
    $this->load->library('form_validation');
    $this->load->helper('url', 'form');
  }


  public function index()
  {
    $data['title'] = 'Register | OKR';
    $data['departement']  = $this->Departement_model->getAllDepartement();
   // $data['jabatan'] = $this->Departement_model->getAllJabatanViewWithReview();

    //load model
    $this->load->view('auth/register', $data);
  }

  public function registerSuccess()
  {
    $data['title'] = 'Register | OKR';
    $this->load->view('auth/registersuccess', $data);
  }

  public function check_username_exists($username)
  {
    $this->form_validation->set_message('check_username_exists', 'Username Sudah diambil. Silahkan gunakan username lain');

    if ($this->Account_model->check_username_exists($username)) {
      return true;
    } else {
      return false;
    }
  }
  public function check_email_exists($email)
  {
      if ($this->Account_model->is_email_exists($email)) {
          $this->form_validation->set_message('check_email_exists', 'Email sudah ada di database. Silakan gunakan email lain.');
          return FALSE;
      } else {
          return TRUE;
      }
  }

  public function inputRegister()
  {
    $data['title'] = 'Register | OKR';

    $this->form_validation->set_rules(
      'username',
      'Username',
      'required|callback_check_username_exists'
    );

    $this->form_validation->set_rules(
      'email',
      'Email',
      'required|valid_email|callback_check_email_exists'
     );
 
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('auth/register', $data);
    } else {
      $username         = $this->input->post('username');
      $nama             = $this->input->post('nama');
      $email            = $this->input->post('email');
      $no_hp            = $this->input->post('no_hp');
      // $jabatan          = $this->input->post('jabatan');
      // $id_departement   = $this->input->post('id_departement');
      $password         = $this->input->post('password');
      $foto             = 'default.jpg';
      $state            = '1';

      $data = array(
        'username'        => $username,
        'password'        => md5($password),
        'nama'            => $nama,
        'email'           => $email,
        'no_hp'           => $no_hp,
        'id_jabatan'      => 0,
        'id_departement'  => 0,
        'foto'            => $foto,
        'role_id'         => '1',
        'state'           => '2'
      );

      $this->Account_model->input_account($data, 'users');
      //   $this->session->set_flashdata('flashAc c', 'Ditambahkan');
      redirect('register/registerSuccess');
    }
  }
}
