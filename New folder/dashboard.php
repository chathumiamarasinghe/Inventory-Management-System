<?php include_once 'C:\xampp\htdocs\Inventory web\Inventory-Management-System\New folder\include\header.php'; ?>
<?php
include_once 'dbc.php'; 

$sql = "SELECT COUNT(*) AS item_count FROM item"; 
$result = $conn->query($sql);
$item_count = 0;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $item_count = $row['item_count'];
}

$sql2 = "SELECT COUNT(*) AS user_count FROM user"; 
$result2 = $conn->query($sql2);
$user_count = 0;

if ($result2 && $result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $user_count = $row2['user_count'];
}

$sql3 = "SELECT c.name AS category_name, COUNT(i.id) AS product_count 
        FROM categories c
        LEFT JOIN item i ON c.id = i.categorie_id
        GROUP BY c.name";
$result3 = $conn->query($sql3);

$categories = [];
$product_counts = [];

if ($result3 && $result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
        $categories[] = $row3['category_name'];
        $product_counts[] = $row3['product_count'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <title>Bootstrap 5 Responsive Admin Dashboard</title>
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card-icon {
            font-size: 2.5rem;
            color: #4d285b;
            position: absolute;
            right: 15px;
            top: 15px;
            background-color: #f8f9fa;
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            text-align: left;
            margin-right: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-content h3 {
            color: #4d285b;
            margin-bottom: 0.5rem;
        }

        .card-content p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .card-body {
            display: flex;
            align-items: center;
            padding: 1rem;
            position: relative;
        }

        .chart-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        

        <!-- Page Content -->
        <div id="page-content-wrapper" class="container px-6">
            <div class="row g-3 my-2 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <a href="../item/viewitem.php" class="text-decoration-none text-dark card-wrapper">
                        <div class="card shadow-sm rounded border-0">
                            <div class="card-body">
                                <div class="card-content">
                                    <h3 class="fs-2"><?php echo $item_count; ?></h3>
                                    <p class="fs-5">Products</p>
                                </div>
                                <i class="fas fa-gift card-icon"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm rounded border-0">
                        <div class="card-body">
                            <div class="card-content">
                                <h3 class="fs-2"><?php echo $user_count; ?></h3>
                                <p class="fs-5">Users</p>
                            </div>
                            <i class="fas fa-user card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graph Container -->
            <div class="row chart-container">
                <div class="col-md-8 mx-auto py-5 px-5">
                    <div class="card shadow-sm rounded border-0">
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Number of Products',
                    data: <?php echo json_encode($product_counts); ?>,
                    backgroundColor: 'rgba(77, 40, 91, 0.2)',
                    borderColor: 'rgba(77, 40, 91, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    </script>
</body>
</html>
<?php include_once '../include/footer.php'; ?> 