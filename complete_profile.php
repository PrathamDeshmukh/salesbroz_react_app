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

$data = json_decode(file_get_contents("php://input"));

$fname = $data->fname;
$lname = $data->lname;
$email = $data->email;
$address = $data->address;
$account_holder_name = $data->account_holder_name;
$accountNo = $data->accountNo;

// Prepare SQL statement to update the retailer profile
$stmt = $conn->prepare("UPDATE retailer SET fname=?, lname=?, email=?, address=?, account_holder_name=?, account_no=?, profile_status='complete' WHERE id=?");
$stmt->bind_param("ssssssi", $fname, $lname, $email, $address, $account_holder_name, $accountNo, $id);

// Assuming you have the id available in session or passed from the frontend
$id = 3; // Replace with the actual id

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "Failed to update profile"));
}

// Close prepared statement and database conn
$stmt->close();
$conn->close();
?>