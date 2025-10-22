<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Seedocument extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url', 'form');
    $this->load->library('form_validation');
    $this->load->model('Account_model');
    $this->load->model('Departement_model');
    $this->load->model('Space_model');
    $this->load->model('Main_model');
  }

  public function index()
  {
    $data['title']      = 'Setting My Profile';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']      = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();

    $this->load->view('userview/userview', $data);
  }

  public function documentview($idbarcode)
  {
    $data['title']      = 'Document';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']      = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();


    // Ambil 4 angka di depan dan 2 angka di belakang
    $first_part = substr($idbarcode, 0, 4);   // Mengambil 4 angka pertama: '2024'
    $last_part = substr($idbarcode, -2);      // Mengambil 2 angka terakhir: '69'

    // Gabungkan dengan format yang diinginkan
    $result =  $first_part . $last_part . '######';

    $data['file'] = $this->Main_model->checkFileByBarcode($idbarcode);
    $data['generate'] = $result;

    $iddocument = 0;
    $idpj = 0;
    if($data['file'] != "") {
      $iddocument = $data['file']['id_document_users'];

      $checkpj    = $this->Space_model->cekProjecteDoc($iddocument);

    $idpj       = $checkpj['id_project'];
    $idspace       = $checkpj['id_space'];
    }

    

    $data['namafolder'] = checkSpaceById($idspace);
    
    

    $this->load->view('userview/userview', $data);
  }
}
