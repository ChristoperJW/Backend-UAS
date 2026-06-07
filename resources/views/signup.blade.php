<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Postify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 font-sans text-gray-800">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/Postify.png') }}" alt="Postify Logo" class="h-12 w-auto mx-auto mb-6 object-contain drop-shadow-sm">
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h1>
            <p class="text-sm text-gray-500 mt-2 font-medium">Bergabunglah dengan komunitas Postify hari ini</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm font-semibold border border-red-100">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST" class="flex flex-col gap-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 transition-all" placeholder="Masukkan nama lengkap kamu" required autofocus>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 transition-all" placeholder="Masukkan email aktif kamu" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700 bg-gray-50 transition-all" placeholder="Buat kata sandi yang kuat" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-sm hover:shadow-md mt-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center text-sm font-medium text-gray-500 border-t border-gray-100 pt-6">
            Sudah punya akun? 
            <a href="/login" class="text-blue-600 hover:text-blue-700 font-bold hover:underline transition-all">Masuk di sini</a>
        </div>
    </div>
</body>
</html>