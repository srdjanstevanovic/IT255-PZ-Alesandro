<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

if (isset($_SERVER['HTTP_TOKEN']) && isset($_POST['product_id'])) {
    $token = $_SERVER['HTTP_TOKEN'];
    $product_id = $_POST['product_id'];
    echo removeOrder($token, $product_id);
}