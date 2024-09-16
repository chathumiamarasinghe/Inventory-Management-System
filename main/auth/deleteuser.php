<?php

include_once "../dbc.php";


if (isset($_GET['id'])) {
    
    $user_id = $_GET['id'];

    
    $checkSql = "SELECT roleid FROM user WHERE id = ?";
    if ($stmt = $conn->prepare($checkSql)) {
       
        $stmt->bind_param("i", $user_id);

       
        $stmt->execute();

        
        $stmt->bind_result($roleid);
        $stmt->fetch();

        
        $stmt->close();

        // Check if the role is Admin (roleid = 1)
        if ($roleid === 1) {
            
            header("Location: userdisplay.php?msg=CannotDeleteAdmin");
            exit();
        } else {
            
            $sql = "DELETE FROM user WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                
                $stmt->bind_param("i", $user_id);

                
                if ($stmt->execute()) {
                    
                    header("Location: userdisplay.php?msg=UserDeleted");
                    exit();
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

                
                $stmt->close();
            } else {
                echo "Error preparing the statement: " . $conn->error;
            }
        }
    } else {
        echo "Error preparing the check statement: " . $conn->error;
    }
} else {
    
    header("Location: userdisplay.php?msg=NoID");
    exit();
}


$conn->close();
?>