<?php
$host = 'shuttle.proxy.rlwy.net';
$db   = 'student_system';
$user = 'root';
$pass = 'oYCEtxbowPQVorrpZukBtfryYPgPWMqZ';
$charset = 'utf8mb4';
$port = 41167;


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>