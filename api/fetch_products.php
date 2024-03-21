<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(0);
# Including the database db name
include "database.php";

# Connecting to the Database table
$sql = "SELECT * FROM product";
 

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $product = array(
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'category' => $row['category'],
            'offers' => $row['offers'],
            'client_id' => $row['client_id'],
            'client_name' => $row['client_name'],
            'product_discription' => $row['product_discription'],
            'product_image1' => $row['product_image1'],
            'product_image2' => $row['product_image2'],
            'product_image3' => $row['product_image3'],
            'product_image4' => $row['product_image4'],
            'product_image5' => $row['product_image5'],
            'product_image6' => $row['product_image6'],
            'product_price' => $row['product_price'],
            'product_tittle' => $row['product_tittle'],
            'product_brand' => $row['product_brand'],
            'product_size' => $row['product_size'],
            'product_ratings' => $row['product_ratings'],
            'product_stock' => $row['product_stock'],
            'product_color1' => $row['product_color1'],
            'product_color2' => $row['product_color2'],
            'product_color3' => $row['product_color3'],
            'product_color4' => $row['product_color4'],
            'similarity' => $row['similarity'],
            'cordinates' => $row['cordinates'],
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'date' => $row['date'],
            'time' => $row['time']
            

 
            
            
            // Add other columns as needed
        );
        $output[] = $product;
    }
    // Count the rows
    $rows = count($output);
    // Encode the whole array
    echo json_encode(array('count' => $rows, 'data' => $output));
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
