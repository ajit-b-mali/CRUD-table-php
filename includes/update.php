<?php
/**
 * Update product
 * Handles both regular form submissions and AJAX requests for in-place editing
 */
require_once '../config/db.php';

// Handle AJAX request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['id']) || !isset($data['name']) || !isset($data['price']) || !isset($data['category'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id = $data['id'];
$name = $data['name'];
$price = $data['price'];
$category = $data['category'];

try {
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category = ? WHERE id = ?");
    $stmt->execute([$name, $price, $category, $id]);
    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;