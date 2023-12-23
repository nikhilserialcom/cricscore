<?php
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();

if(!isset($_SESSION['userId']))
{
    $response = [
        'status_code' => 404,
        'email' => 'your session is expire'
    ];
}
else{
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

    $document = [
        'userId' => $userId->__tostring(),
    ];

    $createMatch = $matchCollection->insertOne($document);

    if($createMatch)
    {
        $response = [
            'status_code' => 200,
            'message' => 'match create successfully!'
        ];
    }
    else{
        $response = [
            'status_code' => 400,
            'message' => 'ERROR:' . mysqli_error($database),
        ];
    }

}
echo json_encode($response);
?>