<?php
include_once "../dbc.php";
include_once '../include/header.php'; 


$message = '';
$messageClass = '';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Prepare the SQL query to get the category details
    $sql = "SELECT * FROM categories WHERE id = ?";
    
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $category_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
        } else {
            echo "<script>
                alert('Category not found.');
                window.location.href='viewcategory.php';
            </script>";
            exit();
        }
        
        $stmt->close();
    } else {
        echo "<script>
            alert('Error preparing statement: " . $conn->error . "');
            window.location.href='viewcategory.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('No category ID provided.');
        window.location.href='viewcategory.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $category_id = $_POST['category_id']; 
    $name = $_POST['category_name'];

    
    $sql = "UPDATE categories SET name = ? WHERE id = ?";

    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $name, $category_id); 
        if ($stmt->execute()) {
            $message = 'Category updated successfully';
            $messageClass = 'alert-success';

            
            echo "<script>
                alert('Category updated successfully.');
                var nextAction = confirm('Do you want to view all categories? Click OK to view categories, or Cancel to stay on this page.');
                if (nextAction) {
                    window.location.href = 'viewcategory.php';
                }
            </script>";
        } else {
            $message = 'Error: ' . $stmt->error;
            $messageClass = 'alert-danger';
        }
        $stmt->close();
    } else {
        $message = 'Error: Invalid category ID';
        $messageClass = 'alert-danger';
    }
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        Edit Category
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert <?php echo htmlspecialchars($messageClass); ?>" role="alert">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>
                        <form id="categoryForm" action="" method="post">
                            <!-- Hidden field for category ID -->
                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="e.g., Electronics" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                            </div>
                            <div class="btn-container text-center">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once '../include/footer.php'; ?>