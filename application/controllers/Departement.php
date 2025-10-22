<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Departement extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Departement_model');
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
    $data['title']        = 'Data Departement';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['divisi']  = $this->Departement_model->getDivision();


    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('departement/departement', $data);
    $this->load->view('template/footer', $data);
  }

  public function division()
  {
  $data['title']        = 'Data Departement';
  $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
  $data['departement']  = $this->Departement_model->getAllDepartement();
  $data['divisi']                 = $this->Departement_model->getDivision();

  $this->load->view('template/header', $data);
  $this->load->view('template/sidebar', $data);
  $this->load->view('template/topbar', $data);
  $this->load->view('departement/division', $data);
  $this->load->view('template/footer', $data);
  }

public function jabatan()
  {
  $data['title']        = 'Data Departement';
  $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
  $data['departement']  = $this->Departement_model->getAllDepartement();
  $this->load->library('pagination');

    // Konfigurasi pagination
    $config['base_url'] = base_url('departement/jabatan');
    $config['total_rows'] = $this->Departement_model->countAllJabatan(); // Jumlah total baris data
    $config['per_page'] = 10; // Jumlah data per halaman
    $choice = $config["total_rows"] / $config["per_page"];
    $config["num_links"] = floor($choice);

    // Membuat Style pagination untuk BootStrap v4
    $config['first_link']       = '<i class="fas fa-chevrons-right"></i>';
    $config['last_link']        = '<i class="fas fa-chevrons-left"></i>';
    $config['next_link']        = '<i class="fas fa-chevron-right"></i>';
    $config['prev_link']        = '<i class="fas fa-chevron-left"></i>';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Inisialisasi konfigurasi pagination
    $this->pagination->initialize($config);

    // Ambil data jabatan dari model
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $data['jabatan']  = $this->Departement_model->getAllJabatan($config['per_page'], $page);

    // print_r($config['total_rows']);exit();   

  $this->load->view('template/header', $data);
  $this->load->view('template/sidebar', $data);
  $this->load->view('template/topbar', $data);
  $this->load->view('departement/jabatan', $data);
  $this->load->view('template/footer', $data);
  }

  public function inputDepartement()
  {
    $id_departement     = $this->input->post('id_departement');
    $no_departement     = $this->input->post('no_departement');
    $nama_departement   = $this->input->post('nama_departement');
    $alamat_departement = $this->input->post('alamat_departement');
    $id_divisi     = $this->input->post('divisi');


    $data = array(
      'id_departement'           => $id_departement,
      'no_departement'          => $no_departement,
      'nama_departement'    => $nama_departement,
      'alamat_departement'  => $alamat_departement,
      'id_divisi'                          => $id_divisi
    );

    $this->Departement_model->input_departement($data, 'departement');
    $this->session->set_flashdata('flashDept', 'Ditambahkan');
    redirect('departement/index');
  }

  public function inputDivisi()
  {
    $nama_divisi   = $this->input->post('nama_divisi');
    $created_date     = date('Y-m-d');


    $data = array(
      'nama_divisi'                   => $nama_divisi,
      'created_date'                 => $created_date
    );

    $this->Departement_model->input_divisi($data, 'divisi');
    $this->session->set_flashdata('flashDept', 'Ditambahkan');
    redirect('departement/division');
  }

  public function inputJabatan()
  {
    $nama_jabatan   = $this->input->post('nama_jabatan');
    $level_jabatan     = $this->input->post('level_jabatan');
    $id_departement     = $this->input->post('id_departement');


    $data = array(
      'nama_jabatan'        => $nama_jabatan,
      'level_jabatan'         => $level_jabatan,
      'id_departement'    => $id_departement,
      'id_jabdivision'        => '0',
      'mapping_hirarki'   => '0'
    );

    $this->Departement_model->input_jabatan($data, 'jabatan');
    $this->session->set_flashdata('flashDept', 'Ditambahkan');
    redirect('departement/jabatan');
  }

  public function editDepartement($id)
  {
    $data['title']        = 'Edit Departement | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getDepartementById($id);

    $this->form_validation->set_rules('no_departement', 'No Departement', 'required');
    $this->form_validation->set_rules('nama_departement', 'Nama Departement', 'required');
    $this->form_validation->set_rules('alamat_departement', 'Alamat Departement', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('departement/departement_edit', $data);
      $this->load->view('template/footer', $data);
    } else {
      $id_departement       = $this->input->post('id_departement');
      $no_departement       = $this->input->post('no_departement');
      $nama_departement     = $this->input->post('nama_departement');
      $alamat_departement   = $this->input->post('alamat_departement');

      $this->db->set('no_departement', $no_departement);
      $this->db->set('nama_departement', $nama_departement);
      $this->db->set('alamat_departement', $alamat_departement);
      $this->db->where('id_departement', $id);
      $this->db->update('departement');


      $this->session->set_flashdata('flashDept', 'Ditambahkan');
      redirect('departement/index');
    }
  }

  public function editDivisi($id)
  {
    $data['title']        = 'Edit Divisi | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['divisi']  = $this->Departement_model->getDivisiById($id);

    $this->form_validation->set_rules('nama_divisi', 'Nama Divisi', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('departement/divisi_edit', $data);
      $this->load->view('template/footer', $data);
    } else {
      $id_divisi       = $this->input->post('id_divisi');
      $nama_divisi     = $this->input->post('nama_divisi');

      $this->db->set('nama_divisi', $nama_divisi);
      $this->db->where('id_divisi', $id);
      $this->db->update('divisi');


      $this->session->set_flashdata('flashDept', 'Ditambahkan');
      redirect('departement/division');
    }
  }

  public function editJabatan($id)
  {
    $data['title']        = 'Edit Jabatan | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['jabatan']  = $this->Departement_model->getJabatanById($id);
    $data['departement']  = $this->Departement_model->getAllDepartement();

    $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required');
    $this->form_validation->set_rules('level_jabatan', 'Level Jabatan', 'required');
    $this->form_validation->set_rules('id_departement', 'Departement', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('departement/jabatan_edit', $data);
      $this->load->view('template/footer', $data);
    } else {
      $nama_jabatan   = $this->input->post('nama_jabatan');
      $level_jabatan     = $this->input->post('level_jabatan');
      $id_departement     = $this->input->post('id_departement');

      $this->db->set('nama_jabatan', $nama_jabatan);
      $this->db->set('level_jabatan', $level_jabatan);
      $this->db->set('id_departement', $id_departement);
      $this->db->where('id_jabatan', $id);
      $this->db->update('jabatan');


      $this->session->set_flashdata('flashDept', 'Ditambahkan');
      redirect('departement/jabatan');
    }
  }

  public function deleteDepartement($id)
  {
    $this->Departement_model->hapus_departement($id);
    $this->session->set_flashdata('flashDept', 'Dihapus');
    redirect('departement');
  }

  public function deleteDivisi($id)
  {
    $this->Departement_model->hapus_divisi($id);
    $this->session->set_flashdata('flashDept', 'Dihapus');
    redirect('departement/division');
  }

  public function deleteJabatan($id)
  {
    $this->Departement_model->hapus_jabatan($id);
    $this->session->set_flashdata('flashDept', 'Dihapus');
    redirect('departement/jabatan');
  }
}
