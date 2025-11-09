/* ========== Konfigurasi ========== */
const DEFAULT_W = 1080;
const DEFAULT_H = 1350;
const ZOOM_LEVELS = [0.5, 0.75, 0.9, 1.0, 1.25, 1.5, 2.0];
const DEFAULT_ZOOM_INDEX = ZOOM_LEVELS.indexOf(1.0);
const container = document.getElementById("container");
const previewPanel = document.getElementById("previewPanel");
let pages = []; // array of {pageEl, baseCanvas, drawCanvas, state}
let pageStates = [];
let currentZoom = 1.0;
const zoomLevels = [0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0];
let currentZoomIndex = DEFAULT_ZOOM_INDEX; // default 1.0
let previousScale = zoomLevels[currentZoomIndex] || 1.0;
let zoomIdx = 2;
let panMode = false;
let currentTool = "brush";
let color = "#000000ff";
let size = 4;
let allowTouchDrawing = true;

/* UI elements */
const zoomPercentLabel = document.getElementById("zoomPercent");
const addPageBtn = document.getElementById("addPageBtn");
const undoBtn = document.getElementById("btnUndo");
const redoBtn = document.getElementById("btnRedo");
const colorPicker = document.getElementById("colorPicker");
const colorPicker2 = document.getElementById("colorPicker2");
const sizePicker = document.getElementById("sizePicker");
const drawModeSelect = document.getElementById("drawMode");
const quickBrush = document.getElementById("quickBrush");
const quickEraser = document.getElementById("quickEraser");
const zoomPercent = document.getElementById("zoomPercent");
const panToggleBtn = document.getElementById("panToggleBtn");
const btnClear = document.getElementById("btnClear");
const settingsBtn = document.getElementById("settingsBtn");
const touchToggleBtn = document.getElementById("touchToggleBtn");
const touchToggleIcon = touchToggleBtn?.querySelector("i");

const toolButtons = [quickBrush, quickEraser, panToggleBtn];
const saveTopBtn = document.getElementById("saveTopBtn");

// function setActiveTool(selectedTool) {
//   tool = selectedTool;
//   if (panMode) {
//     setPanMode(false); // Matikan pan mode (dan cursor grab)
//   }
//   toolButtons.forEach((btn) => {
//     if (btn.id.toLowerCase().includes(selectedTool)) {
//       btn.classList.add("active");
//     } else {
//       btn.classList.remove("active");
//     }
//   });

//   let newCursor = "default"; // Default-nya panah

//   document.querySelectorAll(".draw-layer").forEach((c) => {
//     c.style.cursor = newCursor;
//   });
//   console.log("VEX: Alat diubah ke ->", tool);
// }

function setActiveTool(selectedTool) {
  currentTool = selectedTool;

  const isPan = currentTool === "pan";

  if (container) {
    container.style.cursor = isPan ? "grab" : "default";
  }
  let newCursor = "default"; // Panah (default)
  if (currentTool === "brush") newCursor = "crosshair";
  if (currentTool === "eraser") newCursor = "cell";

  document.querySelectorAll(".page").forEach((page) => {
    // 'page' (div putih) HARUS SELALU 'tembus'.
    page.style.pointerEvents = "none";

    const drawLayer = page.querySelector("canvas.draw-layer");
    const baseLayer = page.querySelector("canvas:not(.draw-layer)");

    if (isPan) {
      // MODE PAN: Matikan KEDUA layer
      if (drawLayer) drawLayer.style.pointerEvents = "none";
      if (baseLayer) baseLayer.style.pointerEvents = "none";
    } else {
      // MODE GAMBAR:
      if (baseLayer) baseLayer.style.pointerEvents = "none";

      let newCursor = currentTool === "brush" ? "crosshair" : "cell";
      if (currentTool !== "brush" && currentTool !== "eraser")
        newCursor = "default";

      if (drawLayer) {
        drawLayer.style.pointerEvents = "auto";
        drawLayer.style.cursor = newCursor;
      }
    }
  });

  toolButtons.forEach((btn) => {
    if (btn.id.toLowerCase().includes(currentTool)) {
      btn.classList.add("active");
    } else {
      btn.classList.remove("active");
    }
  });

  if (isPan) {
    // touchToggleBtn.style.pointerEvents = "none"; // <-- Ganti dari 'disabled'
    // touchToggleBtn.style.opacity = "0.5";
    touchToggleBtn.classList.remove("active");
    touchToggleIcon.className = "fa-solid fa-hand-sparkles";
  } else {
    touchToggleBtn.style.pointerEvents = "auto"; // <-- Ganti dari 'disabled'
    touchToggleBtn.style.opacity = "1";
    touchToggleBtn.classList.toggle("active", allowTouchDrawing);
    touchToggleIcon.className = allowTouchDrawing
      ? "fa-solid fa-hand-point-up" // (true) Ikon Jari
      : "fa-solid fa-pen-nib";
    touchToggleBtn.title = allowTouchDrawing
      ? "Mode Coretan Jari (Aktif)"
      : "Mode Pen Saja (Palm Rejection Aktif)";
  }

  console.log("VEX: Alat diubah ke ->", currentTool);
}

