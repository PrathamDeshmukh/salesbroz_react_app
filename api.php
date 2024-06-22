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



if (isset($_GET['brand_id'])) {
    $brand_id = intval($_GET['brand_id']);
    $sql = "SELECT id, name FROM models WHERE brand_id = $brand_id";
    $result = $conn->query($sql);

    $models = array();
    while($row = $result->fetch_assoc()) {
        $models[] = $row;
    }
    echo json_encode($models);
} elseif (isset($_GET['model_id'])) {
    $model_id = intval($_GET['model_id']);
    $sql = "SELECT name, hsn, tax FROM models WHERE id = $model_id";
    $result = $conn->query($sql);

    $modelDetails = $result->fetch_assoc();

    $sql = "SELECT color, quantity, price FROM colors WHERE model_id = $model_id";
    $result = $conn->query($sql);

    $colors = array();
    while($row = $result->fetch_assoc()) {
        $colors[] = $row;
    }

    $modelDetails['colors'] = $colors;
    echo json_encode($modelDetails);
} else {
    $sql = "SELECT id, name FROM brands";
    $result = $conn->query($sql);

    $brands = array();
    while($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
    echo json_encode($brands);
}
$conn->close();
?>