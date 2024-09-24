<?php include_once "../dbc.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <form action="" method="post">
        <div class="row">
            <div class="col">
                <label for="itemname">Item Name</label>
                <input type="text" name="itemname" class="form-control" required>
            </div>
            <div class="col">
                <label for="quantity">Quantity</label>
                <input type="text" name="quantity" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="categorieid">Categorie ID</label>
            <input type="text" name="categorieid" class="form-control" required>
        </div>
        <div>
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $itemname = $_POST['itemname'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $date = $_POST['date'];
        $categorieid = $_POST['categorieid'];

        // SQL query
        $sql = "INSERT INTO item (name, quantity, price, date, categorie_id) 
                VALUES ('$itemname', '$quantity', '$price', '$date', '$categorieid')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
</body>
</html>
