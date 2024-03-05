<?php
require 'partials/mongodbconnect.php';

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

session_start();

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {

    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $ground_name = isset($_POST['name']) ? $_POST['name'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $map_url = isset($_POST['mapUrl']) ? $_POST['mapUrl'] : '';
    $profile = isset($_FILES['profile']) ? $_FILES['profile'] : '';
    $ground_address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $owner_number = isset($_POST['ownerNumber']) ? $_POST['ownerNumber'] : '';

    // $response = array(
    //     'status_code' => '200',
    //     'name' => $ground_name,
    //     'location' => $location,
    //     'gmapUrl' => $map_url,
    //     'address' => $ground_address,
    //     'profile' => $profile,
    //     'city' => $city,
    //     'ownerNumber' => $owner_number
    // );

    $ground_filter = ['name' => $ground_name];
    $check_ground = $groundCollection->findOne($ground_filter);
    if ($check_ground) {
        $response = array(
            'status_code' => '422',
            'message' => "this ground name already exist"
        );
    } else {
        $document = [
            'userId' => $userId,
            'name' => $ground_name,
            'location' => $location,
            'gmapUrl' => $map_url,
            'address' => $ground_address,
            'city' => $city,
            'ownerNumber' => $owner_number,
            'matchs' => 0,
            'createdAt' => date("Y-m-d H:i:s")
        ];

        if (!empty($profile)) {
            $tmp_name = $profile['tmp_name'];
            $new_part = explode('.', $profile['name']);
            $extension = end($new_part);
            $file_name = rand(111111111, 999999999) . "." . $extension;
            $profile_dir = 'profile/grounds/';
            $profile_path = $profile_dir . $file_name;

            if (!file_exists($profile_dir)) {
                mkdir($profile_dir, 0755, true);
            }
            move_uploaded_file($tmp_name, $profile_path);
            $document['profile'] = $profile_path;
        }

        $addground = $groundCollection->insertOne($document);

        if ($addground->getInsertedCount() > 0) {
            $insertedGround = $groundCollection->findOne(['_id' => $addground->getInsertedId()]);
            $response = array(
                'status_code' => '200',
                'ground' => $insertedGround,
                'message' => 'ground added successfully'
            );
        } else {
            $response = array(
                'status_code' => '500',
                'message' => 'somthing went to worng'
            );
        }
    }
}


echo json_encode($response);
