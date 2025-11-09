<?php

class Space_model extends CI_model
{
  
    public function dataSpaceTeam($iduser)
    {
       $this->db->select('space_team.*,space.*');
       $this->db->from('space_team');
       $this->db->join('space', 'space.id_space  = space_team.id_workspace');
       $this->db->where('space_team.id_user', $iduser);
       $this->db->where('space_team.approval_user', 2);
       $this->db->where('space.kategory_space', "team");
       $this->db->order_by('space.name_space', "ASC");
  
      return $this->db->get()->result_array();
    }

    public function insert_task($data) {
      $this->db->insert('task', $data);
      return $this->db->insert_id();
    }
  


    public function checkAnggotaSpace($idspace)
    {
       $this->db->select('*');
       $this->db->from('space_team');
       $this->db->where('id_workspace', $idspace);
  
      return $this->db->get()->row_array();
    }
  

    public function dataSpaceActive($idspace)
    {
       $this->db->select('*');
       $this->db->from('space');
       $this->db->where('id_space', $idspace);
  
      return $this->db->get()->row_array();
    }

    public function allspaceTeam($iduser)
    {
       $this->db->select('space_team.*,space.*');
       $this->db->from('space_team');
       $this->db->join('space', 'space.id_space  = space_team.id_workspace');
       $this->db->where('space_team.id_user', $iduser);
       $this->db->where('space_team.approval_user', 2);
  
      return $this->db->get()->result_array();
    }

    public function allData($idspace,$id)
    {
       $this->db->select('*');
       $this->db->from('user_tables');
       $this->db->where('okr_intable', $id);
       $this->db->where('space_intable', $idspace);
  
      return $this->db->get()->result_array();
    }

    public function dataSpaceProject($id_user, $id_space)
    {
        $this->db->select('space_team.*, project.id_project, project.nama_project');
        $this->db->from('space_team');
        $this->db->join('space', 'space.id_space = space_team.id_workspace');
        $this->db->join('space_okr', 'space_okr.id_space = space.id_space');
        $this->db->join('project', 'space_okr.id_project = project.id_project');
        $this->db->where('space_team.id_user', $id_user);
        $this->db->where('space_team.approval_user', 2);
        $this->db->where('space.kategory_space', 'team');
        $this->db->where('space.id_space', $id_space);
    
        return $this->db->get()->result_array();
    }

    public function dataSpacePrivate($id)
    {
      $this->db->select('*');
      $this->db->from('space');
      $this->db->where('kategory_space', "private");
      $this->db->where('create_by', $id);
  
      return $this->db->get()->result_array();
    }

    public function checkSpaceById($idspace)
    {
      $this->db->select('*');
      $this->db->from('space');
      $this->db->where('id_space', $idspace);
  
      return $this->db->get()->row_array();
    }

    public function input_space($data, $table)
    {
      return $this->db->insert($table, $data);
    }

    public function getWorkspaceById($id_space) {

      $this->db->where('id_space', $id_space);
      $query = $this->db->get('space'); // Ganti dengan nama tabel yang sesuai
      return $query->row_array();
   }

    public function getProjectsByWorkspaceId($idspace)
    {
      $this->db->select('space_okr.id_space,project.*');
      $this->db->from('space_okr');
      $this->db->join('project', 'project.id_project = space_okr.id_project');
      $this->db->where('space_okr.id_space', $idspace);

      return $this->db->get()->result_array();
    }

    public function getProjectsAccessByWorkspaceId($idspace)
    {
      $iduser = $this->session->userdata("id");
      $this->db->select('space_okr.id_space,project.*');
      $this->db->from('space_okr');
      $this->db->join('project', 'project.id_project = space_okr.id_project');
      $this->db->join('access_team', 'access_team.id_team = project.id_team');
      $this->db->where('space_okr.id_space', $idspace);
      $this->db->where('access_team.id_user', $iduser);

      return $this->db->get()->result_array();
    }

    public function countSpaceTeam($id)
    {
        $this->db->select('*');
        $this->db->from('space_team');
        $this->db->where('id_workspace', $id);
      
      return $this->db->get()->num_rows();
    }

    public function checkUserAtTeam($idspace)
    {
      $this->db->select('space_team.*,users.foto,users.nama');
      $this->db->from('space_team');
      $this->db->join('users', 'users.id = space_team.id_user');
      $this->db->where('space_team.id_workspace', $idspace);

      return $this->db->get()->result_array();
    }


    public function checkUserAtTeamObj($idokr)
    {
      $this->db->select('access_objective.*,users.foto,users.nama');
      $this->db->from('access_objective');
      $this->db->join('users', 'users.id = access_objective.id_user');
      $this->db->where('access_objective.id_objective', $idokr);

      return $this->db->get()->result_array();
    }

    public function hapus_space($id) {
      $this->db->delete('space_team', ['id_workspace' => $id]);
    }

    public function hapus_workspace($id) {
      $this->db->delete('space', ['id_space' => $id]);
    }


    public function hapus_space_team($id) {
      $this->db->delete('space_team', ['id' => $id]);
    }

    public function hapus_new_doc($id) {
      $this->db->delete('document_new', ['id_document_new ' => $id]);
      $this->db->delete('document_new_log', ['id_document_new ' => $id]);
    }

    public function delete_message($id) {
      $this->db->delete('notification', ['user_id' => $id]);
    }

    public function delete_message_one($id) {
      $this->db->delete('notification', ['id_notif' => $id]);
    }



    public function hapus_document($id,$table) {
      if($table == "document_signatur_log") {
        $idtb = 'id_doc_signature';
      } else if($table == "document_signature") {
        $idtb = 'id_document_users';
      } else {
        $idtb = 'id_document';
      }

      $this->db->delete($table, [$idtb => $id]);
    }

