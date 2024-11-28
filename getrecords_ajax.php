<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dbusers";

$result_array = array();

/* Create connection */
$conn = new mysqli($host, $username, $password, $dbname);

/* Check connection */
if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}

/* SQL query to get results from database */
$sql = "SELECT id, first_name, last_name, phone, email, photo FROM users ORDER BY first_name ASC";
$result = $conn->query($sql);

/* If there are results from database push to result array */
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // If no photo, set a default image path
        if (empty($row['photo'])) {
            $row['photo'] = 'https://via.placeholder.com/150';
        }
        array_push($result_array, $row);
    }
}

/* send a JSON encoded array to client */
echo json_encode($result_array);

$conn->close();
?>
