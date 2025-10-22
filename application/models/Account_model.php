<?php

class Account_model extends CI_model
{
  public function getALLUsers()
  {
    return $query = $this->db->get('users')->result_array();
  }
  
  public function input_account($data, $table)
  {
    return $this->db->insert($table, $data);
  }

  public function getAccountById($id)
  {
    return $this->db->get_where('users', ['id' => $id])->row_array();
  }
  
  public function hapus_account($id)
  {
    $this->db->delete('users', ['id' => $id]);
  }

  public function getJoinUsers()
  {
    $query = "SELECT `users`.`id`, `users`.`username`, `users`.`password`, `users`.`nama`, `users`.`email`, `users`.`no_hp`, `users`.`id_kantor`, `users`.`jabatan`, `users`.`alamat`, `users`.`id_departement`, `users`.`foto`, `users`.`id_kantor`, `users`.`role_id`, `users`.`state`
              FROM `users`";

    return $this->db->query($query)->result_array();
  }
  public function get_by_id($table, $id)
  {
    return $this->db->get_where($table, array('id' => $id))->row();
  }
  public function update_status($id, $state)
  {
    $this->db->set('state', $state);
    $this->db->where('id', $id);

    $this->db->update('users');
  }
  public function update_role($id, $role_id)
  {
    $this->db->set('role_id', $role_id);
    $this->db->where('id', $id);

    $this->db->update('users');
  }

  public function check_username_exists($username)
  {
    $query = $this->db->get_where('users', array('username' => $username));
    if (empty($query->row_array())) {
      return true;
    } else {
      return false;
    }
  }

  var $table          = 'users';
  var $column_order   = array('id', 'username', 'password', 'nama', 'email', 'no_hp', 'id_jabatan', 'jabatan', 'alamat', 'id_departement', 'foto', 'id_kantor', 'role_id', 'state');
  var $order          = array('id', 'username', 'password', 'nama', 'email', 'no_hp', 'id_jabatan', 'jabatan', 'alamat', 'id_departement', 'foto', 'id_kantor', 'role_id', 'state');

  private function _get_data_query()
  {

    $this->db->select('users.id, users.username, users.password,users.nama, users.email, users.no_hp, users.id_jabatan, users.jabatan, users.alamat, users.id_departement, departement.nama_departement, users.id_kantor, users.foto, users.role_id, users.state');
    $this->db->from($this->table);
    $this->db->join('departement', 'users.id_departement = departement.id_departement');



    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('users.username', $search_data);
      $this->db->or_like('users.nama', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
      $this->db->order_by('id', 'DESC');
    }
  }

  public function getDataTableAcc()
  {
    $this->_get_data_query();
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }

  public function count_filtered_data()
  {
    $this->_get_data_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_data()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function getJabatan() 
  {
    $this->db->select('id_jabatan, nama_jabatan');
    $this->db->from('jabatan');
    $this->db->order_by('nama_jabatan', 'ASC');
    $query = $this->db->get();

    return $query->result_array();
  }

  public function getAllUserActive() 
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->where('state', '2');
    $query = $this->db->get();

    return $query->result_array();
  }

 
    public function update_signature($user_id, $signature_photo) {
        $this->db->set('signature_photo', $signature_photo);
        $this->db->where('id', $user_id);
        $this->db->update('users');
    }
    public function is_email_exists($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->num_rows() > 0;
    }
  
}
