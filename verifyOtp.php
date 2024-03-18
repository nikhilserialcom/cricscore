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

$data = json_decode(file_get_contents('php://input'), true);

$mobile = isset($data['mobileNo']) ? $data['mobileNo'] : '';
$otp  = isset($data['userOtp']) ? $data['userOtp'] : '';

// $response = array(
//     'mobileNumber' => $mobile,
//     'otp' => $otp
// ); 

// echo json_encode($response,JSON_PRETTY_PRINT);

$mobileFilter = ['mobileNumber' => $mobile, 'verifyStatus' => "0"];
$check_number = $userCollection->findOne($mobileFilter);

if ($check_number) {
    if ($check_number['otp'] == $otp) {
        if(!empty($check_number['userEmail'])){
            $situation = "update";
            $_SESSION['userId'] = $check_number['_id'];
        }else{
            $situation = "pending";
        }
       
        $updateData = [
            '$set' => ['verifyStatus' => "1"]
        ];

        $updateOtpQuery = $userCollection->updateOne($mobileFilter, $updateData);
        $response = [
            'status_code' => "200",
            'situation' => $situation,
            'message' => 'opt verified successfully'
        ];
    } else {
        $response = [
            'status_code' => "400",
            'message' => 'your otp is not valid'
        ];
    }
} else {
    $response = [
        'status_code' => '404',
        'message' => 'No result found',
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
