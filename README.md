# 💬 Real-Time Chat Application

A modern real-time chat application built with Laravel, Pusher, and Tailwind CSS. Features instant messaging with user authentication and message differentiation.

## ✨ Features

- Real-time messaging with Pusher WebSocket integration
- User authentication powered by Laravel Breeze
- Message differentiation (sender: blue/right, receiver: white/left)
- Responsive design with Tailwind CSS
- Keyboard shortcuts (Enter to send)

## 🛠️ Tech Stack

- **Backend**: Laravel + Laravel Breeze
- **Real-time**: Pusher + Laravel Echo
- **Frontend**: Blade Templates + Tailwind CSS
- **Queue**: Laravel Queue System

## 📋 Prerequisites

- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Pusher Account

## 🚀 Installation

### 1. Clone & Install
```bash
git clone [<repository-url>](https://github.com/mohamedabdallah11/Real-Time-Chat.git)
cd Real-Time-Chat
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database
```bash
# Configure your database in .env then run:
php artisan migrate
```

### 4. Pusher Configuration
Add to `.env`:
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

### 5. Build Assets
```bash
npm run build
```

## 🏃‍♂️ Running the Application

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Queue worker (Required for real-time messaging)
php artisan queue:work

# Terminal 3: Development assets (optional)
npm run dev
```

Open `http://localhost:8000` and start chatting!

## 📁 Key Files

```
app/Events/MessageSent.php          # Pusher broadcast event
app/Http/Controllers/MessageController.php    # Message handling
resources/views/chat.blade.php      # Chat interface
```

## 🎨 UI Features

- **Your messages**: Blue bubbles on the right
- **Others messages**: White bubbles on the left
- **Responsive**: Works on all devices
- **Real-time**: Instant message delivery


🔔 Notifications
-Real-time toast notifications using Laravel Events, Laravel Echo, and Pusher.

-Notifications appear at the top center of the screen with smooth animation.

-Triggered when a new message is received from another user.

-Styled using Tailwind CSS with custom icons.

## 🐛 Troubleshooting

**Messages not appearing?**
1. Check Pusher credentials in `.env`
2. Ensure queue worker is running: `php artisan queue:work`
3. Check browser console for errors

**Queue issues?**
```bash
php artisan queue:restart
php artisan queue:work
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/new-feature`)
3. Commit changes (`git commit -m 'Add new feature'`)
4. Push to branch (`git push origin feature/new-feature`)
5. Open Pull Request


---

**Happy Chatting! 💬**
