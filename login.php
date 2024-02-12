<?php

require 'partials/mongodbconnect.php';
require 'twillio/vendor/autoload.php';
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

$userCollection = $database->Users;

function sendOtp($no, $otp)
{

    $sid = "AC2014df18a9e354053a153ad15e381ff8";
    $token = "63d9739d5d347456f4cf679ac960b548";
    $client = new \Twilio\Rest\Client($sid, $token);

    $message = $client->messages->create(
        $no,
        [
            'from' => '+12056971459',
            'body' => "your otp is : " . $otp
        ]
    );

    if ($message) {
        return true;
    } else {
        return false;
    }
}

$data = json_decode(file_get_contents('php://input'), true);

$country = $data['country'];
$mobileNumber = $data['mobileNumber'];
// $otp = rand(1111, 9999);
$otp = 1234;
// $response = array(
//     'countryName' => $country,
//     'mobileNumber' => $mobileNumber,
// );

// echo json_encode($response,JSON_PRETTY_PRINT);

$mobileFilter = ['mobileNumber' => $mobileNumber];
$check_mobileNumber = $userCollection->findOne($mobileFilter);

if ($check_mobileNumber) {

    // $updateOtp = sendOtp($mobileNumber, $otp);
    $updateOtp = "true";
    if ($updateOtp == "true") {
        $updateData = [
            '$set' => ['otp' => $otp, 'verifyStatus' => "0"]
        ];
        $updateOtpQuery = $userCollection->updateOne($mobileFilter, $updateData);
        if ($updateOtpQuery) {
            $response = [
                'status_code' => '200',
                'message' => 'otp has been send in your mobile number',
            ];
        }
    } else {
        $response = [
            'status_code' => '422',
            'message' => 'otp has not been send in your mobile number',
        ];
    }
} else {
    // $insertOtp = sendOtp($mobileNumber, $otp);
    $insertOtp = "true";
    if ($insertOtp == "true") {
        $documents = [
            'country_name' => $country,
            'mobileNumber' => $mobileNumber,
            'otp' => $otp,
            'verifyStatus' => "0"
        ];

        $insertuserInfo = $userCollection->insertOne($documents);

        if ($insertuserInfo->getInsertedCount() > 0) {
            $response = [
                'status_code' => '200',
                'message' => 'otp has been send in your mobile number',
            ];
        }
    } else {
        $response = [
            'status_code' => '422',
            'message' => 'otp has not been send in your mobile number',
        ];
    }
}
echo json_encode($response, JSON_PRETTY_PRINT);
