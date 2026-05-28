@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Obrolan dengan {{ $receiver->name }}</h3>
    <div class="card mb-3">
        <div class="card-body">
            @foreach($messages as $message)
                <div class="mb-2 d-flex justify-content-between">
                    <span>
                        <strong>{{ $message->sender_id === Auth::id() ? 'Anda' : $receiver->name }}:</strong> 
                        {{ $message->content }}
                    </span>
                    @if($message->sender_id === Auth::id())
                        <form action="{{ route('messages.removeMessage', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">X</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <form action="{{ route('messages.sendMessage') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
        <div class="input-group">
            <input type="text" name="content" class="form-control" placeholder="Ketik pesan..." required>
            <button type="submit" class="btn btn-success">Kirim</button>
        </div>
    </form>
</div>
@endsection