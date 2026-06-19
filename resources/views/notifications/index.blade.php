<h1>Notifikasi</h1>

@if ($notifications->isEmpty())
    <p>Belum ada notifikasi.</p>
@else
    @foreach ($notifications as $notif)
        <p style="{{ $notif->isRead() ? '' : 'font-weight: bold;' }}">
            @if ($notif->type === 'like')
                {{ $notif->sender->name }} menyukai postingan Anda
                @if ($notif->post)
                    - <a href="{{ route('posts.show', $notif->post) }}">"{{ $notif->post->caption }}"</a>
                @endif

            @elseif ($notif->type === 'comment')
                {{ $notif->sender->name }} mengomentari postingan anda
                @if ($notif->post)
                    - <a href="{{ route('posts.show', $notif->post) }}">"{{ $notif->post->caption }}"</a>
                @endif

            @elseif ($notif->type === 'follow')
                {{ $notif->sender->name }} mulai mengikuti anda

            @elseif ($notif->type === 'tag_post')
                {{ $notif->sender->name }} menandai anda di sebuah postingan
                @if ($notif->post)
                    - <a href="{{ route('posts.show', $notif->post) }}">"{{ $notif->post->caption }}"</a>
                @endif
            @elseif ($notif->type === 'repost')
                {{ $notif->sender->name }} merepost postingan Anda
                @if ($notif->post)
                    - <a href="{{ route('posts.show', $notif->post) }}">"{{ $notif->post->caption }}"</a>
                @endif

            @elseif ($notif->type === 'favorite')
            {{ $notif->sender->name }} menyimpan postingan Anda ke favorit
            @if ($notif->post)
                - <a href="{{ route('posts.show', $notif->post) }}">"{{ $notif->post->caption }}"</a>
            @endif
            @endif

            - <small>{{ $notif->created_at->diffForHumans() }}</small>

            @if (!$notif->isRead())
                - <form action="{{ route('notifications.read', $notif->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Tandai Dibaca</button>
                </form>
            @endif
        </p>
        <hr>
    @endforeach
@endif
<a href="/">Back to Homepage</a>