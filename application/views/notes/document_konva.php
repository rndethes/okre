<?php
// ===================== DOCUMENT_KONVA WRAPPER =====================
?>

<!-- Variabel global agar bisa dibaca oleh script_conva.js -->
<script>
  window.baseUrl = '<?= base_url() ?>';
  window.pdfFilename = '<?= $filename ?>';
  window.noteId = <?= json_encode($note_id ?? null) ?>; 
 // window.pdfUrl = window.baseUrl + 'notes/view_pdf/' + window.pdfFilename + '/<?= $this->session->userdata('workspace_sesi') ?>';
  console.log("PDF URL dari PHP:", window.pdfUrl);
  console.log("Note ID dari PHP:", window.noteId); 
</script>


<?php
// Load lima bagian template editor
$this->load->view('template/conva_editor/header_conva');
$this->load->view('template/conva_editor/sidebar_conva');
$this->load->view('template/conva_editor/topbar_conva');
$this->load->view('template/conva_editor/document_conva');
$this->load->view('template/conva_editor/footer_conva');
?>
