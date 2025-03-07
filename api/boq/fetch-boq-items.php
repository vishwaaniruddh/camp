<?php
include('../config.php');
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get JSON input
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!isset($inputData['boq_id']) || empty($inputData['boq_id'])) {
        $response["message"] = "BOQ ID is required";
        echo json_encode($response);
        exit;
    }

    $boq_id = intval($inputData['boq_id']);

    // Fetch BOQ Number
    $stmt = $conn->prepare("SELECT boq_number FROM camp_boq_master WHERE id = ?");
    $stmt->bind_param("i", $boq_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $boqData = $result->fetch_assoc();
        $boq_number = $boqData['boq_number'];

        // Fetch BOQ Items
        $stmt = $conn->prepare("SELECT id, spare_name, quantity FROM camp_boq_items WHERE boq_id = ?");
        $stmt->bind_param("i", $boq_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        $response = [
            "status" => "success",
            "boq_number" => $boq_number,
            "boq_id"=>$boq_id,
            "items" => $items
        ];
    } else {
        $response["message"] = "BOQ not found";
    }
}

echo json_encode($response);
?>