function setPanMode(enabled) {
  panMode = enabled;
  panToggleBtn?.classList.toggle("active", panMode);

  if (container) {
    // !! PERBAIKAN KURSOR !!
    // Container (area abu-abu) SEKARANG HANYA 'grab' atau 'default' (panah)
    container.style.cursor = panMode ? "grab" : "default";
    container.style.touchAction = "auto";
  }

  // atur canvas pointer events
  document.querySelectorAll(".page canvas.draw-layer").forEach((c) => {
    c.style.pointerEvents = panMode ? "none" : "auto";
  });
  document.querySelectorAll(".page canvas:not(.draw-layer)").forEach((c) => {
    c.style.pointerEvents = enabled ? "none" : "auto";
  });
}

/* helpers */

function updateZoomLabel() {
  if (!zoomPercentLabel) return;
  const pct = Math.round((zoomLevels[currentZoomIndex] / zoomLevels[2]) * 100);
  zoomPercentLabel.textContent = pct + "%";
}

function createPage(index, restoreDataURL) {
  const pageDiv = document.createElement("div");
  pageDiv.className = "page";
  pageDiv.style.width = DEFAULT_W * currentZoom + "px";
  pageDiv.style.height = DEFAULT_H * currentZoom + "px";

  // base white canvas
  const base = document.createElement("canvas");
  base.width = DEFAULT_W;
  base.height = DEFAULT_H;
  base.style.width = DEFAULT_W * currentZoom + "px";
  base.style.height = DEFAULT_H * currentZoom + "px";
  const bctx = base.getContext("2d");
  bctx.fillStyle = "#ffffff";
  bctx.fillRect(0, 0, base.width, base.height);
  pageDiv.appendChild(base);

  // draw layer
  const draw = document.createElement("canvas");
  draw.className = "draw-layer";
  draw.width = DEFAULT_W;
  draw.height = DEFAULT_H;
  draw.style.position = "absolute";
  draw.style.left = "0";
  draw.style.top = "0";
  draw.style.width = DEFAULT_W * currentZoom + "px";
  draw.style.height = DEFAULT_H * currentZoom + "px";
  pageDiv.appendChild(draw);

  container.appendChild(pageDiv);

  const state = {
    undoStack: [],
    redoStack: [],
    dataURL: null,
  };
  pages.splice(index, 0, {
    pageEl: pageDiv,
    baseCanvas: base,
    drawCanvas: draw,
    state,
  });

  // restore if provided
  if (restoreDataURL) {
    const img = new Image();
    img.onload = () => {
      const ctx = draw.getContext("2d");
      ctx.clearRect(0, 0, draw.width, draw.height);
      ctx.drawImage(img, 0, 0, draw.width, draw.height);
      state.dataURL = draw.toDataURL();
      updateThumbnail();
    };
    img.src = restoreDataURL;
  }

  enableDrawing(draw, pages.indexOf(pages.find((p) => p.drawCanvas === draw)));
  rebuildThumbnails();
  return pages[pages.findIndex((p) => p.drawCanvas === draw)];
}

function addNewPage() {
  createPage(pages.length);
  scrollToPage(pages.length - 1);
  setTimeout(() => {
    autoZoomToFit();
  }, 200);
}

function removePage(index) {
  if (index < 0 || index >= pages.length) return;
  const p = pages[index];
  p.pageEl.remove();
  pages.splice(index, 1);
  rebuildThumbnails();
}

/* drawing */
function getPointerPos(canvas, e) {
  const rect = canvas.getBoundingClientRect();
  const t = e.touches ? e.touches[0] : e;
  return {
    x: (t.clientX - rect.left) * (canvas.width / rect.width),
    y: (t.clientY - rect.top) * (canvas.height / rect.height),
  };
}

