<?php
session_start();

require 'partials/mongodbconnect.php';

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");


$data = json_decode(file_get_contents('php://input'), true);


$mobile_number = isset($data['phoneNumber']) ? $data['phoneNumber'] : '';
$state = isset($data['stateName']) ? $data['stateName'] : '';
$city = isset($data['cityName']) ? $data['cityName'] : '';
$name = isset($data['name']) ? $data['name'] : '';
$email = isset($data['email']) ? $data['email'] : '';

// $response = array(
//     'userId' => $_SESSION['userId']
// );


$userFilter = ['mobileNumber' => $mobile_number];
$check_user = $userCollection->findOne($userFilter);

if ($check_user) {
    $updateData = [
        '$set' => [
            'stateName' => $state,
            'cityName' => $city,
            'userName' => $name,
            'userEmail' => $email
        ]
    ];

    $updateuserInfo = $userCollection->updateOne($userFilter, $updateData);
    if ($updateData) {
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
