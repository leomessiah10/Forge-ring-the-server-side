<?php
// Include the connection.php file which contains the database connection details
include 'connection.php';

// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to send JSON response and exit script execution
function sendResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Function to generate a UUID (Universally Unique Identifier)
function generateUuid() {
    // Generate 16 bytes of random data
    $data = openssl_random_pseudo_bytes(16);

    // Set the version (4) and variant (2) bits
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Variant 2

    // Convert the binary data to a hexadecimal string
    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    return $uuid;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode JSON data from the request body
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if username, email, and password are set in the POST data
    if (isset($postData["username"], $postData["email"], $postData["password"])) {
        $username = $postData["username"];
        $email = $postData["email"];
        $password = $postData["password"];

        // Attempt to insert the user into the database
        $sql = "INSERT INTO user (name, email, password, id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            sendResponse(array("success" => false, "message" => "Error preparing statement: " . $conn->error));
        } else {
            // Generate a UUID for the user
            $uuid = generateUuid();

            // Bind parameters and execute the statement
            $stmt->bind_param("ssss", $username, $email, $password, $uuid);
            if (!$stmt->execute()) {
                // Check for duplicate entry error
                if ($stmt->errno == 1062) {
                    sendResponse(array("success" => false, "message" => "Duplicate email not allowed"));
                } else {
                    sendResponse(array("success" => false, "message" => "Unsuccessful insert: " . $stmt->error));
                }
            } else {
                // Start a new session
                session_start();
                
                // Set session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["uuid"] = $uuid;

                // Set a cookie for the UUID
                setcookie("uuid", $uuid, time() + (86400 * 1), "/");

                // Send success response
                sendResponse(array("success" => true, "message" => "New record inserted successfully"));
            }
            $stmt->close();
        }
    } else {
        sendResponse(array("success" => false, "message" => "Missing required data"));
    }
} else {
    sendResponse(array("success" => false, "message" => "Invalid request method"));
}
?>