function enableDrawing(drawCanvas, pageIndex) {
  const ctx = drawCanvas.getContext("2d");
  ctx.lineJoin = "round";
  ctx.lineCap = "round";
  const s = pages[pageIndex].state;
  let drawing = false,
    last = { x: 0, y: 0 },
    hasDraw = false;

  function saveSnapshot() {
    try {
      s.undoStack.push(drawCanvas.toDataURL());
      if (s.undoStack.length > 50) s.undoStack.shift();
      s.redoStack = [];
    } catch (e) {}
  }
  function getPointerPos(canvas, e) {
    const rect = canvas.getBoundingClientRect();
    // FIX: 'e.touches' tidak lagi diperlukan, 'e' adalah event pointer
    const t = e;
    return {
      x: (t.clientX - rect.left) * (canvas.width / rect.width),
      y: (t.clientY - rect.top) * (canvas.height / rect.height),
    };
  }

  function start(e) {
    if (currentTool === "pan") {
      return;
    }

    if (
      currentTool === "brush" && // JIKA alatnya kuas
      e.pointerType === "touch" && // DAN inputnya sentuh
      !allowTouchDrawing // DAN Pen Mode aktif
    ) {
      return; // Abaikan sentuhan
    }

    e.preventDefault();
    drawing = true;
    hasDraw = false;
    last = getPointerPos(drawCanvas, e);
    saveSnapshot();

    window.addEventListener("pointermove", move);
    window.addEventListener("pointerup", end);
    window.addEventListener("pointercancel", end);
    window.addEventListener("pointerleave", end);
    drawCanvas.setPointerCapture?.(e.pointerId);
  }

  drawCanvas.addEventListener("pointerdown", start, { passive: false });

  function move(e) {
    if (!drawing || panMode) return;
    e.preventDefault();
    const pos = getPointerPos(drawCanvas, e);
    ctx.globalCompositeOperation =
      currentTool === "eraser" ? "destination-out" : "source-over";
    ctx.strokeStyle = color;
    ctx.lineWidth = size;
    ctx.beginPath();
    ctx.moveTo(last.x, last.y);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
    last = pos;
    hasDraw = true;
  }
  function end(e) {
    if (!drawing) return;
    drawing = false;
    ctx.globalCompositeOperation = "source-over";
    if (hasDraw) {
      try {
        s.dataURL = drawCanvas.toDataURL();
      } catch (e) {}
      updateThumbnailForIndex(pageIndex);
    }
    window.removeEventListener("pointermove", move);
    window.removeEventListener("pointerup", end);
    window.removeEventListener("pointercancel", end); // (Menangani 'cancel')
    window.removeEventListener("pointerleave", end); // (Menangani 'leave')
    drawCanvas.releasePointerCapture?.(e.pointerId);
  }
  // drawCanvas.addEventListener("mousedown", start);
  // drawCanvas.addEventListener("touchstart", start, { passive: false });
  drawCanvas._doUndo = function () {
    if (!s.undoStack.length) return;
    const prev = s.undoStack.pop();
    s.redoStack.push(drawCanvas.toDataURL());
    const img = new Image();
    img.onload = () => {
      ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
      ctx.drawImage(img, 0, 0);
      s.dataURL = prev;
      updateThumbnailForIndex(pageIndex);
    };
    img.src = prev;
  };
  drawCanvas._doRedo = function () {
    if (!s.redoStack.length) return;
    const next = s.redoStack.pop();
    s.undoStack.push(drawCanvas.toDataURL());
    const img = new Image();
    img.onload = () => {
      ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
      ctx.drawImage(img, 0, 0);
      s.dataURL = next;
      updateThumbnailForIndex(pageIndex);
    };
    img.src = next;
  };
}

