<?php
/**
 * Main index file
 * Displays a CRUD table and integrates Chart.js for data visualization
 */
require_once 'db.php';

// fetch all products
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching products: " . htmlspecialchars($e->getMessage()));
}

$chartData = [];
try {
    $stmt = $pdo->query("SELECT category, COUNT(*) as count FROM products GROUP BY category");
    $chartData = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching chart data: " . htmlspecialchars($e->getMessage()));
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
                                                <button type="submit" form="deleteForm<?php echo $product['id']; ?>" class="btn btn-sm btn-danger delete-btn" onClick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                <form id="deleteForm<?php echo $product['id']; ?>" action="delete.php" method="post" style="display:none;">
                                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Create functionality -->
                                    <form action="create.php" method="post">
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
        // Store original values for cancel functionality
        let originalValues = {};

        function editRow(id) {
            const row = document.getElementById('row-' + id);
            const cells = row.querySelectorAll('.editable-cell');
            
            // Store original values
            originalValues[id] = {};
            
            cells.forEach(cell => {
                const field = cell.dataset.field;
                let value = cell.textContent.trim();
                
                // Remove $ sign from price
                if (field === 'price') {
                    value = value.replace('$', '');
                }
                
                originalValues[id][field] = value;
                
                // Replace cell content with input field
                if (field === 'price') {
                    cell.innerHTML = `<input type="number" step="0.01" class="form-control form-control-sm" value="${value}" data-field="${field}">`;
                } else {
                    cell.innerHTML = `<input type="text" class="form-control form-control-sm" value="${value}" data-field="${field}">`;
                }
            });
            
            // Toggle buttons
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline-block';
            row.querySelector('.cancel-btn').style.display = 'inline-block';
            row.querySelector('.delete-btn').style.display = 'none';
        }

        function cancelEdit(id) {
            const row = document.getElementById('row-' + id);
            const cells = row.querySelectorAll('.editable-cell');
            
            // Restore original values
            cells.forEach(cell => {
                const field = cell.dataset.field;
                const value = originalValues[id][field];
                
                if (field === 'price') {
                    cell.textContent = '$' + value;
                } else {
                    cell.textContent = value;
                }
            });
            
            // Toggle buttons back
            row.querySelector('.edit-btn').style.display = 'inline-block';
            row.querySelector('.save-btn').style.display = 'none';
            row.querySelector('.cancel-btn').style.display = 'none';
            row.querySelector('.delete-btn').style.display = 'inline-block';
            
            delete originalValues[id];
        }

        function saveRow(id) {
            const row = document.getElementById('row-' + id);
            const inputs = row.querySelectorAll('.editable-cell input');
            
            // Collect updated values
            const data = { id: id };
            inputs.forEach(input => {
                data[input.dataset.field] = input.value;
            });
            
            // Send AJAX request
            fetch('update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Update cells with new values
                    inputs.forEach(input => {
                        const cell = input.parentElement;
                        const field = input.dataset.field;
                        const value = input.value;
                        
                        if (field === 'price') {
                            cell.textContent = '$' + value;
                        } else {
                            cell.textContent = value;
                        }
                    });
                    
                    // Toggle buttons back
                    row.querySelector('.edit-btn').style.display = 'inline-block';
                    row.querySelector('.save-btn').style.display = 'none';
                    row.querySelector('.cancel-btn').style.display = 'none';
                    row.querySelector('.delete-btn').style.display = 'inline-block';
                    
                    delete originalValues[id];
                    
                    // Show success message
                    showMessage('Product updated successfully!', 'success');
                } else {
                    showMessage('Error updating product: ' + result.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Error updating product. Please try again.', 'danger');
            });
        }

        function showMessage(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container');
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    </script>
    <script src="displayChart.js"></script>
    <script>
        const chartData = <?php echo json_encode($chartData); ?>;
        displayChart(chartData);
    </script>
</body>
</html>
