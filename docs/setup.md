# Aplikasi Todo List dengan Laravel, Tailwind CSS, dan Livewire

Dokumentasi ini berisi informasi tentang setup dan pengembangan aplikasi Todo List dengan fitur multi-user dan notifikasi. Aplikasi ini dikembangkan menggunakan Laravel 12, Tailwind CSS, dan Livewire.

## Setup Environment

### Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Git

### Langkah-langkah Instalasi

1. **Clone Repository**

   ```bash
   git clone [URL_REPOSITORY]
   cd [NAMA_FOLDER]
   ```

2. **Install Dependencies PHP**

   ```bash
   composer install
   ```

3. **Setup Environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit file `.env` dan atur konfigurasi database:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hirup_aing
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Install Dependencies JavaScript**

   ```bash
   npm install
   ```

5. **Install Tailwind CSS**

   ```bash
   npm install -D tailwindcss postcss autoprefixer
   npx tailwindcss init -p
   ```

   Tambahkan path berikut ke file `tailwind.config.js`:

   ```js
   /** @type {import('tailwindcss').Config} */
   export default {
     content: [
       "./resources/**/*.blade.php",
       "./resources/**/*.js",
       "./resources/**/*.vue",
     ],
     theme: {
       extend: {},
     },
     plugins: [],
   }
   ```

6. **Install Livewire**

   ```bash
   composer require livewire/livewire
   ```

7. **Migrasi Database**

   ```bash
   php artisan migrate
   ```

8. **Jalankan Aplikasi**

   Dalam dua terminal terpisah, jalankan:

   ```bash
   php artisan serve
   ```

   dan

   ```bash
   npm run dev
   ```

## Fitur Aplikasi

Aplikasi Todo List ini memiliki fitur-fitur sebagai berikut:

1. **Manajemen Tugas**
   - Membuat tugas baru
   - Mengedit tugas
   - Menghapus tugas
   - Menandai tugas sebagai selesai

2. **Kolaborasi Multi-user**
   - Mengundang pengguna lain ke tugas
   - Menerima undangan
   - Menolak undangan
   - Hak akses berbeda untuk pembuat dan kontributor

3. **Notifikasi**
   - Notifikasi saat diundang ke tugas
   - Notifikasi saat tugas diubah
   - Notifikasi saat batas waktu tugas mendekati

4. **Dashboard**
   - Tampilan semua tugas milik pengguna
   - Filter tugas berdasarkan status
   - Pencarian tugas

## Struktur Database

### Tabel Users
- id (primary key)
- name
- email
- password
- created_at
- updated_at

### Tabel Tasks
- id (primary key)
- title
- description
- status (todo, in_progress, completed)
- due_date
- user_id (foreign key ke users.id, pembuat tugas)
- created_at
- updated_at

### Tabel Task_User
- id (primary key)
- task_id (foreign key ke tasks.id)
- user_id (foreign key ke users.id)
- role (owner, member)
- created_at
- updated_at

### Tabel Notifications
- id (primary key)
- type
- notifiable_type
- notifiable_id
- data
- read_at
- created_at
- updated_at

## CI/CD dengan GitHub ke Shared Hosting

### Setup GitHub Actions

1. Buat file `.github/workflows/deploy.yml` dengan isi sebagai berikut:

```yml
name: Deploy to Shared Hosting

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
      with:
        fetch-depth: 0
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql, bcmath, zip
        coverage: none
    
    - name: Install Composer Dependencies
      run: composer install --no-dev --optimize-autoloader
    
    - name: Install Node.js Dependencies and Build Assets
      run: |
        npm install
        npm run build
    
    - name: Setup SSH Key
      uses: webfactory/ssh-agent@v0.7.0
      with:
        ssh-private-key: ${{ secrets.SSH_PRIVATE_KEY }}
    
    - name: Deploy to Shared Hosting
      run: |
        echo "Starting deployment..."
        rsync -avz --exclude='.git' --exclude='.github' --exclude='node_modules' --exclude='.env' --delete ./ ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }}:${{ secrets.REMOTE_TARGET }}
        
        echo "Running post-deployment commands..."
        ssh ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }} "cd ${{ secrets.REMOTE_TARGET }} && php artisan migrate --force && php artisan optimize:clear && php artisan optimize"
        
        echo "Deployment completed successfully!"
```

### Secrets yang Dibutuhkan di GitHub

Tambahkan secrets berikut di repository GitHub:

- `SSH_PRIVATE_KEY`: Private key SSH untuk koneksi ke shared hosting
- `SSH_USER`: Username SSH shared hosting
- `SSH_HOST`: Host shared hosting (misalnya: yourdomain.com)
- `REMOTE_TARGET`: Path ke direktori target di shared hosting (misalnya: /home/username/public_html)

### Setup di Shared Hosting

1. Pastikan shared hosting mendukung PHP 8.2 atau lebih baru
2. Buat database MySQL
3. Upload file `.env` dengan konfigurasi yang sesuai ke shared hosting
4. Set permission:

```bash
chmod -R 755 /path/to/your/laravel/root/directory
chmod -R 777 /path/to/your/laravel/root/directory/storage
chmod -R 777 /path/to/your/laravel/root/directory/bootstrap/cache
```

## Keamanan

1. Pastikan selalu menjaga kerahasiaan file `.env`
2. Jangan menyimpan informasi sensitif di repository
3. Gunakan HTTPS untuk produksi
4. Selalu update dependencies secara berkala
5. Batasi hak akses user sesuai role

## Kontak

Untuk pertanyaan atau bantuan lebih lanjut, hubungi:
[Nama Anda]
[Email Anda]
