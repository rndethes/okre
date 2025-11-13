<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_model extends CI_Model {

    // Ambil detail note + nama pemilik
    public function get_note_by_reff($reff_note) {
        return $this->db->select('n.*, u.nama AS owner_name')
                        ->from('notes n')
                        ->join('users u', 'u.id = n.created_by', 'left')
                        ->where('n.reff_note', $reff_note)
                        ->get()
                        ->row();
    }

    // Ambil data coretan (jika ada)
    public function get_canvas_data($id_note) {
        return $this->db->select('canvas_json, updated_at')
                        ->from('notes_canvas')
                        ->where('id_note', $id_note)
                        ->get()
                        ->row_array();
    }
    
    public function get_note_detail($reff_note)
    {
        return $this->db->select('n.*, u.nama AS owner_name')
            ->from('notes n')
            ->join('users u', 'u.id = n.created_by', 'left')
            ->where('n.reff_note', $reff_note)
            ->get()
            ->row();
    }
}
