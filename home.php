<?php
session_start();
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
requireLogin(); // This will redirect to login if not authenticated

// Include database connection
require 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch all users with error handling
try {
    $stmt = $pdo->query("SELECT id, username, email, firstName, lastName FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Ensure $users is always an array, even if empty
    if (!$users) {
        $users = [];
    }
} catch (PDOException $e) {
    // Log error and set empty array
    error_log("Database error: " . $e->getMessage());
    $users = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
    /* Base Styles */
    body {
        font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #f8fafc;
        color: #1e293b;
        line-height: 1.6;
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Styles */
    h2 {
        color: #1e40af;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3b82f6;
        display: inline-block;
    }

    h3 {
        color: #334155;
        font-size: 1.5rem;
        margin: 1.5rem 0 1rem;
    }

    /* Welcome Message */
    .welcome {
        float: right;
        background-color: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .welcome a {
        color: white;
        text-decoration: none;
        margin-left: 0.5rem;
        font-weight: 600;
        transition: opacity 0.2s;
    }

    .welcome a:hover {
        opacity: 0.9;
        text-decoration: underline;
    }

    /* Error Message */
    .error-message {
        background-color: #fee2e2;
        color: #b91c1c;
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        border: 1px solid #fca5a5;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        overflow: hidden;
        margin-top: 1rem;
    }

    th {
        background-color: #3b82f6;
        color: white;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* Action Links */
    .actions a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        transition: all 0.2s;
    }

    .actions a:first-child {
        color: #10b981;
    }

    .actions a:last-child {
        color: #ef4444;
    }

    .actions a:hover {
        color: white;
        background-color: #3b82f6;
    }

    .actions a:first-child:hover {
        background-color: #10b981;
    }

    .actions a:last-child:hover {
        background-color: #ef4444;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }
        
        .welcome {
            float: none;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
</head>
<body>
    <h2>User Management System</h2>
    <div class="welcome">
        Welcome, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?> | 
        <a href="logout.php">Logout</a>
    </div>
    
    <h3>All Users</h3>
    
    <?php if (empty($users)): ?>
        <div class="error-message">No users found in the database.</div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <!-- In the HTML table section -->
<tbody>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['firstName']) ?></td>
        <td><?= htmlspecialchars($user['lastName']) ?></td>
        <td class="actions">
            <?php if ($_SESSION['user_id'] == $user['id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])): ?>
                <a href="update.php?id=<?= $user['id'] ?>">Edit</a>
                <?php if ($_SESSION['user_id'] == $user['id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])): ?>
                    | <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <?php endif; ?>
            <?php else: ?>
                <span class="no-actions">No actions available</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</body>
</html>