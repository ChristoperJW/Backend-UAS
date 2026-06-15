<a href="/">
    <img src="{{ asset('images/Postify.png') }}" alt="Postify" width="200">
</a>

<h1>Ubah Post</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif

<form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    Caption:
    <br>
    <input type="text" name="caption" value="{{ old('caption', $post->caption) }}" required style="width: 400px;">
    <br><br>

    Media Saat Ini:
    <br>

    @if ($post->media)
        @php
            $extension = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
            <img src="{{ asset('uploads/posts/' . $post->media) }}" width="250">
        @elseif (in_array($extension, ['mp4']))
            <video width="300" controls>
                <source src="{{ asset('uploads/posts/' . $post->media) }}" type="video/mp4">
                Browser tidak mendukung video.
            </video>
        @endif

        <br>
        <small>{{ $post->media }}</small>
    @else
        Tidak ada media
    @endif

    <br><br>

    Ganti Media:
    <br>
    <input type="file" name="media" accept="image/*,video/*">
    <br><br>

    Hashtags:
    <br>
    @foreach ($tags as $tag)
        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $post->tags->contains($tag) ? 'checked' : '' }}>
        #{{ $tag->name }}
        <br>
    @endforeach

    <br>

    Tag Users:
    <br>
    @foreach ($users as $user)
        <input type="checkbox" name="tagged_users[]" value="{{ $user->id }}" {{ $post->taggedUsers->contains($user) ? 'checked' : '' }}>
        {{ '@' . $user->name }}
        <br>
    @endforeach

    <br>

    <button type="submit">Simpan</button>
</form>

<br>

<a href="{{ route('posts.show', $post) }}">Kembali ke Detail Post</a>
<br>
<a href="{{ route('posts.index') }}">Kembali ke Daftar Post</a>