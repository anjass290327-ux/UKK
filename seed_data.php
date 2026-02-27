<?php
// Manual Seed Data
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistem_peminjaman_alat", "root", "");
    
    echo "Starting manual seeding...\n";
    
    // Delete existing data
    $pdo->exec("DELETE FROM returns");
    $pdo->exec("DELETE FROM borrowings");
    $pdo->exec("DELETE FROM activity_logs");
    $pdo->exec("DELETE FROM tools");
    $pdo->exec("DELETE FROM categories");
    $pdo->exec("DELETE FROM users WHERE role != 'admin'");
    
    echo "✓ Old data cleared\n";
    
    // Check if admin exists
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin['total'] == 0) {
        // Insert Admin
        $pdo->exec("INSERT INTO users (name, email, password, phone, address, role, is_active, created_at, updated_at) VALUES ('Admin Sistem', 'admin@peminjaman.local', '" . password_hash('admin123', PASSWORD_BCRYPT) . "', '081234567890', 'Gedung Pusat', 'admin', 1, NOW(), NOW())");
    }
    
    // Insert Petugas
    $pdo->exec("INSERT INTO users (name, email, password, phone, address, role, is_active, created_at, updated_at) VALUES ('Petugas Penyimpanan', 'petugas@peminjaman.local', '" . password_hash('petugas123', PASSWORD_BCRYPT) . "', '081234567891', 'Gedung Penyimpanan', 'petugas', 1, NOW(), NOW())");
    
    // Insert Peminjam
    for ($i = 1; $i <= 5; $i++) {
        $pdo->exec("INSERT INTO users (name, email, password, phone, address, role, is_active, created_at, updated_at) VALUES ('Peminjam User $i', 'peminjam$i@peminjaman.local', '" . password_hash('peminjam123', PASSWORD_BCRYPT) . "', '08123456780" . $i . "', 'Jalan Pendidikan No. $i', 'peminjam', 1, NOW(), NOW())");
    }
    
    echo "✓ Users inserted\n";
    
    // Insert Categories
    $categories = [
        'Peralatan Laboratorium',
        'Peralatan Olahraga',
        'Peralatan Multimedia',
        'Peralatan Kantor',
        'Peralatan Elektronik'
    ];
    
    foreach ($categories as $cat) {
        $pdo->exec("INSERT INTO categories (name, description, created_at, updated_at) VALUES ('$cat', 'Alat-alat untuk $cat', NOW(), NOW())");
    }
    
    echo "✓ Categories inserted\n";
    
    // Insert Tools
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (1, 'Mikroskop', 'LAB001', 5, 5, 'sangat baik', 'Lab A', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (1, 'Bunsen Burner', 'LAB002', 10, 8, 'baik', 'Lab Kimia', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (2, 'Bola Voli', 'SPORT001', 12, 10, 'baik', 'Gudang Olahraga', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (2, 'Raket Badminton', 'SPORT002', 20, 18, 'baik', 'Gudang Olahraga', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (3, 'Proyektor LCD', 'MM001', 3, 2, 'baik', 'Ruang Multimedia', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (3, 'Screen Proyektor', 'MM002', 4, 4, 'sangat baik', 'Ruang Multimedia', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (4, 'Laminating Machine', 'OFF001', 2, 2, 'sangat baik', 'Ruang Kerja', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (5, 'Laptop', 'ELEC001', 8, 6, 'baik', 'Lab Komputer', 1, NOW(), NOW())");
    $pdo->exec("INSERT INTO tools (category_id, name, code, quantity, available_quantity, condition, location, is_active, created_at, updated_at) VALUES (5, 'Kamera DSLR', 'ELEC002', 3, 2, 'sangat baik', 'Ruang Media', 1, NOW(), NOW())");
    
    echo "✓ Tools inserted\n";
    
    echo "\n✅ Database seeding completed successfully!\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage();
    exit(1);
}
?>
