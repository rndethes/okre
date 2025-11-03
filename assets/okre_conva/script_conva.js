
(function () {
'use strict';

/* ========== PDF.js Setup ========== */
pdfjsLib = window['pdfjs-dist/build/pdf'];
// Gunakan CDN langsung agar worker selalu tersedia
pdfjsLib.GlobalWorkerOptions.workerSrc = 
  'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';


/* ========== SAFE DOM HOOKS ========== */
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

const zoomPercentLabel = document.getElementById('zoomPercent');
const colorPicker = document.getElementById('colorPicker');
const colorPicker2 = document.getElementById('colorPicker2');
const sizePicker = document.getElementById('sizePicker');
const drawModeSelect = document.getElementById('drawMode');
const quickBrush = document.getElementById('quickBrush');
const quickEraser = document.getElementById('quickEraser');
const panToggleBtn = document.getElementById('panToggleBtn');

const undoBtn = document.getElementById('btnUndo');
const redoBtn = document.getElementById('btnRedo');
const zoomInBtn = document.getElementById('zoomInBtn');
const zoomOutBtn = document.getElementById('zoomOutBtn');
const fitBtn = document.getElementById('fitBtn');
const btnClear = document.getElementById('btnClear');
const savePdfBtn = document.getElementById('savePdfBtn');
const saveServerBtn = document.getElementById('saveServerBtn');
const downloadJpgBtn = document.getElementById('downloadJpgBtn');
const downloadTopBtn = document.getElementById('downloadTopBtn');
const downloadDropdown = document.getElementById('downloadDropdown');
const saveServerTopBtn = document.getElementById('saveServerTopBtn');

const pdfUrl = window.pdfUrl || '';

/* ========== STATE ========== */
let pdfDoc = null;
let pageStates = []; // per-page: { dataURL, undoStack, redoStack }
let scale = 1.0;
const zoomLevels = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
let currentZoomIndex = 2; // default 1.0
let panMode = false;
let tool = 'brush';
let color = '#000000ff';
let size = 4;

let isRendering = false;

/* ========== HELPERS: THEME / PROGRESS / POPUPS ========== */
function setThemeLight() {
  document.getElementById('appRoot')?.classList.remove('theme-dark');
  document.documentElement.style.setProperty('--blue-500', '#1976d2');
  document.documentElement.style.setProperty('--blue-600', '#1565c0');
  document.documentElement.style.setProperty('--sidebar-bg', 'linear-gradient(180deg,var(--card),#f0f7ff)');
}
function setThemeDark() {
  document.getElementById('appRoot')?.classList.add('theme-dark');
}
function setThemeCustom(hex) {
  function darken(hex, amt) {
    const c = hex.replace('#', '');
    const num = parseInt(c, 16);
    let r = (num >> 16) - amt; if (r < 0) r = 0;
    let g = ((num >> 8) & 0x00FF) - amt; if (g < 0) g = 0;
    let b = (num & 0x0000FF) - amt; if (b < 0) b = 0;
    return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
  }
  document.documentElement.style.setProperty('--blue-500', hex);
  document.documentElement.style.setProperty('--blue-600', darken(hex, 20));
  document.getElementById('appRoot')?.classList.remove('theme-dark');
}

function showProgress() { if (progressBar && progressFill) { progressBar.style.display = 'block'; progressFill.style.width = '0%'; } }
function setProgress(p) { if (progressFill) progressFill.style.width = Math.max(0, Math.min(100, p)) + '%'; }
function hideProgress() { if (progressBar) setTimeout(() => { progressBar.style.display = 'none'; }, 200); }

function hideAllPopups() {
  document.querySelectorAll('.popup').forEach(p => p.classList.remove('show'));
  document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active'));
}

function scrollPreviewTo(pageIndex) {
  const thumb = previewPanel.querySelectorAll('.thumb')[pageIndex];
  if (thumb) thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}


/* ========== ZOOM LABEL ========== */
function updateZoomLabel() {
  if (!zoomPercentLabel) return;
  const pct = Math.round((zoomLevels[currentZoomIndex] / zoomLevels[2]) * 100);
  zoomPercentLabel.textContent = pct + '%';
}

/* ========== DRAWING / CANVAS HELPERS ========== */
function getPosOnCanvas(canvas, e) {
  const rect = canvas.getBoundingClientRect();
  const t = e.touches ? e.touches[0] : e;
  return { x: (t.clientX - rect.left), y: (t.clientY - rect.top) };
}

function enableDrawingOnCanvas(canvas, pageIndex) {
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  ctx.lineJoin = 'round';
  ctx.lineCap = 'round';

  if (!pageStates[pageIndex]) pageStates[pageIndex] = { dataURL: null, undoStack: [], redoStack: [] };

  let drawing = false, hasDrawn = false;
  let last = { x: 0, y: 0 };

  function getCanvasPos(e) {
    const rect = canvas.getBoundingClientRect();
    return { x: e.clientX - rect.left, y: e.clientY - rect.top };
  }

  function saveSnapshotToUndo() {
    const s = pageStates[pageIndex];
    try {
      const snap = canvas.toDataURL();
      s.undoStack.push(snap);
      if (s.undoStack.length > 30) s.undoStack.shift();
      s.redoStack = [];
    } catch (err) { console.error(err); }
  }

  // === POINTER EVENTS ===
  canvas.addEventListener('pointerdown', e => {
    if (panMode) {
      // biar event terus ke container agar bisa pan
      e.stopPropagation();
      container.dispatchEvent(new PointerEvent('pointerdown', e));
      return;
    }
    e.preventDefault();
    canvas.setPointerCapture(e.pointerId);
    drawing = true;
    hasDrawn = false;
    last = getCanvasPos(e);
    saveSnapshotToUndo();
  });

  canvas.addEventListener('pointermove', e => {
    if (!drawing || panMode) return;
    e.preventDefault();
    const pos = getCanvasPos(e);
    ctx.globalCompositeOperation = (tool === 'eraser') ? 'destination-out' : 'source-over';
    ctx.strokeStyle = color;
    ctx.lineWidth = size * (e.pressure || 1);
    ctx.beginPath();
    ctx.moveTo(last.x, last.y);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
    last = pos;
    hasDrawn = true;
  });

  function stopDrawing(e) {
    if (!drawing) return;
    drawing = false;
    try { canvas.releasePointerCapture(e.pointerId); } catch (_) {}
    ctx.globalCompositeOperation = 'source-over';
    if (hasDrawn) {
      try {
        pageStates[pageIndex].dataURL = canvas.toDataURL();
        updateThumbnail(pageIndex);
        scrollPreviewTo(pageIndex);
      } catch (err) { /* ignore */ }
    }
  }

  canvas.addEventListener('pointerup', stopDrawing);
  canvas.addEventListener('pointercancel', stopDrawing);
  canvas.addEventListener('pointerleave', stopDrawing);

  // === UNDO / REDO ===
  canvas._doUndo = function () {
    const s = pageStates[pageIndex];
    if (!s || !s.undoStack.length) return;
    const prev = s.undoStack.pop();
    try {
      const current = canvas.toDataURL();
      s.redoStack.push(current);
    } catch (e) { /* ignore */ }
    const img = new Image();
    img.onload = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      s.dataURL = prev;
    };
    img.src = prev;
  };

  canvas._doRedo = function () {
    const s = pageStates[pageIndex];
    if (!s || !s.redoStack.length) return;
    const redo = s.redoStack.pop();
    try {
      const current = canvas.toDataURL();
      s.undoStack.push(current);
    } catch (e) { /* ignore */ }
    const img = new Image();
    img.onload = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      s.dataURL = redo;
    };
    img.src = redo;
  };
}

