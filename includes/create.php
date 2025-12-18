<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize Inputs (Remove extra spaces/tags)
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category = trim($_POST['category'] ?? '');

    // 2. Simple Validation Rules
    $errors = [];

    if (strlen($name) < 2) {
        $errors[] = "Product name must be at least 2 characters.";
    }

    if (!is_numeric($price) || (float)$price <= 0) {
        $errors[] = "Price must be a valid positive number.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    }

    // 3. Process if no errors
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, category) VALUES (:name, :price, :category)");
            $stmt->execute([
                ':name'     => htmlspecialchars($name), // Prevent XSS
                ':price'    => (float)$price,
                ':category' => htmlspecialchars($category)
            ]);
            
            header("Location: ../index.php?success=added");
            exit();
        } catch (PDOException $e) {
            die("Database Error. Please try again later.");
        }
    } else {
        // Convert the array of errors into a single string
        $errorMsg = urlencode(implode(" ", $errors));
        header("Location: ../index.php?error=" . $errorMsg);
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}