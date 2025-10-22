function myFunction() {
	var x = document.getElementById("password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}

//sweet alert
const flashData = $(".flash-data").data("flashdata");

if (flashData) {
	Swal.fire({
		title: "Data",
		icon: "success",
		text: "Berhasil " + flashData,
		type: "success",
	});
}

//tombol hapus
$(document).on("click", ".tombol-hapus", function (e) {
	e.preventDefault();
	const href = $(this).data("target");

	Swal.fire({
		title: "Apakah anda yakin?",
		text: "data akan dihapus",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus Data!",
	}).then((result) => {
		if (result.isConfirmed) {
			document.location.href = href;
		}
	});
});

function showDisabled() {
	document.getElementById("passwordEdit").readOnly = false;
}

$("#delegateModal").on("show.bs.modal", function (event) {
	var button = $(event.relatedTarget);
	var idtim = button.data("idtim");
	var kr = button.data("kr");

	document.getElementById("teamdelegate").value = idtim;
	document.getElementById("krdelegate").value = kr;
});

$(document).on("click", "#savedelegate", function (e) {
	var idtim = $("#teamdelegate").val();
	var idkr = $("#krdelegate").val();

	var selected = $("#usertim :selected")
		.map((_, e) => e.value)
		.get();

	$.ajax({
		url: baseURL + "project/saveDelegate",
		type: "POST",
		dataType: "json",
		data: {
			idtim: idtim,
			idkr: idkr,
			useritem: selected,
		},
		success: function (data) {
			var todos = JSON.stringify(data);

			obj = JSON.parse(todos);

			if (obj.length === 0) {
				Swal.fire({
					title: "Berhasil!",
					text: "Di Delegasikan!",
					icon: "success",
				}).then(function () {
					location.reload();
				});
			} else {
				Swal.fire({
					title: "Peringatan!",
					text: "User Yang Sudah di Delegasikan Tidak di Simpan!",
					icon: "info",
				}).then(function () {
					location.reload();
				});
			}
		},
	});
});

$(document).on("click", "#risehand", function (e) {
	var idkr = $(this).data("idkr");
	var user = $(this).data("user");
	var idtim = $(this).data("idtim");

	Swal.fire({
		title: "Yakin Meminta Bantuan?",
		text: "Setelah anda meminta bantuan teman anda bisa mengambil pekerjaan anda!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "project/riseHand",
				type: "POST",
				dataType: "json",
				data: {
					idkr: idkr,
					user: user,
					idtim: idtim,
				},
				success: function (data) {
					Swal.fire({
						title: "Berhasil!",
						text: "Meminta Bantuan!",
						icon: "success",
					}).then(function () {
						location.reload();
					});
				},
			});
		}
	});
});

$(document).on("click", "#taketask", function (e) {
	var idkr = $(this).data("idkr");
	var user = $(this).data("user");
	var idtim = $(this).data("idtim");

	Swal.fire({
		title: "Yakin Ambil Task?",
		text: "Setelah anda klik task akan diambil!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "project/takeTask",
				type: "POST",
				dataType: "json",
				data: {
					idkr: idkr,
					user: user,
					idtim: idtim,
				},
				success: function (data) {
					Swal.fire({
						title: "Berhasil!",
						text: "Mengambil Task!",
						icon: "success",
					}).then(function () {
						location.reload();
					});
				},
			});
		}
	});
});

$(document).on("click", "#riseinisiative", function (e) {
	var idini = $(this).data("timini");
	var idkr = $(this).data("idkr");
	var user = $(this).data("user");
	var idtim = $(this).data("idtim");

	Swal.fire({
		title: "Yakin Meminta Bantuan?",
		text: "Setelah anda meminta bantuan teman anda bisa mengambil pekerjaan anda!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "project/riseHandInisiative",
				type: "POST",
				dataType: "json",
				data: {
					idkr: idkr,
					user: user,
					idtim: idtim,
					idini: idini,
				},
				success: function (data) {
					Swal.fire({
						title: "Berhasil!",
						text: "Meminta Bantuan!",
						icon: "success",
					}).then(function () {
						location.reload();
					});
				},
			});
		}
	});
});

