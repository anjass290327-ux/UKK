# Sistem Peminjaman Alat

Aplikasi web untuk manajemen peminjaman dan pengembalian alat dengan fitur lengkap.

## Fitur Utama

### Untuk Admin
- ✅ Login/Logout
- ✅ CRUD User (Admin, Petugas, Peminjam)
- ✅ CRUD Kategori Alat
- ✅ CRUD Alat
- ✅ Kelola Peminjaman
- ✅ Kelola Pengembalian
- ✅ Log Aktivitas (Export CSV)
- ✅ Dashboard Analytics

### Untuk Petugas
- ✅ Login/Logout
- ✅ Menyetujui/Menolak Peminjaman
- ✅ Memantau Pengembalian Alat
- ✅ Melihat Status Peminjaman
- ✅ Dashboard Monitoring

### Untuk Peminjam
- ✅ Login/Logout
- ✅ Melihat Daftar Alat Tersedia
- ✅ Mengajukan Peminjaman
- ✅ Mengembalikan Alat
- ✅ Melihat History Peminjaman
- ✅ Dashboard Peminjaman Saya

## Struktur Database

### Tabel Users
- id, name, email, password, phone, address, role, is_active, timestamps, soft_deletes

### Tabel Categories
- id, name, description, timestamps, soft_deletes

### Tabel Tools
- id, category_id, name, code, quantity, available_quantity, condition, location, purchase_date, is_active, timestamps, soft_deletes

### Tabel Borrowings
- id, user_id, tool_id, quantity, borrow_date, due_date, approved_by, approved_at, status, notes, timestamps, soft_deletes

### Tabel Returns
- id, borrowing_id, return_date, quantity_returned, condition, notes, received_by, timestamps, soft_deletes

### Tabel Activity Logs
- id, user_id, action, description, ip_address, user_agent, table_name, record_id, timestamps

## Requirement

- PHP 8.0+
- Laravel 8+
- MySQL 5.7+
- Composer
- Node.js (untuk asset compilation)

## Installation

1. **Clone/Extract Project**
   ```bash
   cd c:\xampp\htdocs\UKKK
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   - Copy `.env.example` ke `.env`
   - Generate app key: `php artisan key:generate`
   - Konfigurasi database di `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=sistem_peminjaman_alat
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Setup Database**
   
   **Opsi A: Menggunakan Migration (Recommended)**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

   **Opsi B: Menggunakan Batch File**
   ```bash
   setup-database.bat
   ```

5. **Compile Assets**
   ```bash
   npm run dev
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   
   atau jika menggunakan Apache di XAMPP:
   - Pastikan project di `C:\xampp\htdocs\UKKK`
   - Akses: `http://localhost/UKKK/public`

## Akun Default

### Admin
- Email: `admin@peminjaman.local`
- Password: `admin123`

### Petugas
- Email: `petugas@peminjaman.local`
- Password: `petugas123`

### Peminjam (5 Akun)
- Email: `peminjam1@peminjaman.local` - `peminjam5@peminjaman.local`
- Password: `peminjam123`

## Teknologi

- **Framework**: Laravel 8
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Blade Templates
- **Icons**: Bootstrap Icons
- **Authentication**: Laravel Built-in Auth

## File Structure

```
app/
  ├── Http/
  │   ├── Controllers/
  │   │   ├── AuthController.php
  │   │   ├── DashboardController.php
  │   │   ├── UserController.php
  │   │   ├── CategoryController.php
  │   │   ├── ToolController.php
  │   │   ├── BorrowingController.php
  │   │   ├── ReturnController.php
  │   │   └── ActivityLogController.php
  │   └── Middleware/
  │       └── AdminMiddleware.php
  └── Models/
      ├── User.php
      ├── Category.php
      ├── Tool.php
      ├── Borrowing.php
      ├── ReturnItem.php
      └── ActivityLog.php

database/
  ├── migrations/
  └── seeders/
      └── DatabaseSeeder.php

resources/views/
  ├── auth/
  │   ├── login.blade.php
  │   └── register.blade.php
  ├── dashboard/
  │   ├── admin.blade.php
  │   ├── petugas.blade.php
  │   └── peminjam.blade.php
  ├── users/
  ├── categories/
  ├── tools/
  ├── borrowings/
  ├── returns/
  ├── activity-logs/
  └── layout.blade.php

routes/
  └── web.php
```

## Fitur Keamanan

1. CSRF Protection
2. SQL Injection Prevention (Prepared Statements)
3. Password Hashing (Bcrypt)
4. Role-Based Access Control (RBAC)
5. Soft Deletes untuk data safety
6. Activity Logging

## Troubleshooting

### Database Connection Error
- Pastikan XAMPP MySQL sudah running
- Check `.env` database configuration
- Verify database name exists

### Permission Denied Error
- Give write permission to `storage/` dan `bootstrap/cache/`
- Linux/Mac: `chmod -R 775 storage bootstrap/cache`
- Windows: Right-click folder > Properties > Security

### Asset Not Found
- Run: `php artisan storage:link`
- Clear cache: `php artisan cache:clear`

## Development Notes

- Semua form validation sudah implemented
- Activity logging otomatis untuk setiap action penting
- Responsive design dengan Bootstrap 5
- Dark mode support (via CSS variables)

## Support

Untuk pertanyaan atau issues, silakan buat issue di repository atau hubungi developer.

---

**Created**: February 26, 2026
**Version**: 1.0.0
**License**: MIT
