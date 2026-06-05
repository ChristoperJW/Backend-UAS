<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Pesan Pribadi</h2>
            <a href="/" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition-colors">Kembali ke Beranda</a>
        </div>
        
        <hr class="border-gray-200 mb-6">

        <div class="mb-8 p-5 bg-blue-50 border border-blue-100 rounded-xl">
            <h3 class="text-lg font-semibold text-blue-800 mb-3">Mulai Obrolan Baru</h3>
            <div class="flex gap-3">
                <select id="new_chat_user" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="" disabled selected>Pilih kontak teman...</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                    <option value="{{ session('current_user_id') }}">Diri Sendiri (Catatan Pribadi)</option>
                </select>
                <button onclick="startNewChat()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">Chat</button>
            </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Obrolan</h3>
        <div class="space-y-3">
            @forelse($activeChats as $user)
                <a href="/messages/{{ $user->id }}" class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-blue-700">
                        @if($user->id == session('current_user_id'))
                            Catatan Pribadi
                        @else
                            {{ $user->name }}
                        @endif
                    </span>
                    <span class="text-sm px-4 py-1 bg-gray-100 text-gray-600 rounded-full group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                        Lanjutkan Obrolan
                    </span>
                </a>
            @empty
                <div class="text-center py-8 text-gray-500">
                    Belum ada riwayat pesan. Silakan mulai obrolan baru di atas!
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function startNewChat() {
            const select = document.getElementById('new_chat_user');
            if(select.value) {
                window.location.href = '/messages/' + select.value;
            }
        }
    </script>
</body>
</html>