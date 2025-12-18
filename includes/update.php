<?php
// 1. Set headers
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

// 2. Capture raw JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 3. Simple Validation & Sanitization
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

// Clean the inputs
$id       = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : false;
$name     = isset($data['name']) ? trim($data['name']) : '';
$price    = isset($data['price']) ? filter_var($data['price'], FILTER_VALIDATE_FLOAT) : false;
$category = isset($data['category']) ? trim($data['category']) : '';

// 4. Logic Checks
if ($id === false || $id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid Product ID.']);
    exit;
}

if (empty($name) || strlen($name) < 2) {
    echo json_encode(['success' => false, 'message' => 'Name must be at least 2 characters.']);
    exit;
}

if ($price === false || $price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Price must be a positive number.']);
    exit;
}

if (empty($category)) {
    echo json_encode(['success' => false, 'message' => 'Category cannot be empty.']);
    exit;
}

// 5. Database Execution
try {
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category = ? WHERE id = ?");
    $stmt->execute([
        htmlspecialchars($name),
        $price, 
        htmlspecialchars($category),
        $id
    ]);

    echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
}