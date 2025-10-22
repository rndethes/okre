<?php

class Project_model extends CI_model
{
  public function countAllProject()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == '1') {
      $this->db->select('project.*');
      $this->db->from('project');
      $this->db->join('team', 'project.id_team = team.id_team');
    } else {
      $this->db->select('project.*');
      $this->db->from('project');
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->join('access_team', 'access_team.id_team = team.id_team');
      $this->db->where('access_team.id_user', $user_id);
    }
    return $this->db->get()->num_rows();
  }
  public function countAllProjectinsSpace()
  {
    $spaceid = $this->session->userdata('workspace_sesi');
    $user_id = $this->session->userdata('id');

      $this->db->select('project.*');
      $this->db->from('space_okr');
      $this->db->join('project', 'project.id_project = space_okr.id_project');
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->join('access_team', 'access_team.id_team = team.id_team');
      $this->db->where('access_team.id_user', $user_id);
      $this->db->where('space_okr.id_space', $spaceid);
  
    return $this->db->get()->num_rows();
  }
  public function countCompleteProject()
  {
    $status = 1;
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == '1') {
      $this->db->select('project.id_project, project.nama_project, project.id_departement, project.priority_project, project.id_team, project.tanggal_awal_project, project.tanggal_akhir_project, project.description_project, project.file, project.work_status, project.value_project, departement.nama_departement , team.nama_team');
      $this->db->from('project');
      $this->db->join('departement', 'project.id_departement = departement.id_departement');
      $this->db->join('team', 'project.id_team = team.id_team');
    } else {
      $this->db->select('project.id_project, project.nama_project, project.id_departement, project.priority_project, project.id_team, project.tanggal_awal_project, project.tanggal_akhir_project, project.description_project, project.file, project.work_status, project.value_project, departement.nama_departement , team.nama_team, access_team.id_user');
      $this->db->from('project');
      $this->db->join('departement', 'project.id_departement = departement.id_departement');
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->join('access_team', 'access_team.id_team = team.id_team');
      $this->db->where('access_team.id_user', $user_id);
      $this->db->where('work_status', $status);
    }


    return $this->db->get()->num_rows();
  }

  public function count_key_result($id_okr)
  {
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_okr', $id_okr);
    return $this->db->get()->num_rows();
  }
  public function count_initiative($id_kr)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->where('id_kr', $id_kr);
    return $this->db->get()->num_rows();
  }

  public function sum_initiative($id_kr)
  {
    $this->db->select('SUM(value_initiative) as jumlahinitiative, SUM(value_ach_initiative) as jumlahachievment');
    $this->db->from('initiative');
    $this->db->where('id_kr', $id_kr);
    return $this->db->get()->row_array();
  }
  public function getAllProject()
  {
    return $query = $this->db->get('project')->result_array();
  }
  public function getAllObject()
  {
    $id_project = $this->uri->segment(3);
    $query = "SELECT *
              FROM `okr`
              WHERE `id_project` = '$id_project'";

    return $this->db->query($query)->result_array();
  }
  public function getAllObjectDelegasi($iduser)
  {
    $id_project = $this->uri->segment(3);
    $query = "SELECT *
              FROM `okr`
              JOIN `delegate_save`
              ON `okr`.`id_okr` = `delegate_save`.`id_okr`
              WHERE `delegate_save`.`id_user_delegate` = '$iduser' 
              AND `delegate_save`.`id_project` = '$id_project'";

    return $this->db->query($query)->result_array();
  }

  public function getAllKeyResultDelegasi($iduser)
  {
    $id_project = $this->uri->segment(3);
    $query = "SELECT *
              FROM `key_result`
              JOIN `delegate_save`
              ON `key_result`.`id_kr` = `delegate_save`.`id_kr`
              WHERE `delegate_save`.`id_user_delegate` = '$iduser' 
              AND `delegate_save`.`id_project` = '$id_project'";

    return $this->db->query($query)->result_array();
  }

  
  public function getAllKeyResult()
  {
    $id_okr = $this->uri->segment(4);
    $query = "SELECT *
              FROM `key_result`
              WHERE `id_okr` = '$id_okr'";

    return $this->db->query($query)->result_array();
  }

  public function getTotalKr($id_okr)
  {
    $query = "SELECT *
              FROM `okr`
              WHERE `id_okr` = '$id_okr'";
    return $this->db->query($query)->result_array();
  }
  public function getPrecentage($id_okr)
  {
    $query = "SELECT *
              FROM `key_result`
              WHERE `id_okr` = '$id_okr'";

    return $this->db->query($query)->result_array();
  }

  public function getPrecentageValueKr($id_kr)
  {
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_kr', $id_kr);
    return $this->db->get()->result_array();
  }

  public function getPrecentageInitiative($idkr){
    $query = "SELECT *
    FROM `initiative`
    WHERE `id_kr` = '$idkr'";

return $this->db->query($query)->result_array();
  }


  public function getPrecentageInInitiative($idini){
    $query = "SELECT *
    FROM `initiative`
    WHERE `id_initiative` = '$idini'";

return $this->db->query($query)->row_array();
  }

  public function getgetPrecentageKeyResult($idkr){
    $query = "SELECT *
    FROM `key_result`
    WHERE `id_kr` = '$idkr'";

return $this->db->query($query)->result_array();
  }

  public function getAchInitiative($id_kr)
  {
    $query = "SELECT *
              FROM `initiative`
              WHERE `id_kr` = '$id_kr'";

    return $this->db->query($query)->result_array();
  }
  public function getPrecentagefromKey($id)
  {
    $query = "SELECT *
              FROM `key_result`
              WHERE `id_kr` = '$id'";

    return $this->db->query($query)->result_array();
  }
  public function getPrecentageOkr($id_project)
  {
    $query = "SELECT *
              FROM `okr`
              WHERE `id_project` = '$id_project'";

    return $this->db->query($query)->result_array();
  }
  public function countOkr($id_project)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->where('id_project', $id_project);
    return $this->db->get()->num_rows();
  }

  public function checkPjById($id_project)
  {
    $this->db->select('*');
    $this->db->from('project');
    $this->db->where('id_project', $id_project);
    return $this->db->get()->row_array();
  }

  public function countKr($id_okr)
  {
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_okr', $id_okr);
    return $this->db->get()->num_rows();
  }

  public function countInit($id_kr)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->where('id_kr', $id_kr);
    return $this->db->get()->num_rows();
  }

  public function input_project($data, $table)
  {
    return $this->db->insert($table, $data);
  }

  public function input_key_result($data, $table)
  {
    $this->db->insert($table, $data);

    return $this->db->insert_id();
  }

  public function input_initiative($data, $table)
  {
    $this->db->insert($table, $data);

    return $this->db->insert_id();
  }

  public function input_delegate($data, $table)
  {
    return $this->db->insert($table, $data);
  }

  public function input_delegate_inisiative($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function input_adjust($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function getProjectById($id)
  {
    return $this->db->get_where('project', ['id_project' => $id])->row_array();
  }

  public function getOkrById($id)
  {
    return $this->db->get_where('okr', ['id_okr' => $id])->row_array();
  }
  
  public function getKeyById($id_project, $id)
  {
    return $this->db->get_where('okr', ['id_project' => $id_project, 'id_okr' => $id])->row_array();
  }

  public function getKeyByIdKr($id)
  {
    return $this->db->get_where('key_result', ['id_kr' => $id])->row_array();
  }

  public function getInitByIdInit($id)
  {
    return $this->db->get_where('initiative', ['id_initiative' => $id])->row_array();
  }

  public function edit_key($data, $id_kr)
  {
    $this->db->where('id_kr', $id_kr);
    $this->db->update('key_result', $data);

    return TRUE;
  }

  public function editkr($idkr, $user)
  { 
    $this->db->set('status_key_result', '1');
    $this->db->set('status_user_key_result', $user);
    $this->db->where('id_kr', $idkr);
    $this->db->update('key_result');

    return TRUE;
  }
  public function hapus_project($id,$id_team)
  {
    $this->db->delete('project', ['id_project' => $id]);
    $this->db->delete('kuadran', ['id' => $id]);
    $this->db->delete('team', ['id_team' => $id_team]);
    $this->db->delete('access_team', ['id_team' => $id_team]);
  }

  public function hapus_okr($id)
  {
    $this->db->delete('okr', ['id_okr' => $id]);
    $this->db->delete('kuadran', ['id' => $id]);
  }

  public function hapus_key_result($id)
  {
    $this->db->delete('key_result', ['id_kr' => $id]);
    $this->db->delete('kuadran', ['id' => $id]);
  }

  public function hapus_initiative_kr($id)
  {
    $this->db->delete('key_result', ['id_kr' => $id]);
    $this->db->delete('kuadran', ['id' => $id]);
  }

  public function hapus_initiative($id)
  {
    $this->db->delete('initiative', ['id_initiative' => $id]);
    $this->db->delete('kuadran', ['id' => $id]);
  }


  public function input_okr($data, $table)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }

  public function getInitiativeById($id_kr)
  {
    $user_id = $this->session->userdata('id');
    $query = "SELECT *
               FROM `initiative`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `initiative`.`id_initiative` AND `kuadran`.`id_user` = $user_id
               WHERE `id_kr` = '$id_kr'";

    return $this->db->query($query)->result_array();
  }

  public function getInitiativeByIdIni($idini)
  {
    $query = "SELECT *
               FROM `initiative`
               WHERE `id_initiative` = '$idini'";

    return $this->db->query($query)->result_array();
  }
  public function getKeyResultById($id_kr)
  {
    $query = "SELECT *
               FROM `key_result`
               WHERE `id_kr` = '$id_kr'";

    return $this->db->query($query)->result_array();
  }
  public function getOKRNewById($id_okr)
  {
    $query = "SELECT *
               FROM `okr`
               WHERE `id_okr` = '$id_okr'";

    return $this->db->query($query)->row_array();
  }

  public function getProjectJoinUser()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == 1) {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`,`project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               LIMIT 8";
    } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `access_team`.`id_user`,`project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `access_team`.`id_user` = '$user_id'
               LIMIT 8";
    }

    return $this->db->query($query)->result_array();
  }

  public function cekDelegasi($iduser)
  {
    $this->db->select('*');
    $this->db->from('delegate_save');
    $this->db->where('id_user_delegate', $iduser);
    
    return  $this->db->get()->row_array();
  }

  public function getYourAllProject()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == '1') {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `project`.`project_from` IS NULL
               ORDER BY `project`.`date_created` DESC
               LIMIT 8";
    } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `access_team`.`id_user`,`project`.`created_by`, `kuadran`.`id_priority`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `access_team`.`id_user` = '$user_id'
               ORDER BY `project`.`date_created` DESC 
               LIMIT 4";
    }

    return $this->db->query($query)->result_array();
  }


  public function getYourProject($idspace)
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    // if ($role_id == '1') {
    //   $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
    //            FROM `project`
    //            JOIN `team`
    //            ON `project`.`id_team` = `team`.`id_team`
    //            JOIN `space_okr`
    //            ON `project`.`id_project` = `space_okr`.`id_project`
    //            LEFT JOIN `kuadran` 
    //            ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
    //            WHERE `project`.`project_from` IS NULL
    //            AND `space_okr`.`id_space` = '$idspace'
    //            ORDER BY `project`.`updated_project` DESC
    //            LIMIT 8";
    // } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`, `access_team`.`id_user`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `access_team`.`id_user` = '$user_id'
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`updated_project` DESC 
               LIMIT 4";
    // }

    return $this->db->query($query)->result_array();
  }

  public function getYourProjectNoLimit($idspace)
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == '1') {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `project`.`project_from` IS NULL
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`updated_project` DESC";
    } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`, `access_team`.`id_user`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `access_team`.`id_user` = '$user_id'
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`updated_project` DESC";
    }

    return $this->db->query($query)->result_array();
  }


  public function getYourProjectDelegate($idspace)
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `delegate_save`
               ON `project`.`id_project` = `delegate_save`.`id_project`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `project`.`project_from` IS NULL
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`date_created` DESC";

    return $this->db->query($query)->result_array();
  }

  public function getRecentProject()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');
    
    if ($role_id == '1') {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               LIMIT 8";
    } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `access_team`.`id_user`, `project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               WHERE `access_team`.`id_user` = '$user_id'
               LIMIT 5";
    }

    return $this->db->query($query)->result_array();
  }

  public function getYourProjectDelegateAll($idspace)
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `delegate_save`
               ON `project`.`id_project` = `delegate_save`.`id_project`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `project`.`project_from` IS NULL
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`date_created` DESC
               LIMIT 8";

    return $this->db->query($query)->result_array();
  }

  public function getYourProjectDelegateNoAllLimit($idspace)
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `team`.`nama_team`,`project`.`created_by`, `kuadran`.`id_priority`,`space_okr`.`id_space`
               FROM `project`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `delegate_save`
               ON `project`.`id_project` = `delegate_save`.`id_project`
               JOIN `space_okr`
               ON `project`.`id_project` = `space_okr`.`id_project`
               LEFT JOIN `kuadran` 
               ON `kuadran`.`id` = `project`.`id_project` AND `kuadran`.`id_user` = $user_id
               WHERE `project`.`project_from` IS NULL
               AND `space_okr`.`id_space` = '$idspace'
               ORDER BY `project`.`date_created` DESC";

    return $this->db->query($query)->result_array();
  }


  public function getRecentProjectAll()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');
    
    if ($role_id == '1') {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               LIMIT 8";
    } else {
      $query = "SELECT `project`.`id_project`, `project`.`nama_project`, `project`.`id_departement`, `project`.`priority_project`, `project`.`id_team`, `project`.`tanggal_awal_project`, `project`.`tanggal_akhir_project`, `project`.`description_project`, `project`.`file`, `project`.`work_status`, `project`.`value_project`, `departement`.`nama_departement` , `team`.`nama_team`, `access_team`.`id_user`, `project`.`created_by`
               FROM `project`
               JOIN `departement`
               ON `project`.`id_departement` = `departement`.`id_departement`
               JOIN `team`
               ON `project`.`id_team` = `team`.`id_team`
               JOIN `access_team`
               ON `access_team`.`id_team` = `team`.`id_team`
               WHERE `access_team`.`id_user` = '$user_id'
               LIMIT 5";
    }

    return $this->db->query($query)->result_array();
  }

  var $table          = 'project';
  var $column_order   = array('id_project', 'nama_project', 'id_departement', 'priority_project', 'id_team', 'tanggal_awal_project', 'tanggal_akhir_project', 'description_project', 'file', 'work_status', 'value_project,created_by');
  var $order          = array('id_project', 'nama_project', 'id_departement', 'priority_project', 'id_team', 'tanggal_awal_project', 'tanggal_akhir_project', 'description_project', 'file', 'work_status', 'value_project,created_by');

  private function _get_data_query()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');

    if ($role_id == 1) {
      $this->db->select('project.id_project, project.nama_project, project.id_departement, project.priority_project, project.id_team, project.tanggal_awal_project, project.tanggal_akhir_project, project.description_project, project.file, project.work_status, project.value_project, departement.nama_departement , team.nama_team');
      $this->db->from($this->table);
      $this->db->join('departement', 'project.id_departement = departement.id_departement');
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->order_by('id_project', 'DESC');
    } else {
      $this->db->select('project.id_project, project.nama_project, project.id_departement, project.priority_project, project.id_team, project.tanggal_awal_project, project.tanggal_akhir_project, project.description_project, project.file, project.work_status, project.value_project, departement.nama_departement , team.nama_team , access_team.id_user');
      $this->db->from($this->table);
      $this->db->join('departement', 'project.id_departement = departement.id_departement');
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->join('access_team', 'access_team.id_team = team.id_team');
      $this->db->where('access_team.id_user', $user_id);
      $this->db->order_by('id_project', 'DESC');
    }

    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('project.id_project', $search_data);
      $this->db->or_like('project.nama_project', $search_data);
      $this->db->or_like('project.tanggal_awal_project', $search_data);
      $this->db->or_like('project.tanggal_akhir_project', $search_data);
      $this->db->or_like('team.nama_team', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
      $this->db->order_by('id_project', 'DESC');
    }
  }

  public function getDataTable()
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

  public function getuserRise($user)
  {
    $this->db->select('username,nama,foto');
    $this->db->from('users');
    $this->db->where('id', $user);

    return  $this->db->get()->row_array();
  }

  public function checkTeam($idpjkr){
    $this->db->select('id_team');
    $this->db->from('project');
    $this->db->where('id_project', $idpjkr);

    return  $this->db->get()->row_array();
  }

  public function checkDelegateRise($id_kr){
    $this->db->select('*');
    $this->db->from('delegate_key_result');
    $this->db->where('id_kr_delegate', $id_kr);
    $this->db->where('status_delegate', '1');

    return  $this->db->get()->row_array();
  }
  public function checkDelegateInisiativeRise($id_inisiative){
    $this->db->select('*');
    $this->db->from('delegate_inisiative');
    $this->db->where('id_inisiative_delegate', $id_inisiative);
    $this->db->where('status_delegate_inisiative', '1');

    return  $this->db->get()->row_array();
  }

  public function checkDelegateTake($id_kr){
    $this->db->select('*');
    $this->db->from('delegate_key_result');
    $this->db->where('id_kr_delegate', $id_kr);
    $this->db->where('status_delegate', '2');

    return  $this->db->get()->row_array();
  }
  

  public function checkDelegateInisiativeTake($id_inisiative){
    $this->db->select('*');
    $this->db->from('delegate_inisiative');
    $this->db->where('id_inisiative_delegate', $id_inisiative);
    $this->db->where('status_delegate_inisiative', '2');

    return  $this->db->get()->row_array();
  }

  public function checkDelegateInisiative($id_inisiative){
    $this->db->select('*');
    $this->db->from('delegate_inisiative');
    $this->db->where('id_inisiative_delegate', $id_inisiative);

    return $this->db->get()->num_rows();
  }

  public function checkDelegate($id_inisiative){
    $this->db->select('users.username,users.nama,users.foto,delegate_inisiative.id_inisiative_delegate,delegate_inisiative.status_delegate_inisiative');
    $this->db->from('delegate_inisiative');
    $this->db->join('users','users.id = delegate_inisiative.id_user_delegate_inisiative');
    $this->db->where('delegate_inisiative.id_inisiative_delegate', $id_inisiative);

    return $this->db->get()->result_array();
  }

  public function checkUserTake($iduser,$id_kr){
    $this->db->select('*');
    $this->db->from('delegate_key_result');
    $this->db->where('id_user_delegate', $iduser);
    $this->db->where('id_kr_delegate', $id_kr);
    $this->db->where('status_delegate', '2');

    return  $this->db->get()->row_array();
  }

  public function getuserTake($id_kr){
    $this->db->select('users.username,users.nama,users.foto,delegate_key_result.id_kr_delegate');
    $this->db->from('delegate_key_result');
    $this->db->join('users','users.id = delegate_key_result.id_user_delegate');
    $this->db->where('delegate_key_result.status_delegate', '2');
    $this->db->where('delegate_key_result.id_kr_delegate', $id_kr);
    // $this->db->where('id', $user);

    return  $this->db->get()->result_array();
  }

  public function getuserTakeIni($id_inisiative){
    $this->db->select('users.username,users.nama,users.foto,delegate_inisiative.id_inisiative_delegate');
    $this->db->from('delegate_inisiative');
    $this->db->join('users','users.id = delegate_inisiative.id_user_delegate_inisiative');
    $this->db->where('delegate_inisiative.status_delegate_inisiative', '2');
    $this->db->where('delegate_inisiative.id_inisiative_delegate', $id_inisiative);
    // $this->db->where('id', $user);

    return  $this->db->get()->result_array();
  }

  public function getuserRiseIni($id_inisiative){
    $this->db->select('users.username,users.nama,users.foto,delegate_inisiative.id_inisiative_delegate');
    $this->db->from('delegate_inisiative');
    $this->db->join('users','users.id = delegate_inisiative.id_user_delegate_inisiative');
    $this->db->where('delegate_inisiative.status_delegate_inisiative', '1');
    $this->db->where('delegate_inisiative.id_inisiative_delegate', $id_inisiative);
    // $this->db->where('id', $user);

    return  $this->db->get()->result_array();
  }

  public function checkUserTakeIni($iduser,$id_inisiative){
    $this->db->select('*');
    $this->db->from('delegate_inisiative');
    $this->db->where('id_user_delegate_inisiative', $iduser);
    $this->db->where('id_inisiative_delegate', $id_inisiative);
    $this->db->where('status_delegate_inisiative', '2');

    return  $this->db->get()->row_array();
  }


  public function checkUserRiseIni($iduser,$id_inisiative){
    $this->db->select('*');
    $this->db->from('delegate_inisiative');
    $this->db->where('id_user_delegate_inisiative', $iduser);
    $this->db->where('id_inisiative_delegate', $id_inisiative);
    $this->db->where('status_delegate_inisiative', '1');

    return  $this->db->get()->row_array();
  }

  public function getAllHistory($idini){
    $this->db->select('*');
    $this->db->from('history_inisiative');
    $this->db->where('id_ini', $idini);
 
    return  $this->db->get()->result_array();
  }

  public function inputKuadran($kuad) 
  {
    return $this->db->insert('kuadran', $kuad);
  }

  public function getKuadHigh()
  {
    $user_id = $this->session->userdata('id');
    $query = "SELECT `kuadran`.*, `okr`.`id_project`, `key_result`.`id_okr`, `project`.`nama_project`,`okr`.`description_okr`,`key_result`.`nama_kr`, `initiative`.`description`, `users`.`username`, `project`.`value_project`, `okr`.`value_okr`, `key_result`.`precentage`, `initiative`.`value_percent`
    FROM `kuadran` 
    LEFT JOIN `project` 
    ON `project`.`id_project` = `kuadran`.`id` 
    LEFT JOIN `okr` 
    ON `okr`.`id_okr`= `kuadran`.`id` 
    LEFT JOIN `key_result` 
    ON `key_result`.`id_kr`= `kuadran`.`id` 
    LEFT JOIN `initiative` 
    ON `initiative`.`id_initiative`= `kuadran`.`id` 
    JOIN `users` 
    ON `users`.`id`= `kuadran`.`id_user` 
    WHERE (`project`.`value_project` < 100 
    OR `okr`.`value_okr` < 100 
    OR `key_result`.`precentage` < 100 
    OR `initiative`.`value_percent` < 100)
    AND `id_priority` = 3 
    AND `id_user` = $user_id
    ORDER BY tanggal_akhir_project DESC, due_date DESC, due_datekey DESC, due_dateinit DESC;";

    return $this->db->query($query)->result();
  }

  public function getKuadMed()
  {
    $user_id = $this->session->userdata('id');
    $query = "SELECT `kuadran`.*, `project`.`nama_project`,`okr`.`description_okr`,`key_result`.`nama_kr`, `initiative`.`description`, `users`.`username`, `project`.`value_project`, `okr`.`value_okr`, `key_result`.`precentage`, `initiative`.`value_percent`
    FROM `kuadran` 
    LEFT JOIN `project` 
    ON `project`.`id_project` = `kuadran`.`id` 
    LEFT JOIN `okr` 
    ON `okr`.`id_okr`= `kuadran`.`id` 
    LEFT JOIN `key_result` 
    ON `key_result`.`id_kr`= `kuadran`.`id` 
    LEFT JOIN `initiative` 
    ON `initiative`.`id_initiative`= `kuadran`.`id` 
    JOIN `users` 
    ON `users`.`id`= `kuadran`.`id_user` 
    WHERE (`project`.`value_project` < 100 
    OR `okr`.`value_okr` < 100 
    OR `key_result`.`precentage` < 100 
    OR `initiative`.`value_percent` < 100)
    AND `id_priority` = 2
    AND `id_user` = $user_id
    ORDER BY `tanggal_akhir_project` DESC, `due_date` DESC, `due_datekey` DESC, `due_dateinit` DESC;";

    return $this->db->query($query)->result();
  }

  public function getKuadLow()
  {
    $user_id = $this->session->userdata('id');
    $query = "SELECT `kuadran`.*, `project`.`nama_project`,`okr`.`description_okr`,`key_result`.`nama_kr`, `initiative`.`description`, `users`.`username`, `project`.`value_project`, `okr`.`value_okr`, `key_result`.`precentage`, `initiative`.`value_percent`
    FROM `kuadran` 
    LEFT JOIN `project` 
    ON `project`.`id_project` = `kuadran`.`id` 
    LEFT JOIN `okr` 
    ON `okr`.`id_okr`= `kuadran`.`id` 
    LEFT JOIN `key_result` 
    ON `key_result`.`id_kr`= `kuadran`.`id` 
    LEFT JOIN `initiative` 
    ON `initiative`.`id_initiative`= `kuadran`.`id` 
    JOIN `users` 
    ON `users`.`id`= `kuadran`.`id_user` 
    WHERE (`project`.`value_project` < 100 
    OR `okr`.`value_okr` < 100 
    OR `key_result`.`precentage` < 100 
    OR `initiative`.`value_percent` < 100 )
    AND `id_priority` = 1
    AND `id_user` = $user_id
    ORDER BY tanggal_akhir_project DESC, due_date DESC, due_datekey DESC, due_dateinit DESC;";

    return $this->db->query($query)->result();
  }

  public function getKuadLowest()
  {
    $user_id = $this->session->userdata('id');
    $query = "SELECT `kuadran`.*, `project`.`nama_project`,`okr`.`description_okr`,`key_result`.`nama_kr`, `initiative`.`description`, `users`.`username`, `project`.`value_project`, `okr`.`value_okr`, `key_result`.`precentage`, `initiative`.`value_percent`
    FROM `kuadran` 
    LEFT JOIN `project` 
    ON `project`.`id_project` = `kuadran`.`id` 
    LEFT JOIN `okr` 
    ON `okr`.`id_okr`= `kuadran`.`id` 
    LEFT JOIN `key_result` 
    ON `key_result`.`id_kr`= `kuadran`.`id` 
    LEFT JOIN `initiative` 
    ON `initiative`.`id_initiative`= `kuadran`.`id` 
    JOIN `users` 
    ON `users`.`id`= `kuadran`.`id_user` 
    WHERE (`project`.`value_project` < 100 
    OR `okr`.`value_okr` < 100 
    OR `key_result`.`precentage` < 100 
    OR `initiative`.`value_percent` < 100)
    AND `id_priority` = 0 
    AND `id_user` = $user_id
    ORDER BY tanggal_akhir_project DESC, due_date DESC, due_datekey DESC, due_dateinit DESC;";
    return $this->db->query($query)->result();
  }

  public function countKuadHigh()
  {
    $this->db->select('*');
    $this->db->from('kuadran');
    $this->db->where('id_priority', '3');
    return $this->db->get()->num_rows();
  }
  public function countKuadMedium()
  {
    $this->db->select('*');
    $this->db->from('kuadran');
    $this->db->where('id_priority', '2');
    return $this->db->get()->num_rows();
  }
  public function countKuadLow()
  {
    $this->db->select('*');
    $this->db->from('kuadran');
    $this->db->where('id_priority', '1');
    return $this->db->get()->num_rows();
  }
  public function countKuadLowest()
  {
    $this->db->select('*');
    $this->db->from('kuadran');
    $this->db->where('id_priority', '0');
    return $this->db->get()->num_rows();
  }

  public function editOkrByIdPr($id_project)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->join('kuadran','kuadran.id = okr.id_okr', 'left');
    $this->db->where('okr.id_project', $id_project);

    return $this->db->get()->result_array();
  }

  public function editKrByIdOkr($id_okr)
  {

    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->join('kuadran','kuadran.id = key_result.id_kr', 'left');
    $this->db->where('key_result.id_okr', $id_okr);

    return $this->db->get()->result_array();
  }

  public function editInitByIdKr($id_kr)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->join('kuadran','kuadran.id = initiative.id_initiative', 'left');
    $this->db->where('initiative.id_kr', $id_kr);

    return $this->db->get()->result_array();
  }

  public function checkKuadPrj($id_project)
  {
    $this->db->select('id');
    $this->db->from('kuadran');
    $this->db->where('id', $id_project);
    $this->db->get()->num_rows();
  }

  public function checkKuadOkr($id_okr)
  {
    $this->db->select('id');
    $this->db->from('kuadran');
    $this->db->where('id', $id_okr);
    $this->db->get()->num_rows();
  }

  public function checkKuadKr($id_kr)
  {
    $this->db->select('id');
    $this->db->from('kuadran');
    $this->db->where('id', $id_kr);
    $this->db->get()->num_rows();
  }

  public function checkKuadInit($id_initiative)
  {
    $this->db->select('id');
    $this->db->from('kuadran');
    $this->db->where('id', $id_initiative);
    $this->db->get()->num_rows();
  }

  public function checkIni($id)
  {
    $this->db->select('id_kr');
    $this->db->from('initiative');
    $this->db->where('id_initiative', $id);

    return $this->db->get()->row_array();
  }

  // public function cekSpace($id)
  // {
  //   $this->db->select('*');
  //   $this->db->from('space');
  //   $this->db->where('create_by', $id);

  //   return $this->db->get()->num_rows();
  // }

   public function cekSpace($id)
    {
      $this->db->select('*');
      $this->db->from('space_team');
      $this->db->where('id_user', $id);

      return $this->db->get()->num_rows();
    }
  
  public function checkKr($id)
  {
   // Tambahkan ini untuk melihat nilai dan tipe data $id
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_kr', $id);

    return $this->db->get()->row_array();
  }
  
  public function checkOkr($id)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->where('id_okr', $id);

    return $this->db->get()->row_array();
  }
  
  public function inputBridgePrj($data)
  {
    return $this->db->insert('bridge_project', $data);
  }

  public function getUserDelegateOkr($id_okr)
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('bridge_project', 'bridge_project.id_user = users.id');
    $this->db->where('bridge_project.id_okr', $id_okr);

    return $this->db->get()->result();
  }

  public function cekUser($id_okr)
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('delegate_save', 'delegate_save.id_user_delegate = users.id');
    $this->db->where('delegate_save.id_okr', $id_okr);

    return $this->db->get()->result();
  }


  public function checkDelegateOkr($id_okr, $id_user)
  {
    $this->db->select('id_bridge');
    $this->db->from('bridge_project');
    $this->db->where('id_okr', $id_okr);
    $this->db->where('id_user', $id_user);

    return $this->db->get()->row_array();
  }

  public function inputBridgeOkr($data)
  {
    return $this->db->insert('bridge_okr', $data);
  }

  public function getUserDelegateKr($id_kr)
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('bridge_okr', 'bridge_okr.id_user = users.id');
    $this->db->where('bridge_okr.id_kr', $id_kr);

    return $this->db->get()->result();
  }

  public function checkDelegateKr($id_kr, $id_user)
  {
    $this->db->select('id_bridge');
    $this->db->from('bridge_okr');
    $this->db->where('id_kr', $id_kr);
    $this->db->where('id_user', $id_user);

    return $this->db->get()->row_array();
  }

  public function inputBridgeKr($data)
  {
    return $this->db->insert('bridge_kr', $data);
  }

  public function getUserDelegateInit($id_init)
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('bridge_kr', 'bridge_kr.id_user = users.id');
    $this->db->where('bridge_kr.id_initiative', $id_init);

    return $this->db->get()->result();
  }

  public function checkDelegateInit($id_init, $id_user)
  {
    $this->db->select('id_bridge');
    $this->db->from('bridge_kr');
    $this->db->where('id_initiative', $id_init);
    $this->db->where('id_user', $id_user);

    return $this->db->get()->row_array();
  }

  public function checkBrdPrj($id_project)
  {
    $this->db->select('*');
    $this->db->from('bridge_project');
    $this->db->where('id_project_to', $id_project);
    return $this->db->get()->row_array();
  }

  public function checkBrdOkr($id_project)
  {
    $this->db->select('*');
    $this->db->from('bridge_okr');
    $this->db->where('id_project_to', $id_project);
    return $this->db->get()->row_array();
  }

  public function checkBrdKr($id_project)
  {
    $this->db->select('*');
    $this->db->from('bridge_kr');
    $this->db->where('id_project_to', $id_project);
    return $this->db->get()->row_array();
  }

  public function checkBridgePrj($id_project)
  {
    $this->db->select('project_from');
    $this->db->from('project');
    $this->db->where('id_project', $id_project);
    return $this->db->get()->row_array();
  }

  public function countInisiative($idkr)
  {
      $this->db->where('id_kr', $idkr);
      $this->db->from('initiative');
      return $this->db->count_all_results();
  }

  public function countObjective($idokr)
  {
      $this->db->where('id_okr', $idokr);
      $this->db->from('okr');
      return $this->db->count_all_results();
  }

  public function countBridgePrj($idprj)
  {
      $this->db->where('id_project_from', $idprj);
      $this->db->from('bridge_project');
      return $this->db->count_all_results();
  }

  public function checkInisiative($id)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->where('id_kr', $id);

    return $this->db->get()->result_array();
  }

  public function cekValueOkr($id)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->where('id_okr', $id);

    return $this->db->get()->row_array();
  }

  public function insert_workspace($data) {
    $this->db->insert('space', $data);
    return $this->db->insert_id(); // Mengembalikan ID dari workspace yang baru ditambahkan
  }

  public function add_user_to_workspace($workspace_id, $user_ids, $creator_id) {
    // Tambahkan pengguna yang membuat workspace sebagai leader
    $data = array(
        'id_workspace'  => $workspace_id,
        'id_user'       => $creator_id,
        'status_user'   => 'admin',
        'approval_user' => 2,
        'can_edit'      => 1,
        'can_delete'    => 1,
    );

    $this->db->insert('space_team', $data);

    // Tambahkan pengguna lain sebagai staff
    foreach ($user_ids as $user_id) {
        if ($user_id != $creator_id) {
            $data = array(
                'id_workspace'  => $workspace_id,
                'id_user'       => $user_id,
                'status_user'   => 'editor',
                'approval_user'   => 1,
                'can_edit'      => 1,
                'can_delete'    => 0,
            );
            $this->db->insert('space_team', $data);
        }
    }
}
public function add_user_workspace($workspace_id, $creator_id) {
    $data = array(
      'id_workspace'  => $workspace_id,
      'id_user'       => $creator_id,
      'status_user'   => 'admin',
      'approval_user' => 2,
      'can_edit'      => 1,
      'can_delete'    => 1,
  );

  $this->db->insert('space_team', $data);

}

