<?php
// Declaring the header types and access controls
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
error_reporting(0);

// Include the database connection
include "database.php";

// Inserting the dynamic value in JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Taking input values
$id = $data['id'] ?? '';
$full_name = $data['full_name'] ?? '';
$Address = $data['Address'] ?? '';
$office_address = $data['office_address'] ?? '';
$password = $data['password'] ?? '';
$email = $data['email'] ?? '';

// Update data in the database table
$sql = "UPDATE users SET full_name=?, Address=?, office_address=?, password=?, email=? WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $Address, $office_address, $password, $email, $id);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    // Check if any rows were affected
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Records updated successfully
        $response = array('message' => 'Data updated successfully.', 'status' => true);
        echo json_encode($response);
    } else {
        // No rows were affected, so no changes were made
        echo json_encode(array('message' => 'No changes were made.', 'status' => false));
    }
} else {
    // Capture the MySQL error message
    echo json_encode(array('message' => 'Error executing the query: ' . mysqli_error($conn), 'status' => false));
}

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
