<?php
// ===================== FOOTER_CONVA =====================
?>

<!-- SETTINGS POPUP -->
<div class="popup-sidebar" id="settingsPopup" style="display:none;">
  <label>Mode tampilan</label>
  <div style="display:flex;gap:8px;margin-bottom:8px;">
    <button class="small-btn" id="themeLightBtn">Light</button>
    <button class="small-btn" id="themeDarkBtn">Dark</button>
    <!-- <button class="small-btn" id="themeCustomBtn">Custom</button> -->
  </div>
  <!-- <div id="customColorRow" style="display:none;">
    <label>Pilih warna aksen</label>
    <input type="color" id="customAccent" value="#1976d2">
    <div style="height:8px"></div>
    <small style="color:var(--muted);">Catatan: dokumen tetap berwarna putih. Ini mengubah warna UI.</small>
  </div> -->
</div>

<!-- ===================== BOTTOM TOOLBAR ===================== -->
<div class="bottom-toolbar" id="bottomToolbar">

 <!-- DRAW TOOL -->
  <div class="tool-btn" id="quickBrush" title="Brush">
      <i class="fa-solid fa-pen-nib"></i>
    </div>
    <div class="tool-btn" id="touchToggleBtn" title="Mode Coretan Jari">
      <i class="fa-solid fa-hand-point-up"></i>
    </div>
    <div class="tool-btn" id="panToggleBtn" title="Scroll Mode">
      <i class="fa-solid fa-hand"></i>
    </div>
    <div class="tool-btn" id="quickEraser" title="Eraser">
      <i class="fa-solid fa-eraser"></i>
    </div>
   <div class="tool-btn" id="btnDraw" title="Draw / Tools">
    <i class="fa-solid fa-palette"></i>
    <div class="popup" id="popupDraw" style="display:none;">
      <div class="popup-row">
        <label><i class="fa-solid fa-droplet"></i></label>
        <input type="color" id="colorPicker" value="#000000ff">
      </div>

      <div class="popup-row">
        <label><i class="fa-solid fa-ruler-horizontal"></i></label>
        <input type="range" id="sizePicker" min="1" max="60" value="4">
      </div>
    </div>
  </div>

  <!-- ZOOM -->
   
  <div class="tool-btn" id="btnZoom" title="Zoom">
    <i class="fa-solid fa-magnifying-glass-plus"></i>
    <div class="popup" id="popupZoom" style="display:none;">
      <div style="display:flex;gap:8px;align-items:center;">
        <button class="small-btn" id="zoomOutBtn"><i class="fa-solid fa-minus"></i></button>
        <div id="zoomPercent" style="min-width:56px;text-align:center;font-weight:600">100%</div>
        <button class="small-btn" id="zoomInBtn"><i class="fa-solid fa-plus"></i></button>
      </div>
      <div style="height:6px"></div>
      <button class="small-btn" id="fitBtn" title="Fit Width"><i class="fa-solid fa-expand"></i></button>
    </div>
  </div>

  <!-- UNDO -->
  <div class="tool-btn" id="btnUndo" title="Undo">
    <i class="fa-solid fa-rotate-left"></i>
  </div>

  <!-- REDO -->
  <div class="tool-btn" id="btnRedo" title="Redo">
    <i class="fa-solid fa-rotate-right"></i>
  </div>

  <!-- CLEAR ALL -->
  <div class="tool-btn" id="btnClear" title="Hapus semua coretan">
    <i class="fa-solid fa-trash-can"></i>
  </div>

  <!-- Hidden color picker -->
  <input type="hidden" id="colorPicker2" value="#000000ff">
</div>


<script>
  var BaseURL = '<?= base_url(); ?>' 
</script>


<!-- ===================== LIBRARIES ===================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- PDF.js dan PDF-Lib -->
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/konva@9.2.0/konva.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="<?= base_url('assets/okre_conva/script_conva.js') ?>"></script>





<!-- ===================== SCRIPT UTAMA ===================== -->
<script>

document.addEventListener("DOMContentLoaded", () => {
  const btnDraw = document.getElementById('btnDraw');
  const popupDraw = document.getElementById('popupDraw');
  const btnZoom = document.getElementById('btnZoom');
  const popupZoom = document.getElementById('popupZoom');

  const settingsBtn = document.getElementById('settingsBtn');
  const settingsPopup = document.getElementById('settingsPopup');

  function togglePopup(popup) {
    const isVisible = popup.style.display === 'flex'; 
    
    document.querySelectorAll('.popup, .popup-sidebar').forEach(p => p.style.display = 'none');

    popup.style.display = isVisible ? 'none' : 'flex';
  }

  btnDraw.addEventListener('click', e => { e.stopPropagation(); togglePopup(popupDraw); });
  btnZoom.addEventListener('click', e => { e.stopPropagation(); togglePopup(popupZoom); });
  settingsBtn.addEventListener('click', e => { e.stopPropagation(); togglePopup(settingsPopup); });
  document.addEventListener('click', (e) => {
    // Tambahkan cek untuk .popup-sidebar
    if (!e.target.closest('.popup') && !e.target.closest('.popup-sidebar')) {
      document.querySelectorAll('.popup, .popup-sidebar').forEach(p => p.style.display = 'none');
    }
  });
});
</script>

</body>
</html>
