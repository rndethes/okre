<?php

class Main_model extends CI_model
{
  public function countAllProject()
  {
    $this->db->select('*');
    $this->db->from('project');
    return $this->db->get()->num_rows();
  }

  public function countAllMySpace()
  {
    $id = $this->session->userdata("id");
    $this->db->select('*');
    $this->db->from('space_team');
    $this->db->where('id_user',$id);
    return $this->db->get()->num_rows();
  }

  public function countAllMyProject()
  {
    $id = $this->session->userdata("id");
    $this->db->select('*');
    $this->db->from('access_team');
    $this->db->where('id_user',$id);
    return $this->db->get()->num_rows();
  }

  public function countAllMyTask()
  {
    $id = $this->session->userdata("id");
    $this->db->select('*');
    $this->db->from('task');
    $this->db->where('user_to_task',$id);
    $this->db->where('status_task !=','2');
    return $this->db->get()->num_rows();
  }

  public function countAllMyDoc()
  {
    $id = $this->session->userdata("id");
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_user_doc',$id);
    $this->db->where('status_signature !=','2');
    return $this->db->get()->num_rows();
  }


  public function dataAllMyDoc()
  {
    $id = $this->session->userdata("id");
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_user_doc',$id);
    $this->db->where('status_signature !=','2');
    return $this->db->get()->num_rows();
  }

  public function getTaskStatusCounts()
  {
    $id = $this->session->userdata("id");
    $this->db->select('status_task, COUNT(*) as count');
    $this->db->from('task');
    $this->db->where('user_to_task',$id);
    return $this->db->get()->result_array();
  }


  public function getScheduleTask()
  {
    $id = $this->session->userdata("id");

    $this->db->select('*');
    $this->db->from('task');
    $this->db->where('user_to_task',$id);
    $this->db->where('status_task !=','2');
    
    return $this->db->get()->result_array();
  }

  public function countAllTeam()
  {
    $this->db->select('*');
    $this->db->from('team');
    return $this->db->get()->num_rows();
  }
  public function countAllUser()
  {
    $this->db->select('*');
    $this->db->from('users');
    return $this->db->get()->num_rows();
  }
  public function countAllDepartement()
  {
    $this->db->select('*');
    $this->db->from('departement');
    return $this->db->get()->num_rows();
  }

  public function dataMyDocumentAll($iduser){
  
 
    $this->db->select('document.*,users.nama,space.*,');
    $this->db->from('document');
    $this->db->join('space', 'document.id_space  = space.id_space');
    $this->db->join('users', 'document.id_user_create = users.id');
    $this->db->where('document.id_user_create', $iduser);
    $this->db->where('document.status_document !=', 4);
    $this->db->order_by('document.id_document', "DESC");
    $this->db->limit(3);
    
  
    return $this->db->get()->result_array();
  }
  
  public function dataMyDocument($iduser){
    $this->db->select('document.*,users.nama,space.*,document_signature.*');
    $this->db->from('document');
    $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
    $this->db->join('space', 'document.id_space  = space.id_space');
    $this->db->join('users', 'document_signature.id_user_doc = users.id');
    $this->db->where('document_signature.id_user_doc', $iduser);
    $this->db->where('document.status_document !=', 4);
    $this->db->order_by('document.id_document', "DESC");
    $this->db->limit(3);
    
  
    return $this->db->get()->result_array();
  }

  public function dataMyTask()
  {
    $id = $this->session->userdata("id");

    $this->db->select('task.*,users.nama,space.name_space');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->join('space', 'task.task_in_space = space.id_space');
    $this->db->where('task.user_to_task',$id);
    $this->db->where('task.status_task',1);
    $this->db->order_by('task.updated_task', 'DESC');
    $this->db->limit('5');

    return $this->db->get()->result_array();
  }

  public function printExcelProject($id, $dataprj)
  {
    foreach ($dataprj as $data) {
      $this->db->select($data);
    }
    $this->db->from('project');
    $this->db->join('departement', 'departement.id_departement = project.id_departement');
    $this->db->join('team', 'project.id_team = team.id_team');
    $this->db->join('okr', 'okr.id_project = project.id_project');
    $this->db->where('project.id_project', $id);
    $query = $this->db->get();

    return $query->result_array();
  }