    // ===== MODEL MINI DALAM CONTROLLER =====
private function getNotesBySpace($id_space)
{
    return $this->db->get_where('notes', ['id_space' => $id_space])->result_array();
}

private function insertNotes($data)
{
    $this->db->insert('notes', $data);
}

private function getNoteById($id_note)
{
    return $this->db->get_where('notes', ['id_note' => $id_note])->row_array();
}

private function deleteNote($id_note)
{
    $this->db->delete('notes', ['id_note' => $id_note]);
}



    public function checkSpaceOkr($id)
    {
      $this->db->select('*');
      $this->db->from('space_okr');
      $this->db->where('id_space', $id);

      return $this->db->get()->result_array();
    }

    public function checkSpaceOkrById($id)
    {
      $this->db->select('space_okr.*,space.*');
      $this->db->from('space_okr');
      $this->db->join('space', 'space.id_space  = space_okr.id_space');
      $this->db->where('space_okr.id_project', $id);

      return $this->db->get()->row_array();
    }

    public function checkApprovalSpace($iduser)
    {
      $this->db->select('*');
      $this->db->from('space_team');
      $this->db->where('id_user', $iduser);
      $this->db->where('status_user !=', "leader");
      $this->db->where('approval_user', 1);

      return $this->db->get()->result_array();
    }

    public function checkWhoNotif($iduser)
    {
      $this->db->select('space_team.*,users.*,space.*');
      $this->db->from('space_team');
      $this->db->join('space', 'space.id_space  = space_team.id_workspace');
      $this->db->join('users', 'users.id = space.create_by');
      $this->db->where('space_team.id_user', $iduser);
      $this->db->where('space_team.approval_user', 1);

      return $this->db->get()->result_array();
    }

    public function toggle_favorite($workspace_id, $user_id) {
      // Logika untuk memeriksa dan mengubah status favorit
      $this->db->where('id_space', $workspace_id);
      $this->db->where('create_by', $user_id); // Jika user memiliki preferensi favorit yang terpisah
      $workspace = $this->db->get('space')->row();

      $new_status = !$workspace->is_favorite;

      $this->db->where('id_space', $workspace_id);
      $this->db->update('space', ['is_favorite' => $new_status]);

      return $new_status;
    }

    public function dataMyDocumentAll($iduser,$idprj){
      $this->db->select('document.*,users.nama,project.*,space.*,');
      $this->db->from('document');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document.id_user_create', $iduser);
      $this->db->where('document.id_project', $idprj);
      $this->db->where('document.status_document !=', 4);
      $this->db->order_by('document.id_document', "DESC");
      

      return $this->db->get()->result_array();
    }

    public function dataMyDocument($iduser,$idprj){
      $this->db->select('document.*,users.nama,project.*,space.*,document_signature.*');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document_signature.id_user_doc = users.id');
      $this->db->where('document_signature.id_user_doc', $iduser);
      $this->db->where('document.id_project', $idprj);
      $this->db->where('document.status_document !=', 4);
      $this->db->order_by('document.id_document', "DESC");
      

      return $this->db->get()->result_array();
    }


    public function dataMyDocumentById($id){
      $this->db->select('document.*,users.nama,users.id,project.*,space.*');
      $this->db->from('document');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document.id_document', $id);
     // $this->db->where('document_signature.id_user_doc', $iduser);
      

      return $this->db->get()->row_array();
    }

    public function dataMyDocumentByIdInSpace($id){
      $this->db->select('document.*,users.nama,users.id,space.*');
      $this->db->from('document');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document.id_document', $id);
     // $this->db->where('document_signature.id_user_doc', $iduser);
      

      return $this->db->get()->row_array();
    }

