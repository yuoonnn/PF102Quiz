<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dbusers";
$result = 0;

/* Create connection */
$conn = new mysqli($host, $username, $password, $dbname);
/* Check connection */
if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}

/* Get data from Client side using $_POST array */
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

/* validate whether user has entered all values. */
if (!$fname || !$lname || !$phone || !$email) {
    $result = 2;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = 3;
} else {
    $photo_path = null;
    
    // Handle image upload if a file was provided
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['photo']['type'];
        
        if(!in_array($file_type, $allowed_types)) {
            $result = 4; // Invalid file type
            echo $result;
            exit;
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $file_extension;
        $upload_path = 'uploads/' . $filename;
        
        // Move uploaded file
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
            $photo_path = $upload_path;
        }
    }
    
    // SQL query to insert data
    $sql = "INSERT INTO users (first_name, last_name, phone, email, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $fname, $lname, $phone, $email, $photo_path);
    
    if ($stmt->execute()) {
        $result = 1;
    }
}

echo json_encode($result);
$conn->close();
?>
