importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyD5B1VP_Gmced8EicnhVW_eETLEh8olAq0",
    authDomain: "mini-ecommerce-cdf9d.firebaseapp.com",
    projectId: "mini-ecommerce-cdf9d",
    storageBucket: "mini-ecommerce-cdf9d.firebasestorage.app",
    messagingSenderId: "942656687028",
    appId: "1:942656687028:web:f81194d419c022525180e1"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/favicon.ico'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