    public function dataShowDocumentById($id,$iduser){
      $this->db->select('document.*,users.nama,users.id,project.*,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature,document_signature.note_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      $this->db->where('document_signature.id_user_doc', $iduser);
      
      return $this->db->get()->row_array();
    }


    public function dataShowDocumentSpaceById($id,$iduser){
      $this->db->select('document.*,users.nama,users.id,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature,document_signature.note_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      $this->db->where('document_signature.id_user_doc', $iduser);
      
      return $this->db->get()->row_array();
    }

    public function dataShowDocumentSpaceByIdAfterReject($id){
      $this->db->select('document.*,users.nama,users.id,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature,document_signature.note_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
     
      return $this->db->get()->row_array();
    }


    public function dataShowDocumentFileById($id){
      $this->db->select('document.*,users.nama,users.id,project.*,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      $this->db->where('document_signature.reff_document !=', NULL);
      $this->db->order_by('document_signature.no_signature', "DESC");
     

      return $this->db->get()->row_array();
    }

    public function dataShowDocumentFileInPjById($id){
      $this->db->select('document.*,users.nama,users.id,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      $this->db->where('document_signature.reff_document !=', NULL);
      $this->db->order_by('document_signature.no_signature', "DESC");
     

      return $this->db->get()->row_array();
    }

    public function dataShowDocumentFinishById($id){
      $this->db->select('document.*,users.nama,users.id,project.*,space.*,document_signature.no_signature,document_signature.note_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature,document_signature.note_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      

      return $this->db->get()->row_array();
    }

    public function dataShowDocumentFinishSpaceById($id){
      $this->db->select('document.*,users.nama,users.id,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.note_signature,document_signature.id_user_doc,document_signature.file_signature,document_signature.note_signature');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document_signature.id_document_users', $id);
      

      return $this->db->get()->row_array();
    }

    public function dataMySpaceUser($idspace,$iduser){
      $this->db->select('users.id,users.username,users.nama,users.id as idusers,space_team.*');
      $this->db->from('space_team');
      $this->db->join('users', 'space_team.id_user = users.id');
      $this->db->where('space_team.id_workspace', $idspace);
      
      return $this->db->get()->result_array();
    }
    public function dataMySpaceUserSide($idspace){
      $this->db->select('users.id,users.username,users.nama,users.id as idusers');
      $this->db->from('space_team');
      $this->db->join('users', 'space_team.id_user = users.id');
      $this->db->where('space_team.id_workspace', $idspace);
      
      return $this->db->get()->result_array();
    }

    public function updateDocument($id_document, $data) {
      $this->db->where('id_document', $id_document);
      $this->db->update('document', $data);
      }

      public function deleteDocumentSignatures($id_document) {
          $this->db->where('id_document_users', $id_document);
          $this->db->delete('document_signature');
      }

      public function insertDocumentSignature($data) {
          $this->db->insert('document_signature', $data);
      }

      public function save_signature_position($documentId, $signatureId, $x, $y) {
        $data = [
            'document_id' => $documentId,
            'signature_id' => $signatureId,
            'position_x' => $x,
            'position_y' => $y
        ];

        $this->db->insert('document_signature_positions', $data);
    }

    public function insertLogSignature($data) {
      $this->db->insert('document_signatur_log', $data);
    }

    public function dataUserAproval($iddoc)
    {
      $this->db->select('document_signature.*,document_signatur_log.*');
      $this->db->from('document_signature');
      $this->db->join('document_signatur_log', 'document_signature.id_document_users = document_signatur_log.id_doc_signature');
      $this->db->where('document_signature.id_document_users', $iddoc);
      $this->db->order_by('document_signatur_log.id_document_signature_log', 'DESC');

      return $this->db->get()->row_array();
    }

    public function logTerakhir($iddoc)
    {
      $this->db->select('*');
      $this->db->from('document_signatur_log');
      $this->db->where('id_doc_signature', $iddoc);
      $this->db->order_by('id_document_signature_log', 'DESC');

      return $this->db->get()->row_array();
    }

    public function DataAllAprove($iddoc)
    {
        $this->db->select('*');
        $this->db->from('document_signature');
        $this->db->where('id_document_users', $iddoc);
    
        $result = $this->db->get()->result_array();
    
         // Periksa apakah hasil kosong
            if (empty($result)) {
              return [
                  'data' => [],
                  'conclusion' => 'emptyresult', // Mengembalikan kesimpulan "emptyresult" jika hasil kosong
              ];
          }

          // Inisialisasi variabel untuk kesimpulan
          $statusConclusion = 'Approve'; // Asumsikan semua status adalah "Approve" terlebih dahulu

          // Periksa setiap status
          foreach ($result as $row) {
              if ($row['status_signature'] != 2) {
                  $statusConclusion = 'NotApprove'; // Jika ada status yang bukan 2, ubah kesimpulan menjadi "NotApprove"
                  break; // Keluar dari loop, tidak perlu memeriksa lebih lanjut
              }
          }

        // Tambahkan kesimpulan ke hasil
        return [
            'data' => $result,
            'conclusion' => $statusConclusion,
        ];
    }

    public function checkUserSignature($iduserscek,$idodc)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('id_document_users',$idodc);
      $this->db->where('file_signature',NULL);
      $this->db->order_by('no_signature', 'ASC');

      $result = $this->db->get()->row_array();
     
      
        // Jika ada hasil, kembalikan id_user_doc
      if ($result) {
        return $result['id_user_doc'];
      } else {
          // Jika tidak ada, kembalikan null atau nilai lain yang menandakan tidak ada user berikutnya
        return null;
      }
      
    }

    public function checkIfISign($iduserscek,$idodc)
    {
      $this->db->select('no_signature');
      $this->db->from('document_signature');
      $this->db->where('id_document_users',$idodc);
      $this->db->where('status_signature','5');
    
      return $this->db->get()->row_array();
    }

    public function checkIfISignature($iduserscek,$idodc)
    {
      $this->db->select('status_signature');
      $this->db->from('document_signature');
      $this->db->where('id_document_users',$idodc);
      $this->db->where('id_user_doc',$iduserscek);
      // $this->db->where('status_signature','2');
    
      return $this->db->get()->row_array();
    }

    public function checkIfISignatureApprove($iduserscek,$idodc)
    {
      $this->db->select('status_signature');
      $this->db->from('document_signature');
      $this->db->where('id_document_users',$idodc);
      $this->db->where('id_user_doc',$iduserscek);
      $this->db->where('status_signature','2');
    
      return $this->db->get()->row_array();
    }

    public function checkIfRevisi($idodc,$nosign,$iduserscek)
    {
      $this->db->select('id_user_doc');
      $this->db->from('document_signature');
      $this->db->where('id_document_users',$idodc);
      $this->db->where('id_user_doc',$iduserscek);
    
      $this->db->where('no_signature <',$nosign);
    
      return $this->db->get()->row_array();
    }

    public function checkWhoCreateRevisi($idodc,$nosign)
    {
      $this->db->select('id_user_create');
      $this->db->from('document');
      $this->db->where('id_document',$idodc);
    
      return $this->db->get()->row_array();
    }

    public function checkLogById($iddoc,$iduser)
    {
      $this->db->select('*');
      $this->db->from('document_signatur_log');
      $this->db->where('id_doc_signature', $iddoc);
      $this->db->where('id_user_log_document', $iduser);
      $this->db->where('status_log', '1');
  
      return $this->db->get()->row_array();
    }

    public function checkSignatureFile($iddocument)
    {
      $this->db->select('file_signature');
      $this->db->from('document_signature');
      $this->db->where('file_signature !=', NULL);
      $this->db->where('id_document_users', $iddocument);
      $this->db->order_by('no_signature', 'ASC');
  
      return $this->db->get()->row_array();
    }

    public function checkAllSignatureFile($iddocument)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('file_signature', NULL);
      $this->db->where('id_document_users', $iddocument);

  
      return $this->db->get()->row_array();
    }

    public function checkAllSignatureFileFirst($iddocument)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('file_signature', NULL);
      $this->db->where('id_document_users', $iddocument);

  
      return $this->db->get()->result_array();
    }

    public function checkLastNoSignature($iddocument)
    {
      $this->db->select('no_signature');
      $this->db->from('document_signature');
      $this->db->where('id_document_users', $iddocument);
      $this->db->order_by('no_signature', 'DESC');

  
      return $this->db->get()->row_array();
    }


    public function checkLastDocument($iddocument)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('id_document_users', $iddocument);
      $this->db->order_by('no_signature','DESC');

  
      return $this->db->get()->row_array();
    }

    public function dataLogDoc($iddoc)
    {

      $this->db->select('*');
      $this->db->from('document_signatur_log');
      $this->db->where('id_doc_signature', $iddoc);

      return $this->db->get()->result_array();
    }

    public function checkSignatureById($iddocument)
    {
      $this->db->select('file_signature');
      $this->db->from('document_signature');
      $this->db->where('id_document_users', $iddocument);

      return $this->db->get()->row_array();
    }

    public function insert_message($data) {
      $this->db->insert('message_chat', $data);
      return $this->db->insert_id(); // Mengembalikan ID dari workspace yang baru ditambahkan
    }
    public function insert_roommessage($data) {
      $this->db->insert('message_chat_room', $data);
      return $this->db->insert_id(); // Mengembalikan ID dari workspace yang baru ditambahkan
    }

    public function input_task($data) {
      $this->db->insert('task', $data);
      return $this->db->insert_id(); // Mengembalikan ID dari workspace yang baru ditambahkan
    }

    public function dataMessageInSpace($idproject)
    {
      $this->db->select('message_chat.*, users.username');
      $this->db->from('message_chat');
      $this->db->join('users', 'message_chat.user_id_mc = users.id');
      $this->db->join('message_chat_room', 'message_chat.chatroom_id_mc = message_chat_room.id_mcr');
      $this->db->where('message_chat_room.id_project_rc',$idproject);
      $this->db->order_by('message_chat.timestamp_mc', 'ASC');
  
      return $this->db->get()->result_array();
    }

    public function dataMessagebySpace($idspace)
    {
      $this->db->select('message_chat.*, users.username');
      $this->db->from('message_chat');
      $this->db->join('users', 'message_chat.user_id_mc = users.id');
      $this->db->join('message_chat_room', 'message_chat.chatroom_id_mc = message_chat_room.id_mcr');
      $this->db->where('message_chat_room.id_space_rc',$idspace);
      $this->db->where('message_chat_room.id_project_rc','0');
      $this->db->order_by('message_chat.timestamp_mc', 'ASC');
  
      return $this->db->get()->result_array();
    }

    public function dataObj($table,$idproject)
    {
      if($idproject == 0) {
        if($table == 'okr') {
          $this->db->select('*');
          $this->db->from($table);
          $this->db->order_by('id_okr','DESC');
        } else if($table == 'key_result') {
          $this->db->select('key_result.*,okr.id_project');
          $this->db->from($table);
          $this->db->join('okr', 'key_result.id_okr = okr.id_okr');
          $this->db->order_by('key_result.id_kr','DESC');
        }
      } else {
        if($table == 'okr') {
          $this->db->select('*');
          $this->db->from($table);
          $this->db->where('id_project',$idproject);
          $this->db->order_by('id_okr','DESC');
        } else if($table == 'key_result') {
          $this->db->select('key_result.*,okr.id_project');
          $this->db->from($table);
          $this->db->join('okr', 'key_result.id_okr = okr.id_okr');
          $this->db->where('okr.id_project',$idproject);
          $this->db->order_by('key_result.id_kr','DESC');
        }
      }
   

      return $this->db->get()->result_array();
    }

    public function dataDoc($table,$idproject)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_project',$idproject);
        $this->db->order_by('id_document','DESC');
        $this->db->limit(6);

      return $this->db->get()->result_array();
    }


    public function checkSignatureNote($iddocument)
    {
      $this->db->select('*');
      $this->db->from('document_signature');
      $this->db->where('id_document_users', $iddocument);
      $this->db->where('status_signature', '3');
      $this->db->order_by('id_doc_signature');
      $this->db->limit(1);

      return $this->db->get()->row_array();
    }

    public function dataTableMyDocumentAll($iduser, $id_project,$id_space){
      
      $this->db->select('document.*,users.nama,space.*');
      $this->db->from('document');
      $this->db->join('space', 'document.id_space  = space.id_space');
      $this->db->join('users', 'document.id_user_create = users.id');
      $this->db->where('document.id_space', $id_space);
      $this->db->where('document.status_document', '4');
      $this->db->order_by('document.created_date', 'DESC');
      
      if ($id_project != 0) {
          $this->db->where('document.id_project', $id_project);
      }
  
      return $this->db->get()->result_array();
  }

  var $table          = 'document';
  var $column_order   = array('id_document', 'name_document', 'file_document', 'type_document', 'id_user_create', 'id_space', 'id_project', 'status_document', 'created_date', 'publish_at', 'nama','name_space');
  var $order          = array('id_document', 'name_document', 'file_document', 'type_document', 'id_user_create', 'id_space', 'id_project', 'status_document', 'created_date', 'publish_at', 'nama','name_space');

  private function _get_data_querydoc($iduser, $id_project,$id_space) {
        $this->db->select('document.*,users.nama,space.*');
        $this->db->from('document');
        $this->db->join('space', 'document.id_space  = space.id_space');
        $this->db->join('users', 'document.id_user_create = users.id');
        $this->db->where('document.id_space', $id_space);
        $this->db->where('document.status_document', '4');
        $this->db->where('document.publish_at', '0000-00-00 00:00:00');
        $this->db->order_by('document.created_date', 'DESC');
        
        if ($id_project != 0) {
            $this->db->where('document.id_project', $id_project);
        }

        $search_data = $_POST['search']['value'];

        if (isset($search_data)) {
          $this->db->group_start();
          $this->db->like('document.name_document', $search_data);
          $this->db->or_like('users.nama', $search_data);
          $this->db->group_end();
        }

        if (isset($_POST['order'])) {
          $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
          $this->db->order_by('id_document', 'DESC');
        }
      }

  public function getDataTableDoc($iduser, $id_project,$id_space)
    {
      $this->_get_data_querydoc($iduser, $id_project,$id_space);
      if ($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);
      }
      $query = $this->db->get();
      return $query->result_array();
    }

