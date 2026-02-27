<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=sistem_peminjaman_alat', 'root', '');

echo "=== DATABASE CHECK ===\n\n";

// Check returns table
$result = $pdo->query('SELECT COUNT(*) as count FROM returns');
$data = $result->fetch(PDO::FETCH_ASSOC);
echo "Total returns: " . $data['count'] . "\n";

// Check borrowings table
$result = $pdo->query('SELECT COUNT(*) as count FROM borrowings');
$data = $result->fetch(PDO::FETCH_ASSOC);
echo "Total borrowings: " . $data['count'] . "\n";

// Check approved borrowings without return
$result = $pdo->query("SELECT COUNT(*) as count FROM borrowings WHERE status = 'approved'");
$data = $result->fetch(PDO::FETCH_ASSOC);
echo "Approved borrowings: " . $data['count'] . "\n";

// Show sample returns data
echo "\n=== SAMPLE RETURNS DATA ===\n";
$result = $pdo->query('SELECT * FROM returns LIMIT 5');
$returns = $result->fetchAll(PDO::FETCH_ASSOC);
if (count($returns) > 0) {
    foreach ($returns as $row) {
        echo "ID: {$row['id']}, Borrowing ID: {$row['borrowing_id']}, Return Date: {$row['return_date']}\n";
    }
} else {
    echo "No returns data found\n";
}

// Show sample borrowings data
echo "\n=== SAMPLE BORROWINGS DATA ===\n";
$result = $pdo->query('SELECT * FROM borrowings LIMIT 5');
$borrowings = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($borrowings as $row) {
    echo "ID: {$row['id']}, User: {$row['user_id']}, Tool: {$row['tool_id']}, Status: {$row['status']}\n";
}
?>
