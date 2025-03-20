<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; // Default XAMPP password is empty
$database = "handphonestore"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

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
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $login_input, $login_input);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) { 
    $user = $result->fetch_assoc();
    error_log("User found: " . print_r($user, true));

    if ($password === $user['password']) { // Plain text comparison
        session_start();
        $_SESSION['user_id'] = $user['id']; 
        echo json_encode(["success" => true, "redirect" => "edit.php?id=" . $user['id']]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password"]);
    }
} else { 
    echo json_encode(["success" => false, "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
