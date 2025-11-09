<?php

class Note_model extends CI_model
{
  public function get_note_by_reff($reff_note) {
        $this->db->select('id_note, reff_note, canvas_data_path');
        $this->db->from('notes');
        $this->db->where('reff_note', $reff_note);
        return $this->db->get()->row(); // Ambil satu baris
    }
}