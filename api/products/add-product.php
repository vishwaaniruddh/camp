<?php
include('../config.php');

header('Content-Type: application/json');

$name = $_POST['name'];

$category = $_POST['category'];
$purchase_price = $_POST['purchase_price'];
$units = $_POST['units'];
$alert_quantity = $_POST['alert_quantity'];
$model = $_POST['model'];
$requires_serial_numbers = $_POST['requires_serial_numbers'];

$description = $_POST['description'];
$created_by = 'current_user'; // Replace with actual user ID or name

// Handle file upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../../uploads/product/" . date("Y/m/d/");
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
        exit;
    }
}


$query = "INSERT INTO camp_products 
    (name, model, category, purchase_price, requires_serial_numbers, units, alert_quantity, description, image_path, created_by) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param(
    $stmt,
    "sssdssisss",
    $name,
    $model,
    $category,
    $purchase_price,
    $requires_serial_numbers,
    $units,
    $alert_quantity,
    $description,
    $image_path,
    $created_by
);

if (mysqli_stmt_execute($stmt)) {
    http_response_code(200);

    echo json_encode(['status' => 200, 'success' => true, 'message' => 'Product added successfully']);

} else {
    http_response_code(500);
    echo json_encode(['status' => 500, 'success' => false, 'message' => 'Failed to add product']);
}

mysqli_stmt_close($stmt);

?>