<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); // JSON File Type

    include_once '../../config/database.php';
    include_once '../models/user.php';
    
    $database = new Database();
    $db = $database->connect();

    // User Instantiation
    $user = new User($db);

    // User Query
    $result = $user->all();

    // Row Count
    $n_rows = $result->rowCount();

    if($n_rows > 0){
        $user_array = array();
        $user_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $user_item = array(
                'userid' => $userid,
                'username' => $username,
                'firstname' => $firstname,
                'surname' => $surname,
                'email' => $email,
                'created' => $created,
                'hash' => $hash
            );
            // Push to array
            array_push($user_array['data'], $user_item);
        }

        // Turn to JSON
        echo json_encode($user_array);

    }else{
        // No Users
        echo json_encode(array('message' => 'No Users Found'));
    }