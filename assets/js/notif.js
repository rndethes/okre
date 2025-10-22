const firebaseConfig = {
	apiKey: "AIzaSyCfCILTIQsQMCvt__0_UxLu513_ejYeItc",
	authDomain: "okre-ethes-tech.firebaseapp.com",
	projectId: "okre-ethes-tech",
	storageBucket: "okre-ethes-tech.appspot.com",
	messagingSenderId: "484531713150",
	appId: "1:484531713150:web:82fd12ebb81488555c142f",
	measurementId: "G-BBWKTGKRH3",
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

function requestNotificationPermission() {
	Notification.requestPermission().then(function (permission) {
		if (permission === "granted") {
			// Jika izin notifikasi telah diberikan, dapatkan token dan mendaftarkan perangkat
			registerServiceWorkerAndGetToken();
		} else if (permission === "denied") {
			alert(
				"Anda telah menolak izin notifikasi. Silakan aktifkan izin notifikasi melalui pengaturan browser Anda."
			);
		}
	});
}

function registerServiceWorkerAndGetToken() {
	if ("serviceWorker" in navigator) {
		navigator.serviceWorker
			.register(baseURL + "firebase-messaging-sw.js")
			.then(function (registration) {
				messaging.useServiceWorker(registration);

				messaging
					.getToken({
						vapidKey:
							"BBrHm9G0i4ODFBCWvNQmKKCLBiOWmEheuN_7KUtaNaX-uWImOSFJKbEHl8S6Gnq_5vD1P7_JaALmNWaqYl18hZg",
					})
					.then(function (currentToken) {
						if (currentToken) {
							console.log(currentToken);
							// Mengirim token ke server Anda untuk disimpan
							$.ajax({
								url: baseURL + "dashboard/saveToken",
								type: "POST",
								data: {
									token: currentToken,
								},
								success: function (data) {
									console.log("Success save token");
								},
							});
						} else {
							console.log("No registration token available.");
						}
					})
					.catch(function (err) {
						console.log("An error occurred while retrieving token. ", err);
					});
			});
	}
}

if ("Notification" in window) {
	// Memeriksa status izin notifikasi pengguna
	if (Notification.permission === "granted") {
		// Jika izin notifikasi telah diberikan, dapatkan token dan mendaftarkan perangkat
		registerServiceWorkerAndGetToken();
	} else if (Notification.permission !== "denied") {
		// Jika izin notifikasi belum diberikan, tampilkan permintaan izin notifikasi
		requestNotificationPermission();
	}
}

$(document).ready(function () {
	var lastSwalTime = new Date().getTime();
	function loadMessages() {
		$.getJSON(baseURL + "workspace/getMessages", function (data) {
			$("#newmessage").empty();
			var unreadCount = data.result.length; // Menghitung jumlah pesan yang belum dibaca

			// Update jumlah pesan di bagian notifikasi
			$("#message-count").text(unreadCount);

			// Update badge jika ada pesan baru
			if (unreadCount > 0) {
				$("#badge-count").text(unreadCount).show();
			} else {
				$("#badge-count").hide();
			}
			$.each(data.result, function () {
				const date = new Date(this["created_at_notif"]);
				const year = date.getFullYear();
				const month = new Intl.DateTimeFormat("en", { month: "long" }).format(
					date
				);
				const day = date.getDate();

				const formattedDate = `${day} ${month} ${year}`;
				const rawUrl = this["data_notif"];
				let cleanUrl = rawUrl;

				try {
					// Jika data_notif adalah string JSON, parsing mungkin diperlukan
					const parsedData = JSON.parse(rawUrl);
					cleanUrl = parsedData.url.replace(/\\/g, ""); // Menghapus escape character
				} catch (e) {
					// Jika tidak bisa diparsing, gunakan rawUrl langsung
					cleanUrl = rawUrl.replace(/\\/g, "");
				}

				const parsedDataTask = JSON.parse(rawUrl);
				let task = parsedDataTask.type
					? parsedDataTask.type === "taskmeeting"
						? "meeting"
						: "task"
					: "";

				if (task == "meeting") {
					const parsedData = JSON.parse(rawUrl);
					myidtask = parsedData.idtask;

					$("#newmessage").append(
						`<a href="" class="list-group-item list-group-item-action notif-meeting" data-url="` +
							cleanUrl +
							`" data-idnotif="` +
							this["id_notif"] +
							`" data-mytask="` +
							myidtask +
							`" data-descnotif="` +
							this["message_notif"] +
							`"
							">
                    <div class="row align-items-center">
                      <div class="col-auto">
					  	<img alt="Image placeholder" src="` +
							baseURL +
							`assets/img/profile/` +
							this["foto"] +
							`" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">` +
							this["nama"] +
							` <span class="text-primary">Meeting<span></h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>` +
							formattedDate +
							`</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">` +
							this["message_notif"] +
							`</p>
                      </div>
                    </div>
                  </a>`
					);
				} else {
					$("#newmessage").append(
						`<a href="" class="list-group-item list-group-item-action notif-action" data-url="` +
							cleanUrl +
							`" data-idnotif="` +
							this["id_notif"] +
							`">
                    <div class="row align-items-center">
                      <div class="col-auto">
					  	<img alt="Image placeholder" src="` +
							baseURL +
							`assets/img/profile/` +
							this["foto"] +
							`" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">` +
							this["nama"] +
							` </h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>` +
							formattedDate +
							`</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">` +
							this["message_notif"] +
							`</p>
                      </div>
                    </div>
                  </a>`
					);
				}
			});
			// Cek dan tampilkan SweetAlert jika ada notifikasi baru
			var currentTime = new Date().getTime();
			if (unreadCount > 0 && currentTime - lastSwalTime >= 10 * 60 * 1000) {
				// 10 menit
				Swal.fire({
					title: "Ada notifikasi baru!",
					text: `Kamu memiliki ${unreadCount} notifikasi yang belum dibaca.`,
					icon: "info",
					showCancelButton: true,
					confirmButtonText: "Lihat Notifikasi",
				}).then((result) => {
					if (result.isConfirmed) {
						// Arahkan pengguna ke halaman notifikasi jika diperlukan
						window.location.href = baseURL + "workspace/myNotification/";
					}
				});

				lastSwalTime = currentTime; // Update waktu terakhir SweetAlert ditampilkan
			}
		});
	}

	// Memanggil fungsi untuk load pesan
	loadMessages();

	// Bisa juga di-set interval untuk mengambil pesan setiap beberapa detik
	setInterval(loadMessages, 5000); // Refresh setiap 5 detik

	$(document).on("click", ".notif-action", function (e) {
		e.preventDefault(); // Mencegah perilaku default dari link

		var notificationId = $(this).data("idnotif");
		var redirectUrl = $(this).data("url");

		// Tandai notifikasi sebagai dibaca di server
		$.ajax({
			url: baseURL + "workspace/markAsRead", // Endpoint server untuk menandai notifikasi sebagai dibaca
			type: "POST",
			data: { id_notif: notificationId },
			success: function (response) {
				// Alihkan pengguna ke URL setelah notifikasi berhasil ditandai sebagai dibaca
				window.location.href = redirectUrl;
			},
			error: function (xhr, status, error) {
				console.log("Error marking notification as read:", error);
				// Alihkan pengguna ke URL meskipun terjadi error
				window.location.href = redirectUrl;
			},
		});
	});
	function checkOverdueTasks() {
		$.ajax({
			url: baseURL + "workspace/check_overdue_tasks",
			type: "GET",
			dataType: "json",
			success: function (data) {
				if (data.length > 0) {
					// Tampilkan notifikasi jika ada task yang overdue
					Swal.fire({
						title: "Ada Task yang Overdue!",
						text: `Kamu memiliki ${data.length} task yang sudah overdue.`,
						icon: "warning",
						showCancelButton: true,
						confirmButtonText: "Lihat Task",
					}).then((result) => {
						if (result.isConfirmed) {
							// Arahkan pengguna ke halaman task jika diperlukan
							window.location.href = baseURL + "/calendar/viewall";
						}
					});
				}
			},
			error: function (xhr, status, error) {
				console.log("Terjadi kesalahan: ", error);
			},
		});
	}

	// Cek overdue tasks setiap 10 menit (600000 ms)
	setInterval(checkOverdueTasks, 600000);
});

document.addEventListener("DOMContentLoaded", function () {
	// Gunakan event delegation pada elemen induk
	document
		.getElementById("newmessage")
		.addEventListener("click", function (event) {
			// Pastikan elemen yang diklik memiliki class 'notif-meeting'
			if (event.target.closest(".notif-meeting")) {
				event.preventDefault(); // Mencegah aksi default link

				// Dapatkan elemen yang diklik
				const targetElement = event.target.closest(".notif-meeting");

				// Dapatkan data dari elemen yang diklik
				const notifId = targetElement.getAttribute("data-idnotif");
				const url = targetElement.getAttribute("data-url");
				const idtask = targetElement.getAttribute("data-mytask");
				const desc = targetElement.getAttribute("data-descnotif");

				console.log(desc);

				// Tampilkan SweetAlert2 dengan tiga tombol
				Swal.fire({
					title: "Apakah kamu akan menerima meeting ini?",
					text: desc,
					icon: "question",
					showCancelButton: true,
					showDenyButton: true,
					confirmButtonText: "Terima",
					denyButtonText: "Tolak",
					cancelButtonText: "Ubah",
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
						console.log("Tolak meeting dengan ID:", notifId);
						$.ajax({
							url: baseURL + "workspace/aprovalTask", // Endpoint server untuk menandai notifikasi sebagai dibaca
							type: "POST",
							data: { id_notif: notifId, idtask: idtask },
							success: function (response) {
								// Alihkan pengguna ke URL setelah notifikasi berhasil ditandai sebagai dibaca
								window.location.reload();
							},
							error: function (xhr, status, error) {
								console.log("Error marking notification as read:", error);
								// Alihkan pengguna ke URL meskipun terjadi error
								window.location.reload();
							},
						});
						// Aksi jika memilih 'Terima'
						// Lakukan aksi seperti mengirim request ke server dengan AJAX
					} else if (result.isDenied) {
						// Aksi jika memilih 'Tolak'
						console.log("Tolak meeting dengan ID:", notifId);
						$.ajax({
							url: baseURL + "workspace/rejectTask", // Endpoint server untuk menandai notifikasi sebagai dibaca
							type: "POST",
							data: { id_notif: notifId, idtask: idtask },
							success: function (response) {
								// Alihkan pengguna ke URL setelah notifikasi berhasil ditandai sebagai dibaca
								window.location.reload();
							},
							error: function (xhr, status, error) {
								console.log("Error marking notification as read:", error);
								// Alihkan pengguna ke URL meskipun terjadi error
								window.location.reload();
							},
						});
						// Lakukan aksi untuk menolak meeting
					} else if (result.dismiss === Swal.DismissReason.cancel) {
						// Aksi jika memilih 'Ubah'
						console.log("Ubah meeting dengan ID:", notifId);
						$.ajax({
							url: baseURL + "workspace/markAsReadMeeting", // Endpoint server untuk menandai notifikasi sebagai dibaca
							type: "POST",
							data: { id_notif: notifId },
							success: function (response) {
								// Alihkan pengguna ke URL setelah notifikasi berhasil ditandai sebagai dibaca
								window.location.href = url;
							},
							error: function (xhr, status, error) {
								console.log("Error marking notification as read:", error);
								// Alihkan pengguna ke URL meskipun terjadi error
								window.location.href = url;
							},
						});

						// Lakukan aksi untuk mengubah meeting (misalnya buka form ubah)
					}
				});
			}
		});
});

