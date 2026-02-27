# ✅ TESTING CHECKLIST - SISTEM PEMINJAMAN ALAT

## 🔧 Pre-Testing Setup

- [ ] Database sudah di-migrate
- [ ] Database sudah di-seed dengan data dummy
- [ ] Server berjalan tanpa error
- [ ] Akses halaman login berhasil
- [ ] CSS dan JavaScript loading dengan baik

---

## 🔐 Authentication Testing

### Login
- [ ] Login dengan Admin berhasil
- [ ] Login dengan Petugas berhasil
- [ ] Login dengan Peminjam berhasil
- [ ] Login dengan password salah menampilkan error
- [ ] Login dengan email tidak terdaftar menampilkan error
- [ ] Session dijaga setelah refresh halaman
- [ ] Redirect ke dashboard setelah login

### Register
- [ ] Register dengan data valid berhasil
- [ ] Register dengan email sudah terdaftar menampilkan error
- [ ] Register dengan password tidak cocok menampilkan error
- [ ] Password minimal 8 karakter divalidasi
- [ ] Auto login setelah register berhasil

### Logout
- [ ] Logout berhasil
- [ ] Redirect ke halaman login setelah logout
- [ ] Session dihapus setelah logout
- [ ] Activity log tercatat untuk logout

---

## 👥 User Management Testing (Admin Only)

### View User List
- [ ] Halaman user list dapat diakses
- [ ] Pagination bekerja dengan baik
- [ ] Tampil role user (Admin, Petugas, Peminjam)
- [ ] Tampil status user (Aktif, Nonaktif)

### Create User
- [ ] Form create user dapat dibuka
- [ ] Bisa create user dengan role Admin
- [ ] Bisa create user dengan role Petugas
- [ ] Bisa create user dengan role Peminjam
- [ ] Validasi email unique
- [ ] Password harus minimal 8 karakter
- [ ] Password confirm harus sesuai
- [ ] User baru bisa login dengan password yang dibuat

### Edit User
- [ ] Form edit user dapat dibuka
- [ ] Bisa mengubah nama user
- [ ] Bisa mengubah email user
- [ ] Bisa mengubah role user
- [ ] Bisa mengubah status user (aktif/nonaktif)
- [ ] User nonaktif tidak bisa login

### Delete User
- [ ] Tombol delete muncul
- [ ] Konfirmasi sebelum delete
- [ ] User berhasil dihapus (soft delete)
- [ ] Activity log tercatat untuk delete

---

## 📂 Category Management Testing (Admin Only)

### View Category List
- [ ] Halaman category list dapat diakses
- [ ] Pagination bekerja
- [ ] Tampil nama kategori
- [ ] Tampil deskripsi kategori

### Create Category
- [ ] Form create category dapat dibuka
- [ ] Bisa create kategori dengan nama unique
- [ ] Validasi nama tidak boleh kosong
- [ ] Deskripsi opsional
- [ ] Category berhasil ditambah ke list

### Edit Category
- [ ] Form edit category dapat dibuka
- [ ] Bisa mengubah nama kategori
- [ ] Bisa mengubah deskripsi kategori
- [ ] Validasi nama unique (except current)

### Delete Category
- [ ] Tombol delete muncul
- [ ] Konfirmasi sebelum delete
- [ ] Category berhasil dihapus

---

## 🔨 Tool Management Testing (Admin Only)

### View Tool List
- [ ] Halaman tool list dapat diakses
- [ ] Pagination bekerja
- [ ] Tampil semua kolom (kode, nama, kategori, jumlah, tersedia, kondisi)
- [ ] Status aktif/nonaktif ditampilkan

### Create Tool
- [ ] Form create tool dapat dibuka
- [ ] Pilih kategori dari dropdown
- [ ] Input kode alat (unique)
- [ ] Input nama alat
- [ ] Input deskripsi
- [ ] Input quantity
- [ ] Input available quantity
- [ ] Pilih kondisi alat
- [ ] Input lokasi alat (opsional)
- [ ] Input tanggal pembelian (opsional)
- [ ] Tool berhasil ditambahkan

