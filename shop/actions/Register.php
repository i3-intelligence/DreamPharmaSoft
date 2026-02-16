<?php
include '../config/Database.php';
include '../includes/Session.php';

if ($_POST['CSRF_token'] !== $_SESSION['CSRF']) {
    die("CSRF token mismatch!");
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
try {
    $stmt->execute([':username' => $username, ':password' => $password]);
    header("Location: ../views/Login.php");
} catch (PDOException $e) {
    die("Username already exists!");
}
?>