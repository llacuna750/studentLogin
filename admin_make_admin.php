<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

$userId = $_GET['id'];
$stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
$stmt->execute([$userId]);

header("Location: admin_dashboard.php");
exit;
?>