### Edit Tool
- [ ] Form edit tool dapat dibuka
- [ ] Bisa mengubah kategori
- [ ] Bisa mengubah nama
- [ ] Bisa mengubah deskripsi
- [ ] Bisa mengubah quantity
- [ ] Bisa mengubah available quantity
- [ ] Bisa mengubah kondisi
- [ ] Bisa mengubah lokasi
- [ ] Bisa mengubah status (aktif/nonaktif)

### Delete Tool
- [ ] Tombol delete muncul
- [ ] Konfirmasi sebelum delete
- [ ] Tool berhasil dihapus

---

## 📦 Borrowing Management Testing

### Admin View
- [ ] Admin bisa melihat semua peminjaman
- [ ] Tampil user, alat, jumlah, tanggal, status
- [ ] Pagination bekerja

### Petugas View
- [ ] Petugas hanya melihat peminjaman
- [ ] Bisa melihat tab "Menunggu Persetujuan"
- [ ] Bisa melihat tab "Peminjaman Aktif"

### Peminjam View
- [ ] Peminjam hanya melihat peminjaman mereka sendiri
- [ ] Tampil alat yang sedang dipinjam

### Create Borrowing (Peminjam)
- [ ] Halaman create borrowing dapat diakses
- [ ] Dropdown alat hanya menampilkan alat aktif dengan stok > 0
- [ ] Dropdown menampilkan stok tersedia
- [ ] Bisa input quantity
- [ ] Bisa input due date (harus besok atau lebih)
- [ ] Bisa input catatan (opsional)
- [ ] Validasi quantity ≤ available quantity
- [ ] Borrowing berhasil dibuat dengan status PENDING
- [ ] Activity log tercatat

### Approve Borrowing (Admin/Petugas)
- [ ] Tombol approve muncul untuk PENDING
- [ ] Modal konfirmasi muncul
- [ ] Setelah approve:
  - [ ] Status berubah menjadi APPROVED
  - [ ] Stok berkurang
  - [ ] Activity log tercatat
  - [ ] Tombol approve hilang

### Reject Borrowing (Admin/Petugas)
- [ ] Tombol reject muncul untuk PENDING
- [ ] Modal konfirmasi muncul
- [ ] Setelah reject:
  - [ ] Status berubah menjadi REJECTED
  - [ ] Stok tetap sama
  - [ ] Activity log tercatat

---

## ↩️ Return Management Testing

### Peminjam View
- [ ] Halaman returns menampilkan alat yang sedang dipinjam
- [ ] Hanya alat dengan status APPROVED dan belum dikembalikan
- [ ] Tombol "Kembalikan" tersedia

### Create Return (Peminjam)
- [ ] Halaman return form dapat dibuka
- [ ] Tampil info peminjaman (alat, jumlah, tanggal, tenggat)
- [ ] Bisa input quantity returned (max = quantity peminjaman)
- [ ] Bisa pilih kondisi alat
- [ ] Bisa input catatan (opsional)
- [ ] Return berhasil dicatat
- [ ] Stok berkurang yang dikembalikan
- [ ] Status peminjaman berubah ke RETURNED jika semua dikembalikan
- [ ] Activity log tercatat

### Petugas View
- [ ] Petugas bisa melihat list pengembalian
- [ ] Tampil user, alat, jumlah dikembalikan, kondisi, waktu

---

## 📊 Dashboard Testing

### Admin Dashboard
- [ ] Tampil statistik: Total Users, Total Tools, Total Borrowings, Pending Borrowings
- [ ] Angka statistik akurat
- [ ] Activity log terbaru ditampilkan (max 10)
- [ ] Tampil nama user, aksi, deskripsi, waktu

### Petugas Dashboard
- [ ] Tampil Peminjaman Menunggu Persetujuan
- [ ] Tampil Peminjaman Aktif
- [ ] Bisa langsung approve/reject dari dashboard
- [ ] Tampil warning jika ada peminjaman terlambat

### Peminjam Dashboard
- [ ] Tampil info selamat datang
- [ ] Tampil alat tersedia (max 6)
- [ ] Bisa langsung pinjam dari dashboard
- [ ] Tampil peminjaman saya (max 10)
- [ ] Tampil status peminjaman dengan badge

---

