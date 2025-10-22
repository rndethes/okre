const quillOptions = [
	[{ size: ["small", false, "large", "huge"] }], // custom dropdown
	["bold", "italic", "underline", "strike"], // toggled buttons
	["link", "image"],
	[{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
];

var quillinspace = document.getElementById("spacedesc");

if (quillinspace) {
	quillspace = new Quill("#spacedesc", {
		theme: "snow",
	});
}

const formquill = document.querySelector(".workspaceclass-form");
if (formquill) {
	formquill.onsubmit = function () {
		var quillSpaceSelect = quillspace.root.innerHTML;
		document.getElementById("descfromquill").value = quillSpaceSelect;
	};
}

// Pastikan DOM sudah dimuat
document.addEventListener("DOMContentLoaded", function () {
	// Temukan form berdasarkan class atau ID
	const form = document.querySelector("#editSpaceModal .editworkspace-form");

	// Pastikan form ada sebelum menambahkan event listener
	if (form) {
		form.addEventListener("submit", function (e) {
			e.preventDefault(); // Mencegah submit default

			// Ambil konten dari quill editor
			var quillSpaceModal = quillspace.root.innerHTML;
			console.log("Konten dari Quill: ", quillSpaceModal); // Debugging

			// Set value dari textarea yang akan dikirim
			var descFromModal = document.getElementById("descfrommodal");

			if (descFromModal) {
				descFromModal.value = quillSpaceModal;
				console.log("Textarea value: ", descFromModal.value); // Debugging

				// Submit form secara manual setelah textarea terisi
				setTimeout(() => {
					form.submit(); // Submit setelah dipastikan textarea terisi
				}, 100); // Tambahkan sedikit delay untuk memastikan textarea di-update
			} else {
				console.error("Textarea dengan ID 'descfrommodal' tidak ditemukan.");
			}
		});
	}
});
