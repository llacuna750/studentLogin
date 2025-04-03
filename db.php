<?php
// Get values from Railway environment variables
$host = getenv('MYSQLHOST') ?: 'shuttle.proxy.rlwy.net';
$port = getenv('MYSQLPORT') ?: '41167';
$db   = getenv('MYSQLDATABASE') ?: 'student_system';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt'
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected successfully to Railway MySQL!";
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>