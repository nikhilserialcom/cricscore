<?php

require_once 'partials/mongodbconnect.php';

$stateCollection = $database->states_name;
$city_name = [
    "Alabama",
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Colorado",
    "Connecticut",
    "Delaware",
    "Florida",
    "Georgia",
    "Hawaii",
    "Idaho",
    "Illinois",
    "Indiana",
    "Iowa",
    "Kansas",
    "Kentucky",
    "Louisiana",
    "Maine",
    "Maryland",
    "Massachusetts",
    "Michigan",
    "Minnesota",
    "Mississippi",
    "Missouri",
    "Montana",
    "Nebraska",
    "Nevada",
    "New Hampshire",
    "New Jersey",
    "New Mexico",
    "New York",
    "North Carolina",
    "North Dakota",
    "Ohio",
    "Oklahoma",
    "Oregon",
    "Pennsylvania",
    "Rhode Island",
    "South Carolina",
    "South Dakota",
    "Tennessee",
    "Texas",
    "Utah",
    "Vermont",
    "Virginia",
    "Washington",
    "West Virginia",
    "Wisconsin",
    "Wyoming",
];

$documents = [];

// foreach($city_name as $name)
// {
//     $document = [
//         'city_name' => $name,
//         'state_id' => "652cc18fb92a34c08804e02f"
//     ];

//     $documents[] = $document;
// }

foreach($city_name as $name)
{
    $document = [
        'state_name' => $name,
        'country_id' => "652cc18fb92a34c08804e02f"
    ];

    $documents[] = $document;
}

$insertCountry = $stateCollection->insertMany($documents);

if ($insertCountry->getInsertedCount() > 0) {
    echo 'insert city name successfully';
}
else{
    echo 'Failed inserted data';
}

// $deleteCountry = $cityNameCollection->deleteMany([]);

// if ($deleteCountry->getDeletedCount() > 0) {
//     echo 'delete city name successfully';
// }
// else{
//     echo 'Failed inserted data';
// }

?>