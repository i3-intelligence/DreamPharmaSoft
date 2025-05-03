<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /public/index.php");
    exit();
}
?>