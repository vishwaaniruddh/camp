<?php
include('../config.php');

header('Content-Type: application/json');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

// Get filter parameters
$name = isset($_GET['name']) ? $_GET['name'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query with filters
$sql = "SELECT * FROM camp_customers WHERE 1=1";

if ($name !== '') {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($name) . "%'";
}
if ($status !== '') {
    $sql .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

$totalSql = "SELECT COUNT(*) as total FROM ($sql) as totalTable";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

$sql .= " order by id desc LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$banks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'customer' => $banks,
    'pagination' => [
        'total_pages' => $totalPages,
        'current_page' => $page
    ]
]);

$conn->close();
?>