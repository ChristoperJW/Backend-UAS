<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
</head>
<body>

    @if(session('success'))

    <p>{{ session('success') }}</p>

    @endif

    <h1>Friends</h1>

    <hr>

    <h3>Social Statistics<h3>

    <a href="/friends/followers">
        Followers: 0
    </a>

    <br><br>

    <a href="/friends/following">
        Following: 0
    </a>

    <hr>

    <h3>Suggested Friends</h3>

    <div>
        @foreach($suggestions as $user)

            <div style="margin-bottom: 15px;">

                <strong> {{ $user->name }}</strong>

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