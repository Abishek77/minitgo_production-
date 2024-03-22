<?php
$uploadDir = 'uploads/';
$uploadedFile = $uploadDir . basename($_FILES['image']['name']);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($uploadedFile)) {
    echo 'Sorry, file already exists.';
    $uploadOk = 0;
}

// Check file size
if ($_FILES['image']['size'] > 5000000) { // 5MB
    echo 'Sorry, your file is too large.';
    $uploadOk = 0;
}

// Allow certain file formats
$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
if (!in_array($imageFileType, $allowedTypes)) {
    echo 'Sorry, only JPG, JPEG, PNG, and GIF files are allowed.';
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo 'Sorry, your file was not uploaded.';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
        // Return the path to the uploaded file
        echo $uploadedFile;
    } else {
        echo 'Sorry, there was an error uploading your file.';
    }
}
?>
