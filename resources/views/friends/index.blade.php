<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
</head>
<body>

    <h2>
        Current User:
        {{ $currentUser->name }}
    </h2>

    <hr>

    @if(session('success'))

    <p>{{ session('success') }}</p>

    @endif

    <h1>Friends</h1>

    <hr>

    <h3>Search Users</h3>

    <form action="/friends" method="GET">
        <input type="text" name="search" placeholder="Search user by name or email" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    @if(request('search'))
        <h4>Search Results</h4>

        @forelse($searchResults as $user)
            <div style="margin-bottom: 15px;">
                <strong>{{ $user->name }}</strong>
                <p>{{ $user->email }}</p>

                @if($followedUsers->contains($user->id))
                    <form action="{{ route('friends.unfollow', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Unfollow</button>
                    </form>
                @else
                    <form action="{{ route('friends.follow', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Follow</button>
                    </form>
                @endif
            </div>
        @empty
            <p>No users found.</p>
        @endforelse
    @endif

    <h3>Social Statistics</h3>

    <a href="/friends/followers">
        <p>Followers: {{ $followersCount }}</p>
    </a>


    <a href="/friends/following">
        <p>Following: {{ $followingCount }}</p>
    </a>

    <hr>

    <h3>Suggested Friends</h3>

    <div>

        @foreach($suggestions as $user)

            <div style="margin-bottom: 15px;">

                <strong>{{ $user->name }}</strong>

                <form action="{{ route('friends.follow', $user->id) }}"
                      method="POST"
                      style="display:inline;">

                    @csrf

                    <button type="submit">
                        Follow
                    </button>

                </form>

            </div>

        @endforeach

    </div>

    <hr>

    <a href="/">
        <button>
            Back to homepage
        </button>
    </a>

</body>
</html>