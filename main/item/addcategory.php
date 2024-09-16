<?php include_once '../include/header.php'; ?>
<?php include_once "../dbc.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center; 
            align-items: flex-start; 
            min-height: 80vh; 
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
        .form-label {
            font-weight: bold; 
            color: #4d285b; 
        }
        .btn-container {
            margin-top: 20px; 
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
                        Add New Category
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category Name" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="script.js"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];

    $sql = "INSERT INTO categories (name) VALUES ('$category')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record created successfully'); window.location.href='viewcategory.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
?>
</body>
</html>
<?php include_once '../include/footer.php'; ?>
