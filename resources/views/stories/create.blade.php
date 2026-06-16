<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Buat Story</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif

<form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data">
    @csrf

    Caption:
    <br>
    <input type="text" name="caption" value="{{ old('caption') }}" style="width: 400px;">
    <br><br>

    Media (Foto / Video):
    <br>
    <input type="file" name="media" accept="image/*,video/*" required>
    <br><br>

    <button type="submit">Upload Story</button>
</form>

<br>

<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>