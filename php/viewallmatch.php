<?php
session_start();
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");


if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400, 
        'email' => 'your session is expire'
    ];
} else {
    $all_matchs = $matchCollection->find();

    $matchs = iterator_to_array($all_matchs);

    if ($matchs) {
        $response = [
            'status_code' => 200,
            'matchs' => $matchs
        ];
    } else {
        $response = [
            'status_code' => "404",
            'message' => 'no record found'
        ];
    }
}

echo json_encode($response,JSON_PRETTY_PRINT);