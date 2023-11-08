<?php

require '../partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['matchId'];
$breakType = $data['breakType'];

// $response = array(
//     'status_code' => '200',
//     'matchId' => $matchId,
//     'match' => $breakType
// );

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$checkmatch = $matchCollection->findOne($matchFilter);

if($checkmatch)
{
    $document = [
        '$set' => [
            'match_break' => $breakType
        ]
    ];
    $updateMatch = $matchCollection->updateOne($matchFilter,$document);
    if($updateMatch->getModifiedCount() > 0)
    {
        $response = array(
            'status_code' => '200',
            'braek_status' => 'match break'
        );
    }
    else
    {
        $response = array(
            'status_code' => '422',
            'match' => 'network error'
        );
    }
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