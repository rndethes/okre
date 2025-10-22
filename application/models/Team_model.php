<?php

class Team_model extends CI_model
{
  public function getALLTeam()
  {
    return $query = $this->db->get('team')->result_array();
  }

  public function input_team($data, $table)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }

  public function getTeamById($id)
  {
    return $this->db->get_where('team', ['id_team' => $id])->row_array();
  }

  public function getProjectByTeam($id)
  {
    return $this->db->get_where('project', ['id_team' => $id])->row_array();
  }

  public function getAllTeamAcc()
  {
    return $query = $this->db->get('access_team')->result_array();
  }

  public function input_teamacc($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function delete_teamacc($id)
  {
    $this->db->delete('access_team', ['id_access_team' => $id]);
  }
  public function delete_team($id)
  {
    $this->db->delete('team', ['id_team' => $id]);
  }
  public function getTeamAcc()
  {
    $id_acc = $this->uri->segment(3);

    $query = "SELECT `access_team`.`id_access_team`,`access_team`.`id_user`,`access_team`.`id_team`, `users`.`nama`, `users`.`foto`, `users`.`username`,  `access_team`.`role_user`
             FROM `access_team`
             JOIN `users`
             ON `access_team`.`id_user` = `users`.`id`             
             WHERE `id_team` = '$id_acc'
             ORDER BY `access_team`.`role_user` DESC";
    return $this->db->query($query)->result_array();
  }
  
  public function getTeamAccByID($id)
  {
    $query = "SELECT `id_access_team`,`id_user`,`id_team`
             FROM `access_team`
             WHERE `id_access_team` = '$id'";
    return $this->db->query($query)->result_array();
  }

  public function getTeamProject($id_tm)
  {

    $query = "SELECT `users`.`foto`,`users`.`nama`, `access_team`.`id_team`, `access_team`.`id_user` 
             FROM `access_team`
             JOIN `users`
             ON `access_team`.`id_user` = `users`.`id`
             WHERE `access_team`.`id_team` = '$id_tm' 
             LIMIT 3";
    return $this->db->query($query)->result_array();
  }

  public function getTeamObj($idobj)
  {

    $query = "SELECT `users`.`foto`,`users`.`nama`, `access_objective`.`id_user` 
             FROM `access_objective`
             JOIN `users`
             ON `access_objective`.`id_user` = `users`.`id`
             WHERE `access_objective`.`id_objective` = '$idobj' 
             LIMIT 5";
    return $this->db->query($query)->result_array();
  }

  public function getByOneTeamObj($idobj)
  {

    $query = "SELECT `users`.`foto`,`users`.`nama`, `access_objective`.*
             FROM `access_objective`
             JOIN `users`
             ON `access_objective`.`id_user` = `users`.`id`
             WHERE `access_objective`.`id_objective` = '$idobj'";
    return $this->db->query($query)->row_array();
  }


  public function getMyTeamProject($id_tm,$id)
  {

    $query = "SELECT *
             FROM `access_team`
             WHERE `id_team` = '$id_tm'
             AND `id_user` = '$id'
             ";
    return $this->db->query($query)->row_array();
  }

  public function getTeamProjectAllOkr($id_tm)
  {

    $query = "SELECT `users`.`foto`,`users`.`nama`, `access_team`.`id_team`, `access_team`.`id_user`,`access_team`.`role_user`,`access_team`.`can_edit_okr`,`access_team`.`can_delete_okr`,`access_team`.`id_access_team`
             FROM `access_team`
             JOIN `users`
             ON `access_team`.`id_user` = `users`.`id`
             WHERE `access_team`.`id_team` = '$id_tm'";

    return $this->db->query($query)->result_array();
  }

  public function getTeamProjectAll($id_tm)
  {

    $query = "SELECT `users`.`foto`,`users`.`nama`, `access_team`.`id_team`, `access_team`.`id_user` 
             FROM `access_team`
             JOIN `users`
             ON `access_team`.`id_user` = `users`.`id`
             WHERE `access_team`.`id_team` = '$id_tm' 
             LIMIT 3";
    return $this->db->query($query)->result();
  }

  public function getUserTeamRoleOkr($id_tm,$id_user)
  {
    $query = "SELECT `role_user`,`can_edit_okr`,`can_delete_okr`
             FROM `access_team`
             WHERE `id_user` = '$id_user'
             AND `id_team` = '$id_tm'";

    return $this->db->query($query)->row_array();
  }


  public function getUserTeamRole($id_tm)
  {
    $id_user = $this->session->userdata('id');
    $query = "SELECT `role_user`
             FROM `access_team`
             WHERE `access_team`.`id_user` = '$id_user'
             AND `access_team`.`id_team` = '$id_tm'";
    return $this->db->query($query)->row_array();
  }

  public function getTeam()
  {
    $query = "SELECT `id_team`
             FROM `team`";
    return $this->db->query($query)->result_array();
  }
    public function getAllTeamLead() {
    $id_user = $this->session->userdata('id');
    $role    = $this->session->userdata('role_id');
    if($role == '1') {
    $query = "SELECT `access_team`.`id_access_team`, `access_team`.`id_team`, `team`.`nama_team`, `team`.`keterangan`
             FROM `access_team`
             JOIN `team`
             ON `access_team`.`id_team` = `team`.`id_team`
             GROUP BY `access_team`.`id_team`";
    } else {
       $query = "SELECT `access_team`.`id_access_team`, `access_team`.`id_team`, `team`.`nama_team`, `team`.`keterangan`
             FROM `access_team`
             JOIN `team`
             ON `access_team`.`id_team` = `team`.`id_team` 
             WHERE `id_user` = '$id_user'";
    }
     return $this->db->query($query)->result_array();
  }

  public function getTeamLast(){
    $query = "SELECT * 
              FROM `team`
              ORDER BY `id_team` DESC
              LIMIT 1";
      return $this->db->query($query)->result_array();
  }
  
  public function getProjectTim($id_project){
    $query = "SELECT id_team
    FROM `project`
    WHERE `id_project` = '$id_project'";
return $this->db->query($query)->row_array();
  }

  public function getUserTim($id_acc) {
    $query = "SELECT `access_team`.`id_access_team`,`access_team`.`id_user`,`access_team`.`id_team`, `users`.`nama`, `users`.`foto`, `users`.`username`,  `users`.`role_id`
             FROM `access_team`
             JOIN `users`
             ON `access_team`.`id_user` = `users`.`id` 
             WHERE `id_team` = '$id_acc'";
    return $this->db->query($query)->result_array();
  }

  public function checkTeamById($id,$iduser)
  {
    $this->db->select('delegate_key_result.*, users.nama');
    $this->db->from('delegate_key_result');
    $this->db->join('users','users.id = delegate_key_result.id_user_delegate');
    $this->db->where('delegate_key_result.id_user_delegate', $iduser);
    $this->db->where('delegate_key_result.id_kr_delegate', $id);

    return  $this->db->get()->row_array();
  }

  public function getDepartByDivisi() 
  {
    $id_dep = $this->session->userdata('id_departement');
    $this->db->select('id_division');
    $this->db->from('departement');
    $this->db->where('id_departement', $id_dep);
    $id_div = $this->db->get()->result_array();

    $this->db->select('id_departement, nama_departement');
    $this->db->from('departement');
    $this->db->where_in('id_division', array_column($id_div, 'id_division'));
    return $this->db->get()->result_array();
  }

  public function getUserByDepartement($id_depart)
  {
    $this->db->select('id');
    $this->db->from('users');
    $this->db->where_in('id_departement', $id_depart);
    return $this->db->get()->result_array();
  }

  public function getUserByJabatan()
  {
    $id_jab = $this->session->userdata('id_jabatan');

    $this->db->select('level_jabatan');
    $this->db->from('jabatan');
    $this->db->where('id_jabatan', $id_jab);
    $lvl = $this->db->get()->result_array();
    
    $levels = array_column($lvl, 'level_jabatan');

    if (in_array('TM', $levels)) {
      $this->db->select('users.*');
      $this->db->from('users');
      $this->db->join('jabatan', 'jabatan.id_jabatan = users.id_jabatan');      
      $query = $this->db->get();
      return $query->result_array();
    } else if (in_array('MM', $levels)) {
      $this->db->select('users.*');
      $this->db->from('users');
      $this->db->join('jabatan', 'jabatan.id_jabatan = users.id_jabatan');
      $this->db->where_in('jabatan.level_jabatan', array('MM', 'FM', 'OF'));
      $query = $this->db->get();
      return $query->result_array();
    } else if (in_array('FM', $levels)) {
      $this->db->select('users.*');
      $this->db->from('users');
      $this->db->join('jabatan', 'jabatan.id_jabatan = users.id_jabatan');
      $this->db->where_in('jabatan.level_jabatan', array('FM', 'OF'));
      $query = $this->db->get();
      return $query->result_array();
    } else if (in_array('OF', $levels)) {
      $this->db->select('users.*');
      $this->db->from('users');
      $this->db->join('jabatan', 'jabatan.id_jabatan = users.id_jabatan');
      $this->db->where('jabatan.level_jabatan', 'OF');
      $query = $this->db->get();
      return $query->result_array();
    }        
  }

  public function checkAccTeam($id_team, $id_user)
  {
    $this->db->select('*');
    $this->db->from('access_team');
    $this->db->where('id_team', $id_team);
    $this->db->where('id_user', $id_user);
    return $this->db->get()->result();
  }

  public function checkAccTeamInObj($id_team)
  {
    $this->db->select('*');
    $this->db->from('access_team');
    $this->db->where('id_team', $id_team);
  
    return $this->db->get()->result_array();
  }

  public function getUserByTeam($id)
  {
    $this->db->select('access_team.*,users.nama,users.foto');
    $this->db->from('access_team');
    $this->db->join('users', 'access_team.id_user = users.id');
    $this->db->where('access_team.id_team', $id);
    return $this->db->get()->result_array();
  }


  public function getUserActiveInSpace($sesiworkspace)
  {
    $iduser = $this->session->userdata('id');

    $this->db->select('space_team.*,users.*');
    $this->db->from('space_team');
    $this->db->join('users', 'space_team.id_user = users.id');
    $this->db->where('space_team.id_workspace', $sesiworkspace);
    // $this->db->where('space_team.id_user !=', $iduser);

    return $this->db->get()->result_array();
  }

  public function cekTeamSpace($idspace)
  {
    $this->db->select('*');
    $this->db->from('space_team');
    $this->db->where('id_workspace', $idspace);
    
    return $this->db->get()->result_array();
  }

  public function checkTeamObj($id)
  {
    $this->db->select('access_objective.*');
    $this->db->from('access_objective');
    $this->db->join('okr','okr.id_okr = access_objective.id_objective');
    $this->db->where('okr.id_project', $id);

    return  $this->db->get()->result_array();
  }

  public function cekAccSpace($id)
  {
    $this->db->select('*');
    $this->db->from('space_team');
    $this->db->where('id_access_team', $id);

    return $this->db->get()->result_array();
  }

  public function checkAccObj($id,$iduser)
  {
    $this->db->select('*');
    $this->db->from('access_objective');
    $this->db->where('id_objective', $id);
    $this->db->where('id_user', $iduser);

    return  $this->db->get()->row_array();
  }



}
