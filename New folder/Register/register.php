<?php include_once "../dbc.php"; ?>

<?php
$error_username = '';
$error_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } elseif ($password !== $confirm_password) {
        $error_password = 'Passwords do not match!';
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if username already exists
        $checkusernameSql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $checkusernameStmt = $conn->prepare($checkusernameSql);
        $checkusernameStmt->bind_param("s", $username);
        $checkusernameStmt->execute();
        $checkusernameStmt->bind_result($usernameCount);
        $checkusernameStmt->fetch();
        $checkusernameStmt->close();

        if ($usernameCount > 0) {
            $error_username = 'This username is already taken!';
            echo "<script>alert('This username is already taken!');</script>";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!');</script>";
                echo "<script>window.location.href = '../Login/login.php';</script>";
            } else {
                echo "<script>alert('Registration unsuccessful!');</script>";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css" />
</head>
<body>
<section class="background-radial-gradient ">
    <div class="container px-5 py-5 px-md-5 text-center text-lg-start my-5 bootom-0">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    Join Us Today <br />
                    <span style="color: hsl(218, 81%, 75%)">Create Your Account</span>
                </h1>
                <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                    Fill the details below to create a new account. If you already have an account, you can log in instead.
                </p>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                <div class="card m-5 px-4 py-5" style="width:500px">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group mb-4">
                                <input type="text" class="form-control" name="username" required>
                                <label for="inputusername">Username</label>
                            </div>

                            <div class="form-group mb-4">
                                <input type="email" class="form-control" name="email" required>
                                <label for="inputemail">Email Address</label>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" class="form-control" name="password" required>
                                <label for="inputpassword">Password</label>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" class="form-control" name="confirm_password" required>
                                <label for="inputconfirmpassword">Confirm Password</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn custom-signin-btn mb-4 me-4">Sign Up</button>
                            </div>

                            <div class="text-center d-flex justify-content-center align-items-center">
                                <p class="mb-0 me-2">Already have an account?</p>
                                <a href="../Login/login.php" class="btn custom-signin-btn mb-2">Sign In</a>
                            </div>

                            <div class="text-center">
                                <p>or sign in with:</p>
                                <a href="https://www.facebook.com" class="btn btn-link btn-floating mx-1" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.google.com" class="btn btn-link btn-floating mx-1" target="_blank" aria-label="Google">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="https://twitter.com" class="btn btn-link btn-floating mx-1" target="_blank" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://github.com" class="btn btn-link btn-floating mx-1" target="_blank" aria-label="GitHub">
                                    <i class="fab fa-github"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
