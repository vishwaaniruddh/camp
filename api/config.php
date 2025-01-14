<?php session_start();
date_default_timezone_set('Asia/Kolkata');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$host="localhost";
$user="u444388293_cncindia";
$pass="CNCIndia2024#";
$dbname="u444388293_cncindia";
$con = $conn = new mysqli($host, $user, $pass, $dbname);
// Check connection
$datetime = date('Y-m-d H:i:s');
if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
// echo "Connected succesfull";
   
}

function logChange($conn, $tableName, $recordId, $previousState, $newState, $user, $actionType) {
    // Prepare JSON-encoded data, handling null values
    global $datetime; 
    $previousStateJson = $previousState ? json_encode($previousState, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
    $newStateJson = $newState ? json_encode($newState, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;

    // Use prepared statements to prevent SQL injection
    $logSql = "INSERT INTO camp_audit_log (table_name, record_id, previous_state, new_state, user, action_type,timestamp) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($logSql);

    if (!$stmt) {
        throw new mysqli_sql_exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param(
        "sisssss", 
        $tableName, 
        $recordId, 
        $previousStateJson, 
        $newStateJson, 
        $user, 
        $actionType,
        $datetime
    );

    // Execute and check for errors
    if (!$stmt->execute()) {
        throw new mysqli_sql_exception("Failed to execute statement: " . $stmt->error);
    }

    $stmt->close();
}
