-- Create database
CREATE DATABASE IF NOT EXISTS digitaledu_db;
USE digitaledu_db;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO products
    (name, price, category)
VALUES
    ('Laptop', 899.99, 'Electronics'),
    ('Mouse', 19.99, 'Electronics'),
    ('Keyboard', 49.99, 'Electronics'),
    ('Office Chair', 199.99, 'Furniture'),
    ('Desk', 299.99, 'Furniture'),
    ('Notebook', 5.99, 'Stationery'),
    ('Pen Set', 12.99, 'Stationery'),
    ('Monitor', 249.99, 'Electronics'),
    ('Bookshelf', 149.99, 'Furniture'),
    ('Headphones', 79.99, 'Electronics'),
    ('USB Cable', 9.99, 'Electronics'),
    ('Desk Lamp', 39.99, 'Furniture'),
    ('Webcam', 59.99, 'Electronics'),
    ('Plant Pot', 29.99, 'Home Decor'),
    ('Wall Clock', 44.99, 'Home Decor');