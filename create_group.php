<?php
session_start();

require 'partials/mongodbconnect.php';

use MongoDB\BSON\ObjectId;

$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173/',
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

function generateID()
{
    $uniqid = uniqid();

    $uniqid = substr($uniqid, 0, 8);
    $random = '';
    for ($i = 0; $i < 12; $i++) {
        $random .= dechex(mt_rand(0, 15));
    }
    $customID = $uniqid . $random;

    return $customID;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $torId = isset($data['torId']) ? new  ObjectId($data['torId']) : '';
    $group = isset($data['group']) ? $data['group'] : '';

    $filter = ['_id' => $torId];
    $findTor = $tournamentCollection->findOne($filter);

    if ($findTor) {
        if ($findTor['userId'] == $_SESSION['userId']) {
            if (isset($findTor['groups'])) {
                $group['id'] = generateID();
                $update_group = [
                    '$push' => [
                        'groups' => $group
                    ]
                ];
            } else {
                $group['id'] = generateID();
                $update_group = [
                    '$set' => [
                        'groups' => array($group)
                    ]
                ];
            }
            $update_data = $tournamentCollection->updateOne($filter, $update_group);
            $response = array(
                'status_code' => "200",
                'message' => "create group successfully"
            );
        } else {
            $response = array(
                'status_code' => "401",
                'message' => "This tournament does not allow you to add teams"
            );
        }
    } else {
        $response = array(
            'status_code' => '404',
            'message' => "Such a tournament does not exist."
        );
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
