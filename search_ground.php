<?php
require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.26:5173/',
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");
header("ngrok-skip-browser-warning: 1");

$search_input = isset($_GET['search_input']) ? $_GET['search_input'] : '';

$ground_filter = [
    '$or' => [
        ['name' => ['$regex' => ".*" . $search_input . ".*", '$options' => 'i']],
        ['address' => ['$regex' => ".*" . $search_input . ".*", '$options' => 'i']],
        ['city.name' => ['$regex' => ".*" . $search_input . ".*", '$options' => 'i']]
    ]
];

$options = [
    'limit' => 20
];

$find_ground = $groundCollection->find($ground_filter,$options);

$ground_arr = iterator_to_array($find_ground);
usort($ground_arr,function($a,$b) {
    return strcmp($a->name, $b->name);
});

if(!empty($ground_arr)){
    $response = array(
        'status_code' => "200",
        'ground_arr' => $ground_arr
    );
}
else{
    $response = array(
        'status_code' => "404",
        'ground_arr' =>"database empty"
    );
}

echo json_encode($response,JSON_PRETTY_PRINT)
?>