public function countAllSpace()
{
  $role_id = $this->session->userdata('role_id');
  $user_id = $this->session->userdata('id');

  if ($role_id == '1') {
    $this->db->select('*');
    $this->db->from('space');
  } else {
    $this->db->select('space_team.*,space.*');
    $this->db->from('space_team');
    $this->db->join('space', 'space.id_space  = space_team.id_workspace');
    $this->db->where('space_team.id_user', $user_id);
    $this->db->where('space_team.approval_user', 2);
  }
  return $this->db->get()->num_rows();
}

public function countTeamSpace()
{
  $status = 1;
  $role_id = $this->session->userdata('role_id');
  $user_id = $this->session->userdata('id');

  if ($role_id == '1') {
    $this->db->select('*');
    $this->db->from('space');
    $this->db->where('kategory_space', "team");
  } else {
    $this->db->select('space_team.*,space.*');
    $this->db->from('space_team');
    $this->db->join('space', 'space.id_space  = space_team.id_workspace');
    $this->db->where('space_team.id_user', $user_id);
    $this->db->where('space_team.approval_user', 2);
    $this->db->where('space.kategory_space', "team");
  }


  return $this->db->get()->num_rows();
}

public function countPrivateSpace()
{
  $status = 1;
  $role_id = $this->session->userdata('role_id');
  $user_id = $this->session->userdata('id');

  if ($role_id == '1') {
    $this->db->select('*');
    $this->db->from('space');
    $this->db->where('kategory_space', "private");
  } else {
    $this->db->select('space_team.*,space.*');
    $this->db->from('space_team');
    $this->db->join('space', 'space.id_space  = space_team.id_workspace');
    $this->db->where('space_team.id_user', $user_id);
    $this->db->where('space_team.approval_user', 2);
    $this->db->where('space.kategory_space', "private");
  }


  return $this->db->get()->num_rows();
}


