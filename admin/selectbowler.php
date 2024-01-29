<?php

require '../partials/mongodbconnect.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input'),true);

$matchId = $data['match_id'];
$bowlerId = $data['bowler_Id'];

// $response = array(
//     'status_code' => "200",
//     'bowlerID' => $bowlerId
//  );

$matchFilter = ['_id' => new MongoDB\BSON\ObjectId($matchId)];
$check_match = $matchCollection->findOne($matchFilter);

if ($check_match) {

    $updateBowler = [
        '$set' => [
            'bowler' => $bowlerId
        ]
    ];

    $updatePlayer = $matchCollection->updateOne($matchFilter,$updateBowler);
    if($updatePlayer)
    {
        $response = array(
            'status_code' => "200",
            'message' => 'bowler change successfully'
        );
    }
}
else
{
    $response = array(
        'status_code' => "400",
        'message' => "database empty" 
    );
}
 
echo json_encode($response);
?>