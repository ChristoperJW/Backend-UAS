<!DOCTYPE html>
<html>
<head>
    <title>Following</title>
</head>
<body>

    <h1>Following List</h1>

    <hr>

    @forelse($followers as $user)

    <div style="margin-bottom: 15px;">

        <strong>{{ $user->name }}</strong>

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