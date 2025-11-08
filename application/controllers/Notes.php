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
        $data['notes'] = $this->getNotesAccessibleByUser($id_space);
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

 // ==================================================
    // Ambil Notes yang bisa diakses user
    // ==================================================
    private function getNotesAccessibleByUser($id_space)
{
    $id_user = $this->session->userdata('id');

    // ===== Subquery untuk note yang dibagikan ke user ini =====
    $subQuery = $this->db->select('id_notes')
        ->from('notes_share')
        ->where('id_users', $id_user)
        ->where('state_note_share', 'active')
        ->get_compiled_select();

    // Penting: reset builder biar query utama nggak kacau
    $this->db->reset_query();

    // ===== Query utama =====
    $this->db->select('*');
    $this->db->from('notes');
    $this->db->where('id_space_note', $id_space);
    $this->db->group_start();
    $this->db->where('created_by', $id_user);
    $this->db->or_where("id_note IN ($subQuery)", null, false);
    $this->db->group_end();

    $notes = $this->db->get()->result_array();

    // ===== Tambahkan daftar user yang dibagikan =====
    foreach ($notes as &$note) {
        $this->db->select('users.id, users.nama, notes_share.role');
        $this->db->from('notes_share');
        $this->db->join('users', 'users.id = notes_share.id_users');
        $this->db->where('notes_share.id_notes', $note['id_note']);
        $note['shared_users'] = $this->db->get()->result_array();
    }

    return $notes;
}

