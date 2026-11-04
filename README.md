# PBKK – Latihan CodeIgniter 4

Source code tugas PBKK-2 (Pengenalan Framework CodeIgniter), CodeIgniter 4.7.6.

| Folder | Aplikasi | Port | Database |
|---|---|---|---|
| `siakad/` | SIAKAD: mahasiswa, dosen, mata kuliah, KRS, nilai (role admin/dosen/mahasiswa) | 8080 | `ci_siakad` |
| `toko-online/` | Toko Online: etalase, keranjang, checkout, pesanan (role admin/customer) | 8081 | `ci_toko` |

Laporan: `laporan.html` / `laporan.pdf` (screenshot di `screenshots/`).

## Menjalankan

Kebutuhan: PHP 8.2 dengan ekstensi `intl` dan `mysqli`, Composer, MariaDB/MySQL (mis. XAMPP).

```bash
cd siakad            # atau toko-online
composer install
cp env .env          # lalu atur app.baseURL dan database.default.* (lihat di bawah)
php spark migrate
php spark db:seed SiakadSeeder   # toko-online: TokoSeeder
php spark serve --port 8080      # Windows/XAMPP: serve.bat 8080
```

Isi `.env` minimal:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = ci_siakad
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

Buat database kosong (`ci_siakad` / `ci_toko`) terlebih dahulu.

## Akun demo (dari seeder)

| Aplikasi | Role | Username | Password |
|---|---|---|---|
| SIAKAD | Admin | admin | admin123 |
| SIAKAD | Dosen | 0011223301 | 0011223301 |
| SIAKAD | Mahasiswa | 5025231015 | 5025231015 |
| Toko | Admin | admin | admin123 |
| Toko | Customer | budi | budi123 |
