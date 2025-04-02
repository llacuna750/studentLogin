<?php
session_start();
require 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Only allow users to edit their own account unless admin
$userId = $_GET['id'] ?? $_SESSION['user_id'];
if ($userId != $_SESSION['user_id'] && $_SESSION['username'] != 'admin') {
    header("Location: home.php");
    exit;
}

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ? WHERE id = ?");
    $stmt->execute([$firstName, $lastName, $email, $userId]);
    
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; }
    </style>
</head>
<body>
    <h2>Update User</h2>
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']) ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastName" value="<?= htmlspecialchars($user['lastName']) ?>" required>
        </div>
        <button type="submit">Update</button>
        <a href="home.php">Cancel</a>
    </form>
</body>
</html>