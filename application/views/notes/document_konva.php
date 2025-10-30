<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Editor PDF - OKRE Sketch</title>

<!-- Font Awesome 6 (ikon profesional) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f5f5f5;
    display: flex;
    height: 100vh;
    overflow: hidden;
  }

  /* === Toolbar kiri === */
  #sidebar {
    width: 260px;
    background: #1f1f1f;
    color: #fff;
    display: flex;
    flex-direction: column;
    padding: 15px;
    gap: 10px;
    overflow-y: auto;
    box-shadow: 2px 0 8px rgba(0,0,0,0.3);
  }

  #sidebar h3 {
    margin: 0 0 10px;
    color: #4caf50;
    text-align: center;
    font-weight: 600;
  }

  #sidebar label {
    font-size: 13px;
    margin-bottom: 2px;
    display: block;
  }

  #sidebar select, 
  #sidebar input[type="color"], 
  #sidebar input[type="range"], 
  #sidebar button {
    width: 100%;
    padding: 7px 10px;
    border-radius: 6px;
    border: none;
    margin-bottom: 6px;
    box-sizing: border-box;
    font-size: 14px;
  }

  #sidebar button {
    background: #333;
    color: white;
    font-weight: 500;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  #sidebar button:hover {
    background: #4caf50;
    transform: scale(1.03);
  }

  #sidebar i {
    font-size: 15px;
  }

  #sidebar #zoomPercent {
    color: #0f0;
    font-weight: bold;
    text-align: center;
    display: block;
    margin: 4px 0;
  }

  /* === Area Dokumen kanan === */
  #main-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ddd;
    overflow: hidden;
  }

  #container {
    flex: 1;
    overflow: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
  }

  .page {
    position: relative;
    margin: 10px 0;
    background: #fff;
    box-shadow: 0 0 6px rgba(0,0,0,0.25);
  }

  .page canvas {
    display: block;
  }

  /* === Progress bar === */
  #progressBar {
    position: absolute;
    top: 0;
    left: 0;
    height: 6px;
    width: 100%;
    background: #333;
    z-index: 100;
  }

  #progressFill {
    height: 100%;
    width: 0;
    background: #4caf50;
    transition: width 0.15s;
  }

  /* === Responsif === */
  @media(max-width: 900px){
    body { flex-direction: column; }
    #sidebar { 
      width: 100%; 
      flex-direction: row; 
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 10px;
    }
    #main-area { height: calc(100vh - 180px); }
    #sidebar h3 { display: none; }
  }
</style>
</head>

<body>

<!-- === Toolbar kiri === -->
<div id="sidebar">
  <h3><i class="fa-solid fa-screwdriver-wrench"></i> Tools</h3>

  <label><i class="fa-solid fa-pencil"></i> Alat:</label>
  <select id="toolSelect">
    <option value="brush">Brush</option>
    <option value="eraser">Eraser</option>
  </select>

  <label><i class="fa-solid fa-palette"></i> Warna:</label>
  <input type="color" id="colorPicker" value="#ff0000">

  <label><i class="fa-solid fa-sliders"></i> Ukuran:</label>
  <input type="range" id="sizePicker" min="1" max="30" value="4">

  <button id="undoBtn"><i class="fa-solid fa-rotate-left"></i> Undo</button>
  <button id="redoBtn"><i class="fa-solid fa-rotate-right"></i> Redo</button>

  <button id="zoomInBtn"><i class="fa-solid fa-magnifying-glass-plus"></i> Zoom +</button>
  <span id="zoomPercent">100%</span>
  <button id="zoomOutBtn"><i class="fa-solid fa-magnifying-glass-minus"></i> Zoom −</button>

  <button id="panToggleBtn"><i class="fa-solid fa-arrows-up-down-left-right"></i> Pan Mode: OFF</button>
  <button id="clearBtn"><i class="fa-solid fa-broom"></i> Hapus Coretan</button>
  <button id="toggleLayoutBtn"><i class="fa-solid fa-columns"></i> Tampilan: Vertikal</button>

  <hr style="border-color:#444; width:100%;">

  <button id="savePdfBtn"><i class="fa-solid fa-file-pdf"></i> Download PDF</button>
  <button id="saveServerBtn"><i class="fa-solid fa-cloud-arrow-up"></i> Simpan ke Server</button>
  <button id="downloadJpgBtn"><i class="fa-solid fa-image"></i> Download JPG</button>