$(document).on("click", "#takeinisiative", function (e) {
	var idini = $(this).data("timini");
	var idkr = $(this).data("idkr");
	var user = $(this).data("user");
	var idtim = $(this).data("idtim");

	Swal.fire({
		title: "Yakin Ambil Task?",
		text: "Setelah anda klik task akan diambil!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes!",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "project/takeInisiative",
				type: "POST",
				dataType: "json",
				data: {
					idini: idini,
					idkr: idkr,
					user: user,
					idtim: idtim,
				},
				success: function (data) {
					Swal.fire({
						title: "Berhasil!",
						text: "Mengambil Task!",
						icon: "success",
					}).then(function () {
						location.reload();
					});
				},
			});
		}
	});
});

$(document).on("click", "#adjustment", function (e) {
	var user = $(this).data("user");
	var namauser = $(this).data("namauser");
	var idini = document.getElementById("idini").value;
	var score = document.getElementById("inputscore").value;

	var newscore = score.replace(/[.]/g, "");

	var list = document.getElementById("showlist");

	var idkr = document.getElementById("idkr").value;
	var idokr = document.getElementById("idokr").value;
	var idpjkr = document.getElementById("idpjkr").value;

	var valfirst = document.getElementById("valfirst").value;

	var comment = quillnew.root.innerHTML;

	$.ajax({
		url: baseURL + "project/AdjustmentInisiative",
		type: "POST",
		dataType: "json",
		data: {
			user: user,
			idini: idini,
			score: newscore,
			namauser: namauser,
			idkr: idkr,
			idokr: idokr,
			idpjkr: idpjkr,
			valfirst: valfirst,
			comment: comment,
		},
		success: function (data) {
			var todos = JSON.stringify(data);

			obj = JSON.parse(todos);

			var percent = obj.value_percent;
			var achini = obj.value_ach_initiative;
			var description = obj.description;

			// console.log(percent);

			var today = new Date();
			var dd = String(today.getDate()).padStart(2, "0");
			var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
			var yyyy = today.getFullYear();

			var hour = today.getHours();
			var minute = today.getMinutes();
			var second = today.getSeconds();

			var formatdate =
				yyyy + "-" + mm + "-" + dd + " " + hour + ":" + minute + ":" + second;

			var stringadj =
				"Adjustment " + newscore + " by " + namauser + " at " + formatdate;

			var entry = document.createElement("li");
			entry.className = "adjustment-list";
			entry.appendChild(document.createTextNode(stringadj));
			list.appendChild(entry);

			document.getElementById("cekpercen").innerHTML = percent;
			document.getElementById("valinistart").innerHTML = achini;
			CKEDITOR.instances["ckedtor"].setData(comment);

			Swal.fire({
				title: "Berhasil!",
				text: "Melakukan Adjustment!",
				icon: "success",
				showConfirmButton: false,
				timer: 1500,
			});
		},
	});
});

$(document).on("click", "#backbutton", function (e) {
	document.location = baseURL + "project/sesUnsetPerPage";
});

