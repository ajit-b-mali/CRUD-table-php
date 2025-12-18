<?php
    /**
     * Main index file
     * Displays a CRUD table and integrates Chart.js for data visualization
     */
    require_once 'config/db.php';

    // fetch all products
    $products = [];
    try {
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching products: " . htmlspecialchars($e->getMessage()));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 30px;
        }
    </style>
    <title>CRUD table</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Product Management System</span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Products</h2>

                <div class="card mb-4">
                    <div class="card-header">
                        Product Categories Chart
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Product List</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No products found.</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr id="row-<?php echo $product['id']; ?>" data-id="<?php echo $product['id']; ?>">
                                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                                            <td class="editable-cell" data-field="name"><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td class="editable-cell" data-field="price">$<?php echo htmlspecialchars($product['price']); ?></td>
                                            <td class="editable-cell" data-field="category"><?php echo htmlspecialchars($product['category']); ?></td>
                                            <td>
                                    <!-- Edit functionality -->
                                                <button class="btn btn-sm btn-warning edit-btn" onclick="editRow(<?php echo $product['id']; ?>)">Edit</button>
                                                <button class="btn btn-sm btn-success save-btn" style="display:none;" onclick="saveRow(<?php echo $product['id']; ?>)">Save</button>
                                                <button class="btn btn-sm btn-secondary cancel-btn" style="display:none;" onclick="cancelEdit(<?php echo $product['id']; ?>)">Cancel</button>

                                    <!-- Delete functionality -->
                                                <!-- <button type="submit" form="deleteForm<?php echo $product['id']; ?>" class="btn btn-sm btn-danger delete-btn" onClick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                <form id="deleteForm<?php echo $product['id']; ?>" action="includes/delete.php" method="post" style="display:none;">
                                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                </form> -->
                                                <button class="btn btn-sm btn-danger delete-btn" 
                                                        onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Create functionality -->
                                    <form action="includes/create.php" method="post">
                                        <tr>
                                            <td>Auto</td>
                                            <td><input type="text" name="name" class="form-control" required></td>
                                            <td><input type="number" step="0.01" name="price" class="form-control" required></td>
                                            <td><input type="text" name="category" class="form-control" required></td>
                                            <td><button type="submit" class="btn btn-sm btn-success">Add</button></td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showMessage(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container');
            container.insertBefore(alertDiv, container.firstChild);
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    </script>
    <script src="assets/js/displayChart.js"></script>
    <script src="assets/js/updateProducts.js"></script>
    <script src="assets/js/deleteProducts.js"></script>
    <script>
        function refreshChart() {
            fetch('includes/get_chart_data.php')
                .then(response => response.json())
                .then(newData => {
                    displayChart(newData); // This will trigger the destroy and rebuild
                });
        }
        refreshChart();
    </script>
</body>
</html>
