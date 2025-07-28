<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Realtime Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-30px);
        background: #1f2937; 
        color: #fff;
        padding: 14px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 9999;
        font-size: 0.95rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .toast .icon {
        background-color: #3b82f6; 
        border-radius: 50%;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toast .icon svg {
        width: 18px;
        height: 18px;
        color: white;
    }

    </style>
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
                div.style.borderBottomRightRadius = "4px";
            } else {
                div.classList.add("bg-white", "text-gray-800", "mr-auto", "ml-2", "border");
                div.style.borderBottomLeftRadius = "4px";
            }

            div.style.wordWrap = "break-word";
            div.textContent = message;
            messagesList.appendChild(div);
            messagesList.scrollTop = messagesList.scrollHeight;
        }

        function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast';

    toast.innerHTML = `
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>
        </div>
        <div>${message}</div>
    `;

    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

        window.Echo?.channel('messages')
            .listen('MessageSent', (e) => {
                const isOwn = currentUserId && e.user_id == currentUserId;
                appendMessage(e.message, isOwn);

                if (!isOwn) {
                    showToast(`${e.user_name} sent a message: ${e.message}`);
                }
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
