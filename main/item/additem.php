<?php include_once "../dbc.php"; ?>
<?php include_once '../include/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="additem.css">
    <style>
        .form-container {
            
            display: flex;
            justify-content: center; 
            align-items: flex-start; 
            
            background-color: #f8f9fa;
            margin-top: 50px; 
            
        }

        .card {
            width: 100%;
            max-width: 500px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
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

        .btn-container {
            margin-top: 20px;
        }

        
      


        /* Medium screens (tablets, 768px and up) */
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar from header.php will be here -->
    
        <!-- Main Content -->
        <div class="col py-3">
            <div class="container form-container">
                <div class="card">
                    <div class="card-header text-center">
                        Add New Product
                    </div>
                    <div class="card-body">
                        <!-- Message span -->
                        <span id="form-message" class="alert"></span>
                        <form id="productForm" action="" method="post"  enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="itemname" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemname" name="itemname" placeholder="e.g., Laptop" required>
                            </div>
                           
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                <span id="quantity-error" class="error-message"></span>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="e.g., 1000" required>
                                <span id="price-error" class="error-message"></span>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" name="category" onchange="updateCategoryID()" class="form-select" required>
                                    <option value="">Select a category</option>
                                    <?php
                                    
                                    $result = $conn->query("SELECT id, name FROM categories");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value=\"" . htmlspecialchars($row['id']) . "\">" . htmlspecialchars($row['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="categoryID" name="categoryID">
                                
                                
                            </div>
                            <div class="mb-3">
        <label for="img" class="form-label">Product Image</label>
        <input type="file" class="form-control" id="img" name="img" required>
    </div>

                           
                            <div class="btn-container text-center">
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
<script src="additem.js"></script>

<?php
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemname = $_POST['itemname'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $categoryID = isset($_POST['categoryID']) ? $_POST['categoryID'] : '';

    // Check if the file was uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] != UPLOAD_ERR_NO_FILE) {
        $img = $_FILES['img'];

        // Validate image
        if ($img['error'] == UPLOAD_ERR_OK) {
            $fileMimeType = mime_content_type($img['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($fileMimeType, $allowedTypes)) {
                $message = 'Error: Only JPG, PNG, and GIF files are allowed.';
                $messageClass = 'alert-danger';
            } else {
                // Move uploaded file to the 'img' directory
                $targetDir = "img/";
                $imgName = basename($img['name']);
                $targetFile = $targetDir . $imgName;

                if (move_uploaded_file($img['tmp_name'], $targetFile)) {
                    // Proceed with database insertion
                    $stmt = $conn->prepare("INSERT INTO item (name, quantity, price, date, categorie_id, imgpath) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sidsis", $itemname, $quantity, $price, $date, $categoryID, $targetFile);

                    if ($stmt->execute()) {
                        $message = 'New record created successfully';
                        $messageClass = 'alert-success';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "../item/viewitem.php";
                                }, 1000);
                              </script>';
                    } else {
                        $message = 'Error: ' . $stmt->error;
                        $messageClass = 'alert-danger';
                    }
                    $stmt->close();
                } else {
                    $message = 'Error: Failed to upload image.';
                    $messageClass = 'alert-danger';
                }
            }
        } else {
            $message = 'Error: An error occurred during the image upload.';
            $messageClass = 'alert-danger';
        }
    } else {
        $message = 'Error: Please upload an image.';
        $messageClass = 'alert-danger';
    }

    mysqli_close($conn);
}

if ($message) {
    echo "<script>
        document.getElementById('form-message').style.display = 'block';
        document.getElementById('form-message').innerHTML = " . json_encode($message) . ";
        document.getElementById('form-message').className += ' " . $messageClass . "';
    </script>";
}
?>





</body>
</html>
<?php include_once '../include/footer.php'; ?>
