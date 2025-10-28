<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->database();
    }

    // --- Halaman utama: daftar notes + tombol upload
    public function index() {
        $data['notes'] = $this->db->order_by('id_note', 'DESC')->get('notes')->result_array();
        $this->load->view('notes/index', $data);
    }

    // --- Halaman upload PDF manual (kalau pakai file upload_pdf.php)
    public function upload() {
        $this->load->view('notes/upload_pdf');
    }

    // --- Proses upload PDF + simpan ke database
    public function upload_action() {
        $config['upload_path']   = './uploads/documents/';
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = 51200; // 50MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        $name_notes   = $this->input->post('name_notes');
        $created_by   = 1; // nanti bisa diganti user login
        $created_date = date('Y-m-d H:i:s');

        if (!$this->upload->do_upload('pdf_file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('notes/upload_pdf', $error);
        } else {
            $data = $this->upload->data();
            $file_name = $data['file_name'];

            // Simpan ke tabel notes
            $insertData = [
                'reff_note'     => uniqid('NOTE_'),
                'name_notes'    => $name_notes,
                'file_note'     => $file_name,
                'id_space_note' => 0,
                'state'         => 'active',
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'updated_date'  => $created_date
            ];
            $this->db->insert('notes', $insertData);
            
            // Ambil nama file yang baru diupload
            $file_name = $data['file_name'];
            
            // Arahkan ke editor PDF Konva
            redirect('notes/konva/' . $file_name);
        }
    }

    // --- Editor Konva (PDF dengan anotasi)
    public function konva($filename = null) {
        if ($filename == null) redirect('notes/upload');
        $data['filename'] = $filename;
        $this->load->view('notes/document_konva', $data);
    }

    // --- Halaman canvas kosong (tanpa PDF)
    public function canvas_blank() {
        $this->load->view('notes/canvas_blank');
    }

    // --- PDF Viewer Proxy (untuk PDF.js)
    public function view_pdf($filename) {
        $path = FCPATH . 'uploads/documents/' . $filename;

        if (!file_exists($path)) {
            show_404();
            return;
        }

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

    // --- Simpan hasil coretan canvas (PNG)
    public function save_canvas() {
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

    // --- Simpan hasil anotasi PDF (langsung versi PDF)
    public function save_pdf_server() {
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

    // --- Hapus dokumen dari database dan file
    public function delete($id) {
        $note = $this->db->get_where('notes', ['id_note' => $id])->row_array();

        if ($note) {
            $file_path = FCPATH . 'uploads/documents/' . $note['file_note'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $this->db->delete('notes', ['id_note' => $id]);
        }

        redirect('notes');
    }
}
