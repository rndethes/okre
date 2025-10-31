<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>OKRE Sketch — Canvas Blank</title>

<!-- Font Awesome (includes fa-aws brand icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --blue-500:#1976d2; --blue-600:#1565c0; --bg:#f8f9fb; --card:#ffffff; --muted:#6b7280; --glass: rgba(255,255,255,0.9); --shadow: 0 8px 30px rgba(12,34,80,0.06);
}
html,body{height:100%;margin:0;font-family: "Segoe UI", Roboto, Arial, sans-serif;background:var(--bg);color:#0b2540}
.app{display:flex;height:100vh;overflow:visible}
#leftbar{ width:88px; background: linear-gradient(180deg,var(--card),#f0f7ff); border-right:1px solid rgba(25,118,210,0.06); display:flex;flex-direction:column;align-items:center;padding:12px 8px;gap:12px; position:fixed; top:0; left:0; bottom:0; height:100vh; z-index:1000; box-shadow:var(--shadow) }
.left-icon{ width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:transparent;border:1px solid transparent;color:var(--blue-600);cursor:pointer;transition:all .18s;font-size:20px }
.left-icon:hover{transform:translateY(-3px);box-shadow:0 6px 14px rgba(25,118,210,0.06);background:linear-gradient(180deg,#fff,#f0f7ff)}
.left-icon.active{background:linear-gradient(180deg,var(--blue-500),var(--blue-600)); color:white; box-shadow:0 10px 20px rgba(25,118,210,0.14)}
#previewPanel{flex:1;width:100%;overflow-y:auto;display:flex;flex-direction:column;gap:10px;padding:8px 0;align-items:center;box-sizing:border-box}
.thumb{ width:64px;border-radius:8px;overflow:hidden;background:var(--card);border:2px solid transparent;box-shadow:0 6px 16px rgba(2,6,23,0.06);cursor:pointer;display:flex;justify-content:center;align-items:center;position:relative }
.thumb.active{ border-color: rgba(25,118,210,0.9); transform:translateY(-3px) }
.page-num{ position:absolute;font-size:11px;padding:4px 6px;border-radius:12px;background:rgba(255,255,255,0.9);left:6px;top:6px;color:#0b2540 }
.sidebar-footer{ position:sticky; bottom:0;background: linear-gradient(180deg,var(--card),#f0f7ff); width:100%;display:flex;align-items:center;justify-content:center;padding:8px 0;border-top:1px solid rgba(25,118,210,0.1) }
#main-area{ flex:1; display:flex; flex-direction:column; position:relative; margin-left:88px; margin-top:56px; padding-bottom:100px; height:calc(100vh - 56px); overflow:visible }
#topbar{ height:56px; display:flex; align-items:center; justify-content:space-between; padding:0 18px; border-bottom:1px solid rgba(25,118,210,0.06); background:linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.8)); position:fixed; top:0; left:88px; right:0; z-index:950 }
#topbar h2{margin:0;font-size:16px;color:var(--blue-600);letter-spacing:1px;display:flex;gap:8px;align-items:center}
.top-btn{background:var(--card);border:1px solid rgba(15,23,42,0.05);padding:8px 12px;border-radius:8px;cursor:pointer;display:flex;gap:8px;align-items:center}
html, body {
  height: 100%;
  margin: 0;
  overflow: hidden;
}

#main-area {
  flex: 1;
  display: flex;
  overflow: hidden;
  height: calc(100vh - 56px);
}

.container {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  overflow-y: auto;
  padding: 20px 0;
  width: 100%;
  background: #fafafa;
}

.page {
  background: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  margin: 20px auto;
  position: relative;
  transform-origin: top center;
  transition: transform 0.2s ease;
}

.page.active {
  border: 2px solid var(--blue-600);
}

.page canvas { display:block }
.bottom-toolbar{ position:fixed; left:50%; transform:translateX(-50%); bottom:18px; height:64px; background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(245,253,255,0.95)); border-radius:999px; padding:6px 14px; display:flex; gap:10px; align-items:center; z-index:1100; box-shadow: 0 10px 30px rgba(10,25,60,0.12); border:1px solid rgba(25,118,210,0.08) }
.tool-btn{ width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#fff,#f7fbff);border:1px solid rgba(15,23,42,0.04);cursor:pointer; position:relative; transition: transform .14s }
.tool-btn:hover{ transform:translateY(-4px) }
.tool-btn.active{ background:linear-gradient(180deg,var(--blue-500),var(--blue-600)); color:white; border:0; box-shadow:0 10px 20px rgba(25,118,210,0.18) }
.tool-label{ position:absolute; bottom:120px; left:50%; transform:translateX(-50%); font-size:12px; background:rgba(2,6,23,0.9); color:white; padding:6px 8px;border-radius:6px; display:none }
.tool-btn:hover .tool-label{ display:block }
.popup{ position:absolute; bottom:72px; left:50%; transform:translateX(-50%) translateY(8px); min-width:220px; background:var(--card); border-radius:12px; padding:10px; box-shadow:0 12px 30px rgba(2,6,23,0.12); border:1px solid rgba(15,23,42,0.06); display:none; z-index:1100 }
.popup.show{ display:block; transform:translateX(-50%) translateY(0) }
.popup .row{ display:flex; gap:8px; align-items:center; margin-bottom:8px }
.small-btn{ padding:6px 10px;border-radius:8px;background:#f6fbff;border:1px solid rgba(10,20,40,0.04);cursor:pointer }
.small-btn:hover{ background:#eaf6ff }
@media (max-width:880px){ #leftbar{ display:none } .bottom-toolbar{ left:16px; transform:none; right:16px; justify-content:space-between } .popup{ left:auto; right:0; transform:translateY(8px); bottom:78px } }
</style>
</head>
<body>
<div class="app" id="appRoot">
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
      <div class="actions" style="display:flex;gap:10px;align-items:center">
        <button id="downloadTopBtn" class="top-btn"><i class="fa-solid fa-download"></i>&nbsp;Download</button>
        <button id="saveTopBtn" class="top-btn"><i class="fa-solid fa-cloud-arrow-up"></i>&nbsp;Simpan</button>
      </div>
    </div>

    <div id="container" class="container"></div>
  </div>
</div>

<!-- SETTINGS POPUP -->
<div class="popup" id="settingsPopup" style="position:fixed; left:96px; bottom:84px; display:none; z-index:1200;">
  <label>Mode tampilan</label>
  <div style="display:flex;gap:8px;margin-bottom:8px;">
    <button class="small-btn" id="themeLightBtn">Light</button>
    <button class="small-btn" id="themeDarkBtn">Dark</button>
  </div>
  <div style="font-size:13px;color:var(--muted)">Ukuran halaman default: <strong>1080×1350</strong> px</div>
</div>

<!-- BOTTOM TOOLBAR -->
<div class="bottom-toolbar" id="bottomToolbar">
  <div class="tool-btn" id="btnDraw" title="Draw / Pen"><i class="fa-solid fa-pen"></i><div class="tool-label">Draw</div>
    <div class="popup" id="popupDraw"><label>Mode</label>
      <select id="drawMode"><option value="brush">Brush</option><option value="eraser">Eraser</option></select>
      <div style="height:6px"></div>
      <div style="display:flex;gap:8px"><button class="small-btn" id="quickBrush">Brush</button><button class="small-btn" id="quickEraser">Eraser</button></div>
    </div>
  </div>

  <div class="tool-btn" id="btnBrushSettings" title="Brush settings"><i class="fa-solid fa-sliders"></i><div class="tool-label">Brush</div>
    <div class="popup" id="popupBrush"><label>Warna</label><input type="color" id="colorPicker" value="#ff0000"><div style="height:8px"></div><label>Ukuran</label><input type="range" id="sizePicker" min="1" max="80" value="4"><div style="display:flex;justify-content:space-between;margin-top:8px"><button class="small-btn" id="undoBtn"><i class="fa-solid fa-rotate-left"></i> Undo</button><button class="small-btn" id="redoBtn"><i class="fa-solid fa-rotate-right"></i> Redo</button></div></div>
  </div>

  <div class="tool-btn" id="btnColorQuick" title="Quick color"><i class="fa-solid fa-palette"></i><div class="tool-label">Warna</div>
    <div class="popup" id="popupColor"><label>Pilihan warna cepat</label><div class="palette" style="display:flex;gap:6px"><div class="color-swatch" style="background:#000000" data-color="#000000"></div><div class="color-swatch" style="background:#ffffff" data-color="#ffffff"></div><div class="color-swatch" style="background:#ff0000" data-color="#ff0000"></div><div class="color-swatch" style="background:#00b894" data-color="#00b894"></div><div class="color-swatch" style="background:#0984e3" data-color="#0984e3"></div><div class="color-swatch" style="background:#6c5ce7" data-color="#6c5ce7"></div></div><div style="height:8px"></div><label>Custom</label><input type="color" id="colorPicker2" value="#ff0000"></div>
  </div>

  <div class="tool-btn" id="btnZoom" title="Zoom"><i class="fa-solid fa-magnifying-glass-plus"></i><div class="tool-label">Zoom</div>
    <div class="popup" id="popupZoom"><label>Zoom</label><div style="display:flex;gap:8px;align-items:center;">
      <button class="small-btn" id="zoomOutBtn"><i class="fa-solid fa-minus"></i></button><div id="zoomPercent" style="min-width:56px;text-align:center;font-weight:600">100%</div><button class="small-btn" id="zoomInBtn"><i class="fa-solid fa-plus"></i></button></div><div style="height:8px"></div><label>Pan mode</label><div style="display:flex;gap:8px;"><button class="small-btn" id="panToggleBtn">Pan: OFF</button>
    <button class="small-btn" id="fitBtn">Fit Width</button></div></div>
  </div>

  <div class="tool-btn" id="btnClear" title="Clear all"><i class="fa-solid fa-trash-can"></i><div class="tool-label">Hapus</div></div>

  <div class="tool-btn" id="btnSave" title="Save / Download"><i class="fa-solid fa-file-arrow-down"></i><div class="tool-label">Simpan</div>
    <div class="popup" id="popupSave"><label>Ekspor</label><div style="display:flex;gap:8px"><button class="small-btn" id="savePdfBtn"><i class="fa-solid fa-file-pdf"></i> Download PDF</button><button class="small-btn" id="downloadJpgBtn"><i class="fa-solid fa-image"></i> JPG</button><button class="small-btn" id="saveServerBtn"><i class="fa-solid fa-cloud-arrow-up"></i> Simpan ke Server</button></div></div>
  </div>
</div>

<!-- pdf-lib dari CDN -->
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>

<script>
/* ========== Konfigurasi ========== */
const DEFAULT_W = 1080; const DEFAULT_H = 1350;
const container = document.getElementById('container');
const previewPanel = document.getElementById('previewPanel');
let pages = []; // array of {pageEl, baseCanvas, drawCanvas, state}
let currentZoom = 1.0; const zoomLevels = [0.5,0.75,1,1.25,1.5,1.75,2]; let zoomIdx = 2;
let panMode = false; 
let tool = 'brush'; let color = '#ff0000'; 
let size = 4;

/* UI elements */
const addPageBtn = document.getElementById('addPageBtn');
const undoBtn = document.getElementById('undoBtn'); const redoBtn = document.getElementById('redoBtn');
const colorPicker = document.getElementById('colorPicker'); const colorPicker2 = document.getElementById('colorPicker2');
const sizePicker = document.getElementById('sizePicker'); const drawModeSelect = document.getElementById('drawMode');
const zoomPercent = document.getElementById('zoomPercent');

/* helpers */
function updateZoomLabel(){ zoomPercent.textContent = Math.round(currentZoom*100) + '%'; }

function createPage(index, restoreDataURL){
  const pageDiv = document.createElement('div'); pageDiv.className='page'; pageDiv.style.width=(DEFAULT_W*currentZoom)+'px'; pageDiv.style.height=(DEFAULT_H*currentZoom)+'px';

  // base white canvas
  const base = document.createElement('canvas'); base.width = DEFAULT_W; base.height = DEFAULT_H; base.style.width = (DEFAULT_W*currentZoom)+'px'; base.style.height = (DEFAULT_H*currentZoom)+'px';
  const bctx = base.getContext('2d'); bctx.fillStyle = '#ffffff'; bctx.fillRect(0,0,base.width,base.height);
  pageDiv.appendChild(base);

  // draw layer
  const draw = document.createElement('canvas'); draw.className='draw-layer'; draw.width = DEFAULT_W; draw.height = DEFAULT_H; draw.style.position='absolute'; draw.style.left='0'; draw.style.top='0'; draw.style.width = (DEFAULT_W*currentZoom)+'px'; draw.style.height = (DEFAULT_H*currentZoom)+'px';
  pageDiv.appendChild(draw);

  container.appendChild(pageDiv);

  const state = { undoStack: [], redoStack: [], dataURL: null };
  pages.splice(index,0,{pageEl:pageDiv, baseCanvas:base, drawCanvas:draw, state});

  // restore if provided
  if(restoreDataURL){ const img=new Image(); img.onload=()=>{ const ctx = draw.getContext('2d'); ctx.clearRect(0,0,draw.width,draw.height); ctx.drawImage(img,0,0,draw.width,draw.height); state.dataURL = draw.toDataURL(); updateThumbnail(); }; img.src = restoreDataURL; }

  enableDrawing(draw, pages.indexOf(pages.find(p=>p.drawCanvas===draw)));
  rebuildThumbnails();
  return pages[pages.findIndex(p=>p.drawCanvas===draw)];
}

function addNewPage(){ createPage(pages.length); scrollToPage(pages.length-1); 
setTimeout(() => {
    autoZoomToFit();
  }, 200);
}

function removePage(index){ if(index<0||index>=pages.length) return; const p=pages[index]; p.pageEl.remove(); pages.splice(index,1); rebuildThumbnails(); }

/* drawing */
function getPointerPos(canvas, e){ const rect = canvas.getBoundingClientRect(); const t = e.touches?e.touches[0]:e; return { x: (t.clientX - rect.left) * (canvas.width/rect.width), y: (t.clientY - rect.top) * (canvas.height/rect.height) }; }

function enableDrawing(drawCanvas, pageIndex){ const ctx = drawCanvas.getContext('2d'); ctx.lineJoin='round'; ctx.lineCap='round';
  const s = pages[pageIndex].state; let drawing=false, last={x:0,y:0}, hasDraw=false;
  function saveSnapshot(){ try{ s.undoStack.push(drawCanvas.toDataURL()); if(s.undoStack.length>50) s.undoStack.shift(); s.redoStack=[]; }catch(e){} }
  function start(e){ 
    if(panMode) return; 
    e.preventDefault(); 
    drawing=true; 
    hasDraw=false; 
    last = getPointerPos(drawCanvas,e); 
    saveSnapshot(); }
    
  function move(e){ if(!drawing||panMode) return; e.preventDefault(); const pos=getPointerPos(drawCanvas,e); ctx.globalCompositeOperation = (tool==='eraser')?'destination-out':'source-over'; ctx.strokeStyle = color; ctx.lineWidth = size; ctx.beginPath(); ctx.moveTo(last.x,last.y); ctx.lineTo(pos.x,pos.y); ctx.stroke(); last=pos; hasDraw=true; }
  function end(e){ if(!drawing) return; drawing=false; ctx.globalCompositeOperation = 'source-over'; if(hasDraw){ try{ s.dataURL = drawCanvas.toDataURL(); }catch(e){} updateThumbnailForIndex(pageIndex);} }
  drawCanvas.addEventListener('mousedown',start); drawCanvas.addEventListener('mousemove',move); drawCanvas.addEventListener('mouseup',end); drawCanvas.addEventListener('mouseout',end);
  drawCanvas.addEventListener('touchstart',start,{passive:false}); drawCanvas.addEventListener('touchmove',move,{passive:false}); drawCanvas.addEventListener('touchend',end);
  drawCanvas._doUndo = function(){ if(!s.undoStack.length) return; const prev = s.undoStack.pop(); s.redoStack.push(drawCanvas.toDataURL()); const img=new Image(); img.onload=()=>{ ctx.clearRect(0,0,drawCanvas.width,drawCanvas.height); ctx.drawImage(img,0,0); s.dataURL = prev; updateThumbnailForIndex(pageIndex); }; img.src = prev; };
  drawCanvas._doRedo = function(){ if(!s.redoStack.length) return; const next = s.redoStack.pop(); s.undoStack.push(drawCanvas.toDataURL()); const img=new Image(); img.onload=()=>{ ctx.clearRect(0,0,drawCanvas.width,drawCanvas.height); ctx.drawImage(img,0,0); s.dataURL = next; updateThumbnailForIndex(pageIndex); }; img.src = next; };
}

/* thumbnails */
function clearThumbnails(){ previewPanel.innerHTML=''; }
function createThumb(i){ const thumb = document.createElement('div'); thumb.className='thumb'; thumb.dataset.index=i; const pnum=document.createElement('div'); pnum.className='page-num'; pnum.textContent = i+1; thumb.appendChild(pnum); const canvas = document.createElement('canvas'); canvas.width=200; canvas.height=250; canvas.style.width='64px'; canvas.style.height='auto'; thumb.appendChild(canvas);
  thumb.addEventListener('click', ()=> scrollToPage(i)); previewPanel.appendChild(thumb); thumb._canvas = canvas; return thumb; }
function rebuildThumbnails(){ clearThumbnails(); pages.forEach((p,i)=>{ const t = createThumb(i); updateThumbnailForIndex(i); }); observeActivePage(); }
function updateThumbnailForIndex(i){ const p = pages[i]; if(!p) return; const tmp = document.createElement('canvas'); tmp.width = p.baseCanvas.width; tmp.height = p.baseCanvas.height; const tctx = tmp.getContext('2d'); tctx.drawImage(p.baseCanvas,0,0); tctx.drawImage(p.drawCanvas,0,0);
  const thumb = previewPanel.children[i]; if(!thumb) return; const tc = thumb._canvas; const scale = Math.min(160/tmp.width, 1); tc.width = Math.round(tmp.width*scale); tc.height = Math.round(tmp.height*scale); tc.getContext('2d').clearRect(0,0,tc.width,tc.height); tc.getContext('2d').drawImage(tmp,0,0,tmp.width,tmp.height,0,0,tc.width,tc.height);
}

/* active page highlight */
let pageObserver=null; function observeActivePage(){ if(pageObserver) pageObserver.disconnect(); const opts={ root: container, rootMargin:'0px', threshold:[0.45,0.6,0.9] }; pageObserver = new IntersectionObserver((entries)=>{ entries.forEach(en=>{ if(en.isIntersecting){ const idx = Array.from(container.querySelectorAll('.page')).indexOf(en.target); if(idx>=0){ Array.from(previewPanel.children).forEach(c=>c.classList.remove('active')); const t = previewPanel.children[idx]; if(t) t.classList.add('active'); } } }); }, opts); document.querySelectorAll('.page').forEach(p=> pageObserver.observe(p)); }

/* scrolling */
function scrollToPage(i){ const pagesEls = container.querySelectorAll('.page'); if(pagesEls[i]) pagesEls[i].scrollIntoView({behavior:'smooth', block:'center'}); }

/* undo/redo bindings */
undoBtn.addEventListener('click', ()=>{ const c = getFocusedDrawCanvas(); if(c && c._doUndo) c._doUndo(); }); redoBtn.addEventListener('click', ()=>{ const c = getFocusedDrawCanvas(); if(c && c._doRedo) c._doRedo(); });
function getFocusedDrawCanvas(){ const pageEls = Array.from(container.querySelectorAll('.page')); const rect = container.getBoundingClientRect(); let best=null,bestOverlap=-1; for(const p of pageEls){ const r = p.getBoundingClientRect(); const top=Math.max(r.top,rect.top); const bottom=Math.min(r.bottom,rect.bottom); const overlap=Math.max(0,bottom-top); if(overlap>bestOverlap){ bestOverlap=overlap; best=p; } } return best?best.querySelector('canvas.draw-layer'):null; }

/* clear all */
document.getElementById('btnClear').addEventListener('click', ()=>{ pages.forEach((p,i)=>{ p.drawCanvas.getContext('2d').clearRect(0,0,p.drawCanvas.width,p.drawCanvas.height); p.state.dataURL=null; p.state.undoStack=[]; p.state.redoStack=[]; updateThumbnailForIndex(i); }); alert('✅ Semua coretan dihapus.'); });

/* zoom/pan */
document.getElementById('zoomInBtn').addEventListener('click', ()=>{ if(zoomIdx<zoomLevels.length-1){ saveAllDrawStates(); zoomIdx++; currentZoom = zoomLevels[zoomIdx]; rescaleAll(); updateZoomLabel(); }});
document.getElementById('zoomOutBtn').addEventListener('click', ()=>{ if(zoomIdx>0){ saveAllDrawStates(); zoomIdx--; currentZoom = zoomLevels[zoomIdx]; rescaleAll(); updateZoomLabel(); }});
document.getElementById('fitBtn').addEventListener('click', ()=>{ // fit width logic
  const viewportWidth = container.clientWidth - 60; const ratio = viewportWidth / DEFAULT_W; let best=0,bdiff=Infinity; zoomLevels.forEach((z,i)=>{ const d = Math.abs(z - ratio); if(d<bdiff){ bdiff=d; best=i; } }); saveAllDrawStates(); zoomIdx = best; currentZoom = zoomLevels[zoomIdx]; rescaleAll(); updateZoomLabel(); });

document.getElementById('panToggleBtn').addEventListener('click', ()=> { panMode = !panMode; document.getElementById('panToggleBtn').textContent = 'Pan: ' + (panMode ? 'ON' : 'OFF'); container.style.cursor = panMode ? 'grab' : 'default'; });
let isPanning=false, startPan={x:0,y:0}, scrollStart={x:0,y:0}; container.addEventListener('mousedown', e=>{ if(!panMode) return; isPanning=true; container.style.cursor='grabbing'; startPan={x:e.clientX,y:e.clientY}; scrollStart={x:container.scrollLeft,y:container.scrollTop}; }); container.addEventListener('mousemove', e=>{ if(!isPanning) return; const dx = e.clientX - startPan.x; const dy = e.clientY - startPan.y; container.scrollLeft = scrollStart.x - dx; container.scrollTop = scrollStart.y - dy; }); container.addEventListener('mouseup', ()=>{ isPanning=false; container.style.cursor = panMode ? 'grab' : 'default'; });

/* save state helpers */
function saveAllDrawStates(){ pages.forEach(p=>{ try{ p.state.dataURL = p.drawCanvas.toDataURL(); }catch(e){} }); }
function rescaleAll() {
  saveAllDrawStates(); // simpan semua coretan terlebih dahulu
  container.innerHTML = '';

  const loadPromises = pages.map((p, idx) => {
    const data = p.state.dataURL;
    const pageDiv = document.createElement('div');
    pageDiv.className = 'page';
    pageDiv.style.width = (DEFAULT_W * currentZoom) + 'px';
    pageDiv.style.height = (DEFAULT_H * currentZoom) + 'px';
    pageDiv.style.position = 'relative';
    pageDiv.style.margin = '20px auto';
    pageDiv.style.boxShadow = '0 0 10px rgba(0,0,0,0.1)';
    pageDiv.style.background = 'white';
    pageDiv.style.transformOrigin = 'top center';
    pageDiv.style.transition = 'transform 0.2s ease';

    const base = document.createElement('canvas');
    base.width = DEFAULT_W;
    base.height = DEFAULT_H;
    base.style.width = (DEFAULT_W * currentZoom) + 'px';
    base.style.height = (DEFAULT_H * currentZoom) + 'px';
    const bctx = base.getContext('2d');
    bctx.fillStyle = '#ffffff';
    bctx.fillRect(0, 0, base.width, base.height);
    pageDiv.appendChild(base);

    const draw = document.createElement('canvas');
    draw.className = 'draw-layer';
    draw.width = DEFAULT_W;
    draw.height = DEFAULT_H;
    draw.style.position = 'absolute';
    draw.style.left = '0';
    draw.style.top = '0';
    draw.style.width = (DEFAULT_W * currentZoom) + 'px';
    draw.style.height = (DEFAULT_H * currentZoom) + 'px';
    pageDiv.appendChild(draw);

    container.appendChild(pageDiv);

    p.pageEl = pageDiv;
    p.baseCanvas = base;
    p.drawCanvas = draw;
    enableDrawing(draw, idx);

    if (!data) return Promise.resolve();

    // Gunakan Promise agar load gambar sinkron
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => {
        draw.getContext('2d').drawImage(img, 0, 0);
        updateThumbnailForIndex(idx);
        resolve();
      };
      img.src = data;
    });
  });

  Promise.all(loadPromises).then(() => {
    rebuildThumbnails();
  });
}


/* color/size binding */
colorPicker.addEventListener('change', e=>{ color=e.target.value; colorPicker2.value=color; }); colorPicker2.addEventListener('change', e=>{ color=e.target.value; colorPicker.value=color; }); document.querySelectorAll('.color-swatch').forEach(s=> s.addEventListener('click', ()=>{ const c = s.dataset.color; color=c; colorPicker.value=c; colorPicker2.value=c; })); sizePicker.addEventListener('input', e=> size=Number(e.target.value)); drawModeSelect.addEventListener('change', e=> tool=e.target.value); document.getElementById('quickBrush').addEventListener('click', ()=>{ tool='brush'; drawModeSelect.value='brush'; }); document.getElementById('quickEraser').addEventListener('click', ()=>{ tool='eraser'; drawModeSelect.value='eraser'; });

/* thumbnails + add page interactions */
addPageBtn.addEventListener('click', ()=> addNewPage());
const deletePageBtn = document.getElementById('deletePageBtn');
deletePageBtn.addEventListener('click', ()=>{
  const activeIndex = [...previewPanel.children].findIndex(c=>c.classList.contains('active'));
  if(activeIndex<0){ alert('Tidak ada halaman aktif untuk dihapus.'); return; }
  if(!confirm('Yakin ingin menghapus halaman ke-'+(activeIndex+1)+'?')) return;
  removePage(activeIndex);
});


/* export to PDF */
async function generatePdfBytes(){ saveAllDrawStates(); const pdfDoc = await PDFLib.PDFDocument.create(); for(let i=0;i<pages.length;i++){ const p = pages[i]; // merge base+draw
  const tmp = document.createElement('canvas'); tmp.width = p.baseCanvas.width; tmp.height = p.baseCanvas.height; const tctx = tmp.getContext('2d'); tctx.drawImage(p.baseCanvas,0,0); tctx.drawImage(p.drawCanvas,0,0);
  const pngData = tmp.toDataURL('image/png'); const page = pdfDoc.addPage([tmp.width, tmp.height]); const pngImage = await pdfDoc.embedPng(pngData); page.drawImage(pngImage, { x:0, y:0, width: tmp.width, height: tmp.height }); }
  return await pdfDoc.save(); }

document.getElementById('savePdfBtn').addEventListener('click', async ()=>{ try{ const bytes = await generatePdfBytes(); const blob = new Blob([bytes], { type:'application/pdf' }); const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'canvas_annotated.pdf'; a.click(); alert('✅ PDF siap diunduh.'); }catch(e){ console.error(e); alert('Gagal membangun PDF'); } });

/* download JPG */
document.getElementById('downloadJpgBtn').addEventListener('click', ()=>{ const choice = prompt('Pilih halaman (mis: 1,3 atau all)'); if(!choice) return; if(choice.toLowerCase()==='all'){ const canvases = pages.map(p=>{ const tmp = document.createElement('canvas'); tmp.width=p.baseCanvas.width; tmp.height=p.baseCanvas.height; const ctx=tmp.getContext('2d'); ctx.drawImage(p.baseCanvas,0,0); ctx.drawImage(p.drawCanvas,0,0); return tmp; }); // merge vertically
    const final = document.createElement('canvas'); final.width = Math.max(...canvases.map(c=>c.width)); final.height = canvases.reduce((s,c)=>s+c.height,0); const fctx = final.getContext('2d'); let y=0; canvases.forEach(c=>{ fctx.drawImage(c,0,y); y+=c.height; }); const a=document.createElement('a'); a.href=final.toDataURL('image/jpeg',0.9); a.download='all_pages.jpg'; a.click(); alert('✅ Semua halaman diunduh sebagai JPG'); return; } else { const parts = choice.split(',').map(x=>parseInt(x.trim(),10)).filter(n=>!isNaN(n)); for(const n of parts){ if(n<1||n>pages.length) continue; const p=pages[n-1]; const tmp=document.createElement('canvas'); tmp.width=p.baseCanvas.width; tmp.height=p.baseCanvas.height; const ctx=tmp.getContext('2d'); ctx.drawImage(p.baseCanvas,0,0); ctx.drawImage(p.drawCanvas,0,0); const a=document.createElement('a'); a.href=tmp.toDataURL('image/jpeg',0.9); a.download='page_'+n+'.jpg'; a.click(); } alert('✅ Halaman JPG berhasil diunduh.'); } });

/* save to server */
document.getElementById('saveServerBtn').addEventListener('click', async ()=>{ try{ const bytes = await generatePdfBytes(); const blob = new Blob([bytes], { type:'application/pdf' }); const form = new FormData(); form.append('pdf_file', blob, 'annotated_'+Date.now()+'.pdf'); const res = await fetch('index.php/document/save_canvas', { method:'POST', body: form }); const json = await res.json(); if(json && json.status==='success') alert('✅ PDF tersimpan: '+ json.file); else alert('❌ Gagal simpan ke server'); }catch(e){ console.error(e); alert('⚠️ Error simpan ke server'); } });

/* popup toggles */
function hideAllPopups(){ document.querySelectorAll('.popup').forEach(p=>p.classList.remove('show')); document.querySelectorAll('.tool-btn').forEach(b=>b.classList.remove('active')); }
document.querySelectorAll('.tool-btn').forEach(btn=>{ btn.addEventListener('click', (e)=>{ e.stopPropagation(); const popup = btn.querySelector('.popup'); if(!popup){ if(btn.id==='btnClear'){ document.getElementById('btnClear').click(); return; } return; } const isShown = popup.classList.contains('show'); hideAllPopups(); if(!isShown){ popup.classList.add('show'); btn.classList.add('active'); } }); });
document.addEventListener('click', ()=> hideAllPopups()); document.querySelectorAll('.popup').forEach(p=> p.addEventListener('click', e=> e.stopPropagation()));

/* settings popup */
const settingsBtn = document.getElementById('settingsBtn'); const settingsPopup = document.getElementById('settingsPopup'); settingsBtn.addEventListener('click', e=>{ e.stopPropagation(); settingsPopup.style.display = settingsPopup.style.display==='block'? 'none':'block'; }); document.addEventListener('click', ()=> settingsPopup.style.display='none'); settingsPopup.addEventListener('click', e=> e.stopPropagation()); document.getElementById('themeDarkBtn').addEventListener('click', ()=> document.documentElement.classList.add('theme-dark'));

/* init: create two pages */
(function init(){ createPage(0);  updateZoomLabel(); })();

/* utilities */
function updateThumbnail(){ pages.forEach((p,i)=> updateThumbnailForIndex(i)); }
function autoZoomToFit() {
  const container = document.querySelector('.container');
  const page = document.querySelector('.page');
  if (!container || !page) return;

  const maxWidth = container.clientWidth * 0.9; // sedikit margin
  const zoom = maxWidth / DEFAULT_W;
  currentZoom = Math.min(zoom, 1.0); // maksimal 100%
  rescaleAll();
  updateZoomLabel();
  function rescaleAll(){
  const pages = document.querySelectorAll('.page');
  pages.forEach(pg=>{
    pg.style.width = (DEFAULT_W * currentZoom) + 'px';
    pg.style.height = (DEFAULT_H * currentZoom) + 'px';
    pg.style.transform = `scale(${currentZoom})`;
    
  });

}


}


</script>
</body>
</html>
