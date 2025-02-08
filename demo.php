<?php
include('./config.php');
require 'vendor/autoload.php'; // Load PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;


// Check if file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excel_file"])) {
    $file = $_FILES["excel_file"]["tmp_name"];

    // Verify file extension
    $allowed_extensions = ['xls', 'xlsx'];
    $file_ext = pathinfo($_FILES["excel_file"]["name"], PATHINFO_EXTENSION);
    if (!in_array($file_ext, $allowed_extensions)) {
        die("Invalid file format! Please upload an Excel file (.xls or .xlsx).");
    }

    try {
        // Load Excel file
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(); // Convert to array

        // Skip header (1st row)
        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];

            // Assigning Excel columns to variables
            $ATMID = $row[0] ?? ''; // Column A
            $AMOUNT = $row[1] ?? 0; // Column B
            $Payee_Type = $row[2] ?? ''; // Column C
            $BENE_NAME = $row[3] ?? ''; // Column D
            $BENE_BANK_NAME = $row[4] ?? ''; // Column E
            $BENE_ACC_No = $row[5] ?? ''; // Column F
            $IFSC_CODE = $row[6] ?? ''; // Column G
            $Requester = $row[7] ?? ''; // Column H
            $Request_Date = date('Y-m-d', strtotime($row[8] ?? '')); // Column I
            $Engineer_Vendor_Details = $row[9] ?? ''; // Column J
            $Work_Type = $row[10] ?? ''; // Column K
            $Distance = $row[11] ?? ''; // Column L
            $Source_of_traveling = $row[12] ?? ''; // Column M
            $Fund_Transfer_Status = $row[13] ?? ''; // Column N
            $Fund_Transfer_Date = date('Y-m-d', strtotime($row[14] ?? '')); // Column O
            $DESCRIPTION = $row[15] ?? ''; // Column P
            $REMARK = $row[16] ?? ''; // Column Q
            $Complete_Address = $row[17] ?? ''; // Column R
            $Work_Status = $row[18] ?? ''; // Column S

            // Prepare SQL statement
            $sql = "INSERT INTO fund_distribution (ATMID, AMOUNT, Payee_Type, BENE_NAME, BENE_BANK_NAME, BENE_ACC_No, IFSC_CODE, Requester, Request_Date, Engineer_Vendor_Details, Work_Type, Distance, Source_of_traveling, Fund_Transfer_Status, Fund_Transfer_Date, DESCRIPTION, REMARK, Complete_Address, Work_Status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $con->prepare($sql);
            $stmt->bind_param("sdsssssssssssssssss", $ATMID, $AMOUNT, $Payee_Type, $BENE_NAME, $BENE_BANK_NAME, $BENE_ACC_No, $IFSC_CODE, $Requester, $Request_Date, $Engineer_Vendor_Details, $Work_Type, $Distance, $Source_of_traveling, $Fund_Transfer_Status, $Fund_Transfer_Date, $DESCRIPTION, $REMARK, $Complete_Address, $Work_Status);
            $stmt->execute();
        }

        echo "<p style='color:green;'>✅ Data imported successfully!</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Error loading file: " . $e->getMessage() . "</p>";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
</head>
<body>
    <h2>Upload Excel File</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".xls,.xlsx" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
