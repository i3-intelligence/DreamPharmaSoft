<?php
include 'includes/session.php'; // Session Starting file
if (!isset($_SESSION['CSRF'])) {
    $_SESSION['CSRF'] = bin2hex(random_bytes(32)); // Generate a new CSRF token if it doesn't exist


}
// print $_SESSION['CSRF'];

header("Location: views/login.php?notify=login");
exit();
?>