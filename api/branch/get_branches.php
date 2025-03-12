<?php
include('../config.php');
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["zones"])) {
    $zoneIds = explode(",", $_GET["zones"]); // Get zone IDs from query string

    if (!empty($zoneIds)) {
        $placeholders = implode(',', array_fill(0, count($zoneIds), '?'));
        $sql = "SELECT id, name FROM camp_branchs WHERE zone IN ($placeholders) AND status = 'active'";
        $stmt = $conn->prepare($sql);

        // Bind parameters dynamically
        $stmt->bind_param(str_repeat('i', count($zoneIds)), ...$zoneIds);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $branches = [];
            while ($row = $result->fetch_assoc()) {
                $branches[] = $row;
            }

            $response = ["status" => "success", "branches" => $branches];
        } else {
            $response["message"] = "Failed to fetch branches";
        }
    } else {
        $response["message"] = "No valid zones selected";
    }
}

echo json_encode($response);
?>
