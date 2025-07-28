# SI Kepegawaian - Panduan Pengembang

Dokumen ini berisi informasi teknis mengenai struktur proyek, arsitektur aplikasi, serta cara menjalankan pengujian.

## 1. Struktur Proyek

```
ci4app/            # Aplikasi CodeIgniter 4
├── app/           # Kode sumber utama (Controllers, Models, Views, Config)
├── public/        # Dokumen publik yang diakses oleh web server
├── writable/      # Berkas yang dapat diubah (termasuk uploads dan database)
├── tests/         # Kumpulan unit test
└── composer.json  # Definisi dependensi
```

Semua logika berada pada folder `app/` menggunakan pola MVC bawaan CodeIgniter.

## 2. Arsitektur Aplikasi

### 2.1 Autentikasi

- `App\Controllers\Auth` menggunakan paket `league/oauth2-google` untuk proses OAuth2 dengan Google.
- Terdapat filter `AuthFilter` yang memastikan semua route dengan filter `auth` hanya diakses pengguna yang sudah login.
- Pengguna baru otomatis dibuat pada tabel `users` dan mendapatkan peran `hr` jika emailnya terdaftar pada variabel `HR_EMAILS`.

### 2.2 Modul Pegawai

- **Controller**: `Employees`.
- **Model**: `EmployeeModel` yang terhubung dengan tabel `pegawai`.
- **View**: terdapat form `_form.php`, halaman `index.php` untuk menampilkan dan mengedit data.
- Hanya peran HR yang dapat mengakses route modul ini (dijaga oleh `HrFilter`).

### 2.3 Modul Presensi

- **Controller**: `Attendance`.
- **Model**: `AttendanceModel` dengan tabel `presensi`.
- HR dapat menambah dan mengubah presensi seluruh pegawai.
- Karyawan melakukan presensi mandiri melalui aksi `self()` dan `selfSave()` yang mengakses kamera dan geolokasi di `views/attendance/self.php`.

### 2.4 Modul Cuti

- **Controller**: `Cuti` dan `CutiLogModel` untuk riwayat.
- Pegawai mengajukan cuti, HR memproses status dan alasan penolakan.
- Fungsi `timeline()` menampilkan riwayat perubahan status cuti dan komentar sanggahan.

### 2.5 Pengaturan Profil

- **Controller**: `Profile`.
- Pengguna dapat memperbarui nama yang tersimpan di tabel `users`.

### 2.6 Penyajian Berkas Upload

- `Files::uploads()` menyajikan berkas di `writable/uploads` secara aman melalui route `/uploads/...`.

### 2.7 Basis Data

- Database default menggunakan SQLite (`writable/database.sqlite`).
- Seluruh skema dibuat melalui migrasi di `app/Database/Migrations` seperti pembuatan tabel `pegawai`, `presensi`, `cuti`, `cuti_logs`, dan `users`.

## 3. Menjalankan Aplikasi Lokal

1. Masuk ke direktori `ci4app`.
2. Jalankan `composer install` untuk mengunduh dependensi.
3. Salin file `env` menjadi `.env` lalu isi `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, dan `HR_EMAILS` sesuai kebutuhan.
4. Jalankan seluruh migrasi:
   ```bash
   php spark migrate
   ```
5. Jalankan server pengembangan aplikasi kepegawaian pada port 8080:
   ```bash
   php spark serve --port 8080
   ```
6. Buka terminal baru dan jalankan layanan SSO pada port 8081:
   ```bash
   cd ../sso
   composer install
   php spark serve --port 8081
   ```
7. Aplikasi kepegawaian dapat diakses di `http://localhost:8080` dan proses
   autentikasi dilakukan melalui `http://localhost:8081`.

## 4. Menjalankan Pengujian

Unit test berada pada direktori `tests/`. Untuk menjalankannya:

```bash
cd ci4app
composer install
vendor/bin/phpunit
```

Perintah tersebut akan mengeksekusi seluruh test. Hasil pengujian di repositori ini seharusnya menampilkan semua test **OK**.

## 5. Catatan Pengembangan

- Seluruh fitur diatur melalui berkas route `app/Config/Routes.php`.
- Filter `HrFilter` dan `AuthFilter` mencegah akses tidak sah.
- Controller mewarisi `BaseController` yang menginisialisasi layanan umum.
- View menggunakan template `layout.php` yang memuat AdminLTE untuk tampilan antarmuka.

Panduan ini diharapkan membantu pengembang memahami struktur internal dan cara melakukan modifikasi maupun pengujian pada aplikasi.
