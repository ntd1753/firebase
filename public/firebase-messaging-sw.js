importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDUMQVq1IrkNJE5CbP2VRbVjYfG_sW5uiQ",
    authDomain: "fir-47d8a.firebaseapp.com",
    projectId: "fir-47d8a",
    storageBucket: "fir-47d8a.appspot.com",
    messagingSenderId: "393973542602",
    appId: "1:393973542602:web:0cf1bbcf7d6f4883e30e33",
    measurementId: "G-DX1D01CVGQ"
};

// Khởi tạo Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Lắng nghe và xử lý thông báo trong nền
messaging.onBackgroundMessage(function (payload) {
    console.log('Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
