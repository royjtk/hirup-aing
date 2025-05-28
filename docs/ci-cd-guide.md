# Membuat CI/CD Pipeline dengan GitHub Actions ke Shared Hosting

Dokumen ini berisi langkah-langkah untuk membuat CI/CD pipeline dari GitHub ke shared hosting menggunakan GitHub Actions.

## Prasyarat

- Akun GitHub
- Akun Shared Hosting yang mendukung SSH
- Akses SSH ke shared hosting
- Repository GitHub yang berisi project Laravel

## Langkah-langkah Setup

### 1. Generate SSH Key Pair

Pertama, kita perlu membuat SSH key pair untuk menghubungkan GitHub Actions dengan shared hosting:

```bash
ssh-keygen -t rsa -b 4096 -C "your_email@example.com" -f github-actions
```

Perintah ini akan menghasilkan dua file:
- `github-actions` (private key)
- `github-actions.pub` (public key)

### 2. Tambahkan Public Key ke Shared Hosting

Upload public key ke shared hosting dengan menambahkannya ke file `~/.ssh/authorized_keys`:

```bash
cat github-actions.pub >> ~/.ssh/authorized_keys
```

Jika folder atau file belum ada, buat terlebih dahulu:

```bash
mkdir -p ~/.ssh
touch ~/.ssh/authorized_keys
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
```

### 3. Tambahkan Private Key ke GitHub Secrets

1. Buka repository GitHub Anda
2. Klik tab "Settings"
3. Klik "Secrets and variables" > "Actions" di sidebar
4. Klik "New repository secret"
5. Tambahkan secrets berikut:
   - `SSH_PRIVATE_KEY`: Isi dengan konten file private key (github-actions)
   - `SSH_USER`: Username SSH shared hosting
   - `SSH_HOST`: Host shared hosting (misalnya: yourdomain.com)
   - `REMOTE_TARGET`: Path ke direktori target di shared hosting (misalnya: /home/username/public_html)

### 4. Buat Workflow File GitHub Actions

Buat file `.github/workflows/deploy.yml` di repository Anda:

```yaml
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

### 5. Setup di Shared Hosting

1. Buat database MySQL di shared hosting
2. Upload file `.env` dengan konfigurasi yang sesuai ke shared hosting
3. Set permission:

```bash
chmod -R 755 /path/to/your/laravel/root/directory
chmod -R 777 /path/to/your/laravel/root/directory/storage
chmod -R 777 /path/to/your/laravel/root/directory/bootstrap/cache
```

### 6. Test Pipeline

Setelah semua setup selesai, push perubahan ke branch main GitHub repository Anda untuk memicu pipeline:

```bash
git add .
git commit -m "Setup CI/CD pipeline"
git push origin main
```

## Troubleshooting

### Masalah SSH Connection

Jika terjadi masalah koneksi SSH, pastikan:
- Public key telah ditambahkan dengan benar ke authorized_keys
- Permission file dan folder .ssh sudah benar
- Shared hosting mendukung koneksi SSH

### Masalah Rsync

Jika terjadi masalah dengan rsync, pastikan:
- Rsync terinstal di shared hosting
- Path target benar dan memiliki permission yang cukup

### Masalah Database

Jika terjadi masalah dengan database, pastikan:
- Kredensial database di file .env benar
- Database telah dibuat di shared hosting

## Kesimpulan

Dengan setup ini, setiap kali Anda push ke branch main, GitHub Actions akan otomatis:
1. Menginstal dependensi PHP dan Node.js
2. Membangun aset frontend
3. Deploy kode ke shared hosting
4. Menjalankan migrasi database
5. Mengoptimasi aplikasi

Ini memungkinkan workflow pengembangan yang lebih efisien dan deployment yang otomatis.
