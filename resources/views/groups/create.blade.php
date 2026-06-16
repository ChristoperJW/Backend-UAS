<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Grup - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <a href="{{ route('messages.getConversations') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Buat Grup Baru</h1>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ route('groups.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Grup</label>
                    <input type="text" id="name" name="name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors" placeholder="Masukkan nama grup..." required autocomplete="off">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Anggota</label>
                    <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
                        @foreach($users as $user)
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 cursor-pointer transition-colors">
                            <input type="checkbox" name="members[]" value="{{ $user->id }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm">
                        Buat Grup
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>