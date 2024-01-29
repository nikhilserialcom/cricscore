<?php

    require 'partials/mongodbconnect.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("content-type: application/json");

    $data = json_decode(file_get_contents('php://input'), true);

    $input = $data['input'];

    if($input == '') {
        $response = array(
            'status_code' => '404',
            'message' => 'Please enter 1 or more characters.'
        );

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    $filter = ['country_name' => ['$regex' => $input, '$options' => 'i']];
    $check_country = $countryNameCollection->find($filter);

    $arr_of_obj = [];

    foreach($check_country as $document)
    {
        $country_data = [
            'id' => $document['_id'],
            'country' => $document['country_name'],
            'country_code' => $document['country_code']
        ];

        $arr_of_obj[] = $country_data; 
    }

    if(!empty($arr_of_obj))
    {
        $response = [
            'status_code' => '200',
            'arr' => $arr_of_obj
        ];

        echo json_encode($response,JSON_PRETTY_PRINT);
    } else {
        $response = [
            'status_code' =>  '404',
            'message' => 'No result found'
        ];

        echo json_encode($response,JSON_PRETTY_PRINT);
    }
   
?>