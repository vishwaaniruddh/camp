<?php
// Include database configuration
include('./config.php');

// Set default response
$response = [
    'success' => false,
    'message' => '',
    'data' => [],
    'pagination' => [],
];

try {
    // Get page and limit from query parameters, with default values
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

    // Calculate the offset
    $offset = ($page - 1) * $limit;

    // Fetch total number of rows
    $totalQuery = "SELECT COUNT(*) AS total FROM camp_vendors where status='active'";
    $totalResult = $conn->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalRecords = (int)$totalRow['total'];

    // Fetch vendor data with limit and offset
    $query = "SELECT * FROM camp_vendors ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch data into an array
        $vendors = [];
        while ($row = $result->fetch_assoc()) {
            $vendors[] = $row;
        }

        // Calculate pagination details
        $totalPages = ceil($totalRecords / $limit);

        $response['success'] = true;
        $response['message'] = 'Vendors fetched successfully.';
        $response['data'] = $vendors;
        $response['pagination'] = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'limit' => $limit,
            'total_records' => $totalRecords,
        ];
    } else {
        $response['message'] = 'No vendors found.';
    }
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
