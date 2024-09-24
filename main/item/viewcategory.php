<?php include_once "../dbc.php"; ?>
<?php include_once '../include/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        main {
            background-color: antiquewhite;
        }

        .table-container {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 15px;
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

        .popup {
            position: absolute;
            display: none;
            background-color: #d6c2e0;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 200px;
            border-radius: 10px;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 5px;
        }

        .popup strong {
            color: #333;
        }

        .category-name {
            position: relative;
            cursor: pointer;
        }

        .category-name:hover .popup {
            display: block;
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
            .table-container {
                margin-left: 0;
            }

            .table {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .table-container {
                padding: 0 10px;
                margin-left: 0;
            }

            .table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<?php $user_role = isset($_SESSION['roleid']) ? $_SESSION['roleid'] : null; ?>

<div class="table-container">
    <?php if ($user_role == 1): ?>
        <div class="button-container">
            <a href="addcategory.php" class="btn btn-success my-3">Add Category</a>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>View</th>
                <?php if ($user_role == 1): ?>
                    
                    <th>Update</th>
                    <th>Delete</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT c.id, c.name, GROUP_CONCAT(i.name SEPARATOR ', ') as items
                    FROM categories c
                    LEFT JOIN item i ON i.categorie_id = c.id
                    GROUP BY c.id, c.name
                    ORDER BY c.id;";
            $result = mysqli_query($conn, $sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td class="category-name">
                            <?php echo htmlspecialchars($row["name"]); ?>
                            <div class="popup">
                                <strong>Items:</strong><br>
                                <?php echo htmlspecialchars($row["items"]) ?: "No items available"; ?>
                            </div>
                        </td>
                        <td>
                            <a href="itemimage.php?categorie_id=<?php echo urlencode($row['id']); ?>">
                                <button type="button" class="btn btn-success">View</button>
                            </a>
                        </td>
                        <?php if ($user_role == 1): ?>
                            <td><a href="editcategory.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-secondary">Update</button></a></td>
                            <td><a href="deletecategory.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="<?php echo $user_role == 1 ? '5' : '2'; ?>">No categories found</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<?php include_once '../include/footer.php'; ?>

</body>
</html>
