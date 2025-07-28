<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Realtime Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <script>
        const currentUserId = @json(auth()->id());
    </script>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-4 flex flex-col">
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold text-gray-800">💬 Realtime Chat</h1>
            <p class="text-sm text-gray-500">Messages appear instantly!</p>
        </div>

        <div id="messagesList" class="flex-1 overflow-y-auto border rounded-lg p-3 bg-gray-50 space-y-2 h-64">
        </div>

        <div class="mt-4 flex">
            <input type="text" id="messageInput" placeholder="Type your message..."
                class="flex-1 rounded-l-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="sendBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg transition">
                Send
            </button>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messagesList = document.getElementById('messagesList');

        function appendMessage(message, isOwn = false) {
            const div = document.createElement('div');
            div.classList.add("p-3", "rounded-lg", "shadow-sm", "max-w-[80%]", "mb-2");
            
            if (isOwn) {
                div.classList.add("bg-blue-500", "text-white", "ml-auto", "mr-2");
                div.style.borderBottomRightRadius = "4px";              } else {
                div.classList.add("bg-white", "text-gray-800", "mr-auto", "ml-2", "border");
                div.style.borderBottomLeftRadius = "4px";}
            
            div.style.wordWrap = "break-word";
            div.textContent = message;
            messagesList.appendChild(div);
            messagesList.scrollTop = messagesList.scrollHeight;
        }

        window.Echo?.channel('messages')
            .listen('MessageSent', (e) => {
                const isOwn = currentUserId && e.user_id == currentUserId;
                appendMessage(e.message, isOwn);
            });

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            if (!message) return;

            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message sent:', data);
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });

            messageInput.value = '';
        }

        document.getElementById('sendBtn').addEventListener('click', sendMessage);

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    });
</script>

</body>
</html>