</div>

<!-- === Area Dokumen kanan === -->
<div id="main-area">
  <div id="progressBar"><div id="progressFill"></div></div>
  <div id="container"></div>
</div>

<!-- === Script utama tetap sama === -->
<script src="<?= base_url('assets/js/pdf.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pdf-lib.min.js') ?>"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = "<?= base_url('assets/js/pdf.worker.min.js') ?>";
</script>

<script>
const pdfUrl = "<?= base_url('index.php/notes/view_pdf/'.$filename) ?>";
const container = document.getElementById('container');
const progressBar = document.getElementById('progressBar');
const progressFill = document.getElementById('progressFill');

let tool='brush', color='#ff0000', size=4;
let pdfDoc=null, pageStates=[];
let panMode=false;

/* ==== ZOOM KONFIGURASI ==== */
const zoomLevels = [1.0, 1.25, 1.5, 1.75, 2.0];
let currentZoomIndex = 0;
let scale = zoomLevels[currentZoomIndex];
const zoomPercentLabel = document.getElementById('zoomPercent');
function updateZoomLabel(){
  const percent = ((zoomLevels[currentZoomIndex] / zoomLevels[0]) * 100);
  zoomPercentLabel.textContent = percent.toFixed(0) + '%';
}

/* Progress Bar */
function showProgress(){progressBar.style.display='block';progressFill.style.width='0%';}
function setProgress(p){progressFill.style.width=Math.max(0,Math.min(100,p))+'%';}
function hideProgress(){setTimeout(()=>{progressBar.style.display='none';},250);}

/* Toolbar events */
document.getElementById('toolSelect').onchange = e => tool = e.target.value;
document.getElementById('colorPicker').onchange = e => color = e.target.value;
document.getElementById('sizePicker').oninput = e => size = Number(e.target.value);

/* Render semua halaman PDF */
async function renderAllPages(restore=true){
  showProgress(); setProgress(5);
  container.innerHTML=''; pageStates = pageStates || [];

  if(!pdfDoc){
    const loading = pdfjsLib.getDocument({url:pdfUrl});
    pdfDoc = await loading.promise;
  }

  const num = pdfDoc.numPages;
  for(let i=1;i<=num;i++){
    setProgress(10 + Math.floor((i/num)*70));
    const page = await pdfDoc.getPage(i);
    const viewport = page.getViewport({scale});

    const pageDiv = document.createElement('div');
    pageDiv.className = 'page';
    pageDiv.style.width = viewport.width+'px';
    pageDiv.style.height = viewport.height+'px';
    container.appendChild(pageDiv);

    const pdfCanvas = document.createElement('canvas');
    pdfCanvas.width = viewport.width;
    pdfCanvas.height = viewport.height;
    pageDiv.appendChild(pdfCanvas);
    const ctx = pdfCanvas.getContext('2d',{willReadFrequently:true});
    await page.render({canvasContext:ctx,viewport}).promise;

    const drawCanvas = document.createElement('canvas');
    drawCanvas.classList.add('draw-layer');
    drawCanvas.width = viewport.width;
    drawCanvas.height = viewport.height;
    drawCanvas.style.position='absolute';
    drawCanvas.style.left='0';
    drawCanvas.style.top='0';
    pageDiv.appendChild(drawCanvas);

    if(!pageStates[i-1]) pageStates[i-1]={dataURL:null,undoStack:[],redoStack:[]};
    if(restore && pageStates[i-1].dataURL){
      const img = new Image(); img.src = pageStates[i-1].dataURL;
      await new Promise(r=>img.onload=r);
      const dctx = drawCanvas.getContext('2d');
      dctx.clearRect(0,0,drawCanvas.width,drawCanvas.height);
      dctx.drawImage(img,0,0,drawCanvas.width,drawCanvas.height);
    }

    enableDrawingOnCanvas(drawCanvas,i-1);
  }
  setProgress(100); hideProgress();
  updateZoomLabel();
}

