<?php
include('./config.php');

header('Content-Type: application/json');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Get filter parameters
$name = isset($_GET['name']) ? $_GET['name'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$gstin = isset($_GET['gstin']) ? $_GET['gstin'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query with filters
$sql = "SELECT * FROM camp_vendors WHERE 1=1";

if ($name !== '') {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($name) . "%'";
}
if ($phone !== '') {
    $sql .= " AND phone LIKE '%" . $conn->real_escape_string($phone) . "%'";
}
if ($email !== '') {
    $sql .= " AND email LIKE '%" . $conn->real_escape_string($email) . "%'";
}
if ($gstin !== '') {
    $sql .= " AND gstin LIKE '%" . $conn->real_escape_string($gstin) . "%'";
}
if ($status !== '') {
    $sql .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

$totalSql = "SELECT COUNT(*) as total FROM ($sql) as totalTable";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$vendors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vendors[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'data' => $vendors,
    'pagination' => [
        'total_pages' => $totalPages,
        'current_page' => $page
    ]
]);

$conn->close();
?>