    public function count_filtered_datadoc($iduser, $id_project,$id_space)
      {
        $this->_get_data_querydoc($iduser, $id_project,$id_space);
        $query = $this->db->get();
        return $query->num_rows();
      }

      public function count_all_datadoc()
      {
        $this->db->from($this->table);
        return $this->db->count_all_results();
      }


      private function _get_data_querydocpublish($iduser, $id_project,$id_space)
      {
        $this->db->select('document.*,users.nama,space.*');
        $this->db->from('document');
        $this->db->join('space', 'document.id_space  = space.id_space');
        $this->db->join('users', 'document.id_user_create = users.id');
        $this->db->where('document.id_space', $id_space);

        $this->db->where('document.status_document', '4');
        $this->db->where('document.publish_at !=', '0000-00-00 00:00:00');
        $this->db->order_by('document.created_date', 'DESC');
        
        if ($id_project != 0) {
            $this->db->where('document.id_project', $id_project);
        }

        $search_data = $_POST['search']['value'];

        if (isset($search_data)) {
          $this->db->group_start();
          $this->db->like('document.name_document', $search_data);
          $this->db->or_like('users.nama', $search_data);
          $this->db->group_end();
        }

        if (isset($_POST['order'])) {
          $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
          $this->db->order_by('id_document', 'DESC');
        }
      }

