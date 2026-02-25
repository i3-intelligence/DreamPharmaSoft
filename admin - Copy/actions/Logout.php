<?php
include '../includes/Session.php';
session_unset();
session_destroy();
header("Location: ../views/Login.php?notify=logout");
exit();
?>