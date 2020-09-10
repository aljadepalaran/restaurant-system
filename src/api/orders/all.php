<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); // JSON File Type

    include_once '../../config/database.php';
    include_once '../models/order.php';
    
    $database = new Database();
    $db = $database->connect();

    // Order Instantiation
    $order = new Order($db);

    // Order Query
    $result = $order->all();

    // Row Count
    $n_rows = $result->rowCount();

    if($n_rows > 0){
        $order_array = array();
        $order_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $order_item = array(
                'orderid' => $orderid,
                'userid' => $userid,
                'datetime' => $datetime,
                'total' => $total
            );
            // Push to array
            array_push($order_array['data'], $order_item);
        }

        // Turn to JSON
        echo json_encode($order_array);

    }else{
        // No Orders
        echo json_encode(array('message' => 'No Orders Found'));
    }