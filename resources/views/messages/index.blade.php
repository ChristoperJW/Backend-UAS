<!DOCTYPE html>
<html>
<head>
    <title>Messages - Postify</title>
</head>
<body>
    <a href="/">
        <button>Back to Home</button>
    </a>
    <hr>
<div class="container">
    <h3>Daftar Obrolan</h3>
    <form action="{{ route('messages.createConversation') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="number" name="receiver_id" class="form-control" placeholder="Masukkan ID User tujuan..." required>
            <button type="submit" class="btn btn-primary">Mulai Obrolan Baru</button>
        </div>
    </form>
    @foreach($users as $user)
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('messages.getMessages', $user->id) }}" class="btn btn-outline-primary">
            @if($user->id == session('current_user_id'))
                Diri Sendiri (Catatan Pribadi)
            @else
                {{ $user->name }}
            @endif
            <small> (ID Dia: {{ $user->id }} | ID Saya: {{ session('current_user_id') }}) </small>
            </a>
            <form action="{{ route('messages.removeFullConversation', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus Obrolan</button>
            </form>
        </div>
    @endforeach
</div>
</body>
</html>