<?php
include('../config.php');

header('Content-Type: application/json');

$product_id = $_POST['id'];
$name = $_POST['name'];
$sku = $_POST['sku'];
$category = $_POST['category'];
$selling_price = $_POST['selling_price'];
$purchase_price = $_POST['purchase_price'];
$quantity = $_POST['quantity'];
$units = $_POST['units'];
$discount_type = $_POST['discount_type'];
$barcode = $_POST['barcode'];
$alert_quantity = $_POST['alert_quantity'];
$tax = $_POST['tax'];
$description = $_POST['description'];
$created_by = 'current_user'; // Replace with actual user ID or name
$status = 'active'; // Default status

// Handle file upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/product/" . date("Y/m/d/");
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
} else {
    // Retain the existing image path if no new image is uploaded
    $sql = "SELECT image_path FROM camp_products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];
    }
    $stmt->close();
}

$sql = "UPDATE camp_products SET name = ?, sku = ?, category = ?, selling_price = ?, purchase_price = ?, quantity = ?, units = ?, discount_type = ?, barcode = ?, alert_quantity = ?, tax = ?, description = ?, image_path = ?, created_by = ?, status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssdisssisssssi", $name, $sku, $category, $selling_price, $purchase_price, $quantity, $units, $discount_type, $barcode, $alert_quantity, $tax, $description, $image_path, $created_by, $status, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product']);
}

$stmt->close();
$conn->close();
?>