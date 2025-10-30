<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library(array('session', 'upload'));
        $this->load->database();
        $this->load->model('Space_model');
    }

    // ==================================================
    // 1️⃣ Halaman utama Notes
    // ==================================================
    public function index($id_space = null)
    {
        if ($id_space === null) {
            $id_space = $this->session->userdata('workspace_sesi');
        } else {
            $this->session->set_userdata('workspace_sesi', $id_space);
        }

        $data['space'] = $this->Space_model->getWorkspaceById($id_space);
        $data['notes'] = $this->getNotesBySpace($id_space);
        $data['title'] = 'Sketch / Notes';

        // Data user login (topbar)
        $data['users_name'] = $this->db
            ->get_where('users', ['username' => $this->session->userdata('username')])
            ->row_array();

        // Template
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('notes/index', $data);
        $this->load->view('template/footer');
    }

    // ==================================================
    // 2️⃣ Proses Upload PDF + Simpan ke DB + Buka Konva
    // ==================================================
    public function upload_action()
    {
        $id_space     = $this->session->userdata('workspace_sesi');
        $created_by   = $this->session->userdata('id');
        $created_date = date('Y-m-d H:i:s');

        $config['upload_path']   = FCPATH . 'uploads/documents/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 51200; // 50MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('pdf_file')) {
            $error = strip_tags($this->upload->display_errors());
            $this->session->set_flashdata('flashPj', 'Gagal upload: ' . $error);
            redirect('notes/index/' . $id_space);
            return;
        }

        $dataUpload = $this->upload->data();

        // --- Simpan ke database
        $insertData = [
            'reff_note'     => uniqid('NOTE_'),
            'name_notes'    => $this->input->post('name_notes', TRUE),
            'file_note'     => $dataUpload['file_name'],
            'id_space_note' => $id_space,
            'state'         => 'active',
            'created_by'    => $created_by,
            'created_date'  => $created_date,
            'updated_date'  => $created_date
        ];

        $this->insertNotes($insertData);

        // Redirect ke editor konva
        redirect('notes/konva/' . $dataUpload['file_name']);
    }

    // ==================================================
    // 3️⃣ Halaman Editor Konva (PDF dengan anotasi)
    // ==================================================
    public function konva($filename = null)
    {
        if (!$filename) redirect('notes/index/' . $this->session->userdata('workspace_sesi'));

        $file_path = FCPATH . 'uploads/documents/' . $filename;
        if (!file_exists($file_path)) {
            show_error('File tidak ditemukan: ' . $filename);
            return;
        }

        $data['filename'] = $filename;
        $this->load->view('notes/document_konva', $data);
    }

    // ==================================================
    // 4️⃣ Canvas kosong
    // ==================================================
    public function canvas_blank()
    {
        $this->load->view('notes/canvas_blank');
    }

    // ==================================================
    // 5️⃣ View PDF (untuk preview)
    // ==================================================
    public function view_pdf($filename)
    {
        $path = FCPATH . 'uploads/documents/' . $filename;
        if (!file_exists($path)) {
            show_404();
            return;
        }

        while (ob_get_level()) ob_end_clean();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }

    // ==================================================
    // 6️⃣ Hapus Dokumen
    // ==================================================
    public function delete($id)
    {
        $note = $this->getNoteById($id);

        if ($note) {
            $file_path = FCPATH . 'uploads/documents/' . $note['file_note'];
            if (file_exists($file_path)) unlink($file_path);
            $this->deleteNote($id);
        }

        redirect('notes/index/' . $this->session->userdata('workspace_sesi'));
    }

    // ==================================================
    // 7️⃣ SAVE CANVAS AJAX (simpan JSON + image ke server & DB)
    // ==================================================
    public function save_canvas()
    {
        // only accept POST
        if ($this->input->method(TRUE) !== 'POST') {
            return $this->output_json(['status' => 'error', 'message' => 'Method not allowed'], 405);
        }

        // Set basic variables
        $created_by   = $this->session->userdata('id') ?: null; // sesuaikan key session
        $created_date = date('Y-m-d H:i:s');

        $name_notes = $this->input->post('name_notes', TRUE) ?: 'Untitled';
        $reff_note  = $this->input->post('reff_note', TRUE);
        if (empty($reff_note)) {
            $reff_note = uniqid('NOTE_');
        }
        $id_space = $this->input->post('id_space_note', TRUE) ?: $this->session->userdata('workspace_sesi');

        // optional meta_pages (JSON string) describing overlays per page
        $meta_pages_raw = $this->input->post('meta_pages', TRUE);
        $meta_pages = null;
        if ($meta_pages_raw) {
            $meta_pages = json_decode($meta_pages_raw, true);
            if ($meta_pages === null) $meta_pages = null; // invalid JSON -> treat as null
        }

        // create folder structure
        $base_dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'canvas' . DIRECTORY_SEPARATOR;
        $img_dir  = $base_dir . 'img' . DIRECTORY_SEPARATOR;
        if (!is_dir($base_dir)) mkdir($base_dir, 0755, true);
        if (!is_dir($img_dir)) mkdir($img_dir, 0755, true);

        $saved = [];
        $this->db->trans_begin();

        // Count uploaded files like page_1, page_2...
        $files_received = 0;
        foreach ($_FILES as $k => $v) {
            if (strpos($k, 'page_') === 0) $files_received++;
        }

        if ($files_received > 0) {
            // handle multipart file uploads
            foreach ($_FILES as $fieldName => $fileInfo) {
                if (strpos($fieldName, 'page_') !== 0) continue;
                $pageNo = (int) str_replace('page_', '', $fieldName);
                if ($fileInfo['error'] !== UPLOAD_ERR_OK) {
                    // skip this page
                    continue;
                }
                $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
                $imgFilename = $reff_note . '_p' . $pageNo . '_' . time() . '.' . $ext;
                $imgPathRel  = 'uploads/canvas/img/' . $imgFilename;
                $imgPathAbs  = $img_dir . $imgFilename;

                if (move_uploaded_file($fileInfo['tmp_name'], $imgPathAbs)) {
                    // write JSON metadata
                    $meta = (isset($meta_pages[$pageNo - 1]) ? $meta_pages[$pageNo - 1] : []);
                    $jsonFilename = $reff_note . '_p' . $pageNo . '_' . time() . '.json';
                    $jsonPathRel  = 'uploads/canvas/' . $jsonFilename;
                    $jsonPathAbs  = $base_dir . $jsonFilename;
                    $jsonData = json_encode([
                        'meta' => $meta,
                        'page_number' => $pageNo,
                        'image' => $imgPathRel,
                        'saved_at' => $created_date
                    ], JSON_UNESCAPED_UNICODE);

                    if (write_file($jsonPathAbs, $jsonData)) {
                        // insert DB
                        $row = [
                            'reff_note'    => $reff_note,
                            'name_notes'   => $name_notes,
                            'page_number'  => $pageNo,
                            'canvas_data'  => $jsonData,
                            'file_json'    => $jsonPathRel,
                            'file_image'   => $imgPathRel,
                            'id_space_note'=> $id_space,
                            'state'        => 'active',
                            'created_by'   => $created_by,
                            'created_date' => $created_date,
                            'updated_date' => $created_date
                        ];
                        $this->db->insert('document_konva', $row);
                        $saved[] = ['page' => $pageNo, 'json' => $jsonPathRel, 'img' => $imgPathRel];
                    }
                }
            }
        } else {
            // fallback: accept pages as POSTed JSON array (pages param = JSON string array of dataURL)
            $page_data_raw = $this->input->post('pages', FALSE);
            if (empty($page_data_raw)) {
                // maybe pages sent as "page_data[]" - try raw POST body
                $raw = $this->input->raw_input_stream;
                // try decode raw JSON if present like { pages: [...] }
                $raw_json = json_decode($raw, true);
                if ($raw_json && isset($raw_json['pages'])) {
                    $page_data = $raw_json['pages'];
                } else {
                    $page_data = null;
                }
            } else {
                $page_data = json_decode($page_data_raw, true);
            }

            if (!empty($page_data) && is_array($page_data)) {
                foreach ($page_data as $i => $dataURL) {
                    $pageNo = $i + 1;
                    if (preg_match('/^data:image\/(\w+);base64,/', $dataURL, $m)) {
                        $ext = ($m[1] === 'jpeg') ? 'jpg' : $m[1];
                        $imgFilename = $reff_note . '_p' . $pageNo . '_' . time() . '.' . $ext;
                        $imgPathRel  = 'uploads/canvas/img/' . $imgFilename;
                        $imgPathAbs  = $img_dir . $imgFilename;

                        $base64 = substr($dataURL, strpos($dataURL, ',') + 1);
                        $imgData = base64_decode($base64);
                        if ($imgData !== false && write_file($imgPathAbs, $imgData)) {
                            $meta = (isset($meta_pages[$i]) ? $meta_pages[$i] : []);
                            $jsonFilename = $reff_note . '_p' . $pageNo . '_' . time() . '.json';
                            $jsonPathRel  = 'uploads/canvas/' . $jsonFilename;
                            $jsonPathAbs  = $base_dir . $jsonFilename;
                            $jsonData = json_encode([
                                'meta' => $meta,
                                'page_number' => $pageNo,
                                'image' => $imgPathRel,
                                'saved_at' => $created_date
                            ], JSON_UNESCAPED_UNICODE);

                            if (write_file($jsonPathAbs, $jsonData)) {
                                $row = [
                                    'reff_note'    => $reff_note,
                                    'name_notes'   => $name_notes,
                                    'page_number'  => $pageNo,
                                    'canvas_data'  => $jsonData,
                                    'file_json'    => $jsonPathRel,
                                    'file_image'   => $imgPathRel,
                                    'id_space_note'=> $id_space,
                                    'state'        => 'active',
                                    'created_by'   => $created_by,
                                    'created_date' => $created_date,
                                    'updated_date' => $created_date
                                ];
                                $this->db->insert('document_konva', $row);
                                $saved[] = ['page' => $pageNo, 'json' => $jsonPathRel, 'img' => $imgPathRel];
                            }
                        }
                    }
                }
            } else {
                $this->db->trans_rollback();
                return $this->output_json(['status' => 'error', 'message' => 'No page data received'], 400);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->output_json(['status' => 'error', 'message' => 'DB error saving data'], 500);
        } else {
            $this->db->trans_commit();
            return $this->output_json(['status' => 'success', 'reff_note' => $reff_note, 'saved' => $saved], 200);
        }
    }

    // helper untuk JSON output
    private function output_json($data, $status = 200) {
        $this->output->set_content_type('application/json')->set_status_header($status)->set_output(json_encode($data));
        return;
    }

    // ==================================================
    // 🔹 Mini Model
    // ==================================================
    private function getNotesBySpace($id_space)
    {
        return $this->db->get_where('notes', ['id_space_note' => $id_space])->result_array();
    }

    private function insertNotes($data)
    {
        return $this->db->insert('notes', $data);
    }

    private function getNoteById($id_note)
    {
        return $this->db->get_where('notes', ['id_note' => $id_note])->row_array();
    }

    private function deleteNote($id_note)
    {
        return $this->db->delete('notes', ['id_note' => $id_note]);
    }
}
