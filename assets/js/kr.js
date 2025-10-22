$(document).ready(function () {
	// Fungsi untuk menambah form
	$(".add-more").click(function () {
		var html = $(".initiative-group").first().clone(); // Clone the first group of inputs
		html.find("input").val(""); // Clear the input values
		html.find("select").val(""); // Clear the select values
		html.appendTo("#initiativeContainer"); // Append the new input group to the container
	});

	// Fungsi untuk menghapus form
	$("body").on("click", ".remove", function () {
		if ($(".initiative-group").length > 1) {
			$(this).closest(".initiative-group").remove();
		} else {
			alert("At least one initiative is required.");
		}
	});
});

$(document).ready(function () {
	// Ketika tombol 'Cek Inisiative' diklik
	$("#cekinisiative").on("click", function () {
		var keyResultId = $("#keyresultselect").val();
		if (keyResultId) {
			// Ajax request untuk mendapatkan Inisiative berdasarkan Key Result ID
			$.ajax({
				url: baseURL + "task/cekInisiative", // Ganti dengan URL API yang benar
				method: "GET",
				data: { keyResultId: keyResultId },
				success: function (response) {
					console.log(response); // Lihat apa yang diterima dari server

					// Pastikan response dikonversi ke objek JavaScript
					var data = JSON.parse(response);

					if (data.status === "success") {
						// Kosongkan dropdown inisiativeselect sebelum menambahkan opsi baru
						$("#inisiativeselect")
							.empty()
							.append('<option value="">Pilih Inisiative</option>');

						// Iterasi melalui data inisiative dan tambahkan ke dropdown
						$.each(data.data, function (index, inisiative) {
							$("#inisiativeselect").append(
								'<option value="' +
									inisiative.id_initiative +
									'">' +
									inisiative.description +
									"</option>"
							);
						});

						// Tampilkan dropdown inisiative
						$("#inisiativeselect").show();
						$("#proseskr").hide();

						// Tampilkan select dan tombol Proses/Hapus setelah Inisiative berhasil dimuat
						$("#inisiative-container").show();
						$("#prosesini").show();
						$("#hapusini").show();
					} else {
						alert(data.message);
					}
				},
			});
		} else {
			alert("Pilih Key Result terlebih dahulu.");
		}
	});

	// Ketika tombol 'Hapus' diklik
	$("#hapusini").on("click", function () {
		// Reset kedua select dan sembunyikan Inisiative
		$("#keyresultselect").val("");
		$("#inisiativeselect").html('<option value="">Pilih Inisiative</option>');
		$("#inisiative-container").hide();
		$("#prosesini").hide();
		$("#hapusini").hide();
		$("#proseskr").show();
	});

	$("#projectid").change(function () {
		var projectId = $(this).val();
		if (projectId) {
			$("#proseskr").prop("disabled", false);
			$("#cekinisiative").prop("disabled", false);
			$.ajax({
				url: baseURL + "task/getKey/", // URL ke controller untuk mengambil key result
				type: "POST",
				data: { project_id: projectId },
				dataType: "json",
				success: function (data) {
					$("#keyresultselect").empty(); // Kosongkan dropdown key result
					$("#keyresultselect").append(
						'<option value="">Pilih Key Result</option>'
					); // Tambahkan opsi default

					$.each(data, function (key, value) {
						$("#keyresultselect").append(
							'<option value="' +
								value.id_kr +
								'">' +
								value.nama_kr +
								" (" +
								value.description_okr +
								")</option>"
						);
					});
				},
				error: function () {
					alert("Gagal mengambil data Key Result");
				},
			});
		} else {
			$("#proseskr").prop("disabled", true);
			$("#cekinisiative").prop("disabled", true);
			$("#keyresultselect").empty(); // Kosongkan dropdown jika project tidak dipilih
			$("#keyresultselect").append(
				'<option value="">Pilih Key Result</option>'
			); // Tambahkan opsi default
		}
	});
});

$(document).ready(function () {
	btnsimpantask = document.getElementById("simpantask");
	if (btnsimpantask) {
		document.getElementById("simpantask").disabled = true;
	}
	// Ketika tombol 'Proses' pada Key Result diklik
	$("#proseskr").on("click", function () {
		var keyResultId = $("#keyresultselect").val();
		if (keyResultId) {
			$.ajax({
				url: baseURL + "task/getKeyResultDetails", // Ganti dengan URL API yang benar
				method: "GET",
				data: { keyResultId: keyResultId, namatask: "keyresult" },
				success: function (rsp) {
					console.log(rsp);
					var data = JSON.parse(rsp);

					if (data.status === "success") {
						// Isi form dengan data yang diperoleh
						$("#idselected").val(data.data.id_kr);
						$("#namaselected").val("keyresult");
						$("#namatask").val(data.data.nama_kr);
						$("#tanggalakhir").val(data.data.due_datekey);
						$("#tanggalawal").val(data.data.start_datekey);

						if (quillokr) {
							quillokr.clipboard.dangerouslyPasteHTML(data.data.description_kr);
						}

						console.log(quillokr);

						$("#describeokr").val(data.data.description_kr);

						document.getElementById("simpantask").disabled = false;
					} else {
						alert(data.message);
					}
				},
			});
		} else {
			alert("Pilih Key Result terlebih dahulu.");
		}
	});

	$("#prosesini").on("click", function () {
		var keyResultId = $("#inisiativeselect").val();
		if (keyResultId) {
			$.ajax({
				url: baseURL + "task/getKeyResultDetails", // Ganti dengan URL API yang benar
				method: "GET",
				data: { keyResultId: keyResultId, namatask: "inisiative" },
				success: function (rsp) {
					console.log(rsp);
					var data = JSON.parse(rsp);

					if (data.status === "success") {
						// Isi form dengan data yang diperoleh
						$("#idselected").val(data.data.id_initiative);
						$("#namaselected").val("initiative");
						$("#namatask").val(data.data.description);
						$("#tanggalakhir").val(data.data.due_dateinit);
						$("#tanggalawal").val(data.data.start_dateinit);

						if (quillokr) {
							quillokr.clipboard.dangerouslyPasteHTML(data.data.comment);
						}

						console.log(quillokr);

						$("#describeokr").val(data.data.comment);

						document.getElementById("simpantask").disabled = false;
					} else {
						alert(data.message);
					}
				},
			});
		} else {
			alert("Pilih Key Result terlebih dahulu.");
		}
	});
});

