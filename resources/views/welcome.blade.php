<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Real-Time Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-black text-white min-h-screen flex flex-col items-center justify-center">
    <div class="text-center px-6">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">
            Welcome to <span class="text-sky-400">Real-Time Chat</span>
        </h1>
        <p class="text-gray-300 text-lg sm:text-xl mb-8">
            Connect instantly. Chat securely. Built with Laravel + Pusher.
        </p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-sky-500 hover:bg-sky-600 rounded-full text-white font-semibold transition">Login</a>
            <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-purple-500 hover:bg-purple-600 rounded-full text-white font-semibold transition">Register</a>
            <a href="{{ route('realtime') }}" class="inline-block px-6 py-3 bg-emerald-500 hover:bg-emerald-600 rounded-full text-white font-semibold transition">Enter Chat</a>
        </div>
    </div>

    <footer class="absolute bottom-4 text-sm text-gray-500">
        &copy; {{ date('Y') }} Real-Time Chat System. All rights reserved.
    </footer>
</body>
</html>
