#!/usr/bin/env python3
import mysql.connector
import sys
import os

# Configuration
db_config = {
    'host': '127.0.0.1',
    'user': 'root',
    'password': '',
    'port': 3306
}

db_name = 'sistem_peminjaman_alat'

try:
    # Connect to MySQL
    print("Terhubung ke MySQL Server...")
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    
    # Create database
    print(f"Membuat database {db_name}...")
    cursor.execute(f"CREATE DATABASE IF NOT EXISTS `{db_name}`")
    conn.commit()
    
    print(f"✓ Database {db_name} berhasil dibuat!")
    cursor.close()
    conn.close()
    
    # Now run Laravel migrations
    print("\nMenjalankan Laravel migrations...")
    os.system('cd ' + os.path.dirname(os.path.abspath(__file__)) + ' && php artisan migrate --force && php artisan db:seed --force')
    
    print("\n" + "="*50)
    print("BERHASIL! Database dan tabel sudah dibuat.")
    print("="*50)
    print("\nAkun Login Default:")
    print("\n  Admin:")
    print("    Email: admin@peminjaman.local")
    print("    Password: admin123")
    print("\n  Petugas:")
    print("    Email: petugas@peminjaman.local")
    print("    Password: petugas123")
    print("\n  Peminjam (5 akun):")
    print("    Email: peminjam1@peminjaman.local - peminjam5@peminjaman.local")
    print("    Password: peminjam123")
    
except mysql.connector.Error as err:
    print(f"✗ Error: {err}")
    sys.exit(1)
except Exception as e:
    print(f"✗ Unexpected error: {e}")
    sys.exit(1)
