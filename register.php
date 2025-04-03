<?php
require 'includes/db.php';

// Define allowed admin registration key (store this securely in production)
define('ADMIN_REGISTRATION_KEY', 'your-secure-key-123');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $isAdmin = 0; // Default to regular user
    
    // Check for admin registration (only if special key is provided)
    if (isset($_POST['admin_key']) && $_POST['admin_key'] === ADMIN_REGISTRATION_KEY) {
        $isAdmin = 1;
    }

    // Validate inputs
    $errors = [];
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($_POST['password'])) $errors[] = "Password is required";
    if (strlen($_POST['password']) < 8) $errors[] = "Password must be at least 8 characters";
    
    // Check if username/email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Username or email already exists";
    }

    // Proceed if no errors
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users 
                              (username, email, password, firstName, lastName, is_admin) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $firstName, $lastName, $isAdmin]);
        
        header("Location: index.php?registered=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 0 auto; padding: 20px; }
        .error { color: red; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; }
        .admin-key { display: none; } /* Hidden by default */
    </style>
</head>
<body>
    <h2>Register</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password (min 8 characters)</label>
            <input type="password" name="password" required minlength="8">
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstName" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastName" required>
        </div>
        
        <!-- Admin registration (hidden by default) -->
        <div class="form-group admin-key" id="adminKeyGroup">
            <label>Admin Registration Key</label>
            <input type="password" name="admin_key" placeholder="Enter admin key">
        </div>
        
        <button type="submit">Register</button>
        <button type="button" onclick="toggleAdminKey()">Register as Admin</button>
    </form>
    
    <p>Already have an account? <a href="index.php">Login here</a></p>
    
    <script>
        function toggleAdminKey() {
            const group = document.getElementById('adminKeyGroup');
            group.style.display = group.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>