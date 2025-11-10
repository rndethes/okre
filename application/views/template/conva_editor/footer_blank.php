<!-- pdf-lib dari CDN -->

 <script>
  var BaseURL = '<?= base_url(); ?>';
  window.restoredCanvasData = <?= json_encode($restored_canvas_data); ?>;
    
  window.currentNoteReff = <?= json_encode($reff_note); ?>;
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>
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

  const settingsBtn = document.getElementById("settingsBtn");
  const settingsPopup = document.getElementById("settingsPopup");

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
  settingsBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    togglePopup(settingsPopup);
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