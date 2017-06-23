<?php


require_once '../shared.php';

function getOrder($token)
{
    $user_id = tokenToId($token);
    global $conn;
    $query = 'SELECT orders_details.id, orders_details.product_id, 
      product.code, product.name, product.price, orders_details.quantity,
       product.type_id, product.elements_number, product.image,
      (orders_details.quantity * product.price) AS total,
      (SELECT name FROM type WHERE type.id = product.type_id) AS type
      FROM orders_details
      JOIN orders ON orders_details.orders_id = orders.id
      JOIN user ON orders.user_id = user.id
      JOIN product ON orders_details.product_id = product.id
      WHERE orders.flag = 1 AND orders.user_id = ?';
    $orders = array();
    if ($statement = $conn->prepare($query)) {
        $statement->bind_param('i', $user_id);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $order = array();
            $order['id'] = $row['id'];
            $order['product_id'] = $row['product_id'];
            $order['code'] = $row['code'];
            $order['name'] = $row['name'];
            $order['type'] = $row['type'];
            $order['price'] = $row['price'];
            $order['quantity'] = $row['quantity'];
            $order['type_id'] = $row['type_id'];
            $order['elements_number'] = $row['elements_number'];
            $order['image'] = $row['image'];
            $order['total'] = $row['total'];
            array_push($orders, $order);
        }
    }
    $message['orders'] = $orders;
    return json_encode($orders);
}

function removeOrder($token, $product_id)
{
    $user_id = tokenToId($token);
    global $conn;
    $message = array();
    $query = 'DELETE orders_details
      FROM orders_details
      JOIN product ON orders_details.product_id = product.id
      JOIN orders ON orders_details.orders_id = orders.id
      WHERE orders_details.product_id = ? AND orders.user_id = ?';
    $statement = $conn->prepare($query);
    $statement->bind_param("ii", $product_id, $user_id);
    $statement->execute();
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    return json_encode($message);
}

function addOrder($token, $product_id, $quantity)
{
    $cart_id = tokenToCart($token);
    global $conn;
    $message = array();
    $query = 'INSERT INTO orders_details (orders_id, product_id, quantity) VALUES  (?, ?, ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param("iii", $cart_id, $product_id, $quantity);
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    return json_encode($message);
}

function updateOrder($token, $product_id, $quantity)
{
    $user_id = tokenToId($token);
    global $conn;
    $message = array();
    $query = 'UPDATE orders_details
      JOIN orders	
      ON orders_details.orders_id = orders.id
      JOIN user 
      ON orders.user_id = user.id
      SET orders_details.quantity = ?
      WHERE orders_details.product_id = ?
      AND user.id = ?';
    $statement = $conn->prepare($query);
    $statement->bind_param("iii", $quantity, $product_id, $user_id);
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    if (!checkIfCartExists($token)) {
        createCart($token);
    }
    return json_encode($message);
}

function checkout($token)
{
    $token = str_replace('"', "", $token);
//    sendMail($token);
    $user_id = tokenToId($token);
    global $conn;
    $message = array();
    $query = 'UPDATE orders 
              SET flag = 2
              WHERE orders.flag = 1 AND orders.user_id = ?';
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $user_id);
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    if (!checkIfCartExists($token)) {
        createCart($token);
    }
    return json_encode($message);
}