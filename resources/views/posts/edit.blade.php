<h1>Ubah Post</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('posts.update', $post) }}">
    @csrf
    @method('PUT')

    Caption:
    <br>
    <input type="text" name="caption" value="{{ old('caption', $post->caption) }}" required>
    <br><br>

    Media:
    <br>
    <input type="text" name="media" value="{{ old('media', $post->media) }}">
    <br><br>

    Tags:
    <br>
    @foreach ($tags as $tag)
    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $post->tags->contains($tag) ? 'checked' : '' }}>
    {{ $tag->name }}
    <br>
    @endforeach
    <br>

    <button type="submit">Simpan</button>
</form>

<br>

<a href="{{ route('posts.show', $post) }}">Kembali ke Detail</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>