(function () {
	$(".form-key").on("submit", function () {
		$(".btn-key").attr("disabled", "true");
		$(".spinner").show();
		$(".btn-inner--text").hide();
		$(".ni-fat-add").hide();
	});
})();

(function () {
	$(".form-inisiative").on("submit", function () {
		$(".btn-inisiative").attr("disabled", "true");
		$(".spinner").show();
		$(".btn-inner--text").hide();
		$(".ni-fat-add").hide();
	});
})();

// (function () {
// 	$(".form-inputkey").on("submit", function () {
// 		$(".btn-input").attr("disabled", "true");
// 		$(".spinner").show();
// 		$(".btn-inner--text").hide();
// 		$(".fa-plus").hide();
// 	});
// })();

$(document).ready(function () {
	// Function to load workspace details from sessionStorage
	function loadWorkspaceFromSession() {
		var savedWorkspace = sessionStorage.getItem("savedWorkspace");
		if (savedWorkspace) {
			var data = JSON.parse(savedWorkspace);
			$("#workspaceName").text(data.workspaceName);

			$("#workspaceDetails").empty();
			$.each(data.projects, function (index, project) {
				$("#workspaceDetails").append(
					'<li class="list-group-item px-0">' +
						'<div class="row align-items-center">' +
						'<div class="col-auto"><a href="#!" class="avatar avatar-xs rounded-circle bg-warning"><i class="fas fa-info-circle"></i></a></div>' +
						'<div class="col ml--2">' +
						'<h4 class="mb-0"><a href="#!">' +
						project.nama_project +
						"</a></h4>" +
						'<span class="text-success">●</span>' +
						"<small>" +
						project.id_project +
						"</small> | " +
						'<span class="text-info">' +
						project.value_project +
						"%</span>" +
						"</div>" +
						'<div class="col-auto">' +
						'<a href="' +
						baseURL +
						"project/showOkr/" +
						project.id_project +
						'" class="btn btn-sm btn-primary" onclick="saveCurrentUrl(\'' +
						data.currentUrl +
						"')\">View</a>" +
						"</div>" +
						"</div>" +
						"</li>"
				);
			});
		}
	}

	// Call the function to load data from sessionStorage if available
	loadWorkspaceFromSession();

	// Event listener for the "View" button
	$(".view-workspace").on("click", function () {
		var workspaceId = $(this).data("workspaceid");

		// Make AJAX call to get workspace data
		$.ajax({
			url: baseURL + "workspace/getWorkspaceData/" + workspaceId,
			type: "GET",
			dataType: "json",
			success: function (response) {
				var workspace = response.workspace;
				var projects = response.projects;

				// Update the HTML with the retrieved data
				$("#workspaceName").text(workspace.name_space);

				// Clear the previous list items
				$("#workspaceDetails").empty();

				// Append new list items
				$.each(projects, function (index, project) {
					$("#workspaceDetails").append(
						'<li class="list-group-item px-0">' +
							'<div class="row align-items-center">' +
							'<div class="col-auto"><a href="#!" class="avatar avatar-xs rounded-circle bg-warning"><i class="fas fa-info-circle"></i></a></div>' +
							'<div class="col ml--2">' +
							'<h4 class="mb-0"><a href="#!">' +
							project.nama_project +
							"</a></h4>" +
							'<span class="text-success">●</span>' +
							"<small>" +
							project.id_project +
							"</small> | " +
							'<span class="text-info">' +
							project.value_project +
							"%</span>" +
							"</div>" +
							'<div class="col-auto">' +
							'<a href="' +
							baseURL +
							"project/showOkr/" +
							project.id_project +
							'" class="btn btn-sm btn-primary" onclick="saveCurrentUrl(\'' +
							baseURL +
							"project/projectAtWorkspace/" +
							workspaceId +
							"')\">View</a>" +
							"</div>" +
							"</div>" +
							"</li>"
					);
				});

				// Save workspace data to sessionStorage
				sessionStorage.setItem(
					"savedWorkspace",
					JSON.stringify({
						workspaceName: workspace.name_space,
						projects: projects,
						currentUrl: baseURL + "project/projectAtWorkspace/" + workspaceId,
					})
				);
			},
			error: function (xhr, status, error) {
				console.log("Error: " + error);
			},
		});
	});
});

function saveCurrentUrl(nextUrl) {
	// Simpan URL saat ini ke sessionStorage sebelum pindah ke halaman baru
	sessionStorage.setItem("previousUrl", nextUrl);
}

function goBackToPreviousPage() {
	// Ambil URL sebelumnya dari sessionStorage
	const previousUrl = sessionStorage.getItem("previousUrl");

	if (previousUrl) {
		// Arahkan ke URL sebelumnya
		window.location.href = previousUrl;
	} else {
		// Arahkan ke URL default jika previousUrl tidak tersedia
		window.location.href = baseURL + "/dashboard";
	}
}

$(".favorite-workspace").on("click", function (event) {
	event.preventDefault(); // Mencegah tindakan default dari elemen <a>

	var $this = $(this);
	var workspaceId = $this.data("idspace");
	var $icon = $this.find("i");

	$.ajax({
		url: baseURL + "workspace/toggle_favorite",
		type: "POST",
		data: {
			workspace_id: workspaceId,
		},
		success: function (response) {
			var data = JSON.parse(response);
			if (data.is_favorite) {
				$this.addClass("text-warning");
				$icon.addClass("text-warning");
				$this.addClass("active");
			} else {
				$this.removeClass("text-warning");
				$icon.removeClass("text-warning");
				$this.removeClass("active");
			}
		},
	});

	// Efek transisi
	$icon.toggleClass("active");
});

