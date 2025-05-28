# Menjalankan Aplikasi Todo List Laravel

Dokumen ini berisi petunjuk step-by-step untuk menjalankan aplikasi Todo List yang telah dikembangkan.

## Prasyarat

Pastikan Anda telah menginstal:
- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Database MySQL

## Langkah-langkah Menjalankan Aplikasi

### 1. Clone Repository (jika belum)

```bash
git clone [URL_REPOSITORY]
cd [NAMA_FOLDER]
```

### 2. Install Dependensi

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hirup_aing
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat struktur database dan menambahkan data demo.

### 5. Jalankan Server Development

Dalam dua terminal terpisah, jalankan:

```bash
# Terminal 1 - Backend
php artisan serve
```

```bash
# Terminal 2 - Frontend
npm run dev
```

### 6. Akses Aplikasi

Buka browser dan kunjungi: `http://localhost:8000`

## Akun Demo

Aplikasi sudah dilengkapi dengan dua akun demo:

1. Demo User
   - Email: user@example.com
   - Password: password

2. Team Member
   - Email: member@example.com
   - Password: password

## Fitur Utama

1. **Manajemen Tugas**
   - Buat, edit, dan hapus tugas
   - Tetapkan status tugas (Todo, In Progress, Completed)
   - Tetapkan tanggal jatuh tempo

2. **Kolaborasi Multi-user**
   - Undang pengguna lain ke tugas
   - Terima atau tolak undangan
   - Atur peran anggota (Owner, Member)

3. **Notifikasi**
   - Notifikasi email saat diundang ke tugas
   - Notifikasi di aplikasi untuk aktivitas penting

## Troubleshooting

### Masalah Database

Jika terjadi masalah koneksi database, pastikan:
- Layanan database berjalan
- Kredensial database di file `.env` benar
- Database telah dibuat

### Masalah Frontend

Jika aset frontend tidak dimuat dengan benar:
- Pastikan `npm run dev` berjalan
- Hapus cache browser
- Coba build aset: `npm run build`

### Masalah Laravel

Jika terjadi error Laravel:
- Hapus cache: `php artisan optimize:clear`
- Periksa log error di `storage/logs/laravel.log`
- Pastikan semua dependensi terinstal dengan benar
