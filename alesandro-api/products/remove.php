<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

if (isset($_SERVER['HTTP_TOKEN']) && isset($_POST['id'])) {
    $token = $_SERVER['HTTP_TOKEN'];
    $product_id = $_POST['id'];
    echo removeProduct($token, $product_id);
}