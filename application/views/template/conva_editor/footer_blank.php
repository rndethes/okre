<!-- pdf-lib dari CDN -->
   <!-- ===================== TOAST NOTIFIKASI ===================== -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="liveToast" class="toast align-items-center text-white bg-primary border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">Berhasil disimpan.</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

 <script>
  var BaseURL = '<?= base_url(); ?>';
  window.restoredCanvasData = <?= json_encode($restored_canvas_data); ?>;
    
  window.currentNoteReff = <?= json_encode($reff_note); ?>;
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/konva@9.2.0/konva.min.js"></script>
  <script src=" <?= base_url('assets/'); ?>js/sweetalert/sweetalert2.all.min.js"></script>

<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>

<script defer src="<?= base_url('assets/okre_conva/script_blank.js') ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
  const btnDraw = document.getElementById("btnDraw");
  const popupDraw = document.getElementById("popupDraw");
  const btnZoom = document.getElementById("btnZoom");
  const popupZoom = document.getElementById("popupZoom");



  function togglePopup(popup) {
    const isVisible = popup.style.display === "flex";

    document
      .querySelectorAll(".popup, .popup-sidebar")
      .forEach((p) => (p.style.display = "none"));

    popup.style.display = isVisible ? "none" : "flex";
  }

  btnDraw.addEventListener("click", (e) => {
    e.stopPropagation();
    togglePopup(popupDraw);
  });
  btnZoom.addEventListener("click", (e) => {
    e.stopPropagation();
    togglePopup(popupZoom);
  });

  document.addEventListener("click", (e) => {
    // Tambahkan cek untuk .popup-sidebar
    if (!e.target.closest(".popup") && !e.target.closest(".popup-sidebar")) {
      document
        .querySelectorAll(".popup, .popup-sidebar")
        .forEach((p) => (p.style.display = "none"));
    }
  });
});
</script>
</body>
</html>