/* ========== UNDO / REDO UTIL ========== */
function getFocusedDrawCanvas() {
  const pages = [...document.querySelectorAll('.page')];
  if (!container || !pages.length) return null;
  const containerRect = container.getBoundingClientRect();
  let best = null, bestOverlap = -1;
  for (const p of pages) {
    const r = p.getBoundingClientRect();
    const top = Math.max(r.top, containerRect.top);
    const bottom = Math.min(r.bottom, containerRect.bottom);
    const overlap = Math.max(0, bottom - top);
    if (overlap > bestOverlap) { bestOverlap = overlap; best = p; }
  }
  return best ? best.querySelector('canvas.draw-layer') : null;
}

/* connect undo/redo buttons (safe) */
undoBtn?.addEventListener('click', () => {
  const c = getFocusedDrawCanvas();
  if (c && c._doUndo) c._doUndo();
});
redoBtn?.addEventListener('click', () => {
  const c = getFocusedDrawCanvas();
  if (c && c._doRedo) c._doRedo();
});

/* ========== PAN MODE (UNIVERSAL + FIXED POINTER OVERLAY) ========== */
panToggleBtn?.addEventListener('click', () => {
  panMode = !panMode;
  panToggleBtn.classList.toggle('active', panMode);
  if (container) { container.style.cursor = panMode ? 'grab' : 'default';
  container.style.touchAction = panMode ? 'pan-x pan-y' : 'none';
  }

  // hanya ubah cursor, jangan ubah pointer-events (biar event tetap jalan)
  document.querySelectorAll('.page canvas.draw-layer').forEach(c => {
    cc.style.cursor = panMode ? 'grab' : 'crosshair';
  });
});

