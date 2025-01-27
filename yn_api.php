<?php
require 'vendor/autoload.php'; // Load PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// API URL
$apiUrl = 'https://srishringarr.com/yn/export_product_garmets.php?type=2';

// Fetch JSON data from API
$response = file_get_contents($apiUrl);

// Check if API call was successful
if ($response === FALSE) {
    die("Error: Unable to fetch data from API.");
}

// Decode JSON response
$data = json_decode($response, true);

// Check if JSON data is valid
if (!$data || !is_array($data)) {
    die("Error: Invalid JSON data.");
}

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$headers = ['pid', 'product_name', 'selling_price', 'actual_price', 'sku', 'deposit', 'qty','Descriptions'];
$sheet->fromArray($headers, null, 'A1');

// Add data rows
$row = 2; // Start from the second row
foreach ($data as $item) {
    $sheet->setCellValue("A$row", $item['pid']);
    $sheet->setCellValue("B$row", $item['product_name']);
    $sheet->setCellValue("C$row", $item['selling_price']);
    $sheet->setCellValue("D$row", $item['actual_price']);
    $sheet->setCellValue("E$row", $item['sku']);
    $sheet->setCellValue("F$row", $item['deposit']);
    $sheet->setCellValue("G$row", $item['qty']);
    $sheet->setCellValue("H$row", $item['product_desc']);
    $row++;
}

// Set auto column width
foreach (range('A', 'G') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Write to Excel file
$filename = 'products_export_garments.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Save the Excel file to the output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
