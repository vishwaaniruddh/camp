<?php
require '../vendor/autoload.php'; // Adjust the path as needed
include('./config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="vendor_data.xlsx"');
header('Cache-Control: max-age=0');

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

$result = $conn->query($sql);

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Your Name')
    ->setLastModifiedBy('Your Name')
    ->setTitle('Vendor Data')
    ->setSubject('Vendor Data')
    ->setDescription('Exported vendor data.')
    ->setKeywords('vendor data export')
    ->setCategory('Export');

// Add header row
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Email');
$sheet->setCellValue('D1', 'Phone');
$sheet->setCellValue('E1', 'Address');
$sheet->setCellValue('F1', 'Status');
$sheet->setCellValue('G1', 'Created At');

// Populate the spreadsheet with data
if ($result->num_rows > 0) {
    $rowNumber = 2; // Start from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id']);
        $sheet->setCellValue('B' . $rowNumber, $row['name']);
        $sheet->setCellValue('C' . $rowNumber, $row['email']);
        $sheet->setCellValue('D' . $rowNumber, $row['phone']);
        $sheet->setCellValue('E' . $rowNumber, $row['address']);
        $sheet->setCellValue('F' . $rowNumber, $row['status']);
        $sheet->setCellValue('G' . $rowNumber, $row['created_at']);
        $rowNumber++;
    }
}

// Write the file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$conn->close();
?>