document.addEventListener("DOMContentLoaded", function (event) {
	var scrollpos = localStorage.getItem("scrollpos");
	if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function (e) {
	localStorage.setItem("scrollpos", window.scrollY);
};

$(document).ready(function () {
	function setActiveNav() {
		var activeTab = localStorage.getItem("activeTab");
		if (activeTab) {
			$('#tabs-text-doc a[href="' + activeTab + '"]').tab("show"); // FIXED
		} else {
			$("#tabs-text-doc a:first").tab("show"); // FIXED
		}
	}

	// Ketika tab di-klik, simpan state ke localStorage
	$("#tabs-text-doc a").on("click", function (e) {
		e.preventDefault();
		var tabId = $(this).attr("href");
		console.log(tabId);
		localStorage.setItem("activeTab", tabId);
		$(this).tab("show");

		if (tabId === "#tabs-text-complete") {
			$("#text-complete").show();
			$("#myDocumentData").DataTable().ajax.reload();
		} else if (tabId === "#tabs-text-publish") {
			$("#text-publish").show();
			$("#myDocumentDataPublish").DataTable().ajax.reload();
		}
	});

	// Jalankan fungsi untuk memuat nav yang tersimpan
	setActiveNav();

	// Pemanggilan pertama ajax saat page load
	var tableokr = $("#myDocumentData").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: baseURL + "document/getDocumentsData",
			type: "POST",
			data: function (data) {
				data.idproject = $("#filterspace").val();
				data.idspace = $("#spaceindoc").val();
			},
		},
		language: {
			paginate: {
				next: '<i class="fas fa-chevron-right"></i>',
				previous: '<i class="fas fa-chevron-left"></i>',
			},
		},
		columnDefs: [
			{ targets: 0, orderable: false },
			{ targets: -1, orderable: false },
		],
		scrollCollapse: true,
	});

	var tableafterpublish = $("#myDocumentDataPublish").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: baseURL + "document/getDocumentsDataAfterPublish",
			type: "POST",
			data: function (data) {
				data.idproject = $("#filterspace").val();
				data.idspace = $("#spaceindoc").val();
			},
		},
		language: {
			paginate: {
				next: '<i class="fas fa-chevron-right"></i>',
				previous: '<i class="fas fa-chevron-left"></i>',
			},
		},
		columnDefs: [
			{ targets: 0, orderable: false },
			{ targets: -1, orderable: false },
		],
		scrollCollapse: true,
	});

	// Logika untuk memuat tab terakhir yang aktif saat halaman dibuka
	var lastActiveTab = localStorage.getItem("activeTab");
	if (lastActiveTab) {
		$('a[href="' + lastActiveTab + '"]').tab("show");
	} else {
		$('a[data-toggle="tab"]:first').tab("show");
	}

	// Reload data pada click button filter
	$("#btnfilterspace").on("click", function () {
		var activeTab = localStorage.getItem("activeTab");
		if (activeTab === "#tabs-text-complete") {
			tableokr.ajax.reload();
		} else if (activeTab === "#tabs-text-publish") {
			tableafterpublish.ajax.reload();
		}
	});

	var tabledocnew = $("#docNew").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: baseURL + "data/getDocumentsData",
			type: "POST",
			data: function (data) {
				data.idspace = $("#spaceindoc").val();
			},
		},
		language: {
			paginate: {
				next: '<i class="fas fa-chevron-right"></i>',
				previous: '<i class="fas fa-chevron-left"></i>',
			},
		},
		columnDefs: [
			{
				target: [-1],
				orderable: false,
			},
		],
		scrollCollapse: true,
	});
});

$(document).ready(function () {
	// Logika untuk "Check All"
	$("#checkAll").on("click", function () {
		// Cari semua .doc-checkbox HANYA di dalam tabel 'myDocumentData'
		$("#myDocumentData .doc-checkbox").prop("checked", this.checked);
	});

	// Event listener untuk tombol Check All di TABEL KEDUA
	$("#checkAllPublish").on("click", function () {
		// Cari semua .doc-checkbox HANYA di dalam tabel 'myDocumentDataPublish'
		$("#myDocumentDataPublish .doc-checkbox").prop("checked", this.checked);
	});

	// Logika untuk uncheck "Check All" jika salah satu checkbox anak di-uncheck
	$("#myDocumentData, #myDocumentDataPublish").on(
		"click",
		".doc-checkbox",
		function () {
			if (!this.checked) {
				// Cari "Check All" di dalam tabel yang sama dan uncheck
				$(this)
					.closest("table")
					.find('thead .text-center input[type="checkbox"]')
					.prop("checked", false);
			}
		}
	);

	// Jika ada checkbox individual yang tidak dicentang, maka "Check All" juga tidak dicentang
	$("#myDocumentData").on("click", ".doc-checkbox", function () {
		if (!this.checked) {
			$("#checkAll").prop("checked", false);
		}
	});

	// Logika saat form di-submit
	$("#backupForm").on("submit", function (e) {
		e.preventDefault();

		var selectedIds = [];
		// UBAH BAGIAN INI: Cari checkbox hanya di dalam .tab-pane yang sedang .active
		$(".tab-pane.fade.show.active .doc-checkbox:checked").each(function () {
			selectedIds.push($(this).val());
		});

		if (selectedIds.length === 0) {
			Swal.fire({
				title: "Gagal!",
				text: "Anda harus memilih minimal satu dokumen di tab yang aktif.",
				icon: "error",
				confirmButtonText: "OK",
			});
			return;
		}

		$("#selected_ids_hidden").val(selectedIds.join(","));
		this.submit();
	});
});

