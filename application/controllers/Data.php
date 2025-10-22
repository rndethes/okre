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

  class Data extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Account_model');
      $this->load->model('Departement_model');
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
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);

      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $iduser               = $this->session->userdata('id');
      $idspace              = $this->session->userdata('workspace_sesi');

      $data['space']        = $this->Space_model->checkSpaceById($idspace);
  

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('data/data', $data);
      $this->load->view('template/footer', $data);
    }

    public function upload_logo()
    {
      // Konfigurasi upload
      $config['upload_path'] = './assets/doctemplate/kop/'; // Folder tujuan
      $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Tipe file yang diperbolehkan
      $config['max_size'] = 2048; // Maksimal ukuran file dalam KB (2MB)
      $config['file_name'] = uniqid(); // Nama file yang unik

      // Load library upload
      $this->load->library('upload', $config);

      if ($this->upload->do_upload('foto')) {
        // Jika upload berhasil
        $uploadData = $this->upload->data();
        $fileName = $uploadData['file_name']; // Nama file yang diupload

        $data = array(
          'header_photo'    => $fileName,
          'created_date'    => date("Y-m-d H:i:s"),
        );

       $id_template = $this->Main_model->insert_data($data,'document_template');

        // Kirim respons sukses ke client
        echo json_encode([
          'status' => 'success', 
          'file_name' => $fileName, 
          'id_template' => $id_template // Kirim $id_template ke client
        ]);
      } else {
        // Jika upload gagal, kirim error
        echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
      }
    }

    public function upload_template() {
      
      $header_template = $this->input->post('header_template'); // Ambil data dari POST
      $id_template = $this->input->post('id_template'); // Ambil ID template

        $this->db->set('header_template', $header_template);
        $this->db->where('id_document_template', $id_template);
        $this->db->update('document_template');

      // Kirim respons sukses
      echo json_encode(['status' => 'success']);
    }

    public function createDocument($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);

      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $iduser               = $this->session->userdata('id');
      $idspace              = $this->session->userdata('workspace_sesi');

      $data['space']        = $this->Space_model->checkSpaceById($idspace);
      $data['templatekop']  = $this->Space_model->checkMyTemplateKop();
      $data['mydocspace']   = $this->Space_model->checkMyDocSpace($idspace);

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentcreated', $data);
      $this->load->view('template/footer', $data);
    }

    public function viewDocument($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);

      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $iduser               = $this->session->userdata('id');
      $idspace              = $this->session->userdata('workspace_sesi');

      $data['space']        = $this->Space_model->checkSpaceById($idspace);
      $data['templatekop']  = $this->Space_model->checkMyTemplateKop();
      

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('document/documentview', $data);
      $this->load->view('template/footer', $data);
    }

    public function deleteDocumentNew($iddoc,$idspace) {

      $this->Space_model->hapus_new_doc($iddoc);

      redirect("data/viewDocument/" . $idspace ."/space");
    }


    public function upload_image() {
      // Tentukan path upload
      $config['upload_path'] = './assets/doctemplate/doc/';  // Path folder untuk menyimpan gambar
      $config['allowed_types'] = 'gif|jpg|jpeg|png';  // Jenis file yang diizinkan
      $config['max_size'] = 7048;  // Ukuran maksimum file dalam KB (2MB)

      // Load library upload dari CodeIgniter dengan konfigurasi di atas
      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('file')) {  // 'file' adalah nama file yang dikirimkan oleh TinyMCE
          // Jika ada error saat upload
          $response = array(
              'status' => 'error',
              'message' => $this->upload->display_errors()  // Menampilkan pesan error
          );
      } else {
          // Jika upload berhasil
          $uploadData = $this->upload->data();  // Data file yang diupload
          $imageURL = base_url('assets/doctemplate/doc/' . $uploadData['file_name']);  // URL dari gambar yang diupload

          $response = array(
              'status' => 'success',
              'location' => $imageURL  // Mengirimkan URL gambar ke TinyMCE
          );
      }

      // Kirimkan response dalam format JSON
      echo json_encode($response);
  }

  public function savedecsdoc($id)
  {
    $iduser             = $this->session->userdata('id');
    $workspace_sesi     = $this->session->userdata('workspace_sesi'); 

    $templatekop   = $this->input->post("templatekop");
    $docname       = $this->input->post("docname");
    $doctype       = $this->input->post("doctype");

    
    $data = array(
      'name_document_new'   => $docname,
      'tipe_document_new'   => $doctype,
      'kop_document'        => $templatekop,
      'space_id'            => $id,
      'user_id'             => $iduser,
      'created_doc'         => 1,
      'created_date'        => date("Y-m-d H:i:s"),
    );

    $iddata = $this->Main_model->insert_data($data,'document_new');

    $session_data = array(
      'sesicreateddoc'   => 1,
    );

    $this->session->set_userdata($session_data);

    redirect('data/viewCreatedDoc/' .$id.'/'.$iddata );
  }
  

  public function viewCreatedDoc($idspace,$iddata) {
    $data['title']        = 'Edit Project | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['team']         = $this->Team_model->getALLTeam();

    $iduser     = $this->session->userdata('id');
    $workspace_sesi     = $this->session->userdata('workspace_sesi');   

    $data['space']      = $this->Space_model->checkSpaceById($idspace);

    $data['checkdata']  = $this->Space_model->getMyNewDocById($iddata);

    $data['checklog']  = $this->Space_model->getLogDocById($iddata);

    $this->load->view('template/header', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('document/documentnew', $data);
    $this->load->view('template/footer', $data);
  }

  public function editCreatedDoc($idspace,$iddata) {
    $data['title']        = 'Edit Project | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['team']         = $this->Team_model->getALLTeam();

    $iduser     = $this->session->userdata('id');
    $workspace_sesi     = $this->session->userdata('workspace_sesi');   

    $data['space']      = $this->Space_model->checkSpaceById($idspace);

    $data['checkdata']  = $this->Space_model->getMyNewDocById($iddata);

    $this->load->view('template/header', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('document/documentnewedit', $data);
    $this->load->view('template/footer', $data);
  }

  public function previewDocument($idspace,$iddata) {
    $data['title']        = 'Edit Project | OKR';
    $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
    $data['departement']  = $this->Departement_model->getAllDepartement();
    $data['team']         = $this->Team_model->getALLTeam();

    $iduser     = $this->session->userdata('id');
    $workspace_sesi     = $this->session->userdata('workspace_sesi');   

    $data['space']      = $this->Space_model->checkSpaceById($idspace);

    $data['checkdata']  = $this->Space_model->getMyNewDocById($iddata);

    $data['checklog']  = $this->Space_model->getLogDocById($iddata);

    $this->load->view('template/header', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('document/documentnewpreview', $data);
    $this->load->view('template/footer', $data);
  }


  public function get_templates() {
    // Ambil data template dari model
    $templates = $this->Space_model->get_all_templates();

    $titledefaultone    = 'Template OKRE 1';
    $descdefaultone     = 'default';
    $contentdefaultone  = '<table style="border-collapse: collapse; width: 99.9808%; border-width: 1px; background-color: rgb(255, 255, 255); border-color: rgb(255, 255, 255);" border="1"><colgroup><col style="width: 7.76575%;"><col style="width: 90.6275%;"><col style="width: 1.57017%;"></colgroup>
    <tbody>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);"><img src="../../../assets/doctemplate/doc/logo.png" alt="" width="77" height="79"></td>
    <td style="border-color: rgb(255, 255, 255);">
    <h2 style="line-height: 1.2; margin-left: 7.08661pt; text-indent: -3.16339pt; margin-top: 4.25pt; margin-bottom: 0pt; text-align: center;"><strong><span style="font-size: 11.5pt; font-family: Arial, sans-serif;">TITLE YOUR COMPANY</span></strong></h2>
    <p style="line-height: 1.21; margin-top: 0.15pt; margin-right: 122.15pt; margin-bottom: 0pt; padding-left: 153.449px; text-align: center;"><span style="font-size: 8pt; font-family: Arial, sans-serif;">Krajan 1 Kandangan, 001/007 Kandangan, Temanggung,&nbsp;</span></p>
    <p style="line-height: 1.21; margin-top: 0.15pt; margin-right: 122.15pt; margin-bottom: 0pt; padding-left: 153.449px; text-align: center;"><span style="font-size: 8pt; font-family: Arial, sans-serif;">Central Java 56281, Indonesia</span></p>
    <p style="line-height: 1.2; text-indent: 14.1732pt; margin-top: 0pt; margin-bottom: 0pt; text-align: center;"><span style="font-size: 8pt;"><span style="font-family: Arial, sans-serif;">Email : okre@okre.com</span><span style="font-family: Arial, sans-serif; color: rgb(45, 144, 188);">&nbsp;</span><span style="font-family: Arial, sans-serif;">Telp : 081209202</span></span></p>
    </td>
    <td style="border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    <hr>
    <p style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 12pt; font-family: Arial, sans-serif; text-decoration: underline; text-decoration-skip-ink: none;">SURAT&nbsp;PEMBERITAHUAN</span></strong></p>
    <p style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 11pt; font-family: Arial, sans-serif;">NO.001/OKR/OKREVI/2024</span></strong></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-size: 12pt;"><span style="font-family: Arial, sans-serif;">Perihal</span><span style="font-family: Arial, sans-serif;"> </span><span style="font-family: Arial, sans-serif;"> </span><span style="font-family: Arial, sans-serif;">: Penarikan Barang&nbsp;</span></span></p>
    <p style="line-height: 1.2;">&nbsp;</p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Yth,</span></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Direktur OKRE</span></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.2;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Mr OKRE&nbsp;</span></p>
    <p style="text-indent: 36pt; text-align: justify; background-color: rgb(255, 255, 255); margin-top: 15pt; margin-bottom: 15pt; line-height: 1.2;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12pt;"><strong>Lorem Ipsum</strong>&nbsp;adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf. Ia tidak hanya bertahan selama 5 abad, tapi juga telah beralih ke penataan huruf elektronik, tanpa ada perubahan apapun. Ia mulai dipopulerkan pada tahun 1960 dengan diluncurkannya lembaran-lembaran Letraset yang menggunakan kalimat-kalimat dari Lorem Ipsum, dan seiring munculnya perangkat lunak Desktop Publishing seperti Aldus PageMaker juga memiliki versi Lorem Ipsum.</span></p>
    <table style="border-collapse: collapse; width: 99.9808%; border-width: 1px; border-style: solid; height: 54.9999px;" border="1"><colgroup><col style="width: 8.75713%;"><col style="width: 41.3072%;"><col style="width: 25.0322%;"><col style="width: 24.8669%;"></colgroup>
    <tbody>
    <tr style="border-color: rgb(0, 0, 0); border-style: double; background-color: rgb(206, 212, 217); height: 18.3333px;">
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">No</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Name</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Division</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Action</td>
    </tr>
    <tr style="height: 18.3333px;">
    <td style="height: 18.3333px;">1</td>
    <td style="height: 18.3333px;">Mr OKRE</td>
    <td style="height: 18.3333px;">System</td>
    <td style="height: 18.3333px;">Promotion</td>
    </tr>
    <tr style="height: 18.3333px;">
    <td style="height: 18.3333px;">2</td>
    <td style="height: 18.3333px;">Mrs OKRE</td>
    <td style="height: 18.3333px;">System</td>
    <td style="height: 18.3333px;">Promotion</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <p style="line-height: 1.2;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12pt;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Lorem Ipsum</strong>&nbsp;adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang.</span></p>
    <table style="border-collapse: collapse; width: 99.9808%; border-width: 1px; background-color: rgb(255, 255, 255); border-color: rgb(255, 255, 255);" border="1"><colgroup><col style="width: 49.9587%;"><col style="width: 49.9587%;"></colgroup>
    <tbody>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Temanggung 16 Oktober 2024</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Manager Operasional</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Direktur Operasional</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Mrs OKRE System</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Mr OKRE System</td>
    </tr>
    </tbody>
    </table>';

    $titledefaulttwo    = 'Template OKRE 2';
    $descdefaulttwo     = 'default';
    $contentdefaulttwo  = '<table style="border-collapse: collapse; width: 99.9808%; height: 37.188px; border-width: 1px; border-color: rgb(255, 255, 255);" border="1"><colgroup><col style="width: 100%;"></colgroup>
    <tbody>
    <tr style="height: 37.188px;">
    <td style="height: 37.188px; border-color: rgb(255, 255, 255);">
    <p style="line-height: 1;"><img style="display: block; margin-left: auto; margin-right: auto;" src="../../../assets/doctemplate/doc/logo.png" alt="" width="48" height="49"></p>
    <h2 style="line-height: 1; margin-left: 7.08661pt; text-indent: -3.16339pt; margin-top: 4.25pt; margin-bottom: 0pt; text-align: center;"><strong><span style="font-size: 11.5pt; font-family: Arial, sans-serif;">TITLE YOUR COMPANY</span></strong></h2>
    <p style="line-height: 1; margin-top: 0.15pt; margin-right: 122.15pt; margin-bottom: 0pt; padding-left: 153.449px; text-align: center;"><span style="font-size: 8pt;">Krajan 1 001/007, Kandangan, Temanggung, Jawa Tengah 56281</span><br><span style="font-size: 8pt;">Telp. 0293 4963641 Hp : 0811291979 hallo@lidogrosir.id</span></p>
    </td>
    </tr>
    </tbody>
    </table>
    <hr>
    <p style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 12pt; font-family: Arial, sans-serif; text-decoration: underline; text-decoration-skip-ink: none;">SURAT&nbsp;PEMBERITAHUAN</span></strong></p>
    <p style="text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 11pt; font-family: Arial, sans-serif;">NO.001/OKR/OKREVI/2024</span></strong></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.1;"><span style="font-size: 12pt;"><span style="font-family: Arial, sans-serif;">Perihal</span><span style="font-family: Arial, sans-serif;"> </span><span style="font-family: Arial, sans-serif;"> </span><span style="font-family: Arial, sans-serif;">: Penarikan Barang&nbsp;</span></span></p>
    <p style="line-height: 1.1;">&nbsp;</p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.1;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Yth,</span></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.1;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Direktur OKRE</span></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.1;"><span style="font-size: 12pt; font-family: Arial, sans-serif;">Mr OKRE&nbsp;</span></p>
    <p style="text-align: justify; margin-top: 0pt; margin-bottom: 0pt; line-height: 1.1;">&nbsp;</p>
    <p style="text-indent: 36pt; text-align: justify; background-color: rgb(255, 255, 255); margin-top: 15pt; margin-bottom: 15pt;"><span style="font-family: arial, helvetica, sans-serif; font-size: 12pt;"><strong>Lorem Ipsum</strong>&nbsp;adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf. Ia tidak hanya bertahan selama 5 abad, tapi juga telah beralih ke penataan huruf elektronik, tanpa ada perubahan apapun. Ia mulai dipopulerkan pada tahun 1960 dengan diluncurkannya lembaran-lembaran Letraset yang menggunakan kalimat-kalimat dari Lorem Ipsum, dan seiring munculnya perangkat lunak Desktop Publishing seperti Aldus PageMaker juga memiliki versi Lorem Ipsum.</span></p>
    <table style="border-collapse: collapse; width: 99.9808%; border-width: 1px; border-style: solid; height: 54.9999px;" border="1"><colgroup><col style="width: 8.75713%;"><col style="width: 41.3072%;"><col style="width: 25.0322%;"><col style="width: 24.8669%;"></colgroup>
    <tbody>
    <tr style="border-color: rgb(0, 0, 0); border-style: double; background-color: rgb(206, 212, 217); height: 18.3333px;">
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">No</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Name</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Division</td>
    <td style="border-color: rgb(0, 0, 0); border-style: double; height: 18.3333px;">Action</td>
    </tr>
    <tr style="height: 18.3333px;">
    <td style="height: 18.3333px;">1</td>
    <td style="height: 18.3333px;">Mr OKRE</td>
    <td style="height: 18.3333px;">System</td>
    <td style="height: 18.3333px;">Promotion</td>
    </tr>
    <tr style="height: 18.3333px;">
    <td style="height: 18.3333px;">2</td>
    <td style="height: 18.3333px;">Mrs OKRE</td>
    <td style="height: 18.3333px;">System</td>
    <td style="height: 18.3333px;">Promotion</td>
    </tr>
    </tbody>
    </table>
    <p>&nbsp;</p>
    <p><span style="font-family: arial, helvetica, sans-serif; font-size: 12pt;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Lorem Ipsum</strong>&nbsp;adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang</span></p>
    <p>&nbsp;</p>
    <table style="border-collapse: collapse; width: 99.9808%; border-width: 1px; background-color: rgb(255, 255, 255); border-color: rgb(255, 255, 255);" border="1"><colgroup><col style="width: 49.9587%;"><col style="width: 49.9587%;"></colgroup>
    <tbody>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Temanggung 16 Oktober 2024</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Manager Operasional</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Direktur Operasional</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>
    <tr>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Mrs OKRE System</td>
    <td style="text-align: center; border-color: rgb(255, 255, 255);">Mr OKRE System</td>
    </tr>
    </tbody>
    </table>
    <hr class="page-break" style="break-before: page;">';

    // Format sebagai JSON untuk dikembalikan ke TinyMCE
    $result = [];

    // Memasukkan data default ke array $result
    $result[] = [
      'title'       => $titledefaultone,
      'description' => $descdefaultone,
      'content'     => $contentdefaultone
    ];

    $result[] = [
      'title'       => $titledefaulttwo,
      'description' => $descdefaulttwo,
      'content'     => $contentdefaulttwo
    ];


    foreach ($templates as $template) {
        $result[] = [
            'title'       => $template->template_name,
            'description' => 'new',
            'content'     => $template->header_template  // Ini kolom HTML di database
        ];
    }

    // Kembalikan sebagai JSON
    echo json_encode($result);
}

  public function save_new(){
        // Ambil data dari request
        $id_document = $this->input->post('id_document_new');
        $content = $this->input->post('content');
        
        // Validasi data jika perlu
        if (empty($id_document) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        if($id_document != "") {
          $this->db->set('content_doc', $content);
          $this->db->set('updated_date', date('Y-m-d H:i:s'));
          $this->db->where('id_document_new', $id_document);
          $this->db->update('document_new');
          $save_result = true;
        } else {
          $save_result = false;
        }

        $datalog = [
          'id_document_new'     => $id_document,
          'user_update_log'     => $this->session->userdata('id'),  
          'desc_log'            => 'Dokumen di Edit Oleh ' . $this->session->userdata('nama'),
          'created_date_log'    => date('Y-m-d H:i:s'),
       ];

       $iddata = $this->Main_model->insert_data($datalog,'document_new_log');


       
        // Cek apakah penyimpanan berhasil
        if ($save_result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan dokumen']);
        }
  }

  public function save_new_template(){
      // Ambil data dari request
      $id_document  = $this->input->post('id_document_new');
      $content      = $this->input->post('content');
      $nametemp     = $this->input->post('template_name');
      $idspace      = $this->input->post('idspace');
      
      // Validasi data jika perlu
      if (empty($id_document) || empty($content)) {
          echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
          return;
      }

      if($id_document != "") {

        $data = array(
          'template_name'   => $nametemp,
          'header_template' => $content,
          'id_space'        => $idspace,
          'created_date'    => date("Y-m-d H:i:s"),
        );

       $iddata = $this->Main_model->insert_data($data,'document_template');

        $save_result = true;
      } else {
        $save_result = false;
      }

      $datalog = [
        'id_document_new'     => $id_document,
        'user_update_log'     => $this->session->userdata('id'),  
        'desc_log'            => 'Dibuat Template Oleh ' . $this->session->userdata('nama'),
        'created_date_log'    => date('Y-m-d H:i:s'),
    ];

    $iddata = $this->Main_model->insert_data($datalog,'document_new_log');

    
      // Cek apakah penyimpanan berhasil
      if ($save_result) {
          echo json_encode(['success' => true]);
      } else {
          echo json_encode(['success' => false, 'message' => 'Gagal menyimpan dokumen']);
      }
  }


  public function save_and_submit(){
    $this->load->library('pdf');  // Load library PDF

    // Ambil konten dari TinyMCE
    $content      = $this->input->post('content');
    $id_document  = $this->input->post('id_document_new');
    $namadoc      = $this->input->post('document_name');
    $tipedoc      = $this->input->post('tipedoc');
    $idspace      = $this->input->post('space');

    $urlback      = base_url("data/editCreatedDoc/") . $idspace . '/' . $id_document;

    try{
          // Simpan ke database (bisa gunakan logika penyimpanan dokumen di sini)
          $this->db->set('content_doc', $content);
          $this->db->set('updated_date', date('Y-m-d H:i:s'));
          $this->db->where('id_document_new', $id_document);
          $this->db->update('document_new');

          // Buat PDF dari konten menggunakan Dompdf
          $html_content = "";
          $html_content .= $content;  // Tambahkan konten HTML

          $namadocnew = str_replace(' ', '_', $namadoc);

          // Konversi HTML menjadi PDF
          $pdf_output = $this->pdf->create_pdf($html_content, $namadocnew, FALSE);

          $idspace = 'space';

          $namafolder          = checkSpace($idspace);

          // Tentukan path untuk menyimpan PDF
          $pdf_path = './assets/document/' . $namafolder . '/' . $namadocnew . '.pdf';
          file_put_contents($pdf_path, $pdf_output);

          // Simpan data pengajuan ke database
          $pengajuan_data = [
              'name_document' => $namadoc,
              'type_document' => $tipedoc,
              'url_doc'       => base_url('/assets/document/') . $namafolder . '/' . $namadocnew . '.pdf',  
              'name_file'     => $namadocnew . '.pdf',
              'urlback'       => $urlback,
          ];

          // Simpan data ke session
          $this->session->set_userdata('pengajuan_data', $pengajuan_data);

          echo json_encode([
            'success' => true,
            'message' => 'Pengajuan berhasil dibuat!',
            'redirect_url' => base_url('document/newdocumentinput/space')
        ]);
    } catch (Exception $e) {
      // Kirimkan respon error jika terjadi kesalahan
      echo json_encode([
          'success' => false,
          'message' => 'Terjadi kesalahan: ' . $e->getMessage()
      ]);
    }

    }

  public function searchKop()
  {
    // Ambil ID dari permintaan AJAX
    $templateId = $this->input->post('id');

    // Ambil data kop_document dari database
    $kopDocument = $this->Space_model->get_kop_document($templateId);

    // Cek jika data ditemukan
    if ($kopDocument) {
        $response = [
            'success' => true,
            'kop_document' => $kopDocument['header_template']
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Tidak ada data yang ditemukan.'
        ];
    }

    // Kembalikan respons dalam format JSON
    echo json_encode($response);
  }


  public function getDocumentsData(){
 
    $id_space = $this->input->post('idspace'); // Ambil ID
  
    $mydocument = $this->Space_model->getDataTableDocNew($id_space);
  
     // Ambil total data tanpa filter untuk menghitung recordsTotal
     $data   = [];
     $no     = $_POST['start'];
  
      // Iterasi dan tambahkan elemen HTML pada nama_dokumen
      foreach ($mydocument as &$doc) {
        $row    = array();

        $row[] = '
            <div class="media align-items-center">
                <a href="#" class="avatar rounded-circle mr-3 bg-primary">
                  <i class="fas fa-folder-open"></i>
                </a>
                <div class="media-body">
                    <span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_document_new']) . '</span>
                </div>
            </div>';
            $row[] ='<span class="name mb-0 text-sm">' . htmlspecialchars($doc['nama']) . '</span>';
  
            $row[] ='<span class="name mb-0 text-sm">' . htmlspecialchars($doc['name_space']) . '</span>';

            $row[] ='<span class="name mb-0 text-sm">' . $doc['updated_date'] . '</span>';

  
            $row[] = '<a href="'. base_url("data/editCreatedDoc/") . $id_space . "/" . $doc['id_document_new'] .'" class="btn btn-default btn-sm rounded-pill font-btn"> 
              <span class="btn--inner-icon">
                <i class="ni ni-single-copy-04"></i></span>
              <span class="btn-inner--text">Lihat Dokumen</span>
            </a>
            <a data-target="' . base_url('data/deleteDocumentNew/') .$doc['id_document_new']. "/" . $id_space.'" class="btn btn-danger btn-sm tombol-hapus rounded-pill text-white">
                <span class="btn--inner-icon">
                  <i class="fas fa-trash"></i></span>
                <span class="btn-inner--text">Hapus</span>
              </a>
            ';
      
          $data[] = $row;
        
    }

    $output   = array(
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->Space_model->count_all_datadocnew(),
      "recordsFiltered" => $this->Space_model->count_filtered_datadocnew($id_space),
      "data"            => $data,
    );
  
    $this->output->set_content_type('application/json')->set_output(json_encode($output));
  }

  public function getDocumentById() {
      // Dapatkan id dokumen dari POST request
      $input = json_decode(file_get_contents('php://input'), true);
      $id_document_new = $input['id_document_new'];

      // Query untuk mengambil detail dokumen dari tabel document_new
  
      $document = $this->Space_model->getMyNewDocById($id_document_new);

      // Jika dokumen ditemukan, kirimkan data dalam format JSON
      if ($document) {
          echo json_encode([
              'success'       => true,
              'content'       => $document['content_doc'],  // Atau sesuai kolom content dalam tabel Anda
              'iddocnew'      => $document['id_document_new'],
              'namadoc'       => 'Dokumen   : ' . $document['name_document_new'],
              'usercreated'   => 'Dibuat Oleh         : ' . $document['nama'],
              'createddate'   => 'Tanggal Pembuatan   : ' . $document['created_date'],
          ]);
      } else {
          echo json_encode([
              'success' => false,
              'message' => 'Dokumen tidak ditemukan',
          ]);
      }
  }



  
    public function viewinputdata($id)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['project']      = $this->Project_model->getProjectById($id);


      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $iduser               = $this->session->userdata('id');
      $workspace_sesi       = $this->session->userdata('workspace_sesi');

      $delegasi   = $this->Project_model->cekDelegasi($iduser);

      $data['users']         = $this->Account_model->getAllUserActive();

      $delegasi   = $this->Project_model->cekDelegasi($iduser);
      
      if(!empty($delegasi)) {
        $object     = $this->Project_model->getAllObjectDelegasi($iduser);
        $data['statusproject'] = "Project Partner";
      } else {
        $object     = $this->Project_model->getAllObject();
        $data['statusproject'] = "-";
      }

      $data['chat']  = $this->Project_model->cekChat($id,$workspace_sesi);

      $data['teamobj'] = $this->Team_model->checkTeamObj($id);

      $data['object'] = $object;

      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('data/data_input', $data);
      $this->load->view('template/footer', $data);
    }

    public function inputtabel($idpj){
        $tablename = $this->input->post("tablename");
        $tabledesc = $this->input->post("tabledesc");

        $id = $this->session->userdata("id");

        $data = array(
            'user_id'       => $id,
            'table_name'    => $tablename,
            'description'   => $tabledesc,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
          );

        $iddata = $this->Main_model->insert_data($data,'user_tables');

        redirect("data/viewafterinput/" . $idpj . "/" . $iddata);
    }

    public function viewafterinput($idpj,$iddata)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $data['tables']       = $this->Main_model->getDataById($iddata);

      $data['datacolumn']   = $this->Main_model->getDataColumnById($iddata);

      $iduser     = $this->session->userdata('id');
      $workspace_sesi     = $this->session->userdata('workspace_sesi');   

      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('data/data_tables', $data);
      $this->load->view('template/footer', $data);
    }

    public function edittable($idpj,$iddata){
        $tablename = $this->input->post("tablename");
        $tabledesc = $this->input->post("tabledesc");

        $id = $this->session->userdata("id");

        $this->db->set('table_name', $tablename);
        $this->db->set('description', $tabledesc);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->where('id', $iddata);
        $this->db->update('user_tables');

        redirect("data/viewafterinput/" . $idpj . "/" . $iddata);
    }

    public function inputColumn(){
        $table_id       = $this->input->post("table_id");
        $nama_kolom     = $this->input->post("nama_kolom");
        $tipe_data      = $this->input->post("tipe_data");
        $kosong         = $this->input->post("kosong");
        $default_value  = $this->input->post("default_value");
        $idpj           = $this->input->post("idpj");
        

        $id = $this->session->userdata("id");

        $data = array(
            'table_id'      => $table_id,
            'column_name'   => $nama_kolom,
            'data_type'     => $tipe_data,
            'is_nullable'   => $kosong,
            'default_value' => $default_value,
            'created_at'    => date("Y-m-d H:i:s"),
          );

          $id = $this->Main_model->insert_data($data,'user_table_columns');

      // Kirim response dalam bentuk JSON
        echo json_encode([
            'id' => $id,
            'tablename' => '',
            'namakolom' => $nama_kolom,
            'tipedata' => $tipe_data,
            'kosong' => $kosong,
            'defaultvalue' => $default_value
        ]);
    }

    public function deleteData(){
        $id   = $this->input->post("id");

        $this->Main_model->hapus_data($id,"user_table_columns","id");
       
        return true;
    }

    public function showEditData(){
        $id     = $this->input->get("id");

        $data   = $this->Main_model->getDataColumnId($id);
     
      // Kirim response dalam bentuk JSON
        echo json_encode([
            'id' => $data['id'],
            'table_id' => '',
            'column_name' => $data['column_name'],
            'data_type' => $data['data_type'],
            'is_nullable' => $data['is_nullable'],
            'default_value' => $data['default_value']
        ]);
    }
    
    public function viewinput($idpj,$iddata)
    {
      $data['title']        = 'Edit Project | OKR';
      $data['users_name']   = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
      $data['departement']  = $this->Departement_model->getAllDepartement();
      $data['team']         = $this->Team_model->getALLTeam();

      $data['tables']       = $this->Main_model->getDataById($iddata);

      $data['datacolumn']   = $this->Main_model->getDataColumnById($iddata);

      $iduser     = $this->session->userdata('id');
      $workspace_sesi     = $this->session->userdata('workspace_sesi');   
    
  
  
      $this->load->view('template/header', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('data/data_value', $data);
      $this->load->view('template/footer', $data);
    }

    // public function save_data()
    // {
    //     // Memastikan ini adalah request POST
    //     if ($this->input->server('REQUEST_METHOD') == 'POST') {

    //         // Mengambil data dari input POST
    //         $data = $this->input->post();

    //         // Ambil table_id dari input POST
    //         $table_id = $this->input->post('table_id');

    //         // Proses data lainnya untuk disimpan dalam format JSON
    //         unset($data['table_id']); // Hapus table_id dari data supaya tidak termasuk dalam JSON
    //         $jsonData = json_encode($data);

    //          // Cek apakah data dengan table_id ini sudah ada
    //         $existing_data = $this->Main_model->get_data_by_table_id($table_id);

    //         // Siapkan data untuk disimpan ke dalam database
    //         $insert_data = [
    //             'table_id'    => $table_id,
    //             'column_data' => $jsonData,
    //             'created_at'  => date('Y-m-d H:i:s')
    //         ];

    //         if ($existing_data) {
    //             // Jika sudah ada data, lakukan UPDATE
    //             $update_data = [
    //                 'column_data' => $jsonData,
    //                 'updated_at'  => date('Y-m-d H:i:s')
    //             ];
    
    //             if ($this->Main_model->update_data($table_id, $update_data)) {
    //                 echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
    //             } else {
    //                 echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
    //             }
    //         } else {
    //             // Jika belum ada data, lakukan INSERT
    //             $insert_data = [
    //                 'table_id'    => $table_id,
    //                 'column_data' => $jsonData,
    //                 'created_at'  => date('Y-m-d H:i:s')
    //             ];
    
    //             if ($this->Main_model->insert_data($insert_data,'user_table_data')) {
    //                 echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    //             } else {
    //                 echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    //             }
    //         }
    //     }
    // }

    // Fungsi untuk menyimpan data
    public function saveData() {
        // Mendapatkan data dari permintaan POST
        $postData = $this->input->post('data'); // data dari frontend

        // Menyiapkan data untuk disimpan
        $savedData = [];
        foreach ($postData as $row) {
           
            $savedData[] = [
                'row_number' => $row['row_number'], // Angka baris
                'table_id' => $row['table_id'],     // ID tabel
                'column_id' => $row['column_id'],   // ID kolom
                'column_value' => $row['column_value'], // Nilai kolom
                'created_at' => date('Y-m-d H:i:s'), // Waktu dibuat
                'updated_at' => date('Y-m-d H:i:s')  // Waktu diperbarui
            ];
        }

        // Menyimpan data ke database
        if ($this->Main_model->saveData($savedData)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data.']);
        }
    }




}