<?php
require('../fpdf/fpdf.php');
include('../config.php'); // Include your database configuration file

// Fetch the purchase order details
$po_id = isset($_GET['purchase-order']) ? $_GET['purchase-order'] : '';
if (!$po_id) {
    die("Error: Purchase order ID is required.");
}

$query = "SELECT * FROM camp_purchase_orders_new WHERE po_number = '" . mysqli_real_escape_string($con, $po_id) . "'";
$result = mysqli_query($con, $query);
$po = mysqli_fetch_assoc($result);

if (!$po) {
    die("Error: Purchase order not found.");
}
$poid = $po['po_id']; 

// Fetch the items
$query = "SELECT * FROM camp_po_items WHERE po_id = '" . mysqli_real_escape_string($con, $poid) . "'";
$result = mysqli_query($con, $query);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

// Create new PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Add company logo
$pdf->Image('../assets/img/boxed.png', 10, 10, 30); // Replace with the path to your logo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'CAMP', 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, 'Comfort Assets Management Program', 0, 1, 'C');

// Add a line break
$pdf->Ln(10);

// System-generated Receipt notice
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(0, 10, 'This is a system-generated Receipt.', 0, 1, 'C');

$pdf->Ln(10);

// Receipt Details
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Receipt Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Receipt Number:', 0, 0);
$pdf->Cell(0, 10, $po['po_number'], 0, 1);
$pdf->Cell(50, 10, 'Vendor:', 0, 0);
$pdf->Cell(0, 10, $po['vendor'], 0, 1);
$pdf->Cell(50, 10, 'Order Date:', 0, 0);
$pdf->Cell(0, 10, $po['order_date'], 0, 1);
$pdf->Cell(50, 10, 'Expected Delivery Date:', 0, 0);
$pdf->Cell(0, 10, $po['expected_delivery_date'], 0, 1);
$pdf->Cell(50, 10, 'Status:', 0, 0);
$pdf->Cell(0, 10, ucfirst($po['status']), 0, 1);
$pdf->Cell(50, 10, 'Total Amount:', 0, 0);
$pdf->Cell(0, 10,  number_format($po['total_amount'], 2), 0, 1);
$pdf->Cell(50, 10, 'Notes:', 0, 0);
$pdf->MultiCell(0, 10, $po['notes']);

// Add a line break
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 10, '#', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Product', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Model Name', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Quantity', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Unit Price', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Total', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$total_amount = 0;

// Items Table Rows
foreach ($items as $index => $item) {
    $row_fill = $index % 2 === 0 ? 240 : 255; // Alternate row shading
    $pdf->SetFillColor($row_fill, $row_fill, $row_fill);
    $total = $item['quantity'] * $item['unit_price'];
    $total_amount += $total;

    $pdf->Cell(10, 10, $index + 1, 1, 0, 'C', true);
    $pdf->Cell(40, 10, $item['product_name'], 1, 0, 'L', true);
    $pdf->Cell(40, 10, $item['model_name'], 1, 0, 'L', true);
    $pdf->Cell(25, 10, $item['quantity'], 1, 0, 'C', true);
    $pdf->Cell(25, 10,  number_format($item['unit_price'], 2), 1, 0, 'R', true);
    $pdf->Cell(25, 10,  number_format($total, 2), 1, 1, 'R', true);
}

// Add a line break
$pdf->Ln(10);

// Total Amount Summary
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Grand Total:', 0, 0, 'L');
$pdf->Cell(0, 10,  number_format($total_amount, 2), 0, 1, 'R');

// Add a line break
$pdf->Ln(10);

// Footer
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Thank you for your business!', 0, 1, 'C');

// Page Number
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');

// Output the PDF
$pdf->Output('I', 'receipt.pdf');
?>