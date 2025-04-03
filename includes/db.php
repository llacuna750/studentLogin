<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get Railway's auto-injected MySQL variables
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');

// SSL configuration for Railway
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "✅ Connected to Railway MySQL!";
    echo "<br>Host: $host";
    echo "<br>Database: $db";
    
    // Test query
    $stmt = $pdo->query("SELECT 1");
    echo "<br>Test query successful!";
    
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>