$(document).ready(function () {
	let dataTables = {};

	function loadTable(tableId, status, prj, space, stateacctive) {
		console.log(stateacctive);
		console.log(prj);
		console.log(space);
		// Menyembunyikan semua tabel terlebih dahulu
		$(".table-responsive").each(function () {
			// Sembunyikan div table-responsive, tetapi biarkan DataTable tetap aktif
			if ($(this).find("table").length > 0) {
				$(this).hide();
			}
		});

		// Menampilkan tabel yang sesuai dengan tab yang dipilih (menampilkan parent div .table-responsive)
		$(tableId).closest(".table-responsive").show();

		if ($.fn.DataTable.isDataTable(tableId)) {
			// Jika tabel sudah diinisialisasi, reload data
			dataTables[tableId].ajax.reload();
		} else {
			// Jika tabel belum diinisialisasi, inisialisasi dengan DataTables

			if (tableId == "#tabOnGoing") {
				var cssTab = "custom-column-style-on";
				var cssLine = "custom-line-style-on";
			} else if (tableId == "#tabPending") {
				var cssTab = "custom-column-style-pen";
				var cssLine = "custom-line-style-pen";
			} else if (tableId == "#tabReject") {
				var cssTab = "custom-column-style-rej";
				var cssLine = "custom-line-style-rej";
			} else {
				var cssTab = "custom-column-style-com";
				var cssLine = "custom-line-style-com";
			}

			console.log(tableId);

			dataTables[tableId] = $(tableId).DataTable({
				processing: true,
				serverSide: true,
				order: [[1, "desc"]],
				paging: false,
				ajax: {
					url: baseURL + "task/loadTasksByStatusTable",
					type: "POST",
					data: function (data) {
						data.statustask = status;
						data.prj = prj;
						data.space = space;
						data.stateacctive = stateacctive;
						data.tableid = tableId;
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
					{ targets: 8, orderable: false },
					{ targets: 7, orderable: false },
					{ targets: 6, orderable: false },
					// { targets: 2, orderable: true },
					// { targets: 3, orderable: true },
					{ targets: 4, className: cssTab }, // Kolom 4
					{ targets: 5, className: cssLine }, // Kolom 5
				],
				scrollX: true,
				scrollCollapse: true,
			});
		}
	}

	$(".nav-link").on("click", function () {
		const status = $(this).data("status");
		const prj = $(this).data("prj");
		const space = $(this).data("space");
		const stateacctive = $(this).data("stateacctive");
		const tableId = `#tab${$(this).text().replace(/\s/g, "")}`;
		console.log(tableId);

		loadTable(tableId, status, prj, space, stateacctive);
	});

	var taskspace = document.getElementById("taskspace");

	if (taskspace) {
		const initialStatus = $(".nav-link.active").data("status");
		const initialPrj = $(".nav-link.active").data("prj");
		const initialSpace = $(".nav-link.active").data("space");
		const initialState = $(".nav-link.active").data("stateacctive");
		const initialTableId = "#tabOnGoing";
		loadTable(
			initialTableId,
			initialStatus,
			initialPrj,
			initialSpace,
			initialState
		);
	}

	// Fungsi untuk memuat data tabel berdasarkan tab yang dipilih
	// function loadTableData(tabId, prj, space, statusTask, stateacctive) {
	// 	console.log(
	// 		"Loading data for tab:",
	// 		tabId,
	// 		prj,
	// 		space,
	// 		statusTask,
	// 		stateacctive
	// 	);
	// 	if (tabId === "tabs-icons-text-1") {
	// 		reloadTable(
	// 			"#tableOnGoing",
	// 			prj,
	// 			space,
	// 			statusTask,
	// 			stateacctive,
	// 			tableOnGoing
	// 		);
	// 	} else if (tabId === "tabs-icons-text-2") {
	// 		reloadTable(
	// 			"#tablePending",
	// 			prj,
	// 			space,
	// 			statusTask,
	// 			stateacctive,
	// 			tablePending
	// 		);
	// 	} else if (tabId === "tabs-icons-text-3") {
	// 		reloadTable(
	// 			"#tableReject",
	// 			prj,
	// 			space,
	// 			statusTask,
	// 			stateacctive,
	// 			tableReject
	// 		);
	// 	} else if (tabId === "tabs-icons-text-4") {
	// 		reloadTable(
	// 			"#tableComp",
	// 			prj,
	// 			space,
	// 			statusTask,
	// 			stateacctive,
	// 			tableCompleteTask
	// 		);
	// 	}
	// }
	// function reloadTable(
	// 	tableSelector,
	// 	prj,
	// 	space,
	// 	statusTask,
	// 	stateacctive,
	// 	loadFunction
	// ) {
	// 	if ($.fn.DataTable.isDataTable(tableSelector)) {
	// 		$(tableSelector).DataTable().clear().destroy();
	// 	}
	// 	// Bersihkan body tabel
	// 	$(tableSelector).find("tbody").empty();
	// 	// Pastikan header dan footer tabel kosong
	// 	$(tableSelector).find("tbody").empty();
	// 	// Panggil fungsi pemuatan DataTable
	// 	loadFunction(prj, space, statusTask, stateacctive);
	// }
	// $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
	// 	var tabId = $(e.target).attr("href").replace("#", ""); // Ambil ID tab
	// 	var prj = $(e.target).data("prj"); // Ambil data project
	// 	var space = $(e.target).data("space"); // Ambil data space
	// 	var statusTask = $(e.target).data("status"); // Ambil status task
	// 	var stateacctive = $(e.target).data("stateacctive");
	// 	console.log("Tab activated:", tabId);
	// 	// Panggil fungsi loadTableData
	// 	loadTableData(tabId, prj, space, statusTask, stateacctive);
	// });
	// var firstTab = $('a[data-toggle="tab"].active');
	// loadTableData(
	// 	firstTab.attr("href").replace("#", ""),
	// 	firstTab.data("prj"),
	// 	firstTab.data("space"),
	// 	firstTab.data("status"),
	// 	firstTab.data("stateacctive")
	// );

	$("body")
		.on("show.bs.dropdown", ".droptask", function (e) {
			var $dropdown = $(this).find(".droptask-menu");

			// Pindahkan dropdown ke body
			$("body").append($dropdown.detach());

			// Tambahkan kelas unik untuk tracking
			$dropdown.addClass("active-droptask");

			// Sesuaikan posisi dropdown agar tampil di bawah tombol
			var offset = $(this).offset();
			$dropdown.css({
				display: "block",
				position: "absolute",
				top: offset.top + $(this).outerHeight(),
				left: offset.left,
				zIndex: 10000, // Pastikan berada di atas elemen lain
			});
		})
		.on("hide.bs.dropdown", ".droptask", function (e) {
			var $dropdown = $(".droptask-menu.active-droptask");

			if ($dropdown.length) {
				// Kembalikan dropdown ke elemen asli
				$(this).append($dropdown.detach());
				$dropdown.removeClass("active-droptask").hide();
			}
		});
});

function tableOnGoing(prj, space, statusTask, stateacctive) {
	console.log("Loading tableOnGoing");
	$("#tableOnGoing").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		paging: false, // Menonaktifkan pagination
		ajax: {
			url: baseURL + "task/loadTasksByStatusTable",
			type: "POST",
			data: function (data) {
				data.statustask = statusTask;
				data.prj = prj;
				data.space = space;
				data.stateacctive = stateacctive;
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
		scrollX: true,
		scrollCollapse: true,
	});
}

function tablePending(prj, space, statusTask, stateacctive) {
	$("#tablePending").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		paging: false, // Menonaktifkan pagination
		ajax: {
			url: baseURL + "task/loadTasksByStatusTable",
			type: "POST",
			data: function (data) {
				data.statustask = statusTask;
				data.prj = prj;
				data.space = space;
				data.stateacctive = stateacctive;
			},
		},
		language: {
			paginate: {
				next: '<i class="fas fa-chevron-right"></i>',
				previous: '<i class="fas fa-chevron-left"></i>',
			},
		},
		columnDefs: [{ width: "10%", targets: 4 }],
		// columnDefs: [
		// 	{
		// 		target: [-1],
		// 		orderable: false,
		// 	},
		// 	{ targets: 4, width: "150px" }, // Kolom Purpose
		// 	{ targets: 5, width: "200px" }, // Kolom Desc
		// ],
		scrollX: true,
		scrollCollapse: true,
		fixedColumns: {
			left: 0,
			right: 1,
		},
	});
}