  public function getDataTableDocPublish($iduser, $id_project,$id_space)
    {
      $this->_get_data_querydocpublish($iduser, $id_project,$id_space);
      if ($_POST['length'] != -1) {
        $this->db->limit($_POST['length'], $_POST['start']);
      }
      $query = $this->db->get();
      return $query->result_array();
    }

    public function count_filtered_datadocpublish($iduser, $id_project,$id_space)
      {
        $this->_get_data_querydocpublish($iduser, $id_project,$id_space);
        $query = $this->db->get();
        return $query->num_rows();
      }

      public function count_all_datadocpublish()
      {
        $this->db->from($this->table);
        return $this->db->count_all_results();
      }



  public function getTotalDocuments($iduser, $id_space, $id_project = null){

   
      
    $this->db->select('document.*,users.nama,space.*');
    $this->db->from('document');
    $this->db->join('space', 'document.id_space  = space.id_space');
   // $this->db->join('project', 'document.id_project  = project.id_project');
    $this->db->join('users', 'document.id_user_create = users.id');
    //$this->db->where('document.id_user_create', $iduser);
    $this->db->where('document.id_space', $id_space);
    $this->db->where('document.status_document', '4');
    $this->db->order_by('document.created_date', 'DESC');
    
    if ($id_project) {
        $this->db->where('document.id_project', $id_project);
    }
    return $this->db->get()->num_rows();
}

  
  public function dataTableMyDocument($iduser, $id_space,$id_project = null){
      $this->db->select('document.*,users.nama,space.*,document_signature.*');
      $this->db->from('document');
      $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
      $this->db->join('space', 'document.id_space  = space.id_space');
      //$this->db->join('project', 'document.id_project  = project.id_project');
      $this->db->join('users', 'document_signature.id_user_doc = users.id');
      $this->db->where('document.id_space', $id_space);
      $this->db->where('document.status_document', '4');
      
      if ($id_project) {
          $this->db->where('document.id_project', $id_project);
      }

      $this->db->order_by('document.created_date', 'DESC');
  
      return $this->db->get()->result_array();
  }


  public function getSignatureFile($iddocument)
  {
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddocument);
    $this->db->where('status_signature', '2');
    $this->db->order_by('no_signature','DESC');
    $this->db->limit(1);

