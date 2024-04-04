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
$product_id = $data['product_id'] ?? '';
$order_id = $data['order_id'] ?? '';
$product_name = $data['product_name'] ?? '';
$quantity = $data['quantity'] ?? '';
$payment_mode = $data['payment_mode'] ?? '';
$transition_id = $data['transition_id'] ?? '';
$payment_status = $data['payment_status'] ?? '';
$client_id = $data['client_id'] ?? '';
$client_name = $data['client_name'] ?? '';
$client_cordnates = $data['client_cordnates'] ?? '';
$user_name = $data['user_name'] ?? '';
$user_id = $data['user_id'] ?? '';
$user_cordnates = $data['user_cordnates'] ?? '';
$user_address = $data['user_address'] ?? '';
$product_color = $data['product_color'] ?? '';
$product_price = $data['product_price'] ?? '';
$delivery_boy_name = $data['delivery_boy_name'] ?? '';
$delivery_boy_id = $data['delivery_boy_id'] ?? '';
$delivery_boy_cordnates_from = $data['delivery_boy_cordnates_from'] ?? '';
$delivery_boy_cordnates_client = $data['delivery_boy_cordnates_client'] ?? '';
$delivery_boy_cordnates_user = $data['delivery_boy_cordnates_user'] ?? '';
$status_product_client = $data['status_product_client'] ?? '';
$status_delivery_boy = $data['status_delivery_boy'] ?? '';
$product_title = $data['product_title'] ?? '';
$status_delivery_user = $data['status_delivery_user'] ?? '';
$product_status = $data['product_status'] ?? '';
$status_after_delivery = $data['status_after_delivery'] ?? '';
$return = $data['return'] ?? '';
$reason = $data['reason'] ?? '';
$product_image = $data['product_image'] ?? '';
$delivery_boy_phonenumber = $data['delivery_boy_phonenumber'] ?? '';
$date = $data['date'] ?? '';
$time = $data['time'] ?? '';
$user_phonenumber = $data['user_phonenumber'] ?? '';
$product_description = $data['product_description'] ?? '';

// Update data in the database table
$sql = "INSERT INTO orders (id, product_id, order_id, product_name, quantity, payment_mode, transition_id, payment_status, client_id, client_name, client_cordnates, user_name, user_id, user_cordnates, user_address, product_color, product_price, delivery_boy_name, delivery_boy_id, delivery_boy_cordnates_from, delivery_boy_cordnates_client, delivery_boy_cordnates_user, status_product_client, status_delivery_boy, product_title, status_delivery_user, product_status, status_after_delivery, `return`, reason, product_image, delivery_boy_phonenumber, `date`, `time`, user_phonenumber, product_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "isssissssssssssssdssssssssssssss", $id, $product_id, $order_id, $product_name, $quantity, $payment_mode, $transition_id, $payment_status, $client_id, $client_name, $client_cordnates, $user_name, $user_id, $user_cordnates, $user_address, $product_color, $product_price, $delivery_boy_name, $delivery_boy_id, $delivery_boy_cordnates_from, $delivery_boy_cordnates_client, $delivery_boy_cordnates_user, $status_product_client, $status_delivery_boy, $product_title, $status_delivery_user, $product_status, $status_after_delivery, $return, $reason, $product_image, $delivery_boy_phonenumber, $date, $time, $user_phonenumber, $product_description);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    $response = array('message' => 'Data inserted successfully.', 'status' => true);
    
    // Check if files were uploaded
    if (!empty($_FILES['file']['name'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $destination = $uploadFolder . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $response['file_message'] = 'File uploaded successfully.';
        } else {
            $response['file_message'] = 'Error uploading file.';
        }
    }
    echo json_encode($response);
} } else {
    // Capture the MySQL error message
    $error_message = 'Error executing the query: ' . mysqli_error($conn);
    error_log($error_message); // Log the error message
    echo json_encode(array('message' => $error_message, 'status' => false));
}

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