function tableReject(prj, space, statusTask, stateacctive) {
	$("#tableReject").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		paging: false, // Menonaktifkan pagination
		ajax: {
			url: baseURL + "task/loadTasksByStatusTable",
			type: "POST",
			data: function (data) {
				data.statustask = statusTask;
				data.prj = prj;
				data.space = space;
				data.stateacctive = stateacctive;
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
		scrollX: true,
		scrollCollapse: true,
		fixedColumns: {
			left: 0,
			right: 1,
		},
	});
}
function tableCompleteTask(prj, space, statusTask, stateacctive) {
	console.log("Loading tableCompleteTask");
	$("#tableComp").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		paging: false, // Menonaktifkan pagination
		ajax: {
			url: baseURL + "task/loadTasksByStatusTable",
			type: "POST",
			data: function (data) {
				data.statustask = statusTask;
				data.prj = prj;
				data.space = space;
				data.stateacctive = stateacctive;
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
		scrollX: true,
		scrollCollapse: true,
		fixedColumns: {
			left: 0,
			right: 1,
		},
	});
}
$(document).ready(function () {
	// Event handler saat tombol diklik
	$(document).on("click", ".btn-fetch-data", function () {
		// Ambil nilai dari data-taskfrom dan data-tipetask
		var taskFrom = $(this).data("taskfrom");
		var tipeTask = $(this).data("tipetask");

		// Lakukan request AJAX
		$.ajax({
			url: baseURL + "task/showConnectOKR", // Ganti dengan URL server untuk mengambil data
			type: "POST",
			data: {
				taskFrom: taskFrom,
				tipeTask: tipeTask,
			},
			success: function (response) {
				// Asumsikan response adalah JSON yang berisi data dari database
				// Isi modal dengan data dari server
				$("#checkOKRModal").modal("show");
				$("#modalContent").html(response);
			},
			error: function (xhr, status, error) {
				console.error(error);
				$("#modalContent").html(
					"<p>Terjadi kesalahan saat mengambil data.</p>"
				);
			},
		});
	});
});

