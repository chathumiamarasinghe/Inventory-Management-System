<?php
    $dbservername = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'inventorymanagement';

    // Create connection
    $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        // Log the error to a file
        error_log("Connection failed: " . $conn->connect_error, 3, 'error.log');
        
        // Display a generic error message to the user
        echo "Sorry, we're experiencing technical difficulties. Please try again later.";
        
        // Exit the script
        exit();
    }

   
?>