<?php
session_set_cookie_params([
    'lifetime' => 6 * 30 * 24 * 60 * 60, 
    'path' => '/', 
    'secure' => true, 
    'httponly' => true,
    'samesite' => 'None']);
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


$data = json_decode(file_get_contents('php://input'), true);


$mobile_number = isset($data['phoneNumber']) ? $data['phoneNumber'] : '';
$name = isset($data['name']) ? $data['name'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$address = isset($data['address']) ? $data['address'] : '';
$player_role = isset($data['role']) ? $data['role'] : '';
$batting_style = isset($data['battingStyle']) ? $data['battingStyle'] : '';
$bowling_style = isset($data['bowlingStyle']) ? $data['bowlingStyle'] : '';

// $response = [
//     'address_data' => $address['country']
// ];

$userFilter = ['mobileNumber' => $mobile_number];
$check_user = $userCollection->findOne($userFilter);

if ($check_user) {
    $updateData = [
        '$set' => [
            'userName' => $name,
            'userEmail' => $email,
            'address' => $address,
            'player_role' => $player_role,
            'batting_style' => $batting_style,
            'bowling_style' => $bowling_style

        ]
    ];

    $updateuserInfo = $userCollection->updateOne($userFilter, $updateData);
    if ($updateData) {
        if(!isset($_SESSION['userId'])){
            $_SESSION['userId'] = $check_user['_id'];
        }
        $response = [
            'status_code' => "200",
            'message' => 'Login Succesfully'
        ];
    } else {
        $response = [
            'status_code' => "400",
            'message' => 'sonthing went to worng'
        ];
    }
} else {
    $response = [
        'status_code' => "404",
        'message' => 'user not found'
    ];
}



echo json_encode($response, JSON_PRETTY_PRINT);
