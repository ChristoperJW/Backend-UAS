<!DOCTYPE html>
<html>
<head>
    <title>Followers</title>
</head>
<body>

    <h1>Followers List</h1>

    <hr>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @forelse($followers as $user)

        <div style="margin-bottom: 15px;">

            <strong>{{ $user->name }}</strong>

            <a href="{{ route('users.profile', $user->id) }}">
                View Profile
            </a>

            @if(in_array($user->id, $closeFriendIds))
                <form action="{{ route('close-friends.remove', $user->id) }}" method="POST" style="display:inline;">
                    @csrf

                    <button type="submit">
                        Remove from Close Friend
                    </button>
                </form>
            @else
                <form action="{{ route('close-friends.add', $user->id) }}" method="POST" style="display:inline;">
                    @csrf

                    <button type="submit">
                        Add to Close Friend
                    </button>
                </form>
            @endif

        </div>

    @empty

        <p>No followers yet.</p>

    @endforelse

    <hr>

    <a href="/friends">
        <button>
            Back to Friends
        </button>
    </a>

</body>
</html>