<?php
/**
 * Database configuration file
 * Uses PDO for secure database connection
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'digitaledu_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // Create a new PDO instance
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS
    );

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      // Enable exceptions for errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);              // Disable emulation of prepared statements i.e. use native prepared statements if supported

} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}