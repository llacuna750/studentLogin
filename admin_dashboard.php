<?php
session_start();
require 'includes/db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

// Get all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .admin-menu { background: #f5f5f5; padding: 15px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="admin-menu">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</p>
        <a href="home.php">User View</a> | 
        <a href="logout.php">Logout</a>
    </div>

    <h3>Manage Users</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['firstName']) ?></td>
                <td><?= htmlspecialchars($user['lastName']) ?></td>
                <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="admin_edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
                    <a href="admin_delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php if (!$user['is_admin']): ?>
                        | <a href="admin_make_admin.php?id=<?= $user['id'] ?>">Make Admin</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>