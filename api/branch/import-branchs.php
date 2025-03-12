<?php
require '../../branch/autoload.php'; // Adjust the path as needed
include('../config.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['importbranch']) && $_FILES['importbranch']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['importbranch']['tmp_name'];
        $fileName = $_FILES['importbranch']['name'];
        $fileSize = $_FILES['importbranch']['size'];
        $fileType = $_FILES['importbranch']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('xls', 'xlsx');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            try {
                $spreadsheet = IOFactory::load($fileTmpPath);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();

                // Skip the header row
                array_shift($data);

                $conn->begin_transaction();

                foreach ($data as $row) {
                    $name = $conn->real_escape_string($row[0]);
                    $email = $conn->real_escape_string($row[1]);
                    $phone = $conn->real_escape_string($row[2]);
                    $address = $conn->real_escape_string($row[3]);
                    $gstin = $conn->real_escape_string($row[4]);
                    $status = 'active';

                    $sql = "INSERT INTO camp_branchs (name, email, phone, address, status,gstin) VALUES ('$name', '$email', '$phone', '$address', '$status','$gstin')";
                    if (!$conn->query($sql)) {
                        throw new Exception("Database error: " . $conn->error);
                    }
                }

                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'branchs imported successfully']);
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file extension']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>