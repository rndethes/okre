<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

class Archieve_model extends CI_Model {

    const GDRIVE_FOLDER_ID = '1l_ltWW9co6kBPcNbC6tF9YGNBK8n_7KF';
    private $drive_service; // Properti untuk menyimpan service object

    public function __construct() {
        parent::__construct();
        $this->initialize_drive_service(); // Inisialisasi service saat model dimuat
    }


    private function initialize_drive_service() {
        try {
            $client = new Google_Client();
            $client->setApplicationName('ITAKA Arsip Uploader');
            $client->setScopes(Google_Service_Drive::DRIVE);
            $client->setAuthConfig(APPPATH . 'credentials.json');
            // TAMBAHAN PENTING 1: Beritahu client untuk mendukung Shared Drive
          //  $client->setSupportsAllDrives(true);
            $this->drive_service = new Google_Service_Drive($client);
            
        } catch (Exception $e) {
            log_message('error', 'Google Drive Client Initialization Error: ' . $e->getMessage());
            $this->drive_service = null;
        }
    }

    private function _find_or_create_folder($parent_id, $folder_name) {
        if (!$this->drive_service) return false;

        // 1. Cari folder yang sudah ada
        $query = "mimeType='application/vnd.google-apps.folder' and trashed=false and name='" . $folder_name . "' and '" . $parent_id . "' in parents";
        $optParams = [
            'q' => $query, 
            'fields' => 'files(id)',
            // TAMBAHAN PENTING 2: Parameter untuk pencarian di Shared Drive
            'supportsAllDrives' => true,
            'includeItemsFromAllDrives' => true
        ];
        $results = $this->drive_service->files->listFiles($optParams);

        if (count($results->getFiles()) > 0) {
            // Jika folder ditemukan, kembalikan ID-nya
            return $results->getFiles()[0]->getId();
        } else {
            // 2. Jika tidak ada, buat folder baru
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $folder_name,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => [$parent_id]
            ]);
           // TAMBAHAN PENTING 3: Parameter untuk membuat folder di Shared Drive
           $folder = $this->drive_service->files->create($fileMetadata, ['fields' => 'id', 'supportsAllDrives' => true]);
           return $folder->getId();
        }
    }

    public function upload_to_gdrive($local_file_path, $file_name_on_drive, $namafolder) {
        if (!$this->drive_service) return false;

        try {
            // Buat atau dapatkan ID folder tahun-bulan (misal: '2025-10')
            $folder_name_id = $this->_find_or_create_folder(self::GDRIVE_FOLDER_ID, $namafolder);
            if (!$folder_name_id) return false; // Gagal membuat folder


            $folderLink = 'https://drive.google.com/drive/folders/' . $folder_name_id;

            // Upload file ke folder tanggal
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $file_name_on_drive,
                'parents' => [$folder_name_id]
            ]);

            $content = file_get_contents($local_file_path);
            $file = $this->drive_service->files->create($fileMetadata, [
                'data' => $content, 'mimeType' => 'application/pdf', 'uploadType' => 'multipart', 'fields' => 'id', 'supportsAllDrives' => true
            ]);

            $fileId = $file->getId();
            
            return [
                'file_id' => $fileId,
                'folder_link' => $folderLink
            ];

        } catch (Exception $e) {
            log_message('error', 'Google Drive Upload Error: ' . $e->getMessage());
            return false;
        }
    }
    
    // ... (Fungsi save_other_id dan get_local_images_by_date Anda tetap sama)
    public function save_other_id($file_id, $gdrive_id,$files) {
        $data_to_update = [
            'backup_file'=> $files,
            'other_id' => $gdrive_id['file_id'], // Ambil file_id dari array
            'folder_link' => $gdrive_id['folder_link'], // Ambil folder_link dari array
            'backup_status' => 1, // Ambil folder_link dari array
            'backup_date' => date("Y-m-d H:i:s") // Ambil folder_link dari array
        ];

        $this->db->where('id_document', $file_id);
        $this->db->update('document', $data_to_update);
    
        return $this->db->affected_rows() > 0;
    }

    public function get_documents_by_ids($id_document) {

        $this->db->select('document.*,users.nama,space.*');
        $this->db->from('document');
        $this->db->join('space', 'document.id_space  = space.id_space');
        $this->db->join('users', 'document.id_user_create = users.id');
        $this->db->where_in('document.id_document', $id_document);
        $this->db->order_by('document.created_date', 'DESC');
    
          return $this->db->get()->row_array();
        }
    
    

    

}