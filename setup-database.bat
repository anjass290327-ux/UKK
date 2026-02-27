@echo off
REM Nama Database
set DB_NAME=sistem_peminjaman_alat
set DB_USER=root
set DB_PASS=

REM Path ke folder XAMPP
set XAMPP_PATH=C:\xampp

REM Buat database
echo Membuat database %DB_NAME%...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u %DB_USER% -p%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME%;" >nul 2>&1

if errorlevel 1 (
    echo Gagal membuat database. Pastikan XAMPP MySQL sudah berjalan!
    pause
    exit /b 1
)

echo Database %DB_NAME% berhasil dibuat!

REM Jalankan migration dan seeding
echo.
echo Menjalankan migration...
cd /d "%~dp0"
php artisan migrate --force
if errorlevel 1 (
    echo Gagal menjalankan migration!
    pause
    exit /b 1
)

echo.
echo Menjalankan database seeding...
php artisan db:seed --force
if errorlevel 1 (
    echo Gagal menjalankan seeding!
    pause
    exit /b 1
)

echo.
echo ==================================================
echo BERHASIL! Database dan tabel sudah dibuat.
echo ==================================================
echo.
echo Akun yang sudah dibuat:
echo   Admin:
echo     Email: admin@peminjaman.local
echo     Password: admin123
echo.
echo   Petugas:
echo     Email: petugas@peminjaman.local
echo     Password: petugas123
echo.
echo   Peminjam (5 akun):
echo     Email: peminjam1@peminjaman.local - peminjam5@peminjaman.local
echo     Password: peminjam123
echo.
pause
