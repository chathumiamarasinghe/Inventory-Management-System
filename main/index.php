<?php
session_start();
define('MYSITE',true);  
// Debugging: Check if the session is starting correctly
if (!isset($_SESSION['username'])) {
    // Debugging: Output message to check if this condition is being met
    echo "Redirecting to login page...";
    header("Location: ../New folder\Login\login.php");
    exit();
} else {
   
    header("Location: Dashboard/dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FriendsInventory</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/index.css" type="text/css">
</head>
<body>
    <div class="container">
        <h1>Welcome to FriendsInventory</h1>
        <p>Manage your inventory efficiently and effectively.</p>
        <!-- Your main content goes here -->
    </div>
</body>
</html>

<?php
// Include the footer

?>