    return $this->db->get()->row_array();
  }


  public function dataShowDocumentByIdDoc($id){
    $this->db->select('document.*,users.nama,users.id,project.*,space.*,document_signature.no_signature,document_signature.id_doc_signature,document_signature.id_user_doc,document_signature.file_signature');
    $this->db->from('document');
    $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
    $this->db->join('space', 'document.id_space  = space.id_space');
    $this->db->join('project', 'document.id_project  = project.id_project');
    $this->db->join('users', 'document.id_user_create = users.id');
    $this->db->where('document_signature.id_document_users', $id);
    
    return $this->db->get()->row_array();
  }

  public function cekLastSign($id,$no){
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $id);
    $this->db->where('no_signature <=', $no);
    // $this->db->where('status_signature', "1");
    
    return $this->db->get()->result_array();
  }

  public function dataSignature($id){
    $this->db->select('document_signature.no_signature,document_signature.id_user_doc,users.nama');
    $this->db->from('document_signature');
    $this->db->join('users', 'document_signature.id_user_doc = users.id');
    $this->db->where('document_signature.id_document_users', $id);
    
    return $this->db->get()->result_array();
  }

  public function dataLastDocument($iddocument)
  {
    $this->db->select('file_signature,note_signature');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddocument);
    $this->db->where('file_signature !=', NULL);

    return $this->db->get()->row_array();
  }


  public function dataLastDocumentByNo($iddocument)
  {
    $this->db->select('file_signature');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddocument);
    $this->db->where('file_signature !=', NULL);
    $this->db->order_by('no_signature', 'DESC');

    return $this->db->get()->row_array();
  }


  public function checkDataDocument($order,$id,$iddoc)
  {
    $this->db->select('file_signature');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddoc);
    $this->db->where('no_signature', $order);
    $this->db->where('id_user_doc', $id);

    return $this->db->get()->row_array();
  }

  public function checkDataDocumentAll($iddoc)
  {
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddoc);
    $this->db->where('status_signature', '5');

    return $this->db->get()->row_array();
  }


  public function checkNoSign($iddoc,$nosign)
  {
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $iddoc);
    $this->db->where('no_signature <=', $nosign);
    // $this->db->order_by('no_signature', 'DESC');

    return $this->db->get()->result_array();
  }

  public function checkSignature($iddocument)
  {
    $this->db->select('document_signature.no_signature,document_signature.status_signature,users.*');
    $this->db->from('document_signature');
    $this->db->join('users', 'document_signature.id_user_doc = users.id');
    $this->db->where('document_signature.id_document_users', $iddocument);

    return $this->db->get()->result_array();
  }


  public function checkSignatureStatus($iddocument,$nosign)
  {
    $this->db->select('document_signature.no_signature,document_signature.status_signature,document_signature.updated_date,users.nama,users.nama,users.signature_photo');
    $this->db->from('document_signature');
    $this->db->join('users', 'document_signature.id_user_doc = users.id');
    $this->db->where('document_signature.id_document_users', $iddocument);
    // $this->db->where('document_signature.no_signature <= ', $nosign);

    return $this->db->get()->result_array();
  }

  public function checkFile($id_document)
  {
    $this->db->select('*');
    $this->db->from('document');
    $this->db->where('id_document', $id_document);

    return $this->db->get()->row_array();
  }

  public function cekSpaceDoc($id_project)
  {
    $this->db->select('id_space');
    $this->db->from('space_okr');
    $this->db->where('id_project', $id_project);

    return $this->db->get()->row_array();
  }

  public function cekFolderSpace($idspace)
  {
    $this->db->select('folder_space');
    $this->db->from('space');
    $this->db->where('id_space', $idspace);

    return $this->db->get()->row_array();
  }


  public function cekProjecteDoc($iddoc)
  {
    $this->db->select('id_project,id_space');
    $this->db->from('document');
    $this->db->where('id_document', $iddoc);

    return $this->db->get()->row_array();
  }

  public function checkIdChatRoom($idpj)
  {
    $this->db->select('id_mcr');
    $this->db->from('message_chat_room');
    $this->db->where('id_project_rc', $idpj);

    return $this->db->get()->row_array();
  }

  public function checkHaveChatRoom($idpj)
  {
    $this->db->select('*');
    $this->db->from('message_chat_room');
    $this->db->where('id_project_rc', $idpj);
    $this->db->where('id_space_rc', $idpj);

    return $this->db->get()->row_array();
  }

  public function documentSign($id)
  {
    $this->db->select('*');
    $this->db->from('document_signature');
    $this->db->where('id_document_users', $id);

    return $this->db->get()->result_array();
  }

  public function documentFile($id)
  {
    $this->db->select('file_document');
    $this->db->from('document');
    $this->db->where('id_document', $id);

    return $this->db->get()->result_array();
  }

  public function saveDocumentSignature($iduser,$id, $file_path) {
    $data = array(
      'id_document_sign' => $id,
        'user_document_last' => $iduser,
        'file_sign' => $file_path
    );
    $this->db->insert('document_last', $data);
}


public function checkLastDocumentSignature($iduser,$id)
{
  $this->db->select('file_sign');
  $this->db->from('document_last');
  $this->db->where('user_document_last', $iduser);
  $this->db->where('id_document_sign', $id);
  $this->db->order_by('id_document_last', 'DESC');


  return $this->db->get()->row_array();
}

public function arrayLastDocumentSignature($iduser,$id)
{
  $this->db->select('file_sign');
  $this->db->from('document_last');
  $this->db->where('user_document_last', $iduser);
  $this->db->where('id_document_sign', $id);
  $this->db->order_by('id_document_last', 'DESC');


  return $this->db->get()->result_array();
}

public function dataMyTask($status,$idprj)
{
  $this->db->select('task.*,users.nama');
  $this->db->from('task');
  $this->db->join('users', 'task.user_to_task = users.id');
  $this->db->where('task.task_in', $idprj);
  $this->db->where('task.status_task', $status);
  $this->db->order_by('task.updated_task', 'DESC');

  return $this->db->get()->result_array();
}

public function dataMyTaskInSpace($status,$idspace)
{
  $this->db->select('task.*,users.nama');
  $this->db->from('task');
  $this->db->join('users', 'task.user_to_task = users.id');
  $this->db->where('task.task_in_space', $idspace);
  $this->db->where('task.status_task', $status);
  $this->db->order_by('task.updated_task', 'DESC');

  return $this->db->get()->result_array();
}

public function getTaskById($idtask)
{
  $this->db->select('*');
  $this->db->from('task');
  $this->db->where('id_task', $idtask);

  return $this->db->get()->row_array();
}


public function hapus_task($id) {
  $this->db->delete('task', ['id_task' => $id]);
}

public function dataMyDocumentAllInSpace($iduser,$idspace){
  
 
  $this->db->select('document.*,users.nama,space.*,');
  $this->db->from('document');
  $this->db->join('space', 'document.id_space  = space.id_space');
  $this->db->join('users', 'document.id_user_create = users.id');
  $this->db->where('document.id_user_create', $iduser);
  $this->db->where('document.id_space', $idspace);
  $this->db->where('document.status_document !=', 4);
  $this->db->order_by('document.id_document', "DESC");
  

  return $this->db->get()->result_array();
}

public function dataMyDocumentAllSpace($iduser,$idspace){
  
 
  $this->db->select('document.*,users.nama,space.*,document_signature.*');
  $this->db->from('document');
  $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
  $this->db->join('space', 'document.id_space  = space.id_space');
  $this->db->join('users', 'document_signature.id_user_doc = users.id');
  $this->db->where('document.id_user_create !=', $iduser);
  $this->db->where('document_signature.id_user_doc !=', $iduser);
  $this->db->where('document.id_space', $idspace);
  $this->db->where('document.status_document !=', 4);
  $this->db->order_by('document.id_document', "DESC");
  

  return $this->db->get()->result_array();
}

public function dataMyDocumentInSpace($iduser,$idspace){
  $this->db->select('document.*,users.nama,space.*,document_signature.*');
  $this->db->from('document');
  $this->db->join('document_signature', 'document.id_document  = document_signature.id_document_users');
  $this->db->join('space', 'document.id_space  = space.id_space');
  $this->db->join('users', 'document_signature.id_user_doc = users.id');
  $this->db->where('document_signature.id_user_doc', $iduser);
  $this->db->where('document.id_space', $idspace);
  $this->db->where('document.status_document !=', 4);
  $this->db->order_by('document.id_document', "DESC");
  

  return $this->db->get()->result_array();
}


