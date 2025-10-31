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

        $data['users_name'] = $this->db
            ->get_where('users', ['username' => $this->session->userdata('username')])
            ->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('notes/index', $data);
        $this->load->view('template/footer');
    }

    // ==================================================
    // 2️⃣ Upload PDF + Simpan DB + Buka Konva
    // ==================================================
    public function upload_action()
    {
        $id_space     = $this->session->userdata('workspace_sesi');
        $created_by   = $this->session->userdata('id');
        $created_date = date('Y-m-d H:i:s');

        $config['upload_path']   = FCPATH . 'uploads/documents/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 51200;
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, true);

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('pdf_file')) {
            $error = strip_tags($this->upload->display_errors());
            $this->session->set_flashdata('flashPj', 'Gagal upload: ' . $error);
            redirect('notes/index/' . $id_space);
            return;
        }

        $dataUpload = $this->upload->data();

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

        redirect('notes/konva/' . $dataUpload['file_name']);
    }

    // ==================================================
    // 3️⃣ Editor Konva (PDF + Coretan)
    // ==================================================
    public function konva($filename = null)
    {
        if (!$filename) redirect('notes/index/' . $this->session->userdata('workspace_sesi'));

        $file_path = FCPATH . 'uploads/documents/' . $filename;
        if (!file_exists($file_path)) show_error('File tidak ditemukan: ' . $filename);

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
    // 5️⃣ PDF Viewer Proxy (PDF.js Support)
    // ==================================================
    public function view_pdf($filename)
    {
        $path = FCPATH . 'uploads/documents/' . $filename;
        if (!file_exists($path)) show_404();

        while (ob_get_level()) ob_end_clean();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Range');
        header('Accept-Ranges: bytes');
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($path));

        $fp = fopen($path, 'rb');
        fpassthru($fp);
        fclose($fp);
        exit;
    }

    // ==================================================
    // 6️⃣ Save Canvas (Image/JSON)
    // ==================================================
    public function save_canvas()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['image'])) {
            echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
            return;
        }

        $folder = FCPATH . 'uploads/annotated/';
        if (!file_exists($folder)) mkdir($folder, 0777, true);

        $imgData = base64_decode(str_replace('data:image/png;base64,', '', $data['image']));
        $filename = 'annotated_' . time() . '.png';
        file_put_contents($folder . $filename, $imgData);

        echo json_encode([
            'status' => 'success',
            'file' => base_url('uploads/annotated/' . $filename)
        ]);
    }

    // ==================================================
    // 7️⃣ Save PDF hasil edit (langsung PDF)
    // ==================================================
    public function save_pdf_server()
    {
        if (empty($_FILES['pdf_file']['tmp_name'])) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada file PDF diterima']);
            return;
        }

        $folder = FCPATH . 'uploads/annotated/';
        if (!file_exists($folder)) mkdir($folder, 0777, true);

        $newName = 'annotated_' . time() . '.pdf';
        $target = $folder . $newName;

        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target)) {
            echo json_encode([
                'status' => 'success',
                'file' => base_url('uploads/annotated/' . $newName)
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file PDF']);
        }
    }

    // ==================================================
    // 8️⃣ Hapus Dokumen
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
    // 🔹 Mini Model Helpers
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