$(document).ready(function () {
	// Event listener untuk klik pada item dropdown status
	$(document).on("click", ".intask", function (e) {
		e.preventDefault(); // Mencegah default action

		var id_task = $(this).data("idtask"); // Mendapatkan id_task
		var new_status = $(this).data("sttask"); // Mendapatkan status yang dipilih
		var activeTab = $(".nav-pills .active").attr("href");
		var tableid = $(this).data("tableid");
		console.log(tableid);

		console.log(activeTab);
		$(".dropdown-menu").hide();

		// AJAX untuk mengupdate status task
		$.ajax({
			url: baseURL + "task/updateTaskStatus",
			type: "POST",
			data: {
				id_task: id_task,
				status_task: new_status,
			},
			success: function (response) {
				$(tableid).DataTable().ajax.reload();
				$(activeTab + "-tab").trigger("click");

				//$(activeTab).load(window.location.href + " " + activeTab + " > *");
			},
			error: function (xhr, status, error) {
				// Tangani error jika gagal
				console.error("Gagal memperbarui status task:", error);
			},
		});
	});
});
var quill;
var quilldoc = document.getElementById("descpvt");

if (quilldoc) {
	quilldoc = new Quill("#descpvt", {
		theme: "snow",
	});
}

var quillokr = document.getElementById("desokr");

if (quillokr) {
	quillokr = new Quill("#desokr", {
		theme: "snow",
	});
}

var forminputtask = document.querySelector(".form-inputtask");

if (forminputtask) {
	forminputtask.onsubmit = function () {
		var quillContent = quillokr.root.innerHTML;

		console.log(quillContent);

		document.getElementById("describeokr").value = quillContent;
	};
}

var forminputtasksp = document.querySelector(".form-inputtaskokr");

if (forminputtasksp) {
	forminputtasksp.onsubmit = function () {
		var quillContent = quillnew.root.innerHTML;

		console.log(quillContent);

		document.getElementById("descspace").value = quillContent;
	};
}

var forminputokr = document.querySelector(".form-inputtaskokr");

if (forminputokr) {
	forminputokr.onsubmit = function () {
		var quillContent = quillokr.root.innerHTML;

		console.log(quillContent);

		document.getElementById("describeokr").value = quillContent;
	};
}

// $(document).ready(function () {
// 	$(".form-inputtaskokr").on("submit", function (e) {
// 		e.preventDefault(); // Mencegah form submit default
// 		// Ambil konten Quill dan masukkan ke input hidden
// 		if (quilldoc) {
// 			// Ambil konten Quill dan masukkan ke input hidden
// 			var quillContent = quilldoc.root.innerHTML;
// 			$("#describeokr").val(quillContent);
// 		}
// 	});
// });

$(document).ready(function () {
	$("#taskForm").on("submit", function (e) {
		e.preventDefault(); // Mencegah form submit default
		// Ambil konten Quill dan masukkan ke input hidden
		if (quilldoc) {
			// Ambil konten Quill dan masukkan ke input hidden
			var quillContent = quilldoc.root.innerHTML;
			$("#describeprivate").val(quillContent);
		}

		console.log(quillContent);

		// Lakukan AJAX untuk submit data
		$.ajax({
			url: baseURL + "task/saveTask", // Ganti dengan URL endpoint PHP untuk menyimpan task
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (response) {
				console.log(response.status);
				if (response.status === "error") {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Tidak Bisa Simpan!",
					});
					//$("#privateTaskModal").modal("hide");
					// Tampilkan pesan error di UI
				} else if (response.status === "success") {
					console.log(response.message);
					$("#privateTaskModal").modal("hide");
					Swal.fire("Ditambahkan!", "Task telah ditambah.", "success").then(
						() => {
							// Opsional: Refresh halaman atau hapus elemen yang dihapus dari DOM
							location.reload();
						}
					);
					// Tampilkan pesan sukses di UI
				}
			},
			error: function (xhr, status, error) {
				// Tangani error jika gagal
				console.error("Gagal menyimpan task:", error);
			},
		});
	});
});

