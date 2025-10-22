$(document).ready(function () {
	$("#inputdocument").on("change", function (event) {
		var file = event.target.files[0];
		if (file && file.type === "application/pdf") {
			var fileReader = new FileReader();
			fileReader.onload = function () {
				var pdfData = fileReader.result;
				var embed =
					'<embed src="' +
					pdfData +
					'" type="application/pdf" width="100%" height="600px" />';
				$("#previewpdf").html(embed);
			};
			fileReader.readAsDataURL(file);
		} else {
			alert("Please upload a valid PDF file.");
			$("#previewpdf").html("");
		}
	});
});

var selectSpaceElement = document.getElementById("selectspace");

if (selectSpaceElement) {
	selectSpaceElement.addEventListener("change", function () {
		var spaceId = this.value;

		if (spaceId) {
			fetch(baseURL + "/document/getSpaceProjects/" + spaceId)
				.then((response) => response.json())
				.then((data) => {
					var selectOKR = document.getElementById("selectokr");
					selectOKR.innerHTML = '<option value="">Pilih OKR</option>'; // Clear previous options

					data.forEach(function (project) {
						var option = document.createElement("option");
						option.value = project.id_project;
						option.textContent = project.nama_project;
						selectOKR.appendChild(option);
					});
				})
				.catch((error) => console.error("Error:", error));
		} else {
			document.getElementById("selectokr").innerHTML =
				'<option value="">Pilih OKR</option>';
		}
	});
}

$(document).on("show.bs.modal", "#projectModal", function (event) {
	// Ambil data dari tombol yang men-trigger modal
	var button = $(event.relatedTarget); // Tombol yang men-trigger modal
	var iddoc = button.data("doc"); // Ambil nilai dari data-idini

	// Set nilai tersebut ke dalam input di dalam modal
	var modal = $(this);
	modal.find("#iddocumentpj").val(iddoc); // Set nilai idPj ke input taskpj
});

$(document).on("show.bs.modal", "#projectAllModal", function (event) {
	// Ambil data dari tombol yang men-trigger modal
	var button = $(event.relatedTarget); // Tombol yang men-trigger modal
	var iddoc = button.data("doc"); // Ambil nilai dari data-idini
	var spaceid = button.data("spaceid");

	// Set nilai tersebut ke dalam input di dalam modal
	var modal = $(this);
	modal.find("#iddocumentpj").val(iddoc); // Set nilai idPj ke input taskpj
	modal.find("#idspacepj").val(spaceid);
});

// Tambahkan event listener ke semua tombol dengan kelas 'btn-sign'
document.querySelectorAll(".btn-signall").forEach((button) => {
	button.addEventListener("click", function (event) {
		// Ambil nilai dari atribut data-linkback
		const linkBack = this.getAttribute("data-linkback");
		console.log(linkBack);

		// Simpan ke localStorage dengan key 'linkback'
		localStorage.setItem("linkbackdoc", linkBack);
	});
});
