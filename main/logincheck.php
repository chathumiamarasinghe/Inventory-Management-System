<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once 'dbc.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }

    
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($conn, $username);

    
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            session_regenerate_id(true); 

            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['roleid'] = $user['roleid'];
            header("Location: Dashboard/dashboard.php");
            exit();
        } else {
            
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } else {
        
        header("Location: login.php?error=invalid_credentials");
        exit();
    }

    
    $stmt->close();
    mysqli_close($conn);
} else {
    
    header("Location: login.php");
    exit();
}
?>
