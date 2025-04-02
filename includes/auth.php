<?php
// Authentication Functions

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirect to login if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit;
    }
}

/**
 * Check if current user is admin
 */
function isAdmin() {
    return isset($_SESSION['username']) && $_SESSION['username'] === 'admin';
}

/**
 * Redirect to home if user doesn't have admin privileges
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: ../home.php");
        exit;
    }
}

/**
 * Verify password strength
 */
function validatePassword($password) {
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number";
    }
    return true;
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>