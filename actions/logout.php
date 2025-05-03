<?php
include '../includes/session.php';
session_unset();
session_destroy();
header("Location: ../views/login.php");
?>