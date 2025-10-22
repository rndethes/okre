$(document).ready(function () {
	var chartbars = document.getElementById("chart-bars");
	if (chartbars) {
		$.ajax({
			url: baseURL + "dashboard/taskStatus", // Sesuaikan dengan base_url dan controller
			method: "GET",
			success: function (response) {
				// Parse JSON response
				var data = JSON.parse(response);

				var statusMapping = {
					1: "On Going",
					2: "Complete",
					3: "Pending",
					4: "Reject",
				};

				// Pisahkan data untuk digunakan dalam Chart.js
				var labels = data.map(function (item) {
					return statusMapping[item.status_task]; // Pemetaan angka ke label
				});
				var counts = data.map(function (item) {
					return item.count; // Jumlah tugas untuk setiap status
				});

				// Inisialisasi chart dengan data
				initDoughnutChart(labels, counts);
			},
		});
	}
});

$(document).ready(function () {
	var chartdoughnut = document.getElementById("chart-doughnut");
	if (chartdoughnut) {
		$.ajax({
			url: baseURL + "dashboard/myProject",
			method: "GET",
			success: function (response) {
				// Parse JSON response
				var data = JSON.parse(response);

				// Pisahkan data untuk digunakan dalam Chart.js
				var labels = data.map(function (item) {
					return item.nama_project;
				});
				var percentages = data.map(function (item) {
					return item.value_project;
				});

				// Inisialisasi chart dengan data
				initChart(labels, percentages);
			},
		});
	}
});
