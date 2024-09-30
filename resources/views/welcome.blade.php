<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>

</head>

<body class="antialiased">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                @auth
                    <a href="{{ url('/home') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <h1>Firebase Notifications</h1>

        <button id="enable-notifications" class="btn btn-primary">Enable Notifications</button>

    </div>

    <script>
        // Cấu hình Firebase
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
        const firebaseApp = firebase.initializeApp(firebaseConfig);

        // Lấy instance của Firebase Messaging
        const messaging = firebase.messaging();
        // Đăng ký service worker để xử lý thông báo nền
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    console.log('Service Worker registration successful with scope: ', registration.scope);
                })
                .catch((err) => {
                    console.log('Service Worker registration failed: ', err);
                });
        }

        // Yêu cầu quyền nhận thông báo và lấy token
        document.getElementById('enable-notifications').addEventListener('click', function() {
            messaging.requestPermission()
                .then(() => {
                    console.log('Notification permission granted.');
                    return messaging.getToken({
                        vapidKey: 'BF_q3wzojqW3wgqbLVtHtVgeROLK0U0xtqC7lufqsr3W61pznK3HAl-emCRIOjhG06R1Gw1SSBA1Xj85sIX-0H8'
                    });
                })
                .then((currentToken) => {
                    if (currentToken) {
                        console.log('FCM Token:', currentToken);
                        // Gửi token lên server để lưu trữ hoặc sử dụng
                        storeToken(currentToken);
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                    }
                })
                .catch((err) => {
                    console.log('An error occurred while retrieving token. ', err);
                });
        });

        // Hàm gửi token lên server Laravel để lưu trữ
        function storeToken(token) {
            fetch('/save-fcm-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token: token
                    })
                }).then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error saving FCM token:', error));
        }

        // Nhận thông báo khi ứng dụng đang chạy
        messaging.onMessage((payload) => {
            console.log('Message received. ', payload);
            // Hiển thị thông báo theo cách bạn muốn (ví dụ: toast notification)
            alert(`Notification: ${payload.notification.title} - ${payload.notification.body}`);
        });
    </script>
</body>

</html>
