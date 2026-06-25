<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page
    header('Location: auth.php');
    exit;
}

// Check session timeout (optional: 24 hours)
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 86400)) {
    session_destroy();
    header('Location: auth.php?timeout=1');
    exit;
}

// Optional: Check user role
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    // If you want to restrict certain pages to admin only
    // header('Location: unauthorized.php');
    // exit;
}
?>