public function get_shared_users($id_note)
{
    $this->db->select('users.id, users.nama, notes_share.role');
    $this->db->from('notes_share');
    $this->db->join('users', 'users.id = notes_share.id_users');
    $this->db->where('notes_share.id_notes', $id_note);
    $this->db->where('notes_share.state_note_share', 'active');
    $users = $this->db->get()->result_array();

    echo json_encode(['success' => true, 'users' => $users]);
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
    $id_space   = $this->session->userdata('workspace_sesi');
    $created_by = $this->session->userdata('id');

    // Ambil nama folder space
    $namafolder = checkSpaceById($id_space);
    $created_date = getCurrentDate();

    // Nama dokumen (hapus spasi, biar aman di file system)
    $name_doc_input = trim($this->input->post('name_notes', TRUE));
    $safe_doc_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name_doc_input);

    // Buat folder lengkap
    $basePath = FCPATH . "assets/document/{$namafolder}/{$namafolder}_sketch/sketch_pdf/";
    if (!is_dir($basePath)) mkdir($basePath, 0777, true);

    $config['upload_path']   = $basePath;
    $config['allowed_types'] = 'pdf';
    $config['max_size']      = 51200; // 50 MB
    $config['file_name']     = $safe_doc_name . '.pdf'; // nama file sesuai input
    $config['overwrite']     = TRUE; // kalau nama sama, timpa

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('pdf_file')) {
        $error = strip_tags($this->upload->display_errors());
        $this->session->set_flashdata('flashPj', 'Gagal upload: ' . $error);
        redirect('notes/index/' . $id_space);
        return;
    }

    $dataUpload = $this->upload->data();

    // Simpan ke database
    $insertData = [
        'reff_note'     => uniqid('NOTE_'),
        'name_notes'    => $name_doc_input,
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

    $note = $this->db->get_where('notes', ['file_note' => $filename])->row_array();
    if (!$note) show_error('Data note tidak ditemukan.');

    $id_user = $this->session->userdata('id');
    $access = $this->getUserAccess($note['id_note'], $id_user);

    if (!$access['has_access']) {
        show_error('Anda tidak memiliki akses ke dokumen ini.', 403, 'Akses Ditolak');
    }

    $data['readonly'] = ($access['role'] === 'viewer');
    $data['role'] = $access['role'];
    $data['filename'] = $filename;
    $data['note_id']  = $note['id_note'];

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

    public function view_pdf($filename, $id_space = null)
{
    if ($id_space === null) {
        $id_space = $this->session->userdata('workspace_sesi');
    }

    $namafolder = checkSpaceById($id_space);

    if (!str_ends_with(strtolower($filename), '.pdf')) {
        $filename .= '.pdf';
    }

    $path = FCPATH . 'assets/document/' . $namafolder . '/' . $namafolder . '_sketch/sketch_pdf/' . $filename;

    if (!file_exists($path)) {
        show_error("Gagal memuat PDF. File tidak ditemukan di: " . $path, 404, 'File Tidak Ditemukan');
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
    // Save Canvas (Image/JSON)
    // ==================================================
    public function save_canvas()
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['image']) || empty($data['document_name'])) {
        echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
        return;
    }

    $id_space = $this->session->userdata('workspace_sesi');
    $namafolder = checkSpaceById($id_space);

    $safe_doc_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['document_name']);
    $folder = FCPATH . "assets/document/{$namafolder}/{$namafolder}_sketch/sketch_blank/";

    if (!file_exists($folder)) mkdir($folder, 0777, true);

    $imgData = base64_decode(str_replace('data:image/png;base64,', '', $data['image']));
    $filename = $safe_doc_name . '_blank.png';
    file_put_contents($folder . $filename, $imgData);

    echo json_encode([
        'status' => 'success',
        'file' => base_url("assets/document/{$namafolder}/{$namafolder}_sketch/sketch_blank/{$filename}")
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

    $id_space = $this->session->userdata('workspace_sesi');
    $namafolder = checkSpaceById($id_space);

    // Dapatkan nama dokumen dari input (pastikan dikirim di form)
    $name_doc_input = $this->input->post('document_name', TRUE);
    $safe_doc_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name_doc_input);

    // Folder penyimpanan hasil coretan
    $folder = FCPATH . "assets/document/{$namafolder}/{$namafolder}_sketch/sketch_pdf/";
    if (!file_exists($folder)) mkdir($folder, 0777, true);

    $target = $folder . $safe_doc_name . '.pdf';

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target)) {
        echo json_encode([
            'status' => 'success',
            'file' => base_url("assets/document/{$namafolder}/{$namafolder}_sketch/sketch_pdf/{$safe_doc_name}.pdf")
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file PDF hasil edit']);
    }
}


    // ==================================================
    // Hapus Dokumen
    // ==================================================
    public function delete($id)
{
    $note = $this->db->get_where('notes', ['id_note' => $id])->row_array();
    $id_user = $this->session->userdata('id');

    if ($note && $note['created_by'] == $id_user) {
        $namafolder = checkSpaceById($note['id_space_note']);

        // Path baru, masuk ke sketch_pdf
        $path = FCPATH . 'assets/document/' . $namafolder . '/' . $namafolder . '_sketch/sketch_pdf/' . $note['file_note'];

        if (file_exists($path)) {
            unlink($path);
        }

        $this->db->delete('notes', ['id_note' => $id]);
    } else {
        show_error('Anda tidak berhak menghapus dokumen ini.', 403, 'Akses Ditolak');
    }

    redirect('notes/index/' . $this->session->userdata('workspace_sesi'));
}


    // ==================================================
    // Simpan & Load Canvas JSON (Konva)
    // ==================================================
   public function save_canvas_json($id_note)
{
    $id_user = $this->session->userdata('id');
    $access = $this->getUserAccess($id_note, $id_user);

    // hanya owner/editor
    if (!$access['has_access'] || !in_array($access['role'], ['owner', 'editor'])) {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak memiliki izin untuk menyimpan coretan.']);
        return;
    }

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (empty($data['json'])) {
        echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
        return;
    }

    $json = $data['json'];
    $now = date('Y-m-d H:i:s');

    // cek apakah sudah ada data di notes_canvas
    $exists = $this->db->get_where('notes_canvas', ['id_note' => $id_note])->row_array();

    if ($exists) {
        $this->db->where('id_note', $id_note)
                 ->update('notes_canvas', [
                     'canvas_json' => $json,
                     'updated_at' => $now
                 ]);
    } else {
        $this->db->insert('notes_canvas', [
            'id_note' => $id_note,
            'canvas_json' => $json,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }

    echo json_encode(['status' => 'success']);
}

public function load_canvas_json($id_note)
{
    $noteCanvas = $this->db->get_where('notes_canvas', ['id_note' => $id_note])->row_array();

    if (!$noteCanvas || empty($noteCanvas['canvas_json'])) {
        echo json_encode(['status' => 'empty', 'data' => null]);
        return;
    }

    echo json_encode(['status' => 'success', 'data' => json_decode($noteCanvas['canvas_json'], true)]);
}


public function get_note_owner($id_note)
{
    $note = $this->db->select('users.id, users.nama')
        ->from('notes')
        ->join('users', 'users.id = notes.created_by')
        ->where('notes.id_note', $id_note)
        ->get()
        ->row_array();

    if ($note) {
        echo json_encode(['success' => true, 'owner' => $note]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Owner tidak ditemukan']);
    }
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

    $note = $this->db->get_where('notes', [
        'id_note' => $id_note,
        'id_space_note' => $workspace_id
    ])->row_array();

    if (!$note) {
        echo json_encode(['success' => false, 'message' => 'Dokumen tidak ditemukan atau bukan milik workspace ini.']);
        return;
    }

    foreach ($users as $user) {
        if (empty($user['id'])) continue;

        $user_id = $user['id'];
        $role = $user['role'] ?? 'viewer';

        $exists = $this->db->get_where('notes_share', [
            'id_notes' => $id_note,
            'id_users' => $user_id
        ])->num_rows();

        if ($exists == 0) {
            $insertData = [
                'id_notes' => $id_note,
                'id_users' => $user_id,
                'role' => $role,
                'state_note_share' => 'active',
                'created_by' => $id_user_aktif,
                'created_date' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('notes_share', $insertData);
            $dbError = $this->db->error(); // ✅ cek error database

            if ($dbError['code'] != 0) {
                echo json_encode([
                    'success' => false,
                    'message' => 'DB Error: ' . $dbError['message']
                ]);
                return;
            }
        }
    }

    echo json_encode(['success' => true]);
}



    // ==================================================
    // Ambil Anggota Space untuk Dropdown Bagikan
    // ==================================================
    public function get_space_members($id_note = null)
{
    $id_space = $this->session->userdata('workspace_sesi');

    // Jika ada id_note, ambil id pemilik dokumen
    $id_owner = null;
    if ($id_note) {
        $note = $this->db->select('created_by')->get_where('notes', ['id_note' => $id_note])->row_array();
        if ($note) $id_owner = $note['created_by'];
    }

    $this->db->select('users.id, users.nama, users.username');
    $this->db->from('space_team');
    $this->db->join('users', 'users.id = space_team.id_user');
    $this->db->where('space_team.id_workspace', $id_space);

    // Kecualikan pemilik dokumen
    if ($id_owner) {
        $this->db->where('users.id !=', $id_owner);
    }

    $result = $this->db->get()->result_array();
    echo json_encode($result);
}

// ==================================================
// Cek akses user terhadap note
// ==================================================
private function getUserAccess($id_note, $id_user)
{
    $note = $this->db->get_where('notes', ['id_note' => $id_note])->row_array();
    if (!$note) return ['has_access' => false, 'role' => null];

    // Owner selalu punya akses penuh
    if ($note['created_by'] == $id_user) {
        return ['has_access' => true, 'role' => 'owner'];
    }

    // Cek apakah user dibagikan
    $share = $this->db->get_where('notes_share', [
        'id_notes' => $id_note,
        'id_users' => $id_user,
        'state_note_share' => 'active'
    ])->row_array();

    if ($share) {
        return ['has_access' => true, 'role' => $share['role']];
    }

    return ['has_access' => false, 'role' => null];
}
}