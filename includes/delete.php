<?php
// 1. Set headers and error reporting
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

// 2. Get and decode raw JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 3. Simple Validation
$id = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : false;

if ($id === false || $id <= 0) {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid or missing Product ID.'
    ]);
    exit;
}

try {
    // 4. Execute Delete
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error occurred during deletion.'
    ]);
}