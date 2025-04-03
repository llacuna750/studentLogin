<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get values from environment variables
$host = getenv('DB_HOST') ?: 'shuttle.proxy.rlwy.net';
$port = getenv('DB_PORT') ?: 41167;
$db   = getenv('DB_NAME') ?: 'student_system';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';
$charset = getenv('DB_CHARSET') ?: 'utf8mb4';

// SSL configuration for Railway
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Test connection
    $pdo->query("SELECT 1");
    echo "✅ Successfully connected to Railway MySQL!";
    
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>