<!DOCTYPE html>
<html>
<head>
    <title>Following</title>
</head>
<body>

    <h1>Following List</h1>

    <hr>

    @forelse($followingUsers as $user)

        <div style="margin-bottom: 15px;">

            <strong>{{ $user->name }}</strong>

            <a href="{{ route('users.profile', $user->id) }}">
                View Profile
            </a>

            <form action="{{ route('friends.unfollow', $user->id) }}"
                  method="POST"
                  style="display:inline;">

                @csrf

                <button type="submit">
                    Unfollow
                </button>

            </form>

        </div>

    @empty

        <p>No following users yet.</p>

    @endforelse

    <hr>

    <a href="/friends">
        <button>
            Back to Friends
        </button>
    </a>

</body>
</html>