/* ==== Drawing + Undo/Redo ==== */
function enableDrawingOnCanvas(canvas, pageIndex) {
  const ctx = canvas.getContext('2d');
  ctx.lineJoin = 'round';
  ctx.lineCap = 'round';

  if (!pageStates[pageIndex]) pageStates[pageIndex] = { dataURL: null, undoStack: [], redoStack: [] };

  let drawing = false, last = { x: 0, y: 0 }, hasDrawn = false;

  function getPos(e) {
    const rect = canvas.getBoundingClientRect();
    const t = e.touches ? e.touches[0] : e;
    return { x: (t.clientX - rect.left), y: (t.clientY - rect.top) };
  }

  // ===== FIX: push snapshot sebelum mulai menggambar / menghapus =====
  function saveSnapshotToUndo() {
    const s = pageStates[pageIndex];
    try {
      const snap = canvas.toDataURL();
      s.undoStack.push(snap);
      if (s.undoStack.length > 25) s.undoStack.shift();
      s.redoStack = [];
    } catch (err) { console.error(err); }
  }

  const start = e => {
    if (panMode) return;
    e.preventDefault();
    drawing = true;
    hasDrawn = false;
    last = getPos(e);
    saveSnapshotToUndo(); // simpan keadaan sebelum mulai menggambar/hapus
  };

  const move = e => {
    if (!drawing || panMode) return;
    e.preventDefault();
    const pos = getPos(e);
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
    if (!drawing) return;
    drawing = false;
    ctx.globalCompositeOperation = 'source-over';
    if (hasDrawn) {
      try { pageStates[pageIndex].dataURL = canvas.toDataURL(); } catch (err) {}
    }
  };

  canvas.addEventListener('mousedown', start);
  canvas.addEventListener('mousemove', move);
  canvas.addEventListener('mouseup', end);
  canvas.addEventListener('mouseout', end);
  canvas.addEventListener('touchstart', start);
  canvas.addEventListener('touchmove', move);
  canvas.addEventListener('touchend', end);

  // ===== UNDO & REDO =====
  canvas._doUndo = function () {
    const s = pageStates[pageIndex];
    if (!s.undoStack.length) return;
    const prev = s.undoStack.pop(); // ambil keadaan sebelumnya
    const current = canvas.toDataURL();
    s.redoStack.push(current);
    const img = new Image();
    img.onload = () => {
      ctx.globalCompositeOperation = 'source-over'; // penting: cegah eraser mode aktif
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      s.dataURL = prev;
    };
    img.src = prev;
  };

  canvas._doRedo = function () {
    const s = pageStates[pageIndex];
    if (!s.redoStack.length) return;
    const redo = s.redoStack.pop();
    const current = canvas.toDataURL();
    s.undoStack.push(current);
    const img = new Image();
    img.onload = () => {
      ctx.globalCompositeOperation = 'source-over';
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      s.dataURL = redo;
    };
    img.src = redo;
  };
}


/* Undo/Redo tombol */
document.getElementById('undoBtn').onclick = ()=>{
  const c=getFocusedDrawCanvas(); if(c&&c._doUndo)c._doUndo();
};
document.getElementById('redoBtn').onclick = ()=>{
  const c=getFocusedDrawCanvas(); if(c&&c._doRedo)c._doRedo();
};
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

/* Hapus semua coretan */
document.getElementById('clearBtn').onclick=()=>{
  document.querySelectorAll('canvas.draw-layer').forEach((c,i)=>{
    c.getContext('2d').clearRect(0,0,c.width,c.height);
    if(pageStates[i]){pageStates[i].dataURL=null;pageStates[i].undoStack=[];pageStates[i].redoStack=[];}
  });
  alert('✅ Semua coretan dihapus.');
};

