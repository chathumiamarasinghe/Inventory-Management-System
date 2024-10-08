<?php include_once "../dbc.php"; ?>

<?php
$error_email = '';
$error_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email)) {
        $error_email = 'Email is required!';
    }

    if (empty($password)) {
        $error_password = 'Password is required!';
    }

    if (empty($error_email) && empty($error_password)) {
        $sql = "SELECT password FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
               
                $redirectScript = "<script>alert('Login successful!'); window.location.href='../dashboard.php';</script>";
                echo $redirectScript;
            } else {
                $error_password = 'Invalid credentials!';
            }
        } else {
            $error_email = 'No account found with that email!';
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css" />
</head>
<body>
<section class="background-radial-gradient">
    <div class="container px-5 py-5 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    Welcome Back <br />
                    <span style="color: hsl(218, 81%, 75%)">Login to Your Account</span>
                </h1>
                <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                    Please enter your Email and password to log in. If you don't have an account, you can sign up.
                </p>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                <div id="radius-shape-1" class="position-absolute shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                <div class="card m-5 px-4 py-5" style="width: 500px;">
                    <div class="card-body">
                        <form action="" method="post">

                            <div class="form-group mb-4">
                                <input type="email" class="form-control" name="email" required>
                                <label for="inputemail">Email</label>
                                <?php if ($error_email): ?>
                                    <div class="text-danger mt-2"><?php echo $error_email; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" class="form-control" name="password" required>
                                <label for="inputpassword">Password</label>
                                <?php if ($error_password): ?>
                                    <div class="text-danger mt-2"><?php echo $error_password; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn custom-signin-btn mb-4 me-4" name="submit">Login</button>
                            </div>

                            <div class="text-center d-flex justify-content-center align-items-center">
                                <p class="mb-0 me-2">Don't have an account?</p>
                                <a href="../Register/register.php" class="btn custom-signin-btn mb-2">
                                    Sign Up
                                </a>
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

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous">
</script>
</body>
</html>
