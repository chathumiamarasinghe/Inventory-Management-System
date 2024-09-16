<?php
include_once "../dbc.php";

$script = '';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete related supply details first
        $sql_delete_supplydetails = "DELETE FROM supplydetails WHERE itemid = ?";
        if ($stmt = $conn->prepare($sql_delete_supplydetails)) {
            $stmt->bind_param("i", $item_id);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing statement for supply details: " . $conn->error);
        }

        // Delete the item
        $sql_delete_item = "DELETE FROM item WHERE id = ?";
        if ($stmt = $conn->prepare($sql_delete_item)) {
            $stmt->bind_param("i", $item_id);
            if ($stmt->execute()) {
                $script = "<script>alert('Item and its supply details deleted successfully.'); window.location.href='viewitem.php';</script>";
            } else {
                throw new Exception("Error deleting item: " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Error preparing statement for item: " . $conn->error);
        }

        // Commit the transaction
        $conn->commit();

    } catch (Exception $e) {
        // Rollback the transaction if any error occurs
        $conn->rollback();
        $script = "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='viewitem.php';</script>";
    }

} else {
    $script = "<script>alert('No item ID provided.'); window.location.href='viewitem.php';</script>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

<!-- Output the script with alerts -->
<?php echo $script; ?>

</body>
</html>
<?php include_once '../include/footer.php'; ?>
