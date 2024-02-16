<?php

require 'partials/mongodbconnect.php';
$userCollection = $database->Users;

$deleteCountry = $userCollection->deleteMany([]);
$deleteCountry = $teamCollection->deleteMany([]);
$deleteCountry = $playerCollection->deleteMany([]);
$deleteCountry = $groundCollection->deleteMany([]);
// $deleteCountry = $userCollection->deleteMany([]);


if ($deleteCountry->getDeletedCount() > 0) {
    echo 'delete city name successfully';
}
else{
    echo 'Failed inserted data';
}
?>