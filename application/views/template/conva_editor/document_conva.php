<?php
// ===================== DOCUMENT_CONVA =====================
?>
<!-- CONTAINER FOR PAGES -->
<div id="container" style="width:100%; height:100vh; background:#f5f5f5;"></div>

<!-- Script Konva (pastikan sudah di-load di header_conva) -->
<script>
document.addEventListener("DOMContentLoaded", async function () {
  const baseUrl = window.baseUrl;
  const noteId = window.noteId;
  const pdfUrl = window.pdfUrl;

  // === 1️⃣ Inisialisasi stage Konva ===
  const stage = new Konva.Stage({
    container: "container",
    width: window.innerWidth,
    height: window.innerHeight,
  });

  const layer = new Konva.Layer();
  stage.add(layer);

  // === 2️⃣ Muat file PDF (optional kalau kamu render PDF.js di layer bawah)
  console.log("Memuat PDF dari:", pdfUrl);

  // === 3️⃣ Muat coretan dari database ===
  try {
    const res = await fetch(`${baseUrl}notes/load_canvas_json/${noteId}`);
    const result = await res.json();

    if (result.status === "success" && result.data) {
      const jsonData = result.data;
      const loadedStage = Konva.Node.create(jsonData, "container");
      // ganti stage lama dengan yang baru
      stage.destroy();
      window.stage = loadedStage;
      console.log("✅ Coretan berhasil dimuat dari database.");
    } else {
      console.log("ℹ️ Tidak ada coretan tersimpan sebelumnya.");
      window.stage = stage; // simpan stage di global
    }
  } catch (err) {
    console.error("❌ Gagal memuat coretan:", err);
    window.stage = stage;
  }

  // === 4️⃣ Fungsi simpan coretan ke database ===
  async function saveCanvasData() {
    if (!window.stage) return;
    const json = window.stage.toJSON();

    const res = await fetch(`${baseUrl}notes/save_canvas_json/${noteId}`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ json }),
    });

    const result = await res.json();
    if (result.status === "success") {
      console.log("💾 Coretan berhasil disimpan ke database.");
    } else {
      console.warn("⚠️ Gagal menyimpan coretan:", result);
    }
  }

  // === 5️⃣ Tombol Simpan Manual di Topbar ===
  const saveServerBtn = document.getElementById("saveServerTopBtn");
  if (saveServerBtn) {
    saveServerBtn.addEventListener("click", saveCanvasData);
  }

  // === 6️⃣ Auto-save tiap 30 detik ===
  setInterval(saveCanvasData, 30000);

  // === 7️⃣ Responsive resize ===
  window.addEventListener("resize", () => {
    if (!window.stage) return;
    window.stage.width(window.innerWidth);
    window.stage.height(window.innerHeight);
  });
});
</script>
