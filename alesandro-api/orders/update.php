<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

if (isset($_SERVER['HTTP_TOKEN']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $token = $_SERVER['HTTP_TOKEN'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    echo updateOrder($token, $product_id, $quantity);
}