<?php
session_start();

require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173/',
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


if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

    $ground_filter = ['userId' => $userId];
    $find_ground = $groundCollection->find($ground_filter);

    $ground_arr = iterator_to_array($find_ground);

    if (!empty($ground_arr)) {
        $response = array(
            'status_code' => "200",
            'ground_arr' => $ground_arr
        );
    } else {
        $response = array(
            'status_code' => "404",
            'ground_arr' => $ground_arr
        );
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>