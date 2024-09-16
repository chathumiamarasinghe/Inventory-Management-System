<?php 

?>
<?php
include_once '../include/header.php'; 
include_once '../dbc.php';?>
 

<?php

$sql = "SELECT COUNT(*) AS item_count FROM item"; 
$result = $conn->query($sql);
$item_count = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $item_count = $row['item_count'];
}

$sql2 = "SELECT COUNT(*) AS user_count FROM user"; 
$result2 = $conn->query($sql2);
$user_count = 0;

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $user_count = $row2['user_count'];
}

$sql3 = "SELECT i.name AS product_name, i.quantity AS product_quantity 
        FROM item i";
$result3 = $conn->query($sql3);

$product_names = [];
$product_quantities = [];

if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
        $product_names[] = $row3['product_name'];
        $product_quantities[] = $row3['product_quantity'];
    }
}

$sql4 = "SELECT c.name AS category_name, COUNT(i.id) AS product_count 
        FROM categories c
        LEFT JOIN item i ON c.id = i.categorie_id
        GROUP BY c.name";
$result4 = $conn->query($sql4);

$category_names = [];
$category_counts = [];

if ($result4->num_rows > 0) {
    while ($row4 = $result4->fetch_assoc()) {
        $category_names[] = $row4['category_name'];
        $category_counts[] = $row4['product_count'];
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
            margin-top: 100px;
            margin-left: 80px;
        }

        .chart-card {
            padding: 0px;
            margin-top: 40px;
            margin-right: 5px;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .chart-card {
                margin-top: 20px;
                margin-left: 0;
                margin-right: 0;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
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
                    <?php if ($user_role == 1): ?>
                        <a href="../auth/userdisplay.php" class="text-decoration-none text-dark card-wrapper">
                    <?php endif; ?>
                    <div class="card shadow-sm rounded border-0">
                        <div class="card-body">
                            <div class="card-content">
                                <h3 class="fs-2"><?php echo $user_count; ?></h3>
                                <p class="fs-5">Users</p>
                            </div>
                            <i class="fas fa-user card-icon"></i>
                        </div>
                    </div>
                    <?php if ($user_role == 1): ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Graph Containers -->
            <div class="row chart-container">
                <!-- Product Quantity Chart -->
                <div class="col-md-6">
                    <div class="card shadow-sm rounded border-0 chart-card">
                        <div class="card-body">
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Category Product Count Chart -->
                <div class="col-md-6">
                    <div class="card shadow-sm rounded border-0 chart-card">
                        <div class="card-body">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctxProduct = document.getElementById('productChart').getContext('2d');
            var productChart = new Chart(ctxProduct, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($product_names); ?>,
                    datasets: [{
                        label: 'Quantity',
                        data: <?php echo json_encode($product_quantities); ?>,
                        backgroundColor: 'rgba(77, 40, 91, 0.2)',
                        borderColor: 'rgba(77, 40, 91, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Product Names'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Quantity'
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                }
            });

            var ctxCategory = document.getElementById('categoryChart').getContext('2d');
            var categoryChart = new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($category_names); ?>,
                    datasets: [{
                        label: 'Number of Products',
                        data: <?php echo json_encode($category_counts); ?>,
                        backgroundColor: 'rgba(77, 40, 91, 0.2)',
                        borderColor: 'rgba(77, 40, 91, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Category Names'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Products'
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php include_once '../include/footer.php'; ?>
