<?php
session_start();

require 'partials/mongodbconnect.php';

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");


if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

    $matchFilter = ['userId' => $userId->__tostring()];
    $checkMatch = $matchCollection->find($matchFilter);

    $matches = iterator_to_array($checkMatch);

    if ($matches) {
        $response = [
            'status_code' => 200,
            'matchs' => $matches
        ];
    } else {
        $response = [
            'status_code' => "404",
            'message' => 'no record found'
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
