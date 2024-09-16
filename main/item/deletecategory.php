<?php include_once "../dbc.php"; 

$script = '';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Check if there are any items associated with this category
    $sql = "SELECT COUNT(*) AS item_count FROM item WHERE categorie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close(); // Close the statement after use

    if ($row['item_count'] > 0) {
        $script = "<script>alert('Cannot delete category: There are items associated with this category.'); window.location.href='viewcategory.php';</script>";
    } else {
        // Proceed to delete the category
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $conn->prepare($sql); // Create a new statement object
        $stmt->bind_param("i", $category_id);
        if ($stmt->execute()) {
            $script = "<script>alert('Category deleted successfully.'); window.location.href='viewcategory.php';</script>";
        } else {
            $script = "<script>alert('Error deleting category: " . $stmt->error . "'); window.location.href='viewcategory.php';</script>";
        }
        $stmt->close(); // Close the statement after use
    }
} else {
    $script = "<script>alert('No category ID provided.'); window.location.href='viewcategory.php';</script>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

<?php echo $script; ?>

</body>
</html>
<?php include_once '../include/footer.php'; ?>