document.addEventListener("DOMContentLoaded", function () {
	// Gunakan event delegation untuk menangani klik pada tombol hapustask
	document.addEventListener("click", function (event) {
		// Cek jika elemen yang diklik adalah tombol hapustask
		if (event.target && event.target.classList.contains("hapustask")) {
			// Ambil ID tugas dari data-idtaskdelete
			var taskId = event.target.getAttribute("data-idtaskdelete");

			// Tampilkan SweetAlert konfirmasi
			Swal.fire({
				title: "Yakin?",
				text: "Apakah Anda yakin ingin menghapus task ini?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Hapus",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					// Jika diklik "Hapus", lakukan tindakan penghapusan
					fetch(baseURL + "task/deleteTask", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: new URLSearchParams({
							taskId: taskId,
						}),
					})
						.then((response) => response.json())
						.then((data) => {
							// Tangani respons dari server setelah penghapusan
							if (data.success) {
								Swal.fire("Terhapus!", "Task telah dihapus.", "success").then(
									() => {
										// Opsional: Refresh halaman atau hapus elemen yang dihapus dari DOM
										location.reload();
									}
								);
							} else {
								Swal.fire(
									"Gagal!",
									"Terjadi kesalahan saat menghapus task.",
									"error"
								);
							}
						})
						.catch((error) => {
							Swal.fire("Error!", "Terjadi kesalahan.", "error");
						});
				}
			});
		}
	});
});

$(document).ready(function () {
	$("#editTaskForm").on("submit", function (e) {
		e.preventDefault(); // Mencegah form submit default
		//var quilldoc = document.getElementById("descpvt");

		// Ambil konten Quill dan masukkan ke input hidden
		var quillContent = quilldoc.root.innerHTML;
		$("#describeprivate").val(quillContent);

		var linkurlback = $("#linkurlback").val();

		//console.log(linkurlback);

		// Lakukan AJAX untuk submit data
		$.ajax({
			url: baseURL + "task/editTaskAll", // Ganti dengan URL endpoint PHP untuk menyimpan task
			type: "POST",
			data: $(this).serialize(),
			success: function (response) {
				// Opsional: Refresh halaman atau hapus elemen yang dihapus dari DOM
				window.location.href = linkurlback;
			},
			error: function (xhr, status, error) {
				// Tangani error jika gagal
				console.error("Gagal menyimpan task:", error);
			},
		});
	});
});

$(document).on("show.bs.modal", "#taskInOKR", function (event) {
	// Ambil data dari tombol yang men-trigger modal
	var button = $(event.relatedTarget); // Tombol yang men-trigger modal
	var idtask = button.data("idtaskokr"); // Ambil nilai dari data-idtask

	// Set nilai tersebut ke dalam input di dalam modal
	var modal = $(this);
	modal.find("#idtaskokr").val(idtask); // Set nilai idIni ke input taskini
});

// document.addEventListener("DOMContentLoaded", function () {
// 	const selectElements = document.querySelectorAll('select[name="statususer"]');

// 	selectElements.forEach((select) => {
// 		select.addEventListener("change", function () {
// 			const selectedValue = this.value;
// 			const idTeam = this.getAttribute("data-idteam");

// 			// Membuat request AJAX
// 			fetch(baseURL + "workspace/selectAnggota", {
// 				method: "POST",
// 				headers: {
// 					"Content-Type": "application/x-www-form-urlencoded",
// 				},
// 				body: `idteam=${idTeam}&statususer=${selectedValue}`,
// 			})
// 				.then((response) => response.json())
// 				.then((data) => {
// 					if (data.success) {
// 						const Toast = Swal.mixin({
// 							toast: true,
// 							position: "top-end",
// 							showConfirmButton: false,
// 							timer: 2000,
// 							timerProgressBar: true,
// 							didOpen: (toast) => {
// 								toast.onmouseenter = Swal.stopTimer;
// 								toast.onmouseleave = Swal.resumeTimer;
// 							},
// 						});
// 						Toast.fire({
// 							icon: "success",
// 							title: "Berhasil Dirubah",
// 						});
// 					} else {
// 						Swal.fire({
// 							icon: "error",
// 							title: "Oops...",
// 							text: "Gagal di Ubah!",
// 						});
// 					}
// 				})
// 				.catch((error) => console.error("Error:", error));
// 		});
// 	});
// });

