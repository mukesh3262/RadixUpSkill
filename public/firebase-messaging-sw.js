// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

// FIREBASE_MESSAGE is already defined in head.blade.php
const firebaseConfig = {
    apiKey: "AIzaSyAvXqsktqSFSXFIctpiK71DEGjaGhUAkNw",
    authDomain: "radixweb.firebaseapp.com",
    projectId: "radixweb",
    storageBucket: "radixweb.appspot.com",
    messagingSenderId: "1093381611568",
    appId: "1:1093381611568:web:d68ea992ef80eadef1cdf5",
    measurementId: "G-32C8YL4082"
  };
firebase.initializeApp(firebaseConfig);
const FIREBASE_MESSAGE = firebase.messaging();
FIREBASE_MESSAGE.setBackgroundMessageHandler(function (payload) {
    console.log("[firebase-messaging-sw.js] Message received.", payload);
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    return self.registration.showNotification(title, options);
});
