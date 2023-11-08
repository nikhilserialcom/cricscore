<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$playerCollection = $database->players;

$data = json_decode(file_get_contents('php://input'),true);

$teamId = $data['teamId'];

// $response = array(
//     'status_code' => 200, 
//     'matchId' => $matchId,
//     'teamId' => $teamId
// );

$playerFilter = ['teamId' => $teamId ];
$check_player = $playerCollection->find($playerFilter);

$playerData = iterator_to_array($check_player);

if(!empty($playerData))
{
    $response = array(
        'status_code' => 200,
        'player' => $playerData
    );
}
else
{
    $response = array(
        'status_code' => 404,
        'message' => 'database empty',
    );
}


echo json_encode($response);
?>