# 🚀 PANDUAN SETUP CEPAT

## Step 1: Persiapan

Pastikan XAMPP atau MySQL sudah berjalan!

```bash
# Buka terminal/CMD di folder project
cd c:\Users\yanto\UKKK
```

## Step 2: Install Dependencies

```bash
# Install PHP packages
composer install

# Install Node packages (opsional, untuk assets)
npm install
```

## Step 3: Setup Environment

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

## Step 4: Setup Database ⚠️ PENTING!

**PASTIKAN XAMPP MySQL SUDAH RUNNING!**

### Opsi A: Command Line (RECOMMENDED)

```bash
# Jalankan migration
php artisan migrate --force

# Jalankan seeder (untuk data dummy)
php artisan db:seed --force
```

### Opsi B: Menggunakan Batch File

```bash
# Double-click pada file ini
setup-database.bat
```

### Opsi C: Manual dengan phpMyAdmin

1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Buat database baru dengan nama: `sistem_peminjaman_alat`
3. Jalankan command migration: `php artisan migrate --force`
4. Jalankan seeder: `php artisan db:seed --force`

## Step 5: Jalankan Aplikasi

```bash
# Pilih salah satu:

# Opsi A: Laravel Development Server
php artisan serve
# Akses: http://localhost:8000

# Opsi B: XAMPP Apache
# Pastikan folder di c:\xampp\htdocs\UKKK
# Akses: http://localhost/UKKK/public
```

## ✅ Verifikasi Setup

Jika berhasil, Anda seharusnya bisa:

1. ✅ Mengakses aplikasi di browser
2. ✅ Melihat halaman login
3. ✅ Login dengan akun default

## 🔑 Akun Login Default

Setelah migration dan seeding, gunakan akun berikut:

### Admin (Akses Penuh)
```
Email: admin@peminjaman.local
Password: admin123
```

### Petugas (Monitor & Approve)
```
Email: petugas@peminjaman.local
Password: petugas123
```

### Peminjam (User Biasa)
```
Email: peminjam1@peminjaman.local
Password: peminjam123
(ada 5 akun peminjam: peminjam1 - peminjam5)
```

## ❌ Troubleshooting

### Error: "Unknown database 'sistem_peminjaman_alat'"

**Solusi:**
1. Pastikan MySQL service running di XAMPP
2. Jalankan ulang: `php artisan migrate --force`
3. Jika masih error, cek `.env` - pastikan DB_DATABASE=sistem_peminjaman_alat

### Error: "Call to undefined function bcrypt()"

**Solusi:**
```bash
composer dump-autoload
php artisan cache:clear
php artisan db:seed --force
```

### Halaman tidak ditemukan (404)

**Solusi:**
```bash
# Clear semua cache
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

### Port 8000 sudah digunakan

**Solusi:**
```bash
# Gunakan port berbeda
php artisan serve --port=8001
# Akses: http://localhost:8001
```

## 📱 Testing Aplikasi

1. **Login sebagai Admin**
   - Lihat Dashboard Admin
   - Coba buat kategori & alat baru
   - Lihat Activity Log

2. **Login sebagai Petugas**
   - Lihat Peminjaman Pending
   - Approve/Reject Peminjaman
   - Monitor Pengembalian

3. **Login sebagai Peminjam**
   - Lihat Daftar Alat
   - Ajukan Peminjaman
   - Kembalikan Alat

## 📝 Notes

- Semua password untuk akun default adalah: **123** (dengan prefix nama role)
  - Admin: `admin123`
  - Petugas: `petugas123`
  - Peminjam: `peminjam123`

- Database sudah berisi sample data:
  - 5 kategori alat
  - 12 alat dengan berbagai kondisi
  - 7 user (1 admin + 1 petugas + 5 peminjam)

- File migration dan seeder sudah otomatis membuat tabel dan data

## 🎯 Next Steps

Setelah setup berhasil, Anda bisa:

1. Eksplorasi fitur-fitur
2. Test flow peminjaman-pengembalian
3. Buat user baru
4. Tambah kategori dan alat
5. Lihat activity log

---

**Happy Coding! 🚀**

Jika ada pertanyaan, refer ke `README.md` atau `INSTALLATION.md`