document.addEventListener("DOMContentLoaded", function () {
	// Event listener untuk tombol "Edit Anggota"
	document.querySelectorAll(".edit-anggota-btn").forEach((button) => {
		button.addEventListener("click", function () {
			const idSpace = this.getAttribute("data-idspace");
			const canedit = this.getAttribute("data-canedit");
			const candelete = this.getAttribute("data-candelete");
			const stateus = this.getAttribute("data-stateus");

			document.getElementById("idspaceanggota").value = idSpace;
			// AJAX request untuk mengambil data anggota
			fetch(`${baseURL}workspace/getTeamMembers/${idSpace}`)
				.then((response) => response.json())
				.then((data) => {
					const teamList = document.getElementById("space-team-list");
					teamList.innerHTML = ""; // Kosongkan daftar sebelumnya

					// Iterasi data anggota dan tambahkan ke modal
					data.forEach((member) => {
						const listItem = document.createElement("li");
						listItem.className = "list-group-item px-0";
						if (stateus == "viewer") {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select disabled class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="${
									member.id
								}">
								<option value="viewer" ${
									member.status_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.status_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.status_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							<div class="col-lg-2">
								<button type="button" class="btn btn-sm btn-danger hapususer">Hapus</button>
							</div>
							</div>
						`;
						} else if (stateus == "editor") {
							if (member.status_user == "admin") {
								listItem.innerHTML = `
								<div class="row align-items-center">
								<div class="col-lg-1">
									<a href="#" class="avatar rounded-circle">
									<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
									</a>
								</div>
								<div class="col-lg-6">
									<h4 class="mb-0">
									<span>${member.nama}</span>
									</h4>
								</div>
								<div class="col-lg-3">
									<input disabled class="form-control form-control-sm" value="${member.status_user}" id="statusadmin" name="statusadmin">
								</div>
								
								</div>
							`;
							} else {
								listItem.innerHTML = `
									<div class="row align-items-center">
									<div class="col-lg-1">
										<a href="#" class="avatar rounded-circle">
										<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
										</a>
									</div>
									<div class="col-lg-6">
										<h4 class="mb-0">
										<span>${member.nama}</span>
										</h4>
									</div>
									<div class="col-lg-3">
										<select class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="${
											member.id
										}">
										<option value="viewer" ${
											member.status_user === "viewer" ? "selected" : ""
										}>viewer</option>
										<option value="editor" ${
											member.status_user === "editor" ? "selected" : ""
										}>editor</option>
										</select>
									</div>
								
									</div>`;
							}
						} else {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-sm" id="statususer" name="statususer" data-idteam="${
									member.id
								}">
								<option value="viewer" ${
									member.status_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.status_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.status_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							<div class="col-lg-2">
								<button type="button" class="btn btn-sm btn-danger hapususer" data-idspaceteam="${
									member.id
								}">Hapus</button>
							</div>
							</div>`;
						}

						teamList.appendChild(listItem);
					});

					addSelectEventListener();
					hapusEventListener();
				})
				.catch((error) => console.error("Error fetching team members:", error));
		});
	});
	addSelectEventListener();
	hapusEventListener();
});

function addSelectEventListener() {
	const selectElements = document.querySelectorAll('select[name="statususer"]');

	selectElements.forEach((select) => {
		select.addEventListener("change", function () {
			const selectedValue = this.value;
			const idTeam = this.getAttribute("data-idteam");

			// Membuat request AJAX
			fetch(baseURL + "workspace/selectAnggota", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: `idteam=${idTeam}&statususer=${selectedValue}`,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: "Berhasil Dirubah",
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Gagal di Ubah!",
						});
					}
				})
				.catch((error) => console.error("Error:", error));
		});
	});
}

function hapusEventListener() {
	const hapusElements = document.querySelectorAll(".hapususer");
	// Fungsi untuk menghandle tombol hapus
	hapusElements.forEach((button) => {
		button.addEventListener("click", function () {
			const idSpaceTeam = this.getAttribute("data-idspaceteam");

			// Menampilkan konfirmasi SweetAlert
			Swal.fire({
				title: "Apakah Anda yakin?",
				text: "Anda tidak dapat mengembalikan data yang sudah dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Ya, hapus!",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					// Melakukan request AJAX untuk menghapus user
					fetch(baseURL + "workspace/hapusAnggota", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `idspaceteam=${idSpaceTeam}`,
					})
						.then((response) => response.json())
						.then((data) => {
							if (data.success) {
								Swal.fire({
									icon: "success",
									title: "Berhasil!",
									text: "User berhasil dihapus.",
									timer: 2000,
									showConfirmButton: false,
								});

								// Menghapus element list dari DOM
								this.closest("li").remove();
							} else {
								Swal.fire({
									icon: "error",
									title: "Gagal!",
									text: "User gagal dihapus.",
								});
							}
						})
						.catch((error) => {
							console.error("Error:", error);
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Terjadi kesalahan!",
							});
						});
				}
			});
		});
	});
}

