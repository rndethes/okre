<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>OKRE Sketch — Editor (Floating Toolbar)</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  :root{
    --blue-500:#1976d2;
    --blue-600:#1565c0;
    --bg:#f6fbff;
    --card:#ffffff;
    --muted:#6b7280;
    --glass: rgba(255,255,255,0.8);
    --shadow: 0 6px 18px rgba(15,23,42,0.12);
    --accent: #0ea5e9;
    --sidebar-bg: linear-gradient(180deg,var(--card),#f0f7ff);
  }
  /* Dark theme variables (will be toggled by JS) */
  .theme-dark {
    --bg: #0b1220;
    --card: #0f1724;
    --muted: #98a4b3;
    --blue-500: #3b82f6;
    --blue-600: #2563eb;
    --sidebar-bg: linear-gradient(180deg,var(--card),#071022);
  }
  html,body{height:100%;margin:0;font-family: "Segoe UI", Roboto, Arial, sans-serif;background:var(--bg);color:#0b2540;}
  .app {
    display:flex;
    height:100vh;
    overflow:visible;
  }

  /* LEFT SIDEBAR (compact icons vertical) */
  #leftbar {
    width:88px;
    background: var(--sidebar-bg);
    border-right:1px solid rgba(25,118,210,0.06);
    display:flex;
    flex-direction:column;
    align-items:center;
    padding:12px 8px;
    gap:12px;
    box-shadow: var(--shadow);
    transition:background .18s, color .18s;
  }
  .left-top {
    display:flex;flex-direction:column;gap:12px;align-items:center;width:100%;
  }
  .left-icon{
    width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;
    background:transparent;border:1px solid transparent;color:var(--blue-600);cursor:pointer;transition:all .18s;font-size:20px;
  }
  .left-icon:hover{transform:translateY(-3px);box-shadow:0 6px 14px rgba(25,118,210,0.06);background:linear-gradient(180deg,#fff, #f0f7ff);}
  .left-icon.active{background:linear-gradient(180deg,var(--blue-500),var(--blue-600)); color:white; box-shadow:0 10px 20px rgba(25,118,210,0.14);}

  /* PREVIEW PANEL inside sidebar */
  #previewPanel {
    width:100%;
    flex:1;
    overflow-y:auto;
    display:flex;
    flex-direction:column;
    gap:10px;
    padding:8px;
    box-sizing:border-box;
  }
  .thumb {
    width:64px;
    border-radius:8px;
    overflow:hidden;
    background:var(--card);
    border:2px solid transparent;
    box-shadow:0 6px 16px rgba(2,6,23,0.06);
    cursor:pointer;
    align-self:center;
    transition: all .14s;
    display:flex;
    justify-content:center;
    align-items:center;
  }
  .thumb canvas { display:block; width:100%; height:auto; }
  .thumb.active {
    border-color: rgba(25,118,210,0.9);
    box-shadow: 0 8px 22px rgba(25,118,210,0.12);
    transform: translateY(-3px);
  }
  .thumb .page-num {
    position:absolute; font-size:11px; padding:4px 6px; border-radius:12px; background:rgba(255,255,255,0.85); left:6px; top:6px; color:#0b2540;
  }
  /* at small width hide text of settings popup */
  .sidebar-footer { display:flex; align-items:center; gap:10px; padding-bottom:6px; }

  /* MAIN AREA */
  #main-area { flex:1; display:flex; flex-direction:column; position:relative; overflow:visible; }
  #topbar {
    height:56px; display:flex; align-items:center; justify-content:space-between; padding:0 18px;
    border-bottom:1px solid rgba(25,118,210,0.06); background:linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.8));
    backdrop-filter: blur(6px);
  }
  #topbar .left{display:flex;align-items:center;gap:12px;}
  #topbar h2{margin:0;font-size:16px;color:var(--blue-600);letter-spacing:1px;}
  #topbar .actions{display:flex;gap:10px;align-items:center;}
  .top-btn{background:var(--card);border:1px solid rgba(15,23,42,0.05);padding:8px 12px;border-radius:8px;cursor:pointer;display:flex;gap:8px;align-items:center;}
  .top-btn:hover{transform:translateY(-2px);box-shadow:0 6px 12px rgba(14,165,233,0.08);}

  /* container for pages */
  #container {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 40px;
    padding: 40px 20px;
    scroll-behavior: smooth;
  }

  .page { background: #fff; box-shadow: 0 6px 22px rgba(14,165,233,0.06); border-radius:6px; position:relative; margin:0 auto; overflow:hidden; }
  .page canvas { display:block; }

  /* PROGRESS BAR */
  #progressBar { position:absolute; left:0; top:56px; height:6px; width:100%; background:transparent; pointer-events:none; }
  #progressFill { height:100%; width:0; background:linear-gradient(90deg,var(--blue-500),var(--accent)); transition:width .12s; box-shadow:0 2px 8px rgba(14,165,233,0.18); }

  /* FLOATING BOTTOM TOOLBAR */
  .bottom-toolbar {
    position:fixed;
    left:50%;
    transform:translateX(-50%);
    bottom:18px;
    height:64px;
    background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(245,253,ff,0.95));
    border-radius:999px;
    padding:6px 14px;
    display:flex;
    gap:10px;
    align-items:center;
    z-index:999;
    box-shadow: 0 10px 30px rgba(10,25,60,0.12);
    border:1px solid rgba(25,118,210,0.08);
  }

  .tool-btn {
    width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    background:linear-gradient(180deg,#fff,#f7fbff);border:1px solid rgba(15,23,42,0.04);
    cursor:pointer; position:relative; transition: transform .14s;
  }
  .tool-btn:hover{transform:translateY(-4px)}
  .tool-btn.active{background:linear-gradient(180deg,var(--blue-500),var(--blue-600));color:white;border:0;box-shadow:0 10px 20px rgba(25,118,210,0.18);}

  .tool-btn i { font-size:18px; color:var(--blue-600); }
  .tool-btn.active i { color:white; }

  /* Popup above button */
  .popup {
    position:absolute;
    bottom:72px;
    left:50%;
    transform:translateX(-50%) translateY(8px);
    min-width:220px;
    background:var(--card);
    border-radius:12px;
    padding:10px;
    box-shadow:0 12px 30px rgba(2,6,23,0.12);
    border:1px solid rgba(15,23,42,0.06);
    display:none;
    z-index:1100;
    transition:all .12s ease;
  }
  .popup.show{ display:block; transform:translateX(-50%) translateY(0); }

  .popup .row{ display:flex; gap:8px; align-items:center; margin-bottom:8px; }
  .popup label{ font-size:13px; color:#0b2540; margin-bottom:6px; display:block; }
  .popup input[type="color"], .popup input[type="range"], .popup select{ width:100%; padding:8px;border-radius:8px;border:1px solid rgba(10,20,40,0.06); }

  .small-btn{ padding:6px 10px;border-radius:8px;background:#f6fbff;border:1px solid rgba(10,20,40,0.04);cursor:pointer; }
  .small-btn:hover{background:#eaf6ff;}

  .popup .palette{ display:flex; gap:6px; }
  .color-swatch{ width:28px;height:28px;border-radius:6px;border:1px solid rgba(0,0,0,0.06); cursor:pointer; }

  .tool-label{ position:absolute; bottom:120px; left:50%; transform:translateX(-50%); font-size:12px; background:rgba(2,6,23,0.9); color:white; padding:6px 8px;border-radius:6px; display:none; white-space:nowrap; }
  .tool-btn:hover .tool-label{ display:block; }

  @media (max-width:880px){
    #leftbar{ display:none; }
    .bottom-toolbar { left:16px; transform:none; right:16px; justify-content:space-between; }
    .popup{ left:auto; right:0; transform:translateY(8px); bottom:78px; }
  }
</style>
</head>
<body>

<div class="app" id="appRoot">
  <!-- LEFT MINI BAR -->
  <div id="leftbar">
    <div class="left-top">
      <div id="pagesToggle" class="left-icon" title="Pages (toggle preview)"><i class="fa-solid fa-layer-group"></i></div>

      <!-- PREVIEW PANEL: will be filled with thumbnails dynamically -->
      <div id="previewPanel" aria-live="polite" aria-label="Preview halaman">
        <!-- thumbnails inserted here -->
      </div>

      <!-- keep spacing -->
    </div>

    <!-- Footer: settings icon -->
    <div class="sidebar-footer">
      <div id="settingsBtn" class="left-icon" title="Settings"><i class="fa-solid fa-gear"></i></div>
    </div>
  </div>

  <!-- MAIN AREA -->
  <div id="main-area">
    <div id="topbar">
      <div class="left">
        <h2>OKRE Sketch</h2>
        <div style="color:var(--muted);font-size:13px;">Editor PDF — Floating toolbar</div>
      </div>
      <div class="actions">
        <button id="shareBtn" class="top-btn"><i class="fa-solid fa-share-nodes"></i>&nbsp;Bagikan</button>
        <button id="downloadTopBtn" class="top-btn"><i class="fa-solid fa-download"></i>&nbsp;Download</button>
      </div>
    </div>

    <div id="progressBar"><div id="progressFill"></div></div>

    <!-- CONTAINER FOR PAGES -->
    <div id="container"></div>
  </div>
</div>

<!-- SETTINGS POPUP (triggered by settingsBtn) -->
<div class="popup" id="settingsPopup" style="position:fixed; left:96px; bottom:84px; display:none; z-index:1200;">
  <label>Mode tampilan</label>
  <div style="display:flex;gap:8px;margin-bottom:8px;">
    <button class="small-btn" id="themeLightBtn">Light</button>
    <button class="small-btn" id="themeDarkBtn">Dark</button>
    <button class="small-btn" id="themeCustomBtn">Custom</button>
  </div>
  <div id="customColorRow" style="display:none;">
    <label>Pilih warna aksen</label>
    <input type="color" id="customAccent" value="#1976d2">
    <div style="height:8px"></div>
    <small style="color:var(--muted);">Catatan: dokumen tetap berwarna putih. Ini mengubah warna UI.</small>
  </div>
</div>

<!-- FLOATING BOTTOM TOOLBAR (unchanged) -->
<div class="bottom-toolbar" id="bottomToolbar">
  <!-- Draw / Pen -->
  <div class="tool-btn" id="btnDraw" data-tool="brush" title="Draw / Pen">
    <i class="fa-solid fa-pen"></i>
    <div class="tool-label">Draw</div>
    <div class="popup" id="popupDraw">
      <label>Mode</label>
      <select id="drawMode">
        <option value="brush">Brush</option>
        <option value="eraser">Eraser</option>
      </select>
      <div style="height:6px"></div>
      <div style="display:flex;gap:8px;">
        <button class="small-btn" id="quickBrush">Brush</button>
        <button class="small-btn" id="quickEraser">Eraser</button>
      </div>
    </div>
  </div>

  <!-- Shapes -->
  <div class="tool-btn" id="btnShapes" title="Shapes">
    <i class="fa-solid fa-square-plus"></i>
    <div class="tool-label">Shapes</div>
    <div class="popup" id="popupShapes">
      <label>Insert Shape</label>
      <div style="display:flex;gap:8px;">
        <button class="small-btn" id="insertRect">Rectangle</button>
        <button class="small-btn" id="insertCircle">Circle</button>
        <button class="small-btn" id="insertLine">Line</button>
      </div>
      <div style="height:8px"></div>
      <label>Shapes mode (placeholder)</label>
      <div style="font-size:13px;color:var(--muted)">Fitur shapes: ini placeholder — bisa dikembangkan sesuai kebutuhan.</div>
    </div>
  </div>

  <!-- Brush settings -->
  <div class="tool-btn" id="btnBrushSettings" title="Brush settings">
    <i class="fa-solid fa-sliders"></i>
    <div class="tool-label">Brush</div>
    <div class="popup" id="popupBrush">
      <label>Warna</label>
      <input type="color" id="colorPicker" value="#ff0000">
      <div style="height:8px"></div>
      <label>Ukuran</label>
      <input type="range" id="sizePicker" min="1" max="60" value="4">
      <div style="display:flex;justify-content:space-between;margin-top:8px;">
        <button class="small-btn" id="undoBtn"><i class="fa-solid fa-rotate-left"></i> Undo</button>
        <button class="small-btn" id="redoBtn"><i class="fa-solid fa-rotate-right"></i> Redo</button>
      </div>
    </div>
  </div>

  <!-- Color quick -->
  <div class="tool-btn" id="btnColorQuick" title="Quick color">
    <i class="fa-solid fa-palette"></i>
    <div class="tool-label">Warna</div>
    <div class="popup" id="popupColor">
      <label>Pilihan warna cepat</label>
      <div class="palette">
        <div class="color-swatch" style="background:#000000" data-color="#000000"></div>
        <div class="color-swatch" style="background:#ffffff" data-color="#ffffff"></div>
        <div class="color-swatch" style="background:#ff0000" data-color="#ff0000"></div>
        <div class="color-swatch" style="background:#00b894" data-color="#00b894"></div>
        <div class="color-swatch" style="background:#0984e3" data-color="#0984e3"></div>
        <div class="color-swatch" style="background:#6c5ce7" data-color="#6c5ce7"></div>
      </div>
      <div style="height:8px"></div>
      <label>Custom</label>
      <input type="color" id="colorPicker2" value="#ff0000">
    </div>
  </div>

  <!-- Canvas size -->
  <div class="tool-btn" id="btnCanvasSize" title="Ukuran canvas">
    <i class="fa-solid fa-arrows-up-down-left-right"></i>
    <div class="tool-label">Ukuran</div>
    <div class="popup" id="popupSize">
      <label>Pilih ukuran canvas</label>
      <select id="canvasSizeSelect">
        <option value="a4p">A4 - Potret</option>
        <option value="a4l">A4 - Landscape</option>
        <option value="letterp">Letter - Potret</option>
        <option value="letterl">Letter - Landscape</option>
      </select>
      <div style="height:8px"></div>
      <button class="small-btn" id="applyCanvasSize">Terapkan ke halaman aktif</button>
    </div>
  </div>

  <!-- Zoom -->
  <div class="tool-btn" id="btnZoom" title="Zoom">
    <i class="fa-solid fa-magnifying-glass-plus"></i>
    <div class="tool-label">Zoom</div>
    <div class="popup" id="popupZoom">
      <label>Zoom</label>
      <div style="display:flex;gap:8px;align-items:center;">
        <button class="small-btn" id="zoomOutBtn"><i class="fa-solid fa-minus"></i></button>
        <div id="zoomPercent" style="min-width:56px;text-align:center;font-weight:600">100%</div>
        <button class="small-btn" id="zoomInBtn"><i class="fa-solid fa-plus"></i></button>
      </div>
      <div style="height:8px"></div>
      <label>Pan mode</label>
      <div style="display:flex;gap:8px;">
        <button class="small-btn" id="panToggleBtn">Pan: OFF</button>
        <button class="small-btn" id="fitBtn">Fit Width</button>
      </div>
    </div>
  </div>

  <!-- Clear -->
  <div class="tool-btn" id="btnClear" title="Clear all">
    <i class="fa-solid fa-trash-can"></i>
    <div class="tool-label">Hapus</div>
  </div>

  <!-- Save / Download -->
  <div class="tool-btn" id="btnSave" title="Save / Download">
    <i class="fa-solid fa-file-arrow-down"></i>
    <div class="tool-label">Simpan</div>
    <div class="popup" id="popupSave">
      <label>Ekspor</label>
      <div style="display:flex;gap:8px;">
        <button class="small-btn" id="savePdfBtn"><i class="fa-solid fa-file-pdf"></i> Download PDF</button>
        <button class="small-btn" id="downloadJpgBtn"><i class="fa-solid fa-image"></i> JPG</button>
        <button class="small-btn" id="saveServerBtn"><i class="fa-solid fa-cloud-arrow-up"></i> Simpan ke Server</button>
      </div>
    </div>
  </div>
</div>

<!-- PDF.js + PDF-Lib (pastikan file ada di server) -->
<script src="<?= base_url('assets/js/pdf.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pdf-lib.min.js') ?>"></script>
<script>
  pdfjsLib = window['pdfjs-dist/build/pdf'];
  pdfjsLib.GlobalWorkerOptions.workerSrc = "<?= base_url('assets/js/pdf.worker.min.js') ?>";
</script>

<script>
/* ========== Variabel global ========== */
const container = document.getElementById('container');
const progressBar = document.getElementById('progressBar');
const progressFill = document.getElementById('progressFill');
const previewPanel = document.getElementById('previewPanel');
const pagesToggle = document.getElementById('pagesToggle');
const settingsBtn = document.getElementById('settingsBtn');
const settingsPopup = document.getElementById('settingsPopup');
const themeLightBtn = document.getElementById('themeLightBtn');
const themeDarkBtn = document.getElementById('themeDarkBtn');
const themeCustomBtn = document.getElementById('themeCustomBtn');
const customAccent = document.getElementById('customAccent');

let pdfDoc = null;
let pageStates = [];
let scale = 1.0;
const zoomLevels = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
let currentZoomIndex = 2; // default 1.0
let panMode = false;
let tool = 'brush'; // or 'eraser'
let color = '#ff0000';
let size = 4;

/* Hooks */
const zoomPercentLabel = document.getElementById('zoomPercent');
const colorPicker = document.getElementById('colorPicker');
const colorPicker2 = document.getElementById('colorPicker2');
const sizePicker = document.getElementById('sizePicker');
const drawModeSelect = document.getElementById('drawMode');

const pdfUrl = "<?= base_url('index.php/notes/view_pdf/'.$filename) ?>";

/* Theme handling */
function setThemeLight(){
  document.getElementById('appRoot').classList.remove('theme-dark');
  document.documentElement.style.setProperty('--blue-500', '#1976d2');
  document.documentElement.style.setProperty('--blue-600', '#1565c0');
  document.documentElement.style.setProperty('--sidebar-bg', 'linear-gradient(180deg,var(--card),#f0f7ff)');
}
function setThemeDark(){
  document.getElementById('appRoot').classList.add('theme-dark');
}
function setThemeCustom(hex){
  // set accent variables to custom hex
  document.documentElement.style.setProperty('--blue-500', hex);
  // darken a bit for blue-600
  // simple algorithm: reduce brightness
  function darken(hex, amt){
    const c = hex.replace('#','');
    const num = parseInt(c,16);
    let r = (num >> 16) - amt; if(r<0) r=0;
    let g = ((num >> 8) & 0x00FF) - amt; if(g<0) g=0;
    let b = (num & 0x0000FF) - amt; if(b<0) b=0;
    return '#' + ( (1<<24) + (r<<16) + (g<<8) + b ).toString(16).slice(1);
  }
  document.documentElement.style.setProperty('--blue-600', darken(hex,20));
  document.getElementById('appRoot').classList.remove('theme-dark');
}

/* Progress helpers */
function showProgress(){ progressBar.style.display='block'; progressFill.style.width='0%'; }
function setProgress(p){ progressFill.style.width = Math.max(0, Math.min(100,p)) + '%'; }
function hideProgress(){ setTimeout(()=>{ progressBar.style.display='none'; },200); }

/* Update zoom label */
function updateZoomLabel(){ const pct = Math.round((zoomLevels[currentZoomIndex] / zoomLevels[2]) * 100); zoomPercentLabel.textContent = pct + '%'; }

/* ---------- THUMBNAIL / PREVIEW LOGIC ---------- */
let thumbnailCanvases = []; // array of elements {thumbEl, canvasEl, index}
function clearThumbnails(){
  previewPanel.innerHTML = '';
  thumbnailCanvases = [];
}
function createThumbnailForPage(i){
  // creates a .thumb element with small canvas placeholder
  const thumb = document.createElement('div');
  thumb.className = 'thumb';
  thumb.dataset.index = i;
  thumb.style.position = 'relative';

  // page number badge
  const pnum = document.createElement('div');
  pnum.className = 'page-num';
  pnum.textContent = (i+1);
  pnum.style.pointerEvents = 'none';
  thumb.appendChild(pnum);

  const canvas = document.createElement('canvas');
  canvas.width = 200; canvas.height = 300; // will be scaled when drawing
  canvas.style.display = 'block';
  canvas.style.width = '64px';
  canvas.style.height = 'auto';
  thumb.appendChild(canvas);

  thumb.addEventListener('click', ()=> {
    // scroll to page
    const pages = document.querySelectorAll('.page');
    const target = pages[i];
    if(target) target.scrollIntoView({behavior:'smooth', block:'center'});
  });

  previewPanel.appendChild(thumb);
  thumbnailCanvases[i] = { thumbEl: thumb, canvasEl: canvas, index: i };
}

/* Update specific thumbnail by merging base+draw */
function updateThumbnail(i){
  const entry = thumbnailCanvases[i];
  if(!entry) return;
  const pageDiv = document.querySelectorAll('.page')[i];
  if(!pageDiv) return;
  const base = pageDiv.querySelector('canvas:not(.draw-layer)');
  const draw = pageDiv.querySelector('canvas.draw-layer');

  // create merged smaller canvas
  const tmp = document.createElement('canvas');
  tmp.width = base.width;
  tmp.height = base.height;
  const tctx = tmp.getContext('2d');
  tctx.drawImage(base,0,0);
  tctx.drawImage(draw,0,0);

  // draw scaled to thumbnail
  const thumbCanvas = entry.canvasEl;
  const thumbCtx = thumbCanvas.getContext('2d');
  // scale down preserving aspect
  const maxThumbW = 160;
  const scale = Math.min(maxThumbW / tmp.width, 1);
  const tw = Math.round(tmp.width * scale);
  const th = Math.round(tmp.height * scale);
  thumbCanvas.width = tw;
  thumbCanvas.height = th;
  thumbCanvas.style.width = '64px';
  thumbCanvas.style.height = (th / tw * 64) + 'px';

  // clear and draw
  thumbCtx.clearRect(0,0,thumbCanvas.width,thumbCanvas.height);
  thumbCtx.drawImage(tmp, 0, 0, tmp.width, tmp.height, 0, 0, thumbCanvas.width, thumbCanvas.height);
}

/* Rebuild all thumbnails after render */
function rebuildThumbnails(){
  clearThumbnails();
  const pages = document.querySelectorAll('.page');
  for(let i=0;i<pages.length;i++){
    createThumbnailForPage(i);
    updateThumbnail(i);
  }
  // after creating thumbnails, create IntersectionObserver to highlight active
  observeActivePage();
}

/* Update one thumbnail when canvas changed (called on drawing end) */
function onPageEdited(pageIndex){
  // save pageStates dataURL also (existing logic already does)
  updateThumbnail(pageIndex);
}

/* active thumbnail highlight: use IntersectionObserver to find which page is mostly visible */
let pageObserver = null;
function observeActivePage(){
  if(pageObserver) pageObserver.disconnect();
  const opts = { root: container, rootMargin: '0px', threshold: [0.45, 0.6, 0.9] };
  pageObserver = new IntersectionObserver((entries)=>{
    entries.forEach(en=>{
      if(en.isIntersecting){
        const pages = [...document.querySelectorAll('.page')];
        const idx = pages.indexOf(en.target);
        if(idx >= 0){
          // remove previous
          document.querySelectorAll('.thumb').forEach(t=>t.classList.remove('active'));
          const e = thumbnailCanvases[idx];
          if(e && e.thumbEl) e.thumbEl.classList.add('active');
        }
      }
    });
  }, opts);

  document.querySelectorAll('.page').forEach(p=> pageObserver.observe(p));
}

/* ---------- END THUMBNAIL LOGIC ---------- */

/* Rendering pages and drawing code (mostly same as before) */
function getPosOnCanvas(canvas, e){
  const rect = canvas.getBoundingClientRect();
  const t = e.touches ? e.touches[0] : e;
  return { x: (t.clientX - rect.left), y: (t.clientY - rect.top) };
}

/* Enable drawing on a canvas and hook to onPageEdited */
function enableDrawingOnCanvas(canvas, pageIndex){
  const ctx = canvas.getContext('2d');
  ctx.lineJoin = 'round';
  ctx.lineCap = 'round';
  if (!pageStates[pageIndex]) pageStates[pageIndex] = { dataURL: null, undoStack: [], redoStack: [] };

  let drawing=false, last={x:0,y:0}, hasDrawn=false;

  function saveSnapshotToUndo(){
    const s = pageStates[pageIndex];
    try{
      const snap = canvas.toDataURL();
      s.undoStack.push(snap);
      if(s.undoStack.length > 30) s.undoStack.shift();
      s.redoStack = [];
    }catch(err){ console.error(err); }
  }

  const start = e => {
    if(panMode) return;
    e.preventDefault();
    drawing = true;
    hasDrawn = false;
    last = getPosOnCanvas(canvas, e);
    saveSnapshotToUndo();
  };

  const move = e => {
    if(!drawing || panMode) return;
    e.preventDefault();
    const pos = getPosOnCanvas(canvas, e);
    ctx.globalCompositeOperation = (tool === 'eraser') ? 'destination-out' : 'source-over';
    ctx.strokeStyle = color;
    ctx.lineWidth = size;
    ctx.beginPath();
    ctx.moveTo(last.x, last.y);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
    last = pos;
    hasDrawn = true;
  };

  const end = e => {
    if(!drawing) return;
    drawing=false;
    ctx.globalCompositeOperation = 'source-over';
    if(hasDrawn){
      try{ pageStates[pageIndex].dataURL = canvas.toDataURL(); }catch(err){}
      // Auto-update thumbnail for this page
      onPageEdited(pageIndex);
    }
  };

  // mouse
  canvas.addEventListener('mousedown', start);
  canvas.addEventListener('mousemove', move);
  canvas.addEventListener('mouseup', end);
  canvas.addEventListener('mouseout', end);
  // touch
  canvas.addEventListener('touchstart', start);
  canvas.addEventListener('touchmove', move);
  canvas.addEventListener('touchend', end);

  // attach undo/redo to canvas for global buttons
  canvas._doUndo = function(){
    const s = pageStates[pageIndex];
    if(!s.undoStack.length) return;
    const prev = s.undoStack.pop();
    const current = canvas.toDataURL();
    s.redoStack.push(current);
    const img = new Image();
    img.onload = () => {
      ctx.globalCompositeOperation = 'source-over';
      ctx.clearRect(0,0,canvas.width,canvas.height);
      ctx.drawImage(img,0,0);
      s.dataURL = prev;
      onPageEdited(pageIndex);
    };
    img.src = prev;
  };
  canvas._doRedo = function(){
    const s = pageStates[pageIndex];
    if(!s.redoStack.length) return;
    const redo = s.redoStack.pop();
    const current = canvas.toDataURL();
    s.undoStack.push(current);
    const img = new Image();
    img.onload = () => {
      ctx.globalCompositeOperation = 'source-over';
      ctx.clearRect(0,0,canvas.width,canvas.height);
      ctx.drawImage(img,0,0);
      s.dataURL = redo;
      onPageEdited(pageIndex);
    };
    img.src = redo;
  };
}

/* Utility: find focused draw canvas */
function getFocusedDrawCanvas(){
  const pages=[...document.querySelectorAll('.page')];
  const containerRect=container.getBoundingClientRect();
  let best=null,bestOverlap=-1;
  for(const p of pages){
    const r=p.getBoundingClientRect();
    const top=Math.max(r.top,containerRect.top);
    const bottom=Math.min(r.bottom,containerRect.bottom);
    const overlap=Math.max(0,bottom-top);
    if(overlap>bestOverlap){bestOverlap=overlap;best=p;}
  }
  return best?best.querySelector('canvas.draw-layer'):null;
}

/* Undo/Redo bindings (use canvas._doUndo/_doRedo) */
document.getElementById('undoBtn').onclick = ()=>{ const c = getFocusedDrawCanvas(); if(c && c._doUndo) c._doUndo(); };
document.getElementById('redoBtn').onclick = ()=>{ const c = getFocusedDrawCanvas(); if(c && c._doRedo) c._doRedo(); };

/* Clear all draws */
document.getElementById('btnClear').onclick = ()=>{
  document.querySelectorAll('canvas.draw-layer').forEach((c,i)=>{ c.getContext('2d').clearRect(0,0,c.width,c.height); if(pageStates[i]){ pageStates[i].dataURL=null; pageStates[i].undoStack=[]; pageStates[i].redoStack=[]; } });
  // refresh all thumbnails
  document.querySelectorAll('.page').forEach((p,i)=> onPageEdited(i));
  alert('✅ Semua coretan dihapus.');
};

/* Capture draw layers into pageStates */
function captureAllDrawsToStates(){
  document.querySelectorAll('.page').forEach((p,i)=>{
    const d = p.querySelector('canvas.draw-layer');
    if(!pageStates[i]) pageStates[i] = { dataURL:null, undoStack:[], redoStack:[] };
    try{ pageStates[i].dataURL = d.toDataURL(); }catch(e){}
  });
}

/* Zoom controls (unchanged) */
document.getElementById('zoomInBtn').onclick = async ()=>{
  if(currentZoomIndex < zoomLevels.length - 1){
    captureAllDrawsToStates();
    currentZoomIndex++;
    scale = zoomLevels[currentZoomIndex];
    updateZoomLabel();
    await renderAllPages(true);
  }
};
document.getElementById('zoomOutBtn').onclick = async ()=>{
  if(currentZoomIndex > 0){
    captureAllDrawsToStates();
    currentZoomIndex--;
    scale = zoomLevels[currentZoomIndex];
    updateZoomLabel();
    await renderAllPages(true);
  }
};
document.getElementById('fitBtn').onclick = ()=>{
  const viewportWidth = container.clientWidth - 60;
  if(document.querySelector('.page')){
    const base = document.querySelector('.page canvas:not(.draw-layer)');
    const ratio = viewportWidth / base.width;
    let bestIdx = 0; let bestDiff = Infinity;
    for(let i=0;i<zoomLevels.length;i++){
      const diff = Math.abs(zoomLevels[i] - ratio);
      if(diff < bestDiff){ bestDiff = diff; bestIdx = i; }
    }
    captureAllDrawsToStates();
    currentZoomIndex = bestIdx; scale = zoomLevels[currentZoomIndex];
    renderAllPages(true);
  }
};

/* Pan mode */
const panToggleBtn = document.getElementById('panToggleBtn');
panToggleBtn.onclick = ()=>{
  panMode = !panMode;
  panToggleBtn.textContent = 'Pan: ' + (panMode ? 'ON' : 'OFF');
  container.style.cursor = panMode ? 'grab' : 'default';
};

let isPanning=false, startPan={x:0,y:0}, scrollStart={x:0,y:0};
container.addEventListener('mousedown', e=>{
  if(!panMode) return;
  isPanning=true; container.style.cursor='grabbing';
  startPan={x:e.clientX,y:e.clientY};
  scrollStart={x:container.scrollLeft,y:container.scrollTop};
});
container.addEventListener('mousemove', e=>{
  if(!isPanning) return;
  const dx = e.clientX - startPan.x;
  const dy = e.clientY - startPan.y;
  container.scrollLeft = scrollStart.x - dx;
  container.scrollTop = scrollStart.y - dy;
});
container.addEventListener('mouseup', ()=>{ isPanning=false; container.style.cursor = panMode ? 'grab' : 'default'; });

/* Draw mode / color / size bindings */
drawModeSelect.onchange = e => { tool = e.target.value; };
document.getElementById('quickBrush').onclick = ()=>{ tool='brush'; drawModeSelect.value='brush'; };
document.getElementById('quickEraser').onclick = ()=>{ tool='eraser'; drawModeSelect.value='eraser'; };

colorPicker.onchange = e => { color = e.target.value; colorPicker2.value = color; };
colorPicker2.onchange = e => { color = e.target.value; colorPicker.value = color; };
document.querySelectorAll('.color-swatch').forEach(s=>{
  s.onclick = () => { const c = s.dataset.color; color = c; colorPicker.value = c; colorPicker2.value = c; };
});
sizePicker.oninput = e => { size = Number(e.target.value); };

/* Save / Export (unchanged) */
async function generateAnnotatedPdfBytes(onProgress=null){
  const pages = document.querySelectorAll('.page');
  const doc = await PDFLib.PDFDocument.create();
  for(let i=0;i<pages.length;i++){
    const base = pages[i].querySelector('canvas:not(.draw-layer)');
    const draw = pages[i].querySelector('canvas.draw-layer');
    const merged = document.createElement('canvas');
    merged.width = base.width; merged.height = base.height;
    const ctx = merged.getContext('2d');
    ctx.drawImage(base,0,0);
    ctx.drawImage(draw,0,0);
    const imgData = merged.toDataURL('image/png');
    const page = doc.addPage([merged.width,merged.height]);
    const png = await doc.embedPng(imgData);
    page.drawImage(png, { x:0, y:0, width: merged.width, height: merged.height });
    if(onProgress) onProgress(Math.round(((i+1)/pages.length)*100));
  }
  return await doc.save();
}
document.getElementById('savePdfBtn').onclick = async ()=>{
  try{
    showProgress(); setProgress(5);
    const bytes = await generateAnnotatedPdfBytes(p=> setProgress(5 + Math.round(p*0.9)));
    setProgress(95);
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'annotated.pdf'; a.click();
    hideProgress();
  }catch(err){ console.error(err); hideProgress(); alert('Gagal membangun PDF.'); }
};
document.getElementById('saveServerBtn').onclick = async ()=>{
  try{
    showProgress(); setProgress(5);
    const bytes = await generateAnnotatedPdfBytes(p=> setProgress(5 + Math.round(p*0.8)));
    setProgress(70);
    const blob = new Blob([bytes], { type:'application/pdf' });
    const form = new FormData();
    form.append('pdf_file', blob, 'annotated_'+Date.now()+'.pdf');
    const res = await fetch("<?= base_url('index.php/notes/save_pdf_server') ?>", { method:'POST', body: form });
    const json = await res.json();
    setProgress(100); hideProgress();
    if(json.status === 'success') alert('✅ PDF berhasil disimpan:\n' + json.file);
    else alert('❌ Gagal simpan: ' + (json.message || 'unknown'));
  }catch(err){ console.error(err); hideProgress(); alert('⚠️ Error simpan ke server'); }
};

/* Download JPG (unchanged) */
document.getElementById('downloadJpgBtn').onclick = async ()=>{
  const choice = prompt('📸 Pilih halaman (contoh: 1,3 or "all")');
  if(!choice) return;
  const pages = document.querySelectorAll('.page');
  if(choice.toLowerCase() === 'all'){
    let totalH = 0, maxW = 0;
    const canvases = [];
    for(const p of pages){
      const base = p.querySelector('canvas:not(.draw-layer)');
      const draw = p.querySelector('canvas.draw-layer');
      const merged = document.createElement('canvas');
      merged.width = base.width; merged.height = base.height;
      const ctx = merged.getContext('2d');
      ctx.drawImage(base,0,0); ctx.drawImage(draw,0,0);
      canvases.push(merged); totalH += merged.height; if(merged.width > maxW) maxW = merged.width;
    }
    const final = document.createElement('canvas');
    final.width = maxW; final.height = totalH;
    const fctx = final.getContext('2d');
    let y=0; for(const c of canvases){ fctx.drawImage(c,0,y); y+=c.height; }
    const link = document.createElement('a'); link.href = final.toDataURL('image/jpeg', 0.9); link.download = 'semua_halaman.jpg'; link.click();
    alert('✅ Semua halaman diunduh sebagai JPG.');
    return;
  }else{
    const parts = choice.split(',').map(x=>parseInt(x.trim(),10)).filter(n=>!isNaN(n));
    if(!parts.length){ alert('Nomor halaman tidak valid'); return; }
    for(const n of parts){
      if(n<1 || n>pages.length) continue;
      const base = pages[n-1].querySelector('canvas:not(.draw-layer)');
      const draw = pages[n-1].querySelector('canvas.draw-layer');
      const merged = document.createElement('canvas');
      merged.width = base.width; merged.height = base.height;
      const ctx = merged.getContext('2d');
      ctx.drawImage(base,0,0); ctx.drawImage(draw,0,0);
      const link = document.createElement('a'); link.href = merged.toDataURL('image/jpeg',0.9); link.download = 'halaman_'+n+'.jpg'; link.click();
    }
    alert('✅ Halaman JPG berhasil diunduh.');
  }
};

/* Popup toggles (unchanged) */
function hideAllPopups(){
  document.querySelectorAll('.popup').forEach(p=>p.classList.remove('show'));
  document.querySelectorAll('.tool-btn').forEach(b=>b.classList.remove('active'));
}
document.querySelectorAll('.tool-btn').forEach(btn=>{
  btn.addEventListener('click', (e)=>{
    e.stopPropagation();
    const popup = btn.querySelector('.popup');
    if(!popup){ if(btn.id === 'btnClear'){ document.getElementById('btnClear').click(); return; } return; }
    const isShown = popup.classList.contains('show');
    hideAllPopups();
    if(!isShown){ popup.classList.add('show'); btn.classList.add('active'); }
  });
});
document.addEventListener('click', ()=> hideAllPopups());
document.querySelectorAll('.popup').forEach(p=> p.addEventListener('click', e=> e.stopPropagation()));

/* Settings popup handling */
settingsBtn.addEventListener('click', (e)=>{
  e.stopPropagation();
  settingsPopup.style.display = settingsPopup.style.display === 'block' ? 'none' : 'block';
});
document.addEventListener('click', ()=> settingsPopup.style.display = 'none');
settingsPopup.addEventListener('click', e=> e.stopPropagation());

themeLightBtn.onclick = ()=> setThemeLight();
themeDarkBtn.onclick = ()=> setThemeDark();
themeCustomBtn.onclick = ()=> {
  document.getElementById('customColorRow').style.display = 'block';
};
customAccent.addEventListener('input', (e)=> setThemeCustom(e.target.value));

/* Pages toggle show/hide preview */
pagesToggle.addEventListener('click', ()=>{
  const isHidden = previewPanel.style.display === 'none' || previewPanel.style.display === '';
  if(isHidden){
    previewPanel.style.display = 'flex';
    pagesToggle.classList.add('active');
  } else {
    previewPanel.style.display = 'none';
    pagesToggle.classList.remove('active');
  }
});

/* Render all pages using PDF.js and attach draw layers */
async function renderAllPages(restore=true){
  showProgress(); setProgress(5);
  container.innerHTML = '';
  pageStates = pageStates || [];

  if(!pdfDoc){
    const loading = pdfjsLib.getDocument({ url: pdfUrl });
    pdfDoc = await loading.promise;
  }

  const num = pdfDoc.numPages;
  for(let i=1;i<=num;i++){
    setProgress(6 + Math.floor((i/num)*80));
    const page = await pdfDoc.getPage(i);
    const viewport = page.getViewport({ scale, rotation: page.rotation });
    const pageDiv = document.createElement('div');
    pageDiv.className = 'page';
    pageDiv.style.width = viewport.width + 'px';
    pageDiv.style.height = viewport.height + 'px';
    pageDiv.style.position = 'relative';
    pageDiv.style.borderRadius = '6px';
    container.appendChild(pageDiv);

    // Base PDF canvas
    const pdfCanvas = document.createElement('canvas');
    pdfCanvas.width = viewport.width;
    pdfCanvas.height = viewport.height;
    pdfCanvas.style.display = 'block';
    pageDiv.appendChild(pdfCanvas);
    const ctx = pdfCanvas.getContext('2d', { willReadFrequently:true });
    await page.render({ canvasContext: ctx, viewport }).promise;

    // Draw layer
    const drawCanvas = document.createElement('canvas');
    drawCanvas.classList.add('draw-layer');
    drawCanvas.width = viewport.width;
    drawCanvas.height = viewport.height;
    drawCanvas.style.position = 'absolute';
    drawCanvas.style.left = '0';
    drawCanvas.style.top = '0';
    pageDiv.appendChild(drawCanvas);

    if(!pageStates[i-1]) pageStates[i-1] = { dataURL: null, undoStack: [], redoStack: [] };
    if(restore && pageStates[i-1].dataURL){
      const img = new Image(); img.src = pageStates[i-1].dataURL;
      await new Promise(r=>img.onload=r);
      const dctx = drawCanvas.getContext('2d');
      dctx.clearRect(0,0,drawCanvas.width,drawCanvas.height);
      dctx.drawImage(img,0,0,drawCanvas.width,drawCanvas.height);
    }

    enableDrawingOnCanvas(drawCanvas, i-1);
  }

  setProgress(100);
  hideProgress();
  updateZoomLabel();

  // create thumbnails after pages rendered
  rebuildThumbnails();
}

/* Initial load */
(async ()=>{
  try{
    showProgress(); setProgress(10);
    const loading = pdfjsLib.getDocument({ url: pdfUrl });
    pdfDoc = await loading.promise;
    scale = zoomLevels[currentZoomIndex];
    await renderAllPages(false);
  }catch(e){ console.error(e); alert('Gagal memuat PDF.'); }
})();

</script>
</body>
</html>
