<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM camp_vendors WHERE id = $id");
    if ($result = mysqli_fetch_assoc($query)) {
        echo json_encode([
            "success" => true,
            "vendor" => [
                "name" => $result['name'],
                "email" => $result['email'],
                "phone" => $result['phone'],
                "address" => $result['address'],
            ],
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Vendor not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