document.addEventListener("DOMContentLoaded", function () {
	// Event listener untuk tombol "Edit Anggota"
	document.querySelectorAll(".edit-anggota-obj").forEach((button) => {
		button.addEventListener("click", function () {
			const idokr = this.getAttribute("data-idokr");
			const idpj = this.getAttribute("data-idpj");
			const canedit = this.getAttribute("data-caneditokr");
			const candelete = this.getAttribute("data-candeleteokr");
			const stateus = this.getAttribute("data-roleme");

			// AJAX request untuk mengambil data anggota
			fetch(`${baseURL}workspace/getTeamMembersObj/${idokr}`)
				.then((response) => response.json())
				.then((data) => {
					const teamList = document.getElementById("space-team-list");
					teamList.innerHTML = ""; // Kosongkan daftar sebelumnya

					// Iterasi data anggota dan tambahkan ke modal
					data.forEach((member) => {
						const listItem = document.createElement("li");
						listItem.className = "list-group-item px-0";
						if (stateus == "viewer") {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select disabled class="form-control form-control-sm" id="statususerobj" name="statususerobj" data-idteam="${
									member.id_access_objective
								}">
								<option value="viewer" ${
									member.role_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.role_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.role_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							
							</div>
						`;
						} else if (stateus == "editor") {
							if (member.role_user == "admin") {
								listItem.innerHTML = `
								<div class="row align-items-center">
								<div class="col-lg-1">
									<a href="#" class="avatar rounded-circle">
									<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
									</a>
								</div>
								<div class="col-lg-6">
									<h4 class="mb-0">
									<span>${member.nama}</span>
									</h4>
								</div>
								<div class="col-lg-3">
									<input disabled class="form-control form-control-sm" value="${member.role_user}" id="statusadmin" name="statusadmin">
								</div>
								
								</div>
							`;
							} else {
								listItem.innerHTML = `
									<div class="row align-items-center">
									<div class="col-lg-1">
										<a href="#" class="avatar rounded-circle">
										<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
										</a>
									</div>
									<div class="col-lg-6">
										<h4 class="mb-0">
										<span>${member.nama}</span>
										</h4>
									</div>
									<div class="col-lg-3">
										<select class="form-control form-control-sm" id="statususerobj" name="statususerobj" data-idteam="${
											member.id_access_objective
										}">
										<option value="viewer" ${
											member.role_user === "viewer" ? "selected" : ""
										}>viewer</option>
										<option value="editor" ${
											member.role_user === "editor" ? "selected" : ""
										}>editor</option>
										</select>
									</div>
								
									</div>`;
							}
						} else {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-sm" id="statususerobj" name="statususerobj" data-idteam="${
									member.id_access_objective
								}">
								<option value="viewer" ${
									member.role_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.role_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.role_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							
							</div>`;
						}

						teamList.appendChild(listItem);
					});

					addObjTeamSelectEventListener();
				})
				.catch((error) => console.error("Error fetching team members:", error));
		});
	});
	addObjTeamSelectEventListener();
});

function addObjTeamSelectEventListener() {
	const selectElementsObj = document.querySelectorAll(
		'select[name="statususerobj"]'
	);

	selectElementsObj.forEach((select) => {
		select.addEventListener("change", function () {
			const selectedValue = this.value;
			const idTeam = this.getAttribute("data-idteam");

			// Membuat request AJAX
			fetch(baseURL + "workspace/selectAnggotaObj", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: `idteam=${idTeam}&statususerobj=${selectedValue}`,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: "Berhasil Dirubah",
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Gagal di Ubah!",
						});
					}
				})
				.catch((error) => console.error("Error:", error));
		});
	});
}

