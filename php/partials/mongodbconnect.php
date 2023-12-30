<?php

require_once __DIR__ . '/../vendor/autoload.php';

$con = new MongoDB\Client('mongodb://localhost:27017');

$database = $con->crick_heros;
$countryNameCollection = $database->country_name_code;
$cityNameCollection = $database->city_name; 
$userCollection = $database->Users;
$teamCollection = $database->teams;
$stateCollection = $database->states_name;
$cityCollection = $database->city_name;
$matchCollection = $database->matchs;
$teamCollection = $database->teams;
$playerCollection = $database->players;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173/',
    'http://localhost:5174/',
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}

// if ($countryNameCollection) {
//     echo 'mongodb connetion is successfully done!';
// }
// else{
//     echo 'Failed connection!';
// }

?>