/* thumbnails */
function clearThumbnails() {
  previewPanel.innerHTML = "";
}
function createThumb(i) {
  const thumb = document.createElement("div");
  thumb.className = "thumb";
  thumb.dataset.index = i;
  const pnum = document.createElement("div");
  pnum.className = "page-num";
  pnum.textContent = i + 1;
  thumb.appendChild(pnum);
  const canvas = document.createElement("canvas");
  canvas.width = 200;
  canvas.height = 250;
  canvas.style.width = "64px";
  canvas.style.height = "auto";
  thumb.appendChild(canvas);
  thumb.addEventListener("click", () => scrollToPage(i));
  previewPanel.appendChild(thumb);
  thumb._canvas = canvas;
  return thumb;
}
function rebuildThumbnails() {
  clearThumbnails();
  pages.forEach((p, i) => {
    const t = createThumb(i);
    updateThumbnailForIndex(i);
  });
  observeActivePage();
}
function updateThumbnailForIndex(i) {
  const p = pages[i];
  if (!p) return;
  const tmp = document.createElement("canvas");
  tmp.width = p.baseCanvas.width;
  tmp.height = p.baseCanvas.height;
  const tctx = tmp.getContext("2d");
  tctx.drawImage(p.baseCanvas, 0, 0);
  tctx.drawImage(p.drawCanvas, 0, 0);
  const thumb = previewPanel.children[i];
  if (!thumb) return;
  const tc = thumb._canvas;
  const scale = Math.min(160 / tmp.width, 1);
  tc.width = Math.round(tmp.width * scale);
  tc.height = Math.round(tmp.height * scale);
  tc.getContext("2d").clearRect(0, 0, tc.width, tc.height);
  tc.getContext("2d").drawImage(
    tmp,
    0,
    0,
    tmp.width,
    tmp.height,
    0,
    0,
    tc.width,
    tc.height
  );
}

/* active page highlight */
let pageObserver = null;
function observeActivePage() {
  if (pageObserver) pageObserver.disconnect();
  const opts = {
    root: container,
    rootMargin: "0px",
    threshold: [0.45, 0.6, 0.9],
  };
  pageObserver = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) {
        const idx = Array.from(container.querySelectorAll(".page")).indexOf(
          en.target
        );
        if (idx >= 0) {
          Array.from(previewPanel.children).forEach((c) =>
            c.classList.remove("active")
          );
          const t = previewPanel.children[idx];
          if (t) t.classList.add("active");
        }
      }
    });
  }, opts);
  document.querySelectorAll(".page").forEach((p) => pageObserver.observe(p));
}

/* scrolling */
function scrollToPage(i) {
  const pagesEls = container.querySelectorAll(".page");
  if (pagesEls[i])
    pagesEls[i].scrollIntoView({ behavior: "smooth", block: "center" });
}

/* undo/redo bindings */
undoBtn.addEventListener("click", () => {
  const c = getFocusedDrawCanvas();
  if (c && c._doUndo) c._doUndo();
});
redoBtn.addEventListener("click", () => {
  const c = getFocusedDrawCanvas();
  if (c && c._doRedo) c._doRedo();
});
function getFocusedDrawCanvas() {
  const pageEls = Array.from(container.querySelectorAll(".page"));
  const rect = container.getBoundingClientRect();
  let best = null,
    bestOverlap = -1;
  for (const p of pageEls) {
    const r = p.getBoundingClientRect();
    const top = Math.max(r.top, rect.top);
    const bottom = Math.min(r.bottom, rect.bottom);
    const overlap = Math.max(0, bottom - top);
    if (overlap > bestOverlap) {
      bestOverlap = overlap;
      best = p;
    }
  }
  return best ? best.querySelector("canvas.draw-layer") : null;
}

/* clear all */
btnClear?.addEventListener("click", () => {
  // 1. Tampilkan dialog konfirmasi DULU
  Swal.fire({
    title: "Hapus Semua Coretan?",
    text: "Anda yakin ingin membersihkan semua halaman?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33", // Merah untuk tombol hapus
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Ya, Hapus Semua!",
    cancelButtonText: "Batal",
  }).then((result) => {
    // 2. Hanya jalankan jika pengguna menekan "Ya"
    if (result.isConfirmed) {
      // 3. PINDAHKAN SEMUA LOGIKA LAMA ANDA KE SINI
      document.querySelectorAll("canvas.draw-layer").forEach((c, i) => {
        const ctx = c.getContext("2d");
        if (pages[i]) {
          try {
            // (Mencadangkan ke undo stack sebelum menghapus)
            const snap = c.toDataURL();
            pages[i].undoStack.push(snap);
            if (pages[i].undoStack.length > 30) pages[i].undoStack.shift();
          } catch (err) {
            console.error(err);
          }
          ctx.clearRect(0, 0, c.width, c.height);
          pages[i].dataURL = null;
          pages[i].redoStack = [];
          requestIdleCallback(() => updateThumbnail(i));
        }
      }); // Akhir dari forEach

      // 4. Ganti 'alert()' dengan notifikasi sukses SweetAlert
      Swal.fire({
        title: "Dihapus!",
        text: "Semua coretan telah dibersihkan.",
        icon: "success",
        timer: 1500, // Notifikasi hilang setelah 1.5 detik
        showConfirmButton: false,
      });
    }
  }); // Akhir dari .then()
});

