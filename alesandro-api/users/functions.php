<?php

require_once '../shared.php';

function login($mail, $password)
{
    global $conn;
    $message = array();
    $password = trim($password);
    $hashedPassword = md5($password);
    if (checkLogin($mail, $hashedPassword)) {
        $token = sha1(uniqid());
        $query = 'UPDATE user SET token = ? WHERE mail = ?';
        $result = $conn->prepare($query);
        $result->bind_param('ss', $token, $mail);
        $result->execute();
        $message['token'] = $token;

        if (!checkIfCartExists($token)) {
            createCart($token);
        }
    } else {
        $message = 'Invalid username or password';
        header('HTTP/1.1 404 Unauthorized');
    }
    return json_encode($message);
}

function checkLogin($mail, $password)
{
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM user WHERE mail = ? AND password = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param("ss", $mail, $password);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function checkIfUserExists($mail)
{
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM user WHERE mail = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param("s", $mail);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function register($mail, $password, $address, $city_id, $tin)
{
    global $conn;
    $message = array();
    $errors = '';
    if (checkIfUserExists($mail)) {
        $errors .= 'User already exists.';
    }
    if (strlen($password) < 8) {
        $errors .= 'Password must have at least 8 characters.';
    }
    if ($errors == '') {
        $query = 'INSERT INTO user (mail, password, address, city_id, tin, role_id) 
            VALUES (?, ?, ?, ?, ?, ?)';
        $statement = $conn->prepare($query);
        $password = trim($password);
        $hashedPassword = md5($password);
        $role_id = 1;
        $statement->bind_param('sssiii', $mail, $hashedPassword, $address, $city_id, $tin, $role_id);
        if ($statement->execute()) {
            $token = sha1(uniqid());
            $query2 = 'UPDATE user SET token = ? WHERE mail = ?';
            $result = $conn->prepare($query2);
            $result->bind_param('ss', $token, $mail);
            $result->execute();
            $message['token'] = $token;
        } else {
            $message['error'] = 'Database connection error.';
            header('HTTP/1.1 400 Bad Request');
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        $message['error'] = json_encode($errors);
    }
    return json_encode($message);
}

function getUser($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT id, mail, password, address, tin, city_id, role_id,
      (SELECT name FROM role WHERE role.id = user.role_id) AS role_name,
      (SELECT name FROM city WHERE city.id = user.city_id) AS city_name
      FROM user
      WHERE user.token = ?';
    $user = array();
    $statement = $conn->prepare($query);
    $statement->bind_param('i', $token);
    if ($statement->execute()) {
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $user['id'] = $row['id'];
            $user['mail'] = $row['mail'];
            $user['password'] = $row['password'];
            $user['address'] = $row['address'];
            $user['role_id'] = $row['role_id'];
            $user['role_name'] = $row['role_name'];
            $user['tin'] = $row['tin'];
            $user['city_id'] = $row['city_id'];
            $user['city_name'] = $row['city_name'];
        }
    }
    return json_encode($user);
}

function getCities()
{
    global $conn;
    $query = 'SELECT * FROM city';
    $cities = array();
    if ($statement = $conn->prepare($query)) {
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $city = array();
            $city['id'] = $row['id'];
            $city['name'] = $row['name'];
            array_push($cities, $city);
        }
    }
    $message['cities'] = $cities;
    return json_encode($cities);
}