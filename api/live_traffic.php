<?php
// Include database connection
include 'database.php';

// Get the raw POST data
$json_data = file_get_contents('php://input');

// Check if JSON data is empty
if(empty($json_data)) {
    http_response_code(400); // Bad Request
    echo "No JSON data received";
    exit;
}

// Decode JSON data into PHP associative array
$data = json_decode($json_data, true);

// Validate JSON data
if ($data === null) {
    http_response_code(400); // Bad Request
    echo "Invalid JSON data";
    exit;
}

// Extract data from the JSON array
$url = $data['url'] ?? null;
$timestamp = $data['timestamp'] ?? null;
$userAgent = $data['userAgent'] ?? null;
$location = $data['location'] ?? null;

// Validate required fields
if (!isset($url, $timestamp, $userAgent, $location)) {
    http_response_code(400); // Bad Request
    echo "Missing required parameters";
    exit;
}

// Prepare SQL statement with placeholders
$sql = "INSERT INTO live_traffic (url, timestamp, device, location) VALUES (?, ?, ?, ?)";

// Prepare and bind parameters to prevent SQL injection
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $url, $timestamp, $userAgent, $location);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    http_response_code(200); // Success
    echo "Data inserted successfully";
} else {
    http_response_code(500); // Internal Server Error
    echo "Error inserting data into database: " . mysqli_error($conn);
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
