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
    // Halaman utama Notes
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
        $data['space_members'] = $this->getSpaceMembers($id_space);
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

    // ======== Ambil Notes + User yang Dibagikan ========
private function getNotesWithShares($id_space)
{
    $notes = $this->db->get_where('notes', ['id_space_note' => $id_space])->result_array();

    foreach ($notes as &$note) {
        $this->db->select('users.id, users.nama');
        $this->db->from('notes_share');
        $this->db->join('users', 'users.id = notes_share.id_users');
        $this->db->where('notes_share.id_notes', $note['id_note']);
        $note['shared_users'] = $this->db->get()->result_array();
    }

    return $notes;
}

// ======== Ambil Anggota Space ========
private function getSpaceMembers($id_space)
{
    $this->db->select('users.id, users.nama');
    $this->db->from('space_team');
    $this->db->join('users', 'users.id = space_team.id_user');
    $this->db->where('space_team.id_workspace', $id_space);
    return $this->db->get()->result_array();
}


    // ==================================================
    // Upload PDF + Simpan DB + Buka Konva
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

        $this->db->insert('notes', $insertData);
        redirect('notes/konva/' . $dataUpload['file_name'] . "/" . $id_space);
    }

    // ==================================================
    // Editor Konva (PDF + Coretan)
    // ==================================================
    public function konva($filename = null)
    {
        if (!$filename) redirect('notes/index/' . $this->session->userdata('workspace_sesi'));

        $file_path = FCPATH . 'uploads/documents/' . $filename;
        if (!file_exists($file_path)) show_error('File tidak ditemukan: ' . $filename);

        // Ambil data note dan owner
        $note = $this->db->get_where('notes', ['file_note' => $filename])->row_array();
        if (!$note) show_error('Data note tidak ditemukan.');

        $data['filename']   = $filename;
        $data['note_id']    = $note['id_note'];
        $data['owner_id']   = $note['created_by'];

        $owner = $this->db->get_where('users', ['id' => $note['created_by']])->row_array();
        $data['owner_name'] = $owner ? $owner['nama'] : 'Tidak diketahui';

        $this->load->view('notes/document_konva', $data);
    }

    // ==================================================
    // Canvas kosong
    // ==================================================
    public function canvas_blank()
    {   
        $this->load->view('template/conva_editor/header_blank');
        $this->load->view('notes/canvas_blank');
        $this->load->view('template/conva_editor/footer_blank');
    }

    // ==================================================
    // PDF Viewer Proxy (PDF.js Support)
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
        readfile($path);
        exit;
    }

    // ==================================================
    // Save Canvas (Image/JSON)
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
    // Save PDF hasil edit (langsung PDF)
    // ==================================================
    public function save_pdf_server()
    {
        header('Content-Type: application/json');
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
    // Hapus Dokumen
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
    // Simpan & Load Canvas JSON (Konva)
    // ==================================================
    public function save_canvas_json($id_note)
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (empty($data['json'])) {
        echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
        return;
    }

    $update = [
        'canvas_data'  => $data['json'],
        'updated_date' => date('Y-m-d H:i:s')
    ];

    $this->db->where('id_note', $id_note);
    $this->db->update('notes', $update);

    echo json_encode(['status' => 'success']);
}

public function load_canvas_json($id_note)
{
    $note = $this->db->get_where('notes', ['id_note' => $id_note])->row_array();

    if (!$note || empty($note['canvas_data'])) {
        echo json_encode(['status' => 'empty', 'data' => null]);
        return;
    }

    echo json_encode(['status' => 'success', 'data' => json_decode($note['canvas_data'], true)]);
}


    // ==================================================
    // Bagikan Notes ke Anggota Space
    // ==================================================


    public function share_to_users()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $id_note = $data['id_note'] ?? null;
    $users = $data['users'] ?? [];

    if (!$id_note || empty($users)) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        return;
    }

    $id_user_aktif = $this->session->userdata('id');
    $workspace_id = $this->session->userdata('workspace_sesi');

    // Validasi apakah note memang milik workspace aktif
    $note = $this->db->get_where('notes', [
        'id_note' => $id_note,
        'id_space_note' => $workspace_id
    ])->row_array();

    if (!$note) {
        echo json_encode(['success' => false, 'message' => 'Dokumen tidak ditemukan atau bukan milik workspace ini.']);
        return;
    }

    // Simpan data ke tabel notes_share
    foreach ($users as $user) {
        $user_id = $user['id'];

        $exists = $this->db->get_where('notes_share', [
            'id_notes' => $id_note,
            'id_users' => $user_id
        ])->num_rows();

        if ($exists == 0) {
            $this->db->insert('notes_share', [
                'id_notes' => $id_note,
                'id_users' => $user_id,
                'state_note_share' => 'active',
                'created_by' => $id_user_aktif,
                'created_date' => date('Y-m-d H:i:s')
            ]);
        }
    }

    echo json_encode(['success' => true]);
}


    // ==================================================
    // Ambil Anggota Space untuk Dropdown Bagikan
    // ==================================================
    public function get_space_members()
    {
        $id_space = $this->session->userdata('workspace_sesi');
        $this->db->select('users.id, users.nama, users.username');
        $this->db->from('space_team');
        $this->db->join('users', 'users.id = space_team.id_user');
        $this->db->where('space_team.id_workspace', $id_space);

        $result = $this->db->get()->result_array();
        echo json_encode($result);
    }

    // ==================================================
    // Helper mini model
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
