<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Account extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Account_model');
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
    $data['title']      = 'Data Account OKR';
    $data['users_name'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']      = $this->Account_model->getJoinUsers();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['jabatan'] = $this->Account_model->getJabatan();
    $data['kantor'] = $this->Departement_model->getOffice();
    // print_r($data['kantor']);exit();

    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('account/account', $data);
    $this->load->view('template/footer', $data);
  }

  public function getDataAcc()
  {
    $result = $this->Account_model->getDataTableAcc();
    $data   = [];
    $no     = $_POST['start'];

    foreach ($result as $result) {
      $row    = array();
      $row[]  = ++$no;
      // $row[] = $acc_team;
      $row[]  = '<th scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="' . base_url('assets/img/profile/') . $result->foto . '">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">' . $result->nama . '</span>
                        </div>
                      </div>
                    </th>';
      $row[]  = $result->username;
      $row[]  = $result->no_hp;
      // $row[]  = $result->jabatan;
      $row[]  = $result->nama_departement;


      $row[] = '
      <select class="form-control tableselect" id="role_id" name="roleid" data-id="' . $result->id . '">
    <option value="1" ' . ($result->role_id == 1 ? "selected" : "") . '>Company</option>
    <option value="2" ' . ($result->role_id == 2 ? "selected" : "") . '>Leader</option>
    <option value="3" ' . ($result->role_id == 3 ? "selected" : "") . '>Staff</option>
                      </select>
           <script>
        $(document).ready(function() {
          $("select[name=roleid]").change(function() {
            var role_id = $(this).children("option:selected").val();
            //var roleid = $(this).val();
            var id = $(this).data("id");
            $.ajax({
              type: "POST",
              url: "' . base_url('account/changeRole') . '" ,
              data: {
                role_id: role_id,
                id: id
              },
              beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $("#overlay").fadeIn(300);
              },
              success: function(result) {
                $("#display").html(result);
              },
              complete: function() { // Set our complete callback, adding the .hidden class and hiding the spinner.
                setTimeout(function() {
                  $("#overlay").fadeOut(300);
                }, 500);
              },
            });
          });
        });
      </script>';
      if ($result->state == 2) {
        $row[] = '<td>
        <label class="custom-toggle">
            <input id="cheak" name="state" data-id="' . $result->id . '" value="1" type="checkbox" checked>
         
            <span class="custom-toggle-slider"></span></label></td>';
      } else {
        $row[] = '<td>
        <label class="custom-toggle">
          
            <input id="cheak" name="state" data-id="' . $result->id . '" value="0" type="checkbox">
            <span class="custom-toggle-slider"></span></label></td>';
      }

      $row[] = '
      <a href="' . base_url('account/editAccount/') . $result->id . '" class="btn btn-warning btn-sm rounded-pill">
                          <span class="btn--inner-icon">
                            <i class="ni ni-settings"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
                        <a data-target="' . base_url('account/deleteAccount/') . $result->id . '" class="btn btn-danger tombol-hapus btn-sm rounded-pill text-white">
                          <span class="btn--inner-icon">
                            <i class="fas fa-trash"></i></span>
                          <span class="btn-inner--text"></span>
                        </a>
      ';
      $data[] = $row;
    }

    $output   = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->Account_model->count_all_data(),
      "recordsFiltered" => $this->Account_model->count_filtered_data(),
      "data"            => $data,
    );

    // print_r($output);
    // exit();
    $this->output->set_content_type('application/json')->set_output(json_encode($output));
  }

  public function inputAccount()
  {
    $username         = $this->input->post('username');
    $nama             = $this->input->post('nama');
    $email            = $this->input->post('email');
    $no_hp            = $this->input->post('no_hp');
    $jabatan          = $this->input->post('jabatan');
    $alamat           = $this->input->post('alamat');
    $id_departement   = $this->input->post('id_departement');
    $id_kantor  = $this->input->post('id_kantor');
    $role_id          = $this->input->post('role_id');
    $password         = $this->input->post('password');
    $foto             = 'default.jpg';
    $state            = '2';

    $data = array(
      'username'        => $username,
      'password'        => md5($password),
      'nama'            => $nama,
      'email'           => $email,
      'no_hp'           => $no_hp,
      'id_jabatan'         => $jabatan,
      'jabatan'         => 'Staff',
      'alamat'          => $alamat,
      'id_departement'  => $id_departement,
      'foto'            => $foto,
      'id_kantor' => $id_kantor,
      'role_id'         => $role_id,
      'state'           => $state
    );

    $this->Account_model->input_account($data, 'users');
    $this->session->set_flashdata('flashAcc', 'Ditambahkan');
    redirect('account/index');
  }

  public function editAccount($id)
  {
    $data['title']        = 'Edit Account | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['users']        = $this->Account_model->getAccountById($id);
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['jabatan'] = $this->Account_model->getJabatan();
    $data['kantor'] = $this->Departement_model->getOffice();

    $this->form_validation->set_rules('id', 'ID', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('account/account_edit', $data);
      $this->load->view('template/footer', $data);
    } else {

      
    $username         = $this->input->post('username');
    $nama             = $this->input->post('nama');
    $email            = $this->input->post('email');
    $no_hp            = $this->input->post('no_hp');
    $jabatan          = $this->input->post('jabatan');
    $alamat           = $this->input->post('alamat');
    $id_departement   = $this->input->post('id_departement');
    $id_kantor  = $this->input->post('id_kantor');
    $role_id          = $this->input->post('role_id');
      // $password        = $this->input->post('password');
      $foto            = $_FILES['foto'];


      if ($foto) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '2048';
        $config['upload_path']   = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
          $new_image = $this->upload->data('file_name');
          $this->db->set('foto', $new_image);
        } else {
          echo $this->upload->display_errors();
        }
      }


      $this->db->set('username', $username);
      $this->db->set('nama', $nama);
      $this->db->set('email', $email);
      $this->db->set('no_hp', $no_hp);
      $this->db->set('jabatan', $jabatan);
      $this->db->set('alamat', $alamat);
      $this->db->set('id_departement', $id_departement);
      $this->db->set('id_kantor', $id_kantor);
      $this->db->set('role_id', $role_id);
      // $this->db->set('password', $password);
      $this->db->where('id', $id);
      // echo "<pre>";
      // exit();
      $this->db->update('users');
      $this->session->set_flashdata('flashAcc', 'Diedit');
      redirect('account');
    }
  }

  public function deleteAccount($id)
  { 
    $account = $this->Account_model->getAccountById($id);
    $filename = $account['foto'];

    // print_r($filename);
    // exit();
    
    $fileFoto = base_url('assets/img/profile/') . $filename;
    unlink($fileFoto);
    $this->Account_model->hapus_account($id);
    $this->session->set_flashdata('flashAcc', 'Dihapus');
    redirect('account');
  }

  public function changeStatus()
  {
    $id     = $this->input->post('id');
    $state  = $this->input->post('state');


    $data = $this->Account_model->update_status($id, $state);
    echo json_encode($data);
  }

  public function changeRole()
  {
    $id     = $this->input->post('id');
    $role_id  = $this->input->post('role_id');


    $data = $this->Account_model->update_role($id, $role_id);
    echo json_encode($data);
  }

  public function changePassword()
  {
    $id          = $this->input->post('id');
    $password    = $this->input->post('password');

    // print_r($password);
    // exit();
    $this->db->set('password', md5($password));
    $this->db->where('id', $id);
    $this->db->update('users');

    redirect('account/editAccount/' . $id);
  }

  // public function detailAccount($id)
  // {
  //   $data['title']        = 'Edit Account | OKR';
  //   $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
  //   $data['users']        = $this->Account_model->getAccountById($id);
  //   $data['departement']  = $this->Departement_model->getAllDepartement();

  //   $this->load->view('template/header', $data);
  //   $this->load->view('template/sidebar', $data);
  //   $this->load->view('template/topbar', $data);
  //   $this->load->view('account/account_detail', $data);
  //   $this->load->view('template/footer', $data);
  // }


  public function searchUsers() {
    $query = $this->input->get('q');
    
    $this->db->group_start(); // Mulai group pencarian
    $this->db->like('username', $query);
    $this->db->or_like('nama', $query);
    $this->db->or_like('email', $query);
    $this->db->group_end(); // Akhir group pencarian

    $this->db->where('state', 2);      // Hanya ambil user dengan state = 2
    $result = $this->db->get('users')->result_array();

    $data = [];
    foreach ($result as $user) {
        $data[] = [
            'email' => $user['email'],
            'username' => $user['username'],
            'nama' => $user['nama'],
        ];
    }
    
    echo json_encode(['items' => $data]);
  }

  public function searchUsersSpace() {
    $query = $this->input->get('q');
    
    $this->db->like('username', $query);
    $this->db->or_like('nama', $query); // Filter berdasarkan email yang sama persis
    $this->db->where('state', 2);      // Hanya ambil user dengan state = 2
    $result = $this->db->get('users')->result_array();

    $data = [];
    foreach ($result as $user) {
        $data[] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nama' => $user['nama'],
        ];
    }
    
    echo json_encode(['items' => $data]);
  }
}
