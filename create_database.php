<?php
// Script untuk membuat database
try {
    $host = '127.0.0.1';
    $user = 'root';
    $password = '';
    $database = 'sistem_peminjaman_alat';

    // Connect ke MySQL tanpa database
    $pdo = new PDO("mysql:host=$host", $user, $password);
    
    echo "✓ Terkoneksi ke MySQL\n";
    
    // Drop database jika ada
    $pdo->exec("DROP DATABASE IF EXISTS `$database`");
    echo "✓ Database lama dihapus (jika ada)\n";
    
    // Create database
    $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database '$database' berhasil dibuat\n";
    
    // Connect ke database baru
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    echo "✓ Terkoneksi ke database '$database'\n";
    
    echo "\n✅ DATABASE SIAP! Jalankan:\n";
    echo "   php artisan migrate --force\n";
    echo "   php artisan db:seed --force\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
