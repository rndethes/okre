$(document).on("click", ".importurgentone", function (e) {
	e.preventDefault();
	var targetinitiativeone = $(this).data("targetinitiativeone");
	var idkrone = $(this).data("idkrone");
	var idprojectone = $(this).data("idprojectone");
	var idokrone = $(this).data("idokrone");
	var userone = $(this).data("userone");

	$.ajax({
		url: baseURL + "project/priorityInInsiativeOne",
		type: "POST",
		dataType: "json",
		data: {
			idini: targetinitiativeone,
			idkr: idkrone,
			idproject: idprojectone,
			idokr: idokrone,
			iduser: userone,
		},
		success: function (data) {
			Swal.fire({
				icon: "success",
				title: "Berhasil Simpan Priority",
				text: "Data Berhasil Disimpan!",
				type: "success",
			}).then((result) => {
				// Reload the Page
				location.reload();
			});
		},
	});
});
$(document).on("click", ".importurgenttwo", function (e) {
	e.preventDefault();
	var targetinitiativetwo = $(this).data("targetinitiativetwo");
	var idkrtwo = $(this).data("idkrtwo");
	var idprojectwo = $(this).data("idprojecttwo");
	var idokrtwo = $(this).data("idokrtwo");
	var usertwo = $(this).data("usertwo");

	$.ajax({
		url: baseURL + "project/priorityInInsiativeTwo",
		type: "POST",
		dataType: "json",
		data: {
			idini: targetinitiativetwo,
			idkr: idkrtwo,
			idproject: idprojectwo,
			idokr: idokrtwo,
			iduser: usertwo,
		},
		success: function (data) {
			Swal.fire({
				icon: "success",
				title: "Berhasil Simpan Priority",
				text: "Data Berhasil Disimpan!",
				type: "success",
			}).then((result) => {
				// Reload the Page
				location.reload();
			});
		},
	});
});
$(document).on("click", ".importurgentthree", function (e) {
	e.preventDefault();
	var targetinitiativethree = $(this).data("targetinitiativethree");
	var idkrthree = $(this).data("idkrthree");
	var idprojecthree = $(this).data("idprojectthree");
	var idokrthree = $(this).data("idokrthree");
	var userthree = $(this).data("userthree");

	$.ajax({
		url: baseURL + "project/priorityInInsiativeThree",
		type: "POST",
		dataType: "json",
		data: {
			idini: targetinitiativethree,
			idkr: idkrthree,
			idproject: idprojecthree,
			idokr: idokrthree,
			iduser: userthree,
		},
		success: function (data) {
			Swal.fire({
				icon: "success",
				title: "Berhasil Simpan Priority",
				text: "Data Berhasil Disimpan!",
				type: "success",
			}).then((result) => {
				// Reload the Page
				location.reload();
			});
		},
	});
});
$(document).on("click", ".importurgentfour", function (e) {
	e.preventDefault();
	var targetinitiativefour = $(this).data("targetinitiativefour");
	var idkrfour = $(this).data("idkrfour");
	var idprojectfour = $(this).data("idprojectfour");
	var idokrfour = $(this).data("idokrfour");
	var userfour = $(this).data("userfour");

	$.ajax({
		url: baseURL + "project/priorityInInsiativeFour",
		type: "POST",
		dataType: "json",
		data: {
			idini: targetinitiativefour,
			idkr: idkrfour,
			idproject: idprojectfour,
			idokr: idokrfour,
			iduser: userfour,
		},
		success: function (data) {
			Swal.fire({
				icon: "success",
				title: "Berhasil Simpan Priority",
				text: "Data Berhasil Disimpan!",
				type: "success",
			}).then((result) => {
				// Reload the Page
				location.reload();
			});
		},
	});
});

var elementslistpriority = document.getElementsByClassName("listpriority");

if (elementslistpriority) {
	var idlistsession = idsesssion;

	$.ajax({
		url: baseURL + "project/showPriorityData",
		type: "POST",
		dataType: "html",
		beforeSend: function () {
			$(".loadinglistpriority").css("visibility", "visible");
		},
		data: {
			id: idlistsession,
			idprojectlist: idprojectlist,
		},

		success: function (data) {
			$(".listpriority").html(data);
		},
		complete: function () {
			$(".loadinglistpriority").css("visibility", "hidden");
		},
	});
}

