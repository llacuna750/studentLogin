<?php
session_start();
require 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Only allow admin to delete other users
$userId = $_GET['id'];
if ($userId != $_SESSION['user_id'] && $_SESSION['username'] != 'admin') {
    header("Location: home.php");
    exit;
}

// Prevent admin from deleting themselves
if ($userId == $_SESSION['user_id'] && $_SESSION['username'] == 'admin') {
    header("Location: home.php?error=cannot_delete_admin");
    exit;
}

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$userId]);

header("Location: home.php");
exit;
?>