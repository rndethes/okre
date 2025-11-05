(function () {
  'use strict';

  // Defensive: ensure DOM elements exist before continuing
  const el = id => document.getElementById(id);

  /* ========== PDF.js Setup ========== */
  // load pdfjs from CDN earlier via defer; reference here
  const pdfjsLib = window['pdfjs-dist/build/pdf'];
  if (typeof window['pdfjs-dist/build/pdf'] === 'undefined') {
  alert('PDF.js tidak ditemukan, pastikan CDN dimuat dengan benar.');
  return;
}

if (pdfjsLib) {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
  }

  /* ========== SAFE DOM HOOKS ========== */
  const container = el('container');
  const progressBar = el('progressBar');
  const progressFill = el('progressFill');
  const previewPanel = el('previewPanel');
  const pagesToggle = el('pagesToggle');
  const settingsBtn = el('settingsBtn');
  const settingsPopup = el('settingsPopup');
  const themeLightBtn = el('themeLightBtn');
  const themeDarkBtn = el('themeDarkBtn');
  const themeCustomBtn = el('themeCustomBtn');
  const customAccent = el('customAccent');

  const zoomPercentLabel = el('zoomPercent');
  const colorPicker = el('colorPicker');
  const colorPicker2 = el('colorPicker2');
  const sizePicker = el('sizePicker');
  const drawModeSelect = el('drawMode');
  const quickBrush = el('quickBrush');
  const quickEraser = el('quickEraser');
  const panToggleBtn = el('panToggleBtn');

  const undoBtn = el('btnUndo');
  const redoBtn = el('btnRedo');
  const zoomInBtn = el('zoomInBtn');
  const zoomOutBtn = el('zoomOutBtn');
  const fitBtn = el('fitBtn');
  const btnClear = el('btnClear');
  const savePdfBtn = el('savePdfBtn');
  const saveServerBtn = el('saveServerBtn');
  const downloadJpgBtn = el('downloadJpgBtn');
  const downloadTopBtn = el('downloadTopBtn');
  const downloadDropdown = el('downloadDropdown');
  const saveServerTopBtn = el('saveServerTopBtn');

  const pdfUrl = window.pdfUrl || '';

  /* ========== STATE ========== */
  let pdfDoc = null;
  let pageStates = []; // per-page: { dataURL, undoStack, redoStack }
  let baseScale = 1.0; // base rendering scale (logical pixels)
  const zoomLevels = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
  let currentZoomIndex = 2; // default 1.0
  let previousScale = zoomLevels[currentZoomIndex] || 1.0;
  let panMode = false;
  let tool = 'brush';
  let color = '#000000ff';
  let size = 4;
  let isRendering = false;
  let numPages = 0;

  /* ========== HELPERS: THEME / PROGRESS / POPUPS ========== */
  function setThemeLight() {
    document.getElementById('appRoot')?.classList.remove('theme-dark');
    document.documentElement.style.setProperty('--blue-500', '#1976d2');
    document.documentElement.style.setProperty('--blue-600', '#1565c0');
    document.documentElement.style.setProperty('--sidebar-bg', 'linear-gradient(180deg,var(--card),#f0f7ff)');
  }
  function setThemeDark() { document.getElementById('appRoot')?.classList.add('theme-dark'); }
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

  
  function scrollPreviewTo(pageIndex) {
    const thumbs = previewPanel?.querySelectorAll('.thumb');
    const thumb = thumbs ? thumbs[pageIndex] : null;
    if (thumb) thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  /* ========== ZOOM LABEL ========== */
  function updateZoomLabel() {
    if (!zoomPercentLabel) return;
    const pct = Math.round((zoomLevels[currentZoomIndex] / zoomLevels[2]) * 100);
    zoomPercentLabel.textContent = pct + '%';
  }

  /* ========== DRAWING / CANVAS HELPERS ========== */
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
  const t = (e.touches && e.touches[0]) || e;

  // posisi relatif di layar
  const rawX = t.clientX - rect.left;
  const rawY = t.clientY - rect.top;

  // sesuaikan dengan skala dan DPI
  const logicalX = rawX * (canvas.width / rect.width);
  const logicalY = rawY * (canvas.height / rect.height);

  return { x: logicalX, y: logicalY };
}


    function saveSnapshotToUndo() {
      const s = pageStates[pageIndex];
      try {
        const snap = canvas.toDataURL();
        s.undoStack.push(snap);
        if (s.undoStack.length > 30) s.undoStack.shift();
        s.redoStack = [];
      } catch (err) { console.error('snapshot error', err); }
    }

    // pointer handlers: use pointer events and pressure when available
    canvas.addEventListener('pointerdown', e => {
      // when panMode is on, canvas pointer events should be disabled (handled elsewhere)
      if (panMode) return;
      e.preventDefault();
      canvas.setPointerCapture?.(e.pointerId);
      drawing = true;
      hasDrawn = false;
      last = getCanvasPos(e);
      saveSnapshotToUndo();
    }, { passive: false });

    canvas.addEventListener('pointermove', e => {
  if (!drawing || panMode) return;
  e.preventDefault();

  const pos = getCanvasPos(e);

  // mode gambar / hapus
  ctx.globalCompositeOperation = (tool === 'eraser') ? 'destination-out' : 'source-over';
  ctx.strokeStyle = color;

  // tekanan stylus (pressure)
  const pressure = (typeof e.pressure === 'number' && e.pressure > 0) ? e.pressure : 1;
  const effectiveScale = previousScale || 1.0;
  const lw = size * pressure * effectiveScale;
  ctx.lineWidth = lw;
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';
  ctx.miterLimit = 10;

  // ==== smoothing antar titik (anti garis) ====
  const smoothFactor = 0.25;
  const dx = pos.x - last.x;
  const dy = pos.y - last.y;
  const dist = Math.sqrt(dx * dx + dy * dy);
  const steps = Math.ceil(dist / (lw * smoothFactor));

  ctx.beginPath();
  ctx.moveTo(last.x, last.y);
  for (let i = 1; i <= steps; i++) {
    const t = i / steps;
    const x = last.x + dx * t;
    const y = last.y + dy * t;
    ctx.lineTo(x, y);
  }
  ctx.stroke();

  last = pos;
  hasDrawn = true;
}, { passive: false });


    function stopDrawing(e) {
      if (!drawing) return;
      drawing = false;
      try { canvas.releasePointerCapture?.(e.pointerId); } catch (_) {}
      ctx.globalCompositeOperation = 'source-over';
      if (hasDrawn) {
        try {
          pageStates[pageIndex].dataURL = canvas.toDataURL();
          // throttle thumbnail update to avoid UI freeze
          requestIdleCallback(() => updateThumbnail(pageIndex));
          scrollPreviewTo(pageIndex);
        } catch (err) { /* ignore */ }
      }
    }

    canvas.addEventListener('pointerup', stopDrawing);
    canvas.addEventListener('pointercancel', stopDrawing);
    canvas.addEventListener('pointerleave', stopDrawing);

    // UNDO / REDO helpers attached to DOM element for convenience
    canvas._doUndo = function () {
      const s = pageStates[pageIndex]; if (!s || !s.undoStack.length) return;
      const prev = s.undoStack.pop();
      try { const current = canvas.toDataURL(); s.redoStack.push(current); } catch (e) {}
      const img = new Image();
      img.onload = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        s.dataURL = prev;
      };
      img.src = prev;
    };

    canvas._doRedo = function () {
      const s = pageStates[pageIndex]; if (!s || !s.redoStack.length) return;
      const redo = s.redoStack.pop();
      try { const current = canvas.toDataURL(); s.undoStack.push(current); } catch (e) {}
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

  undoBtn?.addEventListener('click', () => { const c = getFocusedDrawCanvas(); if (c && c._doUndo) c._doUndo(); });
  redoBtn?.addEventListener('click', () => { const c = getFocusedDrawCanvas(); if (c && c._doRedo) c._doRedo(); });


/* ========== PAN MODE (STABIL UNTUK MOUSE, TOUCHPAD, DAN HP) ========== */

let isPanning = false;
let startPan = { x: 0, y: 0 };
let scrollStart = { x: 0, y: 0 };
let activeTouches = 0;

function setPanMode(enabled) {
  panMode = enabled;
  panToggleBtn?.classList.toggle('active', panMode);

  if (container) {
    container.style.cursor = panMode ? 'grab' : (tool === 'eraser' ? 'cell' : 'crosshair');
    container.style.touchAction = 'auto';
  }

  // atur canvas pointer events
  document.querySelectorAll('.page canvas.draw-layer').forEach(c => {
    c.style.pointerEvents = panMode ? 'none' : 'auto';
    c.style.cursor = panMode ? 'grab' : 'crosshair';
    c.style.touchAction = panMode ? 'auto' : 'none';
  });
  document.querySelectorAll('.page canvas:not(.draw-layer)').forEach(c => {
    c.style.pointerEvents = enabled  ? 'none' : 'auto';
  });
}

// tombol toggle manual
panToggleBtn?.addEventListener('click', () => setPanMode(!panMode));

/* ====== POINTER HANDLER ====== */
container?.addEventListener('pointerdown', e => {
  if (e.pointerType === 'touch') activeTouches++;

  // dua jari otomatis aktifkan panMode di HP
  if (e.pointerType === 'touch' && activeTouches >= 2) {
    setPanMode(true);
  }

  if (!panMode) return;
  if (e.pointerType === 'mouse' && e.button !== 0) return; // hanya klik kiri

  e.preventDefault();
  isPanning = true;
  container.style.cursor = 'grabbing';
  startPan = { x: e.clientX, y: e.clientY };
  scrollStart = { x: container.scrollLeft, y: container.scrollTop };
  container.setPointerCapture?.(e.pointerId);
}, { passive: false });

container?.addEventListener('pointermove', e => {
  if (!isPanning || !panMode) return;
  e.preventDefault();
  const dx = e.clientX - startPan.x;
  const dy = e.clientY - startPan.y;
  container.scrollLeft = scrollStart.x - dx;
  container.scrollTop = scrollStart.y - dy;
}, { passive: false });

container?.addEventListener('pointerup', e => {
  if (e.pointerType === 'touch') {
    activeTouches = Math.max(0, activeTouches - 1);
  }

  if (isPanning) {
    isPanning = false;
    container.style.cursor = panMode ? 'grab' : 'default';
    try { container.releasePointerCapture?.(e.pointerId); } catch (_) {}
  }
}, { passive: true });

container?.addEventListener('pointercancel', e => {
  if (e.pointerType === 'touch') activeTouches = 0;
  isPanning = false;
  container.style.cursor = panMode ? 'grab' : 'default';
}, { passive: true });

/* ====== SCROLL WHEEL SUPPORT (MOUSE / TOUCHPAD) ====== */
container?.addEventListener('wheel', e => {
  if (!panMode) return; // hanya aktif kalau mode pan
  e.preventDefault();
  container.scrollTop += e.deltaY;
  container.scrollLeft += e.deltaX;
}, { passive: false });



  /* ========== BRUSH / ERASER / COLOR / SIZE ========== */
  quickBrush?.addEventListener('click', () => { tool = 'brush'; if (drawModeSelect) drawModeSelect.value = 'brush'; });
  quickEraser?.addEventListener('click', () => { tool = 'eraser'; if (drawModeSelect) drawModeSelect.value = 'eraser'; });
  if (drawModeSelect) drawModeSelect.addEventListener('change', e => { tool = e.target.value; });
  colorPicker?.addEventListener('change', e => { color = e.target.value; if (colorPicker2) colorPicker2.value = color; });
  sizePicker?.addEventListener('input', e => { size = Number(e.target.value); });

  /* ========== CLEAR ALL ========== */
  btnClear?.addEventListener('click', () => {
    document.querySelectorAll('canvas.draw-layer').forEach((c, i) => {
      const ctx = c.getContext('2d');
      if (pageStates[i]) {
        try { const snap = c.toDataURL(); pageStates[i].undoStack.push(snap); if (pageStates[i].undoStack.length > 30) pageStates[i].undoStack.shift(); } catch (err) { console.error(err); }
        ctx.clearRect(0, 0, c.width, c.height);
        pageStates[i].dataURL = null;
        pageStates[i].redoStack = [];
        // update thumbnail async
        requestIdleCallback(() => updateThumbnail(i));
      }
    });
    alert('✅ Semua coretan dihapus.');
  });

    /* ========== ZOOM CONTROLS  ========== */
async function renderPageAtScale(pageIndex, scale) {
  if (!pdfDoc) return;
  const pageNum = pageIndex + 1;
  const page = await pdfDoc.getPage(pageNum);

  // gunakan devicePixelRatio agar retina / zoom tetap tajam
  const viewport = page.getViewport({ scale: scale * window.devicePixelRatio });

  const pageDiv = container.querySelectorAll('.page')[pageIndex];
  if (!pageDiv) return;

  const baseCanvas = pageDiv.querySelector('canvas:not(.draw-layer)');
  const drawCanvas = pageDiv.querySelector('canvas.draw-layer');

  // ===== BASE LAYER (PDF) =====
  baseCanvas.width = Math.round(viewport.width);
  baseCanvas.height = Math.round(viewport.height);
  baseCanvas.style.width = (viewport.width / window.devicePixelRatio) + 'px';
  baseCanvas.style.height = (viewport.height / window.devicePixelRatio) + 'px';

  const ctx = baseCanvas.getContext('2d', { willReadFrequently: true });
  ctx.setTransform(1, 0, 0, 1, 0, 0);
  ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
  ctx.imageSmoothingEnabled = false;
  ctx.imageSmoothingQuality = 'high';
  ctx.clearRect(0, 0, baseCanvas.width, baseCanvas.height);
  await page.render({ canvasContext: ctx, viewport }).promise;

  // ===== DRAW LAYER =====
  if (drawCanvas) {
    const oldData = pageStates[pageIndex]?.dataURL;
    drawCanvas.width = baseCanvas.width;
    drawCanvas.height = baseCanvas.height;
    drawCanvas.style.width = baseCanvas.style.width;
    drawCanvas.style.height = baseCanvas.style.height;

    const dctx = drawCanvas.getContext('2d');
    dctx.setTransform(1, 0, 0, 1, 0, 0);
    dctx.scale(window.devicePixelRatio, window.devicePixelRatio);
    dctx.imageSmoothingEnabled = true;
    dctx.imageSmoothingQuality = 'high';
    
    dctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
    dctx.lineCap = 'round';
    dctx.lineJoin = 'round';
    if (oldData) {
      const img = new Image();
      img.onload = () => {
        // gambar ulang pixel-perfect tanpa scaling interpolation
        dctx.drawImage(img, 0, 0, img.width, img.height,
                            0, 0, drawCanvas.width / window.devicePixelRatio,
                            drawCanvas.height / window.devicePixelRatio);
      };
      img.src = oldData;
    }
  }

  pageDiv.style.width = (viewport.width / window.devicePixelRatio) + 'px';
pageDiv.style.height = (viewport.height / window.devicePixelRatio) + 'px';
pageDiv.style.overflow = 'hidden';
}



async function applyZoomTransform(maintainCenter = true) {
  // newScale is the selected zoom level (logical scale relative to base)
  const newScale = zoomLevels[currentZoomIndex];
  const oldScale = previousScale || 1.0;
  if (!container || !pdfDoc) return;

  // preserve center in document logical coords
  let centerDocX = null, centerDocY = null;
  if (maintainCenter) {
    centerDocX = (container.scrollLeft + container.clientWidth / 2) / oldScale;
    centerDocY = (container.scrollTop + container.clientHeight / 2) / oldScale;
  }

  // Re-render each PDF page at the newScale (this avoids CSS blur)
  const pages = document.querySelectorAll('.page');
  for (let i = 0; i < pages.length; i++) {
    // render each page at scale = newScale * baseScale (baseScale usually 1)
    const targetScale = newScale * baseScale;
    // await re-render of this page
    await renderPageAtScale(i, targetScale);

    // small yield to keep UI responsive
    await new Promise(r => setTimeout(r, 0));
  }

  updateZoomLabel();

  // restore scroll center (convert logical -> pixel with newScale)
  if (maintainCenter && centerDocX !== null && centerDocY !== null) {
    const newCenterX = Math.round(centerDocX * newScale);
    const newCenterY = Math.round(centerDocY * newScale);
    container.scrollLeft = Math.max(0, newCenterX - Math.round(container.clientWidth / 2));
    container.scrollTop = Math.max(0, newCenterY - Math.round(container.clientHeight / 2));
  }

  previousScale = newScale;
}


  // event listener zoom
  zoomInBtn?.addEventListener('click', () => {
    if (currentZoomIndex < zoomLevels.length - 1) {
      captureAllDrawsToStates();
      currentZoomIndex++;
      applyZoomTransform(true);
    }
  });

  zoomOutBtn?.addEventListener('click', () => {
    if (currentZoomIndex > 0) {
      captureAllDrawsToStates();
      currentZoomIndex--;
      applyZoomTransform(true);
    }
  });

  fitBtn?.addEventListener('click', () => {
    if (!container) return;
    const viewportWidth = container.clientWidth - 60;
    const base = document.querySelector('.page canvas:not(.draw-layer)');
    if (!base) return;

    const logicalBaseWidth = base.width / previousScale;
    const ratio = viewportWidth / logicalBaseWidth;

    let bestIdx = 0, bestDiff = Infinity;
    for (let i = 0; i < zoomLevels.length; i++) {
      const diff = Math.abs(zoomLevels[i] - ratio);
      if (diff < bestDiff) { bestDiff = diff; bestIdx = i; }
    }

    captureAllDrawsToStates();
    currentZoomIndex = bestIdx;
    applyZoomTransform(true);
  });
function applyZoomTransform(scale) {
  const pages = document.querySelectorAll('.page');
  pages.forEach(page => {
    const canvas = page.querySelector('canvas');
    if (!canvas) return;

    const ratio = window.devicePixelRatio || 1;
    const adjustedScale = scale / ratio;

    page.style.transformOrigin = 'top center';
    page.style.transform = `scale(${adjustedScale})`;
  });
}

  /* ========== POPUP / SETTINGS ========== */
  settingsBtn?.addEventListener('click', (e) => { e.stopPropagation(); if (!settingsPopup) return; settingsPopup.style.display = settingsPopup.style.display === 'block' ? 'none' : 'block'; });
  settingsPopup?.addEventListener('click', e => e.stopPropagation());
  themeLightBtn?.addEventListener('click', setThemeLight);
  themeDarkBtn?.addEventListener('click', setThemeDark);
  themeCustomBtn?.addEventListener('click', () => { document.getElementById('customColorRow') && (document.getElementById('customColorRow').style.display = 'block'); });
  customAccent?.addEventListener('input', (e) => setThemeCustom(e.target.value));
  pagesToggle?.addEventListener('click', () => {
    if (!previewPanel) return;
    const isHidden = previewPanel.style.display === 'none' || previewPanel.style.display === '';
    previewPanel.style.display = isHidden ? 'flex' : 'none';
    pagesToggle.classList.toggle('active', isHidden);
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

    // If pdfDoc not loaded, load it
    if (!pdfDoc) {
      if (!pdfUrl || !pdfjsLib) {
        // If no PDF, fallback to canvas-blank mode
        createBlankCanvasMode();
        isRendering = false; hideProgress(); return;
      }
      const loading = pdfjsLib.getDocument({ url: pdfUrl });
      pdfDoc = await loading.promise;
    }

    numPages = pdfDoc.numPages;
    container.innerHTML = '';

    // render each page sequentially but yield to event loop per page to keep UI responsive
    for (let i = 1; i <= numPages; i++) {
      setProgress(6 + Math.floor((i / numPages) * 80));
      const page = await pdfDoc.getPage(i);
      const viewport = page.getViewport({ scale: baseScale });

      const pageDiv = document.createElement('div');
      pageDiv.className = 'page';
      pageDiv.style.position = 'relative';
      pageDiv.style.width = viewport.width + 'px';
      pageDiv.style.height = viewport.height + 'px';
      pageDiv.style.margin = '8px auto';
      pageDiv.style.transformOrigin = 'top left';

      // base canvas (render PDF once at baseScale)
      const pdfCanvas = document.createElement('canvas');
      pdfCanvas.width = viewport.width;
      pdfCanvas.height = viewport.height;
      pdfCanvas.style.display = 'block';
      const ctx = pdfCanvas.getContext('2d');
      // use willReadFrequently only when necessary
      const renderTask = page.render({ canvasContext: ctx, viewport });
      await renderTask.promise;
      pageDiv.appendChild(pdfCanvas);

      // draw layer
      const drawCanvas = document.createElement('canvas');
      drawCanvas.classList.add('draw-layer');
      drawCanvas.width = viewport.width;
      drawCanvas.height = viewport.height;
      drawCanvas.style.position = 'absolute';
      drawCanvas.style.left = '0';
      drawCanvas.style.top = '0';
      drawCanvas.style.touchAction = 'none';
      pageDiv.appendChild(drawCanvas);

      // restore previous drawing if available
      if (!pageStates[i - 1]) pageStates[i - 1] = { dataURL: null, undoStack: [], redoStack: [] };
      if (pageStates[i - 1].dataURL && restore) {
        const img = new Image();
        img.src = pageStates[i - 1].dataURL;
        await new Promise(r => img.onload = r);
        const dctx = drawCanvas.getContext('2d');
        dctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        // compute scale factors; this ensures saved drawing matches new canvas size
        const scaleX = drawCanvas.width / img.width || 1;
        const scaleY = drawCanvas.height / img.height || 1;
        dctx.save(); dctx.scale(scaleX, scaleY); dctx.drawImage(img, 0, 0); dctx.restore();
      }

      // add event listeners for drawing
      enableDrawingOnCanvas(drawCanvas, i - 1);
      container.appendChild(pageDiv);

      // yield to event loop so browser can repaint
      await new Promise(r => setTimeout(r, 0));
    }

    setProgress(100);
    hideProgress();
    updateZoomLabel();

    // generate thumbnails but don't block rendering (use idle callback)
    requestIdleCallback(() => generatePreviewPanel());

    // apply current zoom transform
    applyZoomTransform();

    isRendering = false;
  }

  /* ========== THUMBNAIL PREVIEW GENERATOR (non-blocking) ========== */
  async function generatePreviewPanel() {
    if (!previewPanel || !pdfDoc) return;
    previewPanel.innerHTML = '';
    const num = pdfDoc.numPages;

    for (let i = 1; i <= num; i++) {
      // schedule each thumbnail generation during idle time
      await new Promise(resolve => requestIdleCallback(resolve));
      const page = await pdfDoc.getPage(i);
      const viewport = page.getViewport({ scale: 0.15 });
      const thumbCanvas = document.createElement('canvas');
      const ctx = thumbCanvas.getContext('2d');
      thumbCanvas.width = viewport.width;
      thumbCanvas.height = viewport.height;
      await page.render({ canvasContext: ctx, viewport }).promise;

      // merge draw layer if exists
      const drawCanvas = document.querySelectorAll('.page canvas.draw-layer')[i - 1];
      if (drawCanvas) {
        try {
          ctx.save(); ctx.scale(0.15, 0.15); ctx.drawImage(drawCanvas, 0, 0); ctx.restore();
        } catch (e) { /* ignore cross-origin or empty */ }
      }

      const thumbDiv = document.createElement('div');
      thumbDiv.className = 'thumb'; thumbDiv.title = 'Halaman ' + i; thumbDiv.appendChild(thumbCanvas);
      const label = document.createElement('div'); label.className = 'page-num'; label.textContent = i; thumbDiv.appendChild(label);
      thumbDiv.addEventListener('click', () => { const pageEls = document.querySelectorAll('.page'); if (pageEls[i - 1]) pageEls[i - 1].scrollIntoView({ behavior: 'smooth' }); });
      previewPanel.appendChild(thumbDiv);
    }
  }

  /* ========== UPDATE SINGLE THUMBNAIL (QUICK) ========== */
  async function updateThumbnail(pageIndex) {
    if (!previewPanel || !pdfDoc) return;
    const thumbs = previewPanel.querySelectorAll('.thumb');
    const thumbDiv = thumbs[pageIndex];
    if (!thumbDiv) return;
    const thumbCanvas = thumbDiv.querySelector('canvas');
    if (!thumbCanvas) return;
    try {
      const pageDiv = document.querySelectorAll('.page')[pageIndex];
      const baseCanvas = pageDiv.querySelector('canvas:not(.draw-layer)');
      const drawCanvas = pageDiv.querySelector('canvas.draw-layer');
      if (!baseCanvas) return;
      const merged = document.createElement('canvas'); merged.width = baseCanvas.width; merged.height = baseCanvas.height;
      const mctx = merged.getContext('2d'); mctx.drawImage(baseCanvas, 0, 0);
      if (drawCanvas) mctx.drawImage(drawCanvas, 0, 0);
      const scaleThumb = 0.15; thumbCanvas.width = merged.width * scaleThumb; thumbCanvas.height = merged.height * scaleThumb;
      const ctx = thumbCanvas.getContext('2d'); ctx.save(); ctx.scale(scaleThumb, scaleThumb); ctx.drawImage(merged, 0, 0); ctx.restore();
    } catch (e) { console.error('updateThumbnail error', e); }
  }

  /* ========== PDF ANNOTATION EXPORT (generateAnnotatedPdfBytes) ========== */
  async function generateAnnotatedPdfBytes(onProgress = null) {
    if (typeof PDFLib === 'undefined') throw new Error('PDFLib is not loaded.');
    const pages = document.querySelectorAll('.page');
    const doc = await PDFLib.PDFDocument.create();
    for (let i = 0; i < pages.length; i++) {
      const base = pages[i].querySelector('canvas:not(.draw-layer)');
      const draw = pages[i].querySelector('canvas.draw-layer');
      const merged = document.createElement('canvas'); merged.width = base.width; merged.height = base.height;
      const ctx = merged.getContext('2d'); ctx.drawImage(base, 0, 0); if (draw) ctx.drawImage(draw, 0, 0);
      const imgData = merged.toDataURL('image/png');
      const page = doc.addPage([merged.width, merged.height]);
      const png = await doc.embedPng(imgData);
      page.drawImage(png, { x: 0, y: 0, width: merged.width, height: merged.height });
      if (onProgress) onProgress(Math.round(((i + 1) / pages.length) * 100));
      // yield to event loop to keep UI responsive
      await new Promise(r => setTimeout(r, 0));
    }
    return await doc.save();
  }

  /* ========== SAVE / DOWNLOAD HANDLERS ========== */
  savePdfBtn?.addEventListener('click', async () => {
    try { showProgress(); setProgress(5); const bytes = await generateAnnotatedPdfBytes(p => setProgress(5 + Math.round(p * 0.9))); setProgress(95); const blob = new Blob([bytes], { type: 'application/pdf' }); const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'annotated.pdf'; a.click(); hideProgress(); } catch (err) { console.error(err); hideProgress(); alert('Gagal membangun PDF.'); }
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
    } catch (err) { console.error(err); hideProgress(); alert('⚠️ Error simpan ke server'); }
  });

  downloadJpgBtn?.addEventListener('click', async () => {
    try {
      const choice = prompt('📸 Pilih halaman (contoh: 1,3 or "all")'); if (!choice) return;
      const pages = document.querySelectorAll('.page');
      if (choice.toLowerCase() === 'all') {
        let totalH = 0, maxW = 0; const canvases = [];
        for (const p of pages) {
          const base = p.querySelector('canvas:not(.draw-layer)'); const draw = p.querySelector('canvas.draw-layer'); const merged = document.createElement('canvas'); merged.width = base.width; merged.height = base.height; const ctx = merged.getContext('2d'); ctx.drawImage(base, 0, 0); if (draw) ctx.drawImage(draw, 0, 0); canvases.push(merged); totalH += merged.height; if (merged.width > maxW) maxW = merged.width; }
        const final = document.createElement('canvas'); final.width = maxW; final.height = totalH; const fctx = final.getContext('2d'); let y = 0; for (const c of canvases) { fctx.drawImage(c, 0, y); y += c.height; }
        const link = document.createElement('a'); link.href = final.toDataURL('image/jpeg', 0.9); link.download = 'semua_halaman.jpg'; link.click(); alert('✅ Semua halaman diunduh sebagai JPG.'); return;
      } else {
        const parts = choice.split(',').map(x => parseInt(x.trim(), 10)).filter(n => !isNaN(n)); if (!parts.length) { alert('Nomor halaman tidak valid'); return; }
        for (const n of parts) {
          if (n < 1 || n > pages.length) continue; const base = pages[n - 1].querySelector('canvas:not(.draw-layer)'); const draw = pages[n - 1].querySelector('canvas.draw-layer'); const merged = document.createElement('canvas'); merged.width = base.width; merged.height = base.height; const ctx = merged.getContext('2d'); ctx.drawImage(base, 0, 0); if (draw) ctx.drawImage(draw, 0, 0); const link = document.createElement('a'); link.href = merged.toDataURL('image/jpeg', 0.9); link.download = 'halaman_' + n + '.jpg'; link.click(); }
        alert('✅ Halaman JPG berhasil diunduh.');
      }
    } catch (err) { console.error(err); alert('Gagal membuat JPG.'); }
  });

  saveServerTopBtn?.addEventListener('click', async () => {
    try { showProgress(); setProgress(5); const bytes = await generateAnnotatedPdfBytes(p => setProgress(5 + Math.round(p * 0.8))); setProgress(70); const blob = new Blob([bytes], { type: 'application/pdf' }); const form = new FormData(); form.append('pdf_file', blob, 'annotated_' + Date.now() + '.pdf'); const res = await fetch(window.baseUrl + 'index.php/notes/save_pdf_server', { method: 'POST', body: form }); const json = await res.json(); setProgress(100); hideProgress(); if (json.status === 'success') alert('✅ PDF berhasil disimpan di server:\n' + json.file); else alert('❌ Gagal simpan: ' + (json.message || 'unknown')); } catch (err) { console.error(err); hideProgress(); alert('⚠️ Terjadi kesalahan saat menyimpan ke server.'); }
  });

  downloadTopBtn?.addEventListener('click', (e) => { e.stopPropagation(); container?.dispatchEvent(new PointerEvent('pointerdown', e)); downloadDropdown?.classList.toggle('show'); });
  document.addEventListener('click', () => downloadDropdown?.classList.remove('show'));

  /* ========== INIT ========== */
  (async () => {
    try {
      showProgress(); setProgress(10);
      if (!pdfUrl) {
        // no pdf -> blank canvas mode
        await new Promise(r => setTimeout(r, 100));
        createBlankCanvasMode();
        hideProgress();
        return;
      }
      const loading = pdfjsLib.getDocument({ url: pdfUrl });
      pdfDoc = await loading.promise;
      baseScale = 1.0;
      await renderAllPages(false);
    } catch (e) {
      console.error(e); hideProgress(); alert('Gagal memuat PDF. Lihat console untuk detail.');
    }
  })();

  /* ========== BLANK CANVAS MODE ========== */
  function createBlankCanvasMode() {
    container.innerHTML = '';
const blankPage = document.createElement('div');
  blankPage.className = 'page';
  blankPage.style.position = 'relative';
  blankPage.style.margin = '8px auto';
  blankPage.style.background = '#fff';
  blankPage.style.width = '800px';
  blankPage.style.height = '1000px';

  const drawCanvas = document.createElement('canvas');
  drawCanvas.classList.add('draw-layer');
  drawCanvas.width = 800;
  drawCanvas.height = 1000;
  drawCanvas.style.position = 'absolute';
  drawCanvas.style.left = '0';
  drawCanvas.style.top = '0';
  drawCanvas.style.touchAction = 'none';
  blankPage.appendChild(drawCanvas);

  container.appendChild(blankPage);
  enableDrawingOnCanvas(drawCanvas, 0);
    // create one page-sized canvas with default A4 px size (approx)
    const w = 794; const h = 1123; // ~A4 96dpi
    const pageDiv = document.createElement('div'); pageDiv.className = 'page'; pageDiv.style.position = 'relative'; pageDiv.style.width = w + 'px'; pageDiv.style.height = h + 'px'; pageDiv.style.margin = '8px auto';
    const base = document.createElement('canvas'); base.width = w; base.height = h; base.style.display = 'block'; base.getContext('2d').fillStyle = '#fff'; base.getContext('2d').fillRect(0, 0, w, h); pageDiv.appendChild(base);
    const draw = document.createElement('canvas'); draw.className = 'draw-layer'; draw.width = w; draw.height = h; draw.style.position = 'absolute'; draw.style.left = '0'; draw.style.top = '0'; draw.style.touchAction = 'none'; pageDiv.appendChild(draw);
    container.appendChild(pageDiv);
    numPages = 1; pageStates = [{ dataURL: null, undoStack: [], redoStack: [] }]; enableDrawingOnCanvas(draw, 0);
    applyZoomTransform();
  }

  // expose some helpers for debugging (optional)
  window.okreConva = {
    renderAllPages,
    captureAllDrawsToStates,
    pageStates
  };
/* ========== RESPONSIVE VIEWPORT HANDLING ========== */

function applyResponsiveScaling() {
  if (!container) return;

  const containerWidth = container.clientWidth;
  const samplePage = container.querySelector('.page canvas:not(.draw-layer)');
  if (!samplePage) return;

  // lebar logis PDF (tanpa zoom)
  const logicalWidth = samplePage.width / previousScale;

  // skala yang pas agar halaman muat di layar (fit width)
  const fitScale = containerWidth / logicalWidth;

  // tentukan zoom terdekat dari daftar zoomLevels
  let bestIdx = 0, bestDiff = Infinity;
  for (let i = 0; i < zoomLevels.length; i++) {
    const diff = Math.abs(zoomLevels[i] - fitScale);
    if (diff < bestDiff) { bestDiff = diff; bestIdx = i; }
  }

  // update hanya jika berbeda
  if (currentZoomIndex !== bestIdx) {
    currentZoomIndex = bestIdx;
    applyZoomTransform(false);
  }
}

// panggil saat pertama load
window.addEventListener('load', () => {
  applyResponsiveScaling();
});

// panggil saat orientasi/resize berubah
window.addEventListener('resize', () => {
  // throttle biar tidak terlalu sering
  clearTimeout(window._resizeTimer);
  window._resizeTimer = setTimeout(applyResponsiveScaling, 400);
});

})();
