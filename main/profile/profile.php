<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../include/header.php'; 
include_once '../dbc.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$url_user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($url_user_id <= 0) {
    die('Invalid user ID.');
}

$sql = "SELECT id, username, password FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("i", $url_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Error executing query: ' . $stmt->error);
}

$user = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <title>User Profile</title>
    <style>
        .profile-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            max-width: 500px;
        }
        .profile-card-header {
            background-color: #4d285b;
            color: #ffffff;
            padding: 1rem;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }
        .profile-card-body {
            padding: 1.5rem;
        }
        .profile-card-footer {
            background-color: #f1f3f5;
            padding: 0.75rem;
            border-bottom-left-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
            text-align: center;
        }
        .password-placeholder {
            color: #6c757d;
        }
        .btn {
            background-color: #4d285b;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 px-4 text-center">User Profile</h1>
        <?php if ($user): ?>
            <div class="card profile-card mx-auto">
                <div class="card-header profile-card-header">
                    <h5 class="card-title mb-0 text-center">Profile Details</h5>
                </div>
                <div class="card-body profile-card-body">
                    <p class="card-text"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p class="card-text"><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                    <p class="card-text"><strong>Password:</strong> <span class="password-placeholder"><?php echo str_repeat('•', strlen($user['password'])); ?></span></p>
                </div>
                <div class="card-footer profile-card-footer">
                    <a href="editprofile.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn">Edit Profile</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                User not found.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include_once '../include/footer.php'; ?>