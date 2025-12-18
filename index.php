<?php
    require_once 'config/db.php';

    // Business Logic: Fetch products
    $products = [];
    try {
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching products: " . htmlspecialchars($e->getMessage()));
    }

    // Include UI Components
    include 'includes/header.php';
    include 'includes/navbar.php';
?>

<!-- Handle Alerts -->
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Product added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2>Dashboard</h2>

            <div class="card mb-4">
                <div class="card-header">Product Categories Chart</div>
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
                                    <tr><td colspan="5" class="text-center">No products found.</td></tr>
                                <?php endif; ?>
                                <?php foreach ($products as $product): ?>
                                    <tr id="row-<?= $product['id'] ?>" data-id="<?= $product['id'] ?>">
                                        <td><?= htmlspecialchars($product['id']) ?></td>
                                        <td class="editable-cell" data-field="name"><?= htmlspecialchars($product['name']) ?></td>
                                        <td class="editable-cell" data-field="price">$<?= htmlspecialchars($product['price']) ?></td>
                                        <td class="editable-cell" data-field="category"><?= htmlspecialchars($product['category']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning edit-btn" onclick="editRow(<?= $product['id'] ?>)">Edit</button>
                                            <button class="btn btn-sm btn-success save-btn" style="display:none;" onclick="saveRow(<?= $product['id'] ?>)">Save</button>
                                            <button class="btn btn-sm btn-secondary cancel-btn" style="display:none;" onclick="cancelEdit(<?= $product['id'] ?>)">Cancel</button>
                                            <button class="btn btn-sm btn-danger delete-btn" onclick="deleteProduct(<?= $product['id'] ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                                <form action="includes/create.php" method="post">
                                    <tr>
                                        <td>Auto</td>
                                        <td><input type="text" name="name" class="form-control"></td>
                                        <td><input type="number" step="0.01" name="price" class="form-control"></td>
                                        <td><input type="text" name="category" class="form-control"></td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/uiHelpers.js"></script> <script src="assets/js/displayChart.js"></script>
<script src="assets/js/updateProducts.js"></script>
<script src="assets/js/deleteProducts.js"></script>

<script>
    function refreshChart() {
        fetch('includes/get_chart_data.php')
            .then(res => res.json())
            .then(newData => displayChart(newData));
    }
    refreshChart();
</script>

</body>
</html>