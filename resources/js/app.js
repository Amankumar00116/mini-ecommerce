import Alpine from 'alpinejs';
import { getFirebaseMessaging } from './firebase';
import { getToken } from 'firebase/messaging';

window.Alpine = Alpine;

Alpine.start();

// Success Toast Function
window.showToast = function (message) {
    const toast = document.getElementById('successToast');
    const toastMessage = document.getElementById('toastMessage');

    if (!toast || !toastMessage) return;

    toastMessage.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
};

// Firebase Messaging
window.enableNotifications = async function () {
    try {
        const messaging = await getFirebaseMessaging();

        if (!messaging) {
            alert('Firebase Messaging is not supported in this browser.');
            return;
        }

        const permission = await Notification.requestPermission();

        if (permission !== 'granted') {
            alert('Notification permission was not granted.');
            return;
        }

        const token = await getToken(messaging, {
            vapidKey: 'BNGAyL02GMsLzj4_38gGVv5rEVchxXFydOao7ycMGAJfRAqclSyiLxQIBuU472x-O28gh0JlOiM4dXNnyEKjIE8'
        });

        console.log('Firebase Token:', token);

        const response = await fetch('/save-fcm-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                token: token
            })
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Token could not be saved.');
        }

        console.log('Token Save Result:', result);


        const prompt = document.getElementById('notificationPrompt');

        if (prompt) {
            prompt.style.display = 'none';
        }

        window.showToast('Notifications Enabled Successfully!');

    } catch (error) {
        console.error('Notification Error:', error);
        alert('Something went wrong. Check the browser console.');
    }
};
