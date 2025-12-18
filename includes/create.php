<?php
require_once '../config/db.php';

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $category = $_POST['category'] ?? '';

    if ($name && $price && $category) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, category) VALUES (:name, :price, :category)");
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':category' => $category
            ]);
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            die("Error adding product: " . htmlspecialchars($e->getMessage()));
        }
    } else {
        die("All fields are required.");
    }
} else {
    die("Invalid request method.");
}