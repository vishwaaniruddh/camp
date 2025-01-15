<?php
include('../config.php');

header('Content-Type: application/json');

$name = $_POST['name'];
$sku = $_POST['sku'];
$category = $_POST['category'];
$purchase_price = $_POST['purchase_price'];
$quantity = $_POST['quantity'];
$units = $_POST['units'];
$barcode = $_POST['barcode'];
$alert_quantity = $_POST['alert_quantity'];

$description = $_POST['description'];
$created_by = 'current_user'; // Replace with actual user ID or name
$status = 'active'; // Default status

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

$sql = "INSERT INTO camp_products (name, sku, category, purchase_price, quantity, units, barcode, alert_quantity, description, image_path, created_by, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdississss", $name, $sku, $category,  $purchase_price, $quantity, $units, $barcode, $alert_quantity,  $description, $image_path, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add product']);
}

$stmt->close();
$conn->close();
?>