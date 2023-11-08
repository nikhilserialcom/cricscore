<?php

require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$stateCollection = $database->states_name;

$data = json_decode(file_get_contents('php://input'),true);

$state_input = $data['state_input'];
$country_id = $data['country_id'];

// $response = array(
//     'state_input' => $state_input,
//     'country_id' => $country_id
// );

if ($state_input == '')
{
    $response = array(
        'state_code' => '404',
        'message' => 'Please enter 1 or more characters.'
    );
}

$stateFilter = [
    'country_id' => $country_id,
    'state_name' => ['$regex' => '.*' . $state_input . '.*','$options' => 'i']
];
$check_state = $stateCollection->find($stateFilter);

$arr_of_obj = [];

foreach($check_state as $document)
{
    $state_data = [
        'id' => $document['_id'],
        'state' => $document['state_name']
    ];

    $arr_of_obj[] = $state_data;
}

if(!empty($arr_of_obj))
{
    $response = array(
        'state_code' => '200',
        'arr' => $arr_of_obj
    );
}
else 
{
    $response = array(
        'state_code' => '404',
        'message' => 'No result found'
    );
}

echo json_encode($response);
?>