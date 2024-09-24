<?php

require_once "../dbc.php"; 

// SQL query to fetch order history data
$sql = "SELECT o.orderid, o.orderdescription, i.name AS productname, o.orderdate, o.totalprice
        FROM orders o
        JOIN item i ON o.itemid = i.id
        ORDER BY o.orderid;";

$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
    $delimiter = ",";
    $filename = "Order_History_" . date("Y-m-d") . ".csv";

    // Create a file pointer connected to the output stream
    $f = fopen('php://output', 'w');

    // Set column headers
    $fields = array('Order ID', 'Order Description', 'Product Name', 'Order Date', 'Total Price');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as CSV and write to file pointer
    while ($row = $result->fetch_assoc()) {
        $linedata = array($row['orderid'], $row['orderdescription'], $row['productname'], $row['orderdate'], $row['totalprice']);
        fputcsv($f, $linedata, $delimiter);
    }

    // Close file pointer
    fclose($f);

    // Set headers to download the file rather than display it
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output file
    flush();
    readfile('php://output');
    exit();
} else {
    echo "No records found.";
}

exit;
?>
