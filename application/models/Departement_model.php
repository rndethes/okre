<?php

class Departement_model extends CI_model
{
  public function getAllDepartement()
  {
    $this->db->select('*');
    $this->db->from('departement');
    $this->db->order_by('nama_departement', 'ASC');

    return $query = $this->db->get()->result_array();
  }
  public function input_departement($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function getDepartementById($id)
  {
    return $this->db->get_where('departement', ['id_departement' => $id])->row_array();
  }
  public function hapus_departement($id)
  {
    $this->db->delete('departement', ['id_departement' => $id]);
  }

  public function getOffice() 
  {
    $this->db->select('*');
    $this->db->from('kantor');
    $this->db->order_by('nama_kantor', 'ASC');

    return $query = $this->db->get()->result_array();
  }

  public function getDivision()
  {
    $this->db->select('*');
    $this->db->from('divisi');
    $this->db->order_by('nama_divisi', 'ASC');

    return $query = $this->db->get()->result_array();
  }
  public function getDivisiById($id)
  {
    return $this->db->get_where('divisi', ['id_divisi' => $id])->row_array();
  }
  public function input_divisi($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function hapus_divisi($id)
  {
    $this->db->delete('divisi', ['id_divisi' => $id]);
  }

  public function countAllJabatan() {
    return $this->db->count_all('jabatan');
  }

  public function getAllJabatan($limit, $offset)
  {
    $this->db->select('jabatan.*,departement.nama_departement');
    $this->db->from('jabatan');
    $this->db->join('departement','jabatan.id_departement = departement.id_departement');
    $this->db->order_by("FIELD(level_jabatan, 'TM', 'MM', 'FM', 'OF')");
    $this->db->limit($limit, $offset);

    return $query = $this->db->get()->result_array();
  }
  public function input_jabatan($data, $table)
  {
    return $this->db->insert($table, $data);
  }
  public function getJabatanById($id)
  {
    return $this->db->get_where('jabatan', ['id_jabatan' => $id])->row_array();
  }
  public function hapus_jabatan($id)
  {
    $this->db->delete('jabatan', ['id_jabatan' => $id]);
  }

  public function getAllJabatanView()
  {
    $this->db->select('*');
    $this->db->from('jabatan');

    return $query = $this->db->get()->result_array();
  }

  public function getAllJabatanViewWithReview()
  {
    $this->db->order_by('id_jabdivision', 'ASC');
    $this->db->order_by("
        CASE 
            WHEN level_jabatan = 'TM' THEN 1
            WHEN level_jabatan = 'MM' THEN 2
            WHEN level_jabatan = 'FM' THEN 3
            WHEN level_jabatan = 'OF' THEN 4
            ELSE 5
        END", 'ASC');
    
    $query = $this->db->get('nama_tabel');
    return $query->result_array();
  }
}
