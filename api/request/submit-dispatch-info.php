<?php
header('Content-Type: application/json');

// Get raw JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Check received data
if (!$data) {
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit;
}

// Print received data for debugging
var_dump($data);

// Proceed with your logic here...
?>
