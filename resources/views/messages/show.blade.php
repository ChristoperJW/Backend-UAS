<!DOCTYPE html>
<html>
<head>
    <title>Messages - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6">
    <div class="mb-4">
        <a href="/messages" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition-colors">
            &larr; Kembali ke Daftar Obrolan
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Obrolan dengan 
        @if($receiver->id == session('current_user_id'))
            Diri Sendiri (Catatan Pribadi)
        @else
            {{ $receiver->name }}
        @endif
        </h3>

        <div class="max-h-[500px] overflow-y-auto p-4 bg-gray-50 rounded-lg mb-4 flex flex-col border border-gray-100">
            @foreach($messages as $message)
                <div class="max-w-[70%] p-3 mb-3 rounded-2xl text-sm break-words flex flex-col shadow-sm {{ $message->sender_id === session('current_user_id') ? 'bg-blue-600 text-white ml-auto rounded-br-sm' : 'bg-white text-gray-800 border border-gray-200 mr-auto rounded-bl-sm' }}">
                    <span>
                        <strong class="{{ $message->sender_id === session('current_user_id') ? 'text-blue-200' : 'text-gray-900' }}">{{ $message->sender_id === session('current_user_id') ? 'Anda' : $receiver->name }}:</strong> 
                        {{ $message->content }}
                    </span>
                    
                    @if($message->sender_id === session('current_user_id'))
                        <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="self-end mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] text-blue-200 hover:text-red-300 uppercase tracking-wider">Hapus</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <form action="{{ route('messages.sendMessage') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
            <input type="text" name="content" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Ketik pesan..." required>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors">Kirim</button>
        </form>
    </div>
</body>
</html>