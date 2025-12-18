<?php
require_once 'db.php';
// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            die("Error deleting product: " . htmlspecialchars($e->getMessage()));
        }
    } else {
        die("Product ID is required.");
    }
} else {
    die("Invalid request method.");
}