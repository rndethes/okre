<?php
// ===================== TOPBAR_CONVA =====================
?>
<div id="main-area">
    <div id="topbar">
      <div class="left">
        <h2> OKRE Sketch</h2>
        <button id="sidebarToggle" class="top-btn" style="display:none;">
  <i class="fa-solid fa-eye"></i>
</button>
        <div style="color:var(--muted);font-size:13px;">Editor PDF</div>
      </div>
      <div class="actions">
        <button id="shareBtn" class="top-btn"><i class="fa-solid fa-share-nodes"></i>&nbsp;Bagikan</button>
         <button id="saveServerTopBtn" class="top-btn">
    <i class="fa-solid fa-cloud-arrow-up"></i>&nbsp;Server
  </button>
       <div class="dropdown">
  <button id="downloadTopBtn" class="top-btn">
    <i class="fa-solid fa-download"></i>&nbsp;Download <i class="fa-solid fa-caret-down"></i>
  </button>
  <div class="dropdown-content" id="downloadDropdown">
    <button class="small-btn" id="savePdfBtn"><i class="fa-solid fa-file-pdf"></i> PDF</button>
    <button class="small-btn" id="downloadJpgBtn"><i class="fa-solid fa-image"></i> JPG</button>
  </div>
</div>

      </div>
    </div>

    <div id="progressBar"><div id="progressFill"></div></div>