$(document).on("click", ".importurgentonelist", function (e) {
	e.preventDefault();
	var targetlist = $(this).data("targetlist");

	$.ajax({
		url: baseURL + "project/priorityListOne",
		type: "POST",
		dataType: "json",
		data: {
			targetlist: targetlist,
		},
		success: function (data) {
			var idlistsession = idsesssion;

			$.ajax({
				url: baseURL + "project/showPriorityData",
				type: "POST",
				dataType: "html",
				beforeSend: function () {
					$(".loadinglistpriority").css("visibility", "visible");
				},
				data: {
					id: idlistsession,
					idprojectlist: idprojectlist,
				},

				success: function (data) {
					$(".listpriority").html(data);
				},
				complete: function () {
					$(".loadinglistpriority").css("visibility", "hidden");
				},
			});
		},
	});
});

$(document).on("click", ".importurgentthreelist", function (e) {
	e.preventDefault();
	var targetlist = $(this).data("targetlist");

	$.ajax({
		url: baseURL + "project/priorityListThree",
		type: "POST",
		dataType: "json",
		data: {
			targetlist: targetlist,
		},
		success: function (data) {
			var idlistsession = idsesssion;

			$.ajax({
				url: baseURL + "project/showPriorityData",
				type: "POST",
				dataType: "html",
				beforeSend: function () {
					$(".loadinglistpriority").css("visibility", "visible");
				},
				data: {
					id: idlistsession,
					idprojectlist: idprojectlist,
				},

				success: function (data) {
					$(".listpriority").html(data);
				},
				complete: function () {
					$(".loadinglistpriority").css("visibility", "hidden");
				},
			});
		},
	});
});

$(document).on("click", ".importurgentfourlist", function (e) {
	e.preventDefault();
	var targetlist = $(this).data("targetlist");

	$.ajax({
		url: baseURL + "project/priorityListFour",
		type: "POST",
		dataType: "json",
		data: {
			targetlist: targetlist,
		},
		success: function (data) {
			var idlistsession = idsesssion;

			$.ajax({
				url: baseURL + "project/showPriorityData",
				type: "POST",
				dataType: "html",
				beforeSend: function () {
					$(".loadinglistpriority").css("visibility", "visible");
				},
				data: {
					id: idlistsession,
					idprojectlist: idprojectlist,
				},

				success: function (data) {
					$(".listpriority").html(data);
				},
				complete: function () {
					$(".loadinglistpriority").css("visibility", "hidden");
				},
			});
		},
	});
});

$(document).on("click", ".importurgenttwolist", function (e) {
	e.preventDefault();
	var targetlist = $(this).data("targetlist");

	$.ajax({
		url: baseURL + "project/priorityListTwo",
		type: "POST",
		dataType: "json",
		data: {
			targetlist: targetlist,
		},
		success: function (data) {
			var idlistsession = idsesssion;

			$.ajax({
				url: baseURL + "project/showPriorityData",
				type: "POST",
				dataType: "html",
				beforeSend: function () {
					$(".loadinglistpriority").css("visibility", "visible");
				},
				data: {
					id: idlistsession,
					idprojectlist: idprojectlist,
				},

				success: function (data) {
					$(".listpriority").html(data);
				},
				complete: function () {
					$(".loadinglistpriority").css("visibility", "hidden");
				},
			});
		},
	});
});
$(document).ready(function () {
	notifselesai();
});

function notifselesai() {
	setTimeout(function () {
		showAlertNotification();
	}, 15000);
}

function showAlertNotification() {
	var sessionid = idsesssion;
	$.ajax({
		url: baseURL + "project/searchPriorityData",
		type: "POST",
		dataType: "json",
		data: {
			id: sessionid,
		},
		success: function (data) {
			var todos = JSON.stringify(data);
			obj = JSON.parse(todos);

			var arraydate = [];

			for (var i = 0; i < obj.length; i++) {
				var arr = obj[i];
				var duedate = arr.due_datekey;
				var description = arr.description;

				var now = new Date();

				var targetDate = new Date(duedate);

				targetDate.setDate(targetDate.getDate() + 2);

				var difference = targetDate - now;

				const daysDifference = Math.floor(difference / (1000 * 60 * 60 * 24));

				console.log(daysDifference);

				// Mengubah format tanggal menjadi "28 April 2023"
				const options = { day: "numeric", month: "long", year: "numeric" };
				const formattedDate = targetDate.toLocaleDateString("en-GB", options);

				var stringdesc =
					"Deadline Terdekat Anda " + description + " Pada " + formattedDate;

				if (daysDifference < 2) {
					arraydate.push(stringdesc);
				}
			}

			console.log(arraydate);

			if (arraydate != null) {
				var descinfo = arraydate.join(",\n");
				Swal.fire({
					icon: "info",
					title: "Informasi Anda!",
					text: descinfo,
				});
			}
		},
	});
}