$(document).ready(function () {
	// Fungsi untuk mengecek jadwal user
	function checkUserSchedule() {
		var userId = $("#userselectpvt").val();
		var startDate = $("#startpvt").val();
		var endDate = $("#overduepvt").val();
		var isMeetingChecked = $("#meetingCheckbox").is(":checked");

		if (isMeetingChecked && userId && startDate) {
			// Lakukan AJAX request untuk mengecek jadwal
			$.ajax({
				url: baseURL + "task/userSchedule", // Ganti dengan URL yang tepat
				method: "POST",
				data: {
					userId: userId,
					startDate: startDate,
					endDate: endDate,
				},
				dataType: "json",
				success: function (response) {
					console.log(response);
					console.log(response.hasSchedule);
					if (response.hasSchedule) {
						Swal.fire({
							title:
								response.userName + " sudah ada jadwal di tanggal tersebut",
							text: "Apakah akan melanjutkan penginputan?",
							icon: "warning",
							showCancelButton: true,
							confirmButtonText: "Ya",
							cancelButtonText: "Tidak",
						}).then((result) => {
							if (result.isConfirmed) {
								// Lanjutkan penginputan
							}
						});
					}
				},
			});
		}
	}

	// Event ketika checkbox meeting dicentang
	$("#meetingCheckbox").change(function () {
		if ($(this).is(":checked")) {
			checkUserSchedule();
		}
	});

	// Event ketika user dipilih
	$("#userselectpvt").change(function () {
		if ($("#meetingCheckbox").is(":checked")) {
			checkUserSchedule();
		}
	});
});
