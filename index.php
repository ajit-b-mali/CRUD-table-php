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
            <span class="navbar-brand mb-0 h1">CRUD Table</span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Products</h2>

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
                                    <tr>
                                        <td>1</td>
                                        <td>Laptop</td>
                                        <td>$899.99</td>
                                        <td>Electronics</td>
                                        <td>
                                            <a href="update.php?id=1" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Mouse</td>
                                        <td>$19.99</td>
                                        <td>Electronics</td>
                                        <td>
                                            <a href="update.php?id=2" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Office Chair</td>
                                        <td>$199.99</td>
                                        <td>Furniture</td>
                                        <td>
                                            <a href="update.php?id=3" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Notebook</td>
                                        <td>$5.99</td>
                                        <td>Stationery</td>
                                        <td>
                                            <a href="update.php?id=4" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Monitor</td>
                                        <td>$249.99</td>
                                        <td>Electronics</td>
                                        <td>
                                            <a href="update.php?id=5" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
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
        // chart.js code goes here
    </script>
</body>
</html>