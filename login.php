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

$sql = "SELECT * FROM retailer WHERE phone = '$phone' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(array("status" => "success", "retailer_id" => $row["id"], "profile_status" => $row["profile_status"]));
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid credentials"));
}

$conn->close();
?>
