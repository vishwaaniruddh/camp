<?php
require '../../branch/autoload.php'; // Adjust the path as needed
include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Set headers for CSV download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="CAMP_branch_DATA.csv"');
header('Cache-Control: max-age=0');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV column headers
fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Address', 'Status', 'Created At']);

// Get filter parameters
$name = isset($_GET['name']) ? $_GET['name'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$gstin = isset($_GET['gstin']) ? $_GET['gstin'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query with filters
$sql = "SELECT * FROM camp_branchs WHERE 1=1";

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

$result = $conn->query($sql);

// Write data rows to CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['address'],
            $row['status'],
            $row['created_at']
        ]);
    }
}

// Close the output stream
fclose($output);

// Close the database connection
$conn->close();
?>
