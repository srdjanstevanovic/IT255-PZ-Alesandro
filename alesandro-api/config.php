<?php


$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'alesandro';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die('Connection error: ' . $conn->connect_error);
}

$conn->set_charset('utf8');