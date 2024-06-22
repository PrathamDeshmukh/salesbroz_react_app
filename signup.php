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
$data = json_decode(file_get_contents("php://input"), true);
$phone = $data['phone'];
$password = $data['password'];

// Check if the phone number already exists
$sql_check = "SELECT * FROM retailer WHERE phone = '$phone'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo json_encode(array("status" => "error", "message" => "Phone number already exists"));
} else {
    $sql = "INSERT INTO retailer (phone, password, profile_status) VALUES ('$phone', '$password', 'incomplete')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $conn->error));
    }
}

$conn->close();
?>