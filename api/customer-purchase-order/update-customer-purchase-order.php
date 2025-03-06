<?php
header("Content-Type: application/json");
require_once("../config.php"); // Include your DB connection




$data = json_decode(file_get_contents('php://input'), true);


var_dump($data);