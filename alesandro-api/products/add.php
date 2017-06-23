<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

$path = 'images/';
$fullPath = 'http://127.0.0.1:80/alesandro-api/products/images/';

if (isset($_FILES['file']) && isset($_SERVER['HTTP_TOKEN'])
    && isset($_POST['name']) && isset($_POST['code'])
    && isset($_POST['price']) && isset($_POST['type_id'])
    && isset($_POST['elements_number'])
) {
    $token = $_SERVER['HTTP_TOKEN'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $type_id = $_POST['type_id'];
    $elements_number = $_POST['elements_number'];
    $originalName = $_FILES['file']['name'];
    $ext = '.' . pathinfo($originalName, PATHINFO_EXTENSION);
    $generatedName = md5($_FILES['file']['tmp_name']) . $ext;
    $filePath = $path . $generatedName;
    $fullPath = $fullPath . $generatedName;

    if (!is_writable($path)) {
        echo json_encode(array(
            'status' => false,
            'msg' => 'Destination directory not writable.'
        ));
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        addProduct($token, $name, $type_id, $elements_number, $code, $price, $fullPath);
        echo json_encode(array(
            'status' => true,
            'originalName' => $originalName,
            'generatedName' => $generatedName
        ));
    }
}