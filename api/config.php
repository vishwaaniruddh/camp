<?php session_start();
date_default_timezone_set('Asia/Kolkata');

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