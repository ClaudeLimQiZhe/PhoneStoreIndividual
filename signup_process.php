<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "handphonestore"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read JSON input
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);

    // Validate input
    if (!isset($input['username']) || !isset($input['email']) || !isset($input['password'])) {
        echo json_encode(["success" => false, "message" => "Missing input fields"]);
        exit();
    }

    $username = $input['username'];
    $email = $input['email'];
    $password = $input['password']; // ⚠️ Plain text password (not recommended)

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "User already exists"]);
        exit();
    }
    $stmt->close();

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Signup successful! You can now login."]);
    } else {
        echo json_encode(["success" => false, "message" => "Signup failed. Try again."]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
