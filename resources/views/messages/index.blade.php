<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesan - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Kotak Masuk</h1>
            <a href="/" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition-colors shadow-sm">
                Ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mulai Percakapan Baru</h2>
            <form action="{{ route('messages.createConversation') }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <div class="flex gap-4">
                    <input type="text" name="name" list="users-list" class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700" placeholder="Ketik nama pengguna (contoh: Angga atau Michael)..." required autocomplete="off">
                    <datalist id="users-list">
                        @foreach($allUsers as $user)
                            <option value="{{ $user->name }}">
                        @endforeach
                    </datalist>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors shadow-sm hover:shadow-md">
                        Mulai Chat
                    </button>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm font-medium">Pengguna tidak ditemukan. Pastikan ejaan nama sudah benar.</span>
                @enderror
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Pesan Aktif</h2>
            <div class="flex flex-col gap-3">
                @forelse($activeChats as $chatUser)
                    <div class="flex items-center justify-between p-4 bg-gray-50 hover:bg-blue-50/50 rounded-xl border border-gray-200 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-700 transition-colors">{{ $chatUser->name }}</h3>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('messages.getMessages', $chatUser->id) }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-semibold transition-colors shadow-sm">
                                Buka Chat
                            </a>
                            <form action="{{ route('messages.removeFullConversation', $chatUser->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2 bg-red-50 border border-red-100 text-red-600 rounded-lg hover:bg-red-100 hover:text-red-700 font-semibold transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-gray-300 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-lg font-medium">Belum ada percakapan aktif.</p>
                        <p class="text-gray-400 text-sm mt-1">Mulai obrolan baru melalui menu di atas!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>