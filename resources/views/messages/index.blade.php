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

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8 relative z-50">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cari Pengguna</h2>
            <div class="relative">
                <input type="text" id="searchInput" class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700" placeholder="Ketik nama pengguna (contoh: Angga)..." autocomplete="off">
                
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div id="loadingSpinner" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                    <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <div id="searchResults" class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 hidden max-h-64 overflow-y-auto w-full mx-6" style="width: calc(100% - 3rem);">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 relative z-10">
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
                        <p class="text-gray-500 text-lg font-medium">Belum ada percakapan aktif.</p>
                        <p class="text-gray-400 text-sm mt-1">Cari nama pengguna di atas untuk memulai obrolan!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const loadingSpinner = document.getElementById('loadingSpinner');
        let timeoutId = null;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(timeoutId);
            
            if (query.length === 0) {
                searchResults.innerHTML = '';
                searchResults.classList.add('hidden');
                loadingSpinner.classList.add('hidden');
                return;
            }

            loadingSpinner.classList.remove('hidden');
            searchResults.classList.add('hidden');

            timeoutId = setTimeout(() => {
                fetch(`/messages/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(users => {
                        loadingSpinner.classList.add('hidden');
                        searchResults.innerHTML = '';

                        if (users.length > 0) {
                            users.forEach(user => {
                                const initial = user.name.charAt(0).toUpperCase();
                                const resultHtml = `
                                    <a href="/messages/${user.id}" class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                            ${initial}
                                        </div>
                                        <span class="text-gray-800 font-semibold text-lg">${user.name}</span>
                                    </a>
                                `;
                                searchResults.insertAdjacentHTML('beforeend', resultHtml);
                            });
                        } else {
                            searchResults.innerHTML = '<div class="p-5 text-center text-gray-500">Pengguna tidak ditemukan</div>';
                        }
                        searchResults.classList.remove('hidden');
                    });
            }, 400);
        });

        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                searchResults.classList.add('hidden');
            }
        });
    </script>
</body>
</html>