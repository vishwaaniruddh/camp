<?php
include('../config.php');
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Something went wrong"];

$query = "SELECT 
            b.id, 
            b.boq_number, 
            c.name AS customer_name, 
            k.name AS bank_name, 
            b.created_at 
          FROM camp_boq_master b
          LEFT JOIN camp_customers c ON b.customer_id = c.id
          LEFT JOIN camp_banks k ON b.bank_id = k.id
          ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $query);

if ($result) {
    $boqs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response = ["status" => "success", "boqs" => $boqs];
} else {
    $response["message"] = "Database error: " . mysqli_error($conn);
}

echo json_encode($response);
?>
