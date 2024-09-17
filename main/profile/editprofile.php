<?php
// Start output buffering
ob_start();

include_once '../include/header.php';
include_once '../dbc.php';

// Get user_id from URL parameter
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($user_id <= 0) {
    die('Invalid user ID.');
}


$sql = "SELECT id, username, password FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Error executing query: ' . $stmt->error);
}

$user = $result->fetch_assoc();

// Initialize variables for error messages
$current_password_error = $new_password_error = $confirm_password_error = '';
$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
    $new_username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Validate current password
    if (empty($current_password) || !password_verify($current_password, $user['password'])) {
        $current_password_error = 'Invalid current password.';
    }

    // Validate new password and confirm password
    if (empty($new_password)) {
        $new_password_error = 'New password is required.';
    } elseif ($new_password !== $confirm_password) {
        $confirm_password_error = 'Passwords do not match.';
    } elseif (strlen($new_password) < 8) {
        $new_password_error = 'New password must be at least 8 characters long.';
    }

    // If there are no errors, update the user details
    if (empty($current_password_error) && empty($new_password_error) && empty($confirm_password_error)) {
        $sql = "UPDATE user SET username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssi", $new_username, $hashed_password, $user_id);

        if ($stmt->execute()) {
            // Set a session variable or a flag to indicate a successful update
            $message = 'Update successful!';
            $messageClass = 'alert-success';
            $_SESSION['message'] = $message;
            $_SESSION['messageClass'] = $messageClass;
            // Redirect to profile.php with a message parameter
            header("Location: profile.php?id=" . urlencode($user_id));
            exit();
        } else {
            $message = 'Error updating profile: ' . $stmt->error;
            $messageClass = 'alert-danger';
        }

        $stmt->close();
    } else {
        $message = 'Please fix the errors below.';
        $messageClass = 'alert-danger';
    }
}

$conn->close();

// End output buffering and send output
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Edit Profile</title>
    <style>
        .btn {
            background-color: #4d285b;
            color: white;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
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
        .alert {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col py-3">
            <div class="container form-container">
                <div class="card">
                    <div class="card-header text-center">
                        Edit Profile
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert <?php echo htmlspecialchars($messageClass); ?>" role="alert">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <?php if (!empty($current_password_error)): ?>
                                    <div class="error-message"><?php echo htmlspecialchars($current_password_error); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <?php if (!empty($new_password_error)): ?>
                                    <div class="error-message"><?php echo htmlspecialchars($new_password_error); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                <?php if (!empty($confirm_password_error)): ?>
                                    <div class="error-message"><?php echo htmlspecialchars($confirm_password_error); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="btn-container text-center">
                                <button type="submit" class="btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once '../include/footer.php'; ?>
