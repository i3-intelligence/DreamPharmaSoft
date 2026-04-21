<?php
require_once('auth.php');
// remove all session variables
session_unset();
// destroy the session
session_destroy();
header("location: index.php?notify=logout");
?>