public function checkDoc($id)
  {
    $this->db->select('*');
    $this->db->from('document');
    $this->db->where('id_document', $id);

    return $this->db->get()->row_array();
  }

  public function get_all_tasks($idusers,$idspace)
  {
    $this->db->select('task.*, users.nama');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->where('task.task_in_space', $idspace);
    $this->db->where('task.status_task', '1');

    if($idusers != 'all'){
        $this->db->group_start();
        $this->db->where_in('task.created_by_task', $idusers);
        $this->db->or_where_in('task.user_to_task', $idusers);
        $this->db->group_end();
    }

    $result = $this->db->get()->result();

    return $result;
  }

  public function get_user_tasks($idusers)
  {
    $this->db->select('task.*, users.nama');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->where('task.status_task', '1');
    $this->db->where('task.user_to_task', $idusers);


    $result = $this->db->get()->result();

    return $result;
  }


  public function get_all_tasks_notwithspace($myid)
  {
    $this->db->select('task.*, users.nama');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->where('task.status_task', '1');
    $this->db->group_start();
    $this->db->where_in('task.created_by_task', $myid);
    $this->db->or_where_in('task.user_to_task', $myid);
    $this->db->group_end();
    

    $result = $this->db->get()->result();

    return $result;
  }

  public function cekSpaceTeamId($myid,$idspace){

  $this->db->select('*');
  $this->db->from('space_team');
  $this->db->where('id_user', $myid);
  $this->db->where('id_workspace', $idspace);

  return $this->db->get()->row_array();
}

public function checkDocInOKR($iddocument)
{
  $this->db->select('*');
  $this->db->from('document_in_okr');
  $this->db->where('id_from_doc_in_okr', $iddocument);

  return $this->db->get()->row_array();
}


public function checkTaskDocument($iddocument)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('document_in_task');
  $this->db->where('document_id_in_task', $iddocument);
  $this->db->where('user_doc_in_task', $id);

  return $this->db->get()->row_array();
}

public function checkAllTaskDocument($iddocument)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('document_in_task');
  $this->db->where('document_id_in_task', $iddocument);
  $this->db->where('user_doc_in_task', $id);

  return $this->db->get()->result_array();
}


public function checkDocInTask($idtask)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('document_in_task');
  $this->db->where('task_id', $idtask); 

  return $this->db->get()->row_array();
}

public function checkDocOkr($idtask)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('document_in_okr');
  $this->db->where('task_id', $idtask); 

  return $this->db->get()->row_array();
}


public function checkInTask($idtask)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('task_in_okr');
  $this->db->where('id_tk_inokr', $idtask); 

  return $this->db->get()->row_array();
}



public function checkMyTaskInOKR($id_task)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('task_in_okr');
  $this->db->where('id_tk_inokr', $id_task);

  return $this->db->get()->row_array();
}


public function checkIdByName($nama)
{
  $id = $this->session->userdata("id");

  $this->db->select('*');
  $this->db->from('task');
  $this->db->where('name_task', $nama);

  return $this->db->get()->row_array();
}

public function checkTaskInOkr($id)
{
  $this->db->select('*');
  $this->db->from('task_in_okr');
  $this->db->where('id_okr_inokr', $id);

  return $this->db->get()->row_array();
}

public function checkOkrInDocument($id)
{
  $this->db->select('*');
  $this->db->from('document_in_okr');
  $this->db->where('id_to_doc_in_okr', $id);

  return $this->db->get()->row_array();
}

public function checkMyTemplateKop()
{
  $this->db->select('*');
  $this->db->from('document_template');

  return $this->db->get()->result_array();
}

public function get_kop_document($id)
{
  $this->db->select('*');
  $this->db->from('document_template');
  $this->db->where('id_document_template', $id);

  return $this->db->get()->row_array();
}

public function checkMyDoc($id)
{
  $this->db->select('*');
  $this->db->from('document_new');
  $this->db->where('id_document_new', $id);

  return $this->db->get()->row_array();
}

public function get_all_templates()
{
  $idspace = $this->session->userdata('workspace_sesi');
  
  $this->db->select('*');
  $this->db->where('id_space', $idspace);
  $query = $this->db->get('document_template');

  return $query->result();
}

public function checkMyDocSpace($idspace)
{
  $this->db->select('document_new.*,space.name_space,users.nama');
  $this->db->from('document_new');
  $this->db->join('users', 'document_new.user_id = users.id');
  $this->db->join('space', 'document_new.space_id = space.id_space');
  $this->db->where('document_new.space_id', $idspace);

  return $this->db->get()->result_array();
}

public function getMyNewDocById($iddata)
{
  $this->db->select('document_new.*,space.name_space,users.nama');
  $this->db->from('document_new');
  $this->db->join('users', 'document_new.user_id = users.id');
  $this->db->join('space', 'document_new.space_id = space.id_space');
  $this->db->where('document_new.id_document_new', $iddata);

  return $this->db->get()->row_array();
}


public function getLogDocById($iddata)
{
  $this->db->select('*');
  $this->db->from('document_new_log');
  $this->db->where('id_document_new', $iddata);

  return $this->db->get()->result_array();
}

