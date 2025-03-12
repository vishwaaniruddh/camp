<?php
include('../config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM camp_branchs WHERE id = $id");
    if ($result = mysqli_fetch_assoc($query)) {
        echo json_encode([
            "success" => true,
            "branch" => [
                "branch_id" => $result['id'],
                "name" => $result['name'],
                "email" => $result['email'],
                "phone" => $result['phone'],
                "address" => $result['address'],
                "status" => $result['status'],
                "gstin" => $result['gstin'],

            ],
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "branch not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
