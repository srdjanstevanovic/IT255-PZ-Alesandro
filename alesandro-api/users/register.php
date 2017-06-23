<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

if (isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['address']) && isset($_POST['city_id']) && isset($_POST['tin'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $city = $_POST['city_id'];
    $tin = $_POST['tin'];
    echo register($mail, $password, $address, $city, $tin);
}