document.addEventListener("DOMContentLoaded", () => {
  const btnDraw = document.getElementById("btnDraw");
  const popupDraw = document.getElementById("popupDraw");
  btnDraw.addEventListener("click", (e) => {
    e.stopPropagation();
    togglePopup(popupDraw);
  });

  popupDraw.addEventListener("click", (e) => {
    e.stopPropagation();
  });

  const popupZoom = document.getElementById("popupZoom");
  if (popupZoom) {
    popupZoom.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }

  const settingsPopup = document.getElementById("settingsPopup");
  if (settingsPopup) {
    settingsPopup.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }

  /* zoom/pan */
  document.getElementById("zoomInBtn").addEventListener("click", () => {
    if (currentZoomIndex < ZOOM_LEVELS.length - 1) {
      saveAllDrawStates();
      currentZoomIndex++; // Ganti dari zoomIdx
      currentZoom = ZOOM_LEVELS[currentZoomIndex]; // Ganti dari zoomLevels
      rescaleAll();
      updateZoomLabel();
    }
  });
  document.getElementById("zoomOutBtn").addEventListener("click", () => {
    if (currentZoomIndex > 0) {
      saveAllDrawStates();
      currentZoomIndex--; // Ganti dari zoomIdx
      currentZoom = ZOOM_LEVELS[currentZoomIndex]; // Ganti dari zoomLevels
      rescaleAll();
      updateZoomLabel();
    }
  });
  document.getElementById("fitBtn").addEventListener("click", () => {
    // fit width logic
    const viewportWidth = container.clientWidth - 60;
    const ratio = viewportWidth / DEFAULT_W;
    let best = 0,
      bdiff = Infinity;

    // Gunakan 'ZOOM_LEVELS'
    ZOOM_LEVELS.forEach((z, i) => {
      const d = Math.abs(z - ratio);
      if (d < bdiff) {
        bdiff = d;
        best = i;
      }
    });

    saveAllDrawStates();
    currentZoomIndex = best; // Ganti dari zoomIdx
    currentZoom = ZOOM_LEVELS[currentZoomIndex]; // Ganti dari zoomLevels
    rescaleAll();
    updateZoomLabel();
  });
});

// document.getElementById("panToggleBtn").addEventListener("click", () => {
//   panMode = !panMode;
//   document.getElementById("panToggleBtn").textContent =
//     "Pan: " + (panMode ? "ON" : "OFF");
//   container.style.cursor = panMode ? "grab" : "default";
// });
// panToggleBtn?.addEventListener("click", () => setPanMode(!panMode));
let isPanning = false,
  startPan = { x: 0, y: 0 },
  scrollStart = { x: 0, y: 0 };
container.addEventListener("mousedown", (e) => {
  if (currentTool !== "pan") {
    return; // Keluar jika BUKAN mode pan
  }
  isPanning = true;
  container.style.cursor = "grabbing"; // Kursor 'grabbing' saat menahan klik
  startPan = { x: e.clientX, y: e.clientY };
  scrollStart = { x: container.scrollLeft, y: container.scrollTop };
});

container.addEventListener("mousemove", (e) => {
  if (!isPanning) return;
  const dx = e.clientX - startPan.x;
  const dy = e.clientY - startPan.y;
  container.scrollLeft = scrollStart.x - dx;
  container.scrollTop = scrollStart.y - dy;
});
container.addEventListener("mouseup", () => {
  if (!isPanning) return; // (Lebih baik tambahkan cek ini)
  isPanning = false;
  container.style.cursor = "grab";
});

