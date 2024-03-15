<?php
function generateCustomID() {
    // Generate a unique identifier
    $uniqid = uniqid();

    // Remove the microseconds part and pad the result to 8 characters
    $uniqid = substr($uniqid, 0, 12);

    // Generate a random hexadecimal string of 3 characters
    $random = bin2hex(random_bytes(1));

    // Concatenate the unique id and random string
    $customID = $uniqid . $random;

    return $customID;
}

function generateID() {
    // Generate a unique identifier
    $uniqid = uniqid();

    // Remove the microseconds part and pad the result to 8 characters
    $uniqid = substr($uniqid, 0, 8);

    // Generate additional random hexadecimal characters
    $random = '';
    for ($i = 0; $i < 12; $i++) {
        $random .= dechex(mt_rand(0, 15));
    }

    // Concatenate the unique id and random string
    $customID = $uniqid . $random;

    return $customID;
}

// Example usage:
$customID = generateCustomID() . "<br>";
$userID = generateID();
echo $customID;
echo $userID;
?>
