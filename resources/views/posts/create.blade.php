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

    <button type="submit">Simpan</button>
</form>

<br>

<a href="{{ route('posts.index') }}">Kembali</a>