<?php
session_start(); // Start the session

// Function to send JSON response
function sendResponse($responseData) {
    header('Content-Type: application/json');
    echo json_encode($responseData);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the challengeId from the cookie
    $challengeId = $_COOKIE["challengeId"];
    
    // If challengeId is present, set session variables
    if ($challengeId) {
        // Set session variables for challenge-specific keys
        $_SESSION[$challengeId.'-key'] = ['wiener', 'carlos'];
        
        // Set session variable for random IP range
        $_SESSION['ip_range'] = rand(1, 255);
        
        // Send success response
        sendResponse(array("success" => true));
    } else {
        // If challengeId is missing, send error response
        sendResponse(array("success" => false, "message" => "Missing 'id' parameter"));
    }
} else {
    // If request method is not POST, send error response
    sendResponse(array("success" => false, "message" => "Invalid request method"));
}
?>
