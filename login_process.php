<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header("Content-Type: application/json");

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "phone_shop"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read raw JSON input
    $inputJSON = file_get_contents("php://input");
    error_log("Raw Input JSON: " . $inputJSON); // Log raw input

    $input = json_decode($inputJSON, true);
    error_log("Decoded JSON: " . print_r($input, true)); // Log decoded JSON

    // Validate input
    if (!$input || !isset($input['login_input']) || !isset($input['password'])) {
        echo json_encode(["success" => false, "message" => "Missing input fields"]);
        exit();
    }

    $login_input = $input['login_input'];
    $password = $input['password'];

    // Query the database
    $stmt = $conn->prepare("SELECT * FROM register WHERE Regis_Email = ? OR Regis_Username = ?");
    $stmt->bind_param("ss", $login_input, $login_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { 
        $user = $result->fetch_assoc();
        error_log("User found: " . print_r($user, true));

        // Plaintext password check
        if ($password === $user['Regis_Password']) { 
            $_SESSION['user_id'] = $user['Regis_ID']; 
            echo json_encode(["success" => true, "redirect" => "index.php?id=" . $user['Regis_ID']]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password"]);
        }
    } else { 
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