/* Zoom */
function captureAllDrawsToStates(){
  document.querySelectorAll('.page').forEach((p,i)=>{
    const d=p.querySelector('canvas.draw-layer');
    if(!pageStates[i])pageStates[i]={dataURL:null,undoStack:[],redoStack:[]};
    pageStates[i].dataURL=d.toDataURL();
  });
}
document.getElementById('zoomInBtn').onclick=async()=>{
  if(currentZoomIndex<zoomLevels.length-1){
    captureAllDrawsToStates();
    currentZoomIndex++;
    scale=zoomLevels[currentZoomIndex];
    updateZoomLabel();
    await renderAllPages(true);
  }
};
document.getElementById('zoomOutBtn').onclick=async()=>{
  if(currentZoomIndex>0){
    captureAllDrawsToStates();
    currentZoomIndex--;
    scale=zoomLevels[currentZoomIndex];
    updateZoomLabel();
    await renderAllPages(true);
  }
};

/* Pan mode */
const panBtn=document.getElementById('panToggleBtn');
let isPanning=false,startPan={x:0,y:0},scrollStart={x:0,y:0};
panBtn.onclick=()=>{
  panMode=!panMode;
  panBtn.textContent='Pan Mode: '+(panMode?'ON':'OFF');
  container.style.cursor=panMode?'grab':'default';
};
container.addEventListener('mousedown',e=>{
  if(!panMode)return;
  isPanning=true; container.style.cursor='grabbing';
  startPan={x:e.clientX,y:e.clientY};
  scrollStart={x:container.scrollLeft,y:container.scrollTop};
});
container.addEventListener('mousemove',e=>{
  if(!isPanning)return;
  const dx=e.clientX-startPan.x;
  const dy=e.clientY-startPan.y;
  container.scrollLeft=scrollStart.x-dx;
  container.scrollTop=scrollStart.y-dy;
});
container.addEventListener('mouseup',()=>{isPanning=false;container.style.cursor='grab';});

/* Layout Toggle */
document.getElementById('toggleLayoutBtn').onclick=()=>{
  const isVertical=container.style.flexDirection!=='row';
  container.style.flexDirection=isVertical?'row':'column';
  container.style.alignItems=isVertical?'flex-start':'center';
  document.querySelectorAll('.page').forEach(p=>p.style.margin=isVertical?'0 10px':'10px 0');
  container.style.overflowX='auto';
  container.style.overflowY='auto';
  document.getElementById('toggleLayoutBtn').textContent='Tampilan: '+(isVertical?'Horizontal':'Vertikal');
};

/* Simpan / Download PDF */
async function generateAnnotatedPdfBytes(onProgress=null){
  const pages=document.querySelectorAll('.page');
  const doc=await PDFLib.PDFDocument.create();
  for(let i=0;i<pages.length;i++){
    const base=pages[i].querySelector('canvas:not(.draw-layer)');
    const draw=pages[i].querySelector('canvas.draw-layer');
    const merged=document.createElement('canvas');
    merged.width=base.width; merged.height=base.height;
    const ctx=merged.getContext('2d');
    ctx.drawImage(base,0,0); ctx.drawImage(draw,0,0);
    const imgData=merged.toDataURL('image/png');
    const page=doc.addPage([merged.width,merged.height]);
    const png=await doc.embedPng(imgData);
    page.drawImage(png,{x:0,y:0,width:merged.width,height:merged.height});
    if(onProgress)onProgress(Math.round(((i+1)/pages.length)*100));
  }
  return await doc.save();
}

document.getElementById('savePdfBtn').onclick=async()=>{
  showProgress();setProgress(5);
  const bytes=await generateAnnotatedPdfBytes(p=>setProgress(5+Math.round(p*0.8)));
  setProgress(95);
  const blob=new Blob([bytes],{type:'application/pdf'});
  const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='annotated.pdf';a.click();
  hideProgress();
};

