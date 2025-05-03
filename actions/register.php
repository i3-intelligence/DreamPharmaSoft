<?php
include '../config/database.php';
include '../includes/session.php';

if ($_POST['csrf_token'] !== $_SESSION['csrf']) {
    die("CSRF token mismatch!");
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
try {
    $stmt->execute([':username' => $username, ':password' => $password]);
    header("Location: ../views/login.php");
} catch (PDOException $e) {
    die("Username already exists!");
}
?>