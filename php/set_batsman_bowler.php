<?php

session_start();

require 'partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId as Object_id;

header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers:  X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept");
header("content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 404,
        'message' => 'your session is expire'
    ];
} else {
    $matchId = isset($data['matchId']) ? new Object_id($data['matchId']) : '';
    $striker = isset($data['striker']) ? $data['striker'] : '';
    $non_striker = isset($data['non_striker']) ? $data['non_striker'] : '';
    $bowler = isset($data['bowler']) ? $data['bowler'] : '';

    $filter_match = ['_id' => $matchId];
    $check_match = $matchCollection->findOne($filter_match);

    if ($check_match) {
        foreach($check_match['teamA'] as $batman)
        {
            if($batman['player_id'] == $striker)
            {
                $striker_batman = $batman;
            }
            elseif($batman['player_id'] == $non_striker)
            {
                $non_striker_batman = $batman;
            }
        }

        foreach($check_match['teamB'] as $player)
        {
            if($player['player_id'] == $bowler)
            {
                $playerFound = $player;
            }
        }

        $response = [
            'status_code' => '200',
            'striker' => $striker_batman,
            'non_striker' => $non_striker_batman,
            'bowler' => $playerFound
        ];
        $document = [
            '$set' => [
                'striker' => $striker,
                'non_striker' => $non_striker,
                'bowler' => $bowler
            ]
        ];

        // $update_match = $matchCollection->updateOne($filter_match,$document);

        // if($update_match->getModifiedCount() > 0) {
        //     $response = [
        //         'status_code' => '200',
        //         'message' => 'Set striker, non_striker and bowler'
        //     ];
        // }
        // else{
        //     $response = array(
        //         'status_code' => '422',
        //         'match' => 'network error'
        //     );
        // }

    } else {
        $response = [
            'status_code' => '404',
            'message' => "database empty"
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