  public function printExcelObj($id, $dataokr)
  {
    foreach ($dataokr as $data) {
      $this->db->select($data);
    }
    $this->db->from('okr');
    $this->db->join('project', 'okr.id_project = project.id_project');
    $this->db->join('team', 'okr.id_team = team.id_team');
    $this->db->where('id_okr', $id);
    $this->db->or_where('okr.id_project', $id);
    $query = $this->db->get();

    return $query->result_array();
  }

  public function printExcelKr($id_okr, $datakr)
  {
    foreach ($datakr as $data) {
      $this->db->select($data);
    }
    $this->db->from('key_result');
    $this->db->join('okr', 'okr.id_okr = key_result.id_okr');
    $this->db->where('key_result.id_okr', $id_okr);
    $query = $this->db->get();

    return $query->result_array();
  }

  public function getObjectiveprint($id_pro)
  {
    $query = "SELECT *
    FROM `okr`
    WHERE `id_project` = '$id_pro'";

    return $this->db->query($query)->result_array();
  }
  public function getOKRprint($id_okr)
  {
    $query = "SELECT *
    FROM `key_result`
    WHERE `id_okr` = '$id_okr'";

    return $this->db->query($query)->result_array();
  }

  public function getUserLogin($usernamesession) 
  {
    $query = "SELECT * 
              FROM `users` WHERE `username` = '$usernamesession'";

    return $this->db->query($query)->result_array();
  }