let isPanning = false;
let startPan = { x: 0, y: 0 };
let scrollStart = { x: 0, y: 0 };

function startPanMove(e) {
  if (!panMode) return;
  e.preventDefault();
  isPanning = true;
  container.style.cursor = 'grabbing';
  const p = e.touches ? e.touches[0] : e;
  startPan = { x: p.clientX, y: p.clientY };
  scrollStart = { x: container.scrollLeft, y: container.scrollTop };
}


function movePan(e) {
  if (!isPanning || !panMode) return;
  const p = e.touches ? e.touches[0] : e;
  const dx = p.clientX - startPan.x;
  const dy = p.clientY - startPan.y;
  container.scrollLeft = scrollStart.x - dx;
  container.scrollTop = scrollStart.y - dy;
}

function stopPan() {
  if (!panMode) return;
  isPanning = false;
  container.style.cursor = 'grab';
}

container.addEventListener('pointerdown', startPanMove);
container.addEventListener('pointermove', movePan);
container.addEventListener('pointerup', stopPan);
container.addEventListener('pointercancel', stopPan);

/* ========== BRUSH / ERASER / COLOR / SIZE ========== */
quickBrush?.addEventListener('click', () => { tool = 'brush'; if (drawModeSelect) drawModeSelect.value = 'brush'; });
quickEraser?.addEventListener('click', () => { tool = 'eraser'; if (drawModeSelect) drawModeSelect.value = 'eraser'; });

if (drawModeSelect) {
  drawModeSelect.addEventListener('change', e => { tool = e.target.value; });
}
colorPicker?.addEventListener('change', e => { color = e.target.value; if (colorPicker2) colorPicker2.value = color; });
colorPicker2?.addEventListener('change', e => { color = e.target.value; if (colorPicker) colorPicker.value = color; });
sizePicker?.addEventListener('input', e => { size = Number(e.target.value); });

/* ========== CLEAR ALL ========== */
btnClear?.addEventListener('click', () => {
  document.querySelectorAll('canvas.draw-layer').forEach((c, i) => {
    const ctx = c.getContext('2d');
    if (pageStates[i]) {
      // Simpan snapshot sebelum clear
      try {
        const snap = c.toDataURL();
        pageStates[i].undoStack.push(snap);
        if (pageStates[i].undoStack.length > 30) pageStates[i].undoStack.shift();
      } catch (err) { console.error(err); }

      ctx.clearRect(0, 0, c.width, c.height);
      pageStates[i].dataURL = null;
      updateThumbnail(i);

      // Jangan hapus undoStack, hanya bersihkan redoStack
      pageStates[i].redoStack = [];
    }
  });
  alert('✅ Semua coretan dihapus.');
});

