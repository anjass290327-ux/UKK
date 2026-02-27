<?php
// Check database data
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistem_peminjaman_alat", "root", "");
    
    echo "=== DATABASE CHECK ===\n\n";
    
    // Check users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Users: " . $users['total'] . " records\n";
    
    // Check categories
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categories");
    $cats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Categories: " . $cats['total'] . " records\n";
    
    // Check tools
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tools");
    $tools = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Tools: " . $tools['total'] . " records\n";
    
    // Check borrowings
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM borrowings");
    $borrows = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Borrowings: " . $borrows['total'] . " records\n";
    
    // Check returns
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM returns");
    $returns = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Returns: " . $returns['total'] . " records\n";
    
    echo "\n=== USERS DATA ===\n";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['id'] . " | " . $row['name'] . " | " . $row['email'] . " | " . $row['role'] . "\n";
    }
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
