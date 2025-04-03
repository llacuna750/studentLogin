<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get credentials from environment variables (Railway) or defaults
$host = getenv('DB_HOST') ?: 'shuttle.proxy.rlwy.net';
$port = getenv('DB_PORT') ?: 41167;
$db   = getenv('DB_NAME') ?: 'student_system';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';

try {
    // Test TCP connection first
    $socket = @fsockopen($host, $port, $errno, $errstr, 5);
    if (!$socket) die("❌ Network blocked: $errstr ($errno)");
    
    fclose($socket);
    echo "✅ Port $port is reachable\n";
    
    // Test MySQL credentials
    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt'
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ MySQL login successful!\n";
    echo "Server version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    
} catch (PDOException $e) {
    die("❌ MySQL error: " . $e->getMessage());
}
?>