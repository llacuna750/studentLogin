<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables
require_once __DIR__ . '/vendor/autoload.php'; // If using vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get credentials
$host = $_ENV['MYSQLHOST'] ?? 'shuttle.proxy.rlwy.net';
$port = $_ENV['DB_PORT'] ?? 41167;
$db   = $_ENV['DB_NAME'] ?? 'railway';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

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
    
    echo "✅ Connected to Railway MySQL successfully!";
    echo "<br>Host: $host";
    echo "<br>Database: $db";
    
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>