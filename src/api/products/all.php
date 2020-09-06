<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); // JSON File Type

    include_once '../../config/database.php';
    include_once '../models/product.php';
    
    $database = new Database();
    $db = $database->connect();

    // Product Instantiation
    $product = new Product($db);

    // Product Query
    $result = $product->all();

    // Row Count
    $n_rows = $result->rowCount();

    if($n_rows > 0){
        $product_array = array();
        $product_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $product_item = array(
                'productid' => $productid,
                'p_name' => $p_name,
                'd_details' => $d_details,
                'price' => $price
            );
            // Push to array
            array_push($product_array['data'], $product_item);
        }

        // Turn to JSON
        echo json_encode($product_array);

    }else{
        // No Products
        echo json_encode(array('message' => 'No Products Found'));
    }