let zoomTimeout;
function safeRenderAllPages() {
  clearTimeout(zoomTimeout);
  zoomTimeout = setTimeout(() => renderAllPages(true), 150);
}
/* ========== ZOOM CONTROLS ========== */
zoomInBtn?.addEventListener('click', async () => {
  if (currentZoomIndex < zoomLevels.length - 1) {
    captureAllDrawsToStates();
    currentZoomIndex++;
    scale = zoomLevels[currentZoomIndex];
    updateZoomLabel();
    await renderAllPages(true);
  }
});
zoomOutBtn?.addEventListener('click', async () => {
  if (currentZoomIndex > 0) {
    captureAllDrawsToStates();
    currentZoomIndex--;
    scale = zoomLevels[currentZoomIndex];
    updateZoomLabel();
    safeRenderAllPages();
  }
});
fitBtn?.addEventListener('click', () => {
  if (!container) return;
  const viewportWidth = container.clientWidth - 60;
  const base = document.querySelector('.page canvas:not(.draw-layer)');
  if (!base) return;
  const ratio = viewportWidth / base.width;
  let bestIdx = 0, bestDiff = Infinity;
  for (let i = 0; i < zoomLevels.length; i++) {
    const diff = Math.abs(zoomLevels[i] - ratio);
    if (diff < bestDiff) { bestDiff = diff; bestIdx = i; }
  }
  captureAllDrawsToStates();
  currentZoomIndex = bestIdx; scale = zoomLevels[currentZoomIndex];
  renderAllPages(true);
});

/* ========== POPUP / SETTINGS ========== */
settingsBtn?.addEventListener('click', (e) => {
  e.stopPropagation();
  if (!settingsPopup) return;
  settingsPopup.style.display = settingsPopup.style.display === 'block' ? 'none' : 'block';
});
document.addEventListener('click', () => { if (settingsPopup) settingsPopup.style.display = 'none'; });
settingsPopup?.addEventListener('click', e => e.stopPropagation());
themeLightBtn?.addEventListener('click', setThemeLight);
themeDarkBtn?.addEventListener('click', setThemeDark);
themeCustomBtn?.addEventListener('click', () => {
  document.getElementById('customColorRow') && (document.getElementById('customColorRow').style.display = 'block');
});
customAccent?.addEventListener('input', (e) => setThemeCustom(e.target.value));

/* pages toggle (if any) */
pagesToggle?.addEventListener('click', () => {
  if (!previewPanel) return;
  const isHidden = previewPanel.style.display === 'none' || previewPanel.style.display === '';
  if (isHidden) { previewPanel.style.display = 'flex'; pagesToggle.classList.add('active'); } else { previewPanel.style.display = 'none'; pagesToggle.classList.remove('active'); }
});

/* ========== RENDER PAGES (PDF.js) ========== */
function captureAllDrawsToStates() {
  document.querySelectorAll('.page').forEach((p, i) => {
    const d = p.querySelector('canvas.draw-layer');
    if (!pageStates[i]) pageStates[i] = { dataURL: null, undoStack: [], redoStack: [] };
    try { pageStates[i].dataURL = d.toDataURL(); } catch (e) { /* ignore cross-origin or empty */ }
  });
}

