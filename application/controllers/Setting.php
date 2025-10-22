<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in_okr') != TRUE) {
      redirect('auth');
    }
    $this->load->helper('url', 'form');
    $this->load->library('form_validation');
    $this->load->model('Account_model');
    $this->load->model('Departement_model');
    $this->load->model('Main_model');

    $usernamesession = $this->session->userdata('username');
     
    $validatelogin = $this->Main_model->getUserLogin($usernamesession);

    if(empty($validatelogin)){
     redirect('auth/backlogin');
    } 
  }

  public function index()
  {
    //load model
    $data['title']      = 'Setting My Profile';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']      = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();


    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('dashboard/setting', $data);
    $this->load->view('template/footer');
  }


  public function signatureview()
  {

    $data['title']      = 'Setting My Profile';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']      = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('dashboard/setting_signature', $data);
    $this->load->view('template/footer');
  }

  public function edit()
  {
    $data['title']    = 'Edit Profile';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']    = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();

    $this->form_validation->set_rules('nama', 'Full Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('dashboard/setting', $data);
      $this->load->view('template/footer');
    } else {
      $id              = $this->input->post('id');
      $username        = $this->input->post('username');
      $usernamelama    = $this->input->post('usernamelama');
      $nama            = $this->input->post('nama');
      $email           = $this->input->post('email');
      $no_hp           = $this->input->post('no_hp');
      $alamat          = $this->input->post('alamat');
      $foto            = $_FILES['foto'];

      if ($foto) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '50000';
        $config['upload_path']   = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
          $new_image = $this->upload->data('file_name');
          $this->resizeImage($new_image);
          $this->db->set('foto', $new_image);
        } else {
          echo $this->upload->display_errors();
        }
      }

      
      $this->db->set('username', $username);
      $this->db->set('nama', $nama);
      $this->db->set('email', $email);
      $this->db->set('no_hp', $no_hp);
      $this->db->set('alamat', $alamat);
      $this->db->where('username', $usernamelama);
      $this->db->update('users');

      if($username != $usernamelama){
        $this->session->sess_destroy();
        redirect('auth/backloginset');
      } else {
        redirect('setting');
      }
     
    }
  }

  public function resizeImage($filename)
   {
      $source_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/profile/' . $filename;
      $target_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/profile/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => FALSE,
          'create_thumb' => FALSE,
          'width' => 240,
          'height' => 240
      );


      $this->load->library('image_lib', $config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }


      $this->image_lib->clear();
   }

   public function changepassword() {
    $data['title']        = 'Change Password';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']        = $this->db->get_where('users', ['id' => $this->session->userdata('id')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
    $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');


    if ($this->form_validation->run() == false) {
    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('dashboard/setting_password', $data);
    $this->load->view('template/footer');
    } else {

      $post = $this->input->post();
      $data = array(
        'password' => md5($post['new_password1']),
      );


          $this->db->where('id', $this->session->userdata('id'));
          $this->db->update('users',$data);

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
          redirect('setting/changepassword');

        }
        
      }

      public function editsignature() {
        if ($_FILES['signature_photo']['name']) {
            $config['upload_path'] = './assets/img/signature/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
    
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('signature_photo')) {
                $new_image = $this->upload->data('file_name');
    
                // Hapus tanda tangan lama jika ada
                $current_image = $this->input->post('current_signature_photo');
                if ($current_image != 'default.png') {
                    unlink(FCPATH . 'assets/img/signature/' . $current_image);
                }
    
                // Simpan tanda tangan baru
                $this->Account_model->update_signature($this->session->userdata('id'), $new_image);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tanda tangan berhasil diupdate!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
            }
        }
    
        redirect('setting/signatureview');
    }
    
}

   