document.getElementById('saveServerBtn').onclick=async()=>{
  try{
    showProgress();setProgress(5);
    const bytes=await generateAnnotatedPdfBytes(p=>setProgress(5+Math.round(p*0.8)));
    setProgress(80);
    const blob=new Blob([bytes],{type:'application/pdf'});
    const form=new FormData();
    form.append('pdf_file',blob,'annotated_'+Date.now()+'.pdf');
    const res=await fetch("<?= base_url('index.php/notes/save_pdf_server') ?>",{method:'POST',body:form});
    const json=await res.json();
    setProgress(100);hideProgress();
    if(json.status==='success')alert('✅ PDF berhasil disimpan:\n'+json.file);
    else alert('❌ Gagal simpan: '+(json.message||'unknown'));
  }catch(err){hideProgress();console.error(err);alert('⚠️ Error simpan ke server');}
};

/* ==== Download JPG ==== */
document.getElementById('downloadJpgBtn').onclick = async () => {
  const choice = prompt(
    '📸 Pilih halaman yang ingin diunduh sebagai JPG:\n' +
    '- Ketik nomor halaman (contoh: 1,3,5)\n' +
    '- Ketik "all" untuk semua halaman'
  );
  if (!choice) return;

  const pages = document.querySelectorAll('.page');
  const indices = [];

  if (choice.toLowerCase() === 'all') {
    // Satukan semua halaman jadi satu gambar panjang
    let totalHeight = 0;
    let maxWidth = 0;
    const canvases = [];

    for (let p of pages) {
      const base = p.querySelector('canvas:not(.draw-layer)');
      const draw = p.querySelector('canvas.draw-layer');
      const merged = document.createElement('canvas');
      merged.width = base.width;
      merged.height = base.height;
      const ctx = merged.getContext('2d');
      ctx.drawImage(base, 0, 0);
      ctx.drawImage(draw, 0, 0);
      canvases.push(merged);
      totalHeight += merged.height;
      if (merged.width > maxWidth) maxWidth = merged.width;
    }

    const finalCanvas = document.createElement('canvas');
    finalCanvas.width = maxWidth;
    finalCanvas.height = totalHeight;
    const fctx = finalCanvas.getContext('2d');

    let y = 0;
    for (let c of canvases) {
      fctx.drawImage(c, 0, y);
      y += c.height;
    }

    const link = document.createElement('a');
    link.href = finalCanvas.toDataURL('image/jpeg', 0.9);
    link.download = 'semua_halaman.jpg';
    link.click();
    alert('✅ Semua halaman berhasil digabung dan diunduh!');
    return;
  } else {
    // Halaman tertentu
    const parts = choice.split(',').map(x => parseInt(x.trim(), 10)).filter(n => !isNaN(n));
    if (!parts.length) {
      alert('⚠️ Nomor halaman tidak valid.');
      return;
    }

    for (let n of parts) {
      if (n < 1 || n > pages.length) continue;
      const base = pages[n - 1].querySelector('canvas:not(.draw-layer)');
      const draw = pages[n - 1].querySelector('canvas.draw-layer');
      const merged = document.createElement('canvas');
      merged.width = base.width;
      merged.height = base.height;
      const ctx = merged.getContext('2d');
      ctx.drawImage(base, 0, 0);
      ctx.drawImage(draw, 0, 0);
      const link = document.createElement('a');
      link.href = merged.toDataURL('image/jpeg', 0.9);
      link.download = 'halaman_' + n + '.jpg';
      link.click();
    }
    alert('✅ Halaman JPG berhasil diunduh.');
  }
};


/* Load awal */
(async()=>{
  try{
    const loading=pdfjsLib.getDocument({url:pdfUrl});
    pdfDoc=await loading.promise;
    await renderAllPages(false);
  }catch(e){console.error(e);alert('Gagal memuat PDF.');}
})();
</script>
</body>
</html>
