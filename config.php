<?php session_start();
date_default_timezone_set('Asia/Kolkata');

error_reporting(0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



$host="localhost";
$user="u444388293_cncindia";
$pass="CNCIndia2024#";
$dbname="u444388293_cncindia";
$con = $conn = new mysqli($host, $user, $pass, $dbname);
// Check connection
if ($con->connect_error) {
    // die("Connection failed: " . $con->connect_error);
} else {
// echo "Connected succesfull";
   
}

$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");

$userid = 1;
$username = 'Aniruddh Vishwakarma';