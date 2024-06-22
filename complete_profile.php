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
    



//creat databse conn
$conn = mysqli_connect("localhost", "root", "", "salesbroz");
if(!$conn) {
    die("Conn failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"), true);
$retailer_id = $data['retailer_id'];
$fname = $data['fname'];
$lname = $data['lname'];
$address = $data['address'];
$email = $data['email'];

$sql = "UPDATE retailer SET fname = '$fname', lname = '$lname', address = '$address', email = '$email', profile_status = 'complete' WHERE id = '$retailer_id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => "Error updating record: " . $conn->error));
}

$conn->close();
?>