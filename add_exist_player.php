<?php
session_start();

require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.26:5173/',
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");
header("ngrok-skip-browser-warning: 1");

// $data = json_decode(file_get_contents('php://input'),true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => '400',
        'message' => 'your session is expire'
    ];
} else {
    $team_id = isset($_POST['team_id']) ? new MongoDB\BSON\ObjectId($_POST['team_id']) : '';
    $player_id = isset($_POST['player_id']) ? $_POST['player_id'] : '';

    // $response = array(
    //     'status_code' => '200',
    //     'team_id' => $team_id,
    //     'player_id' => $player_id
    // );

    $team_filter = ['_id' => $team_id];
    $team_find = $teamCollection->findOne($team_filter);

    if($team_find){
        // $response = [
        //     'status_code' => '200',
        //     'message' => $team_find
        // ];
        $document = [
            '$push' =>[ 'member' => $player_id],
        ];

        $add_member = $teamCollection->updateOne($team_filter,$document);
        if($add_member){
            $response = [
                'status_code' => '200',
                'message' => 'player add successfully'
            ];
        }
    }
    else{
        $response = array(
            'status_code' => '404',
            'message' => "team is not exist"
        );
    }
}

echo json_encode($response,JSON_PRETTY_PRINT);
?>