document.addEventListener("DOMContentLoaded", function () {
	// Event listener untuk tombol "Edit Anggota"
	document.querySelectorAll(".edit-anggota-btn-okr").forEach((button) => {
		button.addEventListener("click", function () {
			const idtim = this.getAttribute("data-idtim");
			const idpj = this.getAttribute("data-idpj");
			const roleme = this.getAttribute("data-roleme");
			const caneditokr = this.getAttribute("data-caneditokr");
			const candeleteokr = this.getAttribute("data-candeleteokr");

			document.getElementById("idaccessteam").value = idtim;

			// AJAX request untuk mengambil data anggota
			fetch(`${baseURL}project/getTeamMembers/${idtim}`)
				.then((response) => response.json())
				.then((data) => {
					const teamList = document.getElementById("space-team-list");
					teamList.innerHTML = ""; // Kosongkan daftar sebelumnya

					// Iterasi data anggota dan tambahkan ke modal
					data.forEach((member) => {
						const listItem = document.createElement("li");
						listItem.className = "list-group-item px-0";
						if (roleme == "viewer") {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select disabled class="form-control form-control-sm" id="statususerokr" name="statususerokr" data-idteam="${
									member.id_access_team
								}">
								<option value="viewer" ${
									member.role_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.role_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.role_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							</div>
						`;
						} else if (roleme == "editor") {
							if (member.role_user == "admin") {
								listItem.innerHTML = `
								<div class="row align-items-center">
								<div class="col-lg-1">
									<a href="#" class="avatar rounded-circle">
									<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
									</a>
								</div>
								<div class="col-lg-6">
									<h4 class="mb-0">
									<span>${member.nama}</span>
									</h4>
								</div>
								<div class="col-lg-3">
									<input disabled class="form-control form-control-sm" value="${member.role_user}" id="statusadmin" name="statusadmin">
								</div>
								
								</div>
							`;
							} else {
								listItem.innerHTML = `
									<div class="row align-items-center">
									<div class="col-lg-1">
										<a href="#" class="avatar rounded-circle">
										<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
										</a>
									</div>
									<div class="col-lg-6">
										<h4 class="mb-0">
										<span>${member.nama}</span>
										</h4>
									</div>
									<div class="col-lg-3">
										<select class="form-control form-control-sm" id="statususerokr" name="statususerokr" data-idteam="${
											member.id_access_team
										}">
										<option value="viewer" ${
											member.role_user === "viewer" ? "selected" : ""
										}>viewer</option>
										<option value="editor" ${
											member.role_user === "editor" ? "selected" : ""
										}>editor</option>
										</select>
									</div>
								
									</div>
								`;
							}
						} else {
							listItem.innerHTML = `
							<div class="row align-items-center">
							<div class="col-lg-1">
								<a href="#" class="avatar rounded-circle">
								<img alt="Image placeholder" src="${baseURL}assets/img/profile/${member.foto}">
								</a>
							</div>
							<div class="col-lg-6">
								<h4 class="mb-0">
								<span>${member.nama}</span>
								</h4>
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-sm" id="statususerokr" name="statususerokr" data-idteam="${
									member.id_access_team
								}">
								<option value="viewer" ${
									member.role_user === "viewer" ? "selected" : ""
								}>viewer</option>
								<option value="editor" ${
									member.role_user === "editor" ? "selected" : ""
								}>editor</option>
								<option value="admin" ${
									member.role_user === "admin" ? "selected" : ""
								}>admin</option>
								</select>
							</div>
							<div class="col-lg-2">
								<button type="button" class="btn btn-sm btn-danger hapususerokr" data-idspaceteam="${
									member.id_access_team
								}">Hapus</button>
							</div>
							</div>`;
						}

						teamList.appendChild(listItem);
					});

					addSelectOKREventListener();
					hapusOkrEventListener();
				})
				.catch((error) => console.error("Error fetching team members:", error));
		});
	});
	addSelectOKREventListener();
	hapusOkrEventListener();
	addNewSelectOKREventListener();
});

function addSelectOKREventListener() {
	const selectElements = document.querySelectorAll(
		'select[name="statususerokr"]'
	);

	selectElements.forEach((select) => {
		select.addEventListener("change", function () {
			const selectedValue = this.value;
			const idTeam = this.getAttribute("data-idteam");

			// Membuat request AJAX
			fetch(`${baseURL}project/selectAnggotaOKR/`, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: `idteam=${idTeam}&statususer=${selectedValue}`,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
						});
						Toast.fire({
							icon: "success",
							title: "Berhasil Dirubah",
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Gagal di Ubah!",
						});
					}
				})
				.catch((error) => console.error("Error:", error));
		});
	});
}

function addNewSelectOKREventListener() {
	const selectElements = document.querySelectorAll(
		'select[name="statususerinokr"]'
	);

	selectElements.forEach((select) => {
		select.addEventListener("change", function () {
			const selectedValue = this.value;
			const idTeam = this.getAttribute("data-idteam");

			// Membuat request AJAX
			fetch(`${baseURL}project/selectAnggotaOKR/`, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: `idteam=${idTeam}&statususer=${selectedValue}`,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							},
							// didClose: () => {
							// 	Swal.fire({
							// 		title: "Mau reload halaman?",
							// 		text: "Perubahan sudah berhasil, apakah Anda ingin me-reload halaman?",
							// 		icon: "warning",
							// 		showCancelButton: true,
							// 		confirmButtonText: "Ya, reload!",
							// 		cancelButtonText: "Tidak",
							// 	}).then((result) => {
							// 		if (result.isConfirmed) {
							// 			// Reload halaman jika user menekan tombol "Ya, reload!"
							// 			window.location.reload();
							// 		}
							// 	});
							// },
						});
						Toast.fire({
							icon: "success",
							title: "Berhasil Dirubah",
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Gagal di Ubah!",
						});
					}
				})
				.catch((error) => console.error("Error:", error));
		});
	});
}

function hapusOkrEventListener() {
	const hapusElements = document.querySelectorAll(".hapususerokr");
	// Fungsi untuk menghandle tombol hapus
	hapusElements.forEach((button) => {
		button.addEventListener("click", function () {
			const idSpaceTeam = this.getAttribute("data-idspaceteam");

			// Menampilkan konfirmasi SweetAlert
			Swal.fire({
				title: "Apakah Anda yakin?",
				text: "Anda tidak dapat mengembalikan data yang sudah dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Ya, hapus!",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					// Melakukan request AJAX untuk menghapus user
					fetch(baseURL + "project/hapusAnggotaOKR", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `idspaceteam=${idSpaceTeam}`,
					})
						.then((response) => response.json())
						.then((data) => {
							if (data.success) {
								Swal.fire({
									icon: "success",
									title: "Berhasil!",
									text: "User berhasil dihapus.",
									timer: 2000,
									showConfirmButton: false,
								});

								// Menghapus element list dari DOM
								this.closest("li").remove();
							} else {
								Swal.fire({
									icon: "error",
									title: "Gagal!",
									text: "User gagal dihapus.",
								});
							}
						})
						.catch((error) => {
							console.error("Error:", error);
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Terjadi kesalahan!",
							});
						});
				}
			});
		});
	});
}

document.addEventListener("DOMContentLoaded", function () {
	var buttons = document.querySelectorAll(".checkmyokr"); // Mengambil semua tombol dengan kelas badge-primary

	buttons.forEach(function (button) {
		button.addEventListener("click", function (event) {
			event.preventDefault(); // Mencegah tombol untuk melakukan navigasi

			// Ambil data dari atribut tombol
			var namaOkr = button.getAttribute("data-namaokr");
			var progressOkr = button.getAttribute("data-progressokr");
			var url = button.getAttribute("data-url");
			var desc = button.getAttribute("data-descokr");

			// Tampilkan SweetAlert dengan data yang diambil
			Swal.fire({
				title: "Detail OKR",
				html: `
					<span class="text-small">${desc}</span>
                    <h2>${namaOkr}</h2>
                    <h4><b>Progress:<b> <span class="text-success">${progressOkr}%</span></h4>
                `,
				showCancelButton: true,
				confirmButtonText: "Lihat OKR",
				cancelButtonText: "Tutup",
				preConfirm: () => {
					window.open(url, "_blank"); // Buka URL di tab baru jika tombol "Lihat OKR" diklik
				},
			});
		});
	});
});
