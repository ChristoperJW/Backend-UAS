## Backend Project UAS

## Kelompok 7 (Postify)
- Louise William                535250003
- Michael Respati Sanjaya Ho    535250008
- Angga Johanes Thesman         535250016
- Christoper Julian Wijaya      535250030
- Monica Irene                  535250041

## Cara Run Program
1.	Buka github di browser, kemudian masukkan link berikut: https://github.com/ChristoperJW/Backend-UAS
2.	Lakukan fork dan repository pada link diatas ke local komputer.
3.	Dapat menggunakan command git clone <url yang telah diberikan> pada terminal jika ingin mengakses penuh folder dan file milik kami. Lalu masuk ke folder “Backend-UAS” dengan command cd Backend-UAS pada terminal.
4.	Buka xampp, lalu aktifkan kedua modul (Apache & MySQL).
5.	Ketika modul telah aktif, buka browser dan masuk pada halaman http://localhost/phpmyadmin
6.	Buat file baru bernama .env dan copy paste text yang ada pada file .env.example. Untuk mengakses database.
7.	Untuk setup dev environment, lakukan instalasi modul-modul yang dibutuhkan:
npm install & composer install
8.	Agar migration dan seeder pada database terkoneksi, jalankan perintah berikut:
php artisan migrate:fresh -–seed
9.	Karena kami menggunakan style untuk memperindah tampilan UI (User Interface), terdapat program eksternal yang digunakan bernama “vite”. Jalankan “npm run dev” terlebih dahulu.
10.	Untuk memulai program, jalankan pada terminal, dan tunggu sampai terconnect dengan sukses: php artisan serve.

