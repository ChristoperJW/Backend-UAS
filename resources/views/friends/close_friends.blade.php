<!DOCTYPE html>
<html>
<head>
    <title>Close Friends</title>
</head>
<body>

    <h1>Close Friends List</h1>

    <hr>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @forelse($closeFriends as $closeFriend)

        <div style="margin-bottom: 15px;">

            <strong>{{ $closeFriend->closeFriend->name }}</strong>

            <a href="{{ route('users.profile', $closeFriend->closeFriend->id) }}">
                View Profile
            </a>

            <form action="{{ route('close-friends.remove', $closeFriend->closeFriend->id) }}" method="POST" style="display:inline;">
                @csrf

                <button type="submit">
                    Remove from Close Friend
                </button>
            </form>

        </div>

    @empty

        <p>No close friends yet.</p>

    @endforelse

    <hr>

    <a href="/friends">
        <button>
            Back to Friends
        </button>
    </a>

</body>
</html>