    <?php

    require '../partials/mongodbconnect.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("content-type: application/json");

    $data = json_decode(file_get_contents('php://input'), true);

    $matchId = isset($data['matchId']) ? new MongoDB\BSON\ObjectId($data['matchId']) : '';
    $matchType = isset($data['matchType']) ? $data['matchType'] : '';
    $total_over = isset($data['total_over']) ? $data['total_over'] : '';
    $city = isset($data['city']) ? $data['city'] : '';
    $ground = isset($data['ground']) ? $data['ground'] : '';
    $date_time = isset($data['dateTime']) ? $data['dateTime'] : '';
    $ballType = isset($data['ballType']) ? $data['ballType'] : '';
    $pitch_type = isset($data['pitch_type']) ? $data['pitch_type'] : '';
    $umpires = isset($data['umpires']) ? $data['umpires'] : '';
    $scorer = isset($data['scorer']) ? $data['scorer'] : '';
    $commemtator = isset($data['commentator']) ? $data['commentator'] : '';


    $match_fillter = ['_id' => $matchId];
    $matches = $matchCollection->findOne($match_fillter);

    if ($matches) {
        $document = [
            '$set' => [
                'match_type' => $matchType,
                'total_over' => $total_over,
                'city' => $city,
                'ground' => $ground,
                'dateTime' => $date_time,
                'ballType' => $ballType,
                'pitch_type' => $pitch_type,
                'umpires' => $umpires,
                'scorer' => $scorer,
                'commentator' => $commemtator,
            ]
        ];

        $update_match = $matchCollection->updateOne(['_id' => $matchId],$document);
        if($update_match->getModifiedCount() > 0)
        {
            $response = [
                'status_code' => '200',
                'message' => $matches
            ];
        }
        else{
            $response = [
                'status_code' => '400',
                'message' => 'match update failed'
            ];
        }

    } else {
        $response = [
            'status_code' => '404',
            'message' => 'database empty'
        ];
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
