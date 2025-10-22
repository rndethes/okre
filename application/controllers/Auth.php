<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    // $this->load->model('Main_model');
    $this->load->helper('url');
    if ($this->session->userdata('logged_in_okr') == TRUE) {
      redirect('dashboard');
    
    } 
  }


  public function index()
  {
    $data['title'] = 'Login | OKR';
    //load model
    $this->load->view('auth/login', $data);
  }

  function create_alert($message)
  {
    print_r("<script type='text/javascript'>alert('" . $message . "')</script>");
  }

  public function login()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    $data['title'] = 'Login | OKR';

    if ($this->form_validation->run() == FALSE) {
      $this->create_alert("empty");
      redirect('auth');
      //  $this->load->view('auth/login', $data);
    } else {
      $this->do_login();
    }
  }

  private function do_login()
  {
    $this->load->library('session');
    $username = $this->input->post('username');
    $password = md5($this->input->post('password'));

    $data['title'] = 'Login | OKR';

    $users = $this->db->get_where('users', ['username' => $username])->row_array();

    if (!empty($users)) {
      $password_db      = $users['password'];
      $id               = $users['id'];
      $username         = $users['username'];
      $nama             = $users['nama'];
      $email            = $users['email'];
      $no_hp            = $users['no_hp'];
      $id_jabatan    = $users['id_jabatan'];
      $jabatan          = $users['jabatan'];
      $alamat           = $users['alamat'];
      $id_departement   = $users['id_departement'];
      $foto             = $users['foto'];
      $id_kantor  = $users['id_kantor'];
      $role_id          = $users['role_id'];
      $state            = $users['state'];

      if ($password == $password_db) {
        $session_data = array(
          'id'              => $id,
          'username'        => $username,
          'nama'            => $nama,
          'email'           => $email,
          'no_hp'           => $no_hp,
          'id_jabatan'   => $id_jabatan,
          'jabatan'         => $jabatan,
          'alamat'          => $alamat,
          'id_departement'  => $id_departement,
          'foto'            => $foto,
          'id_kantor' => $id_kantor,
          'role_id'         => $role_id,
          'state'           => $state,
          'logged_in_okr'   => TRUE,
          'dataidkr'        => 0
        );
        if ($state == 1) {
          $this->session->set_flashdata('msg', 'Akun Sudah Di Non Aktifkan!!!');
          $this->load->view('auth/login', $data);
        } else {

          

          $this->session->set_userdata($session_data);
          redirect('dashboard');
        }
      } else {
        $this->session->set_flashdata('msg', 'Password yang Anda Masukan Salah!');
        $this->load->view('auth/login', $data);
      }
    } else {
      $this->session->set_flashdata('msg', 'Username tidak ditemukan');
      $this->load->view('auth/login', $data);
    }
  }

 

  function backlogin()
  {
    $this->load->view('template/backlogin');
  }

   function backloginset()
  {
    $this->load->view('template/backloginafterchange');
  }
}
