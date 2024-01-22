<?php

require 'partials/mongodbconnect.php';
require 'twillio/vendor/autoload.php';

$userCollection = $database->Users;

function sendOtp($no, $otp)
{

    $sid = "AC2014df18a9e354053a153ad15e381ff8";
    $token = "46a36c1aec1131c58532ebfaed55ecc9";
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
