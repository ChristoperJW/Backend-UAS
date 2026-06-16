<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/Postify.png') }}" alt="Logo Postify" class="h-8 md:h-10 w-auto object-contain drop-shadow-sm hover:scale-105 transition-transform duration-300">
    </div>
    <div class="flex items-center gap-4">
        <a href="/notifications" class="transition-transform duration-300 hover:scale-105">
            @if (\App\Models\Notification::where('user_id', session('current_user_id'))->whereNull('read_at')->exists())
                <img src="{{ asset('images/notif after.png') }}" alt="New Notifications" class="h-8 w-auto object-contain">
            @else
                <img src="{{ asset('images/notif.png') }}" alt="Notifications" class="h-8 w-auto object-contain">
            @endif
        </a>
        <a href="/account" class="text-gray-600 hover:text-blue-600 font-semibold transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">Pengaturan Akun</a>
        <a href="/logout" class="transition-transform duration-300 hover:scale-105 hover:opacity-80">
            <img src="{{ asset('images/logout.png') }}" alt="Logout Button" class="h-8 w-auto object-contain">
        </a>
    </div>
</nav>

    <main class="max-w-6xl mx-auto px-6 py-16">
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Selamat Datang di Postify</h1>
            <p class="text-lg text-gray-500 font-medium">Apa yang ingin kamu bagikan ke dunia hari ini?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('feeds.index') }}" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 transition-all duration-300 group flex flex-col items-center text-center">
                <div class="h-24 w-24 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <img src="{{ asset('images/feeds.png') }}" alt="Feeds" class="h-full w-full object-contain drop-shadow-sm">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Feeds</h3>
                <p class="text-sm text-gray-500 font-medium">Jelajahi linimasa dan postingan terbaru</p>
            </a>

            <a href="{{ route('posts.index') }}" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 hover:border-purple-200 transition-all duration-300 group flex flex-col items-center text-center">
                <div class="h-24 w-24 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <img src="{{ asset('images/post.png') }}" alt="Buat Post" class="h-full w-full object-contain drop-shadow-sm">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">Posts</h3>
                <p class="text-sm text-gray-500 font-medium">Bagikan momen dan ceritamu</p>
            </a>

            <a href="{{ route('messages.getConversations') }}" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 hover:border-indigo-200 transition-all duration-300 group flex flex-col items-center text-center">
                <div class="h-24 w-24 mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                    <img src="{{ asset('images/messages.png') }}" alt="Messages" class="h-full w-full object-contain drop-shadow-sm">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">Messages</h3>
                <p class="text-sm text-gray-500 font-medium">Cek kotak masuk dan obrolan</p>
            </a>

            <a href="/friends" class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 hover:border-green-200 transition-all duration-300 group flex flex-col items-center text-center">
                <div class="h-24 w-24 mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                    <img src="{{ asset('images/friends.png') }}" alt="Friends" class="h-full w-full object-contain drop-shadow-sm">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">Friends</h3>
                <p class="text-sm text-gray-500 font-medium">Temukan dan ikuti teman baru</p>
            </a>
        </div>
    </main>
</body>
</html>