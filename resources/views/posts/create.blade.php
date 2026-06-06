<h1>Buat Post Baru</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('posts.store') }}">
    @csrf

    Caption:
    <br>
    <input type="text" name="caption" value="{{ old('caption') }}" required>
    <br><br>

    Media:
    <br>
    <input type="text" name="media" value="{{ old('media') }}">
    <br><br>

    Hashtags:
    <br>
    @foreach ($tags as $tag)
    <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
    {{ $tag->name }}
    <br>
    @endforeach
    <br>

    Tag Users :
    <br>
    @foreach ($users as $user)
    <input type="checkbox" name="tagged_users[]" value="{{ $user->id }}">
    {{ $user->name }}
    <br>
    @endforeach
    <br>

    <button type="submit">Simpan</button>
</form>

<br>

<a href="{{ route('posts.index') }}">Kembali</a>