## 📋 Activity Log Testing (Admin)

### View Log
- [ ] Halaman activity log dapat diakses
- [ ] Pagination bekerja
- [ ] Tampil: user, aksi, deskripsi, tabel, ip, waktu
- [ ] Filter by action berfungsi (jika ada)

### Log Entries
- [ ] CREATE dicatat saat buat user/kategori/alat
- [ ] UPDATE dicatat saat edit user/kategori/alat
- [ ] DELETE dicatat saat delete user/kategori/alat
- [ ] LOGIN dicatat saat login
- [ ] LOGOUT dicatat saat logout
- [ ] APPROVE dicatat saat approve peminjaman
- [ ] REJECT dicatat saat reject peminjaman
- [ ] RETURN dicatat saat return alat

### Export
- [ ] Tombol export CSV tersedia
- [ ] Export berhasil mengunduh file CSV
- [ ] File CSV berisi semua data log

---

## 🔍 General UI/UX Testing

### Layout & Navigation
- [ ] Navbar loading dengan baik
- [ ] Logo/brand name ditampilkan
- [ ] User dropdown berfungsi
- [ ] Sidebar navigation responsive
- [ ] Mobile menu toggle berfungsi

### Forms
- [ ] Form labels jelas
- [ ] Required field ditandai (*)
- [ ] Error messages informatif
- [ ] Success messages ditampilkan
- [ ] Tombol submit/batal responsive

### Tables
- [ ] Table header jelas
- [ ] Data tersusun rapi
- [ ] Action buttons accessible
- [ ] Hover effect jelas
- [ ] Pagination clear

### Responsiveness
- [ ] Desktop view sempurna
- [ ] Tablet view sempurna
- [ ] Mobile view sempurna
- [ ] Sidebar collapse di mobile
- [ ] Buttons readable di mobile

### Error Handling
- [ ] 403 error page muncul saat forbidden
- [ ] 404 error page muncul saat not found
- [ ] 500 error page muncul saat server error
- [ ] Error messages clear dan helpful

---

## 🔐 Security Testing

### Authentication & Authorization
- [ ] Non-admin tidak bisa akses user management
- [ ] Non-admin tidak bisa akses category management
- [ ] Non-admin tidak bisa akses tool management
- [ ] Peminjam hanya lihat peminjaman mereka
- [ ] Guest tidak bisa akses protected pages
- [ ] Session timeout berfungsi

### Input Validation
- [ ] SQL injection tidak bisa melalui form
- [ ] XSS attempts tidak bisa melalui form
- [ ] CSRF token ada di semua form
- [ ] Negative quantities ditolak
- [ ] Invalid dates ditolak

### Data Protection
- [ ] Password di-hash di database
- [ ] Soft delete mengurangi data (not permanent)
- [ ] Deleted users tidak bisa login
- [ ] IP tracking di activity log

---

## 📱 Mobile Testing

- [ ] Sidebar collapse di mobile
- [ ] Navigation accessible
- [ ] Forms readable
- [ ] Tables scrollable
- [ ] Buttons tidak overlap
- [ ] Text readable (font size)
- [ ] Images responsive

---

## ⚡ Performance Testing

- [ ] Pages load cepat (< 2 second)
- [ ] Pagination smooth
- [ ] Form submission responsive
- [ ] No console errors (JavaScript)
- [ ] All assets load properly
- [ ] Database queries optimized (eager loading)

---

## 🌐 Cross-Browser Testing

- [ ] Chrome: ✅
- [ ] Firefox: ✅
- [ ] Safari: ✅
- [ ] Edge: ✅
- [ ] Mobile Browser (Chrome): ✅

---

## 📝 Final Checklist

- [ ] Semua fitur telah ditest
- [ ] Tidak ada critical bugs
- [ ] Documentation lengkap
- [ ] Database backup tersedia
- [ ] Admin account credentials aman
- [ ] Production environment ready
- [ ] Users trained (if applicable)

---

**Testing Date**: _____________  
**Tested By**: _____________  
**Status**: ☐ PASSED  ☐ FAILED

**Notes**:
```
_____________________________________________
_____________________________________________
_____________________________________________
```

---

**Last Updated**: February 26, 2026
