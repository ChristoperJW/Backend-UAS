<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex flex-col font-sans">
    <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center gap-4 sticky top-0 z-50">
        <a href="{{ route('messages.getConversations') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm">
            {{ strtoupper(substr($receiver->name, 0, 1)) }}
        </div>
        <h1 class="text-xl font-bold text-gray-800">{{ $receiver->name }}</h1>
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
                    <div class="flex justify-end items-center gap-2 group w-full relative">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity shrink-0 relative">
                            <button onclick="toggleMenu('menu-{{ $message->id }}')" class="p-2 text-gray-400 bg-white hover:text-red-500 hover:bg-red-50 rounded-full transition-colors shadow-sm border border-gray-100" title="Opsi Pesan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>

                            <div id="menu-{{ $message->id }}" class="hidden absolute right-full mr-2 top-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_me">
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors border-b border-gray-50">Hapus untuk Saya</button>
                                </form>
                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_everyone">
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors border-b border-gray-50 font-medium">Hapus untuk Semua</button>
                                </form>
                                <button onclick="toggleMenu('menu-{{ $message->id }}')" class="w-full text-left px-4 py-3 text-sm text-gray-500 hover:bg-gray-50 transition-colors">Batal</button>
                            </div>
                        </div>

                        <div class="bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col">
                            <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            <div class="flex items-center justify-end gap-1.5 mt-1">
                                <span class="text-[10px] text-blue-100">{{ $message->created_at->format('H:i') }}</span>
                                <span class="{{ $message->is_read ? 'text-white' : 'text-blue-300' }}">
                                    @if($message->is_read)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 12l4 4L16 8m-4 8l4 4L22 10"></path></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start items-center gap-2 group w-full relative">
                        <div class="bg-white border border-gray-200 text-gray-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col">
                            <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            <span class="text-[10px] text-gray-400 mt-1 text-right block">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity shrink-0 relative">
                            <button onclick="toggleMenu('menu-{{ $message->id }}')" class="p-2 text-gray-400 bg-white hover:text-gray-600 hover:bg-gray-50 rounded-full transition-colors shadow-sm border border-gray-100" title="Opsi Pesan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                            </button>

                            <div id="menu-{{ $message->id }}" class="hidden absolute left-full ml-2 top-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_me">
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors border-b border-gray-50">Hapus untuk Saya</button>
                                </form>
                                <button onclick="toggleMenu('menu-{{ $message->id }}')" class="w-full text-left px-4 py-3 text-sm text-gray-500 hover:bg-gray-50 transition-colors">Batal</button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>

    <div class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-50">
        <form action="{{ route('messages.sendMessage') }}" method="POST" class="max-w-3xl mx-auto flex gap-3 items-center">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
            <input type="text" name="content" class="flex-1 border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 text-sm" placeholder="Ketik pesan..." required autocomplete="off">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition-colors shadow-sm w-12 h-12 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
            </button>
        </form>
    </div>

    <script>
        function toggleMenu(menuId) {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                if (menu.id !== menuId) {
                    menu.classList.add('hidden');
                }
            });
            
            const menu = document.getElementById(menuId);
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const isClickInsideMenu = event.target.closest('[id^="menu-"]');
            const isClickOnButton = event.target.closest('button[onclick^="toggleMenu"]');
            
            if (!isClickInsideMenu && !isClickOnButton) {
                document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>