<?php

require 'partials/mongodbconnect.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'),true);

$stateId = $data['state_id'];

$response = array(
    'status' => '200',
    'state_id' => $stateId
);

$filter = ['state_id' => $stateId];
$check_city = $cityNameCollection->find($filter);

$arr_of_obj = [];

foreach($check_city as $document)
{
    $city_data = [
        'id' => $document['_id'],
        'city' => $document['city_name']
    ];
    $arr_of_obj[] = $city_data;
}

if(!empty($arr_of_obj))
{
    $response = [
        'status_code' => '200',
        'arr' => $arr_of_obj
    ];
}
else
{
    $response = [
        'status_code' => '404',
        'message' => 'No result found'
    ];
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>