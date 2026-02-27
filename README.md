# 📦 Sistem Peminjaman Alat

Aplikasi web modern untuk manajemen peminjaman dan pengembalian alat dengan dashboard interaktif dan fitur lengkap.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Laravel](https://img.shields.io/badge/Laravel-8.x-red.svg)

## 🎯 Deskripsi Project

Sistem Peminjaman Alat adalah aplikasi web yang dirancang untuk memudahkan pengelolaan peminjaman dan pengembalian alat di institusi pendidikan atau organisasi. Aplikasi ini memiliki sistem role-based access control dengan tiga level user (Admin, Petugas, dan Peminjam).

## ✨ Fitur Utama

### 👨‍💼 Admin
- Kelola pengguna sistem
- Kelola kategori alat
- Kelola data alat
- Persetujuan/penolakan peminjaman
- Monitor pengembalian alat
- Lihat log aktivitas lengkap
- Export laporan (CSV)
- Dashboard dengan statistik

### 🔧 Petugas
- Menyetujui permintaan peminjaman
- Monitor pengembalian alat
- Melihat status peminjaman
- Dashboard monitoring real-time

### 👤 Peminjam
- Registrasi dan login
- Lihat daftar alat tersedia
- Ajukan peminjaman
- Kembalikan alat
- Lihat history peminjaman
- Dashboard personal

## 🛠️ Teknologi Stack

- **Backend**: Laravel 8
- **Database**: MySQL 5.7+
- **Frontend**: Blade Template + Bootstrap 5
- **Auth**: Laravel Built-in Authentication
- **Icons**: Bootstrap Icons
- **Validation**: Laravel Form Validation

## 📋 Prerequisites

Sebelum menginstall, pastikan Anda sudah memiliki:

- PHP >= 8.0
- Composer
- MySQL 5.7 atau MariaDB
- XAMPP / Laragon / WAMP (untuk development)
- Git (optional)

## 🚀 Quickstart

### 1. Setup Database

**Pastikan XAMPP MySQL sudah running!**

```bash
cd c:\Users\yanto\UKKK

# Generate APP_KEY
php artisan key:generate

# Buat database dan jalankan migration + seeding
php artisan migrate --force
php artisan db:seed --force
```

### 2. Jalankan Server

**Opsi A: Laravel Built-in Server**
```bash
php artisan serve
# Akses: http://localhost:8000
```

**Opsi B: XAMPP Apache**
```bash
# Buat folder di xampp/htdocs atau symlink
# Akses: http://localhost/UKKK/public
```

### 3. Login dengan Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@peminjaman.local | admin123 |
| Petugas | petugas@peminjaman.local | petugas123 |
| Peminjam | peminjam1@peminjaman.local | peminjam123 |

## 📁 Struktur Folder

```
UKKK/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controllers untuk setiap fitur
│   │   └── Middleware/       # Middleware (AdminMiddleware)
│   └── Models/               # Eloquent Models
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheet
│   └── js/                   # JavaScript
├── routes/
│   └── web.php               # Route definitions
├── storage/                  # File storage
├── .env                      # Environment configuration
└── artisan                   # Laravel CLI
```

## 🔐 Database Schema

### Relationships

```
User (1) ---> (Many) Borrowing
User (1) ---> (Many) Return
User (1) ---> (Many) ActivityLog

Category (1) ---> (Many) Tool
Tool (1) ---> (Many) Borrowing

Borrowing (1) ---> (One) Return
```

### Tabel Utama

#### users
```sql
id, name, email, password, phone, address, 
role (admin|petugas|peminjam), is_active, timestamps, soft_deletes
```

#### categories
```sql
id, name, description, timestamps, soft_deletes
```

#### tools
```sql
id, category_id, name, code, quantity, available_quantity, 
condition (sangat baik|baik|sedang|rusak), location, purchase_date, 
is_active, timestamps, soft_deletes
```

#### borrowings
```sql
id, user_id, tool_id, quantity, borrow_date, due_date, 
approved_by, approved_at, status (pending|approved|rejected|returned), 
notes, timestamps, soft_deletes
```

#### returns
```sql
id, borrowing_id, return_date, quantity_returned, 
condition, notes, received_by, timestamps, soft_deletes
```

#### activity_logs
```sql
id, user_id, action, description, ip_address, user_agent, 
table_name, record_id, timestamps
```

## 🔄 Workflow Peminjaman

```
1. Peminjam ajukan peminjaman
          ↓
2. Status: PENDING
          ↓
3. Petugas review → Setujui/Tolak
          ↓
   APPROVED (Stok berkurang)    REJECTED
          ↓
4. Peminjam kembalikan alat
          ↓
5. Status: RETURNED (Stok bertambah)
```

## 🎨 UI/UX Highlights

- ✅ Responsive Design (Mobile, Tablet, Desktop)
- ✅ Modern Gradient Colors
- ✅ Smooth Animations
- ✅ Interactive Tables
- ✅ Status Badges
- ✅ Bootstrap Icons Integration
- ✅ Dark Color Scheme Ready

## 🛡️ Security Features

1. **CSRF Protection** - Built-in Laravel CSRF tokens
2. **SQL Injection Prevention** - Query Builder & Prepared Statements
3. **Password Security** - Bcrypt hashing
4. **Authorization** - Role-based middleware
5. **Soft Deletes** - Data preservation
6. **Activity Logging** - Track semua perubahan data
7. **Input Validation** - Server-side validation

## 📊 Key Features Detail

### Activity Logging
- Automatic logging untuk: CREATE, UPDATE, DELETE, LOGIN, LOGOUT, APPROVE, REJECT, RETURN
- IP address tracking
- User agent recording
- Export ke CSV untuk audit trail

### Stock Management
- Real-time stock tracking
- Available quantity vs total quantity
- Automatic stock decrement/increment
- Condition tracking (baik, rusak, dll)

### Status Management
- Peminjaman: pending → approved/rejected → returned
- Kondisi alat: sangat baik, baik, sedang, rusak
- User status: aktif/nonaktif

## 🐛 Troubleshooting

### Error "Unknown database"
```bash
# Pastikan MySQL running, lalu buat database
php artisan migrate --force
```

### Error "Permission denied"
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows: Run cmd as Administrator
icacls "storage" /grant:r "%username%":F /t
```

### Views tidak tampil
```bash
# Clear cache
php artisan cache:clear
php artisan view:clear
```

## 📝 Lisensi

MIT License - Feel free to use this project for personal or commercial purposes.

## 👨‍💻 Author

Developed with ❤️ for educational purposes.

**Version**: 1.0.0  
**Release Date**: February 26, 2026

## 🤝 Contributing

Contributions welcome! Please fork repository dan buat pull request.

---

**Happy Borrowing! 📚**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
