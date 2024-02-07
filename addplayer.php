<?php
session_start();

require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.15:5173',
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


if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $profile = isset($_FILES['playerProfile']) ? $_FILES['playerProfile'] : null;
    $playerName = isset($_POST['playerName']) ? $_POST['playerName'] : '';
    $mobileNumber = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : '';
    // $playerEmail = isset($_POST['playerEmail']) ?  $_POST['playerEmail'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $teamId = isset($_POST['teamId']) ? $_POST['teamId'] : '';

    foreach ($address as $key => $data) {
        if ($key == "country") {
            $country_name = $data['name'];
            $country_code = $data['phoneCode'];
        }
    }

    // $response = [
    //     'status_code' => '422',
    //     'message' => $country_name . $country_code
    // ];

    $user_filter = ['mobileNumber' => $mobileNumber];
    $check_user = $userCollection->findOne($user_filter);

    if ($check_user) {
        $response = [
            'status_code' => '422',
            'message' => 'user already exist'
        ];
    } else {


        $new_user = [
            'country_name' => $country_name,
            'mobileNumber' => '+' . $country_code . $mobileNumber
        ];


        $create_user = $userCollection->insertOne($new_user);
        $playerInfo = $playerCollection->insertOne($document);

        if ($create_user->getInsertedCount() > 0) {
            $document = [
                'playerName' => $playerName,
                'mobileNumber' => $mobileNumber,
                'address' => $address,
                // 'playerEmail' => $playerEmail,
                'teamId' => $teamId
            ];

            if (!empty($profile)) {
                $profileTmpName = $_FILES['playerProfile']['tmp_name'];
                $profilenewPart = explode('.', $profile['name']);
                $extension = end($profilenewPart);
                $profileNewName = rand(111111111, 999999999) . "." . $extension;
                $profileDir = 'profile/players/';
                $profilePath = $profileDir . $profileNewName;
                $document['player_profile'] = $profilePath;
                move_uploaded_file($profileTmpName, $profilePath);
            }
            $response = [
                'status_code' => '200',
                'message' => 'player add successfully'
            ];
        } else {
            $response = [
                'status_code' => '422',
                'message' => 'sonthing went worng'
            ];
        }
    }
}

echo json_encode($response);