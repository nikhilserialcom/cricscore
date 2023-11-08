<?php
session_start();
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$userCollection = $database->Users;

$data = json_decode(file_get_contents('php://input'),true);

$state = $data['statename'];
$city = $data['cityName'];
$name = $data['name'];
$email = $data['email'];
// $userId = $data['userId'];
$userId = $_SESSION['userId'];


// $response = array(
//     'state' => $state,
//     'cityName' => $city,
//     'userName' => $name,
//     'userEmail' => $email,
//     'userId' => $userId
// );

// echo json_encode($response,JSON_PRETTY_PRINT);

$userFilter = ['userId' => $userId];
$check_user = $userCollection->findOne($userFilter);

if($check_user) {
   $updateData = [
    '$set' => [
            'stateName' => $state,
            'cityName' => $city,
            'userName' => $name,
            'userEmail' => $email
        ]
    ];

   $updateuserInfo = $userCollection->updateOne($userFilter,$updateData);
   if($updateData)
   {
        $response = [
            'status_code' => "200",
            'message' => 'Login Succesfully'
        ];
   }
   else
   {
        $response = [
            'status_code' => "400",
            'message' => 'sonthing went to worng'
        ];
   }

}
else
{
    $response = [
        'status_code' => "404",
        'message' => 'user not found'
    ];

}

echo json_encode($response,JSON_PRETTY_PRINT);
?>