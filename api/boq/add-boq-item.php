<?php
include('../config.php');
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (empty($inputData['boq_number']) || empty($inputData['item_name']) || empty($inputData['quantity'])) {
        $response["message"] = "All fields are required";
        echo json_encode($response);
        exit;
    }
    
    // $boqID = $inputData['boqID'];
    $boq_number = $inputData['boq_number'];
    $item_name = $inputData['item_name'];
    $quantity = intval($inputData['quantity']);

    $stmt = $conn->prepare("INSERT INTO camp_boq_items (boq_id, spare_name, quantity) VALUES ((SELECT id FROM camp_boq_master WHERE id = ?), ?, ?)");
    $stmt->bind_param("isi", $boq_number, $item_name, $quantity);
    
    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "Item added successfully"];
    } else {
        $response["message"] = "Failed to add item";
    }
}

echo json_encode($response);
?>
