// Fungsi untuk memunculkan spinner
function showSpinner() {
	document.getElementById("loadingSpinner").style.display = "block";
}

// Fungsi untuk menyembunyikan spinner
function hideSpinner() {
	document.getElementById("loadingSpinner").style.display = "none";
}
document.getElementById("searchInput").addEventListener("keyup", function () {
	var input, filter, listGroup, listItems, titleKey, i, txtValue;
	input = document.getElementById("searchInput");
	filter = input.value.toLowerCase();
	listGroup = document.querySelector(".list-okr");
	listItems = listGroup.getElementsByClassName("keyresult-view");
	listOkr = listGroup.getElementsByClassName("list-okr");

	// Simpan nilai filter di localStorage
	localStorage.setItem("filterListOkr", filter);

	for (i = 0; i < listItems.length; i++) {
		console.log(listItems[i]); // Debug: Periksa isi elemen list item
		titleKey = listItems[i].querySelector(".title-key"); // Debug: Periksa elemen title-key
		console.log(titleKey); // Debug: Periksa apakah title-key ada

		if (titleKey) {
			txtValue = titleKey.textContent || titleKey.innerText;
			if (txtValue.toLowerCase().indexOf(filter) > -1) {
				listItems[i].style.display = "";
				listOkr[i].style.display = "";
			} else {
				listItems[i].style.display = "none";
				listOkr[i].style.display = "none";
			}
		}
	}
});

// Fungsi untuk memuat filter saat halaman di-reload
window.addEventListener("load", function () {
	showSpinner();
	var storedFilter = localStorage.getItem("filterListOkr");
	if (storedFilter) {
		document.getElementById("searchInput").value = storedFilter;

		// Jalankan ulang proses filtering berdasarkan nilai yang disimpan
		var input, filter, listGroup, listItems, titleKey, i, txtValue;
		input = document.getElementById("searchInput");
		filter = input.value.toLowerCase();
		listGroup = document.querySelector(".list-okr");
		listItems = listGroup.getElementsByClassName("keyresult-view");
		listOkr = listGroup.getElementsByClassName("list-okr");

		for (i = 0; i < listItems.length; i++) {
			titleKey = listItems[i].querySelector(".title-key");
			if (titleKey) {
				txtValue = titleKey.textContent || titleKey.innerText;
				if (txtValue.toLowerCase().indexOf(filter) > -1) {
					listItems[i].style.display = "";
					listOkr[i].style.display = "";
				} else {
					listItems[i].style.display = "none";
					listOkr[i].style.display = "none";
				}
			}
		}
	}
	hideSpinner();
});