$(document).ready(function () {
	$("#typekey").change(function () {
		var selectedType = $(this).val();
		var $valueInput = $("#valuekrinput");

		if (selectedType === "checklist") {
			$valueInput.val(1);
			$valueInput.prop("readonly", true);
		} else {
			$valueInput.val("");
			$valueInput.prop("readonly", false);
		}
	});
	$("#adjustmentcheck").click(function () {
		// Toggle grey color when clicked
		$(this).toggleClass("clicked");

		// Set the value of the input field to 1
		if ($(this).hasClass("clicked")) {
			$(".value_achievment").val(1);
		} else {
			$(".value_achievment").val(""); // Optional: reset value when unclick
		}
	});
});

$(document).ready(function () {
	// Fungsi untuk menampilkan tab yang benar berdasarkan localStorage
	function showTab(tabId) {
		console.log(tabId);
		if (tabId == "#yourdoc") {
			$(".data-yourdoc").removeClass("d-none");
			$(".data-spacedoc").addClass("d-none");
			$("#table-you").css("display", "block"); // Menampilkan elemen
			$("#table-space").css("display", "none"); // Menyembunyikan elemen
			$("#yourdoc-tab").addClass("active");
			$("#spacedoc-tab").removeClass("active");
		} else if (tabId == "#spacedoc") {
			$(".data-yourdoc").addClass("d-none");
			$(".data-spacedoc").removeClass("d-none");
			$("#table-you").css("display", "none"); // Menampilkan elemen
			$("#table-space").css("display", "block"); // Menyembunyikan elemen
			$("#yourdoc-tab").removeClass("active");
			$("#spacedoc-tab").addClass("active");
		}
	}

	// Event ketika user mengklik tab Dokumen Pengajuan
	$("#yourdoc-tab").on("click", function () {
		localStorage.setItem("activeTab", "#yourdoc"); // Simpan tab yang aktif
		showTab("#yourdoc");
	});

	// Event ketika user mengklik tab Document Space
	$("#spacedoc-tab").on("click", function () {
		localStorage.setItem("activeTab", "#spacedoc"); // Simpan tab yang aktif
		showTab("#spacedoc");
	});

	// Cek di localStorage apakah ada tab yang tersimpan
	var activeTab = localStorage.getItem("activeTab");

	// Jika ada tab yang tersimpan, tampilkan tab tersebut, jika tidak, tampilkan default (Dokumen Pengajuan)
	if (activeTab) {
		showTab(activeTab);
	} else {
		showTab("#yourdoc"); // Default tab
	}
});

$(document).ready(function () {
	let isExpanded = localStorage.getItem("isExpanded") === "true"; // Ambil status dari local storage

	// Atur tampilan berdasarkan status yang diambil
	if (isExpanded) {
		$("#mainColumn").removeClass("col-lg-10").addClass("col-lg-12");
		$("#detailColumn").hide();
		$("#perbesarButton").find(".btn-inner--text").text("Kecilkan");
	} else {
		$("#mainColumn").removeClass("col-lg-12").addClass("col-lg-10");
		$("#detailColumn").show();
		$("#perbesarButton").find(".btn-inner--text").text("Perbesar");
	}

	$("#perbesarButton").on("click", function () {
		if (!isExpanded) {
			// Mengubah kolom menjadi col-lg-12 dan menyembunyikan kolom detail
			$("#mainColumn").removeClass("col-lg-10").addClass("col-lg-12");
			$("#detailColumn").hide();
			$(this).find(".btn-inner--text").text("Kecilkan"); // Ubah teks tombol
		} else {
			// Mengembalikan kolom ke ukuran semula
			$("#mainColumn").removeClass("col-lg-12").addClass("col-lg-10");
			$("#detailColumn").show();
			$(this).find(".btn-inner--text").text("Perbesar"); // Kembalikan teks tombol
		}
		isExpanded = !isExpanded; // Toggle status
		localStorage.setItem("isExpanded", isExpanded); // Simpan status ke local storage
	});
});
