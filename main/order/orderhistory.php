<?php include_once '../include/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .table-container {
            
            max-width: 800px;
            margin: 0 auto;
        }
        .btn-export-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .btn-primary {
            background-color: #4d285b;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-right:250px;
        }
        .btn-primary:hover {
            background-color: #3d1e44;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #4d285b;
            color: #ffffff;
            font-size: 1.5rem;
            border-bottom: 1px solid #ddd;
        }
        .card-body {
            padding: 20px;
        }
        table {
            color: #333;
            border-collapse: separate;
            border-spacing: 0;
        }
        thead th {
            background-color: #4d285b;
            color: #ffffff;
            text-align: center;
            padding: 10px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        tbody td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar from header.php will be here -->

        <!-- Main Content -->
        <div class="col py-3">
            <div class="btn-export-container">
                <!-- Form to export data as CSV -->
                <form method="post" action="exportorderhistory.php">
                    <button type="submit" class="btn btn-primary">Export to CSV</button>
                </form>
            </div>
            <div class="table-container mt-5">
                <div class="card">
                    <div class="card-header text-center">
                        Order History
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Description</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Database connection
                                require_once "../dbc.php";
                                
                                // Fetch data from database
                                $result = mysqli_query($conn, "SELECT o.orderid, o.orderdescription, i.name as productname, o.orderdate, o.totalprice
                                                              FROM orders o
                                                              JOIN item i ON o.itemid = i.id");

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['orderid']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['orderdescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['productname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['orderdate']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['totalprice']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
<?php
// Include footer file
include_once '../include/footer.php';
?>
