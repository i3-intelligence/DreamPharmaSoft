<?php
include '../includes/session.php';
if (!isset($_SESSION['CSRF'])) {
    $_SESSION['CSRF'] = bin2hex(random_bytes(32)); // Generate a new CSRF token if it doesn't exist
}
header("Location: ../views/login.php");
exit();
?>