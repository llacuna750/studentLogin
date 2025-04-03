<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Railway MySQL credentials (get these from your MySQL service variables)
$host = getenv('MYSQLHOST') ?: 'shuttle.proxy.rlwy.net'; // From MySQL service
$port = getenv('MYSQLPORT') ?: 41167;                    // From MySQL service
$db   = getenv('MYSQLDATABASE') ?: 'student_system';            // Default DB name
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';

// SSL configuration for Railway
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "✅ Connected to Railway MySQL!";
    echo "<br>MySQL Host: " . $host;
    echo "<br>Port: " . $port;
    
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>