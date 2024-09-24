<?php include_once "../dbc.php"; ?>
<?php include_once '../include/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        main {
            background-color: antiquewhite;
            align-items: center;
        }
        .container{
            margin-left: 250px;
        }

        .table-container {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 15px;
            padding-top: 10px;
            margin-left: 250px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .table th {
            background-color: #d6c2e0;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            margin-right: 20px;
        }

        .button-container a {
            text-decoration: none;
            color: white;
            background-color: #4d285b;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: #3d1e44;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            .table th, .table td {
                padding: 8px;
            }

            .button-container a {
                padding: 8px 16px;
                font-size: 14px;
            }
            .table-container{
                margin-left: 0px;
            }
            #searchForm {
                width: 100%;
                margin-bottom: 10px;
            }
            .container{
                margin-left: 50px;
                padding-left: 150px;
            }
            .add-product-btn {
        margin-left: 50px; /* Adjust as necessary for medium screens */
    }
        }

        @media (max-width: 480px) {
            .table-container {
                padding: 0 10px;
            }
          

            .table {
                font-size: 12px;
            }
            .table-container{
                margin-left: 0px
                ;
            }

            .table th, .table td {
                padding: 6px;
            }

            .button-container a {
                padding: 6px 12px;
                font-size: 12px;
            }

            .button-container {
                justify-content: center;
            }
            .container{
                margin-left: 10px;
                margin-right: 10px;
                
                justify-content: center;
            }
            .btn
            #searchForm {
                size: 20px;
        width: 100%;
    }

    #searchInput {
        width: 20px;
    }
              .form-control{
                width: 10px;
              }

             
       
    }
              
           
        }
    </style>
</head>

<body>
<div class="container" style="margin-top: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <form id="searchForm" action="" method="get" class="d-flex me-3">
                <input class="form-control" type="search" name="search" id="searchInput" placeholder="Search items" aria-label="Search" oninput="filterResults()" value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
            </form>

            <?php if ($user_role == 1): // Only show for admin users ?>
            <a href="additem.php" class="btn add-product-btn" style="margin-left:450px; background-color: #4d285b; color: white;">Add Product</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$user_role = isset($_SESSION['roleid']) ? $_SESSION['roleid'] : null;
?>

<div class="table-container">
    <table border="1" class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date</th>
            <th>Category Name</th>
            <?php if ($user_role == 1): ?>
            <th>Update</th>
            <th>Delete</th>
            <?php endif; ?>
        </tr>

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
                    <tr class="item-row">
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["item_name"]; ?></td>
                        <td><?php echo $row["quantity"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["category_name"]; ?></td>
                        <?php if ($user_role == 1): ?>
                        <td><a href="edititem.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-secondary">Update</button></a></td>
                        <td><a href="deleteitem.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8">No items found</td>
                </tr>
                <?php
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<script>
function filterResults() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.item-row');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => cell.innerText.toLowerCase().includes(searchInput));
        row.style.display = match ? '' : 'none';
    });
}
</script>

</body>
</html>
<?php include_once '../include/footer.php'; ?>
