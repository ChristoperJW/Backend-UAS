<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex flex-col font-sans overflow-hidden">
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
                        
                        @if($message->content !== 'Pesan telah dihapus')
                            <div class="hidden group-hover:flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_everyone">
                                    <button type="submit" title="Hapus untuk Semua" class="text-gray-400 hover:text-red-500 p-1.5 bg-white border border-gray-200 rounded-full shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>

                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_me">
                                    <button type="submit" title="Hapus untuk Saya" class="text-gray-400 hover:text-gray-600 p-1.5 bg-white border border-gray-200 rounded-full shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="bg-blue-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col {{ $message->content === 'Pesan telah dihapus' ? 'opacity-70 italic' : '' }}">
                            @if($message->media_path && $message->content !== 'Pesan telah dihapus')
                                @if($message->media_type === 'image')
                                    <img src="{{ asset('storage/' . $message->media_path) }}" class="rounded-xl max-w-full mb-2 max-h-60 object-cover shadow-sm border border-blue-500">
                                @elseif($message->media_type === 'video')
                                    <video src="{{ asset('storage/' . $message->media_path) }}" controls class="rounded-xl max-w-full mb-2 max-h-60 shadow-sm border border-blue-500"></video>
                                @endif
                            @endif

                            @if($message->content)
                                <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            @endif
                            <div class="flex items-center justify-end gap-1.5 mt-1">
                                <span class="chat-time text-[10px] text-blue-100" data-timestamp="{{ $message->created_at->toIso8601String() }}"></span>
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
                        <div class="bg-white border border-gray-200 text-gray-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm max-w-[75%] sm:max-w-md flex flex-col {{ $message->content === 'Pesan telah dihapus' ? 'opacity-70 italic' : '' }}">
                            
                            @if($message->media_path && $message->content !== 'Pesan telah dihapus')
                                @if($message->media_type === 'image')
                                    <img src="{{ asset('storage/' . $message->media_path) }}" class="rounded-xl max-w-full mb-2 max-h-60 object-cover shadow-sm border border-gray-200">
                                @elseif($message->media_type === 'video')
                                    <video src="{{ asset('storage/' . $message->media_path) }}" controls class="rounded-xl max-w-full mb-2 max-h-60 shadow-sm border border-gray-200"></video>
                                @endif
                            @endif

                            @if($message->content)
                                <p class="text-sm text-left break-words">{{ $message->content }}</p>
                            @endif
                            <span class="chat-time text-[10px] text-gray-400 mt-1 text-right block" data-timestamp="{{ $message->created_at->toIso8601String() }}"></span>
                        </div>

                        @if($message->content !== 'Pesan telah dihapus')
                            <div class="hidden group-hover:flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="for_me">
                                    <button type="submit" title="Hapus untuk Saya" class="text-gray-400 hover:text-gray-600 p-1.5 bg-white border border-gray-200 rounded-full shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </main>

    <div class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-50 relative">
        <div id="media-preview-container" class="hidden absolute bottom-full left-4 mb-2 bg-white p-2 rounded-xl shadow-lg border border-gray-200">
            <div class="relative inline-block">
                <img id="preview-image" class="hidden max-h-40 rounded-lg object-cover">
                <video id="preview-video" class="hidden max-h-40 rounded-lg" controls></video>
                <button type="button" id="remove-media" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <form action="{{ route('messages.sendMessage') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto flex gap-3 items-center" id="chat-form">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
            <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-500 p-3 rounded-full transition-colors shrink-0 flex items-center justify-center w-12 h-12 border border-gray-200 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <input type="file" id="media-input" name="media" accept="image/*,video/*" class="hidden">
            </label>
            <input type="text" name="content" class="flex-1 border border-gray-300 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 text-sm" placeholder="Ketik pesan..." autocomplete="off">
            <button type="submit" id="submit-btn" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition-colors shadow-sm w-12 h-12 flex items-center justify-center shrink-0">
                <span id="btn-icon">
                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                </span>
                <span id="btn-spinner" class="hidden">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </span>
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
            if (container) {
                container.scrollTop = container.scrollHeight;
            }

            const fileInput = document.getElementById('media-input');
            const previewContainer = document.getElementById('media-preview-container');
            const previewImage = document.getElementById('preview-image');
            const previewVideo = document.getElementById('preview-video');
            const removeButton = document.getElementById('remove-media');
            const chatForm = document.getElementById('chat-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnIcon = document.getElementById('btn-icon');
            const btnSpinner = document.getElementById('btn-spinner');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileURL = URL.createObjectURL(file);
                    previewContainer.classList.remove('hidden');

                    if (file.type.startsWith('video/')) {
                        previewVideo.src = fileURL;
                        previewVideo.classList.remove('hidden');
                        previewImage.classList.add('hidden');
                    } else {
                        previewImage.src = fileURL;
                        previewImage.classList.remove('hidden');
                        previewVideo.classList.add('hidden');
                    }
                }
            });

            removeButton.addEventListener('click', function() {
                fileInput.value = '';
                previewContainer.classList.add('hidden');
                previewVideo.src = '';
                previewImage.src = '';
            });

            chatForm.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                btnIcon.classList.add('hidden');
                btnSpinner.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>