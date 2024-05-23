<?php
// Include lab_details.php to access the challenges array
include 'lab_details.php';

// Retrieve the challenge ID from the GET request parameters
$id = $_GET['id'] ?? null;

// Check if the ID exists and corresponds to a challenge
if ($id && array_key_exists($id, $challenges)) {
    // If the ID exists, encode the challenge data as JSON and output it
    echo json_encode($challenges[$id]);
} else {
    // If the ID is not found or invalid, return an error message as JSON
    echo json_encode(array('error' => 'Challenge not found'));
}
?>
