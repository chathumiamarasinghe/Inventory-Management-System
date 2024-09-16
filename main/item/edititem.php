<?php
include_once "../dbc.php";
include_once '../include/header.php'; 


$message = '';
$messageClass = '';
$redirectScript = '';
$new_quantity = '';
$formSubmitted = false;

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    
    $sql = "SELECT * FROM item WHERE id = ?";
    
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $item_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
            $new_quantity = $item['quantity']; 
        } else {
            $redirectScript = "<script>alert('Item not found.'); window.location.href='viewitems.php';</script>";
        }
        
        $stmt->close();
    } else {
        $redirectScript = "<script>alert('Error preparing statement: " . $conn->error . "'); window.location.href='viewitems.php';</script>";
    }
} else {
    $redirectScript = "<script>alert('No item ID provided.'); window.location.href='viewitems.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $formSubmitted = true;
    $item_id = $_POST['item_id']; 
    $name = $_POST['item_name'];
    $quantity = $_POST['item_quantity'];
    $price = $_POST['item_price'];
    $date = $_POST['item_date'];
    $category = $_POST['category'];

    
    $sql = "UPDATE item SET name = ?, quantity = ?, price = ?, date = ?, categorie_id = ? WHERE id = ?";

    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sidsii", $name, $quantity, $price, $date, $category, $item_id); 
        if ($stmt->execute()) {
            $message = 'Record updated successfully';
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
        $message = 'Error: ' . $conn->error;
        $messageClass = 'alert-danger';
    }
}


$categories = $conn->query("SELECT id, name FROM categories");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="edititem.css">
    <style>
        
        .form-container {
            display: flex;
            justify-content: center; 
            align-items: flex-start;
            background-color: #f8f9fa; 
            padding: 20px;
        }
        .card {
            width: 100%;
            max-width: 600px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            border: 1px solid #4d285b; 
            margin: 0 auto;
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
            margin-top: 10px; 
        }
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
                        Update Product
                    </div>
                    <div class="card-body">
                        <span id="form-message" class="alert <?php echo htmlspecialchars($messageClass); ?>" style="display:block;"><?php echo htmlspecialchars($message); ?></span>
                        <form id="productForm" action="" method="post">
                            <!-- Hidden field for item ID -->
                            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id); ?>">
                            <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemName" name="item_name" placeholder="e.g., Laptop" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="itemQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="itemQuantity" name="item_quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
                                <span id="quantity-error" class="error-message"></span>
                            </div>
                            <div class="mb-3">
                                <label for="itemPrice" class="form-label">Price</label>
                                <input type="number" class="form-control" id="itemPrice" name="item_price" step="0.01" placeholder="e.g., 1000" value="<?php echo htmlspecialchars($item['price']); ?>" required>
                                <span id="price-error" class="error-message"></span>
                            </div>
                            <div class="mb-3">
                                <label for="itemDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="itemDate" name="item_date" value="<?php echo htmlspecialchars($item['date']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" name="category" onchange="updateCategoryID()" required>
                                    <option value="">Select a category</option>
                                    <?php
                                    // Populate categories from the database
                                    while ($row = $categories->fetch_assoc()) {
                                        $selected = $row['id'] == $item['categorie_id'] ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($row['id']) . "\" $selected>" . htmlspecialchars($row['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <label id="categoryIDLabel">Category ID: <?php echo htmlspecialchars($item['categorie_id']); ?></label>
                                <input type="hidden" id="categoryID" name="categoryID" value="<?php echo htmlspecialchars($item['categorie_id']); ?>">
                            </div>
                            <div class="btn-container text-center">
                                <button type="submit" class="btn btn-primary">Update Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to dynamically update the category ID
    function updateCategoryID() {
        var categorySelect = document.getElementById('category');
        var categoryIDLabel = document.getElementById('categoryIDLabel');
        var categoryIDInput = document.getElementById('categoryID');
        var selectedOption = categorySelect.options[categorySelect.selectedIndex];
        categoryIDLabel.textContent = 'Category ID: ' + selectedOption.value;
        categoryIDInput.value = selectedOption.value;
    }
</script>
<?php echo $redirectScript; ?>
</body>
</html>
<?php include_once '../include/footer.php'; ?>
