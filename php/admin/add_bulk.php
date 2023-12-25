<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

session_start();
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $players = $data['players'];
    $bulk_players = [];
    foreach($players as $player)
    {
        $playerName = isset($player['playerName']) ? $player['playerName'] : '';
        $mobileNumber = isset($player['mobileNumber']) ? $player['mobileNumber'] : '';
        $playerEmail = isset($player['playerEmail']) ?  $player['playerEmail'] : '';
        $teamId = isset($player['teamId']) ? $player['teamId'] : '';
    
        $bulk_players = [
            'playerProfile' => '',
            'playerName' => $playerName,
            'mobileNumber' => $mobileNumber,
            'playerEmail' => $playerEmail,
            'teamId' => $teamId
        ];
    }

    $bulk_player = $playerCollection->insertMany($bulk_players);

    if($bulk_player->getInsertedCount() > 0)
    {
        $response = [
            'status_code' => '200',
            'message' => 'player add successfully'
        ];
    }
    else
    {
        $response = [
            'status_code' => '400',
            'message' => 'Error inserting players: ' . $bulk_player->getWriteConcernError()
        ];
    }

}

echo json_encode($response, JSON_PRETTY_PRINT);
