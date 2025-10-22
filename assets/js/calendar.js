document.addEventListener("DOMContentLoaded", function () {
	// Inisialisasi kalender
	var calendarEl = document.getElementById("calendar");
	var calendar;
	if (calendarEl) {
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: "dayGridMonth", // Tampilan awal
			headerToolbar: {
				left: "prev,next today",
				center: "title",
				right: "dayGridMonth,timeGridWeek,timeGridDay",
			},
			events: [], // Events akan diisi berdasarkan filter
			eventClick: function (info) {
				const eventDate = new Date(info.event.start);
				const formattedDate = eventDate.toLocaleDateString("id-ID", {
					day: "numeric",
					month: "long",
					year: "numeric",
				});
				// Memperbarui konten modal
				document.querySelector("#modalCalendar .heading").textContent =
					info.event.title;
				document.querySelector("#modalCalendar h5").textContent = formattedDate;
				document.querySelector("#description-container").innerHTML =
					info.event.extendedProps.description;

				const editJadwalButton = document.getElementById("editjadwal");

				const viewNotifButton = document.getElementById("viewnotif");

				// Tambahkan atribut baru, misalnya data-idtask
				editJadwalButton.setAttribute(
					"data-taskin",
					info.event.extendedProps.taskin !== undefined
						? info.event.extendedProps.taskin
						: "0"
				);

				// Menampilkan modal
				$("#modalCalendar").modal("show");

				// Tambahkan event listener untuk meng-handle klik
				editJadwalButton.addEventListener("click", function () {
					// Ambil nilai dari atribut data-idpace
					const idPace = this.getAttribute("data-idpace");

					// Redirect ke URL yang diinginkan, misalnya:
					const url =
						baseURL +
						`task/editTaskInCalendar/${
							info.event.extendedProps.taskin !== undefined
								? info.event.extendedProps.taskin
								: "0"
						}/${info.event.id}/${idPace}`; // Ganti yourBaseURL dan somePath dengan nilai yang sesuai
					window.location.href = url;
				});
			},
		});

		// Render kalender
		calendar.render();
		// Ambil elemen checkbox dan filter
		const checkboxes = document.querySelectorAll(
			'input[name="usercalendar[]"]'
		);
		const checkAll = document.getElementById("usercalendar-all");
		const spaceid = document.getElementById("idspace");
		var idspace;
		if (spaceid) {
			const idspace = document.getElementById("idspace").value;
		}

		// Tambahkan event listener untuk checkbox user dan checkbox "All"
		checkboxes.forEach((checkbox) => {
			checkbox.addEventListener("change", function () {
				applyFilters();
			});
		});

		if (checkAll) {
			checkAll.addEventListener("change", function () {
				if (this.checked) {
					// Jika "All" dicentang, cek semua checkbox user dan disabled
					checkboxes.forEach((checkbox) => {
						checkbox.checked = true;
						checkbox.disabled = true;
					});
				} else {
					// Jika "All" tidak dicentang, uncheck semua checkbox user dan enable kembali
					checkboxes.forEach((checkbox) => {
						checkbox.checked = false;
						checkbox.disabled = false;
					});
				}
				applyFilters(); // Terapkan filter baru
			});
		}

		// Fungsi untuk menerapkan filter dan mengambil event yang sesuai
		function applyFilters() {
			const selectedUsers = Array.from(checkboxes)
				.filter((checkbox) => checkbox.checked)
				.map((checkbox) => checkbox.value);

			fetchFilteredEvents(selectedUsers, idspace);
		}

		function fetchFilteredEvents(selectedUsers, idspace) {
			const url = baseURL + "calendar/getTasks";
			const params = new URLSearchParams({
				users: selectedUsers.join(","), // Menggabungkan array jadi string
				idspace: idspace,
			});

			fetch(`${url}?${params}`)
				.then((response) => {
					if (!response.ok) {
						throw new Error("Network response was not ok");
					}
					return response.json();
				})
				.then((data) => {
					calendar.removeAllEvents(); // Hapus semua event sebelumnya
					calendar.addEventSource(data.events); // Tambahkan event baru yang sesuai filter
				})
				.catch((error) =>
					console.error("Error fetching filtered events:", error)
				);
		}

		// Load awal saat halaman pertama kali dimuat
		applyFilters();
	}
});

