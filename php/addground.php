<?php
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$groundCollection = $database->cricket_grounds;

$data = json_decode(file_get_contents('php://input'),true);

$groundName = $data['ground_name'];
$state = $data['state_name'];
$city = $data['city_name'];

$document = [
    'groundName' => $groundName,
    'stateName' => $state,
    'cityName' => $city
];

$addground = $groundCollection->insertOne($document);

if($addground->getInsertedCount() > 0)
{
    $response = array(
        'status_code' => '200',
        'message' => 'ground added successfully'
    );
}
else
{
    $response = array(
        'status_code' => '500',
        'message' => 'somthing went to worng'
    );
}

echo json_encode($response);
?>