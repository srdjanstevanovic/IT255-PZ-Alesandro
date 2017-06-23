<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

require 'functions.php';

if (isset($_POST['mail']) && isset($_POST['password'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    echo login($mail, $password);
}