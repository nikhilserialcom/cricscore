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


if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $profile = isset($_FILES['profile']) ? $_FILES['profile'] : null;
    $username = isset($_POST['userName']) ? $_POST['userName'] : '';
    $mobile_no = isset($_POST['mobileNumber']) ? $_POST['mobileNumber'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    foreach ($address as $key => $data) {
        if ($key == "country") {
            $country_name = $data['name'];
            $country_code = $data['phoneCode'];
        }
    }
    $role_arr = array($role);
    $final_number = '+' . $country_code . $mobile_no;

    $user_filter = ['mobileNumber' => $final_number];
    $check_user = $userCollection->findOne($user_filter);

    if ($check_user) {
        $response = array(
            'status_code' => "422",
            'message' => 'moible number already exist'
        );
    } else {
        $new_user = [
            'countryName' => $country_name,
            'mobileNumber' => $final_number,
            'address' => $address,
            'userName' => $username,
            'role' => $role_arr,
            'createAt' => date("Y-m-d H:i:s")
        ];
        if (!empty($profile['name'])) {
            $profileTmpName = $_FILES['profile']['tmp_name'];
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
            $response = array(
                'status_code' => "200",
                'message' => "new user created successfully"
            );
        } else {
            $response = array(
                'status_code' => "400",
                'message' => "something went to worng"
            );
        }
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
