<?php
include_once "../dbc.php";
include_once '../include/header.php';


$sql = "SELECT u.id, u.username, r.rolename FROM user u JOIN roles r ON u.roleid = r.roleid";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #4d285b;
        }

        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            margin-left: 250px;
        }

        .table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #4d285b;
            color: #ffffff;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
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
            .table th, .table td {
                padding: 10px;
            }

            .button-container {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .table th, .table td {
                padding: 8px;
            }

            .button-container a {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="table-container">
    
    <?php
    if (isset($_GET['msg'])) {
        $message = '';
        switch ($_GET['msg']) {
            case 'UserDeleted':
                $message = "User deleted successfully.";
                break;
            case 'NoID':
                $message = "No user ID provided.";
                break;
            case 'CannotDeleteAdmin':
                $message = "Admins cannot be deleted.";
                break;
            default:
                $message = "An unknown error occurred.";
        }
        echo "<div class='alert alert-info text-center'>" . htmlspecialchars($message) . "</div>";
    }
    ?>

    <div class="button-container">
        <a href="register.php" class="btn btn-success">New Register</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $deleteButton = $row['rolename'] !== 'Admin' ? "<a href='deleteuser.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'><button type='button' class='btn btn-danger'>Delete</button></a>" : "<button type='button' class='btn btn-secondary' disabled>Cannot Delete</button>";
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rolename']) . "</td>";
                    echo "<td>$deleteButton</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>