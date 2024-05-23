<?php
// Include the file containing the database connection
include 'connection.php';
// Include the file containing the challenge details
include 'lab_details.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

setcookie("uuid", "your_uuid_value", time() + (86400 * 30), "/"); // 86400 = 1 day

// Function to send JSON response
function sendResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit; // Stop further execution
}

// Retrieve flag and challenge ID from POST and cookie respectively
$flag = isset($_POST['flag']) ? $_POST['flag'] : null;
$challengeId = isset($_COOKIE['challengeId']) ? $_COOKIE['challengeId'] : null;

// Check if flag is empty
if(!$flag){
    sendResponse(array("success" => false, "msg" => "Empty Flag Found"));
}

// // Check if UUID cookie is set
// if(!isset($_COOKIE['uuid'])){
//     sendResponse(array("success" => false, "msg" => "UUID Not Found"));
// }
$uuid = $_COOKIE['uuid'];

// Find index of challenge ID in array keys
$index = array_search($challengeId, array_keys($challenges));
if ($challengeId !== null && $flag !== null && $index !== false) {
    // Check if the flag matches the challenge flag
    if ($challenges[$challengeId]['flag'] == $flag) {
        // Determine the column name based on the index
        $column_name = $index == 0 ? 'challenge_id_1' : 'challenge_id_2'; 
        // Prepare SQL statement to update user table
        $sql = "UPDATE user SET $column_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // Check if statement preparation was successful
        if (!$stmt) {
            sendResponse(array("success" => false, "msg" => "Correct Flag But Error In Preparing DB Statement: " . $conn->error));
        } else {
            // Bind parameters and execute the statement
            $stmt->bind_param("ss", $challengeId, $uuid);
            if (!$stmt->execute()) {
                sendResponse(array("success" => false, "msg" => "Correct Flag But Unable To Update Reocrd: " . $stmt->error));
            } else {
                sendResponse(array("success" => true, "msg" => "Correct Flag!"));
            }
            // Close the statement
            $stmt->close();
        }
    } 
    sendResponse(array("success" => false, "msg" => 'Invalid flag'));
} else {
    sendResponse(array("success" => false, "msg" => 'Challenge Id Not Found'));
}
?>
