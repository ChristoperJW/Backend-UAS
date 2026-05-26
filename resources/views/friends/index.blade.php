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

    <h3>Switch User</h3>

    @foreach($allUsers as $user)

        <a href="/switch-user/{{ $user->id }}">

            {{ $user->name }}

        </a>

        |

    @endforeach

    <hr>

    @if(session('success'))

    <p>{{ session('success') }}</p>

    @endif

    <h1>Friends</h1>

    <hr>

    <h3>Social Statistics</h3>

    <a href="/friends/followers">
        <p>Followers: {{ $followersCount }}</p>
    </a>

    <br><br>

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