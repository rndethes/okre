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

  class Project extends CI_Controller
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
    public function index()
    {
    }
  }

?>