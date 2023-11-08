<?php
require 'partials/mongodbconnect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("content-type: application/json");

$matchCollection = $database->matchs;

$data = json_decode(file_get_contents('php://input') ,true);

$team1 = $data['team1_name'];
$team2 = $data['team2_name'];
$matchStarttime = $data['startTime'];
$matchEndtime = $data['endTime'];
$location = $data['location']; 
$toss = $data['toss'];
$elected = $data['elected'];
$over = $data['no_of_over'];
$umpire = $data['umpire'];
$striker = $data['striker'];
$non_striker = $data['non_striker'];

// $response = array(
//     'team1_id' => $team1,
//     'team2_id' => $team2,
//     'start_time' => $matchStarttime,
//     'end_time' => $matchEndtime,
//     'location' => $location,
//     'toss' => $toss,
//     'elected' => $elected,
//     'total_over' => $over,
//     'Umpires' => $umpire,
//     'striker' => $striker,
//     'non_striker' => $non_striker
// );

$document = [
    'team1_id' => $team1,
    'team2_id' => $team2,
    'start_time' => $matchStarttime,
    'end_time' => $matchEndtime,
    'location' => $location,
    'toss' => $toss,
    'elected' => $elected,
    'total_over' => $over,
    'Umpires' => $umpire,
    'striker' => $striker,
    'non_striker' => $non_striker
];

$createMatch = $matchCollection->insertOne($document);

if($createMatch)
{
    $response = array(
        'status_code' => '200',
        'message' => 'Match Created Successfully'
    );
}
else
{
    $response = array(
        'status_code' => '400',
        'message' => 'somthing went Wrong'
    );
}

echo json_encode($response);
?>