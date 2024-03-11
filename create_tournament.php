<?php
session_start();
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

function uploadFile($file,$folder)
{
    if (!empty($file['name'])) {
        $tmp = $file['tmp_name'];
        $new_part = explode('.', $file['name']);
        $extension = end($new_part);
        $name = rand(111111111, 999999999) . "." . $extension;
        $path = $folder . $name;
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        move_uploaded_file($tmp, $path);
        return $path;
    }
}

if (!isset($_SESSION['userId'])) {
    $response = [
        'status_code' => 400,
        'message' => 'your session is expire'
    ];
} else {
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $tournamentName = isset($_POST['name']) ? $_POST['name'] : ''; 
    $ground = isset($_POST['ground']) ? $_POST['ground'] : '';
    $city = isset($_POST['cityName']) ? $_POST['cityName'] : '';
    $organiserName = isset($_POST['organiserName']) ? $_POST['organiserName'] : '';
    $organiserNo = isset($_POST['organiserNo']) ? $_POST['organiserNo'] : '';
    $allowToContact = isset($_POST['allowToContact']) ? $_POST['allowToContact'] : '';
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
    $torCategory  = isset($_POST['torCategory']) ? $_POST['torCategory'] : '';
    $matchType = isset($_POST['matchType']) ? $_POST['matchType'] : '';
    $ballType = isset($_POST['ballType']) ? $_POST['ballType'] : '';
    $pitchType = isset($_POST['pitchType']) ? $_POST['pitchType'] : '';
    $tags = isset($_POST['tags']) ? $_POST['tags'] : '';
    $banner = isset($_FILES['banner']) ? $_FILES['banner'] : '';
    $logo = isset($_FILES['logo']) ? $_FILES['logo'] : '';

    $bannerPath = uploadFile($banner,"profile/tournament/banner/");
    $logoPath = uploadFile($logo,"profile/tournament/logo/");

    // $response = array(
    //     'userId' => $userId,
    //     'name' => $tournamentName,
    //     'banner' => $banner,
    //     'logo' => $logo,
    //     'organiserName' => $organiserName,
    //     'organiserNo' => $organiserNo,
    //     'ground' => $ground,
    //     'address' => $city,
    //     'allowToContant' => $allowToContact,
    //     'startDate' => $startDate,
    //     'endDate' => $endDate,
    //     'torCategory' => $torCategory,
    //     'matchType' => $matchType,
    //     'ballType' => $ballType,
    //     'pitchType' => $pitchType,
    //     'tags' => $tags,
    // );

    $torData = [
        'userId' => $userId,
        'name' => $tournamentName,
        'banner' => $bannerPath,
        'logo' => $logoPath,
        'organiserName' => $organiserName,
        'organiserNo' => $organiserNo,
        'ground' => $ground,
        'cityName' => $city,
        'allowToContant' => $allowToContact,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'torCategory' => $torCategory,
        'matchType' => $matchType,
        'ballType' => $ballType,
        'pitchType' => $pitchType,
        'tags' => $tags,
        'teams' => array(),
        'createdAt' => date("Y-m-d H:i:s")
    ];

    $createTournament = $tournamentCollection->insertOne($torData);

    if($createTournament){
        $response = array(
            'status_code' => "200",
            'message' => "tournament create successfully"
        );
    }
    else{
        $response = array(
            'status_code' => "500",
            'message' => "Failed to connect to server"
        );
    }

}

echo json_encode($response,JSON_PRETTY_PRINT);
