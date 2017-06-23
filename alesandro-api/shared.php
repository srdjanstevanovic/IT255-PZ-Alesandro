<?php


require_once 'config.php';

function tokenToId($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT id FROM user WHERE token = ?';
    $result = $conn->prepare($query);
    $result->bind_param('s', $token);
    $id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }
        return $id;
    }
}

function tokenToMail($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT mail FROM user WHERE token = ?';
    $result = $conn->prepare($query);
    $result->bind_param('s', $token);
    $id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }
        return $id;
    }
}

function tokenToCart($token)
{
    $token = str_replace('"', "", $token);
    $user_id = tokenToId($token);
    global $conn;
    $query = 'SELECT orders.id 
      FROM orders
      WHERE orders.user_id = ?';
    $result = $conn->prepare($query);
    $result->bind_param('i', $user_id);
    $id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }
        return $id;
    }
}


function checkIfLoggedIn($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM user WHERE token = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param('s', $token);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function checkIfCartExists($token)
{
    $token = str_replace('"', "", $token);
    $user_id = tokenToId($token);
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM orders WHERE flag = 1 AND user_id = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param('i', $user_id);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function createCart($token)
{
    $token = str_replace('"', "", $token);
    $user_id = tokenToId($token);
    global $conn;
    $message = array();
    $query = 'INSERT INTO orders (user_id, flag) VALUES (?, ?)';
    $statement = $conn->prepare($query);
    $flag = 1;
    $statement->bind_param("ii", $user_id, $flag);
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    return json_encode($message);
}

function sendMail($token)
{

}