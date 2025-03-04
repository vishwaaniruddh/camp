<?php
include('../config.php');

header('Content-Type: application/json');



$product_id = $_POST['id'];
$name = $_POST['name'];

$category = $_POST['category'];
$purchase_price = $_POST['purchase_price'];
$quantity = $_POST['quantity'];
$units = $_POST['units'];
$alert_quantity = $_POST['alert_quantity'];
$description = $_POST['description'];
$serial_numbers = $_POST['serial_numbers'];
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

$sql = "UPDATE camp_products SET name = ?,  category = ?, purchase_price = ?, quantity = ?, units = ?,  alert_quantity = ?, description = ?, image_path = ?, created_by = ?, status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisssssss", $name,  $category, $purchase_price, $quantity, $units, $alert_quantity, $description, $image_path, $created_by, $status, $product_id);

if ($stmt->execute()) {
    // Fetch existing serial numbers
    $sql_fetch_serials = "SELECT id, serial_number FROM camp_product_serials WHERE product_id = ?";
    $stmt_fetch_serials = $conn->prepare($sql_fetch_serials);
    $stmt_fetch_serials->bind_param("i", $product_id);
    $stmt_fetch_serials->execute();
    $result_serials = $stmt_fetch_serials->get_result();

    $existing_serials = [];
    while ($row_serials = $result_serials->fetch_assoc()) {
        $existing_serials[$row_serials['id']] = $row_serials['serial_number'];
    }
    $stmt_fetch_serials->close();

    // Update or insert serial numbers
    foreach ($serial_numbers as $index => $serial_number) {
        if (isset($existing_serials[$index])) {
            // Update existing serial number
            $sql_update_serial = "UPDATE camp_product_serials SET serial_number = ? WHERE id = ?";
            $stmt_update_serial = $conn->prepare($sql_update_serial);
            $stmt_update_serial->bind_param("si", $serial_number, $index);
            $stmt_update_serial->execute();
            $stmt_update_serial->close();
        } else {
            // Insert new serial number
            $sql_insert_serial = "INSERT INTO camp_product_serials (product_id, serial_number) VALUES (?, ?)";
            $stmt_insert_serial = $conn->prepare($sql_insert_serial);
            $stmt_insert_serial->bind_param("is", $product_id, $serial_number);
            $stmt_insert_serial->execute();
            $stmt_insert_serial->close();
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product']);
}

$stmt->close();
$conn->close();
?>