public function dataAllYourDocument($idspace)
{
  $this->db->select('document_new.*,space.name_space,users.nama');
  $this->db->from('document_new');
  $this->db->join('users', 'document_new.user_id = users.id');
  $this->db->join('space', 'document_new.space_id = space.id_space');
  $this->db->where('document_new.space_id', $idspace);

  return $this->db->get()->result_array();
}

  private function _get_data_querynewdoc($id_space)
  {
    $this->db->select('document_new.*,space.name_space,users.nama');
    $this->db->from('document_new');
    $this->db->join('users', 'document_new.user_id = users.id');
    $this->db->join('space', 'document_new.space_id = space.id_space');
    $this->db->where('document_new.space_id', $id_space);
    $this->db->order_by('document_new.created_date', 'DESC');
  

    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('document_new.name_document_new', $search_data);
      $this->db->or_like('users.nama', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
      $this->db->order_by('id_document_new', 'DESC');
    }
  }

  public function getDataTableDocNew($id_space)
  {
  $this->_get_data_querynewdoc($id_space);
  if ($_POST['length'] != -1) {
    $this->db->limit($_POST['length'], $_POST['start']);
  }
  $query = $this->db->get();
  return $query->result_array();
  }

  public function count_filtered_datadocnew($id_space)
  {
    $this->_get_data_querynewdoc($id_space);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_datadocnew()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }


  var $tabletask          = 'task';
  // var $column_ordertask   = array('id_task', 'name_task', 'desc_task', 'task_in_space', 'task_in', 'type_task', 'classification_task','id_task_from', 'create_date_task', 'user_to_task', 'user_from_task', 'status_task','start_task', 'overdue_task', 'approval_task_meet','created_by_task','updated_task');
  // var $ordertask          = array('id_task', 'name_task', 'desc_task', 'task_in_space', 'task_in', 'type_task','classification_task', 'id_task_from', 'create_date_task', 'user_to_task', 'user_from_task', 'status_task','start_task', 'overdue_task', 'approval_task_meet','created_by_task','updated_task');

  var $column_ordertask   = array('id_task', 'create_date_task', 'overdue_task','classification_task','name_task', 'user_to_task', 'user_from_task', 'status_task','start_task', 'approval_task_meet','created_by_task','updated_task');
  var $ordertask          = array('id_task','create_date_task', 'overdue_task','classification_task', 'name_task', 'user_to_task', 'user_from_task', 'status_task','start_task', 'approval_task_meet','created_by_task','updated_task');

  private function data_task_inspace($status,$idprj,$idspace)
  {
    $user = $this->session->userdata("id");
    $nama = $this->session->userdata("nama");

    $this->db->select('task.*,users.nama');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->where('task.task_in_space', $idspace);
    $this->db->where('task.status_task', $status);
   
    // Grup kondisi untuk user_to_task atau user_from_task
    $this->db->group_start();
    $this->db->where('task.user_to_task', $user);
    $this->db->or_where('task.user_from_task', $nama);
    $this->db->group_end();

    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('task.name_task', $search_data);
      $this->db->or_like('task.overdue_task', $search_data);
      $this->db->or_like('task.classification_task', $search_data);
      $this->db->or_like('users.nama', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->ordertask[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
     // $this->db->order_by('task.create_date_task', 'DESC');
    }
  }

  private function data_task($status,$idprj,$idspace)
  {
    $this->db->select('task.*,users.nama');
    $this->db->from('task');
    $this->db->join('users', 'task.user_to_task = users.id');
    $this->db->where('task.task_in', $idprj);
    $this->db->where('task.status_task', $status);
   

    $search_data = $_POST['search']['value'];

    if (isset($search_data)) {
      $this->db->group_start();
      $this->db->like('task.name_task', $search_data);
      $this->db->or_like('task.overdue_task', $search_data);
      $this->db->or_like('task.classification_task', $search_data);
      $this->db->or_like('users.nama', $search_data);
      $this->db->group_end();
    }

    if (isset($_POST['order'])) {
      $this->db->order_by($this->ordertask[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else {
      //$this->db->order_by('task.create_date_task', 'DESC');
    }
  }

  public function getDatatask()
  {
    $status = $this->input->post('statustask');
    $idprj  = $this->input->post('prj');
    $idspace  = $this->input->post('space');

    if($idprj == "space") {
      $this->data_task_inspace($status,$idprj,$idspace);
    } else {
      // Ambil data tugas berdasarkan status
      $this->data_task($status,$idprj,$idspace);
    }

  
    if ($_POST['length'] != -1) {
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }

  public function count_filtered_datatask()
  {
    $status = $this->input->post('statustask');
    $idprj  = $this->input->post('prj');
    $idspace  = $this->input->post('space');


    if($idprj == "space") {
      $this->data_task_inspace($status,$idprj,$idspace);
    } else {
      // Ambil data tugas berdasarkan status
      $this->data_task($status,$idprj,$idspace);
    }
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all_datatask()
  {
    $this->db->from($this->tabletask);
    return $this->db->count_all_results();
  }


  public function checkDocument($iddocument)
  {
    $this->db->select('document_signature.*,users.nama');
    $this->db->from('document_signature');
    $this->db->join('users', 'document_signature.id_user_doc = users.id');
    $this->db->where('document_signature.status_signature !=', '1');
    $this->db->where('document_signature.id_document_users', $iddocument);


    return $this->db->get()->result_array();
  }

  public function get_documents_by_ids($ids_array) {

    $this->db->select('document.*,users.nama,space.*');
    $this->db->from('document');
    $this->db->join('space', 'document.id_space  = space.id_space');
    $this->db->join('users', 'document.id_user_create = users.id');
    $this->db->where_in('document.id_document', $ids_array);
    $this->db->order_by('document.created_date', 'DESC');

      return $this->db->get()->result_array();
    }

    public function tandai_sudah_diarsip($ids_array) {
    // Pastikan array tidak kosong untuk mencegah error
    if (empty($ids_array)) {
        return false;
    }

    $dateNow = date("Y-m-d H:i:s");

    // Ganti 'status_arsip' dengan nama kolom yang Anda gunakan di tabel 'document'
    $data_update = [
          'backup_status' => 1,
          'backup_date' => $dateNow
        ]; // 1 berarti 'sudah diarsip'

    $this->db->where_in('id_document', $ids_array);
    return $this->db->update('document', $data_update);
}

public function getSpaceById($id_space)
{
    return $this->db->get_where('space', ['id_space_note' => $id_space])->row_array();
}




  





  





  
    
}