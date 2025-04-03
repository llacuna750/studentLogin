<?php
$host = 'shuttle.proxy.rlwy.net'; // Try containers-xxx.railway.app if this fails
$db   = 'student_system';
$user = 'root';
$pass = 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';
$charset = 'utf8mb4';
$port = 41167;

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, // Try adding this if SSL fails
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected successfully!";
} catch (\PDOException $e) {
    // Get more detailed error information
    echo "Connection failed: " . $e->getMessage();
    echo "<br>Error Code: " . $e->getCode();
    echo "<br>DSN used: " . $dsn;
}
?>