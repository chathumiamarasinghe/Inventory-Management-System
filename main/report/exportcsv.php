<?php

require_once "../dbc.php"; 

$sql = "SELECT i.id, i.name AS item_name, i.quantity, i.price, i.date, c.name AS category_name
            FROM item i
            JOIN categories c ON i.categorie_id = c.id
            ORDER BY i.id;";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $delimiter = ",";
  $filename = "Item_data_" . date("Y-m-d") . ".csv";

  // Create a file pointer connected to the output stream
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('Id', 'Name', 'Quantity', 'Price', 'Date', 'Category');
  fputcsv($f, $fields, $delimiter);

  // Output each row of the data, format line as CSV and write to file pointer
  while ($row = $result->fetch_assoc()) {
    $linedata = array($row['id'], $row['item_name'], $row['quantity'], $row['price'], $row['date'], $row['category_name']);
    fputcsv($f, $linedata, $delimiter);
  }

  // Move back to the beginning of the file
  fseek($f, 0);

  // Set headers to download the file rather than display it
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="' . $filename . '";');

  // Output all remaining data on a file pointer
  fpassthru($f);
}

exit;
?>
