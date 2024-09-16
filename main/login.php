<?php
include_once "dbc.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriendsInventory - Login</title>
    <link rel="icon" type="image/x-icon" href="image/favicon2.ico">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #4d285b; /* Preferred brand color */
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #4d285b; /* Preferred button color */
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #6e4d7c; /* Hover effect */
        }

        .alert-danger {
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #4d285b;
            text-decoration: none;
            font-weight: bold;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="loginpage.png" alt="Logo">
            <h1>FriendsInventory</h1>
        </div>
        <form action="logincheck.php" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
                <div class="alert alert-danger" role="alert">
                    Invalid username or password.
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="form-footer">
            <a href="#">Forgot password?</a>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
