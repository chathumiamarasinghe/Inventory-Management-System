<?php
include_once '../include/header.php';
include_once "../dbc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Supplies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .table-container {
            
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            max-width:600px;
            
        }
        .btn-container {
            margin-top: 50px;
            text-align: right;
            margin-right:220px;
        }
        .btn-primary {
            background-color: #4d285b;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #3d1e44;
        }
        h2 {
            color: #4d285b;
            margin-bottom: 30px;
        }
        table {
            color: #333333;
            border-collapse: separate;
            border-spacing: 0 15px;
        }
        th {
            background-color: #4d285b;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        td {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #dddddd;
            border-left: 1px solid #dddddd;
            border-right: 1px solid #dddddd;
            border-radius: 10px;
        }
        tr:last-child td {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>
</head>
<body>
    
<div class="container ">
    <div class="btn-container">
        <a href="addsupply.php" class="btn btn-primary">Add New Supply</a>
    </div>
    <div class="table-container mx-auto mt-1">
        <h2 class="text-center">Supplies List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Supply ID</th>
                    <th scope="col">Supply Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM supply");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['supplyid'] . "</td>";
                    echo "<td>" . $row['supplyname'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include_once '../include/footer.php'; ?>
