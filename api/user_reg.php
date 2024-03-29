<?php
// Declaring the header types and access controls
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Include the database connection
include "database.php";

// Inserting the dynamic value in JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Taking input values

$location_coordinates = !empty($data['location_coordinates']) ? $data['location_coordinates'] : '';
$Address = !empty($data['Address']) ? $data['Address'] : '';
$full_name = !empty($data['full_name']) ? $data['full_name'] : '';
$phone_number = !empty($data['phone_number']) ? $data['phone_number'] : '';
$office_address = !empty($data['office_address']) ? $data['office_address'] : '';
$email = !empty($data['email']) ? $data['email'] : '';
$password = !empty($data['password']) ? $data['password'] : '';
$landmark = !empty($data['landmark']) ? $data['landmark'] : '';
$profile_image = !empty($data['profile_image']) ? $data['profile_image'] : '';
$date = date('Y-m-d'); // Automatically insert current date
$time = date('H:i:s'); // Automatically insert current time

// Check if all required fields are not empty
if (!empty($location_coordinates) && !empty($Address) && !empty($full_name) && !empty($phone_number) && !empty($email) && !empty($password)) {
    // Insert data into the database table
    $sql = "INSERT INTO users (id,location_coordinates, Address, full_name, phone_number, office_address, email, password, landmark, profile_image, date, time) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssssssssss",$location_coordinates, $Address, $full_name, $phone_number, $office_address, $email, $password, $landmark, $profile_image, $date, $time);

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
} else {
    // Error if required fields are empty
    echo json_encode(array('message' => 'Error: Required fields are empty.', 'status' => false));
}
?>
