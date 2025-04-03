<?php
// Database configuration - fetching from .env file with fallback values
$host = $_ENV['MYSQLHOST'] ?? 'shuttle.proxy.rlwy.net';      // .env: MYSQLHOST=localhost
$port = $_ENV['DB_PORT'] ?? '41167';            // .env: DB_PORT=3306
$db   = $_ENV['DB_NAME'] ?? 'student_system';   // .env: DB_NAME=student_system
$user = $_ENV['DB_USER'] ?? 'root';            // .env: DB_USER=root
$pass = $_ENV['DB_PASS'] ?? 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';                // .env: DB_PASS=
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';    // .env: DB_CHARSET=utf8mb4

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Uncomment below to verify connection is working
    // echo "Connected successfully to database: $db";
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>