<?php
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

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
        $_SESSION['userId'] = $check_number['_id'];
        $updateData = [
            '$set' => ['verifyStatus' => "1"]
        ];

        $updateOtpQuery = $userCollection->updateOne($mobileFilter, $updateData);
        $response = [
            'status_code' => "200",
            'userid' => $_SESSION['userId'],
            'message' => 'Login Succesfully'
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
