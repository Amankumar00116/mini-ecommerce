import { initializeApp } from "firebase/app";
import { getMessaging, isSupported } from "firebase/messaging";

const firebaseConfig = {
    apiKey: "AIzaSyD5B1VP_Gmced8EicnhVW_eETLEh8olAq0",
    authDomain: "mini-ecommerce-cdf9d.firebaseapp.com",
    projectId: "mini-ecommerce-cdf9d",
    storageBucket: "mini-ecommerce-cdf9d.firebasestorage.app",
    messagingSenderId: "942656687028",
    appId: "1:942656687028:web:f81194d419c022525180e1"
};

const app = initializeApp(firebaseConfig);

export async function getFirebaseMessaging() {
    const supported = await isSupported();

    if (!supported) {
        return null;
    }

    return getMessaging(app);
}
