<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@lang('Account Settings')</title>
    </head>
    <body>
        <div style="display: flex; align-items: center; gap: 10px;">
        <img src="{{ asset('images/settings.png') }}" width="50">
        <h1>@lang('Account Settings')</h1>
        </div>

        <form action="/account/update" method="GET">
            @csrf
            <button type="submit">
                {{ __('Update Account') }}
            </button>
        </form>

        <hr>


        
        
        @if (app()->getLocale() == 'id') 
            <form action="/account/delete" method="POST" onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!');">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">
                {{ __('Delete My Account') }}
            </button>
            </form>
        @else 
            <form action="/account/delete" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This cannot be undone!');">
            @csrf
            <button type="submit" style="background: red; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">
                {{ __('Delete My Account') }}
            </button>
            </form>
        @endif
        <hr>

        <h3>@lang('Privacy Settings')</h3>

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
                {{ __('Require approval before someone can follow me') }}
            </label>

            <br><br>

            <label>
                <input
                    type="checkbox"
                    name="is_private"
                    {{ $currentUser && $currentUser->is_private ? 'checked' : '' }}
                >
                {{ __('Account Privacy (Private)') }}
            </label>

            <br><br>

            <button type="submit">
                {{ __('Save Privacy Setting') }}
            </button>
        </form>

        <br>

        <a href="{{ route('reports.index') }}">
            <button type="button" style="background: red; color: white; padding: 10px; border-radius: 5px; cursor: pointer;">
                {{ __('Report an Issue') }}
            </button>
        </a><br>
        <br>

        <label for="language">@lang('Select Language:')</label>
        <br>
        
        @if (app()->getLocale() === 'id') 
            <span>@lang('Current Language: Indonesian')</span>
            <nav>
                <a href="{{ url('lang/en') }}">@lang('Ganti ke Inggris')</a>
            </nav>
        @else
            <span>@lang('Current Language: English')</span>
            <nav>
                <a href="{{ url('lang/id') }}">@lang('Ganti ke Indonesia')</a>
            </nav>
        @endif 
        
        <br>
        <a href="/">@lang('Back')</a>
    </body>
</html>