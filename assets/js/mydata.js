$(document).ready(function () {
	$("#saveDataColomn").on("click", function () {
		console.log("cekk");
		// Ambil data dari form input
		var table_id = $("#table_id").val();
		var table_name = $("#table_name_input").val();
		var nama_kolom = $("#namakolom").val();
		var tipe_data = $("#typedata").val();
		var kosong = $("#kosong").val();
		var idpj = $("#idpj").val();
		var default_value = $("#defaultval").val();

		// Validasi input
		if (!table_id || !nama_kolom || !tipe_data) {
			alert("Semua kolom harus diisi");
			return;
		}

		// Kirim data ke server dengan AJAX
		$.ajax({
			url: baseURL + "data/inputColumn/", // Ganti dengan URL untuk simpan data
			type: "POST",
			dataType: "json",
			data: {
				table_id: table_id,
				nama_kolom: nama_kolom,
				tipe_data: tipe_data,
				kosong: kosong,
				default_value: default_value,
				idpj: idpj,
			},
			success: function (resdata) {
				// Menambahkan baris baru ke tabel secara dinamis
				console.log(resdata.namakolom);
				if (resdata.tipedata == "varchar") {
					var datatype = "Karakter";
				} else {
					var datatype = "Number";
				}

				var newRow = `<tr id="row-${resdata.id}">
                    <td>${table_name}</td>
                    <td><span>${resdata.namakolom}</span></td>
                    
                    <td><span>${datatype}</span></td>
                    <td><span>${
											resdata.kosong == 1 ? "Kosong" : "Tidak Kosong"
										}</span></td>
                    <td><span>${resdata.defaultvalue}</span></td>
                    <td>
                        <button class="btn btn-sm btn-icon btn-warning rounded-pill" type="button" onclick="editData(${
													resdata.id
												})">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Edit</span>
                        </button>
                        <button class="btn btn-sm btn-icon btn-danger rounded-pill" type="button" onclick="deleteData(${
													resdata.id
												})">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            <span class="btn-inner--text">Hapus</span>
                        </button>
                    </td>
                </tr>`;
				$("#input-row").before(newRow); // Tambahkan baris baru di atas
			},
		});
	});
});

function deleteData(id) {
	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.isConfirmed) {
			// Jika user mengkonfirmasi, lakukan proses penghapusan
			$.ajax({
				url: baseURL + "data/deleteData", // Ubah URL sesuai endpoint penghapusan data
				type: "POST",
				data: { id: id },
				success: function (response) {
					// Jika berhasil, tampilkan notifikasi penghapusan
					Swal.fire({
						title: "Deleted!",
						text: "Your data has been deleted.",
						icon: "success",
					});

					// Hapus baris dari tabel HTML
					$(`#row-${id}`).remove();
				},
				error: function (xhr, status, error) {
					// Jika terjadi kesalahan, tampilkan notifikasi error
					Swal.fire({
						title: "Error!",
						text: "There was a problem deleting your data.",
						icon: "error",
					});
				},
			});
		}
	});
}

function editData(id) {
	// Ambil data dari server berdasarkan ID
	$.ajax({
		url: baseURL + "data/showEditData/", // Ubah URL sesuai endpoint untuk mengambil data
		type: "GET",
		dataType: "json",
		data: { id: id },
		success: function (response) {
			console.log(response.id);
			// Isi form di modal dengan data yang didapat dari server
			$("#editId").val(response.id);
			$("#editNamaKolom").val(response.column_name);
			$("#editTipeData").val(response.data_type);
			$("#editKosong").val(response.is_nullable);
			$("#editDefaultValue").val(response.default_value);

			// Tampilkan modal
			$("#editModal").modal("show");
		},
		error: function (xhr, status, error) {
			console.log("Error: " + error);
		},
	});
}

function saveData(event) {
	if (event.key === "Enter" || event.key === "Tab") {
		event.preventDefault(); // Mencegah form submit secara default
		// Ambil semua data dari baris input
		var row = $(event.target).closest("tr");
		var data = {};
		row.find("input").each(function () {
			data[$(this).attr("name")] = $(this).val();
		});

		// Tambahkan table_id (sesuaikan ini dengan table_id yang sesuai)
		data["table_id"] = 2; // Misalnya, table_id adalah 1

		// Kirim data ke server menggunakan AJAX
		$.ajax({
			url: baseURL + "data/save_data", // Ganti dengan URL method controller
			type: "POST",
			data: data,
			success: function (response) {
				var result = JSON.parse(response);
				if (result.status === "success") {
					Swal.fire({
						title: "Success!",
						text: "Data berhasil disimpan.",
						icon: "success",
					});
				} else {
					Swal.fire({
						title: "Error!",
						text: "Gagal menyimpan data.",
						icon: "error",
					});
				}
			},
			error: function () {
				Swal.fire({
					title: "Error!",
					text: "Gagal menyimpan data.",
					icon: "error",
				});
			},
		});
	}
}
$(document).ready(function () {
	$("#tambahBaris").click(function () {
		var newRow = `
            <tr>
                <?php foreach($datacolumn as $datacol) { ?>
                <td>
                    <div class="form-group mt-2">
                        <input class="form-control" type="text" placeholder="Masukan <?= $datacol['column_name'] ?>" name="<?= $datacol['column_name'] ?>" onkeypress="saveData(event)">
                    </div>
                </td>
                <?php } ?>
                <td>
                    <button class="btn btn-sm btn-icon btn-danger rounded-pill" type="button" onclick="deleteRow(this)">
                        <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                        <span class="btn-inner--text">Hapus</span>
                    </button>
                </td>
            </tr>
        `;
		$("#inputBody").append(newRow);
	});
});
