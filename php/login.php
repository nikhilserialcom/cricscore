<?php

require 'partials/mongodbconnect.php';
require 'twillio/vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

$userCollection = $database->Users;

function sendOtp($no,$otp)
{
   
    $sid = "AC9df1a8f5bea5649437e9a9ab191dbbdd";
    $token = "d9801bc63bc26de190877f3630684690";
    $client = new \Twilio\Rest\Client($sid,$token);

    $message = $client->messages->create(
        $no,
        [
            'from' => '+18155545270',
            'body' => "your otp is : " . $otp
        ]
    ); 
    
    if($message)
    {
        return true;
    }
    else
    {
        return false;
    }
    
}

$data = json_decode(file_get_contents('php://input'),true);

$country = $data['country'];
$mobileNumber = $data['mobileNumber'];
$otp = rand(1111,9999);
// $response = array(
//     'countryName' => $country,
//     'mobileNumber' => $mobileNumber,
// );

// echo json_encode($response,JSON_PRETTY_PRINT);

$mobileFilter = ['mobileNumber' => $mobileNumber];
$check_mobileNumber = $userCollection->findOne($mobileFilter);

if($check_mobileNumber) {
    
    $updateOtp = sendOtp($mobileNumber,$otp);
    if($updateOtp == "true")
    {
        $updateData = [
            '$set' => ['otp' => $otp,'verifyStatus' => "0"]
        ];
        $updateOtpQuery = $userCollection->updateOne($mobileFilter,$updateData);
        if($updateOtpQuery)
        {
            $response = [
                'status_code' => '200',
                'message' => 'otp has been send in your mobile number',
            ];
        } 
        
    }
    else
    {
        $response = [
            'status_code' => '422',
            'message' => 'otp has not been send in your mobile number',
        ];
    }
}
else {
    $insertOtp = sendOtp($mobileNumber,$otp);
    if($insertOtp == "true")
    {
        $userId = uniqid();
        $documents = [
            'userId' => $userId,
            'country_name' => $country,
            'mobileNumber' => $mobileNumber,
            'otp' => $otp, 
        ];

        $insertuserInfo = $userCollection->insertOne($documents);

        if ($insertuserInfo->getInsertedCount() > 0) {
            $_SESSION['user_mobile'] = $mobileNumber;
            $response = [
                'status_code' => '200',
                'message' => 'otp has been send in your mobile number',
            ];
        }
    }
    else
    {
        $response = [
            'status_code' => '422',
            'message' => 'otp has not been send in your mobile number',
        ];
    } 
    
}
echo json_encode($response, JSON_PRETTY_PRINT);
?>