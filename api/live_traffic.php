<?php
// Extract POST data
extract($_POST);

// Include database connection
include 'database.php';

// Check if location data is missing and set it to an empty string if not provided
$location = isset($location) ? $location : '';

// Prepare SQL statement with parameters to prevent SQL injection
$sql = "INSERT INTO live_traffic (url, timestamp, device, location) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "ssss", $url, $timestamp, $userAgent, $location);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array('message' => 'Record inserted successfully.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Error executing the query: ' . mysqli_error($conn), 'status' => false));
}

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
