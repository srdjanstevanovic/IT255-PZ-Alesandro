<?php

require_once '../shared.php';

function getProducts()
{
    global $conn;
    $message = array();
    $query = 'SELECT id, name, type_id, elements_number, code, price, image, 
      (SELECT name FROM type WHERE type.id = product.type_id) AS type
      FROM product';
    $products = array();
    $statement = $conn->prepare($query);
    if ($statement->execute()) {
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $product = array();
            $product['id'] = $row['id'];
            $product['name'] = $row['name'];
            $product['code'] = $row['code'];
            $product['type_id'] = $row['type_id'];
//            $product['type'] = $row['type'];
            $product['elements_number'] = $row['elements_number'];
            $product['price'] = $row['price'];
            $product['image'] = $row['image'];
            array_push($products, $product);
        }
    }
    $message['products'] = $products;
    return json_encode($message);
}

function addProduct($token, $name, $type_id, $elements_number, $code, $price, $image)
{
    global $conn;
    $message = array();
    if (checkIfLoggedIn($token)) {
        $query = 'INSERT INTO product (name, type_id, elements_number, code, price, image) 
        VALUES (?, ?, ?, ?, ?, ?)';
        $result = $conn->prepare($query);
        $result->bind_param('siiiis', $name, $type_id, $elements_number, $code, $price, $image);
        if ($result->execute()) {
            $message['success'] = 'You have successfully added the product.';
        } else {
            $message['error'] = 'Database connection error.';
        }
    } else {
        $message['error'] = 'Please log in.';
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($message);
}

function updateProduct($token, $name, $type_id, $elements_number, $code, $price, $image)
{
    global $conn;
    $message = array();
    if (checkIfLoggedIn($token)) {
        $query = 'INSERT INTO product (name, type_id, elements_number, code, price, image) 
        VALUES (?, ?, ?, ?, ?, ?)';
        $result = $conn->prepare($query);
        $result->bind_param('siiiis', $name, $type_id, $elements_number, $code, $price, $image);
        if ($result->execute()) {
            $message['success'] = 'You have successfully added the product.';
        } else {
            $message['error'] = 'Database connection error.';
        }
    } else {
        $message['error'] = 'Please log in.';
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($message);
}

function removeProduct($token, $product_id)
{
    global $conn;
    $message = array();
    if (checkIfLoggedIn($token)) {
        $query = 'DELETE FROM product WHERE id = ?';
        $result = $conn->prepare($query);
        $result->bind_param('i', $product_id);
        if ($result->execute()) {
            $message['success'] = 'You have successfully deleted the product.';
        } else {
            $message['error'] = 'Database connection error.';
        }
    } else {
        $message['error'] = 'Please log in.';
        header('HTTP/1.1 401 Unauthorized');
    }
    return json_encode($message);
}

function getElements()
{
    global $conn;
    $query = 'SELECT * FROM elements';
    $elements = array();
    if ($statement = $conn->prepare($query)) {
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $element = array();
            $element['number'] = $row['number'];
            array_push($elements, $element);
        }
    }
    $message['elements'] = $elements;
    return json_encode($elements);
}

function getTypes()
{
    global $conn;
    $query = 'SELECT * FROM type';
    $types = array();
    if ($statement = $conn->prepare($query)) {
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $type = array();
            $type['id'] = $row['id'];
            $type['name'] = $row['name'];
            array_push($types, $type);
        }
    }
    $message['types'] = $types;
    return json_encode($types);
}