$(document).ready(function () {
	// Ambil elemen checkbox dan filter
	const checkboxesall = document.querySelectorAll(
		'input[name="usercalendarall[]"]'
	);
	const checkAllView = document.getElementById("usercalendar-allview");

	// Tambahkan event listener ke tombol filter
	const filterButton = document.getElementById("filterButton");

	const userFilter = document.getElementById("filteruserall");
	const spaceFilter = document.getElementById("filtermyspaceall");

	const resetButton = document.getElementById("resetFilter");

	// Fungsi reset filter
	if (resetButton) {
		resetButton.addEventListener("click", function (event) {
			event.preventDefault();

			// Reset value dari kedua filter
			userFilter.value = "";
			spaceFilter.value = "";

			// Aktifkan kembali kedua filter
			userFilter.disabled = false;
			spaceFilter.disabled = false;

			// Bersihkan hasil filter sebelumnya (misalnya list kalender)
			document.getElementById("list-container").innerHTML = "";

			applyFiltersAll();

			console.log("Filters have been reset");
		});
	}

	if (userFilter) {
		// Event listener untuk mematikan filter space saat user dipilih
		userFilter.addEventListener("change", function () {
			if (userFilter.value !== "") {
				spaceFilter.disabled = true; // Matikan filter space
			} else {
				spaceFilter.disabled = false; // Aktifkan kembali jika user filter kosong
			}
		});
	}

	if (spaceFilter) {
		// Event listener untuk mematikan filter user saat space dipilih
		spaceFilter.addEventListener("change", function () {
			if (spaceFilter.value !== "") {
				userFilter.disabled = true; // Matikan filter user
			} else {
				userFilter.disabled = false; // Aktifkan kembali jika space filter kosong
			}
		});
	}

	if (filterButton) {
		filterButton.addEventListener("click", function (e) {
			e.preventDefault(); // Mencegah aksi default tombol jika ada (misalnya, submit form)
			let selectedUser = userFilter.value;
			let selectedSpace = spaceFilter.value;

			// Jika user dipilih, filter berdasarkan user
			if (selectedUser) {
				// Lakukan filter berdasarkan user
				console.log("Filtering by user: " + selectedUser);
				// Ajax untuk fetch data dari user
				fetchCalendarByUser(selectedUser);
			}
			// Jika space dipilih, filter berdasarkan space
			else if (selectedSpace) {
				applyFiltersAll();
			}
			// Jika tidak ada yang dipilih
			else {
				console.log("Please select a user or space");
			}
		});
	}

	// Fungsi untuk menerapkan filter dan mengambil event yang sesuai
	function applyFiltersAll() {
		const checkboxesall = document.querySelectorAll(
			'input[name="usercalendarall[]"]'
		);
		const selectedUsers = Array.from(checkboxesall)
			.filter((checkbox) => checkbox.checked)
			.map((checkbox) => checkbox.value);

		fetchFilteredEventsAll(selectedUsers);
	}

	function fetchCalendarByUser(userId) {
		const idsp = document.getElementById("idspace");
		if (idsp) {
			const idspaceall = document.getElementById("idspace").value;
			const checkinspace = document.getElementById("checkinspace").value;
			const url = baseURL + "calendar/getTasksFromUser";
			const params = new URLSearchParams({
				users: userId, // Menggabungkan array jadi string
				idspaceall: idspaceall,
				cekin: checkinspace,
			});

			fetch(`${url}?${params}`)
				.then((response) => {
					if (!response.ok) {
						throw new Error("Network response was not ok");
					}
					return response.json();
				})
				.then((data) => {
					calendarall.removeAllEvents(); // Hapus semua event sebelumnya
					calendarall.addEventSource(data.events); // Tambahkan event baru yang sesuai filter
				})
				.catch((error) =>
					console.error("Error fetching filtered events:", error)
				);
		}
	}

	// Fungsi untuk fetch data
	function fetchFilteredEventsAll(selectedUsers) {
		const idsp = document.getElementById("idspace");
		if (idsp) {
			const idspaceall = document.getElementById("idspace").value;
			const checkinspace = document.getElementById("checkinspace").value;
			const url = baseURL + "calendar/getTasksAll";
			const params = new URLSearchParams({
				users: selectedUsers.join(","), // Menggabungkan array jadi string
				idspaceall: idspaceall,
				cekin: checkinspace,
			});

			fetch(`${url}?${params}`)
				.then((response) => {
					if (!response.ok) {
						throw new Error("Network response was not ok");
					}
					return response.json();
				})
				.then((data) => {
					calendarall.removeAllEvents(); // Hapus semua event sebelumnya
					calendarall.addEventSource(data.events); // Tambahkan event baru yang sesuai filter
				})
				.catch((error) =>
					console.error("Error fetching filtered events:", error)
				);
		}
	}

	// Load awal saat halaman pertama kali dimuat
	applyFiltersAll();

	$("#filtermyspaceall").on("change", function () {
		var idspace = $(this).val();

		if (idspace !== "") {
			$.ajax({
				url: baseURL + "calendar/getDataSpaceActive", // Ganti dengan URL yang sesuai
				type: "POST",
				data: { id_space: idspace },
				dataType: "json",
				success: function (response) {
					// Mengosongkan list sebelum menambahkan yang baru
					$("#list-container").empty();

					var selectall = document.getElementById("listall");

					var inpusspace = document.getElementById("idspace");
					var iduserincalendar =
						document.getElementById("iduserincalendar").value;
					selectall.style.display = "block"; //or
					inpusspace.value = idspace;

					// Cek jika response berisi data
					if (response.length > 0) {
						// Perulangan untuk menambahkan setiap item ke dalam list
						response.forEach(function (item) {
							if (iduserincalendar == item.id) {
								$("#list-container").append(
									'<li class="list-group-item">' +
										'<div class="form-check form-check-inline">' +
										'<input checked class="form-check-input" type="checkbox" name="usercalendarall[]" id="usercalendarall' +
										item.id +
										'" value="' +
										item.id +
										'">' +
										'<label class="form-check-label" for="usercalendar_' +
										item.id +
										'">' +
										item.username +
										"</label>" +
										"</div>" +
										"</li>"
								);
							} else {
								$("#list-container").append(
									'<li class="list-group-item">' +
										'<div class="form-check form-check-inline">' +
										'<input class="form-check-input" type="checkbox" name="usercalendarall[]" id="usercalendarall' +
										item.id +
										'" value="' +
										item.id +
										'">' +
										'<label class="form-check-label" for="usercalendar_' +
										item.id +
										'">' +
										item.username +
										"</label>" +
										"</div>" +
										"</li>"
								);
							}
						});
					} else {
						// Jika tidak ada data, tampilkan pesan
						$("#list-container").append(
							'<li class="list-group-item">No data found</li>'
						);
					}

					const checkboxesall = document.querySelectorAll(
						'input[name="usercalendarall[]"]'
					);
					const selectedUsers = Array.from(checkboxesall)
						.filter((checkbox) => checkbox.checked)
						.map((checkbox) => checkbox.value);

					fetchFilteredEventsAll(selectedUsers);

					function fetchFilteredEventsAll(selectedUsers) {
						const idsp = document.getElementById("idspace");
						if (idsp) {
							const idspaceall = document.getElementById("idspace").value;
						}

						const url = baseURL + "calendar/getTasksAll";
						const params = new URLSearchParams({
							users: selectedUsers.join(","), // Menggabungkan array jadi string
							idspaceall: idspaceall,
						});

						fetch(`${url}?${params}`)
							.then((response) => {
								if (!response.ok) {
									throw new Error("Network response was not ok");
								}
								return response.json();
							})
							.then((data) => {
								calendarall.removeAllEvents(); // Hapus semua event sebelumnya
								calendarall.addEventSource(data.events); // Tambahkan event baru yang sesuai filter
							})
							.catch((error) =>
								console.error("Error fetching filtered events:", error)
							);
					}
					checkAllView.addEventListener("change", function () {
						if (this.checked) {
							// Jika "All" dicentang, cek semua checkbox user dan disabled
							checkboxesall.forEach((checkbox) => {
								checkbox.checked = true;
								checkbox.disabled = true;
							});
						} else {
							// Jika "All" tidak dicentang, uncheck semua checkbox user dan enable kembali
							checkboxesall.forEach((checkbox) => {
								checkbox.checked = false;
								checkbox.disabled = false;
							});
						}
						// applyFiltersAll(); // Terapkan filter baru, bisa dihapus jika filter hanya diterapkan lewat tombol
					});
				},
			});
		} else {
			$("#list-container").empty(); // Kosongkan list jika tidak ada pilihan
		}
	});

	// Inisialisasi kalender
	var calendarElAll = document.getElementById("calendarall");
	if (calendarElAll) {
		var calendarall = new FullCalendar.Calendar(calendarElAll, {
			initialView: "dayGridMonth", // Tampilan awal
			height: 650,
			headerToolbar: {
				left: "prev,next today",
				center: "title",
				right: "dayGridMonth,timeGridWeek,timeGridDay", // Tombol awal
			},

			events: [], // Events akan diisi berdasarkan filter
			eventClick: function (info) {
				const eventDate = new Date(info.event.start);
				const formattedDate = eventDate.toLocaleDateString("id-ID", {
					day: "numeric",
					month: "long",
					year: "numeric",
				});
				// Memperbarui konten modal
				document.querySelector("#modalCalendar .heading").textContent =
					info.event.title;
				document.querySelector("#modalCalendar h5").textContent = formattedDate;
				document.querySelector("#description-container").innerHTML =
					info.event.extendedProps.description;

				const editJadwalButton = document.getElementById("editjadwal");
				editJadwalButton.setAttribute(
					"data-taskin",
					info.event.extendedProps.taskin !== undefined
						? info.event.extendedProps.taskin
						: "0"
				);

				var idtask = info.event.id;
				console.log(idtask);

				$.ajax({
					url: baseURL + "task/checkMyTask", // Ganti dengan URL server untuk mengambil data
					type: "POST",
					data: {
						idtask: idtask,
					},
					dataType: "json",
					success: function (response) {
						if (response.okr == "okr") {
							const url =
								baseURL +
								`project/showKey/${
									info.event.extendedProps.taskin !== undefined
										? info.event.extendedProps.taskin
										: "0"
								}}/${idPace}`;
						} else if (response.okr == "document") {
							const url =
								baseURL +
								`project/showKey/${
									info.event.extendedProps.taskin !== undefined
										? info.event.extendedProps.taskin
										: "0"
								}}/${idPace}`;
						} else {
							const url =
								baseURL +
								`project/showKey/${
									info.event.extendedProps.taskin !== undefined
										? info.event.extendedProps.taskin
										: "0"
								}}/${idPace}`;
						}
					},
					error: function (xhr, status, error) {},
				});

				// Menampilkan modal
				$("#modalCalendar").modal("show");

				// Tambahkan event listener untuk meng-handle klik
				editJadwalButton.addEventListener("click", function () {
					const idPace = this.getAttribute("data-idpace");
					const url =
						baseURL +
						`task/editTaskInCalendar/${
							info.event.extendedProps.taskin !== undefined
								? info.event.extendedProps.taskin
								: "0"
						}/${info.event.id}/${idPace}`;
					window.location.href = url;
				});
			},
		});
		// Fungsi untuk menentukan tampilan berdasarkan lebar layar
		function whichView(width) {
			if (width < 601) {
				return "timeGridWeek"; // Beralih ke minggu saat layar kecil
			} else {
				return "dayGridMonth"; // Tampilkan bulan saat layar besar
			}
		}

		// Fungsi untuk mereset dan menginisialisasi kalender
		function initCalendar() {
			var windowHeight = $(window).height();
			calendarall.setOption("height", windowHeight * 1.2);
			calendarall.changeView(whichView($(window).width())); // Set tampilan berdasarkan lebar jendela
			calendarall.render();
		}

		// Menangani perubahan ukuran jendela
		$(window).resize(function () {
			initCalendar();
		});

		// Render kalender
		initCalendar();
	}
});
