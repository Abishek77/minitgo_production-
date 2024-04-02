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
$id = $data['id'];
$product_id = $data['product_id'] ?? '';
$product_name = $data['product_name'] ?? '';
$category = $data['category'] ?? '';
$offers = $data['offers'] ?? '';
$client_id = $data['client_id'] ?? '';
$client_name = $data['client_name'] ?? '';
$product_discription = $data['product_discription'] ?? '';
$product_image1 = $data['product_image1'] ?? '';
$product_image2 = $data['product_image2'] ?? '';
$product_image3 = $data['product_image3'] ?? '';
$product_image4 = $data['product_image4'] ?? '';
$product_image5 = $data['product_image5'] ?? '';
$product_image6 = $data['product_image6'] ?? '';
$product_price = $data['product_price'] ?? '';
$product_tittle = $data['product_tittle'] ?? '';
$product_brand = $data['product_brand'] ?? '';
$product_size = $data['product_size'] ?? '';
$product_ratings = $data['product_ratings'] ?? '';
$product_stock = $data['product_stock'] ?? '';
$product_color1 = $data['product_color1'] ?? '';
$product_color2 = $data['product_color2'] ?? '';
$product_color3 = $data['product_color3'] ?? '';
$product_color4 = $data['product_color4'] ?? '';
$similarity = $data['similarity'] ?? '';
$cordinates = $data['cordinates'] ?? '';
$user_id = $data['user_id'] ?? '';
$user_name = $data['user_name'] ?? '';
$user_rating = $data['user_rating'] ?? '';
$date = $data['date'] ?? '';
$time = $data['time'] ?? '';

// Insert data into the database table
$sql = "INSERT INTO product (product_id, product_name, category, offers, client_id, client_name, product_discription, product_image1, product_image2, product_image3, product_image4, product_image5, product_image6, product_price, product_tittle, product_brand, product_size, product_ratings, product_stock, product_color1, product_color2, product_color3, product_color4, similarity, cordinates, user_id, user_name, user_rating, date, time) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssss", $product_id, $product_name, $category, $offers, $client_id, $client_name, $product_discription, $product_image1, $product_image2, $product_image3, $product_image4, $product_image5, $product_image6, $product_price, $product_tittle, $product_brand, $product_size, $product_ratings, $product_stock, $product_color1, $product_color2, $product_color3, $product_color4, $similarity, $cordinates, $user_id, $user_name, $user_rating, $date, $time);

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
} else {
    // Capture the MySQL error message
    echo json_encode(array('message' => 'Error executing the query: ' . mysqli_error($conn), 'status' => false));
}

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
