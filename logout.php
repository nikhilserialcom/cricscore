<?php

session_start();
require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173',
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

    // if ((empty($CookieInfo['domain'])) && (empty($CookieInfo['secure']))) {
    //     setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], '', $CookieInfo['secure'], 'None');
    // } elseif (empty($CookieInfo['secure'])) {
    //     setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure'], $CookieInfo['samesite']);
    // } else {
    //     setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure'], $CookieInfo['samesite']);
    // }

    $cookie =  setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure'], 'None');
    
    // if (empty($CookieInfo['secure'])) {
    //     setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure'], 'None');
    // } else {
    //     setcookie(session_name(), '', time() - 3600, $CookieInfo['path'], $CookieInfo['domain'], $CookieInfo['secure'], 'None');
    // }

    session_destroy();
    $response = [
        'status_code' => "200",
        'cookie_data' => $CookieInfo,
        'deletecookie' => $cookie,
        'message' => 'Logout successful! '
    ];
} else {
    $response = [
        'status_code' => "400",
        'message' => 'ERROR:'
    ];
}
echo json_encode($response, JSON_PRETTY_PRINT);
