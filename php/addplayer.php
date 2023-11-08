<?php

require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$playerCollection = $database->players;

$profile = $_FILES['playerProfile'];
$playerName = $_POST['playerName'];
$mobileNumber = $_POST['mobileNumber'];
$playerEmail = $_POST['playerEmail'];

$profileTmpName = $_FILES['playerProfile']['tmp_name'];
$profilenewPart = explode('.',$profile['name']);
$extension = end($profilenewPart);
$profileNewName = rand(111111111,999999999) . "." . $extension;
$profileDir = 'profile/players/';
$profilePath = $profileDir.$profileNewName;

// $response = array(
//     'status_code' => '200',
//     'profile' => $profile['name'],
//     'playerName' => $playerName,
//     'mobileNumber' => $mobileNumber,
//     'playerEmail' => $playerEmail
// );

$document = [
    'playerProfile' => $profilePath,
    'playerName' => $playerName,
    'mobileNumber' => $mobileNumber,
    'playerEmail' => $playerEmail,
    'teamId' => '652f7d3ae065cf214509e89a'
];

$playerInfo = $playerCollection->insertOne($document);

if($playerInfo->getInsertedCount() > 0)
{
    move_uploaded_file($profileTmpName,$profilePath);
    $response = [
        'status_code' => '200',
        'message' => 'player add successfully'
    ];
}
else
{
    $response = [
        'status_code' => '422',
        'message' => 'sonthing went worng'
    ];
}
echo json_encode($response);
?>