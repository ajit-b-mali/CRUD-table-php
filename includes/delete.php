<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

// Get raw JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = filter_var($data['id'] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}