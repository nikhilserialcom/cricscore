<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['match_id'];

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$checkmatch = $matchCollection->findOne($matchFilter);

if($checkmatch)
{
    $response = [
        'status_code' => 200,
        'match' => $checkmatch
    ];
}
else
{
    $response = [
        'status_code' => 404,
        'message' => 'database empty'
    ];
}

echo json_encode($response);
?>