<?php
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT category, COUNT(*) as count FROM products GROUP BY category");
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    die("Error fetching chart data: " . htmlspecialchars($e->getMessage()));
    echo json_encode([]);
}