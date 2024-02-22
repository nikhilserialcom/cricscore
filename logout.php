<?php

session_start();
require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.23:5173',
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


if (isset($_SESSION['userId'])) {
    $CookieInfo = session_get_cookie_params();
    $arr_cookie_options = array (
        'expires' => 1,
        'path' => '/',
        'secure' => true,     
        'httponly' => true, 
        'samesite' => 'None' 
        );
    setcookie(session_name(), 'logout session', $arr_cookie_options);

    session_destroy();
    $response = [
        'status_code' => "200",
        'message' => 'Logout successful! '
    ];
} else {
    $response = [
        'status_code' => "400",
        'message' => 'ERROR:'
    ];
}
echo json_encode($response, JSON_PRETTY_PRINT);
