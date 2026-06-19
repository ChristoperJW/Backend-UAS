<h1>Report an Issue</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf
    <textarea name="message" rows="6" cols="50" placeholder="Describe your issue here..." style="width: 100%; padding: 10px;"></textarea>
    @error('message')
        <p style="color: red;">{{ $message }}</p>
    @enderror
    <br>
    <button type="submit" style="background: none; border: none; cursor: pointer;">
        <img src="{{ asset('images/send.png') }}" width="30">
    </button>
</form>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<a href="/account">Back to Account</a>