async function renderAllPages(restore = true) {
  if (isRendering) return;
  isRendering = true; 
  showProgress(); setProgress(5);
  container.innerHTML = '';
  pageStates = pageStates || [];

  if (!pdfDoc) {
    const loading = pdfjsLib.getDocument({ url: pdfUrl });
    pdfDoc = await loading.promise;
  }

  const num = pdfDoc.numPages;
  for (let i = 1; i <= num; i++) {
    setProgress(6 + Math.floor((i / num) * 80));
    const page = await pdfDoc.getPage(i);
    const viewport = page.getViewport({ scale });
    const pageDiv = document.createElement('div');
    pageDiv.className = 'page';
    pageDiv.style.position = 'relative';
    pageDiv.style.width = viewport.width + 'px';
    pageDiv.style.height = viewport.height + 'px';
    pageDiv.style.margin = '8px auto';

    // base canvas
    const pdfCanvas = document.createElement('canvas');
    pdfCanvas.width = viewport.width;
    pdfCanvas.height = viewport.height;
    pdfCanvas.style.display = 'block';
    const ctx = pdfCanvas.getContext('2d', { willReadFrequently: true });
    await page.render({ canvasContext: ctx, viewport }).promise;
    pageDiv.appendChild(pdfCanvas);

    // draw layer
    const drawCanvas = document.createElement('canvas');
    drawCanvas.classList.add('draw-layer');
    drawCanvas.width = viewport.width;
    drawCanvas.height = viewport.height;
    drawCanvas.style.position = 'absolute';
    drawCanvas.style.left = '0';
    drawCanvas.style.top = '0';
    pageDiv.appendChild(drawCanvas);

    if (!pageStates[i - 1]) pageStates[i - 1] = { dataURL: null, undoStack: [], redoStack: [] };
   if (restore && pageStates[i - 1].dataURL) {
  const img = new Image();
  img.src = pageStates[i - 1].dataURL;
  await new Promise(r => img.onload = r);
  const dctx = drawCanvas.getContext('2d');
  dctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);

  // 💡 Hitung skala antara kanvas lama dan yang baru
  const oldWidth = img.width;
  const oldHeight = img.height;
  const scaleX = drawCanvas.width / oldWidth;
  const scaleY = drawCanvas.height / oldHeight;

  // Terapkan skala supaya coretan tetap sejajar
  dctx.save();
  dctx.scale(scaleX, scaleY);
  dctx.drawImage(img, 0, 0);
  dctx.restore();
  
}


    enableDrawingOnCanvas(drawCanvas, i - 1);
    container.appendChild(pageDiv);
  }

  setProgress(100);
hideProgress();
updateZoomLabel();

// buat semua thumbnail dulu
await generatePreviewPanel();

// setelah semua thumbnail jadi, langsung update tiap thumbnail
for (let i = 0; i < pdfDoc.numPages; i++) {
  await updateThumbnail(i);
}
isRendering = false;
}


/* ========== THUMBNAIL PREVIEW GENERATOR ========== */
async function generatePreviewPanel() {
  if (!previewPanel || !pdfDoc) return;
  previewPanel.innerHTML = ''; // kosongkan dulu

  const num = pdfDoc.numPages;
  for (let i = 1; i <= num; i++) {
    const page = await pdfDoc.getPage(i);
    const viewport = page.getViewport({ scale: 0.15 }); // kecilkan untuk thumbnail
    const thumbCanvas = document.createElement('canvas');
    const ctx = thumbCanvas.getContext('2d');
    thumbCanvas.width = viewport.width;
    thumbCanvas.height = viewport.height;

    await page.render({ canvasContext: ctx, viewport }).promise;

    // tambahkan lapisan coretan kalau sudah ada
    const drawCanvas = document.querySelectorAll('.page canvas.draw-layer')[i - 1];
    if (drawCanvas) {
      ctx.save();
      ctx.scale(0.15, 0.15);
      ctx.drawImage(drawCanvas, 0, 0);
      ctx.restore();
    }

    const thumbDiv = document.createElement('div');
    thumbDiv.className = 'thumb';
    thumbDiv.title = 'Halaman ' + i;
    thumbDiv.appendChild(thumbCanvas);

    const label = document.createElement('div');
    label.className = 'page-num';
    label.textContent = i;
    thumbDiv.appendChild(label);

    // klik thumbnail => scroll ke halaman
    thumbDiv.addEventListener('click', () => {
      const pageEls = document.querySelectorAll('.page');
      if (pageEls[i - 1]) {
        pageEls[i - 1].scrollIntoView({ behavior: 'smooth' });
      }
    });

    previewPanel.appendChild(thumbDiv);
  }
}

