<?php
header("Content-Type: application/json");

// Connect to the database
$conn = new mysqli("localhost", "root", "", "handphonestore");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Read incoming JSON
$data = json_decode(file_get_contents("php://input"), true);

$card_number = $conn->real_escape_string($data["card_number"]);
$cardholder_name = $conn->real_escape_string($data["cardholder_name"]);
$expiry_date = $conn->real_escape_string($data["expiry_date"]);
$cvv = $conn->real_escape_string($data["cvv"]);
$total_amount = floatval($data["total_amount"]);

// Verify card exists
$sql = "SELECT * FROM payment_cards WHERE card_number = '$card_number' 
        AND cardholder_name = '$cardholder_name' 
        AND expiry_date = '$expiry_date' 
        AND cvv = '$cvv'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $card = $result->fetch_assoc();
    if ($card["balance"] >= $total_amount) {
        $new_balance = $card["balance"] - $total_amount;
        $conn->query("UPDATE payment_cards SET balance = '$new_balance' WHERE card_number = '$card_number'");
        echo json_encode(["success" => true, "message" => "Payment successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Insufficient balance!"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid card details!"]);
}

$conn->close();
?>
