<?php

require_once "../dbc.php"; 

$sql = "SELECT * FROM categories ORDER BY id;";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $delimiter = ",";
  $filename = "category_data_" . date("Y-m-d") . ".csv";

  // Create a file pointer connected to the output stream
  $f = fopen('php://memory', 'w');

  // Set column headers
  $fields = array('Id', 'Name');
  fputcsv($f, $fields, $delimiter);

  // Output each row of the data, format line as CSV and write to file pointer
  while ($row = $result->fetch_assoc()) {
    $linedata = array($row['id'], $row['name']);
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
