<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT category, COUNT(*) as count FROM products GROUP BY category");
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Something went wrong.'
    ]);
}