/* ========== UPDATE SINGLE THUMBNAIL (ZOOM-SAFE) ========== */
async function updateThumbnail(pageIndex) {
  if (!previewPanel || !pdfDoc) return;
  const thumbDiv = previewPanel.querySelectorAll('.thumb')[pageIndex];
  if (!thumbDiv) return; // belum ada thumbnail
  const thumbCanvas = thumbDiv.querySelector('canvas');
  if (!thumbCanvas) return;

  const ctx = thumbCanvas.getContext('2d');

  // ambil langsung tampilan halaman di DOM (bukan re-render dari PDF.js)
  const pageDiv = document.querySelectorAll('.page')[pageIndex];
  const baseCanvas = pageDiv.querySelector('canvas:not(.draw-layer)');
  const drawCanvas = pageDiv.querySelector('canvas.draw-layer');

  if (!baseCanvas || !drawCanvas) return;

  // buat kanvas sementara untuk gabungkan base + coretan
  const merged = document.createElement('canvas');
  merged.width = baseCanvas.width;
  merged.height = baseCanvas.height;
  const mctx = merged.getContext('2d');
  mctx.drawImage(baseCanvas, 0, 0);
  mctx.drawImage(drawCanvas, 0, 0);

  // skala ke ukuran thumbnail
  const scaleThumb = 0.15;
  thumbCanvas.width = merged.width * scaleThumb;
  thumbCanvas.height = merged.height * scaleThumb;
  ctx.save();
  ctx.scale(scaleThumb, scaleThumb);
  ctx.drawImage(merged, 0, 0);
  ctx.restore();
}



/* ========== PDF ANNOTATION EXPORT (generateAnnotatedPdfBytes) ========== */
async function generateAnnotatedPdfBytes(onProgress = null) {
  // requires pdf-lib included in page
  if (typeof PDFLib === 'undefined') throw new Error('PDFLib is not loaded.');
  const pages = document.querySelectorAll('.page');
  const doc = await PDFLib.PDFDocument.create();
  for (let i = 0; i < pages.length; i++) {
    const base = pages[i].querySelector('canvas:not(.draw-layer)');
    const draw = pages[i].querySelector('canvas.draw-layer');
    const merged = document.createElement('canvas');
    merged.width = base.width; merged.height = base.height;
    const ctx = merged.getContext('2d');
    ctx.drawImage(base, 0, 0);
    ctx.drawImage(draw, 0, 0);
    const imgData = merged.toDataURL('image/png');
    const page = doc.addPage([merged.width, merged.height]);
    const png = await doc.embedPng(imgData);
    page.drawImage(png, { x: 0, y: 0, width: merged.width, height: merged.height });
    if (onProgress) onProgress(Math.round(((i + 1) / pages.length) * 100));
  }
  return await doc.save();
}

/* ========== SAVE / DOWNLOAD HANDLERS ========== */
savePdfBtn?.addEventListener('click', async () => {
  try {
    showProgress(); setProgress(5);
    const bytes = await generateAnnotatedPdfBytes(p => setProgress(5 + Math.round(p * 0.9)));
    setProgress(95);
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'annotated.pdf';
    a.click();
    hideProgress();
  } catch (err) {
    console.error(err);
    hideProgress();
    alert('Gagal membangun PDF.');
  }
});

saveServerBtn?.addEventListener('click', async () => {
  try {
    showProgress(); setProgress(5);
    const bytes = await generateAnnotatedPdfBytes(p => setProgress(5 + Math.round(p * 0.8)));
    setProgress(70);
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const form = new FormData();
    form.append('pdf_file', blob, 'annotated_' + Date.now() + '.pdf');
    const res = await fetch(window.baseUrl + 'index.php/notes/save_pdf_server', { method: 'POST', body: form });
    const json = await res.json();
    setProgress(100); hideProgress();
    if (json.status === 'success') alert('✅ PDF berhasil disimpan:\n' + json.file);
    else alert('❌ Gagal simpan: ' + (json.message || 'unknown'));
  } catch (err) {
    console.error(err);
    hideProgress();
    alert('⚠️ Error simpan ke server');
  }
});

