<?php

// 1. Correct-ana vendor path (config folder-la irunthu mela poga __DIR__ . '/../' correct thaan)
require_once __DIR__ . '/../vendor/autoload.php';

// 2. .env file root folder-la irukurathala __DIR__ . '/../' correct-a point pannum
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 3. Environment variables-a fetch pannuvom
$host = $_ENV['MYSQLHOST'] ?? 'localhost';
$user = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];
$database = $_ENV['MYSQLDATABASE'];
$port = $_ENV['MYSQLPORT'] ?? 3306;

// 4. Connect panra apo variables-a thaan pass pannanum, "DB_USERNAME" nu string kuduka koodathu
$conn = new mysqli($host, $user, $password, $database, $port);

// Connection error check
if ($conn->connect_error) {
    // API-ku JSON format-la error response anupuna nalla irukum
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode(["error" => "Connection Failed: " . $conn->connect_error]);
    exit();
}

// 5. Headers set panra edam (Keep this clean, no echo before headers)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");