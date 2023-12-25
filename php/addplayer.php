<?php

require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();


if (isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $profile = isset($_FILES['playerProfile']) ? $_FILES['playerProfile'] : null;
    $playerName = isset($_POST['playerName']) ? $_POST['playerName'] : '';
    $mobileNumber = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : '';
    $playerEmail = isset($_POST['playerEmail']) ?  $_POST['playerEmail'] : '';
    $teamId = isset($_POST['teamId']) ? $_POST['teamId'] : '';

    if (!empty($profile)) {
        $profileTmpName = $_FILES['playerProfile']['tmp_name'];
        $profilenewPart = explode('.', $profile['name']);
        $extension = end($profilenewPart);
        $profileNewName = rand(111111111, 999999999) . "." . $extension;
        $profileDir = 'profile/players/';
        $profilePath = $profileDir . $profileNewName;
    }

    $document = [
        'playerProfile' => isset($profilePath) ? $profilePath : '',
        'playerName' => $playerName,
        'mobileNumber' => $mobileNumber,
        'playerEmail' => $playerEmail,
        'teamId' => $teamId
    ];

    $playerInfo = $playerCollection->insertOne($document);

    if ($playerInfo->getInsertedCount() > 0) {
        move_uploaded_file($profileTmpName, $profilePath);
        $response = [
            'status_code' => '200',
            'message' => 'player add successfully'
        ];
    } else {
        $response = [
            'status_code' => '422',
            'message' => 'sonthing went worng'
        ];
    }
}

echo json_encode($response);
