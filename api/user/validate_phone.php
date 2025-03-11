<?php
require_once('../config.php'); // Include database connection

header("Content-Type: application/json");

// Check for connection errors
if ($con->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
$phone = isset($data['phone']) ? trim($data['phone']) : '';

if (empty($phone)) {
    echo json_encode(["success" => false, "message" => "phone is required"]);
    exit;
}

// Query to check if the phone exists
$stmt = $con->prepare("SELECT COUNT(*) AS count FROM camp_users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$con->close();

echo json_encode(["exists" => ($count > 0)]);
