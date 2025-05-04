<?php
include '../config/database.php';
include '../includes/session.php';

if ($_POST['CSRF_token'] !== $_SESSION['CSRF']) {
    die("CSRF token mismatch!");
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    header("Location: ../views/dashboard.php");
} else {
    die("Invalid login!");
}
?>