<?php
include_once "../dbc.php";
include_once '../include/header.php';

$message = '';
$messageClass = '';
$formSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formSubmitted = true;

    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $roleid = isset($_POST['roleid']) ? intval($_POST['roleid']) : 0;

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = 'All fields are required';
        $messageClass = 'alert-danger';
    } elseif (strlen($username) < 5) {
        $message = 'Username must be at least 5 characters long';
        $messageClass = 'alert-danger';
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $message = 'Username can only contain letters and numbers';
        $messageClass = 'alert-danger';
    } elseif ($password !== $confirm_password) {
        $message = 'Passwords do not match';
        $messageClass = 'alert-danger';
    } elseif (strlen($password) < 8) {
        $message = 'Password must be at least 8 characters long';
        $messageClass = 'alert-danger';
    } else {
        
        $sql = "SELECT username FROM user WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $message = 'Username already exists';
                $messageClass = 'alert-danger';
            } else {
                
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                
                $sql = "INSERT INTO user (username, password, roleid) VALUES (?, ?, ?)";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ssi", $username, $hashed_password, $roleid);
                    if ($stmt->execute()) {
                        $message = 'User registered successfully';
                        $messageClass = 'alert-success';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "../Dashboard/dashboard.php";
                                }, 3000);
                              </script>';
                    } else {
                        $message = 'Error: ' . $stmt->error;
                        $messageClass = 'alert-danger';
                    }
                } else {
                    $message = 'Error preparing statement: ' . $conn->error;
                    $messageClass = 'alert-danger';
                }
            }

            $stmt->close(); 
        } else {
            $message = 'Error preparing statement: ' . $conn->error;
            $messageClass = 'alert-danger';
        }
    }
}


$roles = $conn->query("SELECT roleid, rolename FROM roles");

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-color: #f8f9fa;
            padding: 20px;
            margin-left: 250px;
        }
        .card {
            width: 100%;
            max-width: 600px;
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
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .form-container {
                margin-left: 0;
                padding: 10px;
            }
            .card {
                max-width: 100%;
                border-radius: 5px;
            }
            .card-header {
                border-radius: 5px 5px 0 0;
            }
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 5px;
            }
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
                        Register User
                    </div>
                    <div class="card-body">
                        <!-- Alert Message -->
                        <?php if (!empty($message)): ?>
                            <div class="alert <?php echo $messageClass; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form id="registerForm" action="" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="roleid" class="form-label">Role</label>
                                <select id="roleid" name="roleid" class="form-control" required>
                                    <?php while ($role = $roles->fetch_assoc()): ?>
                                        <option value="<?php echo $role['roleid']; ?>"><?php echo $role['rolename']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="btn-container text-center">
                                <button type="submit" class="btn btn-primary">Register</button>
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
