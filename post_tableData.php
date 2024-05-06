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

// Create connection
//creat databse connection
$conn = mysqli_connect("localhost", "root", "", "salesbroz");
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Insert data into specified table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $table = $data['table'];
    $fields = $data['fields'];

    $fieldsStr = '';
    $valuesStr = '';
    foreach ($fields as $key => $value) {
        $fieldsStr .= "`$key`,";
        $valuesStr .= "'$value',";
    }
    $fieldsStr = rtrim($fieldsStr, ',');
    $valuesStr = rtrim($valuesStr, ',');

    $sql = "INSERT INTO $table ($fieldsStr) VALUES ($valuesStr)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>