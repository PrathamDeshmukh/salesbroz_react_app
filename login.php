<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}
    header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
    



//creat databse connection
$conn = mysqli_connect("localhost", "root", "", "salesbroz");
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"));


$phone = $data->phone;
$password = $data->password;

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM retailer WHERE  phone=? AND password=?");
$stmt->bind_param("ss",  $phone, $password);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If user exists with the provided credentials
    $row = $result->fetch_assoc();
    $profile_status = $row['profile_status'];
    echo json_encode(array("success" => true, "profile_status" => $profile_status));
} else {
    // If user does not exist or credentials are incorrect
    echo json_encode(array("success" => false, "message" => "Invalid credentials"));
}

// Close prepared statement and database conn
$stmt->close();
$conn->close();
?>