downloadJpgBtn?.addEventListener('click', async () => {
  try {
    const choice = prompt('📸 Pilih halaman (contoh: 1,3 or "all")');
    if (!choice) return;
    const pages = document.querySelectorAll('.page');
    if (choice.toLowerCase() === 'all') {
      let totalH = 0, maxW = 0;
      const canvases = [];
      for (const p of pages) {
        const base = p.querySelector('canvas:not(.draw-layer)');
        const draw = p.querySelector('canvas.draw-layer');
        const merged = document.createElement('canvas');
        merged.width = base.width; merged.height = base.height;
        const ctx = merged.getContext('2d');
        ctx.drawImage(base, 0, 0); ctx.drawImage(draw, 0, 0);
        canvases.push(merged); totalH += merged.height; if (merged.width > maxW) maxW = merged.width;
      }
      const final = document.createElement('canvas');
      final.width = maxW; final.height = totalH;
      const fctx = final.getContext('2d');
      let y = 0; for (const c of canvases) { fctx.drawImage(c, 0, y); y += c.height; }
      const link = document.createElement('a'); link.href = final.toDataURL('image/jpeg', 0.9); link.download = 'semua_halaman.jpg'; link.click();
      alert('✅ Semua halaman diunduh sebagai JPG.');
      return;
    } else {
      const parts = choice.split(',').map(x => parseInt(x.trim(), 10)).filter(n => !isNaN(n));
      if (!parts.length) { alert('Nomor halaman tidak valid'); return; }
      for (const n of parts) {
        if (n < 1 || n > pages.length) continue;
        const base = pages[n - 1].querySelector('canvas:not(.draw-layer)');
        const draw = pages[n - 1].querySelector('canvas.draw-layer');
        const merged = document.createElement('canvas');
        merged.width = base.width; merged.height = base.height;
        const ctx = merged.getContext('2d');
        ctx.drawImage(base, 0, 0); ctx.drawImage(draw, 0, 0);
        const link = document.createElement('a'); link.href = merged.toDataURL('image/jpeg', 0.9); link.download = 'halaman_' + n + '.jpg'; link.click();
      }
      alert('✅ Halaman JPG berhasil diunduh.');
    }
  } catch (err) {
    console.error(err); alert('Gagal membuat JPG.');
  }
});

/* topbar save server (if present) */
saveServerTopBtn?.addEventListener('click', async () => {
  try {
    showProgress(); setProgress(5);
    const bytes = await generateAnnotatedPdfBytes(p => setProgress(5 + Math.round(p * 0.8)));
    setProgress(70);
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const form = new FormData();
    form.append('pdf_file', blob, 'annotated_' + Date.now() + '.pdf');
    const res = await fetch(window.baseUrl + 'index.php/notes/save_pdf_server', { method: 'POST', body: form });
    const json = await res.json();
    setProgress(100); hideProgress();
    if (json.status === 'success') alert('✅ PDF berhasil disimpan di server:\n' + json.file);
    else alert('❌ Gagal simpan: ' + (json.message || 'unknown'));
  } catch (err) {
    console.error(err);
    hideProgress();
    alert('⚠️ Terjadi kesalahan saat menyimpan ke server.');
  }
});

/* download dropdown (top) */
downloadTopBtn?.addEventListener('click', (e) => {
  e.stopPropagation();
  container.dispatchEvent(new PointerEvent('pointerdown', e));
  downloadDropdown?.classList.toggle('show');
});
document.addEventListener('click', () => downloadDropdown?.classList.remove('show'));

/* ========== INIT ========== */
(async () => {
  try {
    showProgress(); setProgress(10);
    if (!pdfUrl) throw new Error('pdfUrl tidak tersedia (window.pdfUrl kosong).');
    const loading = pdfjsLib.getDocument({ url: pdfUrl });
    pdfDoc = await loading.promise;
    scale = zoomLevels[currentZoomIndex];
    await renderAllPages(false);
  } catch (e) {
    console.error(e); hideProgress();
    alert('Gagal memuat PDF. Lihat console untuk detail.');
  }
})();

})();