document.addEventListener("DOMContentLoaded", function () {
	const deleteButtons = document.querySelectorAll(".delete-space");

	deleteButtons.forEach((button) => {
		button.addEventListener("click", function () {
			const deleteUrl = this.getAttribute("data-deletespace");

			Swal.fire({
				title: "Hapus Space?",
				text: "Yakin untuk hapus space!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Hapus!",
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = deleteUrl;
				}
			});
		});
	});
});

document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll("#publish").forEach(function (button) {
		button.addEventListener("click", function () {
			var idDocument = this.getAttribute("data-iddocument");
			var idPrj = this.getAttribute("data-prj");
			var status = this.getAttribute("data-status");
			var spaceidpublish = this.getAttribute("data-idspace");

			console.log(status);

			Swal.fire({
				title: "Pilihlah Opsi Publish",
				text: "Pilihlah Opsi Publish jika klik publish email maka kamu akan diarahkan untuk ke halaman email:",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Publish",
				cancelButtonText: "Publish Email",
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						icon: "success",
						title: "Berhasil!",
						text: "Berhasil Berganti Status Publish!",
						confirmButtonText: "OK",
					}).then((result) => {
						if (result.isConfirmed) {
							// Jika user memilih "Publish"
							window.location.href =
								baseURL +
								"document/publishDocumentAll/" +
								idPrj +
								"/" +
								spaceidpublish +
								"/" +
								status +
								"/" +
								idDocument;
						}
					});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					// Jika user memilih "Publish with Email"
					window.location.href =
						baseURL +
						"document/setEmailPublish/" +
						idPrj +
						"/" +
						idDocument +
						"/" +
						status;
				}
			});
		});
	});
});

// Pastikan Anda memuat library SweetAlert
document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".tombol-hapus-dokumen").forEach(function (button) {
		button.addEventListener("click", function (event) {
			event.preventDefault(); // Mencegah aksi default dari tombol

			var link = this.getAttribute("data-link"); // Ambil URL dari atribut data-link

			Swal.fire({
				title: "Apakah Anda yakin?",
				text: "Dokumen yang dihapus tidak dapat dikembalikan!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d33",
				cancelButtonColor: "#3085d6",
				confirmButtonText: "Ya, hapus!",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = link; // Redirect ke URL penghapusan
				}
			});
		});
	});
});

document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".tombol-hapus-newdoc").forEach(function (button) {
		button.addEventListener("click", function (event) {
			event.preventDefault(); // Cegah tindakan default (navigasi ke URL)

			const url = this.getAttribute("data-link"); // Ambil URL dari data-url

			Swal.fire({
				title: "Apakah Anda yakin?",
				text: "Dokumen ini akan dihapus secara permanen!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, hapus!",
				cancelButtonText: "Batal",
			}).then((result) => {
				if (result.isConfirmed) {
					// Jika dikonfirmasi, redirect ke URL delete
					window.location.href = url;
				}
			});
		});
	});
});

// $(document).ready(function () {
// 	// Fungsi untuk memuat data pesan dan pagination
// 	function loadNotificationAll(page) {
// 		$.ajax({
// 			url: baseURL + "workspace/get_messages_all/" + page,
// 			type: "GET",
// 			dataType: "json",
// 			success: function (data) {
// 				// Kosongkan daftar pesan
// 				$("#message-list").empty();

// 				// Tambahkan pesan baru
// 				$.each(data.messages, function (index, message) {
// 					$("#message-list").append(
// 						`<li class="list-group-item">
//                             <div class="row align-items-center">
//                                 <div class="col-auto">
//                                     <a href="#" class="avatar rounded-circle">
//                                         <img alt="Image placeholder" src="<?= base_url('assets/img/profile/') ?>${message.foto}">
//                                     </a>
//                                 </div>
//                                 <div class="col ml--2">
//                                     <h4 class="mb-0">
//                                         <a href="#">${message.nama}</a>
//                                     </h4>
//                                     <small>${message.message_notif}</small>
//                                 </div>
//                             </div>
//                         </li>`
// 					);
// 				});

// 				// Kosongkan pagination
// 				$("#pagination").empty();

// 				// Previous button (disabled jika halaman pertama)
// 				let previousDisabled = page == 1 ? "disabled" : "";
// 				$("#pagination").append(
// 					`<li class="page-item ${previousDisabled}">
// 						 <a class="page-link" href="#" onclick="loadMessages(${
// 								page - 1
// 							})" tabindex="-1">
// 							 <i class="fa fa-angle-left"></i>
// 							 <span class="sr-only">Previous</span>
// 						 </a>
// 					 </li>`
// 				);

// 				// Generate pagination buttons
// 				for (let i = 1; i <= data.total_pages; i++) {
// 					let activeClass = page == i ? "active" : "";
// 					$("#pagination").append(
// 						`<li class="page-item ${activeClass}">
// 							 <a class="page-link" href="#" onclick="loadMessages(${i})">${i}</a>
// 						 </li>`
// 					);
// 				}

// 				// Next button (disabled jika halaman terakhir)
// 				let nextDisabled = page == data.total_pages ? "disabled" : "";
// 				$("#pagination").append(
// 					`<li class="page-item ${nextDisabled}">
// 						 <a class="page-link" href="#" onclick="loadMessages(${page + 1})">
// 							 <i class="fa fa-angle-right"></i>
// 							 <span class="sr-only">Next</span>
// 						 </a>
// 					 </li>`
// 				);
// 			},
// 			error: function () {
// 				alert("Gagal memuat pesan");
// 			},
// 		});
// 	}

// 	// Muat data pertama kali saat halaman dimuat
// 	loadNotificationAll(1);
// });
