importScripts("https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js");
importScripts(
	"https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"
);

firebase.initializeApp({
	apiKey: "AIzaSyCfCILTIQsQMCvt__0_UxLu513_ejYeItc",
	authDomain: "okre-ethes-tech.firebaseapp.com",
	projectId: "okre-ethes-tech",
	storageBucket: "okre-ethes-tech.appspot.com",
	messagingSenderId: "484531713150",
	appId: "1:484531713150:web:82fd12ebb81488555c142f",
	measurementId: "G-BBWKTGKRH3",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
	console.log(
		"[firebase-messaging-sw.js] Received background message ",
		payload
	);
	/* Customize notification here */
	const notificationTitle = "Background Message Title";
	const notificationOptions = {
		body: "Background Message body.",
		icon: "/itwonders-web-logo.png",
	};

	return self.registration.showNotification(
		notificationTitle,
		notificationOptions
	);
});
