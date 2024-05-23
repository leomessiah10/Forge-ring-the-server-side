<?php
// Include file containing lab details
include 'lab_details.php';

// Check if 'id' parameter is set in the POST request
$id = isset($_POST['id']) ? $_POST['id'] : null;

// Check if 'id' parameter is not null and exists in the $challenges array
if ($id !== null && array_key_exists($id, $challenges)) {
    // Retrieve challenge data corresponding to the 'id' parameter
    $challengeData = $challenges[$id];
    // Set HTTP response code to 200 (OK)
    http_response_code(200); 
    // Encode challenge data as JSON and echo it
    echo json_encode($challengeData);
} else {
    // If 'id' parameter is not found or invalid, set HTTP response code to 404 (Not Found)
    http_response_code(404);
    // Encode error message as JSON and echo it
    echo json_encode(array('error' => 'Challenge not found'));
}
?>
