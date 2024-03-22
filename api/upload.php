<?php
// Check if a file was uploaded
if ($_FILES['image']) {
    $file = $_FILES['image'];

    // File details
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // File extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    // Check if the uploaded file has an allowed extension
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // Max file size (5MB)
                // Generate a unique filename to prevent overwriting existing files
                $fileNameNew = uniqid('', true) . '.' . $fileActualExt;

                // Destination folder where the file will be stored
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the uploads directory if it doesn't exist
                }

                // Move the uploaded file to the destination folder
                $fileDestination = $uploadDir . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                // Return the path to the uploaded file
                echo $fileDestination;
            } else {
                echo "File is too large!";
            }
        } else {
            echo "Error uploading the file!";
        }
    } else {
        echo "Invalid file type! Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
} else {
    echo "No file uploaded!";
}
?>
