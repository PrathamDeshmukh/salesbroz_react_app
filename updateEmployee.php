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




$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$field = $input['field'];
$value = $input['value'];

if ($stmt = $conn->prepare("UPDATE employee SET $field = ? WHERE id = ?")) {
  $stmt->bind_param("si", $value, $id);
  $stmt->execute();
  if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "message" => "No rows affected"]);
  }
  $stmt->close();
} else {
  echo json_encode(["success" => false, "message" => "Error preparing statement"]);
}

$conn->close();
?>