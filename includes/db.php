<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Railway MySQL credentials (match Workbench)
$host = 'shuttle.proxy.rlwy.net'; // From Railway dashboard
$port = 41167;                    // From Railway
$db   = 'student_system';                // Default DB name (change if different)
$user = 'root';                   // From Railway variables
$pass = 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ'; // From Railway vault
$charset = 'utf8mb4';

// SSL configuration for Railway
$ssl_options = [
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
];

try {
    // Create PDO instance with SSL
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ] + $ssl_options;
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Test query
    $stmt = $pdo->query("SELECT 1");
    echo "✅ Connected to Railway MySQL!";
    
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>