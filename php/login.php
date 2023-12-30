<?php

require 'partials/mongodbconnect.php';
require 'twillio/vendor/autoload.php';

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");


$userCollection = $database->Users;

function sendOtp($no, $otp)
{

    $sid = "AC2014df18a9e354053a153ad15e381ff8";
    $token = "8a43f60f838b3f64a27118c256159af0";
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
$otp = rand(1111, 9999);
// $response = array(
//     'countryName' => $country,
//     'mobileNumber' => $mobileNumber,
// );

// echo json_encode($response,JSON_PRETTY_PRINT);

$mobileFilter = ['mobileNumber' => $mobileNumber];
$check_mobileNumber = $userCollection->findOne($mobileFilter);

if ($check_mobileNumber) {

    $updateOtp = sendOtp($mobileNumber, $otp);
    if ($updateOtp == "true") {
        if ($check_mobileNumber['verifyStatus'] == "0") {
            $updateData = [
                '$set' => ['otp' => $otp]
            ];
            $situation = "pending";
        } else {
            $updateData = [
                '$set' => ['otp' => $otp, 'verifyStatus' => "0"]
            ];
            $situation = "update";
        }
        $updateOtpQuery = $userCollection->updateOne($mobileFilter, $updateData);
        if ($updateOtpQuery) {
            $response = [
                'status_code' => '200',
                'situation' => $situation,
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
    $insertOtp = sendOtp($mobileNumber, $otp);
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
                'situation' => 'insert',
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
