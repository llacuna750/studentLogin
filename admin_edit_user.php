<?php
session_start();
require 'includes/db.php';

// Admin check
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

$userId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $isAdmin = isset($_POST['is_admin']) ? 1 : 0;
    
    $stmt = $pdo->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ?, is_admin = ? WHERE id = ?");
    $stmt->execute([$firstName, $lastName, $email, $isAdmin, $userId]);
    
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!-- Similar to update.php but with admin toggle -->
<form method="POST">
    <!-- Existing fields -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_admin" <?= $user['is_admin'] ? 'checked' : '' ?>>
            Administrator
        </label>
    </div>
    <!-- Rest of the form -->
</form>