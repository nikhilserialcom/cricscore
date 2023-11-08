<?php

require_once __DIR__ . '/../vendor/autoload.php';

$con = new MongoDB\Client('mongodb://localhost:27017');

$database = $con->crick_heros;
$countryNameCollection = $database->country_name_code;
$cityNameCollection = $database->city_name;

// if ($countryNameCollection) {
//     echo 'mongodb connetion is successfully done!';
// }
// else{
//     echo 'Failed connection!';
// }

?>