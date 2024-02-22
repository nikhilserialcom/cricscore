<?php
session_start();

require 'partials/mongodbconnect.php';
$allowedOrigins = [
    'https://cricscorers-15aec.web.app',
    'http://localhost:5173',
    'http://localhost:5174',
    'http://192.168.1.23:5173',
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
    $teamId = isset($_POST['teamId']) ? new MongoDB\BSON\ObjectId($_POST['teamId']) : '';

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
    $final_number = '+' . $country_code . $mobileNumber;

    $user_filter = ['mobileNumber' => $final_number];
    $check_user = $userCollection->findOne($user_filter);

    if ($check_user) {
        $response = [
            'status_code' => '422',
            'message' => 'mobile number already exist'
        ];
    } else {

        $new_user = [
            'countryName' => $country_name,
            'mobileNumber' => '+' . $country_code . $mobileNumber,
            'address' => $address,
            'userName' => $playerName,
            'createdAt' => date("Y-m-d H:i:s")
        ];

      
        if (!empty($profile)) {
            $profileTmpName = $_FILES['playerProfile']['tmp_name'];
            $profilenewPart = explode('.', $profile['name']);
            $extension = end($profilenewPart);
            $profileNewName = rand(111111111, 999999999) . "." . $extension;
            $profileDir = 'profile/players/';
            $profilePath = $profileDir . $profileNewName;
            $new_user['userProfile'] = $profilePath;
            move_uploaded_file($profileTmpName, $profilePath);
        }

        $create_user = $userCollection->insertOne($new_user);

        if ($create_user->getInsertedCount() > 0) {
            $player_id = $create_user -> getInsertedId();
            
            $team_member = $teamCollection ->findOne(['_id' =>$teamId]);
            $document = [
                '$push' =>[ 'member' => $player_id->__toString()],
            ];

            $add_member = $teamCollection->updateOne(['_id' => $teamId],$document);
            if($add_member){
                $response = [
                    'status_code' => '200',
                    'message' => 'player add successfully'
                ];
            }
        } else {
            $response = [
                'status_code' => '400',
                'message' => 'somthing went worng'
            ];
        }
    }
}

echo json_encode($response);
