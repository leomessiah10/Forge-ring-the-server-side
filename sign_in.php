<?php
// Include the connection.php file which contains database connection details
include 'connection.php';

// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to send response in JSON format and exit
function sendResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data from the request body and decode it from JSON format
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if email and password are set in the POST data
    if (isset($postData["email"]) && isset($postData["password"])) {
        // Extract email and password from the POST data
        $email = $postData["email"];
        $password = $postData["password"];
        
        // Prepare SQL statement to select user data based on email
        $sql = "SELECT id, email, password FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            // If preparing the statement fails, send error response
            sendResponse(array("success" => false, "message" => "Error preparing statement: " . $conn->error));
        } else {
            // Bind email parameter to the prepared statement
            $stmt->bind_param("s", $email);
            // Execute the prepared statement
            if (!$stmt->execute()) {
                // If executing the statement fails, send error response
                sendResponse(array("success" => false, "message" => "Error executing statement: " . $stmt->error));
            }
            // Get the result set from the executed statement
            $result = $stmt->get_result();
            // Check if a single user with the provided email exists
            if ($result->num_rows == 1) {
                // Fetch the user data
                $row = $result->fetch_assoc();
                // Retrieve hashed password from the fetched user data
                $hashed_password = $row['password'];
                // Verify if the provided password matches the hashed password
                if ($password == $hashed_password) {
                    // If password is correct, start a new session
                    session_start();
                    // Set session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["email"] = $row['email'];
                    // Set a cookie with user ID for future requests
                    setcookie("uuid", $row['id'], time() + (86400 * 1), "/");
                    
                    // Send success response
                    sendResponse(array("success" => true, "message" => "Login successful"));
                } else {
                    // If password is incorrect, send error response
                    sendResponse(array("success" => false, "message" => "Invalid email or password"));
                }
            } else {
                // If no user found with the provided email, send error response
                sendResponse(array("success" => false, "message" => "User Not Found"));
            }
            // Close the prepared statement
            $stmt->close();
        }
    } else {
        // If email or password data is missing in the POST request, send error response
        sendResponse(array("success" => false, "message" => "Missing email or password data"));
    }
} else {
    // If request method is not POST, send error response
    sendResponse(array("success" => false, "message" => "Invalid request method"));
}
?>
