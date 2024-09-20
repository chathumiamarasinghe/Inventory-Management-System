<?php include_once "../dbc.php"; ?>
<?php include_once '../include/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .table {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
            background: #e7d8f3; 
            color: #4d285b;
            border-radius: 8px;
            overflow: hidden;
            margin-left: left;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #c9b0d9; 
        }

        .table th {
            background-color: #d6c2e0; 
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f2e9f5; 
        }

        .btn-container {
            text-align: center;
            margin: 20px auto;
        }

        .btn-export {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4d285b; 
            border-radius: 50px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin-top: 10px;
        }

        h2 {
            color: #4d285b;
            text-align: center;
            margin-top: 20px;
        }

        
        @media (max-width: 768px) {
            .table {
                width: 100%;
                font-size: 14px;
            }

            .table th, .table td {
                padding: 8px;
            }

            .btn-export {
                padding: 8px 16px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .table {
                width: 100%;
                font-size: 12px;
            }

            .table th, .table td {
                padding: 6px;
            }

            .btn-export {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <!-- Items Table -->
    <div class="table-container">
        <h2 class="text-center" style="color: #4d285b;">Item List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Category Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT i.id, i.name AS item_name, i.quantity, i.price, i.date, c.name AS category_name
                    FROM item i
                    JOIN categories c ON i.categorie_id = c.id
                    ORDER BY i.id;";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["item_name"]; ?></td>
                                <td><?php echo $row["quantity"]; ?></td>
                                <td><?php echo $row["price"]; ?></td>
                                <td><?php echo $row["date"]; ?></td>
                                <td><?php echo $row["category_name"]; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">No items found</td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="exportcsv.php" class="btn-export"><i class="dwn">Export Items</i></a>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="table-container">
        <h2 class="text-center" style="color: #4d285b;">Category List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM categories ORDER BY id;";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="2">No categories found</td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="exportcategorycsv.php" class="btn-export"><i class="dwn">Export Categories</i></a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
