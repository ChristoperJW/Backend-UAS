<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Account Settings</title>
    </head>
    <body>
        <div style="display: flex; align-items: center; gap: 10px;">
        <img src="{{ asset('images/settings.png') }}" width="50">
        <h1>Account Settings</h1>
        </div>

        <form action="/account/update" method="GET">
            @csrf
            <button type="submit">
                Update Account
            </button>
        </form>

        <hr>

        <form action="/account/delete" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This cannot be undone!');">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">
                Delete My Account
            </button>
        </form>

        <hr>

        <h3>Privacy Settings</h3>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @php
            $currentUser = \App\Models\User::find(session('current_user_id'));
        @endphp

        <form action="/account/privacy" method="POST">
            @csrf

            <label>
                <input
                    type="checkbox"
                    name="require_follow_approval"
                    {{ $currentUser && $currentUser->require_follow_approval ? 'checked' : '' }}
                >

                Require approval before someone can follow me
            </label>

            <br><br>

            <button type="submit">
                Save Privacy Setting
            </button>
        </form>

        <br>

        <a href="/">Back</a>
    </body>
</html>