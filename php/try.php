<?php
    // Get the data sent from JavaScript
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Get the search query from the data
    $searchQuery = $requestData['input'];

    // Process the data (you can perform a search or any other operation here)
    // For demonstration purposes, we'll just return the search query as the response
    $response = 'You are typing: ' . $searchQuery;

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode(['response' => $response]);
?>