public function checkOKRbyProject($id)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->where('id_project', $id);

    return $this->db->get()->result_array();
  }

  public function checkRowOKRbyProject($id)
  {
    $this->db->select('*');
    $this->db->from('okr');
    $this->db->where('id_project', $id);

    return $this->db->get()->row_array();
  }

  public function checkKrbyOKR($id)
  {
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_okr', $id);

    return $this->db->get()->result_array();
  }

  public function hapus_okrall($id)
  {
    $this->db->delete('okr', ['id_okr' => $id]);
  }

  public function hapus_team($id)
  {
    $this->db->delete('access_team', ['id_access_team' => $id]);
  }


  
  private function _get_data_query_workspace()
  {
    $role_id = $this->session->userdata('role_id');
    $user_id = $this->session->userdata('id');


    $id_space = $this->input->post('idspace');


      $this->db->select('project.id_project, project.nama_project, project.id_departement, project.priority_project, project.id_team, project.tanggal_awal_project, project.tanggal_akhir_project, project.description_project, project.file, project.work_status, project.value_project, team.nama_team , access_team.id_user');
      $this->db->from($this->table);
      $this->db->join('team', 'project.id_team = team.id_team');
      $this->db->join('access_team', 'access_team.id_team = team.id_team');
      $this->db->join('space_okr', 'project.id_project = space_okr.id_project');
      $this->db->where('access_team.id_user', $user_id);
      $this->db->where('space_okr.id_space', $id_space);
      $this->db->order_by('id_project', 'DESC');
  

    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('project.id_project', $search_data);
      $this->db->or_like('project.nama_project', $search_data);
      $this->db->or_like('project.tanggal_awal_project', $search_data);
      $this->db->or_like('project.tanggal_akhir_project', $search_data);
      $this->db->or_like('team.nama_team', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
      $this->db->order_by('id_project', 'DESC');
    }
  }

  public function getDataTableWorkspace()
  {
    $this->_get_data_query_workspace();
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }

  public function count_filtered_data_workspace()
  {
    $this->_get_data_query_workspace();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_data_workspace()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function cekChat($id,$workspace_sesi)
  {
    $this->db->select('*');
    $this->db->from('message_chat_room');
    $this->db->where('id_space_rc', $workspace_sesi);
    $this->db->where('id_project_rc', $id);

    return $this->db->get()->row_array();
  }

  public function checkKeyByPj($id)
  {
    $this->db->select('key_result.*,okr.description_okr');
    $this->db->from('key_result');
    $this->db->join('okr', 'okr.id_okr = key_result.id_okr');
    $this->db->where('okr.id_project', $id);

    return $this->db->get()->result_array();
  }

  public function checkOneOKRbyProject($id)
  {
    $this->db->select('key_result.*,okr.description_okr');
    $this->db->from('okr');
    $this->db->join('key_result', 'key_result.id_okr = okr.id_okr');
    $this->db->where('okr.id_project', $id);

    return $this->db->get()->result_array();
  }

  public function checkByOneOKRbyProject($id)
  {
    $this->db->select('key_result.*,okr.description_okr');
    $this->db->from('okr');
    $this->db->join('key_result', 'key_result.id_okr = okr.id_okr');
    $this->db->where('okr.id_project', $id);

    return $this->db->get()->row_array();
  }
  

  public function checkOneOKRbySpace($idspace)
  {
    $this->db->select('space_okr.id_project,key_result.*,okr.description_okr');
    $this->db->from('space_okr');
    $this->db->join('okr', 'space_okr.id_project = okr.id_project');
    $this->db->join('key_result', 'key_result.id_okr = okr.id_okr');
    $this->db->where('space_okr.id_space', $idspace);

    return $this->db->get()->result_array();
  }

  public function getInisiativesByKeyResultId($id_kr)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->where('id_kr', $id_kr);
    return $this->db->get()->result_array();
  }


  public function checkDataKrbyOKR($id)
  {
    $this->db->select('*');
    $this->db->from('key_result');
    $this->db->where('id_kr', $id);

    return $this->db->get()->row_array();
  }

  public function checkDataIni($id)
  {
    $this->db->select('*');
    $this->db->from('initiative');
    $this->db->where('id_initiative', $id);

    return $this->db->get()->row_array();
  }


  





}

