<?php
include_once '../include/header.php';
include_once "../dbc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplyid = $_POST['supplyid'];

    
    $result = mysqli_query($conn, "SELECT supplyid FROM supply WHERE supplyid = '$supplyid'");
    if (mysqli_num_rows($result) > 0) {
        
        $supply_description = $_POST['supply_description'];
        $productname = $_POST['productname'];
        $quantity = $_POST['quantity'];

        
        $result = mysqli_query($conn, "SELECT id FROM item WHERE name = '$productname'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $productid = $row['id'];

            
            $sql2 = "INSERT INTO supplydetails (supplyid, itemid, supply_description, quantity) 
                     VALUES ('$supplyid', '$productid', '$supply_description', '$quantity')";
            if (mysqli_query($conn, $sql2)) {
                
                $sql3 = "UPDATE item SET quantity = quantity + $quantity WHERE id = '$productid'";
                if (mysqli_query($conn, $sql3)) {
                    echo "<script>alert('Supply saved successfully!'); window.location.href='../item/viewitem.php';</script>";
                } else {
                    echo "<script>alert('Error updating item quantity: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Error inserting into supplydetails: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            
            echo "<script>alert('Product does not exist in the database. Please select a valid product.');</script>";
        }
    } else {
        
        echo "<script>alert('Supplier does not exist in the database. Please select a valid supplier.');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 40vh;
            
        }
        .card {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            border: 1px solid #4d285b;
        }
        .card-header {
            background-color: #4d285b;
            color: white;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #4d285b;
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
        .form-label {
            font-weight: bold;
            color: #4d285b;
        }
        .btn-container {
            margin-top: 20px;
        }
        .btn-add-container {
            margin-bottom: 20px;
            text-align: right;
            margin-right: 250px;
            
        }
        .btn-secondary{
            background-color: #4d285b;
           
        }
        
    </style>
    <script>
        function validateForm() {
            var supplyInput = document.getElementById("supplyid");
            var supplyList = document.getElementById("supply").options;
            var supplyFound = false;

            for (var i = 0; i < supplyList.length; i++) {
                if (supplyInput.value === supplyList[i].value) {
                    supplyFound = true;
                    break;
                }
            }

            if (!supplyFound) {
                alert("Supplier does not exist in the database. Please select a valid supplier.");
                return false;
            }

            var productInput = document.getElementById("productname");
            var productList = document.getElementById("products").options;
            var productFound = false;

            for (var i = 0; i < productList.length; i++) {
                if (productInput.value === productList[i].value) {
                    productFound = true;
                    break;
                }
            }

            if (!productFound) {
               alert("Product does not exist in the database. Please select a valid product.");
               window.location.href = '../suppy/suppy.php'; 
               return false; 
    }

            return true;
        }
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar from header.php will be here -->

        <!-- Main Content -->
        <div class="col py-3">
            <div class="btn-add-container">
                <a href="addsupply.php" class="btn btn-secondary">Add New Supply</a>
                <a href="viewsupply.php" class="btn btn-secondary">View Supplies</a>
            </div>
            <div class="container form-container">
                <div class="card">
                    <div class="card-header text-center">
                        Add Supply Details
                    </div>
                    <div class="card-body">
                        <form action="" method="post" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="supplyid" class="form-label">Select Existing Supply</label>
                                <input list="supply" class="form-control" id="supplyid" name="supplyid" placeholder="Enter or Select Supply" required>
                                <datalist id="supply">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM supply");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['supplyid'] . "'>" . $row['supplyname'] . "</option>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="supply_description" class="form-label">Supply Description</label>
                                <textarea class="form-control" id="supply_description" name="supply_description" placeholder="Enter Supply Description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productname" class="form-label">Product Name</label>
                                <input list="products" class="form-control" id="productname" name="productname" placeholder="Enter or Select Product" required>
                                <datalist id="products">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM item");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['name'] . "'>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="btn-container text-center">
                                <button type="submit" class="btn btn-primary">Save Supply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

<?php include_once '../include/footer.php'; ?>
</body>
</html>
