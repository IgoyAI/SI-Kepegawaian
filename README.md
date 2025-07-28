# SI-Kepegawaian

Aplikasi sederhana sistem informasi kepegawaian berbasis [CodeIgniter 4](https://codeigniter.com/) dengan antarmuka menggunakan AdminLTE 3.

## Menjalankan Aplikasi

1. Masuk ke direktori `ci4app` dan instal dependensi menggunakan Composer:
   ```bash
   cd ci4app
   composer install
   ```
2. Salin berkas `env` menjadi `.env`:
   ```bash
   cp env .env
   ```
3. Atur nilai `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` di file `.env`.
   Anda juga dapat menentukan email yang mendapat peran `hr` melalui variabel `HR_EMAILS` (pisahkan dengan koma).
4. Jalankan perintah berikut untuk menjalankan seluruh migrasi sehingga
   semua tabel yang dibutuhkan (misalnya `users` maupun `cuti_logs`) terbentuk:
   ```bash
   php spark migrate
   ```
5. Jalankan server pengembangan bawaan CodeIgniter untuk aplikasi kepegawaian:
   ```bash
   php spark serve --port 8080
   ```
6. Pada terminal terpisah, jalankan layanan SSO:
   ```bash
   cd ../sso
   composer install
   php spark serve --port 8081
   ```
7. Akses aplikasi melalui `http://localhost:8080` dan login menggunakan tombol
   **Login with SSO** yang akan mengarahkan ke `http://localhost:8081`.

Jenis cuti yang tersedia dapat disesuaikan pada berkas `app/Views/cuti/_form.php`.

Fitur presensi mandiri menggunakan kamera perangkat. Saat membuka menu
"Presensi" sebagai karyawan, aplikasi akan meminta akses kamera dan foto
diambil secara langsung tanpa perlu mengunggah berkas.

Database SQLite berada di `ci4app/writable/database.sqlite`.
