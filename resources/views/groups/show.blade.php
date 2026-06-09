<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->name }} - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex flex-col font-sans">
    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <a href="{{ route('messages.getConversations') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm">
            {{ strtoupper(substr($group->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ $group->name }}</h1>
            <p class="text-xs text-gray-500">{{ $group->members->count() }} Anggota</p>
        </div>
    </nav>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 max-w-3xl mx-auto w-full" id="chat-container">
        <div class="flex flex-col gap-3">
            @php $lastDate = null; @endphp
            
            @foreach($messages as $message)
                @php
                    $currentDate = $message->created_at->format('Y-m-d');
                    $displayDate = $message->created_at->isToday() ? 'Hari Ini' : ($message->created_at->isYesterday() ? 'Kemarin' : $message->created_at->format('d M Y'));
                @endphp

                @if($lastDate !== $currentDate)
                    <div class="flex justify-center my-4">
                        <span class="bg-gray-200 text-gray-600 text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">
                            {{ $displayDate }}
                        </span>
                    </div>
                    @php $lastDate = $currentDate; @endphp
                @endif

                @if($message->sender_id === session('current_user_id'))
                    <div class="flex justify-end items-center gap-2 w-full">
                        <div class="bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col">
                            <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            <div class="flex items-center justify-end gap-1.5 mt-1">
                                <span class="chat-time text-[10px] text-blue-100" data-timestamp="{{ $message->created_at->toIso8601String() }}"></span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start items-center gap-2 w-full">
                        <div class="bg-white border border-gray-200 text-gray-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col">
                            <span class="text-[11px] font-bold text-indigo-600 mb-0.5">{{ $message->sender?->name ?? 'Pengguna' }}</span>
                            <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            <span class="chat-time text-[10px] text-gray-400 mt-1 text-right block" data-timestamp="{{ $message->created_at->toIso8601String() }}"></span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>

    <div class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-50">
        <form action="{{ route('groups.sendMessage', $group->id) }}" method="POST" class="max-w-3xl mx-auto flex gap-3 items-center">
            @csrf
            <input type="text" name="content" class="flex-1 border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 text-sm" placeholder="Ketik pesan ke grup..." required autocomplete="off">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition-colors shadow-sm w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeElements = document.querySelectorAll('.chat-time');
            timeElements.forEach(el => {
                const timestamp = el.getAttribute('data-timestamp');
                if (timestamp) {
                    const date = new Date(timestamp);
                    el.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
            });
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;
        });
    </script>
</body>
</html>