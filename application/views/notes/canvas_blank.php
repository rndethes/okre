
  <div id="leftbar">
  <div class="left-top">
    <div id="addPageBtn" class="left-icon" title="Tambah Halaman">
      <i class="fa-solid fa-plus"></i>
    </div>
    <div id="previewPanel" aria-live="polite" aria-label="Preview halaman"></div>

    <div id="deletePageBtn" class="left-icon" title="Hapus Halaman">
      <i class="fa-solid fa-trash"></i>
    </div>
  </div>

  <div class="sidebar-footer">
    <div id="settingsBtn" class="left-icon" title="Pengaturan">
      <i class="fa-solid fa-gear"></i>
    </div>
  </div>
</div>



  <div id="main-area">
    <div id="topbar">
      <div class="left"><h2>
  <img src="http://localhost/projectint/okre/assets/img/logo.png" alt="OKRE Logo" style="width:22px;height:22px;object-fit:contain;vertical-align:middle;margin-right:6px;">
  OKRE Sketch
</h2><div style="color:var(--muted);font-size:13px;margin-left:12px">Canvas Blank</div></div>
      <input type="hidden" id="editable" value="<?= $editable ?>">
      <input type="hidden" id="back_url" value="<?= base_url() ?>notes/index/<?= $this->session->userdata('workspace_sesi') ?>/space">
      <div class="actions" style="display:flex;gap:10px;align-items:center">
        <a href="<?= base_url() ?>notes/index/<?= $this->session->userdata('workspace_sesi') ?>/space" id="cancelBtn" class="top-btn">
          <i class="fa-solid fa-arrow-left"></i> <span class="btn-text">&nbsp;Batalkan</span>
        </a>
        <button id="downloadTopBtn" class="top-btn"><i class="fa-solid fa-download"></i><span class="btn-text">&nbsp;Download</span></button>
        <button id="saveTopBtn" class="top-btn"><i class="fa-solid fa-cloud-arrow-up"></i><span class="btn-text">&nbsp;Simpan</span></button>
      </div>
    </div>

    <div id="container" class="container"></div>
  </div>
</div>

  <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered custom-modal-top">
      <div class="modal-content custom-modal">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          Apakah kamu ingin menutup halaman dan menyimpan perubahan?
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" id="btnTutupHalaman">Tutup Tanpa Menyimpan</button>
          <button type="button" class="btn btn-primary" id="btnSimpanPerubahan">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>

<!-- SETTINGS POPUP -->
<div class="popup-sidebar" id="settingsPopup" style="position:fixed; left:96px; bottom:84px; display:none; z-index:1200;">
  <label>Mode tampilan</label>
  <div style="display:flex;gap:8px;margin-bottom:8px;">
    <button class="small-btn" id="themeLightBtn">Light</button>
    <button class="small-btn" id="themeDarkBtn">Dark</button>
  </div>
</div>

<!-- BOTTOM TOOLBAR -->
<div class="bottom-toolbar" id="bottomToolbar">
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
      <div style="height:2px"></div>
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



