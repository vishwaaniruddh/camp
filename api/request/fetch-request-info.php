<?php
include('../config.php');

// header('Content-Type: application/json');

$id = $mis_id = $_REQUEST['request_id'];

// Optimized query with JOIN
$sql = "
    SELECT 
        mi.*, 
        mh.contact_person_name,
        mh.contact_person_mob,
        mh.delivery_address
    FROM material_inventory mi
    INNER JOIN mis_history mh ON mi.mis_id = mh.mis_id
    WHERE mi.mis_id = '$id'
    and 
    mh.type='material_requirement'
";


$result = mysqli_query($con, $sql);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        echo json_encode([
            "status" => "success",
            "message" => "Data fetched successfully",
            "request" => $data
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No data found"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Query failed: " . mysqli_error($con)
    ]);
}
?>
