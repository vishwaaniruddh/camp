<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

// Base query
$query = "SELECT * FROM camp_inventory WHERE 1=1";

// Add filters if any
if (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
    $product_name = mysqli_real_escape_string($con, $_GET['product_name']);
    $query .= " AND product_name LIKE '%$product_name%'";
}

if (isset($_GET['product_model']) && !empty($_GET['product_model'])) {
    $product_model = mysqli_real_escape_string($con, $_GET['product_model']);
    $query .= " AND product_model LIKE '%$product_model%'";
}

// Get total count for pagination
$totalQuery = "SELECT COUNT(*) as total FROM ($query) as total_table";
$totalResult = mysqli_query($con, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);

// Add pagination to the query
$query .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

// Execute the query
$result = mysqli_query($con, $query);

$inventory = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $inventory[] = $row;
    }
}

// Return the response
echo json_encode([
    'success' => true,
    'data' => $inventory,
    'pagination' => [
        'total_pages' => $totalPages,
        'current_page' => $page
    ]
]);

mysqli_close($con);
?>