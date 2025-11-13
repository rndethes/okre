<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= isset($note->name_notes) ? htmlspecialchars($note->name_notes) : 'Untitled Document' ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/konva@9.2.0/konva.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f3f4f6;
      height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      color: #333;
    }
    header {
      height: 58px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      border-bottom: 1px solid #ddd;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      z-index: 5;
    }
    .header-left { display: flex; align-items: center; gap: 12px; }
    .header-left i { font-size: 20px; color: #007bff; }
    .doc-header { display: flex; flex-direction: column; line-height: 1.2; }
    .doc-title { font-weight: 600; font-size: 15px; color: #202124; }
    .doc-meta { font-size: 12px; color: #70757a; margin-top: 1px; }
    .header-right { display: flex; align-items: center; gap: 12px; }
    .view-badge {
      font-size: 13px; padding: 4px 10px;
      background: #e0f2fe; color: #007bff;
      border-radius: 8px; font-weight: 500;
    }
    .back-btn {
      display: flex; align-items: center; gap: 6px;
      text-decoration: none; color: #555;
      font-size: 14px; transition: 0.2s;
      border: 1px solid #ddd; padding: 6px 10px;
      border-radius: 6px; background: #fafafa;
    }
    .back-btn:hover { background: #007bff; color: #fff; border-color: #007bff; }
    main { flex: 1; display: flex; overflow: hidden; }
    #leftbar {
      width: 180px; background: #fff;
      border-right: 1px solid #ddd;
      display: flex; flex-direction: column;
      padding: 16px; overflow-y: auto;
      box-shadow: 2px 0 5px rgba(0,0,0,0.05);
      z-index: 2;
    }
    #leftbar h3 { font-size: 16px; font-weight: 600; margin-bottom: 12px; color: #444; }
    .preview-page {
  border: 1px solid #ddd; 
  border-radius: 6px;
  margin-bottom: 8px;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.2s ease;
  background: #fafafa;
  width: 80px;       
  height: auto;  
    }
    .preview-page:hover {
      transform: translateY(-2px);
      border-color: #007bff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .preview-page img { 
      width: 100%;        
  height: auto;       
  display: block;
    }
    #mainArea {
      flex: 1; background: linear-gradient(180deg, #f9fafb, #eef1f4);
      overflow-y: auto; display: flex; flex-direction: column;
      align-items: center; padding: 20px 0; position: relative;
    }
    #viewerContainer {
      width: 90%; background: transparent;
      border: none; border-radius: 0;
      min-height: 90vh;
    }
    .page-container { position: relative; margin: 1rem auto; display: block; background: transparent; width: fit-content; }
    canvas.pdf-page { display: block; position: relative; z-index: 1; }
    .konva-layer { position: absolute; top: 0; left: 0; z-index: 2; pointer-events: none; }
    p.empty { color: #666; font-size: 15px; text-align: center; margin-top: 40px; }
    .zoom-controls {
      position: fixed; right: 20px; bottom: 30px;
      display: flex; flex-direction: column; gap: 8px;
      background: #fff; border: 1px solid #ddd;
      border-radius: 10px; padding: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 20;
    }
    .zoom-btn {
      width: 40px; height: 40px; display: flex;
      align-items: center; justify-content: center;
      border-radius: 8px; background: #f8f9fa;
      border: none; cursor: pointer; font-size: 18px;
      color: #333; transition: 0.2s;
    }
    .zoom-btn:hover { background: #007bff; color: #fff; }
    .toast-refresh {
      position: fixed; bottom: 20px; right: 20px;
      background: #007bff; color: #fff; padding: 10px 16px;
      border-radius: 8px; font-size: 14px; display: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    #previewPanel {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
  </style>
</head>
<body>
<header>
  <div class="header-left">
    <i class="fa-solid fa-file-lines"></i>
    <div class="doc-header">
      <div class="doc-title"><?= htmlspecialchars($note->name_notes ?? 'Untitled Document') ?></div>
      <div class="doc-meta">
        <?= htmlspecialchars($note->owner_name ?? 'Unknown Owner') ?> • 
        <span id="lastUpdate"><?= isset($last_update) ? date('d M Y, H:i', strtotime($last_update)) : 'Tanggal tidak tersedia' ?></span>
      </div>
    </div>
  </div>

  <div class="header-right">
    <span class="view-badge"><i class="fa-solid fa-eye"></i> View Only</span>
    <button class="btn btn-sm btn-outline-primary" id="refreshBtn">
      <i class="fa-solid fa-rotate-right"></i> Refresh Dokumen
    </button>
    <a href="<?= base_url('notes') ?>" class="back-btn">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
  </div>
</header>

<main>
  <div id="leftbar">
    <h3>Preview Dokumen</h3>
    <div id="previewPanel">
      <?php if (!empty($pages)): ?>
        <?php foreach ($pages as $index => $page): ?>
          <div class="preview-page" onclick="scrollToPage(<?= $index ?>)">
            <img src="<?= base_url($page['file_path']) ?>" alt="Halaman <?= $index+1 ?>">
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div id="mainArea">
    <?php if (!empty($pdf_url)): ?>
      <div id="viewerContainer"></div>
    <?php elseif ($is_blank_mode): ?>
      <div id="blankCanvasContainer" style="width:90%; height:90vh; background:#fff; box-shadow:0 0 8px rgba(0,0,0,0.1); border-radius:8px; position:relative;"></div>
    <?php else: ?>
      <p class="empty">Tidak ada dokumen untuk ditampilkan.</p>
    <?php endif; ?>
  </div>
</main>

<div class="zoom-controls">
  <button class="zoom-btn" id="zoomIn"><i class="fa-solid fa-plus"></i></button>
  <button class="zoom-btn" id="zoomOut"><i class="fa-solid fa-minus"></i></button>
</div>
<div id="toastRefresh" class="toast-refresh">✅ Dokumen diperbarui</div>

<script>
const pdfUrl = "<?= $pdf_url ?? '' ?>";
const loadJsonUrl = "<?= $load_json_url ?? '' ?>";
let canvasData = {};
let currentScale = 1.3;

async function loadCanvasData() {
  if (!loadJsonUrl) return;
  try {
    const res = await fetch(loadJsonUrl);
    const result = await res.json();
    if (result.status === "success" && result.data) canvasData = result.data;
  } catch (err) { console.error("Gagal memuat coretan:", err); }
}

async function renderPDF() {
  if (!pdfUrl) return;
  await loadCanvasData();

  const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
  const container = document.getElementById("viewerContainer");
  container.innerHTML = "";

  for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
    const page = await pdf.getPage(pageNum);
    const viewport = page.getViewport({ scale: currentScale });
    const pageDiv = document.createElement("div");
    pageDiv.className = "page-container";
    pageDiv.id = "page-" + pageNum;

    const pdfCanvas = document.createElement("canvas");
    pdfCanvas.className = "pdf-page";
    pdfCanvas.width = viewport.width;
    pdfCanvas.height = viewport.height;
    pageDiv.appendChild(pdfCanvas);

    const ctx = pdfCanvas.getContext("2d");
    await page.render({ canvasContext: ctx, viewport }).promise;

    const konvaDiv = document.createElement("div");
    konvaDiv.className = "konva-layer";
    pageDiv.appendChild(konvaDiv);

    const stage = new Konva.Stage({ container: konvaDiv, width: viewport.width, height: viewport.height });
    const layer = new Konva.Layer();
    stage.add(layer);

    if (canvasData[pageNum]) {
      try {
        const savedStage = Konva.Node.create(canvasData[pageNum]);
        layer.add(...savedStage.getChildren());
        layer.draw();
      } catch (err) { console.error(`Gagal memuat coretan halaman ${pageNum}:`, err); }
    }
    container.appendChild(pageDiv);
  }
}

async function renderBlankCanvas() {
  if (!loadJsonUrl) return;
  try {
    const res = await fetch(loadJsonUrl);
    let jsonData = await res.text();
    try { jsonData = JSON.parse(jsonData); } catch {}
    const container = document.getElementById("blankCanvasContainer");
    const stage = new Konva.Stage({ container: "blankCanvasContainer", width: container.offsetWidth, height: container.offsetHeight });
    const layer = new Konva.Layer();
    stage.add(layer);
    if (jsonData.canvas_data) {
      const savedStage = Konva.Node.create(jsonData.canvas_data);
      layer.add(...savedStage.getChildren());
    } else if (jsonData && typeof jsonData === "object" && jsonData.className) {
      const savedStage = Konva.Node.create(jsonData);
      layer.add(...savedStage.getChildren());
    }
    layer.draw();
  } catch (err) { console.error("Gagal memuat blank canvas:", err); }
}

function scrollToPage(index) {
  const pageEl = document.getElementById("page-" + (index + 1));
  if (pageEl) pageEl.scrollIntoView({ behavior: "smooth", block: "center" });
}

document.getElementById("zoomIn").addEventListener("click", () => { currentScale += 0.2; renderPDF(); });
document.getElementById("zoomOut").addEventListener("click", () => { currentScale = Math.max(0.6, currentScale - 0.2); renderPDF(); });

document.getElementById("refreshBtn").addEventListener("click", async () => {
  const btn = document.getElementById("refreshBtn");
  const toast = document.getElementById("toastRefresh");
  btn.innerHTML = "<i class='fa fa-spinner fa-spin'></i> Memuat...";
  btn.disabled = true;
  if ("<?= $is_blank_mode ?>") await renderBlankCanvas(); else await renderPDF();
  try {
    const res = await fetch("<?= base_url('notes/get_note_timestamp/' . $note->id_note) ?>");
    const data = await res.json();
    if (data.status === "success") document.getElementById("lastUpdate").textContent = data.updated_date;
  } catch {}
  toast.style.display = "block";
  setTimeout(() => toast.style.display = "none", 2000);
  btn.innerHTML = "<i class='fa-solid fa-rotate-right'></i> Refresh Dokumen";
  btn.disabled = false;
});

if ("<?= $is_blank_mode ?>") renderBlankCanvas(); else renderPDF();

// Generate preview thumbnail otomatis jika belum ada
document.addEventListener("DOMContentLoaded", async () => {
  const previewPanel = document.getElementById("previewPanel");
  if (!previewPanel || pdfUrl === "") return;

  <?php if (empty($pages) && !$is_blank_mode): ?>
  const pdfjsLib = window["pdfjsLib"];
  pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
  const loadingTask = pdfjsLib.getDocument(pdfUrl);
  const pdf = await loadingTask.promise;

  for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
    const page = await pdf.getPage(pageNum);
    const viewport = page.getViewport({ scale: 0.2 });
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    await page.render({ canvasContext: ctx, viewport }).promise;

    const img = document.createElement("img");
    img.src = canvas.toDataURL();
    img.classList.add("pdf-thumb");
    img.style.width = "100%";
    img.style.borderRadius = "6px";
    img.style.cursor = "pointer";
    img.onclick = () => scrollToPage(pageNum - 1);

    const wrapper = document.createElement("div");
    wrapper.className = "preview-page";
    wrapper.appendChild(img);
    previewPanel.appendChild(wrapper);
  }
  <?php endif; ?>
});
</script>
</body>
</html>
