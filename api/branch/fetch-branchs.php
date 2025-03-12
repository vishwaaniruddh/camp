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
$sql = "SELECT a.*,b.name as zone_name FROM camp_branchs a
INNER JOIN camp_zones b ON a.zone = b.id

WHERE 1=1";

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

$sql .= " order by a.name ASC LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$branchs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branchs[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'data' => $branchs,
    'pagination' => [
        'total_pages' => $totalPages,
        'current_page' => $page
    ]
]);

$conn->close();
?>