  public function PrintKeyData($id, $datakr)
  {
    foreach ($datakr as $data) {
      $this->db->select($data);
    }
    $this->db->from('key_result');
    $this->db->join('okr', 'okr.id_okr = key_result.id_okr');
    $this->db->where('key_result.id_kr', $id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function PrintInsData($id, $datains)
  {
    foreach ($datains as $data) {
      $this->db->select($data);
    }
    $this->db->from('initiative');
     $this->db->join('key_result', 'key_result.id_kr = initiative.id_kr');
    $this->db->where('initiative.id_kr', $id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function insert_document($data) {
    $this->db->insert('document', $data);
    return $this->db->insert_id();
  }

  public function checkFileByBarcode($idbarcode)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('reff_document', $idbarcode);
      

      return $this->db->get()->row_array();
    }

    public function input($data, $table)
    {
      return $this->db->insert($table, $data);
    }

    public function getUnreadMessages() {
      $id = $this->session->userdata('id');
      // Contoh query untuk mengambil pesan
      $this->db->select('notification.*,users.nama,users.foto');
      $this->db->from('notification');
      $this->db->join('users', 'users.id = notification.user_from');
      $this->db->where('notification.is_read_notif', 1); // Ambil pesan yang belum dibaca
      $this->db->where('notification.user_id', $id);
      $this->db->order_by('notification.created_at_notif', 'DESC');
      $this->db->limit(6);
      $query = $this->db->get();
      
      return $query->result_array(); // Kembalikan hasil dalam bentuk array
  }


  public function getAllMessages() {
    $id = $this->session->userdata('id');
    // Contoh query untuk mengambil pesan
    $this->db->select('notification.*,users.nama,users.foto');
    $this->db->from('notification');
    $this->db->join('users', 'users.id = notification.user_from');
    $this->db->where('notification.user_id', $id);
    $this->db->order_by('notification.created_at_notif', 'DESC');
    $query = $this->db->get();
    
    return $query->result_array(); // Kembalikan hasil dalam bentuk array
}

public function getAllMessagesBySpace($idspace)
  {
    $id = $this->session->userdata('id');
    // Contoh query untuk mengambil pesan
    $this->db->select('notification.*,users.nama,users.foto');
    $this->db->from('notification');
    $this->db->join('users', 'users.id = notification.user_from');
    $this->db->where('notification.user_id', $id);
    $this->db->where('notification.space_from', $idspace);
    $this->db->where('notification.is_read_notif', 1);
    $this->db->order_by('notification.created_at_notif', 'DESC');
    $query = $this->db->get();
    
    return $query->result_array(); // Kembalikan hasil dalam bentuk array
  }

public function getAllNotificationBySpace($idspace) {
  $id = $this->session->userdata('id');
  // Contoh query untuk mengambil pesan
  $this->db->select('notification.*,users.nama,users.foto');
  $this->db->from('notification');
  $this->db->join('users', 'users.id = notification.user_from');
  $this->db->where('notification.user_id', $id);
  $this->db->where('notification.space_from', $idspace);
  $this->db->where('notification.is_read_notif', 1);
  $this->db->order_by('notification.created_at_notif', 'DESC');
  $query = $this->db->get();
  
  return $query->num_rows(); // Kembalikan hasil dalam bentuk array
}

public function get_overdue_tasks($current_date) {
  $id = $this->session->userdata("id");
  
  $this->db->select('*');
  $this->db->from('task');
  $this->db->where('DATE(overdue_task) <=', date('Y-m-d', strtotime($current_date)));
  $this->db->where('status_task !=', 'completed'); // Jika ada kolom status, pastikan task belum selesai
  $this->db->where('user_to_task', $id); 
  $query = $this->db->get();
  
  return $query->result();
}

public function getAllProjects() {
  $id = $this->session->userdata("id");

  $this->db->select('project.*');
  $this->db->from('project');
  $this->db->join('team', 'project.id_team = team.id_team');
  $this->db->join('access_team', 'access_team.id_team = team.id_team');
  $this->db->where('access_team.id_user', $id);
  
  $query = $this->db->get();
  return $query->result_array();
}


public function checkMyNotification($id){

  $this->db->select('*');
  $this->db->from('notification');
  $this->db->where('id_notif', $id);

  $query = $this->db->get();
  return $query->row_array();
}


public function checkMyMessageInDay($idpj){

  $datenow = date('Y-m-d');

  $this->db->select('message_chat.*, message_chat_room.id_project_rc');
  $this->db->from('message_chat');
  $this->db->join('message_chat_room', 'message_chat_room.id_mcr = message_chat.chatroom_id_mc');
  $this->db->where('message_chat_room.id_project_rc', $idpj);
  $this->db->like('DATE(message_chat.timestamp_mc)', $datenow); 
  
  $query = $this->db->get();

  return $query->num_rows();
}

public function checkMyRoomChat($idroom){

  $this->db->select('*');
  $this->db->from('message_chat_room');
  $this->db->where('id_mcr', $idroom);

  $query = $this->db->get();
  return $query->row_array();
}
public function insert_data($data,$tables) {
  $this->db->insert($tables, $data);
  return $this->db->insert_id(); // Mengembalikan ID dari workspace yang baru ditambahkan
}

 // Fungsi untuk menyimpan data ke database
 public function saveData($data) {
  return $this->db->insert('user_table_data', $data);
}

public function get_data_by_table_id($table_id)
{
    $query = $this->db->get_where('user_table_data', ['table_id' => $table_id]);
    return $query->row_array(); // Kembalikan data jika ada, atau null jika tidak ada
}

public function update_data($table_id, $data)
{
  $this->db->where('table_id', $table_id);
  return $this->db->update('user_table_data', $data);
}

public function getDataById($iddata){

  $this->db->select('*');
  $this->db->from('user_tables');
  $this->db->where('id', $iddata);

  $query = $this->db->get();
  return $query->row_array();
}

public function getDataColumnById($iddata){

  $this->db->select('*');
  $this->db->from('user_table_columns');
  $this->db->where('table_id', $iddata);

  $query = $this->db->get();
  return $query->result_array();
}

public function hapus_data($id,$table,$iddata)
{
  $this->db->delete($table, [$iddata => $id]);
}

public function getDataColumnId($iddata){

  $this->db->select('*');
  $this->db->from('user_table_columns');
  $this->db->where('id', $iddata);

  $query = $this->db->get();
  return $query->row_array();
}

public function getMyTeamInSpace($myspace){

  $id = $this->session->userdata('id');

  $this->db->select('users.nama,users.username,space_team.id_user');
  $this->db->from('space_team');
  $this->db->join('users', 'users.id = space_team.id_user');
  $this->db->join('space', 'space.id_space = space_team.id_workspace');
  $this->db->where_in('space_team.id_workspace', $myspace);
  $this->db->where('space_team.id_user !=', $id);
  $this->db->group_by('users.username');


  $query = $this->db->get();
  return $query->result_array();
}

// Di dalam file Main_model.php
public function is_record_exists($table, $where_data)
{
    $this->db->where($where_data);
    $query = $this->db->get($table);
    
    // Jika jumlah baris lebih dari 0, berarti data sudah ada
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

}
