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

$retailer_id = $_GET['retailer_id'];

$sql = "SELECT fname, lname, address, email FROM retailer WHERE id = '$retailer_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(array("status" => "success", "data" => $row));
} else {
    echo json_encode(array("status" => "error", "message" => "No record found"));
}

$conn->close();
?>