/* save state helpers */
function saveAllDrawStates() {
  pages.forEach((p) => {
    try {
      p.state.dataURL = p.drawCanvas.toDataURL();
    } catch (e) {}
  });
}
function rescaleAll() {
  saveAllDrawStates(); // simpan semua coretan terlebih dahulu
  container.innerHTML = "";

  const loadPromises = pages.map((p, idx) => {
    const data = p.state.dataURL;
    const pageDiv = document.createElement("div");
    pageDiv.className = "page";
    pageDiv.style.width = DEFAULT_W * currentZoom + "px";
    pageDiv.style.height = DEFAULT_H * currentZoom + "px";
    pageDiv.style.position = "relative";
    pageDiv.style.margin = "20px auto";
    pageDiv.style.boxShadow = "0 0 10px rgba(0,0,0,0.1)";
    pageDiv.style.background = "white";
    pageDiv.style.transformOrigin = "top center";
    pageDiv.style.transition = "transform 0.2s ease";
    pageDiv.style.transform = `scale(${currentZoom})`;

    const base = document.createElement("canvas");
    base.width = DEFAULT_W;
    base.height = DEFAULT_H;
    base.style.width = "100%";
    base.style.height = "100%";
    const bctx = base.getContext("2d");
    bctx.fillStyle = "#ffffff";
    bctx.fillRect(0, 0, base.width, base.height);
    pageDiv.appendChild(base);

    const draw = document.createElement("canvas");
    draw.className = "draw-layer";
    draw.width = DEFAULT_W;
    draw.height = DEFAULT_H;
    draw.style.position = "absolute";
    draw.style.left = "0";
    draw.style.top = "0";
    draw.style.width = "100%";
    draw.style.height = "100%";
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
        draw.getContext("2d").drawImage(img, 0, 0);
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
colorPicker.addEventListener("change", (e) => {
  color = e.target.value;
  colorPicker2.value = color;
});
colorPicker2.addEventListener("change", (e) => {
  color = e.target.value;
  colorPicker.value = color;
});
document.querySelectorAll(".color-swatch").forEach((s) =>
  s.addEventListener("click", () => {
    const c = s.dataset.color;
    color = c;
    colorPicker.value = c;
    colorPicker2.value = c;
  })
);
sizePicker.addEventListener("input", (e) => (size = Number(e.target.value)));

quickBrush?.addEventListener("click", () => {
  setActiveTool("brush");
  // (Anda bisa biarkan logic color/size picker di sini)
  colorPicker.value = color;
  sizePicker.value = size;
});
quickEraser?.addEventListener("click", () => {
  setActiveTool("eraser");
});
panToggleBtn?.addEventListener("click", () => {
  setActiveTool("pan");
});
// touchToggleBtn?.addEventListener("click", () => {
//   // Balik 'state' boolean-nya
//   allowTouchDrawing = !allowTouchDrawing;

//   console.log("baca sini");

//   // Perbarui tampilan tombol
//   touchToggleBtn.classList.toggle("active", allowTouchDrawing);
//   if (allowTouchDrawing) {
//     touchToggleIcon.className = "fa-solid fa-hand-point-up"; // Ikon "Touch"
//     touchToggleBtn.title = "Mode Coretan Jari (Aktif)";
//   } else {
//     //touchToggleIcon.className = "fa-solid fa-pen-nib"; // Ikon "Pen"
//     touchToggleBtn.title = "Mode Pen Saja (Palm Rejection Aktif)";
//   }
// });
touchToggleBtn?.addEventListener("click", () => {
  allowTouchDrawing = !allowTouchDrawing;
  if (currentTool === "pan") {
    setActiveTool("brush");
  } else {
    setActiveTool(currentTool);
  }
});
colorPicker?.addEventListener("change", (e) => {
  color = e.target.value;
  if (colorPicker2) colorPicker2.value = color;
});
sizePicker?.addEventListener("input", (e) => {
  size = Number(e.target.value);
});

/* thumbnails + add page interactions */
addPageBtn.addEventListener("click", () => addNewPage());
const deletePageBtn = document.getElementById("deletePageBtn");
deletePageBtn.addEventListener("click", () => {
  const activeIndex = [...previewPanel.children].findIndex((c) =>
    c.classList.contains("active")
  );
  if (activeIndex < 0) {
    alert("Tidak ada halaman aktif untuk dihapus.");
    return;
  }
  if (!confirm("Yakin ingin menghapus halaman ke-" + (activeIndex + 1) + "?"))
    return;
  removePage(activeIndex);
});

/* export to PDF */
async function generatePdfBytes() {
  saveAllDrawStates();
  const pdfDoc = await PDFLib.PDFDocument.create();
  for (let i = 0; i < pages.length; i++) {
    const p = pages[i]; // merge base+draw
    const tmp = document.createElement("canvas");
    tmp.width = p.baseCanvas.width;
    tmp.height = p.baseCanvas.height;
    const tctx = tmp.getContext("2d");
    tctx.drawImage(p.baseCanvas, 0, 0);
    tctx.drawImage(p.drawCanvas, 0, 0);
    const pngData = tmp.toDataURL("image/png");
    const page = pdfDoc.addPage([tmp.width, tmp.height]);
    const pngImage = await pdfDoc.embedPng(pngData);
    page.drawImage(pngImage, {
      x: 0,
      y: 0,
      width: tmp.width,
      height: tmp.height,
    });
  }
  return await pdfDoc.save();
}
function setThemeLight() {
  document.getElementById("appRoot")?.classList.remove("theme-dark");
  document.documentElement.style.setProperty("--blue-500", "#1976d2");
  document.documentElement.style.setProperty("--blue-600", "#1565c0");
  document.documentElement.style.setProperty(
    "--sidebar-bg",
    "linear-gradient(180deg,var(--card),#f0f7ff)"
  );
}
function setThemeDark() {
  document.getElementById("appRoot")?.classList.add("theme-dark");
}

settingsBtn?.addEventListener("click", (e) => {
  e.stopPropagation();
  if (!settingsPopup) return;
  settingsPopup.style.display =
    settingsPopup.style.display === "block" ? "none" : "block";
});
settingsPopup?.addEventListener("click", (e) => e.stopPropagation());
themeLightBtn?.addEventListener("click", setThemeLight);
themeDarkBtn?.addEventListener("click", setThemeDark);

/* init: create two pages */
// (function init() {
//   createPage(0);
//   updateZoomLabel();

//   setActiveTool("brush");
// })();

(function init() {
  if (window.restoredCanvasData) {
    console.log("VEX: Data coretan ditemukan, memuat...");
    try {
      const data = JSON.parse(window.restoredCanvasData);

      if (data.canvas_data && data.canvas_data.length > 0) {
        data.canvas_data.forEach((pageData, index) => {
          createPage(index, pageData.dataURL);
        });
      } else {
        createPage(0);
      }
    } catch (e) {
      console.error("VEX: Gagal parse data JSON, membuat canvas kosong.", e);
      createPage(0); // Gagal parse, buat 1 halaman
    }
  } else {
    // 5. Tidak ada data (Mode "Baru")
    console.log("VEX: Mode 'Baru'. Membuat 1 halaman kosong.");
    createPage(0); // Buat 1 halaman kosong
  }
  updateZoomLabel();
  setActiveTool("brush"); // Set default tool
  allowTouchDrawing = false;
  touchToggleBtn.classList.remove("active");
  touchToggleIcon.className = "fa-solid fa-hand-point-up";
  touchToggleBtn.title = "Mode Pen Saja (Palm Rejection Aktif)";
})();

/* utilities */
function updateThumbnail() {
  pages.forEach((p, i) => updateThumbnailForIndex(i));
}
function autoZoomToFit() {
  const container = document.querySelector(".container");
  const page = document.querySelector(".page");
  if (!container || !page) return;

  const maxWidth = container.clientWidth * 0.9; // sedikit margin
  const zoom = maxWidth / DEFAULT_W;
  currentZoom = Math.min(zoom, 1.0); // maksimal 100%
  rescaleAll();
  updateZoomLabel();
  function rescaleAll() {
    const pages = document.querySelectorAll(".page");
    pages.forEach((pg) => {
      pg.style.width = DEFAULT_W * currentZoom + "px";
      pg.style.height = DEFAULT_H * currentZoom + "px";
      pg.style.transform = `scale(${currentZoom})`;
    });
  }
}

async function saveBlankCanvasToServer(noteName) {
  try {
    saveAllDrawStates(); // (Fungsi ini dari file 500 baris Anda)
    const dataToSave = pages.map((p) => {
      return {
        dataURL: p.state.dataURL,
      };
    });

    // 3. Siapkan paket data (payload)
    const payload = {
      note_name: noteName,
      canvas_data: dataToSave,
    };

    // 4. Kirim ke Controller CI3
    const response = await fetch(BaseURL + "notes/save_blank_canvas", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const result = await response.json();

    if (!response.ok || result.status !== "success") {
      throw new Error(result.message || "Gagal merespons server");
    }

    // 5. Sukses, kembalikan hasilnya
    return result;
  } catch (err) {
    // 6. Gagal, lempar error agar bisa ditangkap SweetAlert
    console.error("VEX: Gagal menyimpan canvas:", err);
    throw err;
  }
}

saveTopBtn?.addEventListener("click", () => {
  Swal.fire({
    title: "Simpan Coretan",
    text: "Masukkan nama untuk file coretan Anda:",
    input: "text",
    inputPlaceholder: "Coretan Rapat Mingguan...",
    showCancelButton: true,
    confirmButtonText: "Simpan",
    cancelButtonText: "Batal",

    // Validasi input (tidak boleh kosong)
    inputValidator: (value) => {
      if (!value) {
        return "Nama file tidak boleh kosong!";
      }
    },
  }).then(async (result) => {
    // 2. Jika pengguna mengklik "Simpan" (dan valid)
    if (result.isConfirmed && result.value) {
      const noteName = result.value;
      Swal.fire({
        title: "Menyimpan...",
        text: "Mengirim data ke server. Mohon tunggu.",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      try {
        // 4. Panggil "Mesin"
        const saveResult = await saveBlankCanvasToServer(noteName);

        Swal.fire({
          title: "Tersimpan!",
          text:
            "Coretan Anda telah disimpan (ID: " +
            saveResult.new_note_id +
            "). Apa selanjutnya?",
          icon: "success",
          showCancelButton: true,
          confirmButtonText: "Kembali",
          cancelButtonText: "Tetap di Sini",
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#6c757d",
        }).then((result) => {
          if (result.isConfirmed) {
            // Pengguna memilih "Kembali"
            const backUrlInput = document.getElementById("back_url");

            if (backUrlInput && backUrlInput.value) {
              window.location.href = backUrlInput.value;
            } else {
              console.error(
                "VEX: Input #back_url tidak ditemukan atau kosong."
              );
            }
          }
          // Jika 'isDismissed' (klik "Tetap di Sini"), alert tertutup.
        });
      } catch (err) {
        // 6. Tampilkan notifikasi Gagal
        Swal.fire("Error", "Terjadi kesalahan: " + err.message, "error");
      }
    }
  }); // Akhir .then()
});

/* [TAMBAHKAN INI DI FILE JS "BLANK CANVAS" ANDA] */

// Pastikan ini berjalan setelah DOM siap
document.addEventListener("DOMContentLoaded", () => {
  const cancelBtn = document.getElementById("cancelBtn");
  const confirmModalEl = document.getElementById("confirmModal");

  if (typeof bootstrap === "undefined") {
    console.error(
      "VEX: Bootstrap JS tidak dimuat. Modal tidak akan berfungsi."
    );
    return;
  }

  const modalInstance = new bootstrap.Modal(confirmModalEl);
  const btnTutupHalaman = document.getElementById("btnTutupHalaman");
  const btnSimpanPerubahan = document.getElementById("btnSimpanPerubahan");

  const backUrl = cancelBtn.href;

  cancelBtn.addEventListener("click", (e) => {
    e.preventDefault();
    modalInstance.show();
  });

  btnTutupHalaman.addEventListener("click", () => {
    window.location.href = backUrl;
  });

  btnSimpanPerubahan.addEventListener("click", () => {
    modalInstance.hide();

    Swal.fire({
      title: "Simpan Coretan",
      text: "Masukkan nama untuk file coretan Anda:",
      input: "text",
      inputPlaceholder: "Coretan Rapat Mingguan...",
      showCancelButton: true,
      confirmButtonText: "Simpan & Tutup",
      cancelButtonText: "Batal",
      inputValidator: (value) => {
        if (!value) {
          return "Nama file tidak boleh kosong!";
        }
      },
    }).then(async (result) => {
      // 4c. Jika pengguna memasukkan nama dan mengklik "Simpan & Tutup"
      if (result.isConfirmed && result.value) {
        const noteName = result.value;

        // Tampilkan "Loading"
        Swal.fire({
          title: "Menyimpan...",
          text: "Mengirim data ke server. Mohon tunggu.",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        try {
          // 4d. Panggil "Mesin" Penyimpanan
          await saveBlankCanvasToServer(noteName);

          // 4e. SUKSES: Tutup SweetAlert 'loading' dan REDIRECT
          Swal.close();
          window.location.href = backUrl; // Navigasi ke halaman 'notes'
        } catch (err) {
          // 4f. GAGAL: Tampilkan error
          Swal.fire("Error", "Terjadi kesalahan: " + err.message, "error");
        }
      }
      // Jika pengguna 'Batal' dari SweetAlert, tidak terjadi apa-apa.
    });
  }); // Akhir listener 'btnSimpanPerubahan'
}); // Akhir DOMContentLoaded
