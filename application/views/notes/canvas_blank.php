<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>OKRE Sketch — Mobile Friendly</title>
<script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<style>
:root {
  --blue:#3b82f6; --blue-dark:#2563eb;
  --bg:#f8fafc; --surface:#fff;
  --text:#1e293b; --muted:#64748b;
  --shadow:0 4px 16px rgba(0,0,0,0.06);
}
body.dark { --bg:#0f172a; --surface:#1e293b; --text:#e2e8f0; --muted:#94a3b8; }
*{box-sizing:border-box;}
body{margin:0;font-family:"Inter",sans-serif;color:var(--text);background:var(--bg);display:flex;height:100vh;overflow:hidden;}

/* Sidebar */
#sidebar{width:200px;background:var(--surface);display:flex;flex-direction:column;border-right:1px solid rgba(0,0,0,0.05);}
.brand{display:flex;align-items:center;gap:8px;padding:12px;border-bottom:1px solid rgba(0,0,0,0.05);}
.brand .logo{width:32px;height:32px;background:var(--blue);color:#fff;font-weight:700;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:16px;}
.thumbs{flex:1;overflow:auto;padding:8px;display:flex;flex-direction:column;gap:8px;}
.thumb-item{background:var(--surface);border:1px solid rgba(0,0,0,0.08);border-radius:6px;cursor:pointer;transition:all .2s;overflow:hidden;}
.thumb-item:hover{border-color:var(--blue);}
.thumb-item.selected{border-color:var(--blue);box-shadow:0 0 0 2px rgba(59,130,246,0.3);}
.thumb-canvas{width:100%;height:80px;background:#fff;display:block;}
.thumb-meta{font-size:11px;color:var(--muted);padding:2px 4px;text-align:center;}

/* Main */
#main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
.toolbar{display:flex;align-items:center;flex-wrap:wrap;padding:6px 12px;background:var(--surface);box-shadow: var(--shadow);gap:4px;}
.tools{display:flex;gap:4px;align-items:center;flex-wrap:wrap;}
.tool-btn{width:32px;height:32px;border:none;border-radius:6px;background:transparent;color:var(--text);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;font-size:16px;}
.tool-btn:hover{background:rgba(59,130,246,0.1);color:var(--blue-dark);}
.tool-btn.active{background:var(--blue);color:#fff;}
#pagesContainer{flex:1;overflow:auto;display:flex;flex-direction:column;align-items:center;padding:16px;background:var(--bg);}
.page{width:100%;max-width:900px;height:600px;background:#fff;box-shadow: var(--shadow);border-radius:6px;margin-bottom:16px;position:relative;}
.canvas-el{width:100%;height:100%;border-radius:6px;touch-action:none;}
.page-num{position:absolute;bottom:6px;right:8px;background:rgba(0,0,0,0.05);font-size:11px;color:#555;padding:2px 6px;border-radius:4px;}

/* Modal */
#downloadModal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);justify-content:center;align-items:center;z-index:2000;}
#downloadModal .modal-content{background:#fff;border-radius:8px;max-width:360px;width:90%;padding:16px;position:relative;}
#downloadModal h3{margin-top:0;}
#pageSelector{margin-top:10px; display:none; max-height:200px; overflow:auto;font-size:13px;}
</style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
  <div class="brand"><div class="logo">OK</div>
    <div><strong>OKRE Sketch</strong><br><span style="font-size:10px;color:var(--muted)">Kanvas Multi</span></div>
  </div>
  <div class="thumbs" id="thumbs"></div>
  <div style="padding:8px;display:flex;gap:4px;flex-wrap:wrap;">
    <button id="addAbove" class="tool-btn" title="Tambah Halaman Atas">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14m7-7H5"/></svg>
    </button>
    <button id="addBelow" class="tool-btn" title="Tambah Halaman Bawah">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14m7-7H5"/></svg>
    </button>
    <button id="downloadDropdownBtn" class="tool-btn" title="Download">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14m0 0l-7-7m7 7l7-7"/></svg>
    </button>
    <button id="toggleTheme" class="tool-btn" title="Toggle Mode">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="5"/><path d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.95 7.07l-1.41-1.41M6.34 6.34L4.93 4.93m12.02 0l-1.41 1.41M6.34 17.66l-1.41 1.41"/></svg>
    </button>
  </div>
</div>

<!-- Main -->
<div id="main">
  <div class="toolbar">
    <div class="tools">
      <button id="undoBtn" class="tool-btn" title="Undo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 7v6h6"/><path d="M3 13a9 9 0 1 0 9-9"/></svg>
      </button>
      <button id="redoBtn" class="tool-btn" title="Redo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 7v6h-6"/><path d="M21 13a9 9 0 1 1-9-9"/></svg>
      </button>
      <button id="zoomIn" class="tool-btn" title="Zoom In">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M11 8v6m3-3H8"/></svg>
      </button>
      <button id="zoomOut" class="tool-btn" title="Zoom Out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M8 11h6"/></svg>
      </button>
    </div>
    <div class="tools">
      <button id="brushBtn" class="tool-btn active" title="Brush">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 18a2 2 0 0 0 2 2h4l8-8-4-4-8 8v4z"/></svg>
      </button>
      <button id="eraserBtn" class="tool-btn" title="Eraser">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 17l6 6h12l-6-6M3 17l9-9 6 6M3 17l9-9"/></svg>
      </button>
      <input type="color" id="colorPicker" title="Warna" style="width:32px;height:32px;border:none;padding:0;margin:0;border-radius:6px;">
      <input type="range" id="sizePicker" min="1" max="30" value="4" style="width:80px;">
      <button id="panToggleBtn" class="tool-btn" title="Pan Mode">✋</button>
      <button id="clearBtn" class="tool-btn" title="Hapus Coretan">🧹</button>
      <button id="saveServerBtn" class="tool-btn" title="Simpan ke Server">☁️</button>
    </div>
  </div>
  <div id="pagesContainer"></div>
</div>

<!-- Download Modal -->
<div id="downloadModal">
  <div class="modal-content">
    <h3>Download</h3>
    <div>
      <label><input type="radio" name="fileFormat" value="pdf" checked> PDF</label>
      <label><input type="radio" name="fileFormat" value="jpg"> JPG</label>
    </div>
    <div style="margin-top:10px;">
      <label><input type="radio" name="downloadChoice" value="all" checked> Gabung Semua Halaman</label><br>
      <label><input type="radio" name="downloadChoice" value="perpage"> Per Halaman</label>
    </div>
    <div id="pageSelector"></div>
    <div style="margin-top:12px;text-align:right;">
      <button id="cancelDownload" style="margin-right:8px;">Batal</button>
      <button id="confirmDownload">Download</button>
    </div>
  </div>
</div>

<script>
const { PDFDocument } = PDFLib;
let pages=[], currentIndex=0, tool='brush', color='#000', size=3, zoom=1, panMode=false;
const thumbs=document.getElementById('thumbs'), container=document.getElementById('pagesContainer');

function createPage(){
  const div=document.createElement('div'); div.className='page';
  const canvas=document.createElement('canvas'); canvas.className='canvas-el'; canvas.width=900; canvas.height=600;
  div.appendChild(canvas);
  const num=document.createElement('div'); num.className='page-num'; num.textContent='Halaman '+(pages.length+1);
  div.appendChild(num); container.appendChild(div);
  const ctx=canvas.getContext('2d'); ctx.fillStyle='#fff'; ctx.fillRect(0,0,canvas.width,canvas.height);
  const pageObj={canvas,ctx,undo:[],redo:[]}; pages.push(pageObj);
  attachDrawing(pageObj); updateThumbs();
}
function attachDrawing(page){
  const c=page.canvas, ctx=page.ctx; let drawing=false,last={x:0,y:0};
  ctx.lineCap='round'; ctx.lineJoin='round';
  function pos(e){const r=c.getBoundingClientRect(); const t=e.touches?e.touches[0]:e; return {x:(t.clientX-r.left)/zoom,y:(t.clientY-r.top)/zoom};}
  function saveSnap(){page.undo.push(c.toDataURL()); if(page.undo.length>30) page.undo.shift(); page.redo=[];}
  c.addEventListener('mousedown',e=>{drawing=true;last=pos(e);saveSnap();});
  c.addEventListener('mousemove',e=>{if(!drawing)return; const p=pos(e); ctx.globalCompositeOperation=tool==='eraser'?'destination-out':'source-over'; ctx.strokeStyle=color; ctx.lineWidth=size; ctx.beginPath(); ctx.moveTo(last.x,last.y); ctx.lineTo(p.x,p.y); ctx.stroke(); last=p;});
  window.addEventListener('mouseup',()=>drawing=false);
  c.addEventListener('touchstart',e=>{drawing=true;last=pos(e);saveSnap();},{passive:false});
  c.addEventListener('touchmove',e=>{if(!drawing)return; const p=pos(e); ctx.globalCompositeOperation=tool==='eraser'?'destination-out':'source-over'; ctx.strokeStyle=color; ctx.lineWidth=size; ctx.beginPath(); ctx.moveTo(last.x,last.y); ctx.lineTo(p.x,p.y); ctx.stroke(); last=p; e.preventDefault();},{passive:false});
  c.addEventListener('touchend',()=>drawing=false);
}
function updateThumbs(){
  thumbs.innerHTML='';
  pages.forEach((p,i)=>{
    const t=document.createElement('div'); t.className='thumb-item'+(i===currentIndex?' selected':'');
    const tc=document.createElement('canvas'); tc.className='thumb-canvas'; tc.width=140; tc.height=80;
    tc.getContext('2d').drawImage(p.canvas,0,0,tc.width,tc.height);
    const meta=document.createElement('div'); meta.className='thumb-meta'; meta.textContent='Hal '+(i+1);
    t.appendChild(tc); t.appendChild(meta);
    t.onclick=()=>{currentIndex=i;focusPage();};
    thumbs.appendChild(t);
  });
}
function focusPage(){document.querySelectorAll('.thumb-item').forEach((t,idx)=>{t.classList.toggle('selected',idx===currentIndex);}); container.children[currentIndex].scrollIntoView({behavior:'smooth',block:'center'});}

// TOOL SELECTION
document.getElementById('brushBtn').onclick=()=>{tool='brush';setActive('brushBtn');};
document.getElementById('eraserBtn').onclick=()=>{tool='eraser';setActive('eraserBtn');};
function setActive(id){document.querySelectorAll('.tool-btn').forEach(b=>b.classList.remove('active'));document.getElementById(id).classList.add('active');}
document.getElementById('colorPicker').onchange=e=>color=e.target.value;
document.getElementById('sizePicker').oninput=e=>size=Number(e.target.value);

// UNDO/REDO
document.getElementById('undoBtn').onclick=()=>{ const p=pages[currentIndex]; if(!p.undo.length)return; const prev=p.undo.pop(); p.redo.push(p.canvas.toDataURL()); const img=new Image(); img.onload=()=>p.ctx.drawImage(img,0,0); img.src=prev; };
document.getElementById('redoBtn').onclick=()=>{ const p=pages[currentIndex]; if(!p.redo.length)return; const next=p.redo.pop(); p.undo.push(p.canvas.toDataURL()); const img=new Image(); img.onload=()=>p.ctx.drawImage(img,0,0); img.src=next; };

// ZOOM
document.getElementById('zoomIn').onclick=()=>{zoom=Math.min(2,zoom+0.25); applyZoom();};
document.getElementById('zoomOut').onclick=()=>{zoom=Math.max(0.5,zoom-0.25); applyZoom();};
function applyZoom(){container.style.transform='scale('+zoom+')'; container.style.transformOrigin='center top';}

// PAN MODE
document.getElementById('panToggleBtn').onclick=()=>{panMode=!panMode; document.getElementById('panToggleBtn').textContent=panMode?'✋ ON':'✋ OFF'; container.style.cursor=panMode?'grab':'default';}
let isPanning=false,startPan={x:0,y:0},scrollStart={x:0,y:0};
container.addEventListener('mousedown',e=>{if(!panMode)return; isPanning=true; startPan={x:e.clientX,y:e.clientY}; scrollStart={x:container.scrollLeft,y:container.scrollTop}; container.style.cursor='grabbing';});
container.addEventListener('mousemove',e=>{if(!isPanning)return; const dx=e.clientX-startPan.x,dy=e.clientY-startPan.y; container.scrollLeft=scrollStart.x-dx; container.scrollTop=scrollStart.y-dy;});
container.addEventListener('mouseup',()=>{isPanning=false; if(panMode) container.style.cursor='grab';});

// CLEAR
document.getElementById('clearBtn').onclick=()=>{
  pages.forEach(p=>{p.ctx.clearRect(0,0,p.canvas.width,p.canvas.height); p.undo=[]; p.redo=[];});
  alert('✅ Semua coretan dihapus');
};

// ADD PAGE
document.getElementById('addAbove').onclick=()=>{addPage(currentIndex);}
document.getElementById('addBelow').onclick=()=>{addPage(currentIndex+1);}
function addPage(pos){
  const newPage={canvas:document.createElement('canvas'),ctx:null,undo:[],redo:[]};
  newPage.canvas.width=900; newPage.canvas.height=600;
  newPage.ctx=newPage.canvas.getContext('2d'); newPage.ctx.fillStyle='#fff'; newPage.ctx.fillRect(0,0,900,600);
  pages.splice(pos,0,newPage); rebuild();
}
function rebuild(){
  container.innerHTML='';
  pages.forEach((p,i)=>{
    const div=document.createElement('div'); div.className='page';
    const canvas=document.createElement('canvas'); canvas.className='canvas-el'; canvas.width=900; canvas.height=600;
    canvas.getContext('2d').drawImage(p.canvas,0,0); div.appendChild(canvas);
    const num=document.createElement('div'); num.className='page-num'; num.textContent='Halaman '+(i+1); div.appendChild(num);
    container.appendChild(div); p.canvas=canvas; p.ctx=canvas.getContext('2d'); attachDrawing(p);
  }); updateThumbs();
}

// THEME
document.getElementById('toggleTheme').onclick=()=>{document.body.classList.toggle('dark');};

// DOWNLOAD MODAL
const modal=document.getElementById('downloadModal'), pageSelector=document.getElementById('pageSelector');
document.getElementById('downloadDropdownBtn').onclick=()=>{modal.style.display='flex'; pageSelector.style.display='none';};
document.getElementById('cancelDownload').onclick=()=>{modal.style.display='none';};
modal.querySelectorAll('input[name="downloadChoice"]').forEach(radio=>{
  radio.onchange=()=>{ pageSelector.style.display=radio.value==='perpage'?'block':'none'; if(radio.value==='perpage'){ pageSelector.innerHTML=''; pages.forEach((p,i)=>{ const div=document.createElement('div'); div.innerHTML=`<label><input type="checkbox" value="${i}" checked> Halaman ${i+1}</label>`; pageSelector.appendChild(div); }); } }
});
document.getElementById('confirmDownload').onclick=async()=>{
  const format=modal.querySelector('input[name="fileFormat"]:checked').value;
  const choice=modal.querySelector('input[name="downloadChoice"]:checked').value;
  let selectedPages=[];
  if(choice==='all'){ selectedPages=pages.slice(); } 
  else{ const checkboxes=pageSelector.querySelectorAll('input[type="checkbox"]:checked'); selectedPages=Array.from(checkboxes).map(cb=>pages[parseInt(cb.value)]); if(selectedPages.length===0){alert('⚠️ Pilih minimal 1 halaman'); return;} }
  modal.style.display='none';
  if(format==='pdf'){ await exportPdf(selectedPages, choice==='all'?'okre_sketch.pdf':'selected_pages.pdf'); }
  else{ for(let p of selectedPages){ const idx=pages.indexOf(p); await exportJpgSingle(idx); } }
};

// EXPORT PDF
async function exportPdf(selected,filename){
  const pdfDoc=await PDFDocument.create();
  for(let i=0;i<selected.length;i++){
    const imgData=selected[i].canvas.toDataURL('image/png');
    const page=pdfDoc.addPage([selected[i].canvas.width,selected[i].canvas.height]);
    const png=await pdfDoc.embedPng(imgData);
    page.drawImage(png,{x:0,y:0,width:selected[i].canvas.width,height:selected[i].canvas.height});
  }
  const pdfBytes=await pdfDoc.save();
  const blob=new Blob([pdfBytes],{type:'application/pdf'});
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=filename; a.click();
}

// EXPORT JPG
async function exportJpgSingle(idx){
  const dataUrl=pages[idx].canvas.toDataURL('image/jpeg',0.95);
  const a=document.createElement('a'); a.href=dataUrl; a.download='page_'+(idx+1)+'.jpg'; a.click();
}

// SAVE TO SERVER (placeholder)
document.getElementById('saveServerBtn').onclick=()=>{alert('📤 Fitur Simpan ke Server belum diimplementasikan.');}

// INIT
createPage();
</script>
</body>
</html>
