<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Buat Post Baru</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif

<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf

    Caption:
    <br>
    <input type="text" name="caption" value="{{ old('caption') }}" required style="width: 400px;">
    <br><br>

    Media (Foto / Video):
    <br>
    <input type="file" name="media" accept="image/*,video/*">
    <br><br>

    Hashtags:
    <br>
    @foreach ($tags as $tag)
        <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
        #{{ $tag->name }}
        <br>
    @endforeach

    <br>

    Tag Users:
    <br>
    @foreach ($users as $user)
        <input type="checkbox" name="tagged_users[]" value="{{ $user->id }}">
        {{ '@' . $user->name }}
        <br>
    @endforeach

    <br>

    <button type="submit">Simpan</button>
</form>

<br>

<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>