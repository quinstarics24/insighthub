<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_admin() {
    if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        header('Location: login.php');
        exit;
    }
}
?>
