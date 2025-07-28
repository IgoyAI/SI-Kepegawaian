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
3. Atur nilai `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, dan `JWT_SECRET` di file
   `.env`.  Anda juga dapat menentukan email yang mendapat peran `hr` melalui
   variabel `HR_EMAILS` (pisahkan dengan koma). Nilai `JWT_SECRET` akan digunakan
   untuk menandatangani token SSO, sehingga harus sama pada aplikasi SSO.
4. Jalankan perintah berikut untuk menjalankan seluruh migrasi sehingga
   semua tabel yang dibutuhkan (misalnya `users` maupun `cuti_logs`) terbentuk:
   ```bash
   php spark migrate
   ```
5. Jalankan server pengembangan bawaan CodeIgniter untuk aplikasi kepegawaian:
   ```bash
   php spark serve --port 8080
   ```
6. Pada terminal terpisah, siapkan dan jalankan layanan SSO:
   ```bash
   cd ../sso
   composer install
   cp env .env
   ```
   Sunting berkas `.env` pada direktori `sso` dan isi nilai
   `google.oauthClientId`, `google.oauthClientSecret`, serta `jwt.secret`
   (atau `JWT_SECRET`) dengan nilai yang sama seperti di aplikasi kepegawaian.
   Setelah itu jalankan:
   ```bash
   php spark serve --port 8081
   ```
7. Akses aplikasi melalui `http://localhost:8080` dan login menggunakan tombol
   **Login with SSO** yang akan mengarahkan ke `http://localhost:8081`.

Jenis cuti yang tersedia dapat disesuaikan pada berkas `app/Views/cuti/_form.php`.

Fitur presensi mandiri menggunakan kamera perangkat. Saat membuka menu
"Presensi" sebagai karyawan, aplikasi akan meminta akses kamera dan foto
diambil secara langsung tanpa perlu mengunggah berkas.

Database SQLite berada di `ci4app/writable/database.sqlite`.
