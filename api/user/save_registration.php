<?php
header("Content-Type: application/json");
require_once "../config.php"; // Database connection file

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// Validate required fields
if (!isset($data["full_name"], $data["email"], $data["phone"], $data["password"], $data["role"])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$full_name = trim($data["full_name"]);
$email = trim($data["email"]);
$phone = trim($data["phone"]);
$password = password_hash($data["password"], PASSWORD_BCRYPT);
$role = trim($data["role"]);

// Optional fields (bank details)
$bank_name = isset($data["bank_name"]) ? trim($data["bank_name"]) : null;
$account_number = isset($data["account_number"]) ? trim($data["account_number"]) : null;
$ifsc_code = isset($data["ifsc_code"]) ? trim($data["ifsc_code"]) : null;

// Check if email or phone already exists
$checkQuery = "SELECT id FROM camp_users_registration WHERE email = ? OR phone = ?";
$stmt = $con->prepare($checkQuery);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email or phone number already exists"]);
    $stmt->close();
    exit;
}
$stmt->close();

// Insert user data
$query = "INSERT INTO camp_users_registration (full_name, email, phone, password, role, bank_name, account_number, ifsc_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssssssss", $full_name, $email, $phone, $password, $role, $bank_name, $account_number, $ifsc_code);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id; // Get the newly inserted user ID
    echo json_encode(["success" => true, "message